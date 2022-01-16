<?php

namespace AnexusPHP\Business\Authfast\Repository;

use AnexusPHP\Business\Authfast\Entity\AuthfastEntity;
use AnexusPHP\Core\Database;
use AnexusPHP\Core\Libraries\Pagination\Pagination;
use PDO;

class AuthfastRepository
{
    /**
     * Retorna um registro do banco pelo id
     * 
     * @param integer|null $id
     * @return AuthfastEntity
     */
    public static function byId($id, $cls = AuthfastEntity::class)
    {
        $db = Database::getInstance();
        $cursor = $db->{AuthfastEntity::TABLE}->find(['_id' => intval($id)], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => $cls,
            'document' => $cls,
        ]);
        Database::closeInstance();
        foreach ($cursor as $r) {
            return $r;
        }
        $cls = '\\' . $cls;
        return new $cls();
    }

    /**
     * Retorna um registro do banco pelo id
     * 
     * @param string|null $code
     * @return AuthfastEntity
     */
    public static function byCode($code, $cls = AuthfastEntity::class)
    {
        $db = Database::getInstance();
        $cursor = $db->{AuthfastEntity::TABLE}->find(['code' => $code], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => $cls,
            'document' => $cls,
        ]);
        Database::closeInstance();
        foreach ($cursor as $r) {
            return $r;
        }
        $cls = '\\' . $cls;
        return new $cls();
    }

    /**
     * Retorna um registro do banco pelo id
     * 
     * @param string|null $username
     * @return AuthfastEntity
     */
    public static function byUsername($username, $cls = AuthfastEntity::class)
    {
        $db = Database::getInstance();
        $cursor = $db->{AuthfastEntity::TABLE}->find(['username' => $username], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => $cls,
            'document' => $cls,
        ]);
        Database::closeInstance();
        foreach ($cursor as $r) {
            return $r;
        }
        $cls = '\\' . $cls;
        return new $cls();
    }

    /**
     * Retorna um registro do banco pelo id
     * 
     * @param string|null $email
     * @return AuthfastEntity
     */
    public static function byEmail($email, $cls = AuthfastEntity::class)
    {
        $db = Database::getInstance();
        $cursor = $db->{AuthfastEntity::TABLE}->find(['email' => $email], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => $cls,
            'document' => $cls,
        ]);
        Database::closeInstance();
        foreach ($cursor as $r) {
            return $r;
        }
        $cls = '\\' . $cls;
        return new $cls();
    }

    /**
     * Retorna um registro do banco pelo id
     * 
     * @param string|null $document
     * @return AuthfastEntity
     */
    public static function byDocument($document, $cls = AuthfastEntity::class)
    {
        $db = Database::getInstance();
        $cursor = $db->{AuthfastEntity::TABLE}->find(['document' => $document], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => $cls,
            'document' => $cls,
        ]);
        Database::closeInstance();
        foreach ($cursor as $r) {
            return $r;
        }
        $cls = '\\' . $cls;
        return new $cls();
    }

    /**
     * Retorna todos os registros
     * 
     * @return AuthfastEntity[]
     */
    public static function all($cls = AuthfastEntity::class)
    {
        $db = Database::getInstance();

        $where = [];

        $options = [
            'sort' => [
                '_id' => 1
            ],
        ];

        $cursor = $db->{AuthfastEntity::TABLE}->find(
            $where,
            $options,
        );
        $cursor->setTypeMap([
            'root' => $cls,
            'document' => $cls,
        ]);

        Database::closeInstance();

        $rows = [];
        foreach ($cursor as $r) {
            $rows[] = $r;
        }

        return $rows;
    }

    /**
     * Retorna todos os registros com filtros e paginação
     * 
     * @param string $url
     * @param array $filters
     * @param int $currentPg
     * @param string $varPg
     * @param integer $perPg
     * @return Pagination[]
     */
    public static function allWithPagination($url, $filters = array(), $currentPg, $varPg = 'pg', $perPg = 12, $cls = AuthfastEntity::class)
    {
        $db = Database::getInstance();

        $where = [];

        if (isset($filters['search']) && trim($filters['search']) != '') {
            $where['$and'] = [
                '$or' => [
                    '$regex' => [
                        'firstname' => $filters['search'],
                    ],
                    '$regex' => [
                        'lastname' => $filters['search'],
                    ],
                ],
            ];
        }
        
        $total = $db->{AuthfastEntity::TABLE}->count($filters);

        $pagination = new Pagination($total, $perPg, $varPg, $currentPg, $url);

        $cursor = $db->{AuthfastEntity::TABLE}->find(
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
            'root' => $cls,
            'document' => $cls,
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
