<?php

namespace AnexusPHP\Business\Permission\Rule;

use AnexusPHP\Business\Permission\Entity\PermissionEventEntity;

use AnexusPHP\Core\Database;
use Exception;

class PermissionEventRule
{
    public static function insert(PermissionEventEntity &$record)
    {
        $db = Database::getInstance();
        if ($record->getId()) {
            throw new Exception('Esse método serve inserir registros e não alterar');
        }
        $record->save($db);
    }
    public static function update(PermissionEventEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método serve alterar registros e não inserir');
        }
        $record->save($db);
    }
    public static function delete(PermissionEventEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método deve conter um ID');
        }
        $record->delete($db);
    }
    public static function destroy(PermissionEventEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método deve conter um ID');
        }
        $record->destroy($db);
    }
}
