<?php

namespace AnexusPHP\Business\App\Repository;

use AnexusPHP\Business\App\Entity\AppSessionEntity;
use AnexusPHP\Core\Database;

class AppSessionRepository
{
    /**
     * Retorna um registro do banco pelo id
     *
     * @param integer|null $id
     * @param mixed $className
     * @return AppSessionEntity
     */
    public static function byId($id, $className)
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . AppSessionEntity::TABLE . ' where id = :id limit 1', ['id' => (int)$id])->fetchObject($className);
        if ($reg === false) {
            return new $className();
        }

        return $reg;
    }

    /**
     * Retorna um registro do banco pelo token
     *
     * @param string $token
     * @param mixed $className
     * @return AppSessionEntity
     */
    public static function byToken($token, $className)
    {
        $db = Database::getInstance();

        $reg = $db->query('select * from ' . AppSessionEntity::TABLE . ' where token = :token limit 1', ['token' => $token])->fetchObject($className);
        if ($reg === false) {
            return new $className();
        }

        return $reg;
    }
}
