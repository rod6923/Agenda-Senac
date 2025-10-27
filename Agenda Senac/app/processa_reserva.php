<?php
session_start();
require 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    die("Acesso negado.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_usuario = $_SESSION['user_id'];
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $urgencia = $_POST['urgencia']; // Captura o novo campo
    $data_evento = $_POST['data_evento'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fim = $_POST['hora_fim'];

    if ($hora_fim <= $hora_inicio) {
        die("Erro: A hora de fim deve ser posterior à hora de início. <a href='solicitar_reserva.php'>Tente novamente</a>.");
    }

    $data_inicio = $data_evento . ' ' . $hora_inicio . ':00:00';
    $data_fim = $data_evento . ' ' . $hora_fim . ':00:00';

    // Atualiza a query SQL para incluir o campo 'urgencia'
    $sql = "INSERT INTO reservas (id_usuario, titulo, descricao, urgencia, data_inicio, data_fim, status) VALUES (?, ?, ?, ?, ?, ?, 'pendente')";
    $stmt = $pdo->prepare($sql);
    
    // Adiciona a variável $urgencia ao array de execução
    if ($stmt->execute([$id_usuario, $titulo, $descricao, $urgencia, $data_inicio, $data_fim])) {
        $id_nova_reserva = $pdo->lastInsertId();
        $nome_solicitante = $_SESSION['user_nome'];

        $sql_gerentes = "SELECT id FROM usuarios WHERE cargo = 'gerente'";
        foreach ($pdo->query($sql_gerentes) as $gerente) {
            $id_gerente = $gerente['id'];
            $mensagem = "Nova reserva solicitada por " . htmlspecialchars($nome_solicitante);
            $sql_notificacao = "INSERT INTO notificacoes (id_usuario_destino, tipo, id_referencia, mensagem) VALUES (?, 'nova_reserva', ?, ?)";
            $pdo->prepare($sql_notificacao)->execute([$id_gerente, $id_nova_reserva, $mensagem]);
        }
        
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Erro ao enviar solicitação.";
    }
}
?>