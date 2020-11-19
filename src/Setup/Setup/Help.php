<?php

namespace AnexusPHP\Setup\Setup;

use AnexusPHP\Interfaces\Anx\AnxInterface;
use AnexusPHP\Setup\Anx;

class Help extends Anx implements AnxInterface
{
    public function __construct($param, $option)
    {
        $this->run($param, $option);
    }

    public function run(array $param = [], array $option = []): void
    {
        echo "    ___    _   ___  __" . chr(10);
        echo "   /   |  / | / / |/ /" . chr(10);
        echo "  / /| | /  |/ /|   / " . chr(10);
        echo " / ___ |/ /|  //   |  " . chr(10);
        echo "/_/  |_/_/ |_//_/|_|  " . chr(10);
        echo "                      " . chr(10);

        echo "\033[1;33m" . "Usage:" . "\033[0m" . chr(10);
        echo "\tphp anx command [arguments] [options]" . chr(10) . chr(10);

        echo "\033[1;33m" . "Available Options:" . "\033[0m" . chr(10);

        echo "\033[0;32m" . "  -a" . "\033[0m" . "\t\tPass a App name" . chr(10);
        echo "\033[0;32m" . "  -m" . "\033[0m" . "\t\tPass a Module name" . chr(10);
        echo "\033[0;32m" . "  -r" . "\033[0m" . "\t\tPass a optional route name" . chr(10);
        echo "\033[0;32m" . "  -p" . "\033[0m" . "\t\tPass a panel name" . chr(10);
        echo "\033[0;32m" . "  -b" . "\033[0m" . "\t\tPass the Business name" . chr(10);
        echo "\033[0;32m" . "  -bm" . "\033[0m" . "\t\tPass the Business Module name" . chr(10);
        echo "\033[0;32m" . "  -e" . "\033[0m" . "\t\tPass the Business Entity name" . chr(10) . chr(10);

        echo "\033[1;33m" . "Available Commands:" . "\033[0m" . chr(10);

        echo "\033[0;32m" . "  help" . "\033[0m" . "\t\t\tSee all command list" . chr(10);
        echo "\033[0;32m" . "  init" . "\033[0m" . "\t\t\tInitialize the project with the basics folders" . chr(10);
        echo "\033[0;32m" . "  create-app" . "\033[0m" . "\t\tCreate a new app folder" . chr(10);
        echo "\033[0;32m" . "  create-module" . "\033[0m" . "\t\tCreate a new module folder within an existing application folder" . chr(10);
        echo "\033[0;32m" . "  create-biz" . "\033[0m" . "\t\tCreate a new business folder" . chr(10);
        echo "\033[0;32m" . "  create-biz-module" . "\033[0m" . "\tCreate a new business module folder within an existing business" . chr(10);
        echo "\033[0;32m" . "  create-biz-entity" . "\033[0m" . "\tCreate entity, repository and rule files within an existing business module" . chr(10);
        echo "\033[0;32m" . "  create-panel" . "\033[0m" . "\t\tCreate a panel with routes and authfast login" . chr(10);
        echo "\033[0;32m" . "  country" . "\033[0m" . "\t\tInstall or Update existing countries" . chr(10);
        echo "\033[0;32m" . "  create-cron" . "\033[0m" . "\t\tCreates a php file that will run in the background" . chr(10). chr(10);
    }
}
