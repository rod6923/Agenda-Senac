<?php
require_once 'config/user-config.php';
requireLogin();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
    exit;
}

$titulo = $_POST['titulo'] ?? '';
$descricao = $_POST['descricao'] ?? '';
$data = $_POST['data'] ?? '';
$hora_inicio = $_POST['hora_inicio'] ?? '';
$hora_fim = $_POST['hora_fim'] ?? '';
$participantes = $_POST['participantes'] ?? 1;
$justificativa = $_POST['justificativa'] ?? '';

// Validações
if (empty($titulo) || empty($data) || empty($hora_inicio) || empty($hora_fim) || empty($justificativa)) {
    echo json_encode(['success' => false, 'message' => 'Todos os campos obrigatórios devem ser preenchidos']);
    exit;
}

// Validar se a data não é no passado
$data_inicio = $data . ' ' . $hora_inicio;
$data_fim = $data . ' ' . $hora_fim;

if (strtotime($data_inicio) < time()) {
    echo json_encode(['success' => false, 'message' => 'Não é possível agendar para datas passadas']);
    exit;
}

// Validar se hora fim é maior que hora início
if (strtotime($data_fim) <= strtotime($data_inicio)) {
    echo json_encode(['success' => false, 'message' => 'Hora de fim deve ser maior que hora de início']);
    exit;
}

try {
    $user = getCurrentUser();
    
    // Obter o primeiro auditório (único)
    $auditorio = fetchOne("SELECT * FROM auditorios WHERE ativo = 1 LIMIT 1");
    if (!$auditorio) {
        echo json_encode(['success' => false, 'message' => 'Nenhum auditório disponível']);
        exit;
    }
    
    // Obter status "Pendente"
    $status_pendente = fetchOne("SELECT * FROM status_reserva WHERE nome = 'Pendente'");
    if (!$status_pendente) {
        echo json_encode(['success' => false, 'message' => 'Status pendente não encontrado']);
        exit;
    }
    
    // Verificar conflitos de horário
    $conflito = fetchOne("
        SELECT * FROM reservas 
        WHERE auditorio_id = :auditorio_id 
        AND (
            (data_inicio <= :data_inicio AND data_fim > :data_inicio) OR
            (data_inicio < :data_fim AND data_fim >= :data_fim) OR
            (data_inicio >= :data_inicio AND data_fim <= :data_fim)
        )
        AND status_id IN (SELECT id FROM status_reserva WHERE nome IN ('Pendente', 'Aprovada'))
    ", [
        'auditorio_id' => $auditorio['id'],
        'data_inicio' => $data_inicio,
        'data_fim' => $data_fim
    ]);
    
    if ($conflito) {
        echo json_encode(['success' => false, 'message' => 'Já existe uma reserva neste horário']);
        exit;
    }
    
    // Criar a solicitação
    $reserva_id = insertData('reservas', [
        'titulo' => $titulo,
        'descricao' => $descricao,
        'usuario_id' => $user['id'],
        'auditorio_id' => $auditorio['id'],
        'data_inicio' => $data_inicio,
        'data_fim' => $data_fim,
        'participantes' => $participantes,
        'status_id' => $status_pendente['id'],
        'justificativa' => $justificativa
    ]);
    
    // Notificar gerentes
    $gerentes = fetchData("SELECT id FROM usuarios WHERE tipo = 'gerente' AND ativo = 1");
    foreach ($gerentes as $gerente) {
        insertData('notificacoes', [
            'usuario_id' => $gerente['id'],
            'titulo' => 'Nova Solicitação de Reserva',
            'mensagem' => "Nova solicitação de reserva: '{$titulo}' por {$user['nome']}",
            'tipo' => 'info'
        ]);
    }
    
    echo json_encode(['success' => true, 'message' => 'Solicitação criada com sucesso']);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
}
?>
