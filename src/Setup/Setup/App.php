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
                throw new Exception("The '{$app}' already exists", 1);
            }

            $files = [
                PATH_ROOT . 'src' . DS . $app . DS . 'Modules/Middleware.php' => "<?php\n\nnamespace $app\Modules;\n\nuse Pecee\Http\Middleware\IMiddleware;\nuse Pecee\Http\Request;\n\nclass Middleware implements IMiddleware\n{\n    public function handle(Request \$request): void\n    {\n        \n    }\n}\n",
                PATH_ROOT . 'src' . DS . $app . DS . 'Template.php' => "<?php\n\nnamespace $app;\n\nclass Template\n{\n    \n}\n",
            ];

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
}
