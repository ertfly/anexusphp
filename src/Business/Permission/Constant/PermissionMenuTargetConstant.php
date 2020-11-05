<?php

namespace AnexusPHP\Business\Permission\Constant;

use Exception;

class PermissionMenuTargetConstant
{
    const BLANK_SCREEN = 'BLANK_SCREEN';
    const SELF_SCREEN = 'SELF_SCREEN';

    public static $options = [
        self::BLANK_SCREEN => 'Blank screen',
        self::SELF_SCREEN => 'Self screen'
    ];

    public static function getOptions(){
        return self::$options;
    }

    public static function getOption($key){
        if(!isset(self::$options[$key])){
            throw new Exception('Opção inválida!');
        }

        return self::$options[$key];
    }
}
