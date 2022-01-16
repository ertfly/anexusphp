<?php

namespace AnexusPHP\Business\Api\Rule;

use AnexusPHP\Business\Api\Entity\ApiEntity;
use AnexusPHP\Core\Database;

class ApiRule
{
    public static function install()
    {
        $db = Database::getInstance();
        $db->api->createIndex([
            'name' => 1,
            'trash' => -1,
        ], ['name' => 'api_idx_name']);
        $db->api->createIndex([
            'trash' => -1,
        ], ['name' => 'api_idx_trash']);
        Database::closeInstance();
    }
    public static function insert(ApiEntity &$record)
    {
        $db = Database::getInstance();
        if ($record->getId()) {
            throw new \Exception('Esse método serve inserir registros e não alterar');
        }
        $record->insert($db);
        Database::closeInstance();
    }
    public static function update(ApiEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new \Exception('Esse método serve alterar registros e não inserir');
        }
        $record
            ->setUpdatedAt(strtotime(date('Y-m-d H:i:s')))
            ->update($db);
        Database::closeInstance();
    }
    public static function delete(ApiEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new \Exception('Esse método deve conter um ID');
        }
        $record
            ->setUpdatedAt(strtotime(date('Y-m-d H:i:s')))
            ->delete($db);
        Database::closeInstance();
    }
}
