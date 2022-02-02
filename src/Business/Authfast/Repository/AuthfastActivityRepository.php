<?php

namespace AnexusPHP\Business\Authfast\Repository;

use AnexusPHP\Business\Authfast\Entity\AuthfastActivityEntity;
use AnexusPHP\Business\Authfast\Entity\AuthfastEntity;
use AnexusPHP\Core\Database;
use AnexusPHP\Core\Libraries\Pagination\Pagination;
use AnexusPHP\Core\Tools\Number;
use PDO;

class AuthfastActivityRepository
{
    /**
     * Retorna um registro do banco pelo id
     * 
     * @param integer|null $id
     * @return AuthfastActivityEntity
     */
    public static function byId($id)
    {
        $db = Database::getInstance();
        $cursor = $db->{AuthfastActivityEntity::TABLE}->find(['_id' => intval($id)], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => AuthfastActivityEntity::class,
            'document' => 'array',
        ]);
        Database::closeInstance();
        foreach ($cursor as $r) {
            return $r;
        }
        return new AuthfastActivityEntity();
    }

    /**
     * Retorna todos os registros do banco
     * 
     * @return AuthfastActivityEntity[]
     */
    public static function all(array $filters = [])
    {
        $db = Database::getInstance();

        $where = [];

        if (isset($filters['app_id']) && trim($filters['app_id']) != '') {
            $where['app_id'] = Number::intNull($filters['app_id']);
        }

        if (isset($filters['authfast_id']) && trim($filters['authfast_id']) != '') {
            $where['authfast_id'] = Number::intNull($filters['authfast_id']);
        }

        $options = [
            'sort' => [
                '_id' => -1
            ],
        ];

        $cursor = $db->{AuthfastActivityEntity::TABLE}->find(
            $where,
            $options,
        );
        $cursor->setTypeMap([
            'root' => AuthfastActivityEntity::class,
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
     * Retorna os registro do banco pelo authfast
     * 
     * @param AuthfastEntity $authfast
     * @return AuthfastActivityEntity[]
     */
    public static function allByAuthfast(AuthfastEntity $authfast)
    {
        $db = Database::getInstance();

        $where = [
            'authfast_id' => $authfast->getId()
        ];

        $options = [
            'limit' => 10,
            'sort' => [
                'created_at' => -1
            ],
        ];

        $cursor = $db->{AuthfastActivityEntity::TABLE}->find(
            $where,
            $options,
        );
        $cursor->setTypeMap([
            'root' => AuthfastActivityEntity::class,
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
    public static function allWithPagination($url, $filters = [], $currentPg, $varPg = 'pg', $perPg = 12)
    {
        $db = Database::getInstance();

        $where = [];

        $total = $db->{AuthfastActivityEntity::TABLE}->count($where);

        $pagination = new Pagination($total, $perPg, $varPg, $currentPg, $url);

        $cursor = $db->{AuthfastActivityEntity::TABLE}->find(
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
            'root' => AuthfastActivityEntity::class,
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
