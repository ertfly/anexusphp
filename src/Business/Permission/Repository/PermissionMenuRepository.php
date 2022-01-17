<?php

namespace PequiPHP\Business\Permission\Repository;

use PequiPHP\Business\Permission\Entity\PermissionMenuEntity;

use PequiPHP\Core\Database;
use PequiPHP\Core\Libraries\Pagination\Pagination;
use PDO;

class PermissionMenuRepository
{
    /**
     * Retorna um registro do banco pelo id
     * 
     * @param integer|null $id
     * @return PermissionMenuEntity
     */
    public static function byId($id)
    {
        $db = Database::getInstance();
        $cursor = $db->{PermissionMenuEntity::TABLE}->find(['_id' => intval($id)], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => PermissionMenuEntity::class,
            'document' => PermissionMenuEntity::class,
        ]);
        Database::closeInstance();
        foreach ($cursor as $r) {
            return $r;
        }
        return new PermissionMenuEntity();
    }

    /**
     * @param integer|null $id
     * @return PermissionMenuEntity[]
     */
    public static function byCategoryId($id)
    {
        $db = Database::getInstance();

        $where = [
            'trash' => false,
            'category_id' => intval($id),
        ];

        $options = [];

        $cursor = $db->{PermissionMenuEntity::TABLE}->find(
            $where,
            $options,
        );
        $cursor->setTypeMap([
            'root' => PermissionMenuEntity::class,
            'document' => PermissionMenuEntity::class,
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
     * @return PermissionMenuEntity[]
     */
    public static function all()
    {
        $db = Database::getInstance();

        $where = [
            'trash' => false,
        ];

        $options = [];

        $cursor = $db->{PermissionMenuEntity::TABLE}->find(
            $where,
            $options,
        );
        $cursor->setTypeMap([
            'root' => PermissionMenuEntity::class,
            'document' => PermissionMenuEntity::class,
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

        $where = [
            'trash' => false,
        ];

        /* if (isset($filters['search']) && trim($filters['search']) != '') {
            $where .= " and upper(a.description) like upper('%'||:description||'%') ";
            $bind['description'] = $filters['search'];
        } */

        $total = $db->{PermissionMenuEntity::TABLE}->count($filters);

        $pagination = new Pagination($total, $perPg, $varPg, $currentPg, $url);

        $cursor = $db->{PermissionMenuEntity::TABLE}->find(
            $where,
            [
                'limit' => intval($perPg),
                'sort' => [
                    '_id' => 1
                ],
                'skip' => $pagination->getOffset(),
            ]
        );
        $cursor->setTypeMap([
            'root' => PermissionMenuEntity::class,
            'document' => PermissionMenuEntity::class,
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
     * @param string $modules
     * @param int $app
     * @return PermissionMenuEntity[]
     */
    public static function byModules($modules, $app)
    {
        $db = Database::getInstance();

        $where = [
            'trash' => false,
            'module_id' => [
                '$in' => explode(',',$modules),
            ],
            'app' => intval($app),
        ];

        $options = [];

        $cursor = $db->{PermissionMenuEntity::TABLE}->find(
            $where,
            $options,
        );
        $cursor->setTypeMap([
            'root' => PermissionMenuEntity::class,
            'document' => PermissionMenuEntity::class,
        ]);
        
        Database::closeInstance();

        $rows = [];
        foreach ($cursor as $r) {
            $rows[] = $r;
        }

        return $rows;
    }
}
