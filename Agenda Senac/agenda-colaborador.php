<?php
// Redirecionar para agenda unificada
header('Location: agenda-unificada.php');
exit;
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
                <h1>Ver Agenda</h1>
                <div class="header-controls">
                    <div class="date-navigation">
                        <button class="btn btn-outline">← Anterior</button>
                        <span class="current-month"><?php echo date('F Y'); ?></span>
                        <button class="btn btn-outline">Próximo →</button>
                    </div>
                    <button class="btn btn-primary">Nova Solicitação</button>
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
                                 data-auditorium="<?php echo $auditorio['id']; ?>">
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
</body>
</html>