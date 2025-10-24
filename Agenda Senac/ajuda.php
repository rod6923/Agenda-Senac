<?php
$page_title = 'Ajuda - Sistema de Agendamento SENAC';
$page_content = '
<header class="main-header">
    <h1>Ajuda e Suporte</h1>
    <div class="header-controls">
        <div class="search-box">
            <svg class="search-icon" viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
            <input type="text" placeholder="Buscar na ajuda...">
        </div>
    </div>
</header>

<div class="help-container">
    <!-- Seções de Ajuda -->
    <div class="help-sections">
        <div class="help-section">
            <h2>Como Fazer uma Reserva</h2>
            <div class="help-content">
                <ol>
                    <li>Acesse a página "Agenda" no menu lateral</li>
                    <li>Selecione a data desejada no calendário</li>
                    <li>Escolha o horário disponível</li>
                    <li>Preencha os dados do evento</li>
                    <li>Clique em "Solicitar Reserva"</li>
                </ol>
            </div>
        </div>

        <div class="help-section">
            <h2>Gerenciar Colaboradores</h2>
            <div class="help-content">
                <p>Como gerente, você pode:</p>
                <ul>
                    <li>Visualizar todos os colaboradores cadastrados</li>
                    <li>Aprovar ou rejeitar solicitações de acesso</li>
                    <li>Editar informações dos colaboradores</li>
                    <li>Visualizar estatísticas de uso</li>
                </ul>
            </div>
        </div>

        <div class="help-section">
            <h2>Configurações do Sistema</h2>
            <div class="help-content">
                <p>Nas configurações você pode:</p>
                <ul>
                    <li>Definir horários de funcionamento</li>
                    <li>Configurar notificações</li>
                    <li>Gerenciar segurança</li>
                    <li>Configurar backups automáticos</li>
                </ul>
            </div>
        </div>

        <div class="help-section">
            <h2>Relatórios e Estatísticas</h2>
            <div class="help-content">
                <p>Os relatórios mostram:</p>
                <ul>
                    <li>Uso dos auditórios por período</li>
                    <li>Estatísticas de colaboradores</li>
                    <li>Horários mais utilizados</li>
                    <li>Eventos mais frequentes</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- FAQ -->
    <div class="faq-section">
        <h2>Perguntas Frequentes</h2>
        <div class="faq-list">
            <div class="faq-item">
                <h4>Como cancelar uma reserva?</h4>
                <p>Acesse "Minhas Reservas", encontre a reserva desejada e clique em "Cancelar".</p>
            </div>
            
            <div class="faq-item">
                <h4>Posso fazer reservas para outros colaboradores?</h4>
                <p>Sim, como gerente você pode fazer reservas em nome de outros colaboradores.</p>
            </div>
            
            <div class="faq-item">
                <h4>Como alterar minha senha?</h4>
                <p>Acesse "Meu Perfil" e vá para a seção "Alteração de Senha".</p>
            </div>
            
            <div class="faq-item">
                <h4>O que fazer se esqueci minha senha?</h4>
                <p>Entre em contato com o administrador do sistema para redefinir sua senha.</p>
            </div>
            
            <div class="faq-item">
                <h4>Como configurar notificações?</h4>
                <p>Vá em "Configurações" e ajuste suas preferências de notificação.</p>
            </div>
        </div>
    </div>

    <!-- Contato -->
    <div class="contact-section">
        <h2>Contato e Suporte</h2>
        <div class="contact-info">
            <div class="contact-item">
                <h4>Suporte Técnico</h4>
                <p>suporte@senac.com.br</p>
                <p>(11) 99999-9999</p>
            </div>
            <div class="contact-item">
                <h4>Administrador do Sistema</h4>
                <p>admin@senac.com.br</p>
                <p>(11) 88888-8888</p>
            </div>
            <div class="contact-item">
                <h4>Horário de Atendimento</h4>
                <p>Segunda a Sexta: 8h às 18h</p>
                <p>Sábado: 8h às 12h</p>
            </div>
        </div>
    </div>

    <!-- Documentação -->
    <div class="documentation-section">
        <h2>Documentação</h2>
        <div class="doc-links">
            <a href="#" class="doc-link">
                <svg viewBox="0 0 24 24"><path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/></svg>
                <span>Manual do Usuário</span>
            </a>
            <a href="#" class="doc-link">
                <svg viewBox="0 0 24 24"><path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/></svg>
                <span>Guia do Administrador</span>
            </a>
            <a href="#" class="doc-link">
                <svg viewBox="0 0 24 24"><path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/></svg>
                <span>Política de Uso</span>
            </a>
        </div>
    </div>
</div>
';

include 'includes/layout-base.php';
?>
