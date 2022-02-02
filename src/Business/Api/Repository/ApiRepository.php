<?php

namespace AnexusPHP\Business\Api\Repository;

use AnexusPHP\Business\Api\Entity\ApiEntity;
use AnexusPHP\Core\Database;
use AnexusPHP\Core\Libraries\Pagination\Pagination;
use PDO;

class ApiRepository
{
    /**
     * Retorna um registro do banco pelo id
     *
     * @param string|null $id
     * @return ApiEntity
     */
    public static function byId($id, $className = ApiEntity::class)
    {
        $db = Database::getInstance();
        $cursor = $db->{ApiEntity::TABLE}->find(['_id' => intval($id)], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => $className,
            'document' => 'array',
        ]);
        Database::closeInstance();
        foreach ($cursor as $r) {
            return $r;
        }
        $className = '\\' . $className;
        return new $className();
    }

    /**
     * Undocumented function
     *
     * @param string $className
     * @return ApiEntity[]
     */
    public static function all($className = ApiEntity::class)
    {
        $db = Database::getInstance();

        $filters['trash'] = false;

        $cursor = $db->{ApiEntity::TABLE}->find(
            $filters,
        );
        $cursor->setTypeMap([
            'root' => $className,
            'document' => 'array',
        ]);

        Database::closeInstance();

        $rows = [];
        foreach ($cursor as $r) {
            $rows[] = $r;
        }

        return $rows;
    }

    /**
     * Retorna os registro do banco com paginacao
     * 
     * @param string $url
     * @param array $filters
     * @param int $currentPg
     * @param string $varPg
     * @param integer $perPg
     * @return Pagination[]
     */
    public static function allWithPagination($url, $filters = [], $currentPg, $varPg = 'pg', $perPg = 12, $className = ApiEntity::class)
    {
        $db = Database::getInstance();

        $where = [
            'trash' => false
        ];

        if (isset($filters['authfast_id']) && trim($filters['authfast_id']) != '') {
            $where['authfast_id'] = intval($filters['authfast_id']);
        }

        if (isset($filters['search']) && trim($filters['search']) != '') {
            $where['name'] = [
                '$regex' => $filters['search'],
            ];
        }

        $total = $db->{ApiEntity::TABLE}->count($where);

        $pagination = new Pagination($total, $perPg, $varPg, $currentPg, $url);

        $cursor = $db->{ApiEntity::TABLE}->find(
            $where,
            [
                'limit' => intval($perPg),
                'sort' => [
                    '_id' => -1
                ],
                'skip' => $pagination->getOffset(),
            ]
        );
        $cursor->setTypeMap([
            'root' => $className,
            'document' => 'array',
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
