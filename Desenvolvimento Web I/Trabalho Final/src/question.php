<?php

require_once 'db.php';
require_once 'device.php'; // Incluído para buscar o setor do dispositivo

// Busca as perguntas ativas para um dispositivo específico, considerando o setor.
function get_active_questions_for_device($device_id)
{
    $db = getDbConnection();
    
    // 1. Descobrir em qual setor o dispositivo está.
    $device = get_device_by_id($device_id);
    if (!$device || !$device['status']) {
        return []; // Retorna vazio se o dispositivo não for encontrado ou estiver inativo.
    }
    $sector = $device['sector'];

    // 2. Montar a query SQL.
    // A query busca perguntas que satisfaçam uma das seguintes condições:
    // - A pergunta é global (is_global = true)
    // - A pergunta está associada ao setor do dispositivo na tabela `question_sectors`
    // Em ambos os casos, a pergunta também deve estar ativa (status = true).
    $sql = "
        SELECT q.id, q.question_text, q.question_type
        FROM questions q
        LEFT JOIN question_sectors qs ON q.id = qs.question_id
        WHERE 
            q.status = true 
            AND (q.is_global = true OR qs.sector = $1)
        GROUP BY q.id, q.question_text, q.question_type, q.display_order
        ORDER BY q.display_order ASC, q.id ASC
    ";

    $result = pg_query_params($db, $sql, [$sector]);
    return pg_fetch_all($result) ?: [];
}


function get_all_questions()
{
    $db = getDbConnection();
    $sql = "SELECT id, question_text, question_type, display_order, status, is_global FROM questions ORDER BY display_order ASC, id ASC";
    $result = pg_query($db, $sql);
    return pg_fetch_all($result) ?: [];
}

function get_question_by_id($id)
{
    $db = getDbConnection();
    $sql = "SELECT * FROM questions WHERE id = $1";
    $result = pg_query_params($db, $sql, [$id]);
    $question = pg_fetch_assoc($result);

    if ($question) {
        $question['sectors'] = get_sectors_for_question($id);
    }

    return $question;
}

function get_sectors_for_question($question_id)
{
    $db = getDbConnection();
    $sql = "SELECT sector FROM question_sectors WHERE question_id = $1";
    $result = pg_query_params($db, $sql, [$question_id]);
    
    $sectors = [];
    while ($row = pg_fetch_assoc($result)) {
        $sectors[] = $row['sector'];
    }
    return $sectors;
}

function create_question($text, $type, $order, $status, $is_global, $sectors = [])
{
    $db = getDbConnection();
    pg_query($db, "BEGIN");

    $sql_question = "INSERT INTO questions (question_text, question_type, display_order, status, is_global) VALUES ($1, $2, $3, $4, $5) RETURNING id";
    $status_bool = $status ? 'true' : 'false';
    $is_global_bool = $is_global ? 'true' : 'false';
    
    $result_question = pg_query_params($db, $sql_question, [$text, $type, $order, $status_bool, $is_global_bool]);

    if (!$result_question) {
        pg_query($db, "ROLLBACK");
        return false;
    }

    $question_id = pg_fetch_result($result_question, 0, 'id');

    if (!$is_global && !empty($sectors)) {
        $sql_sectors = "INSERT INTO question_sectors (question_id, sector) VALUES ($1, $2)";
        foreach ($sectors as $sector) {
            $result_sector = pg_query_params($db, $sql_sectors, [$question_id, $sector]);
            if (!$result_sector) {
                pg_query($db, "ROLLBACK");
                return false;
            }
        }
    }

    return pg_query($db, "COMMIT");
}

function update_question($id, $text, $type, $order, $status, $is_global, $sectors = [])
{
    // --- DEBUGGING LOG ---
    $log_message = sprintf(
        "Updating question ID %d: is_global = %s, sectors = [%s]",
        $id,
        $is_global ? 'true' : 'false',
        implode(', ', $sectors)
    );
    error_log($log_message);
    // --- END DEBUGGING LOG ---

    $db = getDbConnection();
    pg_query($db, "BEGIN");

    $sql_question = "UPDATE questions SET question_text = $1, question_type = $2, display_order = $3, status = $4, is_global = $5 WHERE id = $6";
    $status_bool = $status ? 'true' : 'false';
    $is_global_bool = $is_global ? 'true' : 'false';

    $result_question = pg_query_params($db, $sql_question, [$text, $type, $order, $status_bool, $is_global_bool, $id]);

    if (!$result_question) {
        pg_query($db, "ROLLBACK");
        return false;
    }

    // Deleta os setores antigos para depois inserir os novos.
    $sql_delete_sectors = "DELETE FROM question_sectors WHERE question_id = $1";
    $result_delete = pg_query_params($db, $sql_delete_sectors, [$id]);

    if (!$result_delete) {
        pg_query($db, "ROLLBACK");
        return false;
    }

    // Se não for global e tiver setores, insere as novas associações.
    if (!$is_global && !empty($sectors)) {
        $sql_insert_sectors = "INSERT INTO question_sectors (question_id, sector) VALUES ($1, $2)";
        foreach ($sectors as $sector) {
            $result_insert = pg_query_params($db, $sql_insert_sectors, [$id, $sector]);
            if (!$result_insert) {
                pg_query($db, "ROLLBACK");
                return false;
            }
        }
    }

    return pg_query($db, "COMMIT");
}

function delete_question($id)
{
    $db = getDbConnection();
    $sql = "DELETE FROM questions WHERE id = $1";
    $result = pg_query_params($db, $sql, [$id]);
    return (bool)$result;
}
