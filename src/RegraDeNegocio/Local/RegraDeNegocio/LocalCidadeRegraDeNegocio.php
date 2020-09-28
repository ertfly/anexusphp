<?php

namespace AnexusPHP\RegraDeNegocio\Local\RegraDeNegocio;

use AnexusPHP\Core\Database;
use AnexusPHP\RegraDeNegocio\Local\Entidade\LocalCidadeEntidade;
use Exception;

class LocalCidadeRegraDeNegocio
{
    public static function inserir(LocalCidadeEntidade &$registro)
    {
        $db = Database::getInstance();
        if ($registro->getId()) {
            throw new Exception('Esse método serve inserir registros e não alterar');
        }
        $registro->save($db);
    }
    public static function alterar(LocalCidadeEntidade &$registro)
    {
        $db = Database::getInstance();
        if (!$registro->getId()) {
            throw new Exception('Esse método serve alterar registros e não inserir');
        }
        $registro->save($db);
    }
    public static function deletar(LocalCidadeEntidade &$registro)
    {
        $db = Database::getInstance();
        if (!$registro->getId()) {
            throw new Exception('Esse método deve conter um ID');
        }
        $registro->delete($db);
    }
    public static function destruir(LocalCidadeEntidade &$registro)
    {
        $db = Database::getInstance();
        if (!$registro->getId()) {
            throw new Exception('Esse método deve conter um ID');
        }
        $registro->destroy($db);
    }
}
