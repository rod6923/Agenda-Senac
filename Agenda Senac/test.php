<?php
// Teste para verificar se não há mais conflitos de funções
require_once 'config/database.php';
require_once 'config/user-config.php';

echo "✅ Teste de carregamento bem-sucedido!<br>";
echo "Banco de dados: " . DB_NAME . "<br>";
echo "Host: " . DB_HOST . "<br>";

// Testar se as funções estão funcionando
if (function_exists('getCurrentUser')) {
    echo "✅ Função getCurrentUser() disponível<br>";
} else {
    echo "❌ Função getCurrentUser() não encontrada<br>";
}

if (function_exists('hasPermission')) {
    echo "✅ Função hasPermission() disponível<br>";
} else {
    echo "❌ Função hasPermission() não encontrada<br>";
}

if (function_exists('fetchData')) {
    echo "✅ Função fetchData() disponível<br>";
} else {
    echo "❌ Função fetchData() não encontrada<br>";
}

echo "<br><a href='login.php'>Ir para Login</a>";
?>
