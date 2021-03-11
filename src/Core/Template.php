<?php

namespace Core;

use AnexusPHP\Business\Configuration\Repository\ConfigurationRepository;

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

    public static function getSettingByKey($name, $defaultValue = null)
    {
        self::init();
        if (!isset(self::$setting[$name])) {
            return $defaultValue;
        }

        return self::$setting[$name];
    }
}
