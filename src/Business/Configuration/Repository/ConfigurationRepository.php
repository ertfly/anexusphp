<?php

namespace AnexusPHP\Business\Configuration\Repository;

use AnexusPHP\Business\Configuration\Entity\ConfigurationEntity;
use AnexusPHP\Core\Database;

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
}