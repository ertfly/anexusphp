<?php

namespace Authfast\Local\Repositorio;


use AnexusPHP\Core\Database;
use AnexusPHP\RegraDeNegocio\Local\Entidade\LocalUfEntidade;
use PDO;

class LocalUFRepositorio
{
    /**
     * @param integer|null $id
     * @return LocalUFEntidade
     */
    public static function porId(?int $id)
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . LocalUfEntidade::TABELA . ' where id = :id limit 1', ['id' => (int)$id])->fetchObject(LocalUFEntidade::class);
        if ($reg === false) {
            return new LocalUFEntidade();
        }

        return $reg;
    }

    /** @return LocalUfEntidade[]
     */
    public static function buscaTodos()
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . LocalUFEntidade::TABELA . ' where lixo = 0')->fetchAll(PDO::FETCH_CLASS, LocalUfEntidade::class);

        return $reg;
    }
}
