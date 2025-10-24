<?php
require_once 'config/user-config.php';

$page_title = 'Solicitar Acesso - Sistema de Agendamento SENAC';
$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $matricula = $_POST['matricula'] ?? '';
    $departamento = $_POST['departamento'] ?? '';
    $justificativa = $_POST['justificativa'] ?? '';
    
    if (empty($nome) || empty($email) || empty($matricula) || empty($departamento) || empty($justificativa)) {
        $message = 'Por favor, preencha todos os campos obrigatórios.';
        $message_type = 'error';
    } else {
        try {
            // Verificar se o e-mail já existe
            if (userExists($email)) {
                $message = 'Este e-mail já está cadastrado no sistema.';
                $message_type = 'error';
            } else {
                // Criar solicitação de acesso
                $senha_temporaria = password_hash('temp123', PASSWORD_DEFAULT);
                
                insertData('usuarios', [
                    'nome' => $nome,
                    'email' => $email,
                    'senha' => $senha_temporaria,
                    'matricula' => $matricula,
                    'departamento' => $departamento,
                    'tipo' => 'colaborador',
                    'status' => 'pendente',
                    'ativo' => 0
                ]);
                
                $message = 'Solicitação enviada com sucesso! Aguarde a aprovação do administrador.';
                $message_type = 'success';
            }
        } catch (Exception $e) {
            $message = 'Erro ao enviar solicitação: ' . $e->getMessage();
            $message_type = 'error';
        }
    }
}

$page_content = '
<header class="main-header">
    <h1>Solicitar Acesso</h1>
    <div class="header-controls">
        <a href="index.html" class="btn btn-outline">Voltar ao Início</a>
    </div>
</header>

<div class="request-container">
    <div class="request-form">
        <h2>Solicitação de Acesso ao Sistema</h2>
        <p class="form-description">Preencha os dados abaixo para solicitar acesso ao sistema de agendamento.</p>
        
        <?php if ($message): ?>
        <div class="alert alert-<?php echo $message_type; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
        <?php endif; ?>
        
        <form action="#" method="POST">
            <div class="form-grid">
                <div class="form-group">
                    <label for="nome">Nome Completo *</label>
                    <input type="text" id="nome" name="nome" required>
                </div>
                <div class="form-group">
                    <label for="email">E-mail Institucional *</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="matricula">Matrícula *</label>
                    <input type="text" id="matricula" name="matricula" required>
                </div>
                <div class="form-group">
                    <label for="departamento">Departamento *</label>
                    <select id="departamento" name="departamento" required>
                        <option value="">Selecione o departamento</option>
                        <option value="operacoes">Operações</option>
                        <option value="ti">TI</option>
                        <option value="rh">RH</option>
                        <option value="marketing">Marketing</option>
                        <option value="financeiro">Financeiro</option>
                        <option value="academico">Acadêmico</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label for="justificativa">Justificativa para o Acesso *</label>
                <textarea id="justificativa" name="justificativa" rows="4" placeholder="Explique por que você precisa de acesso ao sistema..." required></textarea>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Enviar Solicitação</button>
                <button type="reset" class="btn btn-outline">Limpar Formulário</button>
            </div>
        </form>
    </div>
    
    <div class="info-box">
        <h3>Como Funciona o Processo</h3>
        <div class="info-content">
            <div class="info-step">
                <div class="step-number">1</div>
                <div class="step-content">
                    <h4>Envie sua Solicitação</h4>
                    <p>Preencha o formulário com seus dados e justificativa.</p>
                </div>
            </div>
            <div class="info-step">
                <div class="step-number">2</div>
                <div class="step-content">
                    <h4>Aguarde a Análise</h4>
                    <p>Seu gerente analisará a solicitação e verificará a necessidade.</p>
                </div>
            </div>
            <div class="info-step">
                <div class="step-number">3</div>
                <div class="step-content">
                    <h4>Receba o Acesso</h4>
                    <p>Se aprovada, você receberá um e-mail com suas credenciais de acesso.</p>
                </div>
            </div>
        </div>
        
        <div class="info-notes">
            <h4>Informações Importantes:</h4>
            <ul>
                <li>O processo de aprovação pode levar até 2 dias úteis</li>
                <li>Você receberá uma senha temporária por e-mail</li>
                <li>É recomendado alterar a senha no primeiro acesso</li>
                <li>Em caso de dúvidas, entre em contato com o administrador</li>
            </ul>
        </div>
    </div>
</div>
';

include 'includes/layout-base.php';
?>
