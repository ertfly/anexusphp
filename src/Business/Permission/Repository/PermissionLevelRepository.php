<?php

namespace AnexusPHP\Business\Permission\Repository;

use AnexusPHP\Business\App\Entity\AppEntity;
use AnexusPHP\Business\Permission\Entity\PermissionLevelEntity;
use AnexusPHP\Core\Database;
use AnexusPHP\Core\Libraries\Pagination\Pagination;

class PermissionLevelRepository
{
    /**
     * Retorna um registro do banco pelo id
     * 
     * @param integer|null $id
     * @return PermissionLevelEntity
     */
    public static function byId($id)
    {
        $db = Database::getInstance();
        $cursor = $db->{PermissionLevelEntity::TABLE}->find(['_id' => intval($id)], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => PermissionLevelEntity::class,
            'document' => 'array',
        ]);
        Database::closeInstance();
        foreach ($cursor as $r) {
            return $r;
        }
        return new PermissionLevelEntity();
    }

    /**
     * Retorna todos os registros do banco
     * 
     * @return PermissionLevelEntity[]
     */
    public static function all(array $filters = [])
    {
        $db = Database::getInstance();

        $where = [
            'trash' => false,
        ];

        if (isset($filters['app_id']) && trim($filters['app_id']) != '') {
            $where['app_id'] = intval($filters['app_id']);
        }

        $options = [
            'sort' => [
                'level' => 1
            ],
        ];

        $cursor = $db->{PermissionLevelEntity::TABLE}->find(
            $where,
            $options,
        );
        $cursor->setTypeMap([
            'root' => PermissionLevelEntity::class,
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
     * Retorna os registros que tenham o nivel maior ou igual ao especificado
     * 
     * @return PermissionLevelEntity[]
     */
    public static function byLevelEqualOrHigher(int $level, AppEntity $app)
    {
        $db = Database::getInstance();

        $where = [
            'trash' => false,
            'level' => [
                '$gte' => intval($level),
            ],
            'app_id' => $app->getId(),
        ];

        $options = [
            'sort' => [
                'level' => 1,
            ],
        ];

        $cursor = $db->{PermissionLevelEntity::TABLE}->find(
            $where,
            $options,
        );
        $cursor->setTypeMap([
            'root' => PermissionLevelEntity::class,
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
     * Retorna todos um registro pelo level
     * 
     * @param int $level
     * @return PermissionLevelEntity
     */
    public static function byLevel(int $level)
    {
        $db = Database::getInstance();
        $cursor = $db->{PermissionLevelEntity::TABLE}->find(['trash' => false, 'level' => intval($level)], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => PermissionLevelEntity::class,
            'document' => 'array',
        ]);
        Database::closeInstance();
        foreach ($cursor as $r) {
            return $r;
        }
        return new PermissionLevelEntity();
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
    public static function allWithPagination($url, $filters = array(), $currentPg, $varPg = 'pg', $perPg = 12)
    {
        $db = Database::getInstance();

        $where = [
            'trash' => false,
        ];

        if (isset($filters['search']) && trim($filters['search']) != '') {
            $where['name'] = [
                '$regex' => $filters['search'],
            ];
        }

        if (isset($filters['app_id']) && trim($filters['app_id']) != '') {
            $where['app_id'] = intval($filters['app_id']);
        }

        $total = $db->{PermissionLevelEntity::TABLE}->count($filters);

        $pagination = new Pagination($total, $perPg, $varPg, $currentPg, $url);

        $cursor = $db->{PermissionLevelEntity::TABLE}->find(
            $where,
            [
                'limit' => intval($perPg),
                'sort' => [
                    'level' => 1,
                ],
                'skip' => $pagination->getOffset(),
            ]
        );
        $cursor->setTypeMap([
            'root' => PermissionLevelEntity::class,
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
