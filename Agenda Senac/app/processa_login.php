<?php
session_start();
require 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha_post = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha_post, $usuario['senha'])) {
        if ($usuario['status'] == 'aprovado') {
            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['user_nome'] = $usuario['nome'];
            $_SESSION['user_cargo'] = $usuario['cargo'];
            
            // Redireciona TODOS para o mesmo dashboard
            header("Location: dashboard.php");
            exit;
        } else {
            echo "Seu cadastro ainda está pendente de aprovação.";
            echo '<br><a href="index.php">Voltar</a>';
        }
    } else {
        echo "Email ou senha inválidos.";
        echo '<br><a href="index.php">Voltar</a>';
    }
}
?>