<?php

namespace AnexusPHP\RegraDeNegocio\App\RegraDeNegocio;

use AnexusPHP\Core\Tools\Database;
use AnexusPHP\RegraDeNegocio\App\Entidade\AppSessaoEntidade;

class AppSessaoRegraDeNegocio
{
    public static function inserir(AppSessaoEntidade $registro)
    {
        $db = Database::getInstance();
        if ($registro->getId()) {
            throw new \Exception('Esse método serve inserir registros e não alterar');
        }

        $registro->setDtaInicio(date('Y-m-d H:i:s'));
        $registro->setDtaAtualizacao(date('Y-m-d H:i:s'));
        $registro->save($db);
    }
    public static function alterar(AppSessaoEntidade $registro)
    {
        $db = Database::getInstance();
        if (!$registro->getId()) {
            throw new \Exception('Esse método serve alterar registros e não inserir');
        }

        $registro->setDtaAtualizacao(date('Y-m-d H:i:s'));
        $registro->save($db);
    }
    public static function deletar(AppSessaoEntidade $registro)
    {
        $db = Database::getInstance();
        if (!$registro->getId()) {
            throw new \Exception('Esse método deve conter um ID');
        }
        $registro->delete($db);
    }
    public static function destruir(AppSessaoEntidade $registro)
    {
        $db = Database::getInstance();
        if (!$registro->getId()) {
            throw new \Exception('Esse método deve conter um ID');
        }
        $registro->destroy($db);
    }
}
