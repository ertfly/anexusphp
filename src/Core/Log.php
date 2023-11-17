<?php

namespace AnexusPHP\Core;

use AnexusPHP\Core\Tools\Strings;

class Log
{
    public static function debug($msg)
    {
        if (is_array($msg)) {
            $msg = json_encode($msg, JSON_PRETTY_PRINT);
        }
        $content = 'DEBUG(' . date('Y-m-d H:i:s') .  '): ' . $msg . chr(10);
        @file_put_contents(PATH_LOGS . 'debug_' . date('Ymd') . '.log', $content, FILE_APPEND | LOCK_EX);
    }

    public static function error($msg)
    {
        if (is_array($msg)) {
            $msg = json_encode($msg, JSON_PRETTY_PRINT);
        }
        $content = 'ERROR(' . date('Y-m-d H:i:s') .  '): ' . $msg . chr(10);
        @file_put_contents(PATH_LOGS . 'error_' . date('Ymd') . '.log', $content, FILE_APPEND | LOCK_EX);
    }

    public static function log($msg)
    {
        if (is_array($msg)) {
            $msg = json_encode($msg, JSON_PRETTY_PRINT);
        }
        $content = 'LOG(' . date('Y-m-d H:i:s') .  '): ' . $msg . chr(10);
        @file_put_contents(PATH_LOGS . 'log_' . date('Ymd') . '.log', $content, FILE_APPEND | LOCK_EX);
    }

    public static function user($user, $location, $msg)
    {
        if (is_array($msg)) {
            $msg = json_encode($msg, JSON_PRETTY_PRINT);
        }
        $content = 'USER(' . date('Y-m-d H:i:s') .  '): ' . $msg . chr(10);
        @file_put_contents(PATH_LOGS . 'user_' . $user . '_' . $location . '_' . date('Ymd') . '.log', $msg, FILE_APPEND | LOCK_EX);
    }
}
