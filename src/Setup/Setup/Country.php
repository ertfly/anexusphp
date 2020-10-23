<?php

namespace AnexusPHP\Setup\Setup;

use AnexusPHP\Core\Database;
use AnexusPHP\Interfaces\Anx\AnxInterface;
use AnexusPHP\Setup\Anx;
use Exception;
use PDO;

class Country extends Anx implements AnxInterface
{
    public function __construct($param, $option)
    {
        $this->run($param, $option);
    }

    public function run(array $param = [], array $option = []): void
    {
        // verificar se db existe
        try {
            $database = Database::getInstance();
        } catch (\PDOException $e) {
            exit(chr(10) . 'Database not found' . "\033[0m" . chr(10));
        }

        // insere todos os paises
        try {
            $database->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, 1);
            $sql = file_get_contents(Anx::PATH_ANX_MIGRATION . 'country.sql');
            if (trim($sql) != '') {
                $database->exec($sql);
            }
        } catch (Exception $e) {
            exit(chr(10) . 'Base tables error' . "\033[0m" . chr(10));
        }

        $flags = scandir(Anx::PATH_ANX_SOURCE.'Setup'.DS.'Base'.DS.'Flags');
        unset($flags[0]);
        unset($flags[1]);

        $files = [];
        foreach ($flags as $key => $value) {
            $files += [PATH_UPLOADS.'flags'.DS.$value => file_get_contents(Anx::PATH_ANX_SOURCE.'Setup'.DS.'Base'.DS.'Flags'.DS.$value)];
        }

        foreach ($files as $key => $value) {
            $this->file_force_contents($key, $value);
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
        echo "\tphp anx country" . chr(10) . chr(10);

        echo "\033[1;33m" . "Params:" . "\033[0m" . chr(10);
        echo "\t--help - See this helper" . chr(10);

        exit(chr(10));
    }
}
