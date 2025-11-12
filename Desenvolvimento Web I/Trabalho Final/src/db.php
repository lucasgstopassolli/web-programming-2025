<?php

/**
 * Gerencia a conexão com o banco de dados usando PDO.
 */

// Inclui as configurações do banco de dados uma única vez
require_once __DIR__ . '/../config.php';

/**
 * @var PDO|null A instância única da conexão PDO (Singleton).
 */
$pdo = null;

/**
 * Obtém a instância da conexão PDO com o banco de dados PostgreSQL.
 *
 * Esta função utiliza o padrão Singleton para garantir que apenas uma conexão
 * seja criada por requisição, melhorando a performance.
 *
 * @return PDO A instância do objeto PDO.
 */
function getDbConnection(): PDO
{
    global $pdo;

    // Se a conexão ainda não foi estabelecida, cria uma nova.
    if ($pdo === null) {
        // DSN (Data Source Name) para a conexão com o PostgreSQL
        $dsn = sprintf('pgsql:host=%s;port=%s;dbname=%s', DB_HOST, DB_PORT, DB_NAME);

        try {
            // Tenta criar a instância do PDO
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                // Configurações do PDO para um ambiente de desenvolvimento robusto
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lança exceções em caso de erro
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Retorna resultados como arrays associativos
                PDO::ATTR_EMULATE_PREPARES   => false,                  // Usa prepared statements nativos do DB
            ]);
        } catch (PDOException $e) {
            // Em caso de falha na conexão, loga o erro e exibe uma mensagem genérica.
            // Isso evita expor detalhes sensíveis da configuração em um ambiente de produção.
            error_log('Erro de conexão com o banco de dados: ' . $e->getMessage());
            
            // Interrompe a execução com uma mensagem amigável
            die('Não foi possível conectar ao banco de dados. Verifique as configurações em `config.php` e se o serviço do PostgreSQL está em execução.');
        }
    }

    return $pdo;
}
