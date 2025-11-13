-- Arquivo de Setup do Banco de Dados - PostgreSQL

-- Remove tabelas existentes para garantir um ambiente limpo.
-- A ordem é importante por causa das chaves estrangeiras.
DROP TABLE IF EXISTS evaluations;
DROP TABLE IF EXISTS admin_users;
DROP TABLE IF EXISTS questions;
DROP TABLE IF EXISTS devices;

-- Tabela para armazenar as perguntas da avaliação
CREATE TABLE questions (
    id SERIAL PRIMARY KEY,
    question_text TEXT NOT NULL,
    -- Tipos de pergunta: 'scale' para escala numérica, 'open' para texto livre
    question_type VARCHAR(20) NOT NULL DEFAULT 'scale',
    display_order INT NOT NULL DEFAULT 0,
    -- Status: true para ativa, false para inativa
    status BOOLEAN NOT NULL DEFAULT true
);

-- Tabela para armazenar os dispositivos (tablets) e seus setores
CREATE TABLE devices (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    sector VARCHAR(255) NOT NULL,
    -- Status: true para ativo, false para inativo
    status BOOLEAN NOT NULL DEFAULT true
);

-- Tabela para armazenar os usuários administrativos
CREATE TABLE admin_users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(255) UNIQUE NOT NULL,
    -- A senha será armazenada como um hash seguro
    password VARCHAR(255) NOT NULL
);

-- Tabela para armazenar as respostas das avaliações
CREATE TABLE evaluations (
    id SERIAL PRIMARY KEY,
    device_id INT NOT NULL REFERENCES devices(id) ON DELETE CASCADE,
    question_id INT NOT NULL REFERENCES questions(id) ON DELETE CASCADE,
    -- Resposta em escala (ex: 0-10), nula para perguntas de texto
    answer_scale INT,
    -- Resposta em texto, nula para perguntas de escala
    answer_text TEXT,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);


-- Inserir algumas perguntas de exemplo
INSERT INTO questions (question_text, display_order) VALUES ('Qual a probabilidade de você nos recomendar a um amigo ou familiar?', 1);
INSERT INTO questions (question_text, display_order) VALUES ('Como você avalia a limpeza de nosso estabelecimento?', 2);
INSERT INTO questions (question_text, display_order) VALUES ('Como você avalia a cordialidade de nossos atendentes?', 3);
INSERT INTO questions (question_text, question_type, display_order) VALUES ('Deixe seu feedback, críticas ou sugestões.', 'open', 4);

-- Inserir um dispositivo de exemplo
INSERT INTO devices (name, sector) VALUES ('Tablet Recepção 01', 'Recepção');

