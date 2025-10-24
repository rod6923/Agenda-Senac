<?php
$page_title = 'Configurações - Sistema de Agendamento SENAC';
$page_content = '
<header class="main-header">
    <h1>Configurações</h1>
    <div class="header-controls">
        <button class="btn btn-primary">Salvar Configurações</button>
        <button class="btn btn-outline">Restaurar Padrões</button>
    </div>
</header>

<div class="settings-container">
    <!-- Configurações Gerais -->
    <div class="settings-section">
        <h2>Configurações Gerais</h2>
        <div class="form-grid">
            <div class="form-group">
                <label for="nome-sistema">Nome do Sistema</label>
                <input type="text" id="nome-sistema" value="SENAC Agendamentos" required>
            </div>
            <div class="form-group">
                <label for="horario-funcionamento">Horário de Funcionamento</label>
                <div class="time-range">
                    <input type="time" id="inicio-funcionamento" value="08:00">
                    <span>até</span>
                    <input type="time" id="fim-funcionamento" value="18:00">
                </div>
            </div>
            <div class="form-group">
                <label for="tempo-reserva">Tempo Máximo de Reserva (horas)</label>
                <input type="number" id="tempo-reserva" value="4" min="1" max="8">
            </div>
            <div class="form-group">
                <label for="antecedencia-minima">Antecedência Mínima (horas)</label>
                <input type="number" id="antecedencia-minima" value="24" min="1" max="168">
            </div>
        </div>
    </div>

    <!-- Configurações de Notificação -->
    <div class="settings-section">
        <h2>Notificações</h2>
        <div class="preferences-grid">
            <div class="preference-item">
                <label class="checkbox-label">
                    <input type="checkbox" checked>
                    <span class="checkmark"></span>
                    Enviar e-mails de confirmação
                </label>
            </div>
            <div class="preference-item">
                <label class="checkbox-label">
                    <input type="checkbox" checked>
                    <span class="checkmark"></span>
                    Lembretes automáticos
                </label>
            </div>
            <div class="preference-item">
                <label class="checkbox-label">
                    <input type="checkbox">
                    <span class="checkmark"></span>
                    Notificações por SMS
                </label>
            </div>
            <div class="preference-item">
                <label class="checkbox-label">
                    <input type="checkbox" checked>
                    <span class="checkmark"></span>
                    Atualizações do sistema
                </label>
            </div>
        </div>
    </div>

    <!-- Configurações de Segurança -->
    <div class="settings-section">
        <h2>Segurança</h2>
        <div class="form-grid">
            <div class="form-group">
                <label for="sessao-timeout">Timeout de Sessão (minutos)</label>
                <input type="number" id="sessao-timeout" value="30" min="5" max="480">
            </div>
            <div class="form-group">
                <label for="tentativas-login">Máximo de Tentativas de Login</label>
                <input type="number" id="tentativas-login" value="3" min="1" max="10">
            </div>
            <div class="form-group">
                <label for="complexidade-senha">Complexidade de Senha</label>
                <select id="complexidade-senha">
                    <option value="baixa">Baixa</option>
                    <option value="media" selected>Média</option>
                    <option value="alta">Alta</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Configurações de Backup -->
    <div class="settings-section">
        <h2>Backup e Manutenção</h2>
        <div class="backup-options">
            <div class="backup-item">
                <h4>Backup Automático</h4>
                <p>Último backup: 10/05/2024 às 02:00</p>
                <button class="btn btn-secondary">Fazer Backup Agora</button>
            </div>
            <div class="backup-item">
                <h4>Limpeza de Dados</h4>
                <p>Remover dados antigos (mais de 1 ano)</p>
                <button class="btn btn-outline">Limpar Dados Antigos</button>
            </div>
        </div>
    </div>

    <!-- Configurações de Integração -->
    <div class="settings-section">
        <h2>Integrações</h2>
        <div class="integration-options">
            <div class="integration-item">
                <h4>Calendário Google</h4>
                <p>Sincronizar com Google Calendar</p>
                <button class="btn btn-secondary">Configurar</button>
            </div>
            <div class="integration-item">
                <h4>Microsoft Outlook</h4>
                <p>Sincronizar com Outlook</p>
                <button class="btn btn-secondary">Configurar</button>
            </div>
            <div class="integration-item">
                <h4>API Externa</h4>
                <p>Integração com sistemas externos</p>
                <button class="btn btn-secondary">Configurar</button>
            </div>
        </div>
    </div>
</div>
';

include 'includes/layout-base.php';
?>
