
-- Remove tabelas existentes para garantir um ambiente limpo.
DROP TABLE IF EXISTS evaluations;
DROP TABLE IF EXISTS admin_users;
DROP TABLE IF EXISTS question_sectors; -- Adicionado para limpeza
DROP TABLE IF EXISTS questions;
DROP TABLE IF EXISTS devices;

-- Tabela para armazenar as perguntas da avaliação
CREATE TABLE questions (
    id SERIAL PRIMARY KEY,
    question_text TEXT NOT NULL,
    question_type VARCHAR(20) NOT NULL DEFAULT 'scale',
    display_order INT NOT NULL DEFAULT 0,
    status BOOLEAN NOT NULL DEFAULT true,
    is_global BOOLEAN NOT NULL DEFAULT false
);

-- Tabela para armazenar os dispositivos (tablets) e seus setores
CREATE TABLE devices (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    sector VARCHAR(255) NOT NULL,
    status BOOLEAN NOT NULL DEFAULT true
);

-- Tabela de associação para perguntas e setores (N-para-N)
CREATE TABLE question_sectors (
    question_id INT NOT NULL REFERENCES questions(id) ON DELETE CASCADE,
    sector VARCHAR(255) NOT NULL,
    PRIMARY KEY (question_id, sector)
);

-- Tabela para armazenar os usuários administrativos
CREATE TABLE admin_users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Tabela para armazenar as respostas das avaliações
CREATE TABLE evaluations (
    id SERIAL PRIMARY KEY,
    device_id INT NOT NULL REFERENCES devices(id) ON DELETE CASCADE,
    question_id INT NOT NULL REFERENCES questions(id) ON DELETE CASCADE,
    answer_scale INT,
    answer_text TEXT,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);
