<?php 
// O header já cuida da autenticação, verificação de cargo, conexão com DB, etc.
include 'includes/header.php'; 

// A verificação de cargo específica para esta página
if ($_SESSION['user_cargo'] != 'gerente') {
    header("Location: dashboard.php");
    exit;
}

// Lógica para buscar cadastros pendentes
$sql_users = "SELECT id, nome, email FROM usuarios WHERE status = 'pendente'";
$stmt_users = $pdo->query($sql_users);
$usuarios_pendentes = $stmt_users->fetchAll(PDO::FETCH_ASSOC);

// Lógica para buscar reservas pendentes
$sql_reservas = "SELECT r.id, r.titulo, r.descricao, r.urgencia, r.data_inicio, r.data_fim, u.nome AS autor, r.data_solicitacao 
                 FROM reservas r 
                 JOIN usuarios u ON r.id_usuario = u.id 
                 WHERE r.status = 'pendente' ORDER BY FIELD(r.urgencia, 'Alta', 'Media', 'Baixa'), r.data_solicitacao ASC";
$stmt_reservas = $pdo->query($sql_reservas);
$reservas_pendentes = $stmt_reservas->fetchAll(PDO::FETCH_ASSOC);
?>

<title>Painel Administrativo - Senac Reservas</title>

<h1 class="page-title">Painel Administrativo</h1>

<!-- Painel para Cadastros Pendentes -->
<div class="glass-panel" data-tilt data-tilt-max="0.5">
    <h2>Cadastros Pendentes de Aprovação</h2>
    <?php if (count($usuarios_pendentes) > 0): ?>
        <ul class="approval-list">
            <?php foreach ($usuarios_pendentes as $user): ?>
                <li>
                    <span><?php echo htmlspecialchars($user['nome']) . " (" . htmlspecialchars($user['email']) . ")"; ?></span>
                    <div>
                        <a class="btn btn-approve" href="gerencia_solicitacao.php?acao=aprovar_user&id=<?php echo $user['id']; ?>">Aprovar</a>
                        <a class="btn btn-deny" href="gerencia_solicitacao.php?acao=negar_user&id=<?php echo $user['id']; ?>">Negar</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Nenhum cadastro pendente.</p>
    <?php endif; ?>
</div>

<!-- Painel para Reservas Pendentes -->
<div class="glass-panel" >
    <h2>Reservas Pendentes de Aprovação</h2>
    <?php if (count($reservas_pendentes) > 0): ?>
        <?php foreach ($reservas_pendentes as $reserva): ?>
            <?php
                $urgencia_class = '';
                if ($reserva['urgencia'] == 'Media') $urgencia_class = 'urgencia-media';
                if ($reserva['urgencia'] == 'Alta') $urgencia_class = 'urgencia-alta';
            ?>
            <div class="request-card status-pendente" >
                <h3><?php echo htmlspecialchars($reserva['titulo']); ?></h3>
                <p><strong>Solicitante:</strong> <?php echo htmlspecialchars($reserva['autor']); ?></p>
                <p><strong>Nível de Urgência:</strong> <span class="<?php echo $urgencia_class; ?>"><?php echo htmlspecialchars($reserva['urgencia']); ?></span></p>
                <p><strong>Período:</strong> <?php echo date('d/m/Y H:i', strtotime($reserva['data_inicio'])); ?> a <?php echo date('d/m/Y H:i', strtotime($reserva['data_fim'])); ?></p>
                <?php if (!empty($reserva['descricao'])): ?>
                    <p><strong>Descrição:</strong> <?php echo nl2br(htmlspecialchars($reserva['descricao'])); ?></p>
                <?php endif; ?>
                
                <div style="margin-top: 20px; display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                    <a class="btn btn-approve" href="gerencia_solicitacao.php?acao=aprovar_reserva&id=<?php echo $reserva['id']; ?>">Aprovar</a>
                    <form class="denial-form" action="gerencia_solicitacao.php?acao=negar_reserva&id=<?php echo $reserva['id']; ?>" method="post">
                        <!-- **** CLASSE CORRIGIDA **** -->
                        <input class="glass-input" type="text" name="motivo" placeholder="Motivo para negar" required>
                        <button type="submit" class="btn btn-deny">Negar</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Nenhuma reserva pendente.</p>
    <?php endif; ?>
</div>

<?php 
// Inclui o footer com os frameworks e scripts
include 'includes/footer.php'; 
?>