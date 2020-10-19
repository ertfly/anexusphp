<?php

namespace AnexusPHP\Business\Region\Rule;

use AnexusPHP\Business\Region\Entity\RegionCountryEntity;
use AnexusPHP\Core\Database;
use Exception;

class RegionCountryRule
{
    public static function insert(RegionCountryEntity &$registro)
    {
        $db = Database::getInstance();
        if ($registro->getId()) {
            throw new Exception('Esse método serve inserir registros e não alterar');
        }
        $registro->save($db);
    }
    public static function update(RegionCountryEntity &$registro)
    {
        $db = Database::getInstance();
        if (!$registro->getId()) {
            throw new Exception('Esse método serve alterar registros e não inserir');
        }
        $registro->save($db);
    }
    public static function delete(RegionCountryEntity &$registro)
    {
        $db = Database::getInstance();
        if (!$registro->getId()) {
            throw new Exception('Esse método deve conter um ID');
        }
        $registro->delete($db);
    }
    public static function destroy(RegionCountryEntity &$registro)
    {
        $db = Database::getInstance();
        if (!$registro->getId()) {
            throw new Exception('Esse método deve conter um ID');
        }
        $registro->destroy($db);
    }
}
