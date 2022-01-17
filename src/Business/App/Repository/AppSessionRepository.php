<?php

namespace PequiPHP\Business\App\Repository;

use PequiPHP\Business\App\Entity\AppSessionEntity;
use PequiPHP\Core\Database;

class AppSessionRepository
{
    /**
     * Retorna um registro do banco pelo id
     *
     * @param integer|null $id
     * @param mixed $className
     * @return AppSessionEntity
     */
    public static function byId($id, $className = AppSessionEntity::class)
    {
        $db = Database::getInstance();
        $cursor = $db->{AppSessionEntity::TABLE}->find(['_id' => intval($id)], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => $className,
            'document' => $className,
        ]);
        Database::closeInstance();
        foreach ($cursor as $r) {
            return $r;
        }
        $className = '\\' . $className;
        return new $className();
    }

    /**
     * Retorna um registro do banco pelo token
     *
     * @param string $token
     * @param mixed $className
     * @return AppSessionEntity
     */
    public static function byToken($token, $className = AppSessionEntity::class)
    {
        $db = Database::getInstance();
        $cursor = $db->{AppSessionEntity::TABLE}->find(['token' => $token], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => $className,
            'document' => $className,
        ]);
        Database::closeInstance();
        foreach ($cursor as $r) {
            return $r;
        }
        $className = '\\' . $className;
        return new $className();
    }
}
