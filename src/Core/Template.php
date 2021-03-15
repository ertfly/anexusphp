<?php

namespace AnexusPHP\Core;

use AnexusPHP\Business\Configuration\Repository\ConfigurationRepository;

class Template
{
    private static $setting;

    public static function init()
    {
        if (!self::$setting) {
            self::$setting = @json_decode(ConfigurationRepository::getValue('template_config'), true);
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

    public static function getSettingByKey($name, $defaultValue = null, $isUpload = false)
    {
        self::init();
        if (!isset(self::$setting[$name])) {
            return $defaultValue;
        }

        return !$isUpload ? self::$setting[$name] : upload('template/' . self::$setting[$name]);
    }
}
