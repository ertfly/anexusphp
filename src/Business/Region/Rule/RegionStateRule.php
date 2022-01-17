<?php

namespace Business\Region\Rule;

use AnexusPHP\Business\Region\Entity\RegionStateEntity;
use AnexusPHP\Core\Database;

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
}
