<?php
require_once 'config/user-config.php';

// Se já estiver logado, redirecionar
if (isLoggedIn()) {
    $user = getCurrentUser();
    if ($user['tipo'] === 'gerente') {
        header('Location: dashboard.php');
    } else {
        header('Location: agenda-colaborador.php');
    }
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $error = 'Por favor, preencha todos os campos.';
    } else {
        $user = authenticateUser($email, $password);
        
        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_type'] = $user['tipo'];
            $_SESSION['user_name'] = $user['nome'];
            
            // Redirecionar baseado no tipo de usuário
            if ($user['tipo'] === 'gerente') {
                header('Location: dashboard.php');
            } else {
                header('Location: agenda-colaborador.php');
            }
            exit;
        } else {
            $error = 'E-mail ou senha incorretos.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Agendamento SENAC</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h1>SENAC Agendamentos</h1>
                <p>Faça login para acessar o sistema</p>
            </div>
            
            <?php if ($error): ?>
                <div class="alert alert-error">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" class="login-form">
                <div class="form-group">
                    <label for="email">E-mail Institucional</label>
                    <input type="email" id="email" name="email" required 
                           value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="password">Senha</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" class="btn btn-primary btn-full">Entrar</button>
            </form>
            
            <div class="login-footer">
                <p>Não tem uma conta? <a href="solicitar-acesso.php">Solicite acesso</a></p>
                <p><a href="index.html">Voltar ao início</a></p>
            </div>
        </div>
        
        <div class="login-info">
            <h2>Bem-vindo ao Sistema de Agendamento</h2>
            <p>Gerencie reservas de auditórios e salas de forma eficiente e organizada.</p>
            
            <div class="features">
                <div class="feature">
                    <svg viewBox="0 0 24 24"><path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20a2 2 0 002 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10z"/></svg>
                    <span>Agenda Inteligente</span>
                </div>
                <div class="feature">
                    <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                    <span>Gestão de Colaboradores</span>
                </div>
                <div class="feature">
                    <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg>
                    <span>Relatórios Detalhados</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
