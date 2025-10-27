<?php 
// O header já inicia a sessão, conecta ao DB e busca os dados do usuário
include 'includes/header.php'; 

// --- LÓGICA DO CALENDÁRIO ---
$dataReferencia = isset($_GET['week']) ? $_GET['week'] : date('Y-m-d');
$timestampReferencia = strtotime($dataReferencia);
$inicioDaSemanaTimestamp = strtotime('monday this week', $timestampReferencia);

// Cria o mapeamento para os nomes dos dias da semana em Português
$nomesDiasSemana = [
    'Mon' => 'Seg',
    'Tue' => 'Ter',
    'Wed' => 'Qua',
    'Thu' => 'Qui',
    'Fri' => 'Sex',
    'Sat' => 'Sáb'
];

$semanaAnterior = date('Y-m-d', strtotime('-1 week', $inicioDaSemanaTimestamp));
$proximaSemana = date('Y-m-d', strtotime('+1 week', $inicioDaSemanaTimestamp));
$diasDaSemana = [];
for ($i = 0; $i < 6; $i++) {
    $diasDaSemana[] = date('Y-m-d', strtotime("+$i days", $inicioDaSemanaTimestamp));
}

$inicioSemanaSQL = $diasDaSemana[0] . ' 00:00:00';
$fimSemanaSQL = end($diasDaSemana) . ' 23:59:59';

$sql_reservas_aprovadas = "SELECT r.titulo, r.descricao, r.data_inicio, r.data_fim, u.nome AS autor 
                           FROM reservas r 
                           JOIN usuarios u ON r.id_usuario = u.id 
                           WHERE r.status = 'aprovada' AND r.data_inicio BETWEEN ? AND ?";
$stmt_aprovadas = $pdo->prepare($sql_reservas_aprovadas);
$stmt_aprovadas->execute([$inicioSemanaSQL, $fimSemanaSQL]);
$reservas_da_semana = $stmt_aprovadas->fetchAll(PDO::FETCH_ASSOC);

$reservasPorSlot = [];
foreach ($reservas_da_semana as $reserva) {
    $inicio = new DateTime($reserva['data_inicio']);
    $fim = new DateTime($reserva['data_fim']);
    $horaAtual = clone $inicio;
    while ($horaAtual < $fim) {
        $chave = $horaAtual->format('Y-m-d-H');
        $reservasPorSlot[$chave] = [
            'titulo' => $reserva['titulo'],
            'autor' => $reserva['autor'],
            'descricao' => $reserva['descricao'],
            'inicio' => $reserva['data_inicio'],
            'fim' => $reserva['data_fim']
        ];
        $horaAtual->modify('+1 hour');
    }
}

// --- LÓGICA DE MINHAS SOLICITAÇÕES ---
$id_usuario = $_SESSION['user_id'];
$sql_minhas_reservas = "SELECT titulo, data_inicio, data_fim, status, motivo_negacao, data_solicitacao FROM reservas WHERE id_usuario = ? ORDER BY data_solicitacao DESC";
$stmt_minhas = $pdo->prepare($sql_minhas_reservas);
$stmt_minhas->execute([$id_usuario]);
$minhas_reservas = $stmt_minhas->fetchAll(PDO::FETCH_ASSOC);
?>

<title>Dashboard - Senac Reservas</title>

<h1 class="page-title">Dashboard</h1>

