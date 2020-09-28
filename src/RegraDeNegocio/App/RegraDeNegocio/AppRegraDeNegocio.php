<?php

namespace AnexusPHP\RegraDeNegocio\App\RegraDeNegocio;

use AnexusPHP\Core\Database;
use AnexusPHP\RegraDeNegocio\App\Entidade\AppEntidade;

class AppRegraDeNegocio
{
    public static function inserir(AppEntidade &$registro)
    {
        $db = Database::getInstance();
        if ($registro->getId()) {
            throw new \Exception('Esse método serve inserir registros e não alterar');
        }
        $registro->save($db);
    }
    public static function alterar(AppEntidade &$registro)
    {
        $db = Database::getInstance();
        if (!$registro->getId()) {
            throw new \Exception('Esse método serve alterar registros e não inserir');
        }
        $registro->save($db);
    }
    public static function deletar(AppEntidade &$registro)
    {
        $db = Database::getInstance();
        if (!$registro->getId()) {
            throw new \Exception('Esse método deve conter um ID');
        }
        $registro->delete($db);
    }
    public static function destruir(AppEntidade &$registro)
    {
        $db = Database::getInstance();
        if (!$registro->getId()) {
            throw new \Exception('Esse método deve conter um ID');
        }
        $registro->destroy($db);
    }
}
