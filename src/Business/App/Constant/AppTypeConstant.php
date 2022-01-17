<?php

namespace AnexusPHP\Business\App\Constant;

use Exception;

class AppTypeConstant
{
    const BROWSER = 'N';
    const ANDROID = 'A';
    const IOS = 'I';
    public static $options = [
        self::BROWSER => 'Navegador de internet',
        self::ANDROID => 'Android',
        self::IOS => 'IOS',
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
    public static function has($key)
    {
        if (!isset(self::$options[$key])) {
            return false;
        }

        return true;
    }
}
