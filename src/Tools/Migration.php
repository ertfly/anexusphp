<?php

namespace AnexusPHP\Tools;

use Authfast\Configuracao\RegraDeNegocio\ConfiguracaoRegraDeNegocio;
use Authfast\Configuracao\Repositorio\ConfiguracaoRepositorio;
use PDO;

class Migration
{
    public static function init()
    {
        try {
            ConfiguracaoRepositorio::obterValor('MIGRATION_STARTED');
        } catch (\Exception $e) {
            return self::install();
        }

        $migrationVersion = ConfiguracaoRepositorio::obterValor('MIGRATION_VERSION');

        $version = explode('.', $migrationVersion);

        $down = self::executeDown($version[1]) ?: 0;
        $up = self::executeUp($version[0]) ?: 0;

        $newVersion = $up . '.' . $down;

        if($migrationVersion != $newVersion){
            $version = (ConfiguracaoRepositorio::porId('MIGRATION_VERSION'))->setValor($newVersion);
            ConfiguracaoRegraDeNegocio::alterar($version);
        }
    }

    private static function install()
    {
        set_time_limit(0);
        $database = Database::getInstance();
        $database->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, 1);

        $sql = file_get_contents(PATH_MIGRATIONS . 'base.sql');

        $database->exec($sql);

        self::populate();

        return self::init();
    }

    private static function populate()
    {
        $database = Database::getInstance();
        $database->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, 1);
        
        $sql = file_get_contents(PATH_MIGRATIONS . 'dados.sql');

        $database->exec($sql);
    }

    private static function executeDown($version)
    {
        $database = Database::getInstance();
        $database->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, 1);

        $downPath = PATH_MIGRATIONS . 'down';
        $scanDir = scandir($downPath);
        unset($scanDir[0]);
        unset($scanDir[1]);
        unset($scanDir[2]);

        if(empty($scanDir)){
            return;
        }

        foreach ($scanDir as $value) {
            $pathInfo = pathinfo($downPath . DS . $value);

            if ($pathInfo['extension'] != 'sql' && !is_numeric($pathInfo['filename'])) {
                throw new \Exception('Existe arquivos inválidos');
            }

            if ($version != $value && $version < $value) {
                $sql = file_get_contents($downPath . DS . $value);
                if ($sql != '') {
                    $database->exec($sql);
                }
            }
        }

        return str_replace('.sql', '', array_pop($scanDir));
    }

    private static function executeUp($version)
    {
        $database = Database::getInstance();
        $database->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, 1);

        $upPath = PATH_MIGRATIONS . 'up';
        $scanDir = scandir($upPath);
        unset($scanDir[0]);
        unset($scanDir[1]);
        unset($scanDir[2]);

        if(empty($scanDir)){
            return;
        }

        foreach ($scanDir as $value) {
            $pathInfo = pathinfo($upPath . DS . $value);

            if ($pathInfo['extension'] != 'sql' && is_numeric($pathInfo['filename'])) {
                throw new \Exception('Existe arquivos inválidos');
            }

            if ($version != $value && $version < $value) {
                $sql = file_get_contents($upPath . DS . $value);
                if ($sql != '') {
                    $database->exec($sql);
                }
            }
        }

        return str_replace('.sql', '', array_pop($scanDir));
    }
}
