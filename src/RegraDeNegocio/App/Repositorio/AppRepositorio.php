<?php

namespace AnexusPHP\RegraDeNegocio\App\Repositorio;

use AnexusPHP\Core\Database;
use AnexusPHP\RegraDeNegocio\App\Entidade\AppEntidade;

class AppRepositorio
{
    /**
     * @param integer|null $id
     * @return AppEntidade
     */
    public static function porId(?int $id, $className): AppEntidade
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . AppEntidade::TABELA . ' where id = :id limit 1', ['id' => (int)$id])->fetchObject($className);
        if ($reg === false) {
            return new $className();
        }

        return $reg;
    }
}
