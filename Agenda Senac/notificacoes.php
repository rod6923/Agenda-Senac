<?php
require_once 'config/user-config.php';
requireLogin();

$page_title = 'Notificações - Sistema de Agendamento SENAC';

// Obter notificações do usuário logado
$user = getCurrentUser();
$notificacoes = fetchData("SELECT * FROM notificacoes WHERE usuario_id = :user_id ORDER BY created_at DESC", ['user_id' => $user['id']]);

// Função para calcular tempo relativo
function timeAgo($datetime) {
    $time = time() - strtotime($datetime);
    
    if ($time < 60) return 'Agora mesmo';
    if ($time < 3600) return floor($time/60) . ' min atrás';
    if ($time < 86400) return floor($time/3600) . ' h atrás';
    if ($time < 2592000) return floor($time/86400) . ' dias atrás';
    if ($time < 31536000) return floor($time/2592000) . ' meses atrás';
    return floor($time/31536000) . ' anos atrás';
}

// Função para obter ícone baseado no tipo
function getNotificationIcon($tipo) {
    switch ($tipo) {
        case 'success':
            return '<svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>';
        case 'warning':
            return '<svg viewBox="0 0 24 24"><path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/></svg>';
        case 'error':
            return '<svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H8c0-2.21 1.79-4 4-4s4 1.79 4 4c0 .88-.36 1.68-.93 2.25z"/></svg>';
        default:
            return '<svg viewBox="0 0 24 24"><path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/></svg>';
    }
}
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
    
    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="dashboard-layout">
        <?php include getSidebarPath(); ?>
        
        <!-- CONTEÚDO PRINCIPAL -->
        <main class="main-content">
            <header class="main-header">
                <h1>Notificações</h1>
                <div class="header-controls">
                    <button class="btn btn-outline" onclick="marcarTodasComoLidas()">Marcar Todas como Lidas</button>
                    <button class="btn btn-primary" onclick="window.location.href='configuracoes.php'">Configurar Notificações</button>
                </div>
            </header>

            <div class="notifications-section">
                <!-- Filtros -->
                <div class="notification-filters">
                    <button class="filter-tab active" onclick="filtrarNotificacoes('todas')">Todas</button>
                    <button class="filter-tab" onclick="filtrarNotificacoes('nao-lidas')">Não Lidas</button>
                    <button class="filter-tab" onclick="filtrarNotificacoes('sistema')">Sistema</button>
                    <button class="filter-tab" onclick="filtrarNotificacoes('reservas')">Reservas</button>
                </div>

                <!-- Lista de Notificações -->
                <div class="notifications-list">
                    <?php if (empty($notificacoes)): ?>
                    <div class="empty-state">
                        <h3>Nenhuma notificação encontrada</h3>
                        <p>Você não possui notificações no momento.</p>
                    </div>
                    <?php else: ?>
                        <?php foreach ($notificacoes as $notificacao): ?>
                        <div class="notification-item <?php echo $notificacao['lida'] ? '' : 'unread'; ?>" data-tipo="<?php echo $notificacao['tipo']; ?>">
                            <div class="notification-icon">
                                <?php echo getNotificationIcon($notificacao['tipo']); ?>
                            </div>
                            <div class="notification-content">
                                <h4><?php echo htmlspecialchars($notificacao['titulo']); ?></h4>
                                <p><?php echo htmlspecialchars($notificacao['mensagem']); ?></p>
                                <span class="notification-time"><?php echo timeAgo($notificacao['created_at']); ?></span>
                            </div>
                            <div class="notification-actions">
                                <?php if (!$notificacao['lida']): ?>
                                <button class="btn btn-sm btn-outline" onclick="marcarComoLida(<?php echo $notificacao['id']; ?>)">Marcar como Lida</button>
                                <?php endif; ?>
                                <button class="btn btn-sm btn-outline" onclick="verDetalhes(<?php echo $notificacao['id']; ?>)">Ver Detalhes</button>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <script>
    function filtrarNotificacoes(filtro) {
        const notificacoes = document.querySelectorAll('.notification-item');
        const tabs = document.querySelectorAll('.filter-tab');
        
        // Atualizar tabs ativos
        tabs.forEach(tab => tab.classList.remove('active'));
        event.target.classList.add('active');
        
        // Filtrar notificações
        notificacoes.forEach(notificacao => {
            const tipo = notificacao.dataset.tipo;
            const isUnread = notificacao.classList.contains('unread');
            
            let mostrar = true;
            
            switch (filtro) {
                case 'nao-lidas':
                    mostrar = isUnread;
                    break;
                case 'sistema':
                    mostrar = tipo === 'info';
                    break;
                case 'reservas':
                    mostrar = tipo === 'success' || tipo === 'warning';
                    break;
                case 'todas':
                default:
                    mostrar = true;
                    break;
            }
            
            notificacao.style.display = mostrar ? 'flex' : 'none';
        });
    }

    function marcarComoLida(id) {
        fetch('api/marcar-notificacao-lida.php', {
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

    function marcarTodasComoLidas() {
        if (confirm('Deseja marcar todas as notificações como lidas?')) {
            fetch('api/marcar-todas-lidas.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'}
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
        alert('Detalhes da notificação ID: ' + id);
    }
    </script>
</body>
</html>
