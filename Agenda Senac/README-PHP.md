# Sistema de Agendamento SENAC - Versão PHP

Sistema modularizado com PHP para separação de funcionalidades entre Gerente e Colaborador.

## 📁 Estrutura do Projeto PHP

```
Agenda Senac/
├── config/
│   └── user-config.php          # Configuração de usuários e permissões
├── includes/
│   ├── layout-base.php          # Layout base com sidebar dinâmica
│   ├── sidebar-gerente.php      # Sidebar para gerentes
│   └── sidebar-colaborador.php  # Sidebar para colaboradores
├── agenda.php                   # Agenda do gerente
├── minhas-solicitacoes.php      # Aprovação de solicitações
├── agenda-colaborador.php       # Agenda do colaborador
├── minhas-reservas.php          # Reservas do colaborador
├── exemplo-permissoes.php       # Demonstração do sistema
└── README-PHP.md               # Este arquivo
```

## 🔧 Configuração do Sistema

### 1. Definir Tipo de Usuário

Edite o arquivo `config/user-config.php`:

```php
// Para Gerente (acesso completo)
$user_type = 'gerente';

// Para Colaborador (acesso limitado)
$user_type = 'colaborador';
```

### 2. Permissões Disponíveis

**Gerente:**
- ✅ Visualizar agenda completa
- ✅ Aprovar/rejeitar solicitações
- ✅ Gerenciar colaboradores
- ✅ Visualizar relatórios
- ✅ Configurações do sistema
- ✅ Notificações
- ✅ Ajuda

**Colaborador:**
- ✅ Visualizar agenda (somente disponibilidade)
- ✅ Visualizar próprias reservas
- ✅ Visualizar perfil
- ✅ Ajuda
- ❌ Aprovar solicitações
- ❌ Gerenciar colaboradores
- ❌ Relatórios
- ❌ Configurações do sistema

## 🎯 Como Usar

### 1. Criar Nova Página

```php
<?php
$page_title = 'Título da Página';
$page_content = '
<header class="main-header">
    <h1>Conteúdo da Página</h1>
</header>
<!-- Seu conteúdo aqui -->
';

include 'includes/layout-base.php';
?>
```

### 2. Verificar Permissões

```php
<?php
require_once 'config/user-config.php';

if (hasPermission('approve_requests')) {
    echo "Usuário pode aprovar solicitações";
} else {
    echo "Usuário não tem permissão";
}
?>
```

### 3. Alterar Tipo de Usuário Dinamicamente

```php
<?php
// No início da página
$user_type = 'colaborador'; // ou 'gerente'
$page_title = 'Minha Página';
$page_content = '...';

include 'includes/layout-base.php';
?>
```

## 🔄 Sidebars Dinâmicas

### Sidebar do Gerente
- **Operações**: Agenda, Aprovação de Solicitações
- **Geral**: Colaboradores, Relatórios, Notificações, Configurações, Ajuda
- **Perfil**: Link para perfil do gerente

### Sidebar do Colaborador
- **Navegação**: Ver Agenda, Minhas Reservas
- **Perfil**: Meu Perfil, Ajuda
- **Perfil**: Link para perfil do colaborador

## 🎨 Funcionalidades Implementadas

### Para Gerentes:
1. **agenda.php** - Agenda completa com todas as funcionalidades
2. **minhas-solicitacoes.php** - Sistema de aprovação/rejeição com modal
3. **Sidebar completa** - Acesso a todas as funcionalidades

### Para Colaboradores:
1. **agenda-colaborador.php** - Visualização simplificada da agenda
2. **minhas-reservas.php** - Gestão das próprias reservas
3. **Sidebar simplificada** - Apenas funcionalidades necessárias

## 🚀 Vantagens do Sistema PHP

1. **Modularização**: Sidebars reutilizáveis
2. **Controle de Acesso**: Sistema de permissões robusto
3. **Manutenibilidade**: Fácil de atualizar e modificar
4. **Escalabilidade**: Fácil adicionar novos tipos de usuário
5. **Consistência**: Layout padronizado em todas as páginas

## 📝 Próximos Passos

1. **Autenticação**: Implementar sistema de login
2. **Banco de Dados**: Conectar com MySQL/PostgreSQL
3. **Sessões**: Gerenciar sessões de usuário
4. **API**: Criar endpoints para operações CRUD
5. **Segurança**: Implementar validação e sanitização

## 🔧 Configuração do Servidor

Certifique-se de que o PHP está configurado e funcionando:

```bash
# Verificar versão do PHP
php --version

# Iniciar servidor local
php -S localhost:8000
```

## 📞 Suporte

Para dúvidas ou problemas:
1. Verifique o arquivo `exemplo-permissoes.php`
2. Consulte os comentários no código
3. Teste as permissões com diferentes tipos de usuário
