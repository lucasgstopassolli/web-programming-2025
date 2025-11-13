<?php

require_once 'db.php';

// Busca todas as perguntas ativas para o formulário público.
function get_active_questions()
{
    $db = getDbConnection();
    $sql = "SELECT id, question_text, question_type FROM questions WHERE status = true ORDER BY display_order ASC, id ASC";
    $result = pg_query($db, $sql);
    return pg_fetch_all($result) ?: [];
}

// Busca todas as perguntas (ativas e inativas) para o painel de administração.
function get_all_questions()
{
    $db = getDbConnection();
    $sql = "SELECT id, question_text, question_type, display_order, status FROM questions ORDER BY display_order ASC, id ASC";
    $result = pg_query($db, $sql);
    return pg_fetch_all($result) ?: [];
}

// Busca uma única pergunta pelo seu ID.
function get_question_by_id($id)
{
    $db = getDbConnection();
    $sql = "SELECT * FROM questions WHERE id = $1";
    $result = pg_query_params($db, $sql, [$id]);
    return pg_fetch_assoc($result);
}

// Cria uma nova pergunta no banco de dados.
function create_question($text, $type, $order, $status)
{
    $db = getDbConnection();
    $sql = "INSERT INTO questions (question_text, question_type, display_order, status) VALUES ($1, $2, $3, $4)";
    $status_bool = $status ? 'true' : 'false';
    $result = pg_query_params($db, $sql, [$text, $type, $order, $status_bool]);
    return (bool)$result;
}

// Atualiza uma pergunta existente.
function update_question($id, $text, $type, $order, $status)
{
    $db = getDbConnection();
    $sql = "UPDATE questions SET question_text = $1, question_type = $2, display_order = $3, status = $4 WHERE id = $5";
    $status_bool = $status ? 'true' : 'false';
    $result = pg_query_params($db, $sql, [$text, $type, $order, $status_bool, $id]);
    return (bool)$result;
}

// Deleta uma pergunta do banco de dados.
function delete_question($id)
{
    $db = getDbConnection();
    $sql = "DELETE FROM questions WHERE id = $1";
    $result = pg_query_params($db, $sql, [$id]);
    return (bool)$result;
}