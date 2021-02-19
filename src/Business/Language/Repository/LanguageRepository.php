<?php

namespace AnexusPHP\Business\Language\Repository;

use AnexusPHP\Core\Database;
use AnexusPHP\Business\Language\Entity\LanguageEntity;
use AnexusPHP\Business\Region\Entity\RegionCountryEntity;
use PDO;

class LanguageRepository
{
    /**
     * @param string $id
     * @return LanguageEntity
     */
    public static function byId(?string $id)
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . LanguageEntity::TABLE . ' where id = :id limit 1', ['id' => $id])->fetchObject(LanguageEntity::class);
        if ($reg === false) {
            return new LanguageEntity();
        }

        return $reg;
    }

    /**
     * Undocumented function
     *
     * @param string|null $id
     * @param RegionCountryEntity $country
     * @return LanguageEntity
     */
    public static function byIdCountry(?string $id, RegionCountryEntity $country)
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . LanguageEntity::TABLE . ' where id = :id and region_country_id = :region_country_id limit 1', ['id' => $id, 'region_country_id' => $country->getId()])->fetchObject(LanguageEntity::class);
        if ($reg === false) {
            return new LanguageEntity();
        }

        return $reg;
    }

    /**
     * @return LanguageEntity[]
     */
    public static function all()
    {
        $db = Database::getInstance();
        $regs = $db->query('select * from ' . LanguageEntity::TABLE . ' order by id asc')->fetchAll(PDO::FETCH_CLASS, LanguageEntity::class);

        return $regs;
    }

    /**
     * @param integer $page
     * @param RegionCountryEntity $country
     * @return LanguageEntity[]
     */
    public static function byScreen(int $page, RegionCountryEntity $country)
    {
        $db = Database::getInstance();
        $regs = $db->query('select a.id, a.* from ' . LanguageEntity::TABLE . ' a where region_country_id = :region_country_id and screen_id = :screen_id order by id asc', ['region_country_id' => (int)$country->getId(), 'screen_id' => (int)$page])->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_UNIQUE, LanguageEntity::class);

        return $regs;
    }

    /**
     * @param RegionCountryEntity $country
     * @return LanguageEntity[]
     */
    public static function byCountry(RegionCountryEntity $country)
    {
        $db = Database::getInstance();
        $regs = $db->query('select a.* from ' . LanguageEntity::TABLE . ' a where region_country_id = :region_country_id order by id asc', ['region_country_id' => (int)$country->getId()])->fetchAll(PDO::FETCH_CLASS, LanguageEntity::class);

        return $regs;
    }
}
