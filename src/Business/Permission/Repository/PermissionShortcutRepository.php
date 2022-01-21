<?php

namespace AnexusPHP\Business\Permission\Repository;

use AnexusPHP\Business\Authfast\Entity\AuthfastEntity;
use AnexusPHP\Business\Authfast\Repository\AuthfastShortcutRepository;
use AnexusPHP\Business\Permission\Entity\PermissionShortcutEntity;
use AnexusPHP\Core\Database;
use AnexusPHP\Core\Libraries\Pagination\Pagination;
use PDO;

class PermissionShortcutRepository
{

    /**
     * Retorna um registro do banco pelo id
     * 
     * @param integer|null $id
     * @return PermissionShortcutEntity
     */
    public static function byId($id)
    {
        $db = Database::getInstance();
        $cursor = $db->{PermissionShortcutEntity::TABLE}->find(['_id' => intval($id)], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => PermissionShortcutEntity::class,
            'document' => 'array',
        ]);
        Database::closeInstance();
        foreach ($cursor as $r) {
            return $r;
        }
        return new PermissionShortcutEntity();
    }

    public static function getLastPosition()
    {
        $db = Database::getInstance();
        $cursor = $db->{PermissionShortcutEntity::TABLE}->find([], ['sort' => ['position' => -1], 'limit' => 1]);
        $cursor->setTypeMap([
            'root' => PermissionShortcutEntity::class,
            'document' => 'array',
        ]);
        Database::closeInstance();
        foreach ($cursor as $r) {
            return $r->getPosition();
        }
        return 0;
    }

    /**
     * Retorna todos os registros do banco
     * 
     * @return PermissionShortcutEntity[]
     */
    public static function all($filters = [], $sort = ['position' => 1], $limit = null)
    {
        $db = Database::getInstance();

        $where = [];

        if (isset($filters['change_position_higher']) && is_array($filters['change_position_higher'])) {
            $where['position'] = [
                '$gte' => intval($filters['change_position_higher']['current']),
                '$lte' => intval($filters['change_position_higher']['new']),
            ];
        }

        if (isset($filters['change_position_lower']) && is_array($filters['change_position_lower'])) {
            $where['position'] = [
                '$gte' => intval($filters['change_position_lower']['new']),
                '$lte' => intval($filters['change_position_lower']['current']),
            ];
        }

        $options = [
            'sort' => $sort,
        ];

        $cursor = $db->{PermissionShortcutEntity::TABLE}->find(
            $where,
            $options,
        );
        $cursor->setTypeMap([
            'root' => PermissionShortcutEntity::class,
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
     * Retorna todos os registros do banco
     * 
     * @return PermissionShortcutEntity[]
     */
    public static function byAuthfast(AuthfastEntity $authfast)
    {
        $db = Database::getInstance();

        $ids = [];
        foreach (AuthfastShortcutRepository::byAuthfast($authfast) as $r) {
            $ids[] = $r->getShortcut();
        }

        $where = [
            '_id' => [
                '$in' => $ids,
            ],
        ];

        $options = [
            'sort' => [
                'position' => 1,
            ],
        ];

        $cursor = $db->{PermissionShortcutEntity::TABLE}->find(
            $where,
            $options,
        );
        $cursor->setTypeMap([
            'root' => PermissionShortcutEntity::class,
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
     * @return Pagination
     */
    public static function allWithPagination($url, $filters = array(), $currentPg, $varPg = 'pg', $perPg = 12)
    {
        $db = Database::getInstance();

        $where = [];

        if (isset($filters['search']) && trim($filters['search']) != '') {
            $where['description'] = [
                '$regex' => $filters['search'],
            ];
        }

        $total = $db->{PermissionShortcutEntity::TABLE}->count($filters);

        $pagination = new Pagination($total, $perPg, $varPg, $currentPg, $url);

        $cursor = $db->{PermissionShortcutEntity::TABLE}->find(
            $where,
            [
                'limit' => intval($perPg),
                'sort' => [
                    'position' => 1,
                ],
                'skip' => $pagination->getOffset(),
            ]
        );
        $cursor->setTypeMap([
            'root' => PermissionShortcutEntity::class,
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
