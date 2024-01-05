<?php

namespace AnexusPHP\Core;

use AnexusPHP\Core\Migration;
use Pecee\SimpleRouter\SimpleRouter;

class Router extends SimpleRouter
{
    public static function loadHelper()
    {
        require_once dirname(__FILE__) . '/Helpers.php';
    }
    public static function start($migration = true): void
    {
        //Arquivo de Métodos Globais
        self::loadHelper();

        if ($migration) {
            Migration::init();
        }

        $arrUrl = explode('/', trim(url()->getPath(), '/'));
        $app = isset($arrUrl[0]) && trim($arrUrl[0]) != '' ? $arrUrl[0] : 'app';
        $app = str_replace('-', ' ', $app);
        $app = ucwords($app);
        $app = str_replace(' ', '', $app);
        if (!is_dir(PATH_ROUTES . $app)) {
            $app = 'App';
        }

        $scanDir = scandir(PATH_ROUTES . $app);
        unset($scanDir[0]);
        unset($scanDir[1]);
        $scanDir = array_values($scanDir);

        $j = count($scanDir);
        for ($i = 0; $i < $j; $i++) {
            require_once PATH_ROUTES . $app . DS . $scanDir[$i];
        }

        require_once PATH_ROUTES . 'ErrorRoutes.php';

        parent::start();        
    }
}
