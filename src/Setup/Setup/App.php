<?php

namespace AnexusPHP\Setup\Setup;

use AnexusPHP\Interfaces\Anx\AnxInterface;
use AnexusPHP\Setup\Anx;

class App extends Anx implements AnxInterface
{
    public function __construct()
    {
        $this->run();
    }

    public function run()
    {
    }
}
