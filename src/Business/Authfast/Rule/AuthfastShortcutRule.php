<?php

namespace AnexusPHP\Business\Permission\Rule;

use AnexusPHP\Business\Permission\Entity\AuthfastShortcutEntity;
use AnexusPHP\Core\Database;
use Exception;

class AuthfastShortcutRule
{
    public static function install()
    {
        $db = Database::getInstance();
        $db->{AuthfastShortcutEntity::TABLE}->createIndex([
            'authfast_id' => 1,
        ], ['name' => AuthfastShortcutEntity::TABLE . '_idx_authfast_id']);
        $db->{AuthfastShortcutEntity::TABLE}->createIndex([
            'shortcut' => 1,
        ], ['name' => AuthfastShortcutEntity::TABLE . '_idx_shortcut']);
        $db->{AuthfastShortcutEntity::TABLE}->createIndex([
            'authfast_id' => 1,
            'shortcut' => 1,
        ], ['name' => AuthfastShortcutEntity::TABLE . '_idx_authfast_id_shortcut']);
        Database::closeInstance();
    }
    public static function insert(AuthfastShortcutEntity &$record)
    {
        $db = Database::getInstance();
        if ($record->getId()) {
            throw new Exception('Esse método serve inserir registros e não alterar');
        }
        $record->insert($db);
        Database::closeInstance();
    }
    public static function update(AuthfastShortcutEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método serve alterar registros e não inserir');
        }
        $record->update($db);
        Database::closeInstance();
    }
    public static function destroy(AuthfastShortcutEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método deve conter um ID');
        }
        $record->destroy($db);
        Database::closeInstance();
    }
}
