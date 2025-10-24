<?php require_once 'config/user-config.php'; ?>
<!-- BARRA LATERAL DO COLABORADOR -->
<aside class="sidebar">
    <div class="sidebar-header">
        <h2 class="logo">SENAC Agenda</h2>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-section">
                <a href="agenda-unificada.php" class="nav-item <?php echo getNavClass('agenda-unificada'); ?>">
                <svg class="nav-icon" viewBox="0 0 24 24"><path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20a2 2 0 002 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zM9 14H7v-2h2v2zm4 0h-2v-2h2v2zm4 0h-2v-2h2v2z"/></svg>
                <span>Ver Agenda</span>
            </a>
            <a href="minhas-reservas.php" class="nav-item <?php echo getNavClass('minhas-reservas'); ?>">
                <svg class="nav-icon" viewBox="0 0 24 24"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg>
                <span>Minhas Reservas</span>
            </a>
        </div>
        <div class="nav-section">
            <p class="section-title">PERFIL</p>
            <a href="perfil.php" class="nav-item <?php echo getNavClass('perfil'); ?>">
                <svg class="nav-icon" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                <span>Meu Perfil</span>
            </a>
            <a href="ajuda.php" class="nav-item <?php echo getNavClass('ajuda'); ?>">
                <svg class="nav-icon" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H8c0-2.21 1.79-4 4-4s4 1.79 4 4c0 .88-.36 1.68-.93 2.25z"/></svg>
                <span>Ajuda</span>
            </a>
        </div>
    </nav>
        <div class="sidebar-footer">
            <a href="perfil.php" class="nav-item user-profile <?php echo getNavClass('perfil'); ?>">
                <?php $user = getCurrentUser(); ?>
                <img src="<?php echo !empty($user['avatar']) ? htmlspecialchars($user['avatar']) : 'https://via.placeholder.com/40'; ?>" alt="Avatar do Usuário" class="user-avatar">
                <span><?php echo getDisplayName(); ?></span>
            </a>
            <a href="logout.php" class="nav-item logout-btn">
                <svg class="nav-icon" viewBox="0 0 24 24"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/></svg>
                <span>Sair</span>
            </a>
        </div>
</aside>
