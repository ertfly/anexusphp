<?php

namespace AnexusPHP\Business\Permission\Rule;

use AnexusPHP\Business\Permission\Entity\PermissionLevelEntity;
use AnexusPHP\Core\Database;

class PermissionLevelRule
{
    public static function install()
    {
        $db = Database::getInstance();
        $db->{PermissionLevelEntity::TABLE}->createIndex([
            'app_id' => 1,
            'trash' => 1,
        ], ['app_id' => PermissionLevelEntity::TABLE . '_idx_app_id']);
        $db->{PermissionLevelEntity::TABLE}->createIndex([
            'name' => 1,
            'trash' => 1,
        ], ['name' => PermissionLevelEntity::TABLE . '_idx_name']);
        $db->{PermissionLevelEntity::TABLE}->createIndex([
            'level' => 1,
            'trash' => 1,
        ], ['name' => PermissionLevelEntity::TABLE . '_idx_level']);
        $db->{PermissionLevelEntity::TABLE}->createIndex([
            'trash' => 1,
        ], ['name' => PermissionLevelEntity::TABLE . '_idx_trash']);
        Database::closeInstance();
    }
    public static function insert(PermissionLevelEntity &$record)
    {
        $db = Database::getInstance();
        $record->insert($db);
        Database::closeInstance();
    }
    public static function update(PermissionLevelEntity &$record)
    {
        $db = Database::getInstance();
        $record->update($db);
        Database::closeInstance();
    }
    public static function delete(PermissionLevelEntity &$record)
    {
        $db = Database::getInstance();
        $record->delete($db);
        Database::closeInstance();
    }
}
