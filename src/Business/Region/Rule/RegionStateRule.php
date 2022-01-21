<?php

namespace AnexusPHP\Business\Region\Rule;

use AnexusPHP\Business\Region\Entity\RegionStateEntity;
use AnexusPHP\Core\Database;
use Exception;

class RegionStateRule
{
    public static function install()
    {
        $db = Database::getInstance();
        $db->{RegionStateEntity::TABLE}->createIndex([
            'country_id' => 1,
        ], ['name' => RegionStateEntity::TABLE . '_idx_country_id']);
        $db->{RegionStateEntity::TABLE}->createIndex([
            'initials' => 1,
        ], ['name' => RegionStateEntity::TABLE . '_idx_initials']);
        Database::closeInstance();
    }
    public static function insert(RegionStateEntity &$record)
    {
        $db = Database::getInstance();
        if ($record->getId()) {
            throw new Exception('Esse método serve inserir registros e não alterar');
        }
        $record->insert($db);
        Database::closeInstance();
    }
    public static function update(RegionStateEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método serve alterar registros e não inserir');
        }
        $record->update($db);
        Database::closeInstance();
    }
    public static function destroy(RegionStateEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método deve conter um ID');
        }
        $record->destroy($db);
        Database::closeInstance();
    }
}
