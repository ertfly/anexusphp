<?php

namespace AnexusPHP\RegraDeNegocio\Local\Entidade;

use AnexusPHP\Core\Tools\DatabaseEntity;

class LocalPaisEntidade extends DatabaseEntity
{
    const TABELA = 'local_pais';
    private $id;
    private $pessoa_campo_id;
    private $nome;
    private $codigo;
    private $sigla;
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setPessoaCampoId($pessoaCampoId)
    {
        $this->pessoa_campo_id = $pessoaCampoId;
        return $this;
    }
    public function getPessoaCampoId()
    {
        return $this->pessoa_campo_id;
    }
    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }
    public function getNome()
    {
        return $this->nome;
    }
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
        return $this;
    }
    public function getCodigo()
    {
        return $this->codigo;
    }
    public function setSigla($sigla)
    {
        $this->sigla = $sigla;
        return $this;
    }
    public function getSigla()
    {
        return $this->sigla;
    }
    public function toArray()
    {
        return array(
            'pessoa_campo_id' => $this->getPessoaCampoId(),
            'nome' => $this->getNome(),
            'codigo' => $this->getCodigo(),
            'sigla' => $this->getSigla()
        );
    }

    // /**
    //  * @return PessoaCampoEntidade
    //  */
    // public function getPessoaCamppo()
    // {
    //     return PessoaCampoRepositorio::porId($this->pessoa_campo_id);
    // }
}
