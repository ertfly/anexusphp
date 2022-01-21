<?php

namespace AnexusPHP\Business\Region\Rule;

use AnexusPHP\Business\Region\Entity\RegionCityEntity;
use AnexusPHP\Core\Database;
use Exception;

class RegionCityRule
{
    public static function install()
    {
        $db = Database::getInstance();
        $db->{RegionCityEntity::TABLE}->createIndex([
            'state_id' => 1,
        ], ['name' => RegionCityEntity::TABLE . '_idx_state_id']);
        $db->{RegionCityEntity::TABLE}->createIndex([
            'code' => 1,
        ], ['name' => RegionCityEntity::TABLE . '_idx_code']);
        Database::closeInstance();
    }
    public static function insert(RegionCityEntity &$record)
    {
        $db = Database::getInstance();
        if ($record->getId()) {
            throw new Exception('Esse método serve inserir registros e não alterar');
        }
        $record->insert($db);
        Database::closeInstance();
    }
    public static function update(RegionCityEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método serve alterar registros e não inserir');
        }
        $record->update($db);
        Database::closeInstance();
    }
    public static function destroy(RegionCityEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método deve conter um ID');
        }
        $record->destroy($db);
        Database::closeInstance();
    }
}
