<?php

require_once 'db.php';

// Salva as respostas de uma avaliação no banco de dados.
function save_evaluation($deviceId, $answers)
{
    if (empty($deviceId) || empty($answers)) {
        return false;
    }

    $db = getDbConnection();

    // Inicia uma transação.
    pg_query($db, "BEGIN");

    $sql = "INSERT INTO evaluations (device_id, question_id, answer_scale, answer_text) VALUES ($1, $2, $3, $4)";

    foreach ($answers as $questionId => $answer) {
        $scale = isset($answer['scale']) && $answer['scale'] !== '' ? (int)$answer['scale'] : null;
        $text = isset($answer['text']) ? $answer['text'] : null;

        if ($scale === null && ($text === null || trim($text) === '')) {
            continue;
        }

        $params = [(int)$deviceId, (int)$questionId, $scale, $text];
        $result = pg_query_params($db, $sql, $params);

        // Se uma das inserções falhar, desfaz a transação e retorna erro.
        if (!$result) {
            pg_query($db, "ROLLBACK");
            error_log("Erro ao salvar avaliação: " . pg_last_error($db));
            return false;
        }
    }

    // Se tudo correu bem, confirma a transação.
    return pg_query($db, "COMMIT");
}