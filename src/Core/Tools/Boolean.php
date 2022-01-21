<?php

namespace Core\Tools;

class Boolean
{

    public static function null($var)
    {
        if (trim($var) == '') {
            return null;
        }

        return boolval($var);
    }
}
