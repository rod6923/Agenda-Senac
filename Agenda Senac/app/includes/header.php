<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
require 'config/db.php';

$stmt_user = $pdo->prepare("SELECT nome, foto_perfil FROM usuarios WHERE id = ?");
$stmt_user->execute([$_SESSION['user_id']]);
$usuario_logado = $stmt_user->fetch(PDO::FETCH_ASSOC);

$foto_perfil = (!empty($usuario_logado['foto_perfil']) && file_exists($usuario_logado['foto_perfil'])) 
               ? $usuario_logado['foto_perfil'] 
               : 'public/img/default.jpg';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- A tag <title> será definida em cada página individual -->
    
    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome (para Ícones) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- O CSS da Aplicação -->
    <link rel="stylesheet" href="public/css/app-style.css">
   
</head>
<body>
    <div class="cursor"></div>

    <div class="blob-container">
        <svg viewBox="0 0 1000 1000" xmlns="http://www.w3.org/2000/svg">
            <path id="blob1" d="M826.5,583Q753,666,667,737.5Q581,809,494.5,850Q408,891,326,846.5Q244,802,168,740Q92,678,74.5,589Q57,500,81,417.5Q105,335,152.5,267.5Q200,200,285.5,153.5Q371,107,460.5,91.5Q550,76,630.5,123.5Q711,171,780,235.5Q849,300,865.5,400Q882,500,826.5,583Z" />
            <path id="blob2" d="M834.5,588.5Q771,677,677,735Q583,793,491.5,833Q400,873,316,833.5Q232,794,153.5,733Q75,672,85,586Q95,500,94,411.5Q93,323,150,265Q207,207,294,166.5Q381,126,470.5,115Q560,104,642,148.5Q724,193,786.5,260Q849,327,865.5,413.5Q882,500,834.5,588.5Z" />
        </svg>
    </div>

    <header class="app-header">
        <nav class="app-nav">
            <a href="dashboard.php" class="logo">Senac <strong>Reservas</strong></a>
            <div class="user-menu">
                <a href="solicitar_reserva.php">Solicitar Reserva</a>
                <?php if ($_SESSION['user_cargo'] == 'gerente'): ?>
                    <a href="admin_panel.php">Painel Admin</a>
                <?php endif; ?>
                <a href="logout.php">Sair</a>
                <!-- **** CLASSE ADICIONADA **** -->
                <a href="meu_perfil.php" class="profile-link">
                    <img src="<?php echo $foto_perfil; ?>" alt="Foto de Perfil">
                </a>
            </div>
        </nav>
    </header>

    <main class="main-content">