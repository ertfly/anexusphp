<?php

namespace AnexusPHP\RegraDeNegocio\Idioma\Repositorio;

use AnexusPHP\Core\Database;
use AnexusPHP\RegraDeNegocio\Idioma\Entidade\IdiomaTelaEntidade;
use PDO;

class IdiomaTelaRepositorio
{
    /**
     * @param int $id
     * @return IdiomaTelaEntidade
     */
    public static function porId(?int $id): IdiomaTelaEntidade
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . IdiomaTelaEntidade::TABELA . ' where id = :id limit 1', ['id' => (int)$id])->fetchObject(IdiomaTelaEntidade::class);
        if ($reg === false) {
            return new IdiomaTelaEntidade();
        }

        return $reg;
    }

    /**
     * @return IdiomaTelaEntidade[]
     */
    public static function todos()
    {
        $db = Database::getInstance();
        $regs = $db->query('select * from ' . IdiomaTelaEntidade::TABELA . ' order by id asc')->fetchAll(PDO::FETCH_CLASS, IdiomaTelaEntidade::class);

        return $regs;
    }
}
