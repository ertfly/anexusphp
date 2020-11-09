<?php

namespace AnexusPHP\Business\Permission\Rule;

use AnexusPHP\Business\Permission\Entity\PermissionModuleEntity;

use AnexusPHP\Core\Database;
use Exception;

class PermissionModuleRule
{
    public static function insert(PermissionModuleEntity &$record)
    {
        $db = Database::getInstance();
        if ($record->getId()) {
            throw new Exception('Esse método serve inserir registros e não alterar');
        }
        $record->setTrash(false)
            ->save($db);
    }
    public static function update(PermissionModuleEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método serve alterar registros e não inserir');
        }
        $record->save($db);
    }
    public static function delete(PermissionModuleEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método deve conter um ID');
        }
        $record->delete($db);
    }
    public static function destroy(PermissionModuleEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método deve conter um ID');
        }
        $record->destroy($db);
    }
}
