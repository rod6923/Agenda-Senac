<?php
require_once 'config/user-config.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Sistema de Agendamento SENAC'; ?></title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS Específico da Agenda -->
    <link rel="stylesheet" href="css/agenda.css">
</head>
<body>
    <div class="dashboard-layout">
        <?php include getSidebarPath(); ?>
        
        <!-- CONTEÚDO PRINCIPAL -->
        <main class="main-content">
            <?php if (isset($page_content)): ?>
                <?php echo $page_content; ?>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>
