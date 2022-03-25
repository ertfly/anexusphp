<?php

namespace Business\Region\Constant;

use Exception;

class RegionFormatConstant
{
    const NONE = 1;
    const MONEY = 2;
    const MONEY_EXCHANGE = 3;
    const POINT = 4;

    public static $options = [
        self::NONE => 'Nenhuma formatação',
        self::MONEY => 'Monetário',
        self::MONEY_EXCHANGE => 'Monetário com câmbio',
        self::POINT => 'Pontuação',
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
