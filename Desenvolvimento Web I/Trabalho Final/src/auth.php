<?php

/**
 * Funções para autenticação e gerenciamento de sessão
 * para o painel administrativo.
 */

require_once __DIR__ . '/db.php';

/**
 * Inicia a sessão de forma segura, se ainda não houver uma ativa.
 */
function start_secure_session(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        // Configurações de segurança para o cookie da sessão
        session_set_cookie_params([
            'lifetime' => 0, // A sessão dura até o navegador ser fechado
            'path' => '/',
            'domain' => '', // Em produção, defina seu domínio ex: 'meusite.com'
            'secure' => isset($_SERVER['HTTPS']), // Enviar cookie apenas em HTTPS
            'httponly' => true, // Previne acesso ao cookie via JavaScript
            'samesite' => 'Lax' // Mitigação contra ataques CSRF
        ]);
        session_start();
    }
}

/**
 * Verifica se o usuário está autenticado na sessão.
 *
 * @return bool True se o usuário está logado, false caso contrário.
 */
function is_logged_in(): bool
{
    start_secure_session();
    // A autenticação é confirmada pela existência da variável de sessão 'user_id'
    return isset($_SESSION['user_id']);
}

/**
 * Exige que o usuário esteja logado para acessar a página.
 * Se não estiver, redireciona para a página de login (`admin.php`).
 */
function require_login(): void
{
    if (!is_logged_in()) {
        header('Location: admin.php');
        exit;
    }
}

/**
 * Tenta realizar o login do usuário com as credenciais fornecidas.
 *
 * @param string $username O nome de usuário.
 * @param string $password A senha em texto plano.
 * @return bool True em caso de sucesso no login, false em caso de falha.
 */
function login(string $username, string $password): bool
{
    try {
        $pdo = getDbConnection();
        $stmt = $pdo->prepare("SELECT id, username, password FROM admin_users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch();

        // Verifica se o usuário foi encontrado e se a senha fornecida corresponde ao hash salvo
        if ($user && password_verify($password, $user['password'])) {
            start_secure_session();
            
            // Renova o ID da sessão para previnir ataques de fixação de sessão
            session_regenerate_id(true);
            
            // Armazena os dados do usuário na sessão para uso futuro
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            
            return true;
        }

        return false; // Usuário ou senha incorretos

    } catch (PDOException $e) {
        error_log('Erro no processo de login: ' . $e->getMessage());
        return false;
    }
}

/**
 * Realiza o logout do usuário, destruindo a sessão.
 */
function logout(): void
{
    start_secure_session();

    // Limpa todas as variáveis da sessão
    $_SESSION = [];

    // Destrói o cookie da sessão no navegador
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Finalmente, destrói a sessão no servidor
    session_destroy();

    // Redireciona para a página de login
    header('Location: admin.php');
    exit;
}
