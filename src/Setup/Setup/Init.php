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
        // // verificar se db existe
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
                PATH_ROUTES . 'ErrorRoutes.php' => $this->getTemplate('Route' . DS . 'ErrorRoute'),
                PATH_PUBLIC . 'assets/index.html' => '',
                PATH_PUBLIC . 'uploads/index.html' => '',
                PATH_PUBLIC . '.htaccess' => $this->getTemplate('Configuration' . DS . 'htaccess'),
                PATH_PUBLIC . 'index.php' => $this->getTemplate('Configuration' . DS . 'index'),
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

        // // criar as tabelas base
        try {
            $database->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, 1);
            $sql = file_get_contents(PATH_MIGRATIONS . 'base.sql');
            if(trim($sql) != '') {
                $database->exec($sql);
            }
        } catch (Exception $e) {
            exit(chr(10) . 'Base tables error' . chr(10));
        }
    }
}
