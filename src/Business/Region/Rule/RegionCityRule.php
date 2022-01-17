<?php

namespace Business\Region\Rule;

use PequiPHP\Business\Region\Entity\RegionCityEntity;
use PequiPHP\Core\Database;

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
