<?php

namespace AnexusPHP\Core;

use Exception;

class Translate
{
    private static $vars;
    public static function init($locale)
    {
        if (is_null(self::$vars)) {
            if (!is_dir(PATH_ROOT . 'languages' . DIRECTORY_SEPARATOR . $locale)) {
                throw new Exception('Folder language not found.');
            }
            $files = scandir(PATH_ROOT . 'languages' . DIRECTORY_SEPARATOR . $locale);
            unset($files[0]);
            unset($files[1]);
            foreach ($files as $file) {
                $key = substr($file, 0, strrpos($file, '.'));
                self::$vars[$key] = [];
                $lines = file(PATH_ROOT . 'languages' . DIRECTORY_SEPARATOR . $locale . DIRECTORY_SEPARATOR . $file);
                for ($l = 0; $l < count($lines); $l++) {
                    $arr = explode('=', $lines[$l]);
                    self::$vars[$key][$arr[0]] = $arr[1];
                }
            }
        }
    }

    public static function get($var, $key, $defaultValue = null)
    {
        if (is_null(self::$vars)) {
            throw new Exception('Translate is not started');
        }

        if (!isset(self::$vars[$var])) {
            throw new Exception($var . ' not found in vars');
        }

        if (!isset(self::$vars[$var][$key])) {
            throw new Exception($key . ' not found in ' . $var);
        }

        if (trim(self::$vars[$var][$key]) == '') {
            return $defaultValue;
        }

        return self::$vars[$var][$key];
    }
}
