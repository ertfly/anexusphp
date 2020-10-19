<?php

namespace AnexusPHP\Business\Region\Repository;

use AnexusPHP\Business\Region\Entity\RegionCountryEntity;
use AnexusPHP\Core\Database;
use PDO;

class RegionCountryRepository
{
    /**
     * Retorna um registro pelo id
     *
     * @param integer|null $id
     * @param mixe $className
     * @return RegionCountryEntity
     */
    public static function perId(?int $id, $className): RegionCountryEntity
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . RegionCountryEntity::TABLE . ' where id = :id limit 1', ['id' => (int)$id])->fetchObject($className);
        if ($reg === false) {
            return new $className();
        }

        return $reg;
    }

    /**
     * Retorna um registro da tabela pelo pais
     *
     * @param string|null $locale
     * @param mixed $className
     * @return RegionCountryEntity
     */
    public static function porRegione(?string $locale, $className): RegionCountryEntity
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . RegionCountryEntity::TABLE . ' where "locale" = :locale limit 1', ['locale' => $locale])->fetchObject($className);
        if ($reg === false) {
            return new $className();
        }

        return $reg;
    }

    /**
     * Retorna todos os registros do banco
     *
     * @param mixed $className
     * @return RegionCountryEntity
     */
    public static function todos($className)
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . RegionCountryEntity::TABLE . ' order by id asc')->fetchAll(PDO::FETCH_CLASS, $className);

        return $reg;
    }

    /**
     * Retorna todos os registros visiveis do banco
     *
     * @param mixed $className
     * @return RegionCountryEntity
     */
    public static function allVisible($className)
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . RegionCountryEntity::TABLE . ' where visible is true order by id asc')->fetchAll(PDO::FETCH_CLASS, $className);

        return $reg;
    }

    /**
     * Retorna um registro do banco pela sigla
     *
     * @param string $initials
     * @param mixed $className
     * @return RegionCountryEntity
     */
    public static function perInitials(string $initials, $className): RegionCountryEntity
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . RegionCountryEntity::TABLE . ' where sigla = :sigla limit 1', ['sigla' => $initials])->fetchObject($className);
        if ($reg === false) {
            return new $className();
        }

        return $reg;
    }

    /**
     * Retorna o registro do pais principal
     *
     * @param mixed $className
     * @return RegionCountryEntity
     */
    public static function principal($className): RegionCountryEntity
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . RegionCountryEntity::TABLE . ' where principal is true limit 1')->fetchObject($className);
        if ($reg === false) {
            return new $className();
        }

        return $reg;
    }
}
