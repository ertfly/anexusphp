<?php

namespace AnexusPHP\Business\Permission\Rule;

use AnexusPHP\Business\Permission\Entity\PermissionCategoryMenuEntity;

use AnexusPHP\Core\Database;
use Exception;

class PermissionCategoryMenuRule
{
    public static function install()
    {
        $db = Database::getInstance();
        $db->{PermissionCategoryMenuEntity::TABLE}->createIndex([
            'app' => 1,
            'trash' => -1,
        ], ['name' => PermissionCategoryMenuEntity::TABLE . '_idx_app']);
        $db->{PermissionCategoryMenuEntity::TABLE}->createIndex([
            'trash' => -1,
        ], ['name' => PermissionCategoryMenuEntity::TABLE . '_idx_trash']);
        Database::closeInstance();
    }
    public static function insert(PermissionCategoryMenuEntity &$record)
    {
        $db = Database::getInstance();
        if ($record->getId()) {
            throw new Exception('Esse método serve inserir registros e não alterar');
        }
        $record->insert($db);
        Database::closeInstance();
    }
    public static function update(PermissionCategoryMenuEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método serve alterar registros e não inserir');
        }
        $record->update($db);
        Database::closeInstance();
    }
    public static function delete(PermissionCategoryMenuEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método deve conter um ID');
        }
        $record->delete($db);
        Database::closeInstance();
    }
}
