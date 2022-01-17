<?php

namespace AnexusPHP\Business\Permission\Rule;

use AnexusPHP\Business\Permission\Entity\PermissionMenuEntity;

use AnexusPHP\Core\Database;
use Exception;

class PermissionMenuRule
{
    public static function install()
    {
        $db = Database::getInstance();
        $db->permission_menu->createIndex([
            'category_id' => 1,
            'trash' => -1,
        ], ['name' => 'permission_menu_idx_category_id']);
        $db->permission_menu->createIndex([
            'module_id' => 1,
            'trash' => -1,
        ], ['name' => 'permission_menu_idx_module_id']);
        $db->permission_menu->createIndex([
            'app' => 1,
            'trash' => -1,
        ], ['name' => 'permission_menu_idx_app']);
        $db->permission_menu->createIndex([
            'trash' => -1,
        ], ['name' => 'permission_menu_idx_trash']);
        Database::closeInstance();
    }
    public static function insert(PermissionMenuEntity &$record)
    {
        $db = Database::getInstance();
        if ($record->getId()) {
            throw new Exception('Esse método serve inserir registros e não alterar');
        }
        $record->insert($db);
        Database::closeInstance();
    }
    public static function update(PermissionMenuEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método serve alterar registros e não inserir');
        }
        $record->update($db);
        Database::closeInstance();
    }
    public static function delete(PermissionMenuEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método deve conter um ID');
        }
        $record->delete($db);
        Database::closeInstance();
    }
}
