<?php

namespace AnexusPHP\core;

use AnexusPHP\Business\Configuration\Repository\ConfigurationRepository;
use AnexusPHP\Business\Configuration\Rule\ConfigurationRule;
use PDO;

class Migration
{
    public static function init()
    {
        if (!file_exists(PATH_LOGS . 'start_execution')) {
            exit("Inicialize a aplicação atraves do anx");
        }

        try {
            if(!ConfigurationRepository::getValue('MIGRATION_STARTED')){
                throw new \Exception();
            };
        } catch (\Exception $e) {
            return self::install();
        }
        $migrationVersion = ConfigurationRepository::getValue('MIGRATION_VERSION');
        $newUp = self::getVersionUp();
        $newDown = self::getVersionDown();
        $newVersion = $newUp . '.' . $newDown;

        if ($migrationVersion != $newVersion) {
            $arr = explode('.', $migrationVersion);
            if (intval($arr[0]) < $newUp) {
                self::executeUp(intval($arr[0]), $newUp);
            }
            if (intval($arr[1]) < $newDown) {
                self::executeDown(intval($arr[1]), $newDown);
            }
            $version = (ConfigurationRepository::byId('MIGRATION_VERSION'))->setValue($newVersion);
            ConfigurationRule::update($version);
        }
    }

    private static function install()
    {
        set_time_limit(0);
        $database = Database::getInstance();
        $database->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, 1);

        $sql = file_get_contents(PATH_MIGRATIONS . 'base.sql');

        if(trim($sql) != '') {
            $database->exec($sql);
        }

        self::populate();

        return self::init();
    }

    private static function populate()
    {
        $database = Database::getInstance();
        $database->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, 1);

        $sql = file_get_contents(PATH_MIGRATIONS . 'data.sql');

        if(trim($sql) != '') {
            $database->exec($sql);
        }
    }

    private static function executeDown($oldVersion, $newVersion)
    {
        $database = Database::getInstance();
        $database->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, 1);

        for ($v = ($oldVersion + 1); $v <= $newVersion; $v++) {
            if (!is_file(PATH_MIGRATIONS . 'down' . DS . $v . '.sql')) {
                continue;
            }
            $sql = file_get_contents(PATH_MIGRATIONS . 'down' . DS . $v . '.sql');
            if (trim($sql) == '') {
                continue;
            }
            $database->exec($sql);
        }
    }

    private static function executeUp($oldVersion, $newVersion)
    {
        $database = Database::getInstance();
        $database->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, 1);

        for ($v = ($oldVersion + 1); $v <= $newVersion; $v++) {
            if (!is_file(PATH_MIGRATIONS . 'up' . DS . $v . '.sql')) {
                continue;
            }
            $sql = file_get_contents(PATH_MIGRATIONS . 'up' . DS . $v . '.sql');
            if (trim($sql) == '') {
                continue;
            }
            $database->exec($sql);
        }
    }

    private static function getVersionUp()
    {
        $scan = scandir(PATH_MIGRATIONS . 'up');
        unset($scan[0]);
        unset($scan[1]);
        unset($scan[2]);
        $scan = array_values($scan);
        $scan = str_replace('.sql', '', $scan);
        asort($scan);
        $scan = array_values($scan);
        $version = 0;
        if (isset($scan[count($scan) - 1])) {
            $version = intval($scan[count($scan) - 1]);
        }

        return $version;
    }

    private static function getVersionDown()
    {
        $scan = scandir(PATH_MIGRATIONS . 'down');
        unset($scan[0]);
        unset($scan[1]);
        unset($scan[2]);
        $scan = array_values($scan);
        $scan = str_replace('.sql', '', $scan);
        asort($scan);
        $scan = array_values($scan);
        $version = 0;
        if (isset($scan[count($scan) - 1])) {
            $version = intval($scan[count($scan) - 1]);
        }

        return $version;
    }
}
