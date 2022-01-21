<?php

namespace AnexusPHP\Business\Authfast\Repository;

use AnexusPHP\Business\Authfast\Entity\AuthfastEntity;
use AnexusPHP\Business\Authfast\Entity\AuthfastPermissionEntity;

use AnexusPHP\Core\Database;
use AnexusPHP\Core\Libraries\Pagination\Pagination;
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
}
