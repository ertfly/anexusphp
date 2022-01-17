<?php

namespace PequiPHP\Business\Authfast\Rule;

use PequiPHP\Business\Authfast\Entity\AuthfastActivityEntity;

use PequiPHP\Core\Database;
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
