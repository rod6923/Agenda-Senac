<?php
session_start();
require 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    die("Acesso negado.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_usuario = $_SESSION['user_id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    $params = [$nome, $email];
    $sql = "UPDATE usuarios SET nome = ?, email = ?";

    // Lógica para atualizar a senha (se uma nova foi digitada)
    if (!empty($_POST['senha'])) {
        $senha_hash = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $sql .= ", senha = ?";
        $params[] = $senha_hash;
    }

    // Lógica para upload da foto
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $uploadDir = 'public/uploads/';
        // Garante um nome de arquivo único para evitar conflitos
        $fileName = $id_usuario . '_' . time() . '_' . basename($_FILES['foto']['name']);
        $uploadPath = $uploadDir . $fileName;

        // Move o arquivo para a pasta de uploads
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $uploadPath)) {
            $sql .= ", foto_perfil = ?";
            $params[] = $uploadPath;
        }
    }

    $sql .= " WHERE id = ?";
    $params[] = $id_usuario;

    $stmt = $pdo->prepare($sql);
    if ($stmt->execute($params)) {
        // Atualiza o nome na sessão, caso tenha sido alterado
        $_SESSION['user_nome'] = $nome;
        header("Location: meu_perfil.php?sucesso=1");
    } else {
        header("Location: meu_perfil.php?erro=1");
    }
    exit;
}
?>