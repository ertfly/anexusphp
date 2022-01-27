<?php

namespace AnexusPHP\Business\Authfast\Repository;

use AnexusPHP\Business\App\Entity\AppEntity;
use AnexusPHP\Business\Authfast\Entity\AuthfastEntity;
use AnexusPHP\Business\Authfast\Entity\AuthfastPermissionEntity;
use AnexusPHP\Business\Permission\Entity\PermissionModuleEntity;
use AnexusPHP\Business\Permission\Repository\PermissionMenuRepository;
use AnexusPHP\Core\Database;
use PDO;

class AuthfastPermissionRepository
{
    /**
     * Retorna um registro do banco pelo id
     * 
     * @param integer|null $id
     * @return AuthfastPermissionEntity
     */
    public static function byId($id)
    {
        $db = Database::getInstance();
        $cursor = $db->{AuthfastPermissionEntity::TABLE}->find(['_id' => intval($id)], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => AuthfastPermissionEntity::class,
            'document' => 'array',
        ]);
        Database::closeInstance();
        foreach ($cursor as $r) {
            return $r;
        }
        return new AuthfastPermissionEntity();
    }

    /**
     * Retorna um registro do banco pelo id do Authfast
     * 
     * @param integer|null $authfastId
     * @return AuthfastPermissionEntity[]
     */
    public static function byAuthfast(AuthfastEntity $authfast)
    {
        $db = Database::getInstance();

        $where = [
            'authfast_id' => $authfast->getId(),
        ];

        $options = [
            'sort' => [
                '_id' => 1
            ],
        ];

        $cursor = $db->{AuthfastPermissionEntity::TABLE}->find(
            $where,
            $options,
        );
        $cursor->setTypeMap([
            'root' => AuthfastPermissionEntity::class,
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
     * @param AuthfastEntity $authfast
     * @param int $moduleId
     * @return AuthfastPermissionEntity
     */
    public static function byAuthfastAndModule(AuthfastEntity $authfast, $moduleId)
    {
        $db = Database::getInstance();
        $cursor = $db->{AuthfastPermissionEntity::TABLE}->find(['authfast_id' => $authfast->getId(), 'module_id' => intval($moduleId)], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => AuthfastPermissionEntity::class,
            'document' => 'array',
        ]);
        Database::closeInstance();
        foreach ($cursor as $r) {
            return $r;
        }
        return new AuthfastPermissionEntity();
    }

    /**
     * Undocumented function
     *
     * @param AuthfastEntity $authfast
     * @return int[]
     */
    public static function listModuleIdsbyAuthfast(AuthfastEntity $authfast)
    {
        $db = Database::getInstance();

        $where = [
            'authfast_id' => $authfast->getId(),
        ];

        $options = [
            'sort' => [
                '_id' => 1
            ],
        ];

        $cursor = $db->{AuthfastPermissionEntity::TABLE}->find(
            $where,
            $options,
        );
        $cursor->setTypeMap([
            'root' => AuthfastPermissionEntity::class,
            'document' => 'array',
        ]);

        Database::closeInstance();

        $rows = [];
        foreach ($cursor as $r) {
            $rows[] = $r->getModuleId();
        }

        return $rows;
    }

    /**
     * Undocumented function
     *
     * @param AuthfastEntity $authfast
     * @return int[]
     */
    public static function listMenuIdsbyAuthfast(AuthfastEntity $authfast, AppEntity $app)
    {
        $db = Database::getInstance();

        $options = [
            [
                '$lookup' => [
                    'from' => PermissionModuleEntity::TABLE,
                    'localField' => 'module_id',
                    'foreignField' => '_id',
                    'as' => "AuthfastModule",
                ],
            ],
            [
                '$match' => [
                    'authfast_id' => $authfast->getId(),
                    'AuthfastModule.app' => $app->getId(),
                ],
            ],
        ];

        $cursor = $db->{AuthfastPermissionEntity::TABLE}->aggregate(
            $options,
        );
        $cursor->setTypeMap([
            'root' => AuthfastPermissionEntity::class,
            'document' => 'array',
        ]);

        Database::closeInstance();

        $rows = [];
        foreach ($cursor as $r) {
            $menu = PermissionMenuRepository::byModule($r->getModule());
            $rows[] = $menu->getId();
        }
        
        return $rows;
    }

    /**
     * Undocumented function
     *
     * @param AuthfastEntity $authfast
     * @return int[]
     */
    public static function listCategoryIdsbyAuthfast(AuthfastEntity $authfast, AppEntity $app)
    {
        $db = Database::getInstance();

        $options = [
            [
                '$lookup' => [
                    'from' => PermissionModuleEntity::TABLE,
                    'localField' => 'module_id',
                    'foreignField' => '_id',
                    'as' => "AuthfastModule",
                ],
            ],
            [
                '$match' => [
                    'authfast_id' => $authfast->getId(),
                    'AuthfastModule.app' => $app->getId(),
                ],
            ],
        ];

        $cursor = $db->{AuthfastPermissionEntity::TABLE}->aggregate(
            $options,
        );
        $cursor->setTypeMap([
            'root' => AuthfastPermissionEntity::class,
            'document' => 'array',
        ]);

        Database::closeInstance();

        $rows = [];
        foreach ($cursor as $r) {
            $menu = PermissionMenuRepository::byModule($r->getModule());
            $rows[] = $menu->getCategoryId();
        }
        
        return $rows;
    }
}
