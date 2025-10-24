<?php
require_once 'config/user-config.php';
requireLogin();

$page_title = 'Meu Perfil - Sistema de Agendamento SENAC';
$user = getCurrentUser();
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
                <h1>Meu Perfil</h1>
                <div class="header-controls">
                    <button class="btn btn-primary">Salvar Alterações</button>
                    <button class="btn btn-outline">Cancelar</button>
                </div>
            </header>

            <div class="profile-container">
                <!-- Informações Pessoais -->
                <div class="profile-section">
                    <h2>Informações Pessoais</h2>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="nome">Nome Completo</label>
                            <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($user['nome']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="telefone">Telefone</label>
                            <input type="tel" id="telefone" name="telefone" value="<?php echo htmlspecialchars($user['telefone'] ?? ''); ?>">
                        </div>
                        <div class="form-group">
                            <label for="departamento">Departamento</label>
                            <input type="text" id="departamento" name="departamento" value="<?php echo htmlspecialchars($user['departamento'] ?? ''); ?>">
                        </div>
                        <div class="form-group">
                            <label for="matricula">Matrícula</label>
                            <input type="text" id="matricula" name="matricula" value="<?php echo htmlspecialchars($user['matricula'] ?? ''); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="cargo">Cargo</label>
                            <input type="text" id="cargo" name="cargo" value="<?php echo ucfirst($user['tipo']); ?>" readonly>
                        </div>
                    </div>
                </div>

                <!-- Alteração de Senha -->
                <div class="profile-section">
                    <h2>Alteração de Senha</h2>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="senha_atual">Senha Atual</label>
                            <input type="password" id="senha_atual" name="senha_atual">
                        </div>
                        <div class="form-group">
                            <label for="nova_senha">Nova Senha</label>
                            <input type="password" id="nova_senha" name="nova_senha">
                        </div>
                        <div class="form-group">
                            <label for="confirmar_senha">Confirmar Nova Senha</label>
                            <input type="password" id="confirmar_senha" name="confirmar_senha">
                        </div>
                    </div>
                </div>

                <!-- Preferências de Notificação -->
                <div class="profile-section">
                    <h2>Preferências de Notificação</h2>
                    <div class="preferences-grid">
                        <div class="preference-item">
                            <label class="checkbox-label">
                                <input type="checkbox" checked>
                                <span class="checkmark"></span>
                                E-mail de confirmação de reservas
                            </label>
                        </div>
                        <div class="preference-item">
                            <label class="checkbox-label">
                                <input type="checkbox" checked>
                                <span class="checkmark"></span>
                                Lembrete de eventos próximos
                            </label>
                        </div>
                        <div class="preference-item">
                            <label class="checkbox-label">
                                <input type="checkbox">
                                <span class="checkmark"></span>
                                Notificações por SMS
                            </label>
                        </div>
                        <div class="preference-item">
                            <label class="checkbox-label">
                                <input type="checkbox" checked>
                                <span class="checkmark"></span>
                                Atualizações do sistema
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Avatar -->
                <div class="profile-section">
                    <h2>Foto do Perfil</h2>
                    <div class="avatar-upload">
                        <div class="current-avatar">
                            <div class="avatar-container">
                                <img src="<?php echo !empty($user['avatar']) ? htmlspecialchars($user['avatar']) : 'https://via.placeholder.com/120'; ?>" alt="Avatar atual" class="avatar-large">
                                <div class="avatar-edit-overlay">
                                    <input type="file" id="avatar-upload" accept="image/*" style="display: none;">
                                    <label for="avatar-upload" class="edit-icon">
                                        <svg viewBox="0 0 24 24" width="16" height="16">
                                            <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                        </svg>
                                    </label>
                                </div>
                            </div>
                            <p class="upload-info">Clique no ícone de lápis para alterar a foto</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
    document.getElementById('avatar-upload').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append('avatar', file);

        fetch('api/upload-avatar.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Atualizar a imagem na tela
                const img = document.querySelector('.avatar-large');
                img.src = data.avatar_url + '?t=' + new Date().getTime();
                
                // Mostrar mensagem de sucesso
                alert('Avatar atualizado com sucesso!');
            } else {
                alert('Erro: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao fazer upload da imagem');
        });
    });
    </script>
</body>
</html>