<?php

namespace AnexusPHP\RegraDeNegocio\App\Repositorio;

use AnexusPHP\Core\Tools\Database;
use AnexusPHP\RegraDeNegocio\App\Entidade\AppSessaoEntidade;

class AppSessaoRepositorio
{
    /**
     * @param integer|null $id
     * @return AppSessaoEntidade
     */
    public static function porId(?int $id): AppSessaoEntidade
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . AppSessaoEntidade::TABELA . ' where id = :id limit 1', ['id' => (int)$id])->fetchObject(AppSessaoEntidade::class);
        if ($reg === false) {
            return new AppSessaoEntidade();
        }

        return $reg;
    }

    /**
     * @param string $token
     * @return AppSessaoEntidade
     */
    public static function porToken(string $token): AppSessaoEntidade
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . AppSessaoEntidade::TABELA . ' where token = :token limit 1', ['token' => $token])->fetchObject(AppSessaoEntidade::class);
        if ($reg === false) {
            return new AppSessaoEntidade();
        }

        return $reg;
    }
}
