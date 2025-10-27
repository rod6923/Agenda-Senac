<?php 
// O header já inicia a sessão, conecta ao DB e busca os dados do usuário
include 'includes/header.php'; 

$stmt = $pdo->prepare("SELECT nome, email, foto_perfil FROM usuarios WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

$foto_atual = $foto_perfil; 
?>

<title>Meu Perfil - Senac Reservas</title>

<h1 class="page-title">Meu Perfil</h1>

<div class="glass-panel" data-tilt data-tilt-max="1">
    <form action="processa_perfil.php" method="post" enctype="multipart/form-data">
        <div class="profile-pic-container">
            <!-- **** ESTRUTURA ALTERADA **** -->
            <!-- O input agora está escondido, e a imagem está dentro de um label -->
            <label for="foto" class="profile-pic-upload-wrapper" title="Clique para alterar a foto">
                <img src="<?php echo $foto_atual; ?>" alt="Foto de Perfil" class="profile-pic-preview">
            </label>
            <input type="file" name="foto" id="foto" accept="image/jpeg, image/png, image/gif">
        </div>

        <div class="glass-form-group">
            <label for="nome">Nome Completo:</label>
            <input type="text" name="nome" id="nome" value="<?php echo htmlspecialchars($usuario['nome']); ?>" required>
        </div>
        
        <div class="glass-form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
        </div>

        <div class="glass-form-group">
            <label for="senha">Nova Senha (deixe em branco para não alterar):</label>
            <input type="password" name="senha" id="senha">
        </div>
        
        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    </form>
</div>

<?php 
// O footer inclui os frameworks e os scripts globais
include 'includes/footer.php'; 
?>