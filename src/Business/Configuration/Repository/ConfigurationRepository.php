<?php

namespace PequiPHP\Business\Configuration\Repository;

use PequiPHP\Business\Configuration\Entity\ConfigurationEntity;
use PequiPHP\Core\Database;
use PDO;

class ConfigurationRepository
{
    /**
     * Retorna um registro do banco pelo id
     *
     * @param string|null $id
     * @return ConfigurationEntity
     */
    public static function byId($id)
    {
        $db = Database::getInstance();
        $cursor = $db->{ConfigurationEntity::TABLE}->find(['_id' => intval($id)], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => ConfigurationEntity::class,
            'document' => ConfigurationEntity::class,
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
        $cursor = $db->{ConfigurationEntity::TABLE}->find(['_id' => intval($id)], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => ConfigurationEntity::class,
            'document' => ConfigurationEntity::class,
        ]);
        Database::closeInstance();
        foreach ($cursor as $r) {
            return $r->getValue();
        }
        return null;
    }
}
