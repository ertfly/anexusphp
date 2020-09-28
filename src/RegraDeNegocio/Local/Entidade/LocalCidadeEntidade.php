<?php

namespace AnexusPHP\RegraDeNegocio\Local\Entidade;

use AnexusPHP\Core\DatabaseEntity;

class LocalCidadeEntidade extends DatabaseEntity
{
    const TABELA = 'local_cidade';
    private $id;
    private $uf_id;
    private $nome;
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setUfId($ufId)
    {
        $this->uf_id = $ufId;
        return $this;
    }
    public function getUfId()
    {
        return $this->uf_id;
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
    public function toArray()
    {
        return array(
            'id' => $this->getId(),
            'uf_id' => $this->getUfId(),
            'nome' => $this->getNome()
        );
    }
}
