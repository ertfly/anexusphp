<?php

namespace AnexusPHP\Business\Api\Rule;

use AnexusPHP\Business\Api\Entity\ApiEntity;
use AnexusPHP\Core\Database;

class ApiRule
{
    public static function insert(ApiEntity &$record)
    {
        $db = Database::getInstance();
        if ($record->getId()) {
            throw new \Exception('Esse método serve inserir registros e não alterar');
        }
        $record
            ->setCreatedAt(date('Y-m-d H:i:s'))
            ->save($db);
    }
    public static function update(ApiEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new \Exception('Esse método serve alterar registros e não inserir');
        }
        $record
            ->setUpdatedAt(date('Y-m-d H:i:s'))
            ->save($db);
    }
    public static function destroy(ApiEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new \Exception('Esse método deve conter um ID');
        }
        $record->destroy($db);
    }
}
