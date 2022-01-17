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
        $db->permission_event->createIndex([
            'app' => 1,
            'trash' => -1,
        ], ['name' => 'permission_event_idx_app']);
        $db->permission_event->createIndex([
            'trash' => -1,
        ], ['name' => 'permission_event_idx_trash']);
        Database::closeInstance();
    }
    public static function insert(PermissionEventEntity &$record)
    {
        $db = Database::getInstance();
        if ($record->getId()) {
            throw new Exception('Esse método serve inserir registros e não alterar');
        }
        $record->insert($db);
        Database::closeInstance();
    }
    public static function update(PermissionEventEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método serve alterar registros e não inserir');
        }
        $record->update($db);
        Database::closeInstance();
    }
    public static function delete(PermissionEventEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método deve conter um ID');
        }
        $record->delete($db);
        Database::closeInstance();
    }
}
