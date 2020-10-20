<?php

namespace AnexusPHP\Setup\Setup;

use AnexusPHP\Interfaces\Anx\AnxInterface;
use AnexusPHP\Setup\Anx;
use Exception;

class App extends Anx implements AnxInterface
{
    public function __construct($params)
    {
        $this->run($params);
    }

    public function run(array $params = []): void
    {
        define('DS', DIRECTORY_SEPARATOR);
        define('PATH_ROOT', dirname(__FILE__) . DS);
        define('PATH_PUBLIC', PATH_ROOT . 'public' . DS);
        define('PATH_CACHE', PATH_ROOT . 'cache' . DS);
        define('PATH_LOGS', PATH_ROOT . 'logs' . DS);
        define('PATH_UPLOADS', PATH_PUBLIC . 'uploads' . DS);
        define('PATH_MIGRATIONS', PATH_ROOT . 'migrations' . DS);
        define('PATH_ROUTES', PATH_ROOT . 'routes' . DS);
        
        try {
            if (!is_writable(PATH_ROOT)) {
                throw new Exception("");
            }

            if (!file_exists(PATH_LOGS . 'start_execution')) {
                throw new Exception('Please start the application', 1);
            }

            if (!isset($params[0]) || trim($params[0] == '')) {
                throw new Exception('The app must contain a name', 1);
            }

            $app = ucwords($params[0]);

            if (is_dir(PATH_ROOT . 'src/' . $app)) {
                throw new Exception('This App already exists', 1);
            }

            // var_dump(ucwords($params[0]));
            // exit;
            $files = [
                PATH_ROOT . 'src' . DS . $app . DS . 'Modules/Middleware.php' => "<?php\n\nnamespace $app\Modules;\n\nuse Pecee\Http\Middleware\IMiddleware;\nuse Pecee\Http\Request;\n\nclass Middleware implements IMiddleware\n{\n    public function handle(Request \$request): void\n    {\n        \n    }\n}\n",
                PATH_ROOT . 'src' . DS . $app . DS . 'Template.php' => "<?php\n\nnamespace $app;\n\nclass Template\n{\n    \n}\n",
                PATH_ROOT . 'src' . DS . $app . DS . 'Modules' . DS . $app .DS .'Controllers' . DS . $app . 'Controller.php' => '',
                PATH_ROOT . 'src' . DS . $app . DS . 'Modules' . DS . $app .DS .'Models' . DS . $app . 'Model.php' => '',
                PATH_ROUTES . $app . DS . $app . 'Routes.php' => ''
            ];

            var_dump($files);
            exit;

            // foreach ($files as $key => $value) {
            //     $this->file_force_contents($key, $value);
            // }
        } catch (Exception $e) {
            if ($e->getCode() == 1) {
                exit(chr(10) . $e->getMessage() . chr(10));
            }
            exit(chr(10) . 'Folder permissions error' . chr(10));
        }
    }
}
