<?php

/**
 * Funções para manipulação dos dados das Respostas (Avaliações).
 */

require_once __DIR__ . '/db.php';

/**
 * Salva as respostas de uma avaliação no banco de dados.
 *
 * A função utiliza uma transação para garantir que todas as respostas
 * de uma mesma submissão sejam salvas juntas. Se ocorrer um erro em
 * qualquer uma das inserções, todas são desfeitas (rollback).
 *
 * @param int $deviceId O ID do dispositivo que enviou a avaliação.
 * @param array $answers As respostas, no formato ['question_id' => ['scale' => value] ou ['text' => value]].
 * @return bool True se a operação foi bem-sucedida, false caso contrário.
 */
function save_evaluation(int $deviceId, array $answers): bool
{
    // Validação básica para garantir que temos dados para salvar
    if (empty($deviceId) || empty($answers)) {
        return false;
    }

    $pdo = getDbConnection();

    try {
        // Inicia uma transação: ou todas as queries funcionam, ou nenhuma é aplicada.
        $pdo->beginTransaction();

        // Prepara a query de inserção uma única vez para reutilização no loop
        $stmt = $pdo->prepare("
            INSERT INTO evaluations (device_id, question_id, answer_scale, answer_text)
            VALUES (:device_id, :question_id, :answer_scale, :answer_text)
        ");

        foreach ($answers as $questionId => $answer) {
            // Extrai os valores de escala ou texto. Define como null se não existirem.
            $scale = isset($answer['scale']) && $answer['scale'] !== '' ? (int)$answer['scale'] : null;
            $text = $answer['text'] ?? null;

            // Pula a inserção se a resposta estiver completamente vazia 
            // (ex: textarea opcional não preenchido)
            if ($scale === null && ($text === null || trim($text) === '')) {
                continue;
            }

            // Executa a query preparada com os dados da resposta atual
            $stmt->execute([
                ':device_id' => $deviceId,
                ':question_id' => (int)$questionId,
                ':answer_scale' => $scale,
                ':answer_text' => $text,
            ]);
        }

        // Se tudo correu bem, confirma a transação, aplicando as mudanças no banco.
        return $pdo->commit();

    } catch (PDOException $e) {
        // Se algo deu errado, desfaz a transação.
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        
        // Loga o erro para análise posterior
        error_log('Erro ao salvar avaliação: ' . $e->getMessage());
        
        return false;
    }
}
