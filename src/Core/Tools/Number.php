<?php

namespace AnexusPHP\Core\Tools;

class Number
{

    public static function toDecimal($number, $dec = 2, $usa = false)
    {
        if ($usa) {
            $number = str_replace(',', '', $number);
        } else {
            $number = str_replace(',', '.', str_replace('.', '', $number));
        }
        return number_format($number, $dec, '.', '');
    }

    public static function key($size = 6)
    {
        $alphabet = '1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $size; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public static function keyAlphaNumeric($size = 6)
    {
        $alphabet = '1234567890ABCDEFGHIJLMNOPQRSTUVXZ';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $size; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public static function corrigirCoordenadas($coordenada)
    {
        return (preg_match("/\-/", $coordenada) ? '-' . number_format(str_replace('-', '', $coordenada), 7, '.', '') : number_format(str_replace('-', '', $coordenada), 7, '.', ''));
    }
}
