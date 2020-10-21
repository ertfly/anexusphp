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

    public function run(array $params = [], array $option = []):void
    {
        echo "    ___    _   ___  __" . chr(10);
        echo "   /   |  / | / / |/ /" . chr(10);
        echo "  / /| | /  |/ /|   / " . chr(10);
        echo " / ___ |/ /|  //   |  " . chr(10);
        echo "/_/  |_/_/ |_//_/|_|  " . chr(10);
        echo "                      " . chr(10);

        echo "\033[1;33m" . "Usage:" . "\033[1;37m" . chr(10);
        echo "\tphp anx command [arguments] [arguments2]" . chr(10) . chr(10);

        echo "\033[1;33m" . "Avaliable Commands:" . "\033[1;37m" . chr(10);

        echo "\033[0;32m" . "  init" . "\033[1;37m" . "\t\t\tInitialize the project with the basics folders" . chr(10);
        echo "\033[0;32m" . "  create-app" . "\033[1;37m" . "\t\tCreate a new app folder" . chr(10);
        echo "\033[0;32m" . "  create-module" . "\033[1;37m" . "\t\tCreate a new module folder within an existing application folder" . chr(10);
    }
}
