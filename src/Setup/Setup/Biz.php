<?php

namespace AnexusPHP\Setup\Setup;

use AnexusPHP\Interfaces\Anx\AnxInterface;
use AnexusPHP\Setup\Anx;
use Exception;

class Biz extends Anx implements AnxInterface
{
    public function __construct($params)
    {
        $this->run($params);
    }

    public function run(array $params = []):void
    {
        try {
            if (!is_writable(PATH_ROOT)) {
                throw new Exception("");
            }

            // if (!file_exists(PATH_LOGS . 'start_execution')) {
            //     throw new Exception('Please start the application', 1);
            // }

            if (!isset($params[0]) || trim($params[0] == '')) {
                throw new Exception('Error: param [business-name] is required', 1);
            }

            $biz = ucwords($params[0]);

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
}
