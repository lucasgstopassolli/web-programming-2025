<?php

/**
 * Arquivo de Configuração da Aplicação
 *
 * Centraliza as configurações do banco de dados e da aplicação.
 *
 * IMPORTANTE: Preencha as constantes DB_USER e DB_PASS com suas credenciais do PostgreSQL.
 */

// --- Configurações do Banco de Dados PostgreSQL ---

// Host do banco de dados (geralmente 'localhost')
define('DB_HOST', 'localhost');

// Porta do PostgreSQL (padrão é '5432')
define('DB_PORT', '5432');

// Nome do banco de dados que você criou
define('DB_NAME', 'satisfaction_survey');

// ** PREENCHA AQUI: Usuário do banco de dados **
define('DB_USER', 'postgres');

// ** PREENCHA AQUI: Senha do banco de dados **
define('DB_PASS', 'postgres');


// --- Configurações da Aplicação ---

// Título que aparecerá no navegador
define('APP_NAME', 'Avaliação de Satisfação');


// --- Configurações de Ambiente ---

// Habilitar exibição de erros para facilitar a depuração.
// Em um ambiente de produção, isso deve ser definido como '0'.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Define o fuso horário padrão para funções de data e hora
date_default_timezone_set('America/Sao_Paulo');
