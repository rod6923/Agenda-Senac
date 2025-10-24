<?php
require_once 'config/user-config.php';
requireLogin();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$id = $input['id'] ?? null;

if (!$id) {
    echo json_encode(['success' => false, 'message' => 'ID da notificação não fornecido']);
    exit;
}

try {
    $user = getCurrentUser();
    
    // Verificar se a notificação pertence ao usuário
    $notificacao = fetchOne("SELECT * FROM notificacoes WHERE id = :id AND usuario_id = :user_id", [
        'id' => $id,
        'user_id' => $user['id']
    ]);
    
    if (!$notificacao) {
        echo json_encode(['success' => false, 'message' => 'Notificação não encontrada ou não pertence ao usuário']);
        exit;
    }
    
    // Marcar como lida
    updateData('notificacoes', [
        'lida' => 1
    ], 'id = :id', ['id' => $id]);
    
    echo json_encode(['success' => true, 'message' => 'Notificação marcada como lida']);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
}
?>
