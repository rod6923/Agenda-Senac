<?php
// Configuração do Banco de Dados
define('DB_HOST', 'localhost');
define('DB_NAME', 'senacagenda');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Conexão com o banco de dados
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET,
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $e) {
    // Log do erro e retornar erro JSON se for uma requisição AJAX
    error_log("Erro na conexão com o banco de dados: " . $e->getMessage());
    
    // Se for uma requisição AJAX, retornar JSON
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Erro de conexão com o banco de dados']);
        exit;
    }
    
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}

// Função para executar queries
function executeQuery($sql, $params = []) {
    global $pdo;
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    } catch (PDOException $e) {
        die("Erro na execução da query: " . $e->getMessage());
    }
}

// Função para buscar dados
function fetchData($sql, $params = []) {
    $stmt = executeQuery($sql, $params);
    return $stmt->fetchAll();
}

// Função para buscar um registro
function fetchOne($sql, $params = []) {
    $stmt = executeQuery($sql, $params);
    return $stmt->fetch();
}

// Função para inserir dados
function insertData($table, $data) {
    $columns = implode(',', array_keys($data));
    $placeholders = ':' . implode(', :', array_keys($data));
    $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
    executeQuery($sql, $data);
    return getLastInsertId();
}

// Função para atualizar dados
function updateData($table, $data, $where, $whereParams = []) {
    $setClause = [];
    foreach ($data as $key => $value) {
        $setClause[] = "{$key} = :{$key}";
    }
    $setClause = implode(', ', $setClause);
    $sql = "UPDATE {$table} SET {$setClause} WHERE {$where}";
    $params = array_merge($data, $whereParams);
    executeQuery($sql, $params);
}

// Função para deletar dados
function deleteData($table, $where, $params = []) {
    $sql = "DELETE FROM {$table} WHERE {$where}";
    executeQuery($sql, $params);
}

// Função para obter último ID inserido
function getLastInsertId() {
    global $pdo;
    return $pdo->lastInsertId();
}

// Função para verificar se usuário existe
function userExists($email) {
    $sql = "SELECT id FROM usuarios WHERE email = :email";
    $user = fetchOne($sql, ['email' => $email]);
    return $user !== false;
}

// Função para autenticar usuário
function authenticateUser($email, $password) {
    $sql = "SELECT * FROM usuarios WHERE email = :email AND ativo = 1";
    $user = fetchOne($sql, ['email' => $email]);
    
    if ($user && password_verify($password, $user['senha'])) {
        return $user;
    }
    return false;
}


// Função para obter reservas do usuário
function getUserReservations($userId) {
    $sql = "SELECT r.*, a.nome as auditorio_nome, s.nome as status_nome 
            FROM reservas r 
            LEFT JOIN auditorios a ON r.auditorio_id = a.id 
            LEFT JOIN status_reserva s ON r.status_id = s.id 
            WHERE r.usuario_id = :user_id 
            ORDER BY r.data_inicio DESC";
    return fetchData($sql, ['user_id' => $userId]);
}

// Função para obter todas as reservas (gerente)
function getAllReservations() {
    $sql = "SELECT r.*, u.nome as usuario_nome, a.nome as auditorio_nome, s.nome as status_nome 
            FROM reservas r 
            LEFT JOIN usuarios u ON r.usuario_id = u.id 
            LEFT JOIN auditorios a ON r.auditorio_id = a.id 
            LEFT JOIN status_reserva s ON r.status_id = s.id 
            ORDER BY r.data_inicio DESC";
    return fetchData($sql);
}

// Função para obter solicitações pendentes
function getPendingRequests() {
    $sql = "SELECT * FROM usuarios WHERE status = 'pendente' ORDER BY created_at DESC";
    return fetchData($sql);
}

// Função para obter colaboradores ativos
function getActiveCollaborators() {
    $sql = "SELECT * FROM usuarios WHERE tipo = 'colaborador' AND ativo = 1 ORDER BY nome ASC";
    return fetchData($sql);
}

// Função para obter estatísticas do dashboard
function getDashboardStats() {
    $stats = [];
    
    // Total de reservas hoje
    $sql = "SELECT COUNT(*) as total FROM reservas WHERE DATE(data_inicio) = CURDATE()";
    $stats['reservas_hoje'] = fetchOne($sql)['total'];
    
    // Total de reservas este mês
    $sql = "SELECT COUNT(*) as total FROM reservas WHERE MONTH(data_inicio) = MONTH(CURDATE()) AND YEAR(data_inicio) = YEAR(CURDATE())";
    $stats['reservas_mes'] = fetchOne($sql)['total'];
    
    // Total de colaboradores ativos
    $sql = "SELECT COUNT(*) as total FROM usuarios WHERE tipo = 'colaborador' AND ativo = 1";
    $stats['colaboradores_ativos'] = fetchOne($sql)['total'];
    
    // Total de solicitações pendentes
    $sql = "SELECT COUNT(*) as total FROM usuarios WHERE status = 'pendente'";
    $stats['solicitacoes_pendentes'] = fetchOne($sql)['total'];
    
    return $stats;
}
?>
