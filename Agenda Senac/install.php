<?php
// Script para instalar o banco de dados
// Execute este arquivo para criar o banco e inserir dados iniciais

require_once 'config/database.php';

echo "<h1>Instalação do Banco de Dados - Sistema de Agendamento SENAC</h1>";

try {
    // Ler o arquivo SQL
    $sql = file_get_contents('database.sql');
    
    // Dividir em comandos individuais
    $commands = explode(';', $sql);
    
    $success_count = 0;
    $error_count = 0;
    
    foreach ($commands as $command) {
        $command = trim($command);
        if (empty($command)) continue;
        
        try {
            executeQuery($command);
            $success_count++;
            echo "<p style='color: green;'>✓ Comando executado com sucesso</p>";
        } catch (Exception $e) {
            $error_count++;
            echo "<p style='color: red;'>✗ Erro: " . $e->getMessage() . "</p>";
        }
    }
    
    echo "<h2>Resumo da Instalação</h2>";
    echo "<p><strong>Comandos executados com sucesso:</strong> $success_count</p>";
    echo "<p><strong>Erros encontrados:</strong> $error_count</p>";
    
    if ($error_count == 0) {
    echo "<h2 style='color: green;'>✅ Instalação concluída com sucesso!</h2>";
    echo "<h3>Banco de Dados:</h3>";
    echo "<p><strong>Nome:</strong> senacagenda</p>";
    echo "<p><strong>Host:</strong> localhost</p>";
    echo "<h3>Credenciais de Acesso:</h3>";
    echo "<p><strong>E-mail:</strong> admin@senac.com</p>";
    echo "<p><strong>Senha:</strong> password</p>";
    echo "<p><strong>Tipo:</strong> Gerente</p>";
    echo "<p><a href='login.php'>Fazer Login</a></p>";
    } else {
        echo "<h2 style='color: red;'>❌ Instalação concluída com erros</h2>";
        echo "<p>Verifique os erros acima e execute novamente se necessário.</p>";
    }
    
} catch (Exception $e) {
    echo "<h2 style='color: red;'>❌ Erro na instalação</h2>";
    echo "<p>Erro: " . $e->getMessage() . "</p>";
}
?>
