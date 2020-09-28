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
    public static function porId(?int $id)
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . AppEntidade::TABELA . ' where id = :id limit 1', ['id' => (int)$id])->fetchObject(AppEntidade::class);
        if ($reg === false) {
            return new AppEntidade();
        }

        return $reg;
    }
}
