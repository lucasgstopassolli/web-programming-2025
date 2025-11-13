<?php

require_once 'db.php';

// Busca todos os dispositivos.
function get_all_devices()
{
    $db = getDbConnection();
    $sql = "SELECT id, name, sector, status FROM devices ORDER BY sector ASC, name ASC";
    $result = pg_query($db, $sql);
    return pg_fetch_all($result) ?: [];
}

// Busca um único dispositivo pelo seu ID.
function get_device_by_id($id)
{
    $db = getDbConnection();
    $sql = "SELECT * FROM devices WHERE id = $1";
    $result = pg_query_params($db, $sql, [$id]);
    return pg_fetch_assoc($result);
}

// Cria um novo dispositivo no banco de dados.
function create_device($name, $sector, $status)
{
    $db = getDbConnection();
    $sql = "INSERT INTO devices (name, sector, status) VALUES ($1, $2, $3)";
    // O status vem como 'on' ou não vem. Convertemos para booleano.
    $status_bool = $status ? 'true' : 'false';
    $result = pg_query_params($db, $sql, [$name, $sector, $status_bool]);
    return (bool)$result;
}

// Atualiza um dispositivo existente.
function update_device($id, $name, $sector, $status)
{
    $db = getDbConnection();
    $sql = "UPDATE devices SET name = $1, sector = $2, status = $3 WHERE id = $4";
    $status_bool = $status ? 'true' : 'false';
    $result = pg_query_params($db, $sql, [$name, $sector, $status_bool, $id]);
    return (bool)$result;
}

// Deleta um dispositivo do banco de dados.
function delete_device($id)
{
    $db = getDbConnection();
    $sql = "DELETE FROM devices WHERE id = $1";
    $result = pg_query_params($db, $sql, [$id]);
    return (bool)$result;
}