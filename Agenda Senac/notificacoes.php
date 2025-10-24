<?php
$page_title = 'Notificações - Sistema de Agendamento SENAC';
$page_content = '
<header class="main-header">
    <h1>Notificações</h1>
    <div class="header-controls">
        <button class="btn btn-outline">Marcar Todas como Lidas</button>
        <button class="btn btn-primary">Configurar Notificações</button>
    </div>
</header>

<div class="notifications-section">
    <!-- Filtros -->
    <div class="notification-filters">
        <button class="filter-tab active">Todas</button>
        <button class="filter-tab">Não Lidas</button>
        <button class="filter-tab">Sistema</button>
        <button class="filter-tab">Reservas</button>
    </div>

    <!-- Lista de Notificações -->
    <div class="notifications-list">
        <!-- Notificação 1 -->
        <div class="notification-item unread">
            <div class="notification-icon">
                <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
            </div>
            <div class="notification-content">
                <h4>Solicitação Aprovada</h4>
                <p>Sua solicitação para "Workshop de Inovação" foi aprovada para 15/05/2024.</p>
                <span class="notification-time">Há 2 horas</span>
            </div>
            <div class="notification-actions">
                <button class="btn btn-sm btn-outline">Ver Detalhes</button>
            </div>
        </div>

        <!-- Notificação 2 -->
        <div class="notification-item">
            <div class="notification-icon">
                <svg viewBox="0 0 24 24"><path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/></svg>
            </div>
            <div class="notification-content">
                <h4>Lembrete de Evento</h4>
                <p>Você tem um evento agendado em 30 minutos: "Palestra de Abertura".</p>
                <span class="notification-time">Há 4 horas</span>
            </div>
            <div class="notification-actions">
                <button class="btn btn-sm btn-outline">Ver Evento</button>
            </div>
        </div>

        <!-- Notificação 3 -->
        <div class="notification-item">
            <div class="notification-icon">
                <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H8c0-2.21 1.79-4 4-4s4 1.79 4 4c0 .88-.36 1.68-.93 2.25z"/></svg>
            </div>
            <div class="notification-content">
                <h4>Nova Solicitação</h4>
                <p>Carlos Pereira solicitou acesso ao sistema. Aguardando sua aprovação.</p>
                <span class="notification-time">Ontem</span>
            </div>
            <div class="notification-actions">
                <button class="btn btn-sm btn-primary">Aprovar</button>
                <button class="btn btn-sm btn-outline">Ver Detalhes</button>
            </div>
        </div>

        <!-- Notificação 4 -->
        <div class="notification-item">
            <div class="notification-icon">
                <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg>
            </div>
            <div class="notification-content">
                <h4>Relatório Mensal</h4>
                <p>O relatório de uso do mês de abril está disponível para download.</p>
                <span class="notification-time">2 dias atrás</span>
            </div>
            <div class="notification-actions">
                <button class="btn btn-sm btn-secondary">Download</button>
            </div>
        </div>

        <!-- Notificação 5 -->
        <div class="notification-item">
            <div class="notification-icon">
                <svg viewBox="0 0 24 24"><path d="M19.14,12.94c0.04-0.3,0.06-0.61,0.06-0.94c0-0.32-0.02-0.64-0.07-0.94l2.03-1.58c0.18-0.14,0.23-0.41,0.12-0.61 l-1.92-3.32c-0.12-0.22-0.37-0.29-0.59-0.22l-2.39,0.96c-0.5-0.38-1.03-0.7-1.62-0.94L14.4,2.81c-0.04-0.24-0.24-0.41-0.48-0.41 h-3.84c-0.24,0-0.43,0.17-0.47,0.41L9.25,5.35C8.66,5.59,8.12,5.92,7.63,6.29L5.24,5.33c-0.22-0.08-0.47,0-0.59,0.22L2.74,8.87 C2.62,9.08,2.66,9.34,2.86,9.48l2.03,1.58C4.84,11.36,4.82,11.69,4.82,12s0.02,0.64,0.07,0.94l-2.03,1.58 c-0.18,0.14-0.23,0.41-0.12,0.61l1.92,3.32c0.12,0.22,0.37,0.29,0.59,0.22l2.39-0.96c0.5,0.38,1.03,0.7,1.62,0.94l0.36,2.54 c0.05,0.24,0.24,0.41,0.48,0.41h3.84c0.24,0,0.44-0.17,0.47-0.41l0.36-2.54c0.59-0.24,1.13-0.56,1.62-0.94l2.39,0.96 c0.22,0.08,0.47,0,0.59-0.22l1.92-3.32c0.12-0.22,0.07-0.47-0.12-0.61L19.14,12.94z M12,15.6c-1.98,0-3.6-1.62-3.6-3.6 s1.62-3.6,3.6-3.6s3.6,1.62,3.6,3.6S13.98,15.6,12,15.6z"/></svg>
            </div>
            <div class="notification-content">
                <h4>Atualização do Sistema</h4>
                <p>Nova versão 2.1.0 disponível com melhorias na interface e performance.</p>
                <span class="notification-time">3 dias atrás</span>
            </div>
            <div class="notification-actions">
                <button class="btn btn-sm btn-outline">Ver Atualizações</button>
            </div>
        </div>
    </div>
</div>
';

include 'includes/layout-base.php';
?>
