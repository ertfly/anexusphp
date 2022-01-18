<?php

namespace Business\Api\Rule;

use AnexusPHP\Business\Api\Entity\ApiModuleEntity;
use AnexusPHP\Core\Database;

class ApiModuleRule
{
    public static function install()
    {
        $db = Database::getInstance();
        $db->{ApiModuleEntity::TABLE}->createIndex([
            'trash' => 1,
        ], ['name' => ApiModuleEntity::TABLE . '_idx_trash']);
        Database::closeInstance();
    }
    public static function insert(ApiModuleEntity &$record)
    {
        $db = Database::getInstance();
        if ($record->getId()) {
            throw new \Exception('Esse método serve inserir registros e não alterar');
        }
        $record->insert($db);
        Database::closeInstance();
    }
    public static function update(ApiModuleEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new \Exception('Esse método serve alterar registros e não inserir');
        }
        $record->update($db);
        Database::closeInstance();
    }
}