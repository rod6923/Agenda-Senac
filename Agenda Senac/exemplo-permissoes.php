<?php
require_once 'config/user-config.php';

// Exemplo de uso das permissões
echo "<h2>Sistema de Permissões - " . getUserName() . "</h2>";

echo "<h3>Permissões Disponíveis:</h3>";
echo "<ul>";
if (hasPermission('view_agenda')) {
    echo "<li>✅ Pode visualizar agenda</li>";
} else {
    echo "<li>❌ Não pode visualizar agenda</li>";
}

if (hasPermission('approve_requests')) {
    echo "<li>✅ Pode aprovar solicitações</li>";
} else {
    echo "<li>❌ Não pode aprovar solicitações</li>";
}

if (hasPermission('manage_collaborators')) {
    echo "<li>✅ Pode gerenciar colaboradores</li>";
} else {
    echo "<li>❌ Não pode gerenciar colaboradores</li>";
}

if (hasPermission('view_reports')) {
    echo "<li>✅ Pode visualizar relatórios</li>";
} else {
    echo "<li>❌ Não pode visualizar relatórios</li>";
}

if (hasPermission('system_settings')) {
    echo "<li>✅ Pode acessar configurações do sistema</li>";
} else {
    echo "<li>❌ Não pode acessar configurações do sistema</li>";
}

if (hasPermission('view_own_reservations')) {
    echo "<li>✅ Pode visualizar próprias reservas</li>";
} else {
    echo "<li>❌ Não pode visualizar próprias reservas</li>";
}

if (hasPermission('view_profile')) {
    echo "<li>✅ Pode visualizar perfil</li>";
} else {
    echo "<li>❌ Não pode visualizar perfil</li>";
}

if (hasPermission('view_help')) {
    echo "<li>✅ Pode acessar ajuda</li>";
} else {
    echo "<li>❌ Não pode acessar ajuda</li>";
}
echo "</ul>";

echo "<h3>Sidebar Atual:</h3>";
echo "<p>Arquivo da sidebar: " . getSidebarPath() . "</p>";

echo "<h3>Como Alterar o Tipo de Usuário:</h3>";
echo "<p>Para alterar o tipo de usuário, edite o arquivo <code>config/user-config.php</code> e modifique a variável <code>\$user_type</code>:</p>";
echo "<ul>";
echo "<li><code>\$user_type = 'gerente';</code> - Para acesso completo</li>";
echo "<li><code>\$user_type = 'colaborador';</code> - Para acesso limitado</li>";
echo "</ul>";

echo "<h3>Páginas Disponíveis:</h3>";
echo "<ul>";
echo "<li><a href='agenda.php'>agenda.php</a> - Agenda do gerente</li>";
echo "<li><a href='minhas-solicitacoes.php'>minhas-solicitacoes.php</a> - Aprovação de solicitações</li>";
echo "<li><a href='agenda-colaborador.php'>agenda-colaborador.php</a> - Agenda do colaborador</li>";
echo "<li><a href='minhas-reservas.php'>minhas-reservas.php</a> - Reservas do colaborador</li>";
echo "</ul>";
?>
