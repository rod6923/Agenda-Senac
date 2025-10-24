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
    echo json_encode(['success' => false, 'message' => 'ID da reserva não fornecido']);
    exit;
}

try {
    $user = getCurrentUser();
    
    // Verificar se a reserva pertence ao usuário
    $reserva = fetchOne("SELECT * FROM reservas WHERE id = :id AND usuario_id = :user_id", [
        'id' => $id,
        'user_id' => $user['id']
    ]);
    
    if (!$reserva) {
        echo json_encode(['success' => false, 'message' => 'Reserva não encontrada ou não pertence ao usuário']);
        exit;
    }
    
    // Obter ID do status "Cancelada"
    $status_cancelada = fetchOne("SELECT id FROM status_reserva WHERE nome = 'Cancelada'");
    
    if (!$status_cancelada) {
        echo json_encode(['success' => false, 'message' => 'Status de cancelamento não encontrado']);
        exit;
    }
    
    // Atualizar status da reserva para cancelada
    updateData('reservas', [
        'status_id' => $status_cancelada['id']
    ], 'id = :id', ['id' => $id]);
    
    // Criar notificação para o gerente
    $gerentes = fetchData("SELECT id FROM usuarios WHERE tipo = 'gerente' AND ativo = 1");
    foreach ($gerentes as $gerente) {
        insertData('notificacoes', [
            'usuario_id' => $gerente['id'],
            'titulo' => 'Reserva Cancelada',
            'mensagem' => "A reserva '{$reserva['titulo']}' foi cancelada por {$user['nome']}.",
            'tipo' => 'warning'
        ]);
    }
    
    echo json_encode(['success' => true, 'message' => 'Reserva cancelada com sucesso']);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
}
?>
