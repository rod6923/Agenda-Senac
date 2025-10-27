<?php
// Definições do banco de dados
define('DB_HOST', 'localhost');
define('DB_USER', 'root'); // Substitua pelo seu usuário
define('DB_PASS', '');     // Substitua pela sua senha
define('DB_NAME', 'senac_reservas');

// Tenta estabelecer a conexão usando PDO (mais seguro)
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    // Define o modo de erro do PDO para exceção
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Garante que os caracteres sejam UTF-8
    $pdo->exec("SET NAMES 'utf8'");
} catch(PDOException $e) {
    // Se a conexão falhar, exibe uma mensagem de erro e encerra o script
    die("ERRO: Não foi possível conectar ao banco de dados. " . $e->getMessage());
}
?>