<?php

namespace AnexusPHP\Business\Api\Rule;

use AnexusPHP\Business\Api\Entity\ApiKeyEntity;
use AnexusPHP\Core\Database;

class ApiKeyRule
{
    public static function insert(ApiKeyEntity &$record)
    {
        $db = Database::getInstance();
        if ($record->getId()) {
            throw new \Exception('Esse método serve inserir registros e não alterar');
        }
        $record->insert($db);
        
        Database::closeInstance();
    }
    public static function update(ApiKeyEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new \Exception('Esse método serve alterar registros e não inserir');
        }
        $record->update($db);
        
        Database::closeInstance();
    }
    public static function delete(ApiKeyEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new \Exception('Esse método deve conter um ID');
        }
        $record->delete($db);

        Database::closeInstance();
    }
}
