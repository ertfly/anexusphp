<?php

namespace AnexusPHP\Business\Region\Rule;

use AnexusPHP\Business\Region\Entity\RegionCountryEntity;
use AnexusPHP\Core\Database;
use Exception;

class RegionCountryRule
{
    public static function install()
    {
        $db = Database::getInstance();
        $db->{RegionCountryEntity::TABLE}->createIndex([
            'code' => 1,
        ], ['name' => RegionCountryEntity::TABLE . '_idx_code']);
        $db->{RegionCountryEntity::TABLE}->createIndex([
            'initials' => 1,
        ], ['name' => RegionCountryEntity::TABLE . '_idx_initials']);
        $db->{RegionCountryEntity::TABLE}->createIndex([
            'principal' => 1,
        ], ['name' => RegionCountryEntity::TABLE . '_idx_principal']);
        $db->{RegionCountryEntity::TABLE}->createIndex([
            'visible' => 1,
        ], ['name' => RegionCountryEntity::TABLE . '_idx_visible']);
        $db->{RegionCountryEntity::TABLE}->createIndex([
            'locale' => 1,
        ], ['name' => RegionCountryEntity::TABLE . '_idx_locale']);
        Database::closeInstance();
    }
    public static function update(RegionCountryEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método serve alterar registros e não inserir');
        }
        $record->update($db);
        Database::closeInstance();
    }
}
