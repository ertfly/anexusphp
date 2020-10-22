<?php

namespace AnexusPHP\Business\Api\Repository;

use AnexusPHP\Business\Api\Entity\ApiEntity;
use AnexusPHP\Core\Database;

class ApiRepository
{
    /**
     * Retorna um registro do banco pelo id
     *
     * @param string|null $id
     * @return ApiEntity
     */
    public static function byId(?string $id)
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . ApiEntity::TABLE . ' where id = :id limit 1', ['id' => $id])->fetchObject(ApiEntity::class);
        if ($reg === false) {
            return new ApiEntity();
        }

        return $reg;
    }
}
