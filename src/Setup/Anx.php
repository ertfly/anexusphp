<?php

namespace AnexusPHP\Setup;

use AnexusPHP\Setup\Setup\Help;

class Anx
{
    const PATH_ANX_ROOT = __DIR__ . DS . '..' . DS  . '..' . DS;
    const PATH_ANX_MIGRATION = self::PATH_ANX_ROOT . 'migration' . DS;
    const PATH_ANX_SOURCE = self::PATH_ANX_ROOT . 'src' . DS;
    const PATH_BASE = self::PATH_ANX_SOURCE . 'Setup' . DS . 'Base' . DS;

    public function start($function, $params = [], $inCore = false)
    {
        // funções liberadas pra uso
        $ableFunctions = [
            'help' => '\AnexusPHP\Setup\Setup\Help',
            'init' => '\AnexusPHP\Setup\Setup\Init',
            'create-app' => '\AnexusPHP\Setup\Setup\App',
            'create-module' => '\AnexusPHP\Setup\Setup\Module',
            'create-biz' => '\AnexusPHP\Setup\Setup\Biz',
            'create-biz-module' => '\AnexusPHP\Setup\Setup\BizModule',
            'create-biz-entity' => '\AnexusPHP\Setup\Setup\BizEntity',
            'create-panel' => '\AnexusPHP\Setup\Setup\Panel',
            'create-route' => '\AnexusPHP\Setup\Setup\Route',
            'country' => '\AnexusPHP\Setup\Setup\Country',
            'create-cron' => '\AnexusPHP\Setup\Setup\Cron',
        ];

        $coreFunctions = ['create-biz-module', 'create-biz-entity'];

        if ($function == 'help' || trim($function) == '') {
            new Help([], []);
            exit;
        } elseif (!array_key_exists($function, $ableFunctions)) {
            exit((chr(10) . "\033[0;31m" . 'Invalid method. Try' . "\033[0;33m" . ' php anx help' . "\033[0;31m" . ' to see all comands available.' . "\033[0m" . chr(10) . chr(10)));
        }

        if ($inCore && !in_array($function, $coreFunctions)) {
            exit((chr(10) . "\033[0;31m" . 'This method cannot be used inside the core.' . "\033[0m" . chr(10) . chr(10)));
        }

        $function = $ableFunctions[$function];

        $param = [];
        $option = [];
        foreach ($params as $key => $value) {
            if (preg_match('/^-{1}[a-zA-Z]/', $value)) {
                $param[$value] = $params[$key + 1];
            }
            if (preg_match('/-{2}[a-zA-Z]/', $value)) {
                $option[] = $value;
            }
        }

        if (in_array('--help', $option)) {
            $function::help();
        }

        // iniciando
        echo "\033[0;33m" . 'Application started...' . chr(10) . "\033[0;31m";

        new $function($param, $option);

        // encerrando
        exit(chr(10) . "\033[0;32m" . 'Execution ended with success' . "\033[0m" . chr(10));
    }

    /**
     * @param string $fullPath
     * @param string $contents
     * @param integer $flags
     * @return void
     */
    public function file_force_contents($fullPath, string $contents, $flags = 0)
    {
        if (!file_exists($fullPath)) {
            $parts = explode('/', $fullPath);
            array_pop($parts);
            $dir = implode('/', $parts);

            if (!is_dir($dir))
                mkdir($dir, 0755, true);

            file_put_contents($fullPath, $contents, $flags);
        }
    }

    /**
     * @param string $name
     * @param array $params
     * @return string
     */
    public function getTemplate($name, array $params = []): string
    {
        $name = dirname(__FILE__, 1) . DS . 'Base' . DS . $name;
        $content = file_get_contents($name);

        foreach ($params as $key => $value) {
            $content = str_replace($key, $value, $content);
        }

        return $content;
    }
}
