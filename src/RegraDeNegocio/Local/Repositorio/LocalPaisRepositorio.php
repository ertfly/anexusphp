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
    public static function porId(?int $id, $className): LocalPaisEntidade
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . LocalPaisEntidade::TABELA . ' where id = :id limit 1', ['id' => (int)$id])->fetchObject($className);
        if ($reg === false) {
            return new $className();
        }

        return $reg;
    }

    /**
     * @return LocalPaisEntidade[]
     */
    public static function todos($className)
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . LocalPaisEntidade::TABELA . ' order by id asc')->fetchAll(PDO::FETCH_CLASS, $className);

        return $reg;
    }

    /**
     * @return LocalPaisEntidade[]
     */
    public static function todosVisiveis($className)
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . LocalPaisEntidade::TABELA . ' where visivel is true order by id asc')->fetchAll(PDO::FETCH_CLASS, $className);

        return $reg;
    }

    /**
     * @param string $sigla
     * @return LocalPaisEntidade
     */
    public static function porSigla(string $sigla, $className): LocalPaisEntidade
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . LocalPaisEntidade::TABELA . ' where sigla = :sigla limit 1', ['sigla' => $sigla])->fetchObject($className);
        if ($reg === false) {
            return new $className();
        }

        return $reg;
    }

    /**
     * @param $className
     * @return LocalPaisEntidade
     */
    public static function principal($className): LocalPaisEntidade
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . LocalPaisEntidade::TABELA . ' where principal is true limit 1')->fetchObject($className);
        if ($reg === false) {
            return new $className();
        }

        return $reg;
    }
}
