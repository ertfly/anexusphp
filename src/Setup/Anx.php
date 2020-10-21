<?php

namespace AnexusPHP\Setup;

class Anx
{
    const PATH_BASE = __DIR__ . DS . 'Base' . DS;

    public function start(string $function, $params = [])
    {
        // funções liberadas pra uso
        $ableFunctions = [
            'help' => '\AnexusPHP\Setup\Setup\Help',
            'init' => '\AnexusPHP\Setup\Setup\Init',
            'create-app' => '\AnexusPHP\Setup\Setup\App',
            'create-module' => '\AnexusPHP\Setup\Setup\Module',
            'create-panel' => '\AnexusPHP\Setup\Setup\Panel'
        ];

        // verificando se a chave pedida existe
        if ($function == 'help') {
            new $ableFunctions['help']($params);
            exit;
        } elseif (!array_key_exists($function, $ableFunctions)) {
            exit((chr(10) . "\033[0;31m" . 'Invalid method. Try' . "\033[0;33m" . ' php anx help' . "\033[0;31m" . ' to see all comands avaliable.' . chr(10) . chr(10)));
        }
        $function = $ableFunctions[$function];

        if(in_array('--help', $params)) {
            // $function::help();
        }

        // iniciando
        echo "\033[0;33m" . 'Application started...' . chr(10) . "\033[0;31m";

        new $function($params);

        // encerrando
        exit(chr(10) . "\033[0;32m" . 'Execution ended with success' . chr(10));
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

    /**
     * @param string $name
     * @param array $params
     * @return string
     */
    public function getTemplate(string $name, array $params = []):string {
        $name = dirname(__FILE__, 1) . DS . 'Base' . DS . $name;
        $content = file_get_contents($name);

        foreach ($params as $key => $value) {
            $content = str_replace($key, $value, $content);
        }

        return $content;
    }
}
