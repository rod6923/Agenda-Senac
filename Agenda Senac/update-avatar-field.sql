-- Script para adicionar campo avatar na tabela usuarios
-- Execute este script se a tabela já existir

USE senacagenda;

-- Adicionar campo avatar se não existir
ALTER TABLE usuarios ADD COLUMN IF NOT EXISTS avatar VARCHAR(255) NULL AFTER telefone;
