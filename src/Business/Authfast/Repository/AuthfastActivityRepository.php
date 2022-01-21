<?php

namespace AnexusPHP\Business\Authfast\Repository;

use AnexusPHP\Business\Authfast\Entity\AuthfastActivityEntity;
use AnexusPHP\Business\Authfast\Entity\AuthfastEntity;
use AnexusPHP\Core\Database;
use AnexusPHP\Core\Libraries\Pagination\Pagination;
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
    public static function all()
    {
        $db = Database::getInstance();

        $where = [];

        $options = [
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
}
