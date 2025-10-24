<?php
require_once 'config/user-config.php';
requireLogin();

$page_title = 'Minhas Reservas - Sistema de Agendamento SENAC';

// Obter reservas do usuário logado
$user = getCurrentUser();
$reservas = getUserReservations($user['id']);

$page_content = '
<header class="main-header">
    <h1>Minhas Reservas</h1>
    <div class="header-controls">
        <div class="filter-tabs">
            <button class="filter-tab active">Todas</button>
            <button class="filter-tab">Confirmadas</button>
            <button class="filter-tab">Pendentes</button>
            <button class="filter-tab">Canceladas</button>
        </div>
        <button class="btn btn-primary">Nova Reserva</button>
    </div>
</header>

<!-- Lista de Reservas -->
<div class="requests-list">
    <?php if (empty($reservas)): ?>
    <div class="empty-state">
        <h3>Nenhuma reserva encontrada</h3>
        <p>Você ainda não possui reservas cadastradas.</p>
        <button class="btn btn-primary">Nova Reserva</button>
    </div>
    <?php else: ?>
        <?php foreach ($reservas as $reserva): ?>
        <div class="request-card status-<?php echo strtolower($reserva['status_nome']); ?>">
            <div class="request-header">
                <div class="request-info">
                    <h3><?php echo htmlspecialchars($reserva['titulo']); ?></h3>
                    <p><?php echo htmlspecialchars($reserva['descricao']); ?></p>
                </div>
                <div class="request-status">
                    <span class="status-badge <?php echo strtolower($reserva['status_nome']); ?>"><?php echo htmlspecialchars($reserva['status_nome']); ?></span>
                </div>
            </div>
            <div class="request-details">
                <div class="detail-item">
                    <svg class="detail-icon" viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 20a2 2 0 002 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/></svg>
                    <span><?php echo date('d/m/Y', strtotime($reserva['data_inicio'])); ?></span>
                </div>
                <div class="detail-item">
                    <svg class="detail-icon" viewBox="0 0 24 24"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg>
                    <span><?php echo date('H:i', strtotime($reserva['data_inicio'])); ?> - <?php echo date('H:i', strtotime($reserva['data_fim'])); ?></span>
                </div>
                <div class="detail-item">
                    <svg class="detail-icon" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    <span><?php echo htmlspecialchars($reserva['auditorio_nome']); ?></span>
                </div>
                <div class="detail-item">
                    <svg class="detail-icon" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                    <span><?php echo $reserva['participantes']; ?> participantes</span>
                </div>
            </div>
            <?php if ($reserva['justificativa']): ?>
            <div class="request-details">
                <div class="justification">
                    <strong>Justificativa:</strong> <?php echo htmlspecialchars($reserva['justificativa']); ?>
                </div>
            </div>
            <?php endif; ?>
            <div class="request-actions">
                <button class="btn btn-secondary" onclick="verDetalhes(<?php echo $reserva['id']; ?>)">Ver Detalhes</button>
                <?php if (strtolower($reserva['status_nome']) === 'pendente' || strtolower($reserva['status_nome']) === 'aprovada'): ?>
                <button class="btn btn-outline" onclick="cancelarReserva(<?php echo $reserva['id']; ?>)">Cancelar</button>
                <?php endif; ?>
                <?php if (strtolower($reserva['status_nome']) === 'rejeitada'): ?>
                <button class="btn btn-primary" onclick="novaReserva()">Nova Solicitação</button>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
function verDetalhes(id) {
    // Implementar modal de detalhes
    alert('Detalhes da reserva ID: ' + id);
}

function cancelarReserva(id) {
    if (confirm('Deseja cancelar esta reserva?')) {
        fetch('api/cancel-reservation.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({id: id})
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

function novaReserva() {
    // Implementar formulário de nova reserva
    alert('Formulário de nova reserva');
}
</script>
';

include 'includes/layout-base.php';
?>
