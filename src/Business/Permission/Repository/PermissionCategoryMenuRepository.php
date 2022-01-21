<?php

namespace AnexusPHP\Business\Permission\Repository;

use AnexusPHP\Business\App\Entity\AppAuthfastEntity;
use AnexusPHP\Business\App\Entity\AppEntity;
use AnexusPHP\Business\Authfast\Entity\AuthfastEntity;
use AnexusPHP\Business\Permission\Entity\PermissionCategoryMenuEntity;

use AnexusPHP\Core\Database;
use AnexusPHP\Core\Libraries\Pagination\Pagination;
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
            'document' => 'array',
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
    public static function all(array $filters = [])
    {
        $db = Database::getInstance();

        $where = [
            'trash' => false,
        ];

        if (isset($filters['in_id']) && is_array($filters['in_id']) && count($filters['in_id']) > 0) {
            $where['_id'] = [
                '$in' => $filters['in_id'],
            ];
        }

        $options = [
            'sort' => [
                'position' => 1,
            ],
        ];

        $cursor = $db->{PermissionCategoryMenuEntity::TABLE}->find(
            $where,
            $options,
        );
        $cursor->setTypeMap([
            'root' => PermissionCategoryMenuEntity::class,
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
                'position' => 1
            ],
        ];

        $cursor = $db->{PermissionCategoryMenuEntity::TABLE}->find(
            $where,
            $options,
        );
        $cursor->setTypeMap([
            'root' => PermissionCategoryMenuEntity::class,
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
     * @return int
     */
    public static function lastPositionByApp(AppEntity $app)
    {
        $db = Database::getInstance();
        $cursor = $db->{PermissionCategoryMenuEntity::TABLE}->find(['trash' => false, 'app' => $app->getId()], ['limit' => 1, 'sort' => ['position' => -1]]);
        $cursor->setTypeMap([
            'root' => PermissionCategoryMenuEntity::class,
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
     * @param AppEntity $app
     * @param AuthfastEntity $authfast
     * @return PermissionCategoryMenuEntity
     */
    public static function byAppAuthfast(AppAuthfastEntity $appAuthfast)
    {
        $db = Database::getInstance();

        $where = [
            'trash' => false,
            'app' => $appAuthfast->getAppId(),
            '_id' => [
                // '$in' => $app
            ]
        ];

        $options = [
            'sort' => [
                'position' => 1
            ],
        ];

        $cursor = $db->{PermissionCategoryMenuEntity::TABLE}->find(
            $where,
            $options,
        );
        $cursor->setTypeMap([
            'root' => PermissionCategoryMenuEntity::class,
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
