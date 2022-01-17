<?php

namespace PequiPHP\Business\Api\Rule;

use PequiPHP\Business\Api\Entity\ApiKeyEntity;
use PequiPHP\Core\Database;

class ApiKeyRule
{
    public static function install()
    {
        $db = Database::getInstance();
        $db->{ApiKeyEntity::TABLE}->createIndex([
            'expired_at' => -1,
            'trash' => -1,
        ], ['name' => ApiKeyEntity::TABLE . '_idx_expired_at']);
        $db->{ApiKeyEntity::TABLE}->createIndex([
            'secret_key' => 1,
            'trash' => -1,
        ], ['name' => ApiKeyEntity::TABLE . '_idx_secret_key']);
        $db->{ApiKeyEntity::TABLE}->createIndex([
            'app_key' => 1,
            'trash' => -1,
        ], ['name' => ApiKeyEntity::TABLE . '_idx_app_key']);
        $db->{ApiKeyEntity::TABLE}->createIndex([
            'api_id' => 1,
            'trash' => -1,
        ], ['name' => ApiKeyEntity::TABLE . '_idx_api_id']);
        $db->{ApiKeyEntity::TABLE}->createIndex([
            'trash' => -1,
        ], ['name' => ApiKeyEntity::TABLE . '_idx_trash']);
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
