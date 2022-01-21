<?php

namespace Core\Tools;

class Boolean
{

    public static function null($var)
    {
        if (!is_bool($var) && trim($var) == '') {
            return null;
        }

        return boolval($var);
    }
}
