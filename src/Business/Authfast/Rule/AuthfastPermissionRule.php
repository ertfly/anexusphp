<?php

namespace PequiPHP\Business\Authfast\Rule;

use PequiPHP\Business\Authfast\Entity\AuthfastPermissionEntity;

use PequiPHP\Core\Database;
use Exception;

class AuthfastPermissionRule
{
    public static function install()
    {
        $db = Database::getInstance();
        $db->{AuthfastPermissionEntity::TABLE}->createIndex([
            'authfast_id' => 1,
        ], ['name' => AuthfastPermissionEntity::TABLE . '_idx_authfast_id']);
        $db->{AuthfastPermissionEntity::TABLE}->createIndex([
            'module_id' => 1,
        ], ['name' => AuthfastPermissionEntity::TABLE . '_idx_module_id']);
        Database::closeInstance();
    }
    public static function insert(AuthfastPermissionEntity &$record)
    {
        $db = Database::getInstance();
        if ($record->getId()) {
            throw new Exception('Esse método serve inserir registros e não alterar');
        }
        $record->insert($db);
        Database::closeInstance();
    }
    public static function update(AuthfastPermissionEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método serve alterar registros e não inserir');
        }
        $record->update($db);
        Database::closeInstance();
    }
    public static function destroy(AuthfastPermissionEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método deve conter um ID');
        }
        $record->destroy($db);
        Database::closeInstance();
    }
}
