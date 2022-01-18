<?php

namespace AnexusPHP\Business\Api\Repository;

use AnexusPHP\Business\Api\Entity\ApiModuleConfigEntity;
use AnexusPHP\Core\Database;
use AnexusPHP\Core\Libraries\Pagination\Pagination;

class ApiModuleConfigRepository
{
    /**
     * Retorna um registro do banco pelo id
     * 
     * @param integer|null $id
     * @return ApiModuleConfigEntity
     */
    public static function byId($id, $cls = ApiModuleConfigEntity::class)
    {
        $db = Database::getInstance();
        $cursor = $db->{ApiModuleConfigEntity::TABLE}->find(['_id' => intval($id)], ['limit' => 1]);
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

    /**
     * Retorna todos os registros do banco
     * 
     * @return ApiModuleConfigEntity[]
     */
    public static function all(array $filters = [], $cls = ApiModuleConfigEntity::class)
    {
        $db = Database::getInstance();

        $where = [
            'trash' => false
        ];

        if (isset($filters['module_in']) && is_array($filters['module_in']) && count($filters['module_in']) > 0) {
            $where['api_module_id'] = [
                '$in' => $filters['module_in'],
            ];
        }

        $cursor = $db->{ApiModuleConfigEntity::TABLE}->find(
            $where,
            [
                'sort' => [
                    '_id' => 1,
                ],
            ]
        );
        $cursor->setTypeMap([
            'root' => $cls,
            'document' => $cls,
        ]);

        Database::closeInstance();

        $rows = [];
        foreach ($cursor as $r) {
            $rows[] = $r;
        }

        return $rows;
    }

    /**
     * Retorna todos os registros do banco
     * 
     * @param int $module id do modulo
     * @return ApiModuleConfigEntity[]
     */
    public static function byModule($module, $cls = ApiModuleConfigEntity::class)
    {
        $db = Database::getInstance();

        $where = [
            'trash' => false,
            'api_module_id' => intval($module),
        ];

        $cursor = $db->{ApiModuleConfigEntity::TABLE}->find(
            $where,
            [
                'sort' => [
                    '_id' => 1,
                ],
            ]
        );
        $cursor->setTypeMap([
            'root' => $cls,
            'document' => $cls,
        ]);

        Database::closeInstance();

        $rows = [];
        foreach ($cursor as $r) {
            $rows[] = $r;
        }

        return $rows;
    }

    /**
     * Undocumented function
     *
     * @param integer $module
     * @return ApiModuleConfigEntity
     */
    public static function oneByModule(int $module, $cls = ApiModuleConfigEntity::class)
    {
        $db = Database::getInstance();
        $cursor = $db->{ApiModuleConfigEntity::TABLE}->find(['api_module_id' => intval($module), 'trash' => false], ['limit' => 1]);
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

    /**
     * Retorna os registro do banco com paginacao
     * 
     * @param string $url
     * @param array $filters
     * @param int $currentPg
     * @param string $varPg
     * @param integer $perPg
     * @return Pagination
     */
    public static function allWithPagination($url, $filters = array(), $currentPg, $varPg = 'pg', $perPg = 12, $cls = ApiModuleConfigEntity::class)
    {
        $db = Database::getInstance();

        $where = [
            'trash' => false
        ];

        if (isset($filters['search']) && trim($filters['search']) != '') {
            $where['description'] = [
                '$regex' => $filters['search'],
            ];
        }

        $total = $db->{ApiModuleConfigEntity::TABLE}->count($filters);

        $pagination = new Pagination($total, $perPg, $varPg, $currentPg, $url);

        $cursor = $db->{ApiModuleConfigEntity::TABLE}->find(
            $where,
            [
                'limit' => intval($perPg),
                'sort' => [
                    '_id' => 1,
                ],
                'skip' => $pagination->getOffset(),
            ]
        );
        $cursor->setTypeMap([
            'root' => $cls,
            'document' => $cls,
        ]);

        Database::closeInstance();

        $rows = [];
        foreach ($cursor as $r) {
            $rows[] = $r;
        }

        $pagination->setRows($rows);

        return $pagination;
    }
}
