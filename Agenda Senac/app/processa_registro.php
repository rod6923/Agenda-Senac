<?php
require 'config/db.php';

// Prepara a resposta padrão
$response = [
    'status' => 'error',
    'message' => 'Ocorreu um erro desconhecido.'
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $cargo = $_POST['cargo'];
        
        $sql = "INSERT INTO usuarios (nome, email, senha, cargo, status) VALUES (?, ?, ?, ?, 'pendente')";
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute([$nome, $email, $senha, $cargo])) {
            $id_novo_usuario = $pdo->lastInsertId();
            
            // Notificação para gerentes (lógica mantida)
            $sql_gerentes = "SELECT id FROM usuarios WHERE cargo = 'gerente'";
            $stmt_gerentes = $pdo->query($sql_gerentes);
            while ($gerente = $stmt_gerentes->fetch(PDO::FETCH_ASSOC)) {
                $id_gerente = $gerente['id'];
                $mensagem = "Novo cadastro pendente: " . htmlspecialchars($nome);
                $sql_notificacao = "INSERT INTO notificacoes (id_usuario_destino, tipo, id_referencia, mensagem) VALUES (?, 'novo_cadastro', ?, ?)";
                $pdo->prepare($sql_notificacao)->execute([$id_gerente, $id_novo_usuario, $mensagem]);
            }

            // Define a resposta de sucesso
            $response['status'] = 'success';
            $response['message'] = 'Cadastro enviado com sucesso! Aguarde a aprovação de um gerente.';
        } else {
            $response['message'] = 'Erro ao executar a inserção no banco de dados.';
        }
    } catch (PDOException $e) {
        // Captura erros, como email duplicado
        if ($e->errorInfo[1] == 1062) {
            $response['message'] = 'Este endereço de e-mail já está cadastrado.';
        } else {
            $response['message'] = 'Erro no banco de dados: ' . $e->getMessage();
        }
    }
}

// Define o cabeçalho como JSON e envia a resposta
header('Content-Type: application/json');
echo json_encode($response);
exit();
?>