<?php

namespace PequiPHP\Business\Permission\Repository;

use PequiPHP\Business\Permission\Entity\PermissionCategoryMenuEntity;

use PequiPHP\Core\Database;
use PequiPHP\Core\Libraries\Pagination\Pagination;
use PDO;

class PermissionCategoryMenuRepository
{
    /**
     * Retorna um registro do banco pelo id
     * 
     * @param integer|null $id
     * @return PermissionCategoryMenuEntity
     */
    public static function byId($id)
    {
        $db = Database::getInstance();
        $cursor = $db->{PermissionCategoryMenuEntity::TABLE}->find(['_id' => intval($id)], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => PermissionCategoryMenuEntity::class,
            'document' => PermissionCategoryMenuEntity::class,
        ]);
        Database::closeInstance();
        foreach ($cursor as $r) {
            return $r;
        }
        return new PermissionCategoryMenuEntity();
    }

    /**
     * Retorna todos os registros do banco
     * 
     * @return PermissionCategoryMenuEntity[]
     */
    public static function all()
    {
        $db = Database::getInstance();

        $where = [
            'trash' => false,
        ];

        $options = [
            'sort' => [
                '_id' => 1
            ],
        ];

        $cursor = $db->{PermissionCategoryMenuEntity::TABLE}->find(
            $where,
            $options,
        );
        $cursor->setTypeMap([
            'root' => PermissionCategoryMenuEntity::class,
            'document' => PermissionCategoryMenuEntity::class,
        ]);

        Database::closeInstance();

        $rows = [];
        foreach ($cursor as $r) {
            $rows[] = $r;
        }

        return $rows;
    }

    /**
     * Retorna todos os menus pelo App
     * 
     * @return PermissionCategoryMenuEntity[]
     */
    public static function byApp($app)
    {
        $db = Database::getInstance();

        $where = [
            'trash' => false,
            'app' => intval($app),
        ];

        $options = [
            'sort' => [
                '_id' => 1
            ],
        ];

        $cursor = $db->{PermissionCategoryMenuEntity::TABLE}->find(
            $where,
            $options,
        );
        $cursor->setTypeMap([
            'root' => PermissionCategoryMenuEntity::class,
            'document' => PermissionCategoryMenuEntity::class,
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
    public static function allWithPagination($url, $filters = array(), $currentPg, $varPg = 'pg', $perPg = 12)
    {
        $db = Database::getInstance();

        $where = [];

        /* if (isset($filters['search']) && trim($filters['search']) != '') {
            $where .= " and upper(a.description) like upper('%'||:description||'%') ";
            $bind['description'] = $filters['search'];
        } */

        $total = $db->{PermissionCategoryMenuEntity::TABLE}->count($filters);

        $pagination = new Pagination($total, $perPg, $varPg, $currentPg, $url);

        $cursor = $db->{PermissionCategoryMenuEntity::TABLE}->find(
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
            'root' => PermissionCategoryMenuEntity::class,
            'document' => PermissionCategoryMenuEntity::class,
        ]);

        Database::closeInstance();

        $rows = [];
        foreach ($cursor as $r) {
            $rows[] = $r;
        }

        $pagination->setRows($rows);

        return $pagination;
    }

    /**
     * @param string $list
     * @return PermissionCategoryMenuEntity[]
     */
    public static function byIdList($list)
    {
        $db = Database::getInstance();

        $where = [
            'trash' => false,
            '_id' => [
                '$in' => explode(',', $list),
            ],
        ];

        $options = [
            'sort' => [
                '_id' => 1
            ],
        ];

        $cursor = $db->{PermissionCategoryMenuEntity::TABLE}->find(
            $where,
            $options,
        );
        $cursor->setTypeMap([
            'root' => PermissionCategoryMenuEntity::class,
            'document' => PermissionCategoryMenuEntity::class,
        ]);

        Database::closeInstance();

        $rows = [];
        foreach ($cursor as $r) {
            $rows[] = $r;
        }

        return $rows;
    }
}
