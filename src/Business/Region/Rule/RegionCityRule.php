<?php

namespace Business\Region\Rule;

use AnexusPHP\Business\Region\Entity\RegionCityEntity;
use AnexusPHP\Core\Database;

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
}
