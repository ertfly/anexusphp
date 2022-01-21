<?php

namespace AnexusPHP\Business\Permission\Repository;

use AnexusPHP\Business\App\Entity\AppEntity;
use AnexusPHP\Business\Permission\Entity\PermissionCategoryMenuEntity;
use AnexusPHP\Business\Permission\Entity\PermissionMenuEntity;
use AnexusPHP\Business\Permission\Entity\PermissionModuleEntity;
use AnexusPHP\Core\Database;
use AnexusPHP\Core\Libraries\Pagination\Pagination;
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
            'document' => 'array',
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

        $options = [
            'sort' => [
                'position' => 1,
            ],
        ];

        $cursor = $db->{PermissionMenuEntity::TABLE}->find(
            $where,
            $options,
        );
        $cursor->setTypeMap([
            'root' => PermissionMenuEntity::class,
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
     * @return PermissionMenuEntity[]
     */
    public static function all(array $filters = [])
    {
        $db = Database::getInstance();

        $where = [
            'trash' => false,
        ];

        if (isset($filters['category_id']) && trim($filters['category_id']) != '') {
            $where['category_id'] = intval($filters['category_id']);
        }

        if (isset($filters['menu_in']) && is_array($filters['menu_in']) && count($filters['menu_in']) > 0) {
            $where['_id'] = [
                '$in' => $filters['menu_in'],
            ];
        }

        $options = [
            'sort' => [
                'position' => 1,
            ],
        ];

        $cursor = $db->{PermissionMenuEntity::TABLE}->find(
            $where,
            $options,
        );
        $cursor->setTypeMap([
            'root' => PermissionMenuEntity::class,
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
                    'position' => 1,
                ],
                'skip' => $pagination->getOffset(),
            ]
        );
        $cursor->setTypeMap([
            'root' => PermissionMenuEntity::class,
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

    /**
     * @param array $modules
     * @param AppEntity $app
     * @return PermissionMenuEntity[]
     */
    public static function byModules(array $modules, AppEntity $app)
    {
        $db = Database::getInstance();

        $where = [
            'trash' => false,
            'module_id' => [
                '$in' => $modules,
            ],
            'app' => $app->getId(),
        ];

        $options = [
            'sort' => [
                'position' => 1,
            ],
        ];

        $cursor = $db->{PermissionMenuEntity::TABLE}->find(
            $where,
            $options,
        );
        $cursor->setTypeMap([
            'root' => PermissionMenuEntity::class,
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
     * Undocumented function
     *
     * @param AppEntity $app
     * @param PermissionCategoryMenuEntity $category
     * @return int
     */
    public static function lastPositionByAppCategory(AppEntity $app, PermissionCategoryMenuEntity $category)
    {
        $db = Database::getInstance();
        $cursor = $db->{PermissionMenuEntity::TABLE}->find(['trash' => false, 'app' => $app->getId(), 'category_id' => $category->getId()], ['limit' => 1, 'sort' => ['position' => -1]]);
        $cursor->setTypeMap([
            'root' => PermissionMenuEntity::class,
            'document' => 'array',
        ]);
        Database::closeInstance();
        foreach ($cursor as $r) {
            return $r->getPosition();
        }
        return 0;
    }

    /**
     * Undocumented function
     *
     * @param PermissionModuleEntity $module
     * @return PermissionMenuEntity
     */
    public static function byModule(PermissionModuleEntity $module)
    {
        $db = Database::getInstance();
        $cursor = $db->{PermissionMenuEntity::TABLE}->find(['module_id' => $module->getId()], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => PermissionMenuEntity::class,
            'document' => 'array',
        ]);
        Database::closeInstance();
        foreach ($cursor as $r) {
            return $r;
        }
        return new PermissionMenuEntity();
    }
}
