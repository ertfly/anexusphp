<?php

namespace AnexusPHP\Business\Permission\Rule;

use AnexusPHP\Business\Permission\Entity\PermissionLevelEntity;
use AnexusPHP\Core\Database;
use Exception;

class PermissionLevelRule
{
    public static function install()
    {
        $db = Database::getInstance();
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
        if ($record->getId()) {
            throw new Exception('Esse método serve inserir registros e não alterar');
        }
        $record->insert($db);
        Database::closeInstance();
    }
    public static function update(PermissionLevelEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método serve alterar registros e não inserir');
        }
        $record->update($db);
        Database::closeInstance();
    }
    public static function delete(PermissionLevelEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método deve conter um ID');
        }
        $record->delete($db);
        Database::closeInstance();
    }
}