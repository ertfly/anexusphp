<?php

namespace AnexusPHP\Core;

use Pecee\SimpleRouter\SimpleRouter;

class Router extends SimpleRouter
{
    public static function start(): void
    {
        //Arquivo de Métodos Globais
        require_once 'Helpers.php';

        Migration::init();

        $arrUrl = explode('/', trim(url()->getPath(), '/'));
        $app = isset($arrUrl[0]) && trim($arrUrl[0]) != '' ? $arrUrl[0] : 'app';
        $app = ucfirst($app);
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
