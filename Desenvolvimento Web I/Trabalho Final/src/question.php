<?php

/**
 * Funções para manipulação dos dados das Perguntas (CRUD).
 */

require_once __DIR__ . '/db.php';

/**
 * Busca todas as perguntas ativas no banco de dados para o formulário público.
 * @return array
 */
function get_active_questions(): array
{
    try {
        $pdo = getDbConnection();
        $stmt = $pdo->query("
            SELECT id, question_text, question_type
            FROM questions
            WHERE status = true
            ORDER BY display_order ASC, id ASC
        ");
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log('Erro ao buscar perguntas ativas: ' . $e->getMessage());
        return [];
    }
}

/**
 * Busca TODAS as perguntas (ativas e inativas) para o painel de administração.
 * @return array
 */
function get_all_questions(): array
{
    try {
        $pdo = getDbConnection();
        $stmt = $pdo->query("
            SELECT id, question_text, question_type, display_order, status
            FROM questions
            ORDER BY display_order ASC, id ASC
        ");
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log('Erro ao buscar todas as perguntas: ' . $e->getMessage());
        return [];
    }
}

/**
 * Busca uma única pergunta pelo seu ID.
 * @param int $id
 * @return array|false
 */
function get_question_by_id(int $id)
{
    try {
        $pdo = getDbConnection();
        $stmt = $pdo->prepare("SELECT * FROM questions WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    } catch (PDOException $e) {
        error_log("Erro ao buscar pergunta por ID ($id): " . $e->getMessage());
        return false;
    }
}

/**
 * Cria uma nova pergunta no banco de dados.
 * @param string $text
 * @param string $type
 * @param int $order
 * @param bool $status
 * @return bool
 */
function create_question(string $text, string $type, int $order, bool $status): bool
{
    try {
        $pdo = getDbConnection();
        $stmt = $pdo->prepare(
            "INSERT INTO questions (question_text, question_type, display_order, status) 
             VALUES (:text, :type, :order, :status)"
        );
        return $stmt->execute([
            ':text' => $text,
            ':type' => $type,
            ':order' => $order,
            ':status' => $status,
        ]);
    } catch (PDOException $e) {
        error_log("Erro ao criar pergunta: " . $e->getMessage());
        return false;
    }
}

/**
 * Atualiza uma pergunta existente.
 * @param int $id
 * @param string $text
 * @param string $type
 * @param int $order
 * @param bool $status
 * @return bool
 */
function update_question(int $id, string $text, string $type, int $order, bool $status): bool
{
    try {
        $pdo = getDbConnection();
        $stmt = $pdo->prepare(
            "UPDATE questions 
             SET question_text = :text, question_type = :type, display_order = :order, status = :status 
             WHERE id = :id"
        );
        return $stmt->execute([
            ':id' => $id,
            ':text' => $text,
            ':type' => $type,
            ':order' => $order,
            ':status' => $status,
        ]);
    } catch (PDOException $e) {
        error_log("Erro ao atualizar pergunta ($id): " . $e->getMessage());
        return false;
    }
}

/**
 * Deleta uma pergunta do banco de dados.
 * @param int $id
 * @return bool
 */
function delete_question(int $id): bool
{
    try {
        $pdo = getDbConnection();
        $stmt = $pdo->prepare("DELETE FROM questions WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    } catch (PDOException $e) {
        error_log("Erro ao deletar pergunta ($id): " . $e->getMessage());
        return false;
    }
}
