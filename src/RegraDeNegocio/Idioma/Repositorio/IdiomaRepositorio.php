<?php

namespace AnexusPHP\RegraDeNegocio\Idioma\Repositorio;

use AnexusPHP\Core\Tools\Database;
use AnexusPHP\RegraDeNegocio\Idioma\Entidade\IdiomaEntidade;
use PDO;

class IdiomaRepositorio
{
    /**
     * @param int $id
     * @return IdiomaEntidade
     */
    public static function porId(?int $id)
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . IdiomaEntidade::TABELA . ' where id = :id limit 1', ['id' => $id])->fetchObject(IdiomaEntidade::class);
        if ($reg === false) {
            return new IdiomaEntidade();
        }

        return $reg;
    }

    /**
     * @return IdiomaEntidade[]
     */
    public static function todos()
    {
        $db = Database::getInstance();
        $regs = $db->query('select * from ' . IdiomaEntidade::TABELA . ' order by id asc')->fetchAll(PDO::FETCH_CLASS, IdiomaEntidade::class);

        return $regs;
    }

    /**
     * @param integer $page
     * @param integer $country
     * @return IdiomaEntidade[]
     */
    public static function porTela(int $page, int $country)
    {
        $db = Database::getInstance();
        $regs = $db->query('select a.id, a.* from ' . IdiomaEntidade::TABELA . ' a where local_pais_id = :local_pais_id and tela_id = :tela_id order by id asc', ['local_pais_id' => (int)$country, 'tela_id' => (int)$page])->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_UNIQUE, IdiomaEntidade::class);

        return $regs;
    }
}
