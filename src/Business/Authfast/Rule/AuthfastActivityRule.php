<?php

namespace AnexusPHP\Business\Authfast\Rule;

use AnexusPHP\Business\Authfast\Entity\AuthfastActivityEntity;

use AnexusPHP\Core\Database;
use Exception;

class AuthfastActivityRule
{
    public static function install()
    {
        $db = Database::getInstance();
        $db->{AuthfastActivityEntity::TABLE}->createIndex([
            'authfast_id' => 1,
        ], ['name' => AuthfastActivityEntity::TABLE . '_idx_authfast_id']);
        $db->{AuthfastActivityEntity::TABLE}->createIndex([
            'app_id' => 1,
        ], ['name' => AuthfastActivityEntity::TABLE . '_idx_app_id']);
        $db->{AuthfastActivityEntity::TABLE}->createIndex([
            'manager' => 1,
        ], ['name' => AuthfastActivityEntity::TABLE . '_idx_manager']);
        $db->{AuthfastActivityEntity::TABLE}->createIndex([
            'permission_event_id' => 1,
        ], ['name' => AuthfastActivityEntity::TABLE . '_idx_permission_event_id']);
        $db->{AuthfastActivityEntity::TABLE}->createIndex([
            'permission_module_id' => 1,
        ], ['name' => AuthfastActivityEntity::TABLE . '_idx_permission_module_id']);
        $db->{AuthfastActivityEntity::TABLE}->createIndex([
            'bind_id' => 1,
        ], ['name' => AuthfastActivityEntity::TABLE . '_idx_bind_id']);
        $db->{AuthfastActivityEntity::TABLE}->createIndex([
            'bind_table' => 1,
        ], ['name' => AuthfastActivityEntity::TABLE . '_idx_bind_table']);
        $db->{AuthfastActivityEntity::TABLE}->createIndex([
            'created_at' => 1,
        ], ['name' => AuthfastActivityEntity::TABLE . '_idx_created_at']);
        Database::closeInstance();
    }
    public static function insert(AuthfastActivityEntity &$record)
    {
        $db = Database::getInstance();
        if ($record->getId()) {
            throw new Exception('Esse método serve inserir registros e não alterar');
        }
        $record->insert($db);
        Database::closeInstance();
    }
    public static function update(AuthfastActivityEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método serve alterar registros e não inserir');
        }
        $record->update($db);
        Database::closeInstance();
    }
    public static function destroy(AuthfastActivityEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método deve conter um ID');
        }
        $record->destroy($db);
        Database::closeInstance();
    }
}
