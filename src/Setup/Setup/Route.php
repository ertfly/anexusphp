<?php

namespace AnexusPHP\Setup\Setup;

use AnexusPHP\Interfaces\Anx\AnxInterface;
use AnexusPHP\Setup\Anx;
use Exception;

class Route extends Anx implements AnxInterface
{
    public function __construct($param, $option)
    {
        $this->run($param, $option);
    }

    public function run(array $params = [], array $option = []): void
    {
        try {
            if (!is_writable(PATH_ROOT)) {
                throw new Exception("");
            }

            // if (!file_exists(PATH_LOGS . 'start_execution')) {
            //     throw new Exception('Please start the application', 1);
            // }


            if (!isset($params['-a']) || trim($params['-a'] == '')) {
                throw new Exception('Error: param -a [app-name] is required', 1);
            }

            $app = ucwords($params['-a']);

            if (!is_dir(PATH_ROOT . 'src' . DS . $app)) {
                throw new Exception("The '{$app}' application doesn't exists", 1);
            }

            if (!isset($params['-m']) || trim($params['-m'] == '')) {
                throw new Exception('Error: param -m [module-name] is required', 1);
            }

            $module = ucwords($params['-m']);

            if (!is_dir(PATH_ROOT . 'src' . DS . $app . DS . 'Modules' . DS . $module)) {
                throw new Exception("The '{$module}' module doesn't exists", 1);
            }

            $path = strtolower('/' . ($app . '/' . $module));

            if (in_array('--crud', $option)) {
                $routeType = 'Crud';
            } else {
                $routeType = 'Index';
            }

            $route = $this->getTemplate('Route' . DS . $routeType . 'Route', [
                '{{app}}' => $app,
                '{{module}}' => $module,
                '{{prefix}}' => $path,
                '{{route}}' => ($app . $module)
            ]);

            //exit(chr(10) . 'ate agr deu certo' . chr(10));

            $files = [
                PATH_ROUTES . $app . DS . $module . 'Routes.php' => $route
            ];

            echo "\033[0;37m";

            foreach ($files as $key => $value) {
                $this->file_force_contents($key, $value);
            }
        } catch (Exception $e) {
            exit(chr(10) . $e->getMessage() . "\033[0m" . chr(10));
        }
    }

    public static function help()
    {
        echo "\033[0m" .  "    ___    _   ___  __" . "\033[0m" . chr(10);
        echo "\033[0m" .  "   /   |  / | / / |/ /" . "\033[0m" . chr(10);
        echo "\033[0m" .  "  / /| | /  |/ /|   / " . "\033[0m" . chr(10);
        echo "\033[0m" .  " / ___ |/ /|  //   |  " . "\033[0m" . chr(10);
        echo "\033[0m" .  "/_/  |_/_/ |_//_/|_|  " . "\033[0m" . chr(10);
        echo "\033[0m" .  "                      " . "\033[0m" . chr(10);

        echo "\033[1;33m" . "Usage:" . "\033[1;37m" . chr(10);
        echo "\tphp anx create-route [params]" . chr(10) . chr(10);

        echo "\033[1;33m" . "Params:" . "\033[1;37m" . chr(10);
        echo "\t-a [app-name]" . chr(10);
        echo "\t-m [module-name]" . chr(10);
        echo "\t--crud - Opitional: generate file with crud routes defined" . chr(10);
        echo "\t--help - See this helper" . chr(10);


        exit(chr(10));
    }
}
