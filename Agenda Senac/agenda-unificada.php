<?php
require_once 'config/user-config.php';
requireLogin();

$page_title = 'Agenda - Sistema de Agendamento SENAC';

// Obter dados do banco
$auditorios = fetchData("SELECT * FROM auditorios WHERE ativo = 1 ORDER BY nome");
$reservas = getAllReservations();
$status_reserva = fetchData("SELECT * FROM status_reserva");

// Organizar reservas por auditorio e horário
$reservas_organizadas = [];
foreach ($reservas as $reserva) {
    $auditorio_id = $reserva['auditorio_id'];
    $data_inicio = $reserva['data_inicio'];
    $reservas_organizadas[$auditorio_id][$data_inicio] = $reserva;
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
    
    <!-- CSS Específico da Agenda -->
    <link rel="stylesheet" href="css/agenda.css">
</head>
<body>
    <div class="dashboard-layout">
        <?php include getSidebarPath(); ?>
        
        <!-- CONTEÚDO PRINCIPAL -->
        <main class="main-content">
            <header class="main-header">
                <h1>Agenda</h1>
                <div class="header-controls">
                    <div class="date-navigation">
                        <button class="btn btn-outline">← Anterior</button>
                        <span class="current-month"><?php echo date('F Y'); ?></span>
                        <button class="btn btn-outline">Próximo →</button>
                    </div>
                    <button class="btn btn-primary" onclick="abrirModalSolicitacao()">Nova Solicitação</button>
                </div>
            </header>

            <!-- Grade de Horários -->
            <div class="schedule-grid">
                <div class="grid-header">Horário</div>
                <?php foreach ($auditorios as $auditorio): ?>
                    <div class="grid-header"><?php echo htmlspecialchars($auditorio['nome']); ?></div>
                <?php endforeach; ?>
                
                <?php for ($h = 8; $h <= 18; $h++): ?>
                    <div class="time-cell"><?php echo sprintf('%02d:00', $h); ?></div>
                    <?php foreach ($auditorios as $auditorio): ?>
                        <?php
                        $time = sprintf('%02d:00', $h);
                        $hasReservation = false;
                        $reservation = null;
                        
                        // Verificar se há reserva neste horário
                        foreach ($reservas as $reserva) {
                            if ($reserva['auditorio_id'] == $auditorio['id']) {
                                $reserva_time = date('H', strtotime($reserva['data_inicio']));
                                if ($reserva_time == $h) {
                                    $hasReservation = true;
                                    $reservation = $reserva;
                                    break;
                                }
                            }
                        }
                        ?>
                        
                        <?php if ($hasReservation && $reservation): ?>
                            <div class="slot-cell status-<?php echo strtolower($reservation['status_nome']); ?>" 
                                 data-time="<?php echo $time; ?>" 
                                 data-auditorium="<?php echo $auditorio['id']; ?>">
                                <div class="slot-content">
                                    <div class="slot-title"><?php echo htmlspecialchars($reservation['titulo']); ?></div>
                                    <div class="slot-status"><?php echo htmlspecialchars($reservation['status_nome']); ?></div>
                                    <div class="slot-time"><?php echo date('H:i', strtotime($reservation['data_inicio'])); ?> - <?php echo date('H:i', strtotime($reservation['data_fim'])); ?></div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="slot-cell available" 
                                 data-time="<?php echo $time; ?>" 
                                 data-auditorium="<?php echo $auditorio['id']; ?>"
                                 onclick="abrirModalSolicitacao('<?php echo $time; ?>', <?php echo $auditorio['id']; ?>)">
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endfor; ?>
            </div>

            <!-- Legenda -->
            <div class="schedule-legend">
                <?php foreach ($status_reserva as $status): ?>
                <div class="legend-item">
                    <div class="legend-color" style="background-color: <?php echo $status['cor']; ?>"></div>
                    <span><?php echo htmlspecialchars($status['nome']); ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>

    <!-- Modal de Nova Solicitação -->
    <div id="modalSolicitacao" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Nova Solicitação de Reserva</h2>
                <button class="modal-close" onclick="fecharModalSolicitacao()">&times;</button>
            </div>
            <form id="formSolicitacao" onsubmit="enviarSolicitacao(event)">
                <div class="form-group">
                    <label for="titulo">Título do Evento *</label>
                    <input type="text" id="titulo" name="titulo" required>
                </div>
                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <textarea id="descricao" name="descricao" rows="3"></textarea>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="data">Data *</label>
                        <input type="date" id="data" name="data" required>
                    </div>
                    <div class="form-group">
                        <label for="hora_inicio">Hora de Início *</label>
                        <input type="time" id="hora_inicio" name="hora_inicio" required>
                    </div>
                    <div class="form-group">
                        <label for="hora_fim">Hora de Fim *</label>
                        <input type="time" id="hora_fim" name="hora_fim" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="participantes">Número de Participantes</label>
                    <input type="number" id="participantes" name="participantes" min="1" value="1">
                </div>
                <div class="form-group">
                    <label for="justificativa">Justificativa *</label>
                    <textarea id="justificativa" name="justificativa" rows="3" required placeholder="Explique o motivo da reserva..."></textarea>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn btn-outline" onclick="fecharModalSolicitacao()">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Enviar Solicitação</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function abrirModalSolicitacao(hora = null, auditorioId = null) {
        const modal = document.getElementById('modalSolicitacao');
        modal.style.display = 'block';
        
        if (hora) {
            document.getElementById('hora_inicio').value = hora + ':00';
            const horaFim = (parseInt(hora) + 1).toString().padStart(2, '0') + ':00';
            document.getElementById('hora_fim').value = horaFim;
        }
        
        if (auditorioId) {
            // Se clicou em um slot específico, pode definir o auditório
        }
        
        // Definir data mínima como hoje
        const hoje = new Date().toISOString().split('T')[0];
        document.getElementById('data').min = hoje;
        document.getElementById('data').value = hoje;
    }

    function fecharModalSolicitacao() {
        document.getElementById('modalSolicitacao').style.display = 'none';
        document.getElementById('formSolicitacao').reset();
    }

    function enviarSolicitacao(event) {
        event.preventDefault();
        
        // Obter dados do formulário
        const form = event.target;
        const formData = new FormData(form);
        
        // Mostrar loading
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.textContent = 'Enviando...';
        submitBtn.disabled = true;
        
        // Fazer requisição
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'api/criar-solicitacao.php', true);
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                // Restaurar botão
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
                
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        
                        if (response.success) {
                            alert('Solicitação enviada com sucesso!');
                            fecharModalSolicitacao();
                            location.reload();
                        } else {
                            alert('Erro: ' + response.message);
                        }
                    } catch (e) {
                        console.error('Erro ao parsear JSON:', e);
                        console.error('Resposta do servidor:', xhr.responseText);
                        alert('Erro: Resposta inválida do servidor');
                    }
                } else {
                    console.error('Erro HTTP:', xhr.status);
                    console.error('Resposta:', xhr.responseText);
                    alert('Erro de conexão com o servidor');
                }
            }
        };
        
        xhr.send(formData);
    }

    // Fechar modal clicando fora
    window.onclick = function(event) {
        const modal = document.getElementById('modalSolicitacao');
        if (event.target === modal) {
            fecharModalSolicitacao();
        }
    }
    </script>
</body>
</html>
