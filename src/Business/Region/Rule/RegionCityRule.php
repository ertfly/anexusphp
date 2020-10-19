<?php

namespace AnexusPHP\Business\Region\Rule;

use AnexusPHP\Business\Region\Entity\RegionCityEntity;
use AnexusPHP\Core\Database;
use Exception;

class RegionCityRule
{
    public static function inserir(RegionCityEntity &$registro)
    {
        $db = Database::getInstance();
        if ($registro->getId()) {
            throw new Exception('Esse método serve inserir registros e não alterar');
        }
        $registro->save($db);
    }
    public static function alterar(RegionCityEntity &$registro)
    {
        $db = Database::getInstance();
        if (!$registro->getId()) {
            throw new Exception('Esse método serve alterar registros e não inserir');
        }
        $registro->save($db);
    }
    public static function deletar(RegionCityEntity &$registro)
    {
        $db = Database::getInstance();
        if (!$registro->getId()) {
            throw new Exception('Esse método deve conter um ID');
        }
        $registro->delete($db);
    }
    public static function destruir(RegionCityEntity &$registro)
    {
        $db = Database::getInstance();
        if (!$registro->getId()) {
            throw new Exception('Esse método deve conter um ID');
        }
        $registro->destroy($db);
    }
}
