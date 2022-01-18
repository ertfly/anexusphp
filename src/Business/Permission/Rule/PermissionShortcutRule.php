<?php

namespace AnexusPHP\Business\Permission\Rule;

use AnexusPHP\Business\Permission\Entity\PermissionShortcutEntity;
use AnexusPHP\Business\Permission\Repository\PermissionShortcutRepository;
use AnexusPHP\Core\Database;
use Exception;

class PermissionShortcutRule
{
    public static function install()
    {
        $db = Database::getInstance();
        $db->{PermissionShortcutEntity::TABLE}->createIndex([
            'level' => 1,
        ], ['name' => PermissionShortcutEntity::TABLE . '_idx_level']);
        $db->{PermissionShortcutEntity::TABLE}->createIndex([
            'position' => 1,
        ], ['name' => PermissionShortcutEntity::TABLE . '_idx_position']);
        $db->{PermissionShortcutEntity::TABLE}->createIndex([
            'principal' => -1,
        ], ['name' => PermissionShortcutEntity::TABLE . '_idx_principal']);
        Database::closeInstance();
    }
    public static function insert(PermissionShortcutEntity &$record)
    {
        $db = Database::getInstance();
        if ($record->getId()) {
            throw new Exception('Esse método serve inserir registros e não alterar');
        }
        $record->insert($db);
        Database::closeInstance();
    }
    public static function update(PermissionShortcutEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método serve alterar registros e não inserir');
        }
        $record->update($db);
        Database::closeInstance();
    }
    public static function destroy(PermissionShortcutEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método deve conter um ID');
        }
        $record->destroy($db);
        Database::closeInstance();
    }
    public static function principal(PermissionShortcutEntity &$record)
    {
        foreach (PermissionShortcutRepository::all(['principal' => true]) as $r) {
            $r->setPrincipal(false);
            self::update($r);
        }

        $record->setPrincipal(true);
        self::update($record);
    }
}
