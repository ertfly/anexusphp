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
     * @param string $id
     * @return ConfigurationEntity
     */
    public static function byId($id)
    {
        $db = Database::getInstance();
        $cursor = $db->{ConfigurationEntity::TABLE}->find(['_id' => strval($id)], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => ConfigurationEntity::class,
            'document' => 'array',
        ]);
        Database::closeInstance();
        foreach ($cursor as $r) {
            return $r;
        }
        return new ConfigurationEntity();
    }

    /**
     * Retorna um registro do banco pelo id
     *
     * @param string|null $id
     * @return string
     */
    public static function getValue($id)
    {
        $db = Database::getInstance();
        $cursor = $db->{ConfigurationEntity::TABLE}->find(['_id' => strval($id)], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => ConfigurationEntity::class,
            'document' => 'array',
        ]);
        Database::closeInstance();
        foreach ($cursor as $r) {
            return $r->getValue();
        }
        return null;
    }
}
