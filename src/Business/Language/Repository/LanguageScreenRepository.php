<?php

namespace AnexusPHP\Business\Language\Repository;

use AnexusPHP\Business\Language\Entity\LanguageEntity;
use AnexusPHP\Core\Database;
use PDO;

class LanguageScreenRepository
{
    /**
     * Retorna um registro do banco pelo id
     *
     * @param integer|null $id
     * @return LanguageEntity
     */
    public static function perId(?int $id)
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . LanguageEntity::TABLE . ' where id = :id limit 1', ['id' => $id])->fetchObject(LanguageEntity::class);
        if ($reg === false) {
            return new LanguageEntity();
        }

        return $reg;
    }

    /**
     * Retorna todos os registros do banco
     *
     * @return LanguageEntity[]
     */
    public static function all()
    {
        $db = Database::getInstance();
        $regs = $db->query('select * from ' . LanguageEntity::TABLE . ' order by id asc')->fetchAll(PDO::FETCH_CLASS, LanguageEntity::class);

        return $regs;
    }

    /**
     * Retorna todos os registros do banco por tela
     *
     * @param integer $page
     * @param integer $country
     * @return LanguageEntity
     */
    public static function perScreen(int $page, int $country)
    {
        $db = Database::getInstance();
        $regs = $db->query('select a.id, a.* from ' . LanguageEntity::TABLE . ' a where region_country_id = :region_country_id and screen_id = :screen_id order by id asc', ['region_country_id' => (int)$country, 'screen_id' => (int)$page])->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_UNIQUE, LanguageEntity::class);

        return $regs;
    }

    /**
     * Retorna todos os registros do banco por pais
     *
     * @param integer $country
     * @return LanguageEntity
     */
    public static function perCountry(int $country)
    {
        $db = Database::getInstance();
        $regs = $db->query('select a.* from ' . LanguageEntity::TABLE . ' a where region_country_id = :region_country_id order by id asc', ['region_country_id' => (int)$country])->fetchAll(PDO::FETCH_CLASS, LanguageEntity::class);

        return $regs;
    }
}
