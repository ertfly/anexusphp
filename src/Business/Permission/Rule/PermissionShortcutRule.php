<?php

namespace AnexusPHP\Business\Permission\Rule;

use AnexusPHP\Business\Permission\Entity\PermissionShortcutEntity;
use AnexusPHP\Business\Permission\Repository\PermissionShortcutRepository;
use AnexusPHP\Core\Database;

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
        $record->insert($db);
        Database::closeInstance();
    }
    public static function update(PermissionShortcutEntity &$record)
    {
        $db = Database::getInstance();
        $record->update($db);
        Database::closeInstance();
    }
    public static function destroy(PermissionShortcutEntity &$record)
    {
        $db = Database::getInstance();
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
