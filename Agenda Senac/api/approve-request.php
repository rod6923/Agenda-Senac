<?php
require_once 'config/user-config.php';
requireManager();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$id = $input['id'] ?? null;
$action = $input['action'] ?? null;

if (!$id || !$action) {
    echo json_encode(['success' => false, 'message' => 'Parâmetros inválidos']);
    exit;
}

try {
    if ($action === 'approve') {
        // Aprovar solicitação - ativar usuário
        updateData('usuarios', [
            'status' => 'ativo',
            'ativo' => 1
        ], 'id = :id', ['id' => $id]);
        
        // Criar notificação para o usuário
        $usuario = fetchOne("SELECT * FROM usuarios WHERE id = :id", ['id' => $id]);
        if ($usuario) {
            insertData('notificacoes', [
                'usuario_id' => $id,
                'titulo' => 'Solicitação Aprovada',
                'mensagem' => 'Sua solicitação de acesso foi aprovada. Você já pode usar o sistema.',
                'tipo' => 'success'
            ]);
        }
        
        echo json_encode(['success' => true, 'message' => 'Solicitação aprovada com sucesso']);
        
    } elseif ($action === 'reject') {
        // Rejeitar solicitação
        updateData('usuarios', [
            'status' => 'inativo',
            'ativo' => 0
        ], 'id = :id', ['id' => $id]);
        
        // Criar notificação para o usuário
        $usuario = fetchOne("SELECT * FROM usuarios WHERE id = :id", ['id' => $id]);
        if ($usuario) {
            insertData('notificacoes', [
                'usuario_id' => $id,
                'titulo' => 'Solicitação Rejeitada',
                'mensagem' => 'Sua solicitação de acesso foi rejeitada. Entre em contato com o administrador para mais informações.',
                'tipo' => 'error'
            ]);
        }
        
        echo json_encode(['success' => true, 'message' => 'Solicitação rejeitada com sucesso']);
        
    } else {
        echo json_encode(['success' => false, 'message' => 'Ação inválida']);
    }
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
}
?>
