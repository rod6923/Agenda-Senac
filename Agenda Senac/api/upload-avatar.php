<?php
require_once 'config/user-config.php';
requireLogin();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
    exit;
}

if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'message' => 'Erro no upload da imagem']);
    exit;
}

$user = getCurrentUser();
$file = $_FILES['avatar'];

// Validar tipo de arquivo
$allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
if (!in_array($file['type'], $allowed_types)) {
    echo json_encode(['success' => false, 'message' => 'Tipo de arquivo não permitido. Use JPG, PNG ou GIF.']);
    exit;
}

// Validar tamanho (máximo 2MB)
if ($file['size'] > 2 * 1024 * 1024) {
    echo json_encode(['success' => false, 'message' => 'Arquivo muito grande. Máximo 2MB.']);
    exit;
}

// Criar diretório de uploads se não existir
$upload_dir = 'uploads/avatars/';
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

// Gerar nome único para o arquivo
$extension = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename = 'avatar_' . $user['id'] . '_' . time() . '.' . $extension;
$filepath = $upload_dir . $filename;

// Mover arquivo
if (move_uploaded_file($file['tmp_name'], $filepath)) {
    // Atualizar banco de dados
    try {
        updateData('usuarios', [
            'avatar' => $filepath
        ], 'id = :id', ['id' => $user['id']]);
        
        echo json_encode([
            'success' => true, 
            'message' => 'Avatar atualizado com sucesso',
            'avatar_url' => $filepath
        ]);
    } catch (Exception $e) {
        // Remover arquivo se falhou ao salvar no banco
        unlink($filepath);
        echo json_encode(['success' => false, 'message' => 'Erro ao salvar no banco de dados']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao fazer upload do arquivo']);
}
?>
