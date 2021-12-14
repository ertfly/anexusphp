<?php

namespace AnexusPHP\Core;

use AnexusPHP\Core\Tools\Strings;
use Exception;

class Router
{
    private static $settings;
    private static $uri;

    public static function start($migration = true): void
    {
        self::init();

        //Arquivo de Métodos Globais
        require_once 'Helpers.php';
    }

    private static function init()
    {
        if (is_null(self::$settings)) {
            if (!is_file(PATH_ROOT . 'routes.php')) {
                throw new Exception('File /routes.php in PATH_ROOT is missing');
            }
            self::$settings = require_once(PATH_ROOT . 'routes.php');
        }
    }

    public static function getUri()
    {
        if (is_null(self::$uri)) {
            self::$uri = $_SERVER['REQUEST_URI'];
            self::$uri = Strings::removeInvisibleCharacters(self::$uri, false);
            self::$uri = explode('?', self::$uri);
            self::$uri = trim(self::$uri[0], '/');
        }

        return self::$uri;
    }

    public static function uriExist()
    {
        foreach (self::$settings as $uri => $setting) {
        }
    }
}
