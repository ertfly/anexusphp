<?php

namespace AnexusPHP\Business\App\Rule;

use AnexusPHP\Business\Configuration\Constant\ConfigurationConstant;
use AnexusPHP\Business\Configuration\Repository\ConfigurationRepository;
use AnexusPHP\Business\Configuration\Rule\ConfigurationRule;
use AnexusPHP\Core\Database;

class MigrationRule
{
    public static function init()
    {
        $config = ConfigurationRepository::byId(ConfigurationConstant::MIGRATION_VERSION);
        if (!$config->getId()) {
            $config
                ->setId(ConfigurationConstant::MIGRATION_VERSION)
                ->setValue(0)
                ->setDescription('Versões do migration');
            $db = Database::getInstance();
            $config->insert($db);
            include PATH_MIGRATIONS . 'install.php';
        }

        if (is_file(PATH_MIGRATIONS . ($config->getValue() + 1) . '.php')) {
            self::loadScripts();
        }
    }

    public static function loadScripts()
    {
        $version = ConfigurationRepository::getValue(ConfigurationConstant::MIGRATION_VERSION);
        $check = true;
        while ($check) {
            $version++;
            if (!is_file(PATH_MIGRATIONS . $version . '.php')) {
                break;
            }
            ConfigurationRule::setValue(ConfigurationConstant::MIGRATION_VERSION, $version);
            include PATH_MIGRATIONS . $version . '.php';
        }
    }
}
