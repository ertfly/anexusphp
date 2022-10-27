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
            'document' => 'array',
        ]);
        Database::closeInstance();
        foreach ($cursor as $r) {
            return $r;
        }
        $cls = '\\' . $cls;
        return new $cls();
    }

    /**
     * Undocumented function
     *
     * @param array $filters
     * @param string $cls
     * @return ApiModuleEntity[]
     */
    public static function all(array $filters = [], $cls = ApiModuleEntity::class)
    {
        $db = Database::getInstance();

        $where = [];

        $cursor = $db->{ApiModuleEntity::TABLE}->find(
            $where,
            [
                'sort' => [
                    'description' => 1,
                ],
            ]
        );
        $cursor->setTypeMap([
            'root' => $cls,
            'document' => 'array',
        ]);

        Database::closeInstance();

        $rows = [];
        foreach ($cursor as $r) {
            $rows[] = $r;
        }

        return $rows;
    }
}