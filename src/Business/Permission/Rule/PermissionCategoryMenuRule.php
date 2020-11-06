<?php

namespace AnexusPHP\Business\Permission\Rule;

use AnexusPHP\Business\Permission\Entity\PermissionCategoryMenuEntity;

use AnexusPHP\Core\Database;
use Exception;

class PermissionCategoryMenuRule
{
    public static function insert(PermissionCategoryMenuEntity &$record)
    {
        $db = Database::getInstance();
        if ($record->getId()) {
            throw new Exception('Esse método serve inserir registros e não alterar');
        }
        $record->save($db);
    }
    public static function update(PermissionCategoryMenuEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método serve alterar registros e não inserir');
        }
        $record->save($db);
    }
    public static function delete(PermissionCategoryMenuEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método deve conter um ID');
        }
        $record->delete($db);
    }
    public static function destroy(PermissionCategoryMenuEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método deve conter um ID');
        }
        $record->destroy($db);
    }
}
