<?php

namespace AnexusPHP\Business\Configuration\Repository;

use AnexusPHP\Business\Configuration\Entity\ConfigurationEntity;
use AnexusPHP\Core\Database;
use PDO;

class ConfigurationRepository
{
    /**
     * Retorna um registro do banco pelo id
     *
     * @param string|null $id
     * @return ConfigurationEntity
     */
    public static function byId(?string $id)
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . ConfigurationEntity::TABLE . ' where id = :id limit 1', ['id' => $id])->fetchObject(ConfigurationEntity::class);
        if ($reg === false) {
            return new ConfigurationEntity();
        }

        return $reg;
    }

    /**
     * Retorna um registro do banco pelo id
     *
     * @param string|null $id
     * @return string
     */
    public static function getValue(?string $id)
    {
        $db = Database::getInstance();
        $reg = $db->query('select value from ' . ConfigurationEntity::TABLE . ' where id = :id limit 1', ['id' => $id])->fetchColumn();

        return $reg;
    }

    /**
     * Retorna um array com todas as configurações que tiverem a string fornecida
     *
     * @param string $match
     * @return ConfigurationEntity[]
     */
    public static function byMatch(string $match)
    {
        $db = Database::getInstance();
        $regs = $db->query('select * from ' . ConfigurationEntity::TABLE . " where lower(id) like concat('%', lower(:match), '%') order by id asc", ['match' => $match])->fetchAll(PDO::FETCH_CLASS, ConfigurationEntity::class);

        return $regs;
    }
}