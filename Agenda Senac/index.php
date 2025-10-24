<?php
// Arquivo para alternar rapidamente entre tipos de usuário
// Altere o valor abaixo para testar diferentes interfaces

$user_type = 'gerente'; // Opções: 'gerente' ou 'colaborador'

// Redirecionamento baseado no tipo de usuário
if ($user_type === 'gerente') {
    header('Location: dashboard.php');
} else {
    header('Location: agenda-colaborador.php');
}
exit;
?>
