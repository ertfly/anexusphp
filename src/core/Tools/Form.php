<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AnexusPHP\Tools;

//defined('BASE_URL') OR exit('No direct script access allowed');

/**
 * Description of Form
 *
 * @author Eric Teixeira
 */
class Form
{

    private static $post = null;

    public static function selected($name, $value, $defaultValue = null, $checkGet = false)
    {
        $value = trim($value);
        if ((self::input($name, $defaultValue, $checkGet) == $value)) {
            return ' selected="selected"';
        }
        return '';
    }

    public static function checked($name, $value, $defaultValue = null, $checkGet = false)
    {
        $value = trim($value);
        if ((self::input($name, $defaultValue, $checkGet) == $value)) {
            return ' checked="checked"';
        }
        return '';
    }

    public static function input($name, $defaultValue = null, $isGet = false)
    {

        if (self::$post === null) {
            self::$post = Session::item('post', true);
        }

        // Session::item('post')
        if (!$isGet && self::$post) {
            if (isset(self::$post[$name])) {
                if (trim(self::$post[$name]) != '') {
                    return trim(self::$post[$name]);
                } else {
                    return $defaultValue;
                }
            }
        } else {
            if ($isGet) {
                $value = input($name, null, 'get');
                if (trim($value) != '') {
                    return trim($value);
                } else {
                    return $defaultValue;
                }
            }
        }

        return $defaultValue;
    }
}
