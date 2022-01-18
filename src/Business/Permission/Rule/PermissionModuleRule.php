<?php

namespace AnexusPHP\Business\Permission\Rule;

use AnexusPHP\Business\Permission\Entity\PermissionModuleEntity;

use AnexusPHP\Core\Database;
use Exception;

class PermissionModuleRule
{
    public static function install()
    {
        $db = Database::getInstance();
        $db->{PermissionModuleEntity::TABLE}->createIndex([
            'position' => 1,
            'trash' => 1,
        ], ['name' => PermissionModuleEntity::TABLE . '_idx_position']);
        $db->{PermissionModuleEntity::TABLE}->createIndex([
            'app' => 1,
            'trash' => 1,
        ], ['name' => PermissionModuleEntity::TABLE . '_idx_app']);
        $db->{PermissionModuleEntity::TABLE}->createIndex([
            'trash' => 1,
        ], ['name' => PermissionModuleEntity::TABLE . '_idx_trash']);
        Database::closeInstance();
    }
    public static function insert(PermissionModuleEntity &$record)
    {
        $db = Database::getInstance();
        if ($record->getId()) {
            throw new Exception('Esse método serve inserir registros e não alterar');
        }
        $record->insert($db);
        Database::closeInstance();
    }
    public static function update(PermissionModuleEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método serve alterar registros e não inserir');
        }
        $record->update($db);
        Database::closeInstance();
    }
    public static function delete(PermissionModuleEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método deve conter um ID');
        }
        $record->delete($db);
        Database::closeInstance();
    }
}
