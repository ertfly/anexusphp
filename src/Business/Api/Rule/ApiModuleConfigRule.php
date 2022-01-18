<?php

namespace AnexusPHP\Business\Api\Rule;

use AnexusPHP\Business\Api\Entity\ApiModuleConfigEntity;
use AnexusPHP\Core\Database;
use Exception;

class ApiModuleConfigRule
{
    public static function install()
    {
        $db = Database::getInstance();
        $db->{ApiModuleConfigEntity::TABLE}->createIndex([
            'api_module_id' => 1,
            'trash' => 1,
        ], ['name' => ApiModuleConfigEntity::TABLE . '_idx_api_module_id']);
        $db->{ApiModuleConfigEntity::TABLE}->createIndex([
            'trash' => 1,
        ], ['name' => ApiModuleConfigEntity::TABLE . '_idx_trash']);
        Database::closeInstance();
    }
    public static function insert(ApiModuleConfigEntity &$record)
    {
        $db = Database::getInstance();
        if ($record->getId()) {
            throw new Exception('Esse método serve inserir registros e não alterar');
        }
        $record->insert($db);
        Database::closeInstance();
    }
    public static function update(ApiModuleConfigEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método serve alterar registros e não inserir');
        }
        $record->update($db);
        Database::closeInstance();
    }
    public static function delete(ApiModuleConfigEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método deve conter um ID');
        }
        $record->delete($db);
        Database::closeInstance();
    }
}
