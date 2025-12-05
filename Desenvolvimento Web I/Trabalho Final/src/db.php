<?php

require_once __DIR__ . '/../config.php';

$db_connection = null;

function getDbConnection()
{
    global $db_connection;

    if ($db_connection === null) {
        $connection_string = sprintf(
            "host=%s port=%s dbname=%s user=%s password=%s",
            DB_HOST,
            DB_PORT,
            DB_NAME,
            DB_USER,
            DB_PASS
        );

        $db_connection = pg_connect($connection_string);

        if (!$db_connection) {
            die('Não foi possível conectar ao banco de dados PostgreSQL.');
        }
    }

    return $db_connection;
}