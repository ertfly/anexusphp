<?php

namespace AnexusPHP\Core;

use Exception;
use PDO;
use Medoo\Medoo;

class Database
{
    /**
     * @var Medoo
     */
    private static $instance;

    /**
     *
     * @var array
     */
    private static $settings;

    /**
     * @return Medoo
     */
    public static function getInstance($instanceName = 'default')
    {
        if(!is_file(PATH_ROOT . 'database.php')){
            throw new Exception('File database.php not exist.');
        }
        if (!self::$settings) {
            self::$settings = require_once PATH_ROOT . 'database.php';
        }

        if(!isset(self::$settings[$instanceName]) || trim(self::$settings[$instanceName])==''){
            throw new Exception('Instance name not exist.');
        }

        if (!self::$instance) {
            self::$instance = new Medoo([
                'database_type' => self::$settings[$instanceName]['driver'],
                'database_name' => self::$settings[$instanceName]['dbname'],
                'server' => self::$settings[$instanceName]['host'],
                'username' => self::$settings[$instanceName]['user'],
                'password' => self::$settings[$instanceName]['pass'],
                'port' => self::$settings[$instanceName]['port'],
                'charset' => self::$settings[$instanceName]['charset'],
                'option' => [
                    PDO::ATTR_CASE => PDO::CASE_NATURAL,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                ]
            ]);
        }

        return self::$instance;
    }
}