<div class="glass-panel" >
    <h2>Agenda do Auditório</h2>
    <div class="calendar-nav" style="display: flex; justify-content: space-between; margin-bottom: 20px; align-items: center;">
        <a href="?week=<?php echo $semanaAnterior; ?>">&laquo; Semana Anterior</a>
        <span><?php echo date('d/m/Y', strtotime($diasDaSemana[0])) . ' - ' . date('d/m/Y', strtotime(end($diasDaSemana))); ?></span>
        <a href="?week=<?php echo $proximaSemana; ?>">Próxima Semana &raquo;</a>
    </div>
    <table class="calendar">
        <thead> 
            <tr>
                <th>Horário</th>
                <?php foreach ($diasDaSemana as $dia): ?>
                    <!-- **** CORREÇÃO **** - Usando o mapeamento manual para os nomes dos dias -->
                    <th><?php echo ucfirst($nomesDiasSemana[date('D', strtotime($dia))]); ?><br><?php echo date('d/m', strtotime($dia)); ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php for ($hora = 7; $hora <= 21; $hora++): ?>
                <tr>
                    <td><?php echo sprintf('%02d:00', $hora); ?></td>
                    <?php foreach ($diasDaSemana as $dia):
                        $chave = $dia . '-' . sprintf('%02d', $hora);
                        if (isset($reservasPorSlot[$chave])):
                            $reserva_info = $reservasPorSlot[$chave];
                        ?>
                            <td data-tilt data-tilt-max="10"class="occupied"
                                data-titulo="<?php echo htmlspecialchars($reserva_info['titulo']); ?>"
                                data-autor="<?php echo htmlspecialchars($reserva_info['autor']); ?>"
                                data-descricao="<?php echo nl2br(htmlspecialchars($reserva_info['descricao'])); ?>"
                                data-inicio="<?php echo date('H:i', strtotime($reserva_info['inicio'])); ?>"
                                data-fim="<?php echo date('H:i', strtotime($reserva_info['fim'])); ?>">
                                <strong><?php echo htmlspecialchars($reserva_info['titulo']); ?></strong><br>
                                <small><?php echo htmlspecialchars($reserva_info['autor']); ?></small>
                            </td>
                        <?php else: ?>
                            <td class="available"></td>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tr>
            <?php endfor; ?>
        </tbody>
    </table>
</div>

<div class="glass-panel" data-tilt data-tilt-max="1">
    <h2>Minhas Solicitações</h2>
    <?php if (count($minhas_reservas) > 0): ?>
        <?php foreach ($minhas_reservas as $reserva): ?>
            <div class="request-card status-<?php echo strtolower($reserva['status']); ?>">
                <h3><?php echo htmlspecialchars($reserva['titulo']); ?></h3>
                <p><strong>Período:</strong> <?php echo date('d/m/Y H:i', strtotime($reserva['data_inicio'])); ?> a <?php echo date('d/m/Y H:i', strtotime($reserva['data_fim'])); ?></p>
                <p><strong>Status:</strong> <?php echo ucfirst($reserva['status']); ?></p>
                <?php if ($reserva['status'] == 'negada'): ?>
                    <p><strong>Motivo:</strong> <?php echo htmlspecialchars($reserva['motivo_negacao']); ?></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Você ainda não fez nenhuma solicitação.</p>
    <?php endif; ?>
</div>

<!-- O HTML do Modal precisa ser incluído aqui, dentro do main-content -->
<!-- Estilo do modal adaptado para a nova estética -->
<style>
.modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); }
.modal-content {
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
    margin: 15% auto; padding: 30px; border-radius: 24px;
    width: 90%; max-width: 500px; position: relative;
    border: 1px solid rgba(255, 255, 255, 0.3);
}
.close { color: #555; position: absolute; top: 15px; right: 25px; font-size: 28px; font-weight: bold; cursor: pointer; }
</style>
<div id="eventModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2 id="modalTitle"></h2>
        <p><strong>Solicitante:</strong> <span id="modalAuthor"></span></p>
        <p><strong>Horário:</strong> <span id="modalTime"></span></p>
        <p><strong>Descrição:</strong></p>
        <div id="modalDescription" style="background-color: rgba(255,255,255,0.4); border: 1px solid rgba(0,0,0,0.05); padding: 10px; border-radius: 12px;"></div>
    </div>
</div>

<script>
// O script do modal, que depende de elementos desta página
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('eventModal');
    if (!modal) return; // Garante que o script não quebre em outras páginas

    const modalTitle = document.getElementById('modalTitle');
    const modalAuthor = document.getElementById('modalAuthor');
    const modalTime = document.getElementById('modalTime');
    const modalDescription = document.getElementById('modalDescription');
    const closeBtn = modal.querySelector('.close');

    const occupiedCells = document.querySelectorAll('.calendar td.occupied');

    occupiedCells.forEach(cell => {
        cell.addEventListener('click', function() {
            modalTitle.textContent = this.dataset.titulo;
            modalAuthor.textContent = this.dataset.autor;
            modalTime.textContent = this.dataset.inicio + ' às ' + this.dataset.fim;
            modalDescription.innerHTML = this.dataset.descricao || 'Nenhuma descrição fornecida.';
            modal.style.display = 'block';
        });
    });

    function closeModal() {
        modal.style.display = 'none';
    }

    if(closeBtn) closeBtn.onclick = closeModal;

    window.onclick = function(event) {
        if (event.target == modal) {
            closeModal();
        }
    };
});
</script>

<?php 
// O footer inclui os frameworks e scripts
include 'includes/footer.php'; 
?>