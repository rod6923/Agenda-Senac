# Sistema de Agendamento SENAC - Versão com Banco de Dados

Sistema completo com MySQL, autenticação real e dados dinâmicos.

## 🚀 Instalação Rápida

### 1. Configurar Banco de Dados

1. **Criar banco de dados MySQL:**
   ```sql
   CREATE DATABASE senacagenda CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

2. **Configurar conexão em `config/database.php`:**
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'senacagenda');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   ```

### 2. Instalar Sistema

1. **Acesse:** `http://localhost/Agenda Senac/install.php`
2. **Aguarde** a instalação automática
3. **Faça login** com as credenciais padrão

### 3. Credenciais Padrão

- **E-mail:** admin@senac.com
- **Senha:** password
- **Tipo:** Gerente

## 📁 Estrutura do Banco de Dados

### Tabelas Principais:

1. **`usuarios`** - Usuários do sistema
   - Gerentes e colaboradores
   - Autenticação e permissões

2. **`auditorios`** - Auditórios e salas
   - Capacidade e equipamentos
   - Status ativo/inativo

3. **`reservas`** - Reservas de auditórios
   - Data, horário, usuário
   - Status e justificativas

4. **`status_reserva`** - Status das reservas
   - Pendente, Aprovada, Rejeitada, etc.

5. **`notificacoes`** - Sistema de notificações
   - Mensagens para usuários

6. **`configuracoes`** - Configurações do sistema
   - Horários, limites, etc.

## 🎯 Funcionalidades Implementadas

### ✅ **Sistema de Autenticação**
- Login com e-mail e senha
- Sessões seguras
- Redirecionamento automático

### ✅ **Controle de Acesso**
- Gerentes: Acesso completo
- Colaboradores: Acesso limitado
- Permissões granulares

### ✅ **Dados Dinâmicos**
- Agenda com reservas reais
- Dashboard com estatísticas
- Colaboradores do banco
- Notificações dinâmicas

### ✅ **Interface Inteligente**
- Sidebar automática por tipo de usuário
- Navegação ativa
- Dados em tempo real

## 🔧 Como Usar

### 1. **Login**
- Acesse `login.php`
- Use as credenciais padrão
- Sistema redireciona automaticamente

### 2. **Como Gerente**
- Dashboard com estatísticas reais
- Agenda com reservas do banco
- Gestão de colaboradores
- Aprovação de solicitações

### 3. **Como Colaborador**
- Visualizar agenda
- Gerenciar próprias reservas
- Perfil pessoal

## 📊 Dados de Exemplo

O sistema inclui dados de exemplo:

- **4 Auditórios** configurados
- **5 Usuários** (1 gerente + 4 colaboradores)
- **4 Reservas** de exemplo
- **4 Notificações** de exemplo
- **Configurações** do sistema

## 🔐 Segurança

- Senhas criptografadas com `password_hash()`
- Proteção contra SQL injection
- Validação de entrada
- Sessões seguras

## 🎨 Interface

- Design glassmorphism mantido
- Responsivo e moderno
- Navegação intuitiva
- Dados em tempo real

## 📝 Próximos Passos

1. **Personalizar** configurações do sistema
2. **Adicionar** mais auditórios
3. **Configurar** notificações por e-mail
4. **Implementar** relatórios avançados
5. **Adicionar** backup automático

## 🚨 Solução de Problemas

### Erro de Conexão com Banco
- Verifique as credenciais em `config/database.php`
- Confirme se o MySQL está rodando
- Verifique se o banco `senacagenda` existe

### Página em Branco
- Verifique se o PHP está configurado
- Confirme se as extensões PDO estão ativas
- Verifique os logs de erro do PHP

### Estilo Não Carrega
- Confirme se o arquivo `css/agenda.css` existe
- Verifique as permissões dos arquivos
- Limpe o cache do navegador

## ✅ Status do Projeto

- [x] Banco de dados MySQL
- [x] Sistema de autenticação
- [x] Dados dinâmicos
- [x] Interface responsiva
- [x] Controle de acesso
- [x] Dados de exemplo
- [x] Instalação automática

**O sistema está 100% funcional com banco de dados!** 🚀

## 📞 Suporte

- **Instalação:** Execute `install.php`
- **Login:** Use `admin@senac.com` / `password`
- **Documentação:** Consulte `ajuda.php`
- **Configuração:** Edite `config/database.php`
