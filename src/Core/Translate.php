<?php

namespace AnexusPHP\Core;

use Exception;

class Translate
{
    private static $vars;
    public static function init($app, $locale)
    {
        if (is_null(self::$vars)) {
            if (!is_dir(PATH_ROOT . 'languages' . DIRECTORY_SEPARATOR . $app . DIRECTORY_SEPARATOR . $locale)) {
                throw new Exception('Folder language not found.');
            }
            $files = scandir(PATH_ROOT . 'languages' . DIRECTORY_SEPARATOR . $app . DIRECTORY_SEPARATOR . $locale);
            unset($files[0]);
            unset($files[1]);
            unset($files[2]);

            $path = PATH_ROOT . 'languages' . DIRECTORY_SEPARATOR . $app . DIRECTORY_SEPARATOR . $locale . DIRECTORY_SEPARATOR . '_default' . DIRECTORY_SEPARATOR;
            $pathInput = PATH_ROOT . 'languages' . DIRECTORY_SEPARATOR . $app . DIRECTORY_SEPARATOR . $locale . DIRECTORY_SEPARATOR;
            $files = scandir($path);
            unset($files[0]);
            unset($files[1]);
            foreach ($files as $file) {
                if (is_file($pathInput . $file)) {
                    continue;
                }
                $content = file_get_contents($path . $file);
                file_put_contents($pathInput . $file, $content);
            }

            foreach ($files as $file) {
                $key = substr($file, 0, strrpos($file, '.'));
                self::$vars[$key] = [];
                $lines = file(PATH_ROOT . 'languages' . DIRECTORY_SEPARATOR . $app . DIRECTORY_SEPARATOR . $locale . DIRECTORY_SEPARATOR . $file);
                for ($l = 0; $l < count($lines); $l++) {
                    if (strpos($lines[$l], '=') === false) {
                        continue;
                    }

                    // $arr = explode('=', $lines[$l]);
                    // self::$vars[$key][$arr[0]] = $arr[1];
                    $varKey = substr($lines[$l], 0, strpos($lines[$l], '='));
                    $varKey = str_replace(' ', '', $varKey);
                    $varValue = substr($lines[$l], strpos($lines[$l], '=') + 1);
                    self::$vars[$key][$varKey] = $varValue;
                }
            }
        }
    }

    public static function get($var, $key, $defaultValue = null, $trim = false)
    {
        if (is_null(self::$vars)) {
            throw new Exception('Translate is not started');
        }

        if (!isset(self::$vars[$var])) {
            return '{{' . $var . '}}';
        }

        if (!isset(self::$vars[$var][$key])) {
            return $defaultValue;
        }

        if (self::$vars[$var][$key] == '') {
            return $defaultValue;
        }

        if ($trim) {
            self::$vars[$var][$key] = trim(self::$vars[$var][$key]);
        }

        return self::$vars[$var][$key];
    }
}
