-- Script SQL para criar o banco de dados do Sistema de Agendamento SENAC
-- Execute este script no MySQL para criar todas as tabelas necessárias

-- Criar banco de dados
CREATE DATABASE IF NOT EXISTS senacagenda CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE senacagenda;

-- Tabela de usuários
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    matricula VARCHAR(50) UNIQUE,
    departamento VARCHAR(100),
    telefone VARCHAR(20),
    avatar VARCHAR(255) NULL,
    tipo ENUM('gerente', 'colaborador') NOT NULL DEFAULT 'colaborador',
    status ENUM('ativo', 'inativo', 'pendente') NOT NULL DEFAULT 'pendente',
    ativo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabela de auditórios
CREATE TABLE auditorios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT,
    capacidade INT NOT NULL,
    equipamentos TEXT,
    ativo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de status de reserva
CREATE TABLE status_reserva (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cor VARCHAR(7) DEFAULT '#007bff',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de reservas
CREATE TABLE reservas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT,
    usuario_id INT NOT NULL,
    auditorio_id INT NOT NULL,
    data_inicio DATETIME NOT NULL,
    data_fim DATETIME NOT NULL,
    participantes INT DEFAULT 1,
    status_id INT NOT NULL,
    justificativa TEXT,
    observacoes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (auditorio_id) REFERENCES auditorios(id) ON DELETE CASCADE,
    FOREIGN KEY (status_id) REFERENCES status_reserva(id)
);

-- Tabela de notificações
CREATE TABLE notificacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    mensagem TEXT NOT NULL,
    tipo ENUM('info', 'success', 'warning', 'error') DEFAULT 'info',
    lida BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Tabela de configurações do sistema
CREATE TABLE configuracoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    chave VARCHAR(100) UNIQUE NOT NULL,
    valor TEXT,
    descricao TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Inserir dados iniciais

-- Status de reserva
INSERT INTO status_reserva (nome, cor) VALUES
('Pendente', '#ffc107'),
('Aprovada', '#28a745'),
('Rejeitada', '#dc3545'),
('Cancelada', '#6c757d'),
('Concluída', '#17a2b8');

-- Auditórios
INSERT INTO auditorios (nome, descricao, capacidade, equipamentos) VALUES
('Auditório Principal', 'Auditório principal com capacidade para 200 pessoas', 200, 'Projetor, Som, Ar condicionado, Palco');

-- Usuário administrador padrão
INSERT INTO usuarios (nome, email, senha, matricula, departamento, tipo, status, ativo) VALUES
('Administrador', 'admin@senac.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '00000', 'TI', 'gerente', 'ativo', TRUE);

-- Configurações do sistema
INSERT INTO configuracoes (chave, valor, descricao) VALUES
('sistema_nome', 'SENAC Agendamentos', 'Nome do sistema'),
('horario_funcionamento_inicio', '08:00', 'Horário de início do funcionamento'),
('horario_funcionamento_fim', '18:00', 'Horário de fim do funcionamento'),
('tempo_maximo_reserva', '4', 'Tempo máximo de reserva em horas'),
('antecedencia_minima', '24', 'Antecedência mínima em horas'),
('notificacoes_email', '1', 'Habilitar notificações por email'),
('notificacoes_sms', '0', 'Habilitar notificações por SMS');

-- Inserir alguns usuários de exemplo
INSERT INTO usuarios (nome, email, senha, matricula, departamento, tipo, status, ativo) VALUES
('Ana Silva', 'ana.silva@senac.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '12345', 'Operações', 'colaborador', 'ativo', TRUE),
('Carlos Pereira', 'carlos.pereira@senac.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '67890', 'TI', 'colaborador', 'ativo', TRUE),
('Mariana Santos', 'mariana.santos@senac.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '54321', 'RH', 'colaborador', 'ativo', TRUE),
('Roberto Lima', 'roberto.lima@senac.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '98765', 'Marketing', 'colaborador', 'ativo', TRUE);

-- Inserir algumas reservas de exemplo
INSERT INTO reservas (titulo, descricao, usuario_id, auditorio_id, data_inicio, data_fim, participantes, status_id, justificativa) VALUES
('Palestra de Abertura', 'Evento de abertura do semestre', 2, 1, '2024-05-15 09:00:00', '2024-05-15 12:00:00', 150, 2, 'Necessário para evento de abertura do semestre'),
('Workshop de Inovação', 'Capacitação em metodologias ágeis', 3, 1, '2024-05-20 14:00:00', '2024-05-20 18:00:00', 30, 1, 'Workshop para capacitação da equipe'),
('Reunião de Equipe', 'Reunião semanal da equipe', 4, 2, '2024-05-10 10:00:00', '2024-05-10 11:00:00', 15, 2, 'Reunião semanal de alinhamento'),
('Treinamento Técnico', 'Treinamento em novas tecnologias', 5, 1, '2024-05-25 08:00:00', '2024-05-25 17:00:00', 25, 1, 'Treinamento necessário para a equipe de desenvolvimento');

-- Inserir algumas notificações de exemplo
INSERT INTO notificacoes (usuario_id, titulo, mensagem, tipo) VALUES
(1, 'Nova Solicitação', 'Carlos Pereira solicitou acesso ao sistema', 'info'),
(1, 'Reserva Aprovada', 'Sua reserva para "Palestra de Abertura" foi aprovada', 'success'),
(2, 'Lembrete de Evento', 'Você tem um evento agendado em 30 minutos', 'warning'),
(3, 'Sistema Atualizado', 'Nova versão 2.1.0 disponível', 'info');

-- Criar índices para melhor performance
CREATE INDEX idx_reservas_usuario ON reservas(usuario_id);
CREATE INDEX idx_reservas_auditorio ON reservas(auditorio_id);
CREATE INDEX idx_reservas_data ON reservas(data_inicio);
CREATE INDEX idx_notificacoes_usuario ON notificacoes(usuario_id);
CREATE INDEX idx_usuarios_email ON usuarios(email);
CREATE INDEX idx_usuarios_tipo ON usuarios(tipo);
CREATE INDEX idx_usuarios_status ON usuarios(status);
