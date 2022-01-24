<?php

namespace AnexusPHP\Business\Permission\Repository;

use AnexusPHP\Business\App\Entity\AppEntity;
use AnexusPHP\Business\Authfast\Entity\AuthfastEntity;
use AnexusPHP\Business\Authfast\Entity\AuthfastPermissionEntity;
use AnexusPHP\Business\Permission\Entity\PermissionModuleEntity;

use AnexusPHP\Core\Database;
use AnexusPHP\Core\Libraries\Pagination\Pagination;
use PDO;

class PermissionModuleRepository
{
    /**
     * Retorna um registro do banco pelo id
     * 
     * @param integer|null $id
     * @return PermissionModuleEntity
     */
    public static function byId($id, $cls = PermissionModuleEntity::class)
    {
        $db = Database::getInstance();
        $cursor = $db->{PermissionModuleEntity::TABLE}->find(['_id' => intval($id)], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => $cls,
            'document' => 'array',
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
     * @return PermissionModuleEntity[]
     */
    public static function all(array $filters = [], $cls = PermissionModuleEntity::class)
    {
        $db = Database::getInstance();

        $where = [];

        if (isset($filters['app_id']) && trim($filters['app_id']) != '') {
            $where['app'] = intval($filters['app_id']);
        }

        $options = [
            'sort' => [
                'name' => 1
            ],
        ];

        $cursor = $db->{PermissionModuleEntity::TABLE}->find(
            $where,
            $options,
        );
        $cursor->setTypeMap([
            'root' => $cls,
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
     * @return PermissionModuleEntity[]
     */
    public static function byLevelEqualOrHigher($level, AppEntity $app, $cls = PermissionModuleEntity::class)
    {
        $db = Database::getInstance();

        $where = [
            'level' => [
                '$gte' => intval($level),
            ],
            'app_id' => $app->getId(),
        ];

        $options = [
            'sort' => [
                'name' => 1
            ],
        ];

        $cursor = $db->{PermissionModuleEntity::TABLE}->find(
            $where,
            $options,
        );
        $cursor->setTypeMap([
            'root' => $cls,
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
    public static function allWithPagination($url, $filters = array(), $currentPg, $varPg = 'pg', $perPg = 12, $cls = PermissionModuleEntity::class)
    {
        $db = Database::getInstance();

        $where = [];

        $total = $db->{PermissionModuleEntity::TABLE}->count($filters);

        $pagination = new Pagination($total, $perPg, $varPg, $currentPg, $url);

        $cursor = $db->{PermissionModuleEntity::TABLE}->find(
            $where,
            [
                'limit' => intval($perPg),
                'sort' => [
                    'position' => 1
                ],
                'skip' => $pagination->getOffset(),
            ]
        );
        $cursor->setTypeMap([
            'root' => $cls,
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
     * @param AuthfastEntity $authfast
     * @return string
     */
    public static function byAuthfast(AuthfastEntity $authfast, $cls = PermissionModuleEntity::class)
    {
        $db = Database::getInstance();

        $where = [
            'authfast_id' => $authfast->getId(),
        ];

        $options = [];

        $cursor = $db->{PermissionModuleEntity::TABLE}->find(
            $where,
            $options,
        );
        $cursor->setTypeMap([
            'root' => $cls,
            'document' => 'array',
        ]);

        Database::closeInstance();

        $rows = [];
        foreach ($cursor as $r) {
            $rows[$r->getId()] = $r;
        }

        return $rows;
    }
}
