<?php
$page_title = 'Relatórios - Sistema de Agendamento SENAC';
$page_content = '
<header class="main-header">
    <h1>Relatórios</h1>
    <div class="header-controls">
        <div class="date-range">
            <input type="date" id="data-inicio" value="2024-01-01">
            <span>até</span>
            <input type="date" id="data-fim" value="2024-12-31">
        </div>
        <button class="btn btn-primary">Gerar Relatório</button>
    </div>
</header>

<div class="reports-section">
    <!-- Estatísticas Principais -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <svg viewBox="0 0 24 24"><path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20a2 2 0 002 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10z"/></svg>
            </div>
            <div class="stat-content">
                <h3>1,247</h3>
                <p>Total de Reservas</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            </div>
            <div class="stat-content">
                <h3>89%</h3>
                <p>Taxa de Ocupação</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            </div>
            <div class="stat-content">
                <h3>45</h3>
                <p>Usuários Ativos</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <svg viewBox="0 0 24 24"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg>
            </div>
            <div class="stat-content">
                <h3>156h</h3>
                <p>Horas Utilizadas</p>
            </div>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="charts-section">
        <div class="chart-container">
            <h3>Reservas por Mês</h3>
            <div class="chart-placeholder">
                <p>Gráfico de barras será exibido aqui</p>
            </div>
        </div>
        
        <div class="chart-container">
            <h3>Ocupação por Horário</h3>
            <div class="chart-placeholder">
                <p>Gráfico de linha será exibido aqui</p>
            </div>
        </div>
    </div>

    <!-- Relatórios Disponíveis -->
    <div class="reports-list">
        <h3>Relatórios Disponíveis</h3>
        <div class="report-options">
            <button class="btn btn-secondary">Relatório de Uso</button>
            <button class="btn btn-secondary">Relatório de Colaboradores</button>
            <button class="btn btn-secondary">Relatório de Horários</button>
            <button class="btn btn-secondary">Relatório de Eventos</button>
        </div>
    </div>
</div>
';

include 'includes/layout-base.php';
?>
