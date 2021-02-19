<?php

namespace AnexusPHP\Business\Language\Repository;

use AnexusPHP\Business\Language\Entity\LanguageScreenEntity;
use AnexusPHP\Business\Region\Entity\RegionCountryEntity;
use AnexusPHP\Core\Database;
use PDO;

class LanguageScreenRepository
{
    /**
     * Retorna um registro do banco pelo id
     *
     * @param integer|null $id
     * @return LanguageScreenEntity
     */
    public static function byId(?int $id)
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . LanguageScreenEntity::TABLE . ' where id = :id limit 1', ['id' => $id])->fetchObject(LanguageScreenEntity::class);
        if ($reg === false) {
            return new LanguageScreenEntity();
        }

        return $reg;
    }

    /**
     * Retorna todos os registros do banco
     *
     * @return LanguageScreenEntity[]
     */
    public static function all()
    {
        $db = Database::getInstance();
        $regs = $db->query('select * from ' . LanguageScreenEntity::TABLE . ' order by id asc')->fetchAll(PDO::FETCH_CLASS, LanguageScreenEntity::class);

        return $regs;
    }

    /**
     * Retorna todos os registros do banco por tela
     *
     * @param integer $page
     * @param RegionCountryEntity $country
     * @return LanguageScreenEntity
     */
    public static function byScreen(int $page, RegionCountryEntity $country)
    {
        $db = Database::getInstance();
        $regs = $db->query('select a.id, a.* from ' . LanguageScreenEntity::TABLE . ' a where region_country_id = :region_country_id and screen_id = :screen_id order by id asc', ['region_country_id' => (int)$country->getId(), 'screen_id' => (int)$page])->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_UNIQUE, LanguageScreenEntity::class);

        return $regs;
    }

    /**
     * Retorna todos os registros do banco por pais
     *
     * @param RegionCountryEntity $country
     * @return LanguageScreenEntity
     */
    public static function byCountry(RegionCountryEntity $country)
    {
        $db = Database::getInstance();
        $regs = $db->query('select a.* from ' . LanguageScreenEntity::TABLE . ' a where region_country_id = :region_country_id order by id asc', ['region_country_id' => (int)$country->getId()])->fetchAll(PDO::FETCH_CLASS, LanguageScreenEntity::class);

        return $regs;
    }
}
