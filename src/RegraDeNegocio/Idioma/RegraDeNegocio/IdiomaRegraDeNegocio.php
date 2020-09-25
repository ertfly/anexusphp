<?php

namespace AnexusPHP\RegraDeNegocio\Idioma\RegraDeNegocio;

use AnexusPHP\Core\Tools\Database;
use AnexusPHP\RegraDeNegocio\Idioma\Entidade\IdiomaEntidade;

class IdiomaRegraDeNegocio
{
    public static function inserir(IdiomaEntidade &$registro)
    {
        $db = Database::getInstance();
        if ($registro->getId()) {
            throw new \Exception('Esse método serve inserir registros e não alterar');
        }

        $registro->save($db);
    }
    public static function alterar(IdiomaEntidade &$registro)
    {
        $db = Database::getInstance();
        if (!$registro->getId()) {
            throw new \Exception('Esse método serve alterar registros e não inserir');
        }
        $registro->save($db);
    }
}
