<?php

namespace AnexusPHP\Setup\Setup;

use AnexusPHP\Interfaces\Anx\AnxInterface;
use AnexusPHP\Setup\Anx;
use Exception;

class Module extends Anx implements AnxInterface
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
                throw new Exception('The module must contain a app', 1);
            }

            if (!isset($param['-m']) || trim($param['-m'] == '')) {
                throw new Exception('The module must contain a name', 1);
            }

            $app = ucwords($param['-a']);
            if (!is_dir(PATH_ROOT . 'src/' . $app)) {
                throw new Exception("The App '{$app}' do not exists", 1);
            }

            $module = ucwords($param['-m']);
            if (!is_dir(PATH_ROOT . 'src/' . $app)) {
                throw new Exception("The Module '{$app}' already exists", 1);
            }

            $path = strtolower((isset($param['-r']) && trim($param['-r']) != '' ? $param['-r'] : '/' . ($app == $module ? $app : $app . '/' . $module)));

            if (in_array('--crud-controller', $option)) {
                $files = $this->crud($app, $module, $path);
            } else {
                $files = $this->single($app, $module, $path);
            }

            foreach ($files as $key => $value) {
                $this->file_force_contents($key, $value);
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

        echo "\033[1;33m" . "Usage:" . "\033[0m" . chr(10);
        echo "\tphp anx create-module [params]" . chr(10) . chr(10);

        echo "\033[1;33m" . "Params:" . "\033[0m" . chr(10);
        echo "\t-a [app-name]" . chr(10) ;
        echo "\t-m [module-name]" . chr(10);
        echo "\t-r [optional-route]" . chr(10);
        echo "\t--crud-controller - Optional: generate controler with crud methods" . chr(10);
        echo "\t--help - See this helper" . chr(10);


        exit(chr(10));
    }

    private function single($app, $module, $path)
    {
        $controller = $this->getTemplate('Controller' . DS . 'BasicController', [
            '{{app}}' => $app,
            '{{module}}' => $module,
            '{{view}}' => strtolower("$module/index")
        ]);

        $model = $this->getTemplate('Model' . DS . 'SubmitModel', [
            '{{app}}' => $app,
            '{{module}}' => $module
        ]);

        $route = $this->getTemplate('Route' . DS . 'IndexRoute', [
            '{{app}}' => $app,
            '{{module}}' => $module,
            '{{prefix}}' => $path,
            '{{route}}' => ($app == $module ? $app : $app . $module)
        ]);

        return [
            PATH_ROOT . 'src' . DS . $app . DS . 'Modules' . DS . $module . DS . 'Controllers' . DS . $module . 'Controller.php' => $controller,
            PATH_ROOT . 'src' . DS . $app . DS . 'Modules' . DS . $module . DS . 'Models' . DS . $module . 'Model.php' => $model,
            PATH_ROOT . 'src' . DS . $app . DS . 'Views' . DS . strtolower($module) . DS . 'index.phtml' => $this->getTemplate('View' . DS . 'HelloWorld'),
            PATH_ROUTES . $app . DS . $module . 'Routes.php' => $route
        ];
    }

    private function crud($app, $module, $path)
    {
        $controller = $this->getTemplate('Controller' . DS . 'CrudController', [
            '{{app}}' => $app,
            '{{module}}' => $module,
            '{{view}}' => strtolower("$module")
        ]);

        $model = $this->getTemplate('Model' . DS . 'CrudModel', [
            '{{app}}' => $app,
            '{{module}}' => $module
        ]);

        $route = $this->getTemplate('Route' . DS . 'CrudRoute', [
            '{{app}}' => $app,
            '{{module}}' => $module,
            '{{prefix}}' => $path,
            '{{route}}' => ($app == $module ? $app : $app . $module)
        ]);

        return [
            PATH_ROOT . 'src' . DS . $app . DS . 'Modules' . DS . $module . DS . 'Controllers' . DS . $module . 'Controller.php' => $controller,
            PATH_ROOT . 'src' . DS . $app . DS . 'Modules' . DS . $module . DS . 'Models' . DS . $module . 'Model.php' => $model,
            PATH_ROOT . 'src' . DS . $app . DS . 'Views' . DS . strtolower($module) . DS . 'index.phtml' => $this->getTemplate('View' . DS . 'HelloWorld'),
            PATH_ROUTES . $app . DS . $module . 'Routes.php' => $route
        ];
    }
}
