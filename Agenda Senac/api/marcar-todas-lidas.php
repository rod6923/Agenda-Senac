<?php
require_once 'config/user-config.php';
requireLogin();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
    exit;
}

try {
    $user = getCurrentUser();
    
    // Marcar todas as notificações do usuário como lidas
    updateData('notificacoes', [
        'lida' => 1
    ], 'usuario_id = :user_id AND lida = 0', ['user_id' => $user['id']]);
    
    echo json_encode(['success' => true, 'message' => 'Todas as notificações foram marcadas como lidas']);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
}
?>
