<?php

namespace AnexusPHP\Business\Api\Rule;

use AnexusPHP\Business\Api\Entity\ApiKeyEntity;
use AnexusPHP\Core\Database;

class ApiKeyRule
{
    public static function install()
    {
        $db = Database::getInstance();
        $db->api_key->createIndex([
            'expired_at' => -1,
            'trash' => -1,
        ], ['name' => 'api_key_idx_expired_at']);
        $db->api_key->createIndex([
            'secret_key' => 1,
            'trash' => -1,
        ], ['name' => 'api_key_idx_secret_key']);
        $db->api_key->createIndex([
            'app_key' => 1,
            'trash' => -1,
        ], ['name' => 'api_key_idx_app_key']);
        $db->api_key->createIndex([
            'api_id' => 1,
            'trash' => -1,
        ], ['name' => 'api_key_idx_api_id']);
        $db->api_key->createIndex([
            'trash' => -1,
        ], ['name' => 'api_key_idx_trash']);
        Database::closeInstance();
    }
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
