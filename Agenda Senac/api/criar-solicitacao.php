<?php
// API para criar solicitação de reserva - Versão Ultra Robusta

// Configurações para evitar qualquer saída HTML
error_reporting(0);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('html_errors', 0);

// Buffer de saída para capturar qualquer erro
ob_start();

// Definir header JSON imediatamente
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-cache, must-revalidate');

// Função para retornar erro JSON
function returnError($message) {
    ob_clean();
    echo json_encode(['success' => false, 'message' => $message]);
    exit;
}

// Função para retornar sucesso JSON
function returnSuccess($message, $data = null) {
    ob_clean();
    $response = ['success' => true, 'message' => $message];
    if ($data) {
        $response['data'] = $data;
    }
    echo json_encode($response);
    exit;
}

// Verificar se é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    returnError('Método não permitido');
}

// Verificar se os arquivos de configuração existem
if (!file_exists('../config/database.php')) {
    returnError('Arquivo de configuração do banco não encontrado');
}

if (!file_exists('../config/user-config.php')) {
    returnError('Arquivo de configuração do usuário não encontrado');
}

try {
    // Incluir dependências
    require_once '../config/database.php';
    require_once '../config/user-config.php';
    
    // Verificar se as funções existem
    if (!function_exists('isLoggedIn')) {
        returnError('Função isLoggedIn não encontrada');
    }
    
    if (!function_exists('getCurrentUser')) {
        returnError('Função getCurrentUser não encontrada');
    }
    
    if (!function_exists('fetchOne')) {
        returnError('Função fetchOne não encontrada');
    }
    
    if (!function_exists('fetchData')) {
        returnError('Função fetchData não encontrada');
    }
    
    if (!function_exists('insertData')) {
        returnError('Função insertData não encontrada');
    }
    
    // Verificar login
    if (!isLoggedIn()) {
        returnError('Usuário não logado');
    }

    // Obter dados do POST
    $titulo = trim($_POST['titulo'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $data = trim($_POST['data'] ?? '');
    $hora_inicio = trim($_POST['hora_inicio'] ?? '');
    $hora_fim = trim($_POST['hora_fim'] ?? '');
    $participantes = intval($_POST['participantes'] ?? 1);
    $justificativa = trim($_POST['justificativa'] ?? '');

    // Validações básicas
    if (empty($titulo)) {
        returnError('Título é obrigatório');
    }
    
    if (empty($data)) {
        returnError('Data é obrigatória');
    }
    
    if (empty($hora_inicio)) {
        returnError('Hora de início é obrigatória');
    }
    
    if (empty($hora_fim)) {
        returnError('Hora de fim é obrigatória');
    }
    
    if (empty($justificativa)) {
        returnError('Justificativa é obrigatória');
    }

    // Validar data
    $data_inicio = $data . ' ' . $hora_inicio;
    $data_fim = $data . ' ' . $hora_fim;
    
    if (strtotime($data_inicio) < time()) {
        returnError('Não é possível agendar para datas passadas');
    }
    
    if (strtotime($data_fim) <= strtotime($data_inicio)) {
        returnError('Hora de fim deve ser maior que hora de início');
    }

    // Obter usuário atual
    $user = getCurrentUser();
    if (!$user) {
        returnError('Usuário não encontrado');
    }

    // Obter auditório
    $auditorio = fetchOne("SELECT * FROM auditorios WHERE ativo = 1 LIMIT 1");
    if (!$auditorio) {
        returnError('Nenhum auditório disponível');
    }

    // Obter status pendente
    $status_pendente = fetchOne("SELECT * FROM status_reserva WHERE nome = 'Pendente'");
    if (!$status_pendente) {
        returnError('Status pendente não encontrado');
    }

    // Verificar conflitos
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
        returnError('Já existe uma reserva neste horário');
    }

    // Criar reserva
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

    returnSuccess('Solicitação criada com sucesso', ['id' => $reserva_id]);

} catch (Exception $e) {
    // Log do erro
    error_log('Erro em criar-solicitacao.php: ' . $e->getMessage());
    returnError('Erro interno do servidor');
} catch (Error $e) {
    // Log do erro fatal
    error_log('Erro fatal em criar-solicitacao.php: ' . $e->getMessage());
    returnError('Erro fatal do servidor');
}
?>