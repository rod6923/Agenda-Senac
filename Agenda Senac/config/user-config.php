<?php
// Iniciar sessão se não estiver iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Incluir configuração do banco de dados
require_once 'database.php';

// Função para verificar se usuário está logado
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

// Função para obter dados do usuário logado
function getCurrentUser() {
    if (!isLoggedIn()) {
        return false;
    }
    
    $sql = "SELECT * FROM usuarios WHERE id = :id";
    return fetchOne($sql, ['id' => $_SESSION['user_id']]);
}

// Função para verificar permissões
function hasPermission($permission) {
    $user = getCurrentUser();
    if (!$user) return false;
    
    $userType = $user['tipo'];
    $permissions = [
        'gerente' => [
            'view_agenda' => true,
            'approve_requests' => true,
            'manage_collaborators' => true,
            'view_reports' => true,
            'manage_notifications' => true,
            'system_settings' => true,
            'view_help' => true,
            'view_profile' => true
        ],
        'colaborador' => [
            'view_agenda' => true,
            'view_own_reservations' => true,
            'view_profile' => true,
            'view_help' => true,
            'approve_requests' => false,
            'manage_collaborators' => false,
            'view_reports' => false,
            'manage_notifications' => false,
            'system_settings' => false
        ]
    ];
    
    return isset($permissions[$userType][$permission]) && $permissions[$userType][$permission];
}

// Função para obter o nome do usuário
function getUserName() {
    $user = getCurrentUser();
    return $user ? $user['nome'] : 'Usuário';
}

// Função para obter o nome de exibição
function getDisplayName() {
    $user = getCurrentUser();
    return $user ? $user['nome'] : 'Usuário';
}

// Função para obter o caminho da sidebar
function getSidebarPath() {
    $user = getCurrentUser();
    if (!$user) return 'includes/sidebar-colaborador.php';
    
    return $user['tipo'] === 'gerente' ? 'includes/sidebar-gerente.php' : 'includes/sidebar-colaborador.php';
}

// Função para verificar se é gerente
function isManager() {
    $user = getCurrentUser();
    return $user && $user['tipo'] === 'gerente';
}

// Função para verificar se é colaborador
function isCollaborator() {
    $user = getCurrentUser();
    return $user && $user['tipo'] === 'colaborador';
}

// Função para obter a classe ativa da navegação
function getNavClass($page) {
    $current_page = basename($_SERVER['PHP_SELF'], '.php');
    return ($current_page === $page) ? 'active' : '';
}

// Função para redirecionar se não estiver logado
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

// Função para redirecionar se não for gerente
function requireManager() {
    requireLogin();
    if (!isManager()) {
        header('Location: agenda-colaborador.php');
        exit;
    }
}

// Função para fazer logout
function logout() {
    session_destroy();
    header('Location: login.php');
    exit;
}
?>
