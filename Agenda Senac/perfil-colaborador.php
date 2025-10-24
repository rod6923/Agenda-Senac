<?php
require_once 'config/user-config.php';
requireManager();

$page_title = 'Perfil do Colaborador - Sistema de Agendamento SENAC';
$colaborador_id = $_GET['id'] ?? null;

if (!$colaborador_id) {
    header('Location: colaboradores.php');
    exit;
}

$colaborador = fetchOne("SELECT * FROM usuarios WHERE id = :id", ['id' => $colaborador_id]);
if (!$colaborador) {
    header('Location: colaboradores.php');
    exit;
}

// Obter estatísticas do colaborador
$reservas_colaborador = fetchData("SELECT COUNT(*) as total FROM reservas WHERE usuario_id = ?", [$colaborador_id]);
$total_reservas = $reservas_colaborador[0]['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>

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
            <header class="main-header">
                <h1>Perfil do Colaborador</h1>
                <div class="header-controls">
                    <a href="colaboradores.php" class="btn btn-outline">Voltar</a>
                    <button class="btn btn-primary">Editar Perfil</button>
                </div>
            </header>

            <div class="profile-container">
                <!-- Breadcrumb -->
                <nav class="breadcrumb">
                    <a href="colaboradores.php">Colaboradores</a>
                    <span class="breadcrumb-separator">></span>
                    <span><?php echo htmlspecialchars($colaborador['nome']); ?></span>
                </nav>

                <!-- Informações do Colaborador -->
                <div class="profile-header">
                    <div class="profile-avatar">
                        <img src="https://via.placeholder.com/120" alt="Avatar" class="avatar-large">
                    </div>
                    <div class="profile-info">
                        <h2><?php echo htmlspecialchars($colaborador['nome']); ?></h2>
                        <p class="profile-role"><?php echo htmlspecialchars($colaborador['departamento'] ?? 'Colaborador'); ?></p>
                        <p class="profile-email"><?php echo htmlspecialchars($colaborador['email']); ?></p>
                        <div class="profile-meta">
                            <span class="meta-item">
                                <strong>Matrícula:</strong> <?php echo htmlspecialchars($colaborador['matricula'] ?? 'N/A'); ?>
                            </span>
                            <span class="meta-item">
                                <strong>Status:</strong> 
                                <span class="status-badge <?php echo $colaborador['ativo'] ? 'active' : 'inactive'; ?>">
                                    <?php echo $colaborador['ativo'] ? 'Ativo' : 'Inativo'; ?>
                                </span>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Estatísticas -->
                <div class="profile-stats">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <svg viewBox="0 0 24 24"><path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20a2 2 0 002 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10z"/></svg>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo $total_reservas; ?></h3>
                            <p>Reservas Realizadas</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo $total_reservas; ?></h3>
                            <p>Eventos Participados</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <svg viewBox="0 0 24 24"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg>
                        </div>
                        <div class="stat-content">
                            <h3>100%</h3>
                            <p>Taxa de Presença</p>
                        </div>
                    </div>
                </div>

                <!-- Informações Detalhadas -->
                <div class="profile-details">
                    <div class="detail-section">
                        <h3>Informações Pessoais</h3>
                        <div class="detail-grid">
                            <div class="detail-item">
                                <span class="detail-label">Nome Completo:</span>
                                <span class="detail-value"><?php echo htmlspecialchars($colaborador['nome']); ?></span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">E-mail:</span>
                                <span class="detail-value"><?php echo htmlspecialchars($colaborador['email']); ?></span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Matrícula:</span>
                                <span class="detail-value"><?php echo htmlspecialchars($colaborador['matricula'] ?? 'N/A'); ?></span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Departamento:</span>
                                <span class="detail-value"><?php echo htmlspecialchars($colaborador['departamento'] ?? 'N/A'); ?></span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Tipo de Usuário:</span>
                                <span class="detail-value"><?php echo ucfirst($colaborador['tipo']); ?></span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Data de Cadastro:</span>
                                <span class="detail-value"><?php echo date('d/m/Y', strtotime($colaborador['created_at'])); ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Atividades Recentes -->
                <div class="profile-activities">
                    <h3>Atividades Recentes</h3>
                    <div class="activity-list">
                        <div class="activity-item">
                            <div class="activity-icon">
                                <svg viewBox="0 0 24 24"><path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20a2 2 0 002 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10z"/></svg>
                            </div>
                            <div class="activity-content">
                                <p><strong>Nova Reserva:</strong> Auditório Principal para reunião de equipe</p>
                                <span class="activity-time">Há 2 horas</span>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon">
                                <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            </div>
                            <div class="activity-content">
                                <p><strong>Evento Confirmado:</strong> Workshop de Inovação</p>
                                <span class="activity-time">Ontem</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>