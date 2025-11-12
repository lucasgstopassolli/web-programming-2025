<?php

/**
 * Funções para manipulação dos dados de Dispositivos (CRUD).
 */

require_once __DIR__ . '/db.php';

/**
 * Busca todos os dispositivos (ativos e inativos) para o painel de administração.
 * @return array
 */
function get_all_devices(): array
{
    try {
        $pdo = getDbConnection();
        $stmt = $pdo->query("
            SELECT id, name, sector, status
            FROM devices
            ORDER BY sector ASC, name ASC
        ");
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log('Erro ao buscar todos os dispositivos: ' . $e->getMessage());
        return [];
    }
}

/**
 * Busca um único dispositivo pelo seu ID.
 * @param int $id
 * @return array|false
 */
function get_device_by_id(int $id)
{
    try {
        $pdo = getDbConnection();
        $stmt = $pdo->prepare("SELECT * FROM devices WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    } catch (PDOException $e) {
        error_log("Erro ao buscar dispositivo por ID ($id): " . $e->getMessage());
        return false;
    }
}

/**
 * Cria um novo dispositivo no banco de dados.
 * @param string $name
 * @param string $sector
 * @param bool $status
 * @return bool
 */
function create_device(string $name, string $sector, bool $status): bool
{
    try {
        $pdo = getDbConnection();
        $stmt = $pdo->prepare(
            "INSERT INTO devices (name, sector, status) 
             VALUES (:name, :sector, :status)"
        );
        return $stmt->execute([
            ':name' => $name,
            ':sector' => $sector,
            ':status' => $status,
        ]);
    } catch (PDOException $e) {
        error_log("Erro ao criar dispositivo: " . $e->getMessage());
        return false;
    }
}

/**
 * Atualiza um dispositivo existente.
 * @param int $id
 * @param string $name
 * @param string $sector
 * @param bool $status
 * @return bool
 */
function update_device(int $id, string $name, string $sector, bool $status): bool
{
    try {
        $pdo = getDbConnection();
        $stmt = $pdo->prepare(
            "UPDATE devices 
             SET name = :name, sector = :sector, status = :status 
             WHERE id = :id"
        );
        return $stmt->execute([
            ':id' => $id,
            ':name' => $name,
            ':sector' => $sector,
            ':status' => $status,
        ]);
    } catch (PDOException $e) {
        error_log("Erro ao atualizar dispositivo ($id): " . $e->getMessage());
        return false;
    }
}

/**
 * Deleta um dispositivo do banco de dados.
 * @param int $id
 * @return bool
 */
function delete_device(int $id): bool
{
    try {
        $pdo = getDbConnection();
        $stmt = $pdo->prepare("DELETE FROM devices WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    } catch (PDOException $e) {
        error_log("Erro ao deletar dispositivo ($id): " . $e->getMessage());
        return false;
    }
}
