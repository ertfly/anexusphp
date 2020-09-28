<?php

namespace AnexusPHP\RegraDeNegocio\Local\Repositorio;

use AnexusPHP\Core\Database;
use AnexusPHP\RegraDeNegocio\Local\Entidade\LocalPaisEntidade;
use PDO;

class LocalPaisRepositorio
{
    /**
     * @param integer|null $id
     * @return LocalPaisEntidade
     */
    public static function porId(?int $id): LocalPaisEntidade
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . LocalPaisEntidade::TABELA . ' where id = :id limit 1', ['id' => (int)$id])->fetchObject(LocalPaisEntidade::class);
        if ($reg === false) {
            return new LocalPaisEntidade();
        }

        return $reg;
    }

    /**
     * @return LocalPaisEntidade[]
     */
    public static function todos()
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . LocalPaisEntidade::TABELA . ' order by sigla asc')->fetchAll(PDO::FETCH_CLASS, LocalPaisEntidade::class);

        return $reg;
    }

    /**
     * @param string $sigla
     * @return LocalPaisEntidade
     */
    public static function porSigla(string $sigla): LocalPaisEntidade
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . LocalPaisEntidade::TABELA . ' where sigla = :sigla limit 1', ['sigla' => $sigla])->fetchObject(LocalPaisEntidade::class);
        if ($reg === false) {
            return new LocalPaisEntidade();
        }

        return $reg;
    }
}
