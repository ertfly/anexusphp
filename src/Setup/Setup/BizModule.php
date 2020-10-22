<?php

namespace AnexusPHP\Setup\Setup;

use AnexusPHP\Interfaces\Anx\AnxInterface;
use AnexusPHP\Setup\Anx;
use Exception;

class BizModule extends Anx implements AnxInterface
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

            if (!file_exists(PATH_LOGS . 'start_execution')) {
                throw new Exception('Please start the application', 1);
            }

            if (!isset($params['-b']) || trim($params['-b'] == '')) {
                throw new Exception('Error: param -b [business-name] is required', 1);
            }

            if (!isset($params['-bm']) || trim($params['-bm'] == '')) {
                throw new Exception('Error: param -bm [business_module-name] is required', 1);
            }

            $biz = ucwords($params['-b']);
            $biz_module = ucwords($params['-bm']);

            if (!is_dir(PATH_ROOT . 'src/' . $biz)) {
                 throw new Exception("The '{$biz}' business doesn't exist", 1);
            }

            if (is_dir(PATH_ROOT . 'src/' . $biz_module)) {
                throw new Exception("The '{$biz_module}' module already exists", 1);
            }

            $files = [
                PATH_ROOT . 'src' . DS . $biz . DS . $biz_module . DS . '.gitkeep' => ''
            ];

            echo "\033[0;37m";

            foreach ($files as $key => $value) {
                $this->file_force_contents($key, $value);
                echo 'Business Module created in: ' . str_replace(DS. '.gitkeep', '', $key);
            }

        } catch (Exception $e) {
            exit(chr(10) . $e->getMessage() . chr(10));
        }
    }
}
