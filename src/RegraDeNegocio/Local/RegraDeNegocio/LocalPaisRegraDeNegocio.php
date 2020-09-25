<?php

namespace AnexusPHP\RegraDeNegocio\Local\RegraDeNegocio;

use AnexusPHP\Core\Tools\Database;
use AnexusPHP\RegraDeNegocio\Local\Entidade\LocalPaisEntidade;

class LocalPaisRegraDeNegocio
{
    public static function inserir(LocalPaisEntidade &$registro)
    {
        $db = Database::getInstance();
        if ($registro->getId()) {
            throw new \Exception('Esse método serve inserir registros e não alterar');
        }
        $registro->save($db);
    }
    public static function alterar(LocalPaisEntidade &$registro)
    {
        $db = Database::getInstance();
        if (!$registro->getId()) {
            throw new \Exception('Esse método serve alterar registros e não inserir');
        }
        $registro->save($db);
    }
    public static function deletar(LocalPaisEntidade &$registro)
    {
        $db = Database::getInstance();
        if (!$registro->getId()) {
            throw new \Exception('Esse método deve conter um ID');
        }
        $registro->delete($db);
    }
    public static function destruir(LocalPaisEntidade &$registro)
    {
        $db = Database::getInstance();
        if (!$registro->getId()) {
            throw new \Exception('Esse método deve conter um ID');
        }
        $registro->destroy($db);
    }
}
