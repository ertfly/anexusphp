<?php

namespace AnexusPHP\Setup\Setup;

use AnexusPHP\Interfaces\Anx\AnxInterface;
use AnexusPHP\Setup\Anx;
use Exception;

class App extends Anx implements AnxInterface
{
    public function __construct($param, $option)
    {
        $this->run($param, $option);
    }

    public function run(array $param = [], array $option = []): void
    {        
        try {
            if (!is_writable(PATH_ROOT)) {
                throw new Exception("");
            }

            if (!file_exists(PATH_LOGS . 'start_execution')) {
                throw new Exception('Please start the application', 1);
            }

            if (!isset($param['-a']) || trim($param['-a'] == '')) {
                throw new Exception('The app must contain a name', 1);
            }

            $app = ucwords($param['-a']);

            if (is_dir(PATH_ROOT . 'src/' . $app)) {
                throw new Exception("The '{$app}' already exists", 1);
            }

            $middleware = $this->getTemplate('Middleware' . DS . 'ViewEngine', [
                '{{app}}' => $app
            ]);

            $template = $this->getTemplate('Template' . DS . 'EmptyTemplate', [
                '{{app}}' => $app
            ]);

            $files = [
                PATH_ROOT . 'src' . DS . $app . DS . 'Modules/Middleware.php' => $middleware,
                PATH_ROOT . 'src' . DS . $app . DS . 'Template.php' => $template,
            ];

            foreach ($files as $key => $value) {
                $this->file_force_contents($key, $value);
            }

            if(isset($param['-m']) && trim($param['-m'] != '')) {
                new Module([
                    '-a' => $app,
                    '-m' => $app,
                    '-r' => strtolower((isset($param['-r']) && trim($param['-r']) != '' ? $param['-r'] : $app))
                ],[]);
            }
        } catch (Exception $e) {
            if ($e->getCode() == 1) {
                exit(chr(10) . $e->getMessage() . chr(10));
            }
            exit(chr(10) . 'Folder permissions error' . chr(10));
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
        echo "\tphp anx create-app [params]" . chr(10) . chr(10);

        echo "\033[1;33m" . "Params:" . "\033[1;37m" . chr(10);
        echo "\t-a [app-name]" . chr(10);
        echo "\t-m [optional-module-name]" . chr(10);
        echo "\t-r [optional-route]" . chr(10);
        echo "\t--help - See this helper" . chr(10);


        exit(chr(10));
    }
}
