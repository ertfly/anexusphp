<?php

namespace AnexusPHP\Core;

use PDO;
use Medoo\Medoo;

class Database
{
    /**
     * @var Medoo
     */
    private static $instance;

    /**
     * @return Medoo
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Medoo([
                'database_type' => 'pgsql',
                'database_name' => getenv('DB_NAME'),
                'server' => getenv('DB_HOST'),
                'username' => getenv('DB_USER'),
                'password' => getenv('DB_PWD'),
                'port' => getenv('DB_PORT'),
                'charset' => 'utf8',
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
