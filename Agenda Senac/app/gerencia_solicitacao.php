<?php
session_start();
require 'config/db.php';

// Apenas gerentes podem acessar este script
if (!isset($_SESSION['user_id']) || $_SESSION['user_cargo'] != 'gerente') {
    die("Acesso negado.");
}

$acao = $_GET['acao'] ?? '';
$id = $_GET['id'] ?? 0;

// Aprovar usuário
if ($acao == 'aprovar_user' && $id > 0) {
    $sql = "UPDATE usuarios SET status = 'aprovado' WHERE id = ?";
    $pdo->prepare($sql)->execute([$id]);
}

// Negar (e excluir) usuário
if ($acao == 'negar_user' && $id > 0) {
    $sql = "DELETE FROM usuarios WHERE id = ?";
    $pdo->prepare($sql)->execute([$id]);
}

// Aprovar reserva
if ($acao == 'aprovar_reserva' && $id > 0) {
    $sql = "UPDATE reservas SET status = 'aprovada' WHERE id = ?";
    $pdo->prepare($sql)->execute([$id]);
}

// Negar reserva
if ($acao == 'negar_reserva' && $id > 0 && isset($_POST['motivo'])) {
    $motivo = $_POST['motivo'];
    $sql = "UPDATE reservas SET status = 'negada', motivo_negacao = ? WHERE id = ?";
    $pdo->prepare($sql)->execute([$motivo, $id]);
}

// Redireciona de volta para o painel administrativo
header("Location: admin_panel.php");
exit();
?>