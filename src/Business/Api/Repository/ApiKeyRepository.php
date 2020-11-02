<?php

namespace AnexusPHP\Business\Api\Repository;

use AnexusPHP\Business\Api\Entity\ApiEntity;
use AnexusPHP\Business\Api\Entity\ApiKeyEntity;
use AnexusPHP\Core\Database;
use PDO;

class ApiKeyRepository
{
    /**
     * Retorna um registro do banco pelo id
     *
     * @param string|null $id
     * @return ApiKeyEntity
     */
    public static function byId(?string $id)
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . ApiKeyEntity::TABLE . ' where id = :id limit 1', ['id' => $id])->fetchObject(ApiKeyEntity::class);
        if ($reg === false) {
            return new ApiKeyEntity();
        }

        return $reg;
    }

    /**
     * Retorna todos os registros do banco
     *
     * @return ApiKeyEntity[]
     */
    public static function all()
    {
        $db = Database::getInstance();
        $regs = $db->query('select * from ' . ApiKeyEntity::TABLE . ' order by id asc')->fetchAll(PDO::FETCH_CLASS, ApiKeyEntity::class);

        return $regs;
    }


    /**
     * Retorna todos os registros do banco por aplicativo
     *
     * @param ApiEntity $application
     * @return ApiKeyEntity[]
     */
    public static function allByApplication(ApiEntity $application)
    {
        $db = Database::getInstance();
        $regs = $db->query('select * from ' . ApiKeyEntity::TABLE . ' where api_id = :api_id order by id asc', ['api_id' => (int)$application])->fetchAll(PDO::FETCH_CLASS, ApiKeyEntity::class);

        return $regs;
    }
}
