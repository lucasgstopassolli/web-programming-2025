<?php

require_once 'db.php';

// Busca a contagem total de submissões de avaliação.
function get_total_submissions_count($sector = null)
{
    $db = getDbConnection();
    $sql = "SELECT COUNT(e.id) 
            FROM evaluations e
            JOIN devices d ON e.device_id = d.id
            JOIN questions q ON e.question_id = q.id
            WHERE q.display_order = (SELECT MIN(display_order) FROM questions WHERE status=true)";
    
    $params = [];
    if ($sector) {
        $sql .= " AND d.sector = $1";
        $params[] = $sector;
    }
    
    $result = pg_query_params($db, $sql, $params);
    return (int) pg_fetch_result($result, 0, 0);
}

// Calcula a média de pontuação para cada pergunta de escala.
function get_average_scores_per_question($sector = null)
{
    $db = getDbConnection();
    $sql = "SELECT 
                q.id, 
                q.question_text, 
                AVG(e.answer_scale) as average_score, 
                COUNT(e.id) as total_answers
            FROM evaluations e
            JOIN questions q ON e.question_id = q.id
            JOIN devices d ON e.device_id = d.id
            WHERE e.answer_scale IS NOT NULL";
    
    $params = [];
    if ($sector) {
        $sql .= " AND d.sector = $1";
        $params[] = $sector;
    }

    $sql .= " GROUP BY q.id, q.question_text ORDER BY q.display_order";

    $result = pg_query_params($db, $sql, $params);
    return pg_fetch_all($result) ?: [];
}

// Busca todos os feedbacks textuais.
function get_text_feedbacks($sector = null)
{
    $db = getDbConnection();
    $sql = "SELECT e.answer_text, e.created_at, d.name as device_name, d.sector
            FROM evaluations e
            JOIN devices d ON e.device_id = d.id
            WHERE e.answer_text IS NOT NULL AND TRIM(e.answer_text) != ''";

    $params = [];
    if ($sector) {
        $sql .= " AND d.sector = $1";
        $params[] = $sector;
    }

    $sql .= " ORDER BY e.created_at DESC";

    $result = pg_query_params($db, $sql, $params);
    return pg_fetch_all($result) ?: [];
}