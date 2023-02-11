<?php

namespace AnexusPHP\Core\Tools;

class Base64
{
    private static function command($action, $str)
    {
        $output = '';
        $command = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base64 "' . $action . '" "' . str_replace('"', '\\"', $str) . '"';
        $handle = popen($command, 'r');
        if ($handle) {
            while ($tmp = fgets($handle)) {
                $output .= $tmp;
            }
            pclose($handle);
        }

        return $output;
    }
    public static function encode($str)
    {
        return self::command('encode', $str);
    }

    public static function decode($str)
    {
        return self::command('decode', $str);
    }
}
