<?php

namespace AnexusPHP\Business\Api\Repository;

use AnexusPHP\Business\Api\Entity\ApiModuleEntity;
use AnexusPHP\Core\Database;

class ApiModuleRepository
{
    /**
     * Retorna um registro do banco pelo id
     * 
     * @param integer|null $id
     * @return ApiModuleEntity
     */
    public static function byId($id, $cls = ApiModuleEntity::class)
    {
        $db = Database::getInstance();
        $cursor = $db->{ApiModuleEntity::TABLE}->find(['_id' => intval($id)], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => $cls,
            'document' => $cls,
        ]);
        Database::closeInstance();
        foreach ($cursor as $r) {
            return $r;
        }
        $cls = '\\' . $cls;
        return new $cls();
    }
}
