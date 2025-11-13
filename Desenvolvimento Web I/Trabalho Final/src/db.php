<?php

// Inclui as configurações do banco de dados.
require_once '../config.php';

// Variável global para a conexão com o banco de dados.
$db_connection = null;

// Obtém a conexão com o banco de dados PostgreSQL.
function getDbConnection()
{
    global $db_connection;

    // Se a conexão ainda não foi estabelecida, cria uma nova.
    if ($db_connection === null) {
        $connection_string = sprintf(
            "host=%s port=%s dbname=%s user=%s password=%s",
            DB_HOST,
            DB_PORT,
            DB_NAME,
            DB_USER,
            DB_PASS
        );

        // Tenta conectar ao banco de dados.
        $db_connection = pg_connect($connection_string);

        if (!$db_connection) {
            // Interrompe a execução com uma mensagem de erro.
            die('Não foi possível conectar ao banco de dados PostgreSQL.');
        }
    }

    return $db_connection;
}