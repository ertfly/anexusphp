<?php

namespace AnexusPHP\Business\Configuration\Constant;

use Exception;

class ConfigurationConstant
{
    const MIGRATION_VERSION = 1;

    private static $options = [
        self::MIGRATION_VERSION => 'Versão do Migration',
    ];

    public static function getOptions()
    {
        return self::$options;
    }

    public static function getOption($key)
    {
        if (!isset(self::$options[$key])) {
            throw new Exception('Opção inválida!');
        }

        return self::$options[$key];
    }

    public static function hasOption($key)
    {
        if (!isset(self::$options[$key])) {
            return false;
        }

        return true;
    }
}
