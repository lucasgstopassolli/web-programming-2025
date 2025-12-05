<?php

require_once 'db.php';

function is_logged_in()
{
    return isset($_SESSION['user_id']);
}

function require_login()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (!is_logged_in()) {
        header('Location: admin.php');
        exit;
    }
}

function login($username, $password)
{
    $db = getDbConnection();
    $sql = "SELECT id, username, password FROM admin_users WHERE username = $1";
    
    $result = pg_query_params($db, $sql, [$username]);

    if ($result) {
        $user = pg_fetch_assoc($result);

        if ($user && password_verify($password, $user['password'])) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            
            return true;
        }
    }

    return false;
}

function logout()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $_SESSION = [];
    session_destroy();

    header('Location: admin.php');
    exit;
}