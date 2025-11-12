<?php

/**
 * Funções para gerar relatórios e estatísticas das avaliações.
 */

require_once __DIR__ . '/db.php';

/**
 * Busca a contagem total de submissões de avaliação.
 * Uma submissão é contada como um conjunto de respostas de um dispositivo em um dado momento.
 * @param string|null $sector Opcional: filtra a contagem por um setor específico.
 * @return int
 */
function get_total_submissions_count(string $sector = null): int
{
    try {
        $pdo = getDbConnection();
        // Esta query é um pouco complexa. Ela conta grupos distintos de avaliações
        // que foram enviadas aproximadamente no mesmo horário pelo mesmo dispositivo.
        // A lógica exata pode ser ajustada conforme a necessidade.
        // Por simplicidade aqui, vamos contar as respostas à primeira pergunta como "uma submissão".
        $sql = "SELECT COUNT(e.id) 
                FROM evaluations e
                JOIN devices d ON e.device_id = d.id
                JOIN questions q ON e.question_id = q.id
                WHERE q.display_order = (SELECT MIN(display_order) FROM questions WHERE status=true)";
        
        if ($sector) {
            $sql .= " AND d.sector = :sector";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':sector' => $sector]);
        } else {
            $stmt = $pdo->query($sql);
        }
        
        return (int) $stmt->fetchColumn();
    } catch (PDOException $e) {
        error_log("Erro ao contar avaliações: " . $e->getMessage());
        return 0;
    }
}

/**
 * Calcula a média de pontuação para cada pergunta de escala.
 * @param string|null $sector Opcional: filtra os dados por um setor específico.
 * @return array
 */
function get_average_scores_per_question(string $sector = null): array
{
    try {
        $pdo = getDbConnection();
        $sql = "SELECT 
                    q.id, 
                    q.question_text, 
                    AVG(e.answer_scale) as average_score, 
                    COUNT(e.id) as total_answers
                FROM evaluations e
                JOIN questions q ON e.question_id = q.id
                JOIN devices d ON e.device_id = d.id
                WHERE e.answer_scale IS NOT NULL";
        
        if ($sector) {
            $sql .= " AND d.sector = :sector";
        }

        $sql .= " GROUP BY q.id, q.question_text ORDER BY q.display_order";

        if ($sector) {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':sector' => $sector]);
        } else {
            $stmt = $pdo->query($sql);
        }

        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Erro ao calcular médias por pergunta: " . $e->getMessage());
        return [];
    }
}

/**
 * Busca todos os feedbacks textuais.
 * @param string|null $sector Opcional: filtra os dados por um setor específico.
 * @return array
 */
function get_text_feedbacks(string $sector = null): array
{
    try {
        $pdo = getDbConnection();
        $sql = "SELECT e.answer_text, e.created_at, d.name as device_name, d.sector
                FROM evaluations e
                JOIN devices d ON e.device_id = d.id
                WHERE e.answer_text IS NOT NULL AND TRIM(e.answer_text) != ''";

        if ($sector) {
            $sql .= " AND d.sector = :sector";
        }

        $sql .= " ORDER BY e.created_at DESC";

        if ($sector) {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':sector' => $sector]);
        } else {
            $stmt = $pdo->query($sql);
        }

        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Erro ao buscar feedbacks textuais: " . $e->getMessage());
        return [];
    }
}

/**
 * Busca uma lista de todos os setores distintos que estão cadastrados nos dispositivos.
 * @return array
 */
function get_all_sectors(): array
{
    try {
        $pdo = getDbConnection();
        $stmt = $pdo->query("SELECT DISTINCT sector FROM devices WHERE status = true ORDER BY sector ASC");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    } catch (PDOException $e) {
        error_log("Erro ao buscar setores: " . $e->getMessage());
        return [];
    }
}
