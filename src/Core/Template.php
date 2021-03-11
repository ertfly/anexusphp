<?php

namespace Core;

use AnexusPHP\Business\Configuration\Repository\ConfigurationRepository;
use Exception;

class Template
{
    private static $setting;

    public static function init()
    {
        if (self::$setting) {
            self::$setting = @json_decode(ConfigurationRepository::getValue('template_config'));
            if (!self::$setting) {
                self::$setting = [];
            }
        }
    }

    public static function getSetting()
    {
        self::init();
        return self::$setting;
    }

    public static function getSettingByKey($name)
    {
        self::init();
        if (!isset(self::$setting[$name])) {
            throw new Exception('Variable ' . $name . ' not exist in template');
        }

        return self::$setting[$name];
    }
}
