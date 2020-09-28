<?php

namespace Authfast\Local\RegraDeNegocio;

use AnexusPHP\Core\Database;
use AnexusPHP\RegraDeNegocio\Local\Entidade\LocalUfEntidade;
use Exception;

class LocalUFRegraDeNegocio
{
    public static function inserir(LocalUfEntidade &$registro)
    {
        $db = Database::getInstance();
        if ($registro->getId()) {
            throw new Exception('Esse método serve inserir registros e não alterar');
        }
        $registro->save($db);
    }
    public static function alterar(LocalUFEntidade &$registro)
    {
        $db = Database::getInstance();
        if (!$registro->getId()) {
            throw new Exception('Esse método serve alterar registros e não inserir');
        }
        $registro->save($db);
    }
    public static function deletar(LocalUFEntidade &$registro)
    {
        $db = Database::getInstance();
        if (!$registro->getId()) {
            throw new Exception('Esse método deve conter um ID');
        }
        $registro->delete($db);
    }
    public static function destruir(LocalUFEntidade &$registro)
    {
        $db = Database::getInstance();
        if (!$registro->getId()) {
            throw new Exception('Esse método deve conter um ID');
        }
        $registro->destroy($db);
    }
}
