<?php

namespace AnexusPHP\RegraDeNegocio\Local\Repositorio;

use AnexusPHP\Core\Database;
use AnexusPHP\RegraDeNegocio\Local\Entidade\LocalCidadeEntidade;
use AnexusPHP\RegraDeNegocio\Local\Entidade\LocalUfEntidade;
use Exception;
use PDO;

class LocalCidadeRepositorio
{
    /**
     * @param integer|null $id
     * @return LocalCidadeEntidade
     */
    public static function porId(?int $id): LocalCidadeEntidade
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . LocalCidadeEntidade::TABELA . ' where id = :id limit 1', ['id' => (int)$id])->fetchObject(LocalCidadeEntidade::class);
        if ($reg === false) {
            return new LocalCidadeEntidade();
        }

        return $reg;
    }

    /**
     * @param LocalUfEntidade $uf
     * @param array $opcoes
     * @return LocalCidadeEntidade[]
     */
    public static function buscaPorUF(LocalUfEntidade $uf, array $opcoes = [])
    {
        $db = Database::getInstance();

        if (!$uf->getId()) {
            throw new Exception('UF inválido');
        }

        $regs = $db->query('
            select 
                a.id as id,
                a.uf_id as uf_id,
                a.nome as nome
            from ' . LocalCidadeEntidade::TABELA . ' a
            where a.uf_id = :local_uf_id
            order by a.nome asc
        ', [
            'local_uf_id' => $uf->getId(),
        ])->fetchAll(PDO::FETCH_CLASS, LocalCidadeEntidade::class);

        foreach ($regs as $key => $reg) {
            if (isset($opcoes['array']) && $opcoes['array']) {
                $regs[$key] = $regs[$key] = $reg->toArray();
            }
        }

        return $regs;
    }

    /**
     * @return LocalCidadeEntidade[]
     */
    public static function buscaTodos()
    {
        $db = Database::getInstance();
        return $db->query('select * from ' . LocalCidadeEntidade::TABELA . ' where lixo = 0')->fetchAll(PDO::FETCH_CLASS, LocalCidadeEntidade::class);
    }
}
