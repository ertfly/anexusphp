<?php

namespace AnexusPHP\RegraDeNegocio\Configuracao\Repositorio;

use AnexusPHP\Core\Database;
use AnexusPHP\RegraDeNegocio\Configuracao\Entidade\ConfiguracaoEntidade;

class ConfiguracaoRepositorio
{
    /**
     * @param string $id
     * @return ConfiguracaoEntidade
     */
    public static function porId($id)
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . ConfiguracaoEntidade::TABELA . ' where id = :id limit 1', ['id' => $id])->fetchObject(ConfiguracaoEntidade::class);
        if ($reg === false) {
            return new ConfiguracaoEntidade();
        }

        return $reg;
    }

    /**
     * @param string $id
     * @return null|string
     */
    public static function obterValor($id)
    {
        $db = Database::getInstance();
        $reg = $db->query('select valor from ' . ConfiguracaoEntidade::TABELA . ' where id = :id limit 1', ['id' => $id])->fetchColumn();

        return $reg;
    }
}
