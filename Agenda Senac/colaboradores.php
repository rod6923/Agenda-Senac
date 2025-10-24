<?php
require_once 'config/user-config.php';
requireManager();

$page_title = 'Colaboradores - Sistema de Agendamento SENAC';

// Obter dados do banco
$solicitacoes_pendentes = getPendingRequests();
$colaboradores = getActiveCollaborators();

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
                <h1>Colaboradores</h1>
                <div class="header-controls">
                    <div class="search-box">
                        <svg class="search-icon" viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
                        <input type="text" placeholder="Buscar colaborador...">
                    </div>
                    <button class="btn btn-primary">Solicitações Pendentes (<?php echo count($solicitacoes_pendentes); ?>)</button>
                </div>
            </header>

            <!-- Seção de Solicitações Pendentes -->
            <?php if (!empty($solicitacoes_pendentes)): ?>
            <div class="pending-requests-section">
                <h2>Solicitações de Acesso Pendentes</h2>
                <div class="requests-list">
                    <?php foreach ($solicitacoes_pendentes as $solicitacao): ?>
                    <div class="request-card pending">
                        <div class="request-header">
                            <div class="request-info">
                                <h3><?php echo htmlspecialchars($solicitacao['nome']); ?></h3>
                                <p><?php echo htmlspecialchars($solicitacao['email']); ?></p>
                                <span class="request-meta">Matrícula: <?php echo htmlspecialchars($solicitacao['matricula']); ?> • Departamento: <?php echo htmlspecialchars($solicitacao['departamento']); ?></span>
                            </div>
                            <div class="request-status">
                                <span class="status-badge pending">Pendente</span>
                            </div>
                        </div>
                        <div class="request-details">
                            <p><strong>Justificativa:</strong> <?php echo htmlspecialchars($solicitacao['justificativa'] ?? 'Solicitação de acesso ao sistema'); ?></p>
                            <div class="request-meta-info">
                                <span>Solicitado em: <?php echo date('d/m/Y H:i', strtotime($solicitacao['created_at'])); ?></span>
                            </div>
                        </div>
                        <div class="request-actions">
                            <button class="btn btn-primary" onclick="aprovarSolicitacao(<?php echo $solicitacao['id']; ?>)">Aprovar</button>
                            <button class="btn btn-secondary" onclick="verDetalhes(<?php echo $solicitacao['id']; ?>)">Ver Detalhes</button>
                            <button class="btn btn-outline" onclick="rejeitarSolicitacao(<?php echo $solicitacao['id']; ?>)">Rejeitar</button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Lista de Colaboradores -->
            <div class="collaborators-grid">
                <?php foreach ($colaboradores as $colaborador): ?>
                <?php
                // Obter estatísticas do colaborador
                $reservas_colaborador = fetchData("SELECT COUNT(*) as total FROM reservas WHERE usuario_id = ?", [$colaborador['id']]);
                $total_reservas = $reservas_colaborador[0]['total'] ?? 0;
                ?>
                <div class="collaborator-card">
                    <div class="collaborator-avatar">
                        <img src="https://via.placeholder.com/60" alt="Avatar" class="avatar-img">
                    </div>
                    <div class="collaborator-info">
                        <h3><?php echo htmlspecialchars($colaborador['nome']); ?></h3>
                        <p class="collaborator-role"><?php echo htmlspecialchars($colaborador['departamento']); ?></p>
                        <p class="collaborator-email"><?php echo htmlspecialchars($colaborador['email']); ?></p>
                    </div>
                    <div class="collaborator-stats">
                        <div class="stat-item">
                            <span class="stat-number"><?php echo $total_reservas; ?></span>
                            <span class="stat-label">Reservas</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number"><?php echo $total_reservas; ?></span>
                            <span class="stat-label">Eventos</span>
                        </div>
                    </div>
                    <div class="collaborator-actions">
                        <a href="perfil-colaborador.php?id=<?php echo $colaborador['id']; ?>" class="btn btn-secondary">Ver Perfil</a>
                        <button class="btn btn-outline" onclick="editarColaborador(<?php echo $colaborador['id']; ?>)">Editar</button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>

    <script>
    function aprovarSolicitacao(id) {
        if (confirm('Deseja aprovar esta solicitação?')) {
            fetch('api/approve-request.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({id: id, action: 'approve'})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Erro: ' + data.message);
                }
            });
        }
    }

    function rejeitarSolicitacao(id) {
        if (confirm('Deseja rejeitar esta solicitação?')) {
            fetch('api/approve-request.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({id: id, action: 'reject'})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Erro: ' + data.message);
                }
            });
        }
    }

    function verDetalhes(id) {
        // Implementar modal de detalhes
        alert('Detalhes da solicitação ID: ' + id);
    }

    function editarColaborador(id) {
        // Implementar edição de colaborador
        alert('Editar colaborador ID: ' + id);
    }
    </script>
</body>
</html>
