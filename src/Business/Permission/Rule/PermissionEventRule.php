<?php

namespace AnexusPHP\Business\Permission\Rule;

use AnexusPHP\Business\Permission\Entity\PermissionEventEntity;

use AnexusPHP\Core\Database;
use Exception;

class PermissionEventRule
{
    public static function install()
    {
        $db = Database::getInstance();
        $db->{PermissionEventEntity::TABLE}->createIndex([
            'level' => 1,
            'trash' => 1,
        ], ['name' => PermissionEventEntity::TABLE . '_idx_level']);
        $db->{PermissionEventEntity::TABLE}->createIndex([
            'app' => 1,
            'trash' => 1,
        ], ['name' => PermissionEventEntity::TABLE . '_idx_app']);
        $db->{PermissionEventEntity::TABLE}->createIndex([
            'trash' => 1,
        ], ['name' => PermissionEventEntity::TABLE . '_idx_trash']);
        Database::closeInstance();
    }
    public static function insert(PermissionEventEntity &$record)
    {
        $db = Database::getInstance();
        $record->insert($db);
        Database::closeInstance();
    }
    public static function update(PermissionEventEntity &$record)
    {
        $db = Database::getInstance();
        $record->update($db);
        Database::closeInstance();
    }
    public static function delete(PermissionEventEntity &$record)
    {
        $db = Database::getInstance();
        $record->delete($db);
        Database::closeInstance();
    }
}
