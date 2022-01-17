<?php

namespace PequiPHP\Business\App\Rule;

use PequiPHP\Business\App\Entity\AppEntity;
use PequiPHP\Core\Database;

class AppRule
{
    public static function install()
    {
        $db = Database::getInstance();
        $db->{AppEntity::TABLE}->createIndex([
            'name' => 1,
        ], ['name' => AppEntity::TABLE . '_idx_name']);
        $db->{AppEntity::TABLE}->createIndex([
            'key' => 1,
        ], ['name' => AppEntity::TABLE . '_idx_key']);
        Database::closeInstance();
    }
    public static function insert(AppEntity &$record)
    {
        $db = Database::getInstance();
        if ($record->getId()) {
            throw new \Exception('Esse método serve inserir registros e não alterar');
        }
        $record->insert($db);
        Database::closeInstance();
    }
    public static function update(AppEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new \Exception('Esse método serve alterar registros e não inserir');
        }
        $record->update($db);
        Database::closeInstance();
    }
}
