<?php

namespace AnexusPHP\Business\Configuration\Rule;

use AnexusPHP\Business\Configuration\Entity\ConfigurationEntity;
use AnexusPHP\Business\Configuration\Repository\ConfigurationRepository;
use AnexusPHP\Core\Database;
use Exception;

class ConfigurationRule
{
    public static function setValue($id, $value)
    {
        $record = ConfigurationRepository::byId($id);
        if (!$record->getId()) {
            throw new Exception('Configuração inválida!');
        }

        $record->setValue($value);
        self::update($record);
    }
    public static function insert(ConfigurationEntity &$record)
    {
        $db = Database::getInstance();
        $record->insert($db);
        Database::closeInstance();
    }
    public static function update(ConfigurationEntity &$record)
    {
        $db = Database::getInstance();
        $record->update($db);
        Database::closeInstance();
    }
}
