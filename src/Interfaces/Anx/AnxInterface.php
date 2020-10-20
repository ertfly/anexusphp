<?php

namespace AnexusPHP\Interfaces\Anx;

interface AnxInterface
{
    /**
     * Esse método deve ser responsável por chamar o método run()
     * 
     * public function __construct()
     * {
     *     $this->run();
     * }
     */
    public function __construct($params);

    /**
     * @param array $params
     * @return void
     */
    public function run(array $params = []):void;
}
