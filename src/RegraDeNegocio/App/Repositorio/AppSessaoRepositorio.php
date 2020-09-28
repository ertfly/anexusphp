<?php

namespace AnexusPHP\RegraDeNegocio\App\Repositorio;

use AnexusPHP\Core\Database;
use AnexusPHP\RegraDeNegocio\App\Entidade\AppSessaoEntidade;

class AppSessaoRepositorio
{
    /**
     * @param integer|null $id
     * @return AppSessaoEntidade
     */
    public static function porId(?int $id, $className): AppSessaoEntidade
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . AppSessaoEntidade::TABELA . ' where id = :id limit 1', ['id' => (int)$id])->fetchObject($className);
        if ($reg === false) {
            return new $className();
        }

        return $reg;
    }

    /**
     * @param string $token
     * @return AppSessaoEntidade
     */
    public static function porToken(string $token, $className): AppSessaoEntidade
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . AppSessaoEntidade::TABELA . ' where token = :token limit 1', ['token' => $token])->fetchObject($className);
        if ($reg === false) {
            return new $className();
        }

        return $reg;
    }
}
