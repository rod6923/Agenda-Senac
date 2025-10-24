<?php
$page_title = 'Aprovação de Solicitações - Sistema de Agendamento SENAC';
$page_content = '
<header class="main-header">
    <h1>Aprovação de Solicitações</h1>
    <div class="header-controls">
        <div class="filter-tabs">
            <button class="filter-tab active">Todas</button>
            <button class="filter-tab">Pendentes</button>
            <button class="filter-tab">Aprovadas</button>
            <button class="filter-tab">Rejeitadas</button>
        </div>
        <div class="stats-summary">
            <span class="stat-item">
                <strong>5</strong> Pendentes
            </span>
            <span class="stat-item">
                <strong>12</strong> Aprovadas
            </span>
            <span class="stat-item">
                <strong>3</strong> Rejeitadas
            </span>
        </div>
    </div>
</header>

<!-- Lista de Solicitações para Aprovação -->
<div class="approval-requests-list">
    <!-- Solicitação Pendente para Aprovação -->
    <div class="approval-card status-pending">
        <div class="approval-header">
            <div class="requester-info">
                <div class="requester-avatar">
                    <img src="https://via.placeholder.com/50" alt="Avatar" class="avatar-img">
                    <div class="status-indicator online"></div>
                </div>
                <div class="requester-details">
                    <h3>Carlos Pereira</h3>
                    <p>carlos.pereira@senac.com</p>
                    <span class="requester-department">Departamento: TI</span>
                </div>
            </div>
            <div class="request-status">
                <span class="status-badge pending">Pendente</span>
                <span class="request-time">Há 2 horas</span>
            </div>
        </div>
        
        <div class="request-content">
            <div class="request-title">
                <h4>Workshop de Capacitação Técnica</h4>
                <p>Treinamento em novas tecnologias para a equipe de desenvolvimento</p>
            </div>
            
            <div class="request-details">
                <div class="detail-item">
                    <svg class="detail-icon" viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 20a2 2 0 002 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/></svg>
                    <span>15 de Maio de 2024</span>
                </div>
                <div class="detail-item">
                    <svg class="detail-icon" viewBox="0 0 24 24"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg>
                    <span>09:00 - 17:00 (Manhã e Tarde)</span>
                </div>
                <div class="detail-item">
                    <svg class="detail-icon" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    <span>Auditório Principal</span>
                </div>
                <div class="detail-item">
                    <svg class="detail-icon" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                    <span>20 participantes</span>
                </div>
            </div>
            
            <div class="request-justification">
                <h5>Justificativa:</h5>
                <p>Necessário para capacitar a equipe em novas tecnologias que serão implementadas nos próximos projetos. O workshop será ministrado por especialista externo e é fundamental para o desenvolvimento da equipe.</p>
            </div>
        </div>
        
        <div class="approval-actions">
            <button class="btn btn-primary" onclick="openApprovalModal(\'approve\', \'Carlos Pereira\', \'Workshop de Capacitação Técnica\')">Aprovar</button>
            <button class="btn btn-secondary" onclick="openApprovalModal(\'reject\', \'Carlos Pereira\', \'Workshop de Capacitação Técnica\')">Rejeitar</button>
            <button class="btn btn-outline">Ver Detalhes</button>
        </div>
    </div>
</div>

<!-- Modal de Aprovação/Rejeição -->
<div id="approvalModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTitle">Aprovar Solicitação</h3>
            <button class="modal-close" onclick="closeApprovalModal()">&times;</button>
        </div>
        <div class="modal-body">
            <div class="modal-info">
                <p><strong>Solicitante:</strong> <span id="modalRequester"></span></p>
                <p><strong>Evento:</strong> <span id="modalEvent"></span></p>
            </div>
            
            <div class="form-group">
                <label for="approvalReason">Motivo da decisão:</label>
                <textarea id="approvalReason" rows="4" placeholder="Explique o motivo da aprovação ou rejeição..."></textarea>
            </div>
            
            <div class="form-group">
                <label for="approvalNotes">Observações adicionais (opcional):</label>
                <textarea id="approvalNotes" rows="3" placeholder="Observações ou sugestões..."></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline" onclick="closeApprovalModal()">Cancelar</button>
            <button class="btn btn-primary" id="modalConfirmBtn" onclick="confirmApproval()">Confirmar</button>
        </div>
    </div>
</div>

<script>
function openApprovalModal(action, requester, event) {
    const modal = document.getElementById(\'approvalModal\');
    const title = document.getElementById(\'modalTitle\');
    const requesterSpan = document.getElementById(\'modalRequester\');
    const eventSpan = document.getElementById(\'modalEvent\');
    const confirmBtn = document.getElementById(\'modalConfirmBtn\');
    const reasonTextarea = document.getElementById(\'approvalReason\');
    
    requesterSpan.textContent = requester;
    eventSpan.textContent = event;
    
    if (action === \'approve\') {
        title.textContent = \'Aprovar Solicitação\';
        confirmBtn.textContent = \'Aprovar\';
        confirmBtn.className = \'btn btn-primary\';
        reasonTextarea.placeholder = \'Explique o motivo da aprovação...\';
    } else {
        title.textContent = \'Rejeitar Solicitação\';
        confirmBtn.textContent = \'Rejeitar\';
        confirmBtn.className = \'btn btn-danger\';
        reasonTextarea.placeholder = \'Explique o motivo da rejeição...\';
    }
    
    modal.style.display = \'block\';
}

function closeApprovalModal() {
    document.getElementById(\'approvalModal\').style.display = \'none\';
    document.getElementById(\'approvalReason\').value = \'\';
    document.getElementById(\'approvalNotes\').value = \'\';
}

function confirmApproval() {
    const reason = document.getElementById(\'approvalReason\').value;
    const notes = document.getElementById(\'approvalNotes\').value;
    
    if (!reason.trim()) {
        alert(\'Por favor, explique o motivo da decisão.\');
        return;
    }
    
    // Aqui você implementaria a lógica para salvar a decisão
    alert(\'Decisão registrada com sucesso!\');
    closeApprovalModal();
}

// Fechar modal ao clicar fora dele
window.onclick = function(event) {
    const modal = document.getElementById(\'approvalModal\');
    if (event.target === modal) {
        closeApprovalModal();
    }
}
</script>
';

include 'includes/layout-base.php';
?>
