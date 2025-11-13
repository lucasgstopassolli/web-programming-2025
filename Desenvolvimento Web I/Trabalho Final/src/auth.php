<?php

require_once 'db.php';

// Verifica se o usuário está logado.
function is_logged_in()
{
    // A sessão deve ser iniciada no script que chama esta função.
    return isset($_SESSION['user_id']);
}

// Exige que o usuário esteja logado para acessar a página.
function require_login()
{
    // Inicia a sessão se ainda não foi iniciada.
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (!is_logged_in()) {
        header('Location: admin.php');
        exit;
    }
}

// Tenta realizar o login do usuário.
function login($username, $password)
{
    $db = getDbConnection();
    $sql = "SELECT id, username, password FROM admin_users WHERE username = $1";
    
    $result = pg_query_params($db, $sql, [$username]);

    if ($result) {
        $user = pg_fetch_assoc($result);

        // Verifica se o usuário foi encontrado e se a senha corresponde ao hash.
        if ($user && password_verify($password, $user['password'])) {
            // Inicia a sessão se ainda não foi iniciada.
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            
            // Armazena os dados do usuário na sessão.
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            
            return true;
        }
    }

    return false; // Usuário ou senha incorretos.
}

// Realiza o logout do usuário.
function logout()
{
    // Inicia a sessão se ainda não foi iniciada.
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Limpa todas as variáveis da sessão.
    $_SESSION = [];

    // Destrói a sessão.
    session_destroy();

    // Redireciona para a página de login.
    header('Location: admin.php');
    exit;
}