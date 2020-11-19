<?php

namespace AnexusPHP\Setup\Setup;

use AnexusPHP\Interfaces\Anx\AnxInterface;
use AnexusPHP\Setup\Anx;
use Exception;

class Cron extends Anx implements AnxInterface
{
    public function __construct($param, $option)
    {
        $this->run($param, $option);
    }

    public function run(array $params = [], array $option = []): void
    {
        try {
            if (!is_writable(PATH_ROOT)) {
                throw new Exception('Folder \"' . PATH_ROOT . '\" does not have write permission');
            }

            if (!file_exists(PATH_LOGS . 'start_execution')) {
                throw new Exception('Please start the application', 1);
            }

            if(!is_dir(PATH_CRON)){
                throw new Exception('Folder cron is not exist.');
            }

            if (!isset($params['-c']) || trim($params['-c'] == '')) {
                throw new Exception('Error: param -c [cron-name] is required', 1);
            }

            $cron = ucwords($params['-c']);

            $cronTemplate = $this->getTemplate('Configuration' . DS . 'cron', [
                '{{cron}}' => $cron,
            ]);

            $files = [
                PATH_CRON .$cron. '.php' => $cronTemplate
            ];

            echo "\033[0;37m";

            foreach ($files as $key => $value) {
                $this->file_force_contents($key, $value);
                echo 'Cron created in: ' . $key;
            }
        } catch (Exception $e) {
            exit(chr(10) . $e->getMessage() . "\033[0m" . chr(10));
        }
    }

    public static function help()
    {
        echo "\033[0m" .  "    ___    _   ___  __" . "\033[0m" . chr(10);
        echo "\033[0m" .  "   /   |  / | / / |/ /" . "\033[0m" . chr(10);
        echo "\033[0m" .  "  / /| | /  |/ /|   / " . "\033[0m" . chr(10);
        echo "\033[0m" .  " / ___ |/ /|  //   |  " . "\033[0m" . chr(10);
        echo "\033[0m" .  "/_/  |_/_/ |_//_/|_|  " . "\033[0m" . chr(10);
        echo "\033[0m" .  "                      " . "\033[0m" . chr(10);

        echo "\033[1;33m" . "Usage:" . "\033[0m" . chr(10);
        echo "\tphp anx create-cron [params]" . chr(10) . chr(10);

        echo "\033[1;33m" . "Params:" . "\033[0m" . chr(10);
        echo "\t-c [cron-name]" . chr(10);
        echo "\t--help - See this helper" . chr(10);


        exit(chr(10));
    }
}
