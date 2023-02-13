<?php

namespace AnexusPHP\Core\Tools;

class Base64
{
    private static function command($action, $str, $tab)
    {
        $output = '';
        $command = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base64 "' . $action . '" "' . str_replace('"', '\\"', $str) . '" ' . $tab;
        $handle = popen($command, 'r');
        if ($handle) {
            while ($tmp = fgets($handle)) {
                $output .= $tmp;
            }
            pclose($handle);
        }

        return $output;
    }
    public static function encode($str, $tab)
    {
        return self::command('encode', $str, $tab);
    }

    public static function decode($str, $tab)
    {
        return self::command('decode', $str, $tab);
    }
}
