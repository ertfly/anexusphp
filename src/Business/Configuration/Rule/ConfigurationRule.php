<?php

namespace PequiPHP\Business\Configuration\Rule;

use PequiPHP\Business\Configuration\Entity\ConfigurationEntity;
use PequiPHP\Business\Configuration\Repository\ConfigurationRepository;
use PequiPHP\Core\Database;
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
