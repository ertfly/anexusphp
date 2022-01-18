<?php

namespace AnexusPHP\Business\App\Rule;

use AnexusPHP\Business\App\Entity\AppEntity;
use AnexusPHP\Core\Database;

class AppRule
{
    public static function install()
    {
        $db = Database::getInstance();
        $db->{AppEntity::TABLE}->createIndex([
            'name' => 1,
        ], ['name' => AppEntity::TABLE . '_idx_name']);
        $db->{AppEntity::TABLE}->createIndex([
            'key' => 1,
        ], ['name' => AppEntity::TABLE . '_idx_key']);
        Database::closeInstance();
    }
    public static function insert(AppEntity &$record)
    {
        $db = Database::getInstance();
        $record->insert($db);
        Database::closeInstance();
    }
    public static function update(AppEntity &$record)
    {
        $db = Database::getInstance();
        $record->update($db);
        Database::closeInstance();
    }
}
