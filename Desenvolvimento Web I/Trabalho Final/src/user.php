<?php

require_once 'db.php';

function get_all_users()
{
    $db = getDbConnection();
    $sql = "SELECT id, username FROM admin_users ORDER BY username ASC";
    $result = pg_query($db, $sql);
    return pg_fetch_all($result) ?: [];
}

function get_user_by_id($id)
{
    $db = getDbConnection();
    $sql = "SELECT id, username FROM admin_users WHERE id = $1";
    $result = pg_query_params($db, $sql, [$id]);
    return pg_fetch_assoc($result);
}

function create_user($username, $password)
{
    if (empty($password)) {
        return false;
    }
    $db = getDbConnection();
    $sql = "INSERT INTO admin_users (username, password) VALUES ($1, $2)";
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $result = pg_query_params($db, $sql, [$username, $hashed_password]);
    return (bool)$result;
}

function update_user($id, $username, $password)
{
    $db = getDbConnection();
    
    if (!empty($password)) {
        $sql = "UPDATE admin_users SET username = $1, password = $2 WHERE id = $3";
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $result = pg_query_params($db, $sql, [$username, $hashed_password, $id]);
    } else {
        $sql = "UPDATE admin_users SET username = $1 WHERE id = $2";
        $result = pg_query_params($db, $sql, [$username, $id]);
    }
    
    return (bool)$result;
}

function delete_user($id)
{
    $db = getDbConnection();

    $count_result = pg_query($db, "SELECT COUNT(id) FROM admin_users");
    $count = (int) pg_fetch_result($count_result, 0, 0);
    if ($count <= 1) {
        return false;
    }

    $sql = "DELETE FROM admin_users WHERE id = $1";
    $result = pg_query_params($db, $sql, [$id]);
    return (bool)$result;
}