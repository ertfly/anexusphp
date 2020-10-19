<?php

namespace AnexusPHP\Setup;

class Anx
{
    public function start(string $function, $params = [])
    {
        // funções liberadas pra uso
        $ableFunctions = [
            'init' => '\AnexusPHP\Setup\Setup\Init',
            'create-app' => '\AnexusPHP\Setup\Setup\App',
            'create-module' => '\AnexusPHP\Setup\Setup\Module'
        ];

        // verificando se a chave pedida existe
        if (!array_key_exists($function, $ableFunctions)) {
            exit(chr(10) . 'Pass a valid method' . chr(10));
        }
        $function = $ableFunctions[$function];

        new $function($params);
    }

    /**
     * @param string $fullPath
     * @param string $contents
     * @param integer $flags
     * @return void
     */
    public function file_force_contents(string $fullPath, string $contents, $flags = 0)
    {
        if (!file_exists($fullPath)) {
            $parts = explode('/', $fullPath);
            array_pop($parts);
            $dir = implode('/', $parts);

            if (!is_dir($dir))
                mkdir($dir, 0777, true);

            file_put_contents($fullPath, $contents, $flags);
        }
    }
}
