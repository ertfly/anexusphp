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
     * @param mixed $className
     * @return RegionCountryEntity
     */
    public static function byId($id, $className): RegionCountryEntity
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
     * @param RegionCountryEntity|null $country
     * @param mixed $className
     * @return RegionCountryEntity
     */
    public static function byLocale($locale, $className = RegionCountryEntity::class)
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
    public static function all($className = RegionCountryEntity::class)
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
    public static function allVisible($className = RegionCountryEntity::class)
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . RegionCountryEntity::TABLE . ' where visible is true order by id asc')->fetchAll(PDO::FETCH_CLASS, $className);

        return $reg;
    }

    /**
     * Retorna um registro do banco pela sigla
     *
     * @param RegionCountryEntity $country
     * @param mixed $className
     * @return RegionCountryEntity
     */
    public static function byInitials(RegionCountryEntity $country, $className = RegionCountryEntity::class)
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . RegionCountryEntity::TABLE . ' where initials = :initials limit 1', ['initials' => $country->getInitials()])->fetchObject($className);
        if ($reg === false) {
            return new $className();
        }

        return $reg;
    }

    /**
     * Undocumented function
     *
     * @param string $code
     * @param string $className
     * @return RegionCountryEntity
     */
    public static function byCode($code, $className = RegionCountryEntity::class)
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . RegionCountryEntity::TABLE . ' where code = :code limit 1', ['code' => $code])->fetchObject($className);
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
    public static function main($className): RegionCountryEntity
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . RegionCountryEntity::TABLE . ' where principal is true limit 1')->fetchObject($className);
        if ($reg === false) {
            return new $className();
        }

        return $reg;
    }
}
