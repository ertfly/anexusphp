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
        $db->permission_category_menu->createIndex([
            'app' => 1,
            'trash' => -1,
        ], ['name' => 'permission_category_menu_idx_app']);
        $db->permission_category_menu->createIndex([
            'trash' => -1,
        ], ['name' => 'permission_category_menu_idx_trash']);
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
