<?php

namespace AnexusPHP\RegraDeNegocio\Idioma\RegraDeNegocio;

use AnexusPHP\Core\Tools\Database;
use AnexusPHP\RegraDeNegocio\Idioma\Entidade\IdiomaTelaEntidade;

class IdiomaTelaRegraDeNegocio
{
    public static function inserir(IdiomaTelaEntidade &$registro)
    {
        $db = Database::getInstance();
        if ($registro->getId()) {
            throw new \Exception('Esse método serve inserir registros e não alterar');
        }

        $registro->save($db);
    }
    public static function alterar(IdiomaTelaEntidade &$registro)
    {
        $db = Database::getInstance();
        if (!$registro->getId()) {
            throw new \Exception('Esse método serve alterar registros e não inserir');
        }
        $registro->save($db);
    }
}
