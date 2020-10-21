<?php

namespace AnexusPHP\Setup\Setup;

use AnexusPHP\Core\Database;
use AnexusPHP\Interfaces\Anx\AnxInterface;
use AnexusPHP\Setup\Anx;
use Exception;
use PDO;

class Init extends Anx implements AnxInterface
{
    public function __construct($params)
    {
        $this->run($params);
    }

    public function run(array $params = []):void
    {
        // verificar se db existe
        try {
            $database = Database::getInstance();
        } catch (\PDOException $e) {
            exit(chr(10) . 'Database not found' . chr(10));
        }

        // criar as pastas básicas
        try {
            if (!is_writable(PATH_ROOT)) {
                throw new Exception("");
            }

            if (file_exists(PATH_LOGS . 'start_execution')) {
                throw new Exception("", 1);
            }

            $this->file_force_contents(PATH_LOGS . 'start_execution', serialize([
                'us_time' => date('Y-m-d H:i:s'),
                'command' => 'php anx init'
            ]));

            $files = [
                PATH_ROOT . 'src/.gitkeep' => '',
                PATH_MIGRATIONS . 'up/.gitkeep' => '',
                PATH_MIGRATIONS . 'down/.gitkeep' => '',
                PATH_MIGRATIONS . 'base.sql' => '',
                PATH_MIGRATIONS . 'dados.sql' => '',
                PATH_CACHE . '.gitkeep' => '',
                PATH_LOGS . '.gitkeep' => '',
                PATH_ROUTES . 'ErrorRoutes.php' => "<?php\n\nuse Pecee\Http\Request;\nuse Pecee\SimpleRouter\Exceptions\NotFoundHttpException;\nuse Pecee\SimpleRouter\SimpleRouter;\n\nSimpleRouter::error(function (Request \$request, \Exception \$exception)\n{\n\tif (\$exception instanceof NotFoundHttpException) {\n\t\treturn response()->redirect(url('not-found'));\n\t}\n});\n",
                PATH_PUBLIC . 'assets/index.html' => '',
                PATH_PUBLIC . 'uploads/index.html' => '',
                PATH_PUBLIC . '.htaccess' => "RewriteEngine On\nRewriteBase /\nRewriteCond %{REQUEST_FILENAME} !-f\nRewriteCond %{REQUEST_FILENAME} !-d\nRewriteRule ^(.*)$ /index.php [L]\n",
                PATH_PUBLIC . 'index.php' => "<?php\n\nuse AnexusPHP\Core\Router;\n\n//Define o timezone\ndate_default_timezone_set('America/Sao_Paulo');\n\n//Define o separador de diretorio\ndefine('DS', DIRECTORY_SEPARATOR);\n\ndefine('MODE', 'production');\ndefine('ASSETS_VERSION', '1.0');\ndefine('PATH_ROOT', dirname(__FILE__) . DS . '..' . DS);\ndefine('PATH_PUBLIC', PATH_ROOT . 'public' . DS);\ndefine('PATH_CACHE', PATH_ROOT . 'cache' . DS);\ndefine('PATH_LOGS', PATH_ROOT . 'logs' . DS);\ndefine('PATH_UPLOADS', PATH_PUBLIC . 'uploads' . DS);\ndefine('PATH_MIGRATIONS', PATH_ROOT . 'migrations' . DS);\ndefine('PATH_ROUTES', PATH_ROOT . 'routes' . DS);\n\ndefine('SESSION_LIFETIME', (60 * 30));\ndefine('SESSION_NAME', 'skeleton');\n\nrequire PATH_ROOT . 'vendor/autoload.php';\n\nRouter::start();\n//Arquivo apenas de início do sistema, nenhuma codificação deve vir aqui\n",
            ];

            foreach ($files as $key => $value) {
                $this->file_force_contents($key, $value);
            }
        } catch (Exception $e) {
            if ($e->getCode() == 1) {
                exit(chr(10) . 'The application has been started previously' . chr(10));
            }
            exit(chr(10) . 'Folder permissions error' . chr(10));
        }

        // criar as tabelas base
        try {
            $database->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, 1);
            $sql = file_get_contents(Anx::PATH_ANX_MIGRATION. 'init.sql');
            if(trim($sql) != '') {
                $database->exec($sql);
            }
        } catch (Exception $e) {
            exit(chr(10) . 'Base tables error' . chr(10));
        }
    }
}
