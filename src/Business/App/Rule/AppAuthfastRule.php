<?php

namespace AnexusPHP\Business\App\Rule;

use AnexusPHP\Business\App\Entity\AppAuthfastEntity;
use AnexusPHP\Core\Database;
use Exception;

class AppAuthfastRule
{
    public static function install()
    {
        $db = Database::getInstance();
        $db->app_authfast->createIndex([
            'app_id' => 1,
            'authfast_id' => 1,
        ], ['name' => 'app_authfast_idx_app_id_authfast_id']);
        $db->app_authfast->createIndex([
            'app_id' => 1,
        ], ['name' => 'app_authfast_idx_app_id']);
        $db->app_authfast->createIndex([
            'authfast_id' => 1,
        ], ['name' => 'app_authfast_idx_authfast_id']);
        Database::closeInstance();
    }
    public static function insert(AppAuthfastEntity &$record)
    {
        $db = Database::getInstance();
        if ($record->getId()) {
            throw new Exception('Esse método serve inserir registros e não alterar');
        }
        $record->insert($db);
        Database::closeInstance();
    }
    public static function update(AppAuthfastEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método serve alterar registros e não inserir');
        }
        $record->update($db);
        Database::closeInstance();
    }
    public static function destroy(AppAuthfastEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método deve conter um ID');
        }
        $record->destroy($db);
        Database::closeInstance();
    }
}
