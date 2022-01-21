<?php

namespace AnexusPHP\Business\Region\Repository;

use AnexusPHP\Business\Region\Entity\RegionCountryEntity;
use AnexusPHP\Business\Region\Entity\RegionStateEntity;
use AnexusPHP\Core\Database;
use PDO;

class RegionStateRepository
{
    /**
     * Retorna um registro da tabela pelo id
     * 
     * @param integer|null $id
     * @return RegionStateEntity
     */
    public static function byId($id)
    {
        $db = Database::getInstance();
        $cursor = $db->{RegionStateEntity::TABLE}->find(['_id' => intval($id)], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => RegionStateEntity::class,
            'document' => 'array',
        ]);
        Database::closeInstance();
        foreach ($cursor as $r) {
            return $r;
        }
        return new RegionStateEntity();
    }

    /**
     * Undocumented function
     *
     * @param RegionCountryEntity $country
     * @return RegionStateEntity[]
     */
    public static function byCountry(RegionCountryEntity $country)
    {
        $db = Database::getInstance();

        $where = [
            'country_id' => intval($country->getId()),
        ];

        $options = [
            'sort' => [
                'name' => 1
            ],
        ];

        $cursor = $db->{RegionStateEntity::TABLE}->find(
            $where,
            $options,
        );
        $cursor->setTypeMap([
            'root' => RegionStateEntity::class,
            'document' => 'array',
        ]);

        Database::closeInstance();

        $rows = [];
        foreach ($cursor as $r) {
            $rows[] = $r;
        }
        return $rows;
    }

    /**
     * Undocumented function
     *
     * @param string $initials
     * @return RegionStateEntity
     */
    public static function byInitials($initials)
    {
        $db = Database::getInstance();
        $cursor = $db->{RegionStateEntity::TABLE}->find(['initials' => $initials], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => RegionStateEntity::class,
            'document' => 'array',
        ]);
        Database::closeInstance();
        foreach ($cursor as $r) {
            return $r;
        }
        return new RegionStateEntity();
    }
}
