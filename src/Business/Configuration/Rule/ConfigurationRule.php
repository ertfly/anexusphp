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
        $config = ConfigurationRepository::byId($id);
        if (!$config->getId()) {
            throw new Exception('Configuração inválida!');
        }

        $config->setValue($value);
        $db = Database::getInstance();
        $config->update($db);
        Database::closeInstance();
    }
}
