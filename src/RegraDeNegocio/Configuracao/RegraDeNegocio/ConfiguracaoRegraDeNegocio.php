<?php

namespace AnexusPHP\RegraDeNegocio\Configuracao\RegraDeNegocio;

use AnexusPHP\Core\Database;
use AnexusPHP\RegraDeNegocio\Configuracao\Entidade\ConfiguracaoEntidade;

class ConfiguracaoRegraDeNegocio
{
    public static function inserir(ConfiguracaoEntidade &$registro)
    {
        $db = Database::getInstance();
        if ($registro->getId()) {
            throw new \Exception('Esse método serve inserir registros e não alterar');
        }
        $registro->save($db);
    }
    public static function alterar(ConfiguracaoEntidade &$registro)
    {
        $db = Database::getInstance();
        if (!$registro->getId()) {
            throw new \Exception('Esse método serve alterar registros e não inserir');
        }
        $registro->save($db);
    }
    public static function deletar(ConfiguracaoEntidade &$registro)
    {
        $db = Database::getInstance();
        if (!$registro->getId()) {
            throw new \Exception('Esse método deve conter um ID');
        }
        $registro->delete($db);
    }
    public static function destruir(ConfiguracaoEntidade &$registro)
    {
        $db = Database::getInstance();
        if (!$registro->getId()) {
            throw new \Exception('Esse método deve conter um ID');
        }
        $registro->destroy($db);
    }
}
