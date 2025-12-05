<?php

// Host do banco de dados (geralmente 'localhost')
define('DB_HOST', 'localhost');

// Porta do PostgreSQL (padrão é '5432')
define('DB_PORT', '5432');

// Nome do banco de dados que você criou
define('DB_NAME', 'satisfaction_survey');

// Usuário do banco de dados
define('DB_USER', 'postgres');

// Senha do banco de dados
define('DB_PASS', 'postgres');

// Título que aparecerá no navegador
define('APP_NAME', 'Avaliação de Satisfação');

// Habilitar exibição de erros para facilitar a depuração.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Define o fuso horário padrão para funções de data e hora
date_default_timezone_set('America/Sao_Paulo');
