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
     * @param int $id
     * @param string $cls
     * @return RegionCountryEntity
     */
    public static function byId($id, $cls = RegionCountryEntity::class)
    {
        $db = Database::getInstance();
        $cursor = $db->{RegionCountryEntity::TABLE}->find(['_id' => intval($id)], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => $cls,
            'document' => $cls,
        ]);
        Database::closeInstance();
        foreach ($cursor as $r) {
            return $r;
        }
        return new RegionCountryEntity();
    }

    /**
     * Retorna um registro da tabela pelo pais
     *
     * @param RegionCountryEntity|null $country
     * @param mixed $className
     * @return RegionCountryEntity
     */
    public static function byLocale($locale, $cls = RegionCountryEntity::class)
    {
        $db = Database::getInstance();

        $cursor = $db->{RegionCountryEntity::TABLE}->find(['locale' => $locale], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => $cls,
            'document' => $cls,
        ]);
        Database::closeInstance();
        foreach ($cursor as $r) {
            return $r;
        }
        return new RegionCountryEntity();
    }

    /**
     * Retorna todos os registros do banco
     *
     * @param mixed $className
     * @return RegionCountryEntity
     */
    public static function all($cls = RegionCountryEntity::class)
    {
        $db = Database::getInstance();

        $where = [];

        $options = [
            'sort' => [
                '_id' => 1
            ],
        ];

        $cursor = $db->{RegionCountryEntity::TABLE}->find(
            $where,
            $options,
        );
        $cursor->setTypeMap([
            'root' => $cls,
            'document' => $cls,
        ]);

        Database::closeInstance();

        $rows = [];
        foreach ($cursor as $r) {
            $rows[] = $r;
        }
        return $rows;
    }

    /**
     * Retorna todos os registros visiveis do banco
     *
     * @param mixed $className
     * @return RegionCountryEntity
     */
    public static function allVisible($cls = RegionCountryEntity::class)
    {
        $db = Database::getInstance();

        $where = [
            'visible' => true,
        ];

        $options = [
            'sort' => [
                '_id' => 1
            ],
        ];

        $cursor = $db->{RegionCountryEntity::TABLE}->find(
            $where,
            $options,
        );
        $cursor->setTypeMap([
            'root' => $cls,
            'document' => $cls,
        ]);

        Database::closeInstance();

        $rows = [];
        foreach ($cursor as $r) {
            $rows[] = $r;
        }
        return $rows;
    }

    /**
     * Retorna um registro do banco pela sigla
     *
     * @param RegionCountryEntity $country
     * @param mixed $className
     * @return RegionCountryEntity
     */
    public static function byInitials(RegionCountryEntity $country, $cls = RegionCountryEntity::class)
    {
        $db = Database::getInstance();

        $cursor = $db->{RegionCountryEntity::TABLE}->find(['initials' => $country->getInitials()], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => $cls,
            'document' => $cls,
        ]);
        Database::closeInstance();
        foreach ($cursor as $r) {
            return $r;
        }
        return new RegionCountryEntity();
    }

    /**
     * Undocumented function
     *
     * @param string $code
     * @param string $className
     * @return RegionCountryEntity
     */
    public static function byCode($code, $cls = RegionCountryEntity::class)
    {
        $db = Database::getInstance();

        $cursor = $db->{RegionCountryEntity::TABLE}->find(['code' => $code], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => $cls,
            'document' => $cls,
        ]);
        Database::closeInstance();
        foreach ($cursor as $r) {
            return $r;
        }
        return new RegionCountryEntity();
    }

    /**
     * Retorna o registro do pais principal
     *
     * @param mixed $className
     * @return RegionCountryEntity
     */
    public static function main($cls = RegionCountryEntity::class)
    {
        $db = Database::getInstance();

        $cursor = $db->{RegionCountryEntity::TABLE}->find(['principal' => true], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => $cls,
            'document' => $cls,
        ]);
        Database::closeInstance();
        foreach ($cursor as $r) {
            return $r;
        }
        return new RegionCountryEntity();
    }
}
