<?php

namespace AnexusPHP\Setup\Setup;

use AnexusPHP\Interfaces\Anx\AnxInterface;
use AnexusPHP\Setup\Anx;
use Exception;

class Biz extends Anx implements AnxInterface
{
    public function __construct($param, $option)
    {
        $this->run($param, $option);
    }

    public function run(array $params = [], array $option = []):void
    {
        try {
            if (!is_writable(PATH_ROOT)) {
                throw new Exception("");
            }

            // if (!file_exists(PATH_LOGS . 'start_execution')) {
            //     throw new Exception('Please start the application', 1);
            // }


            if (!isset($params['-b']) || trim($params['-b'] == '')) {
                throw new Exception('Error: param [business-name] is required', 1);
            }

            $biz = ucwords($params['-b']);

            if (is_dir(PATH_ROOT . 'src/' . $biz)) {
                throw new Exception("The '{$biz}' business already exists", 1);
            }

            $files = [
                PATH_ROOT . 'src' . DS . $biz . DS . '.gitkeep' => ''
            ];

            echo "\033[0;37m";

            foreach ($files as $key => $value) {
                $this->file_force_contents($key, $value);
                echo 'Business created in: ' . str_replace(DS. '.gitkeep', '', $key);
            }

        } catch (Exception $e) {
            exit(chr(10) . $e->getMessage() . chr(10));
        }
    }

    public static function help()
    {
        echo "    ___    _   ___  __" . chr(10);
        echo "   /   |  / | / / |/ /" . chr(10);
        echo "  / /| | /  |/ /|   / " . chr(10);
        echo " / ___ |/ /|  //   |  " . chr(10);
        echo "/_/  |_/_/ |_//_/|_|  " . chr(10);
        echo "                      " . chr(10);

        echo "\033[1;33m" . "Usage:" . "\033[1;37m" . chr(10);
        echo "\tphp anx create-module -a [app] -m [module-name] -r [optional-route] --help - see this helper --crud-controller - Create controller with crud methods" . chr(10) . chr(10);

        exit(chr(10));
    }
}
