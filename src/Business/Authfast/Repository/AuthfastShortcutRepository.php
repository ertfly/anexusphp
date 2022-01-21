<?php

namespace AnexusPHP\Business\Authfast\Repository;

use AnexusPHP\Business\Authfast\Entity\AuthfastEntity;
use AnexusPHP\Business\Authfast\Entity\AuthfastShortcutEntity;
use AnexusPHP\Business\Permission\Entity\PermissionShortcutEntity;
use AnexusPHP\Core\Database;

class AuthfastShortcutRepository
{
    /**
     * Retorna um registro do banco pelo id
     * 
     * @param integer|null $id
     * @return AuthfastShortcutEntity
     */
    public static function byId($id)
    {
        $db = Database::getInstance();
        $cursor = $db->{AuthfastShortcutEntity::TABLE}->find(['_id' => intval($id)], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => AuthfastShortcutEntity::class,
            'document' => 'array',
        ]);
        Database::closeInstance();
        foreach ($cursor as $r) {
            return $r;
        }
        return new AuthfastShortcutEntity();
    }

    /**
     * Retorna todos os registros do banco
     * 
     * @return AuthfastShortcutEntity[]
     */
    public static function byAuthfast(AuthfastEntity $authfast)
    {
        $db = Database::getInstance();

        $where = [
            'authfast_id' => $authfast->getId(),
        ];

        $options = [
            'sort' => ['_id' => 1],
        ];

        $cursor = $db->{AuthfastShortcutEntity::TABLE}->find(
            $where,
            $options,
        );
        $cursor->setTypeMap([
            'root' => AuthfastShortcutEntity::class,
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
     * Retorna um registro do banco pelo id
     * 
     * @param integer|null $id
     * @return AuthfastShortcutEntity
     */
    public static function byShortcutAndPeson(PermissionShortcutEntity $shortcut, AuthfastEntity $authfast)
    {
        $db = Database::getInstance();
        $cursor = $db->{AuthfastShortcutEntity::TABLE}->find(['authfast_id' => $authfast->getId(), 'shortcut' => $shortcut->getId()], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => AuthfastShortcutEntity::class,
            'document' => 'array',
        ]);
        Database::closeInstance();
        foreach ($cursor as $r) {
            return $r;
        }
        return new AuthfastShortcutEntity();
    }

    /**
     * Undocumented function
     *
     * @param AuthfastEntity $authfast
     * @return array
     */
    public static function listShortcutByAuthfast(AuthfastEntity $authfast)
    {
        $db = Database::getInstance();

        $where = [
            'authfast_id' => $authfast->getId(),
        ];

        $options = [
            'sort' => ['_id' => 1],
        ];

        $cursor = $db->{AuthfastShortcutEntity::TABLE}->find(
            $where,
            $options,
        );
        $cursor->setTypeMap([
            'root' => AuthfastShortcutEntity::class,
            'document' => 'array',
        ]);

        Database::closeInstance();

        $rows = [];
        foreach ($cursor as $r) {
            $rows[] = $r->getShortcut();
        }

        return $rows;
    }
}
