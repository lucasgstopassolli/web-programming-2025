<?php

require_once 'db.php';

function get_all_devices()
{
    $db = getDbConnection();
    $sql = "SELECT id, name, sector, status FROM devices ORDER BY sector ASC, name ASC";
    $result = pg_query($db, $sql);
    return pg_fetch_all($result) ?: [];
}

function get_device_by_id($id)
{
    $db = getDbConnection();
    $sql = "SELECT * FROM devices WHERE id = $1";
    $result = pg_query_params($db, $sql, [$id]);
    return pg_fetch_assoc($result);
}

function create_device($name, $sector, $status)
{
    $db = getDbConnection();
    $sql = "INSERT INTO devices (name, sector, status) VALUES ($1, $2, $3)";
    $status_bool = $status ? 'true' : 'false';
    $result = pg_query_params($db, $sql, [$name, $sector, $status_bool]);
    return (bool)$result;
}

function update_device($id, $name, $sector, $status)
{
    $db = getDbConnection();
    $sql = "UPDATE devices SET name = $1, sector = $2, status = $3 WHERE id = $4";
    $status_bool = $status ? 'true' : 'false';
    $result = pg_query_params($db, $sql, [$name, $sector, $status_bool, $id]);
    return (bool)$result;
}

function delete_device($id)
{
    $db = getDbConnection();
    $sql = "DELETE FROM devices WHERE id = $1";
    $result = pg_query_params($db, $sql, [$id]);
    return (bool)$result;
}

// Busca uma lista de todos os setores distintos que estão cadastrados nos dispositivos.
function get_all_sectors()
{
    $db = getDbConnection();
    $sql = "SELECT DISTINCT sector FROM devices WHERE status = true ORDER BY sector ASC";
    $result = pg_query($db, $sql);
    // pg_fetch_all com PDO::FETCH_COLUMN não existe, então fazemos manualmente
    $sectors = [];
    while ($row = pg_fetch_assoc($result)) {
        $sectors[] = $row['sector'];
    }
    return $sectors;
}