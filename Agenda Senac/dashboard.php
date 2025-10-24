<?php
require_once 'config/user-config.php';
requireLogin();

$page_title = 'Dashboard - Sistema de Agendamento SENAC';

// Obter estatísticas do banco
$stats = getDashboardStats();
$user = getCurrentUser();

$page_content = '
<header class="main-header">
    <h1>Dashboard</h1>
    <div class="header-controls">
        <div class="date-info">
            <span class="current-date">' . date('d/m/Y') . '</span>
        </div>
        <button class="btn btn-primary">Nova Reserva</button>
    </div>
</header>

<!-- Estatísticas Principais -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">
            <svg viewBox="0 0 24 24"><path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20a2 2 0 002 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10z"/></svg>
        </div>
        <div class="stat-content">
            <h3>' . $stats['reservas_hoje'] . '</h3>
            <p>Reservas Hoje</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
        </div>
        <div class="stat-content">
            <h3>' . $stats['reservas_mes'] . '</h3>
            <p>Reservas Este Mês</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
        </div>
        <div class="stat-content">
            <h3>' . $stats['colaboradores_ativos'] . '</h3>
            <p>Colaboradores Ativos</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <svg viewBox="0 0 24 24"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg>
        </div>
        <div class="stat-content">
            <h3>' . $stats['solicitacoes_pendentes'] . '</h3>
            <p>Solicitações Pendentes</p>
        </div>
    </div>
</div>

<!-- Atividades Recentes -->
<div class="recent-activities">
    <h2>Atividades Recentes</h2>
    <div class="activity-list">
        <div class="activity-item">
            <div class="activity-icon approved">
                <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
            </div>
            <div class="activity-content">
                <h4>Solicitação Aprovada</h4>
                <p>Palestra de Abertura - Ana Silva</p>
                <span class="activity-time">Há 2 horas</span>
            </div>
        </div>
        
        <div class="activity-item">
            <div class="activity-icon pending">
                <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H8c0-2.21 1.79-4 4-4s4 1.79 4 4c0 .88-.36 1.68-.93 2.25z"/></svg>
            </div>
            <div class="activity-content">
                <h4>Nova Solicitação</h4>
                <p>Workshop de Inovação - Carlos Pereira</p>
                <span class="activity-time">Há 4 horas</span>
            </div>
        </div>
        
        <div class="activity-item">
            <div class="activity-icon info">
                <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            </div>
            <div class="activity-content">
                <h4>Novo Colaborador</h4>
                <p>Mariana Santos foi adicionada ao sistema</p>
                <span class="activity-time">Ontem</span>
            </div>
        </div>
    </div>
</div>
';

include 'includes/layout-base.php';
?>
