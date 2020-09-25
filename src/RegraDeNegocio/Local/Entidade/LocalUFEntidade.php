<?php

namespace AnexusPHP\RegraDeNegocio\Local\Entidade;

use AnexusPHP\Core\Tools\DatabaseEntity;

class LocalUfEntidade extends DatabaseEntity
{
    const TABELA = 'local_uf';
    private $id;
    private $pais_id;
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
    public function setPaisId($paisId)
    {
        $this->pais_id = $paisId;
        return $this;
    }
    public function getPaisId()
    {
        return $this->pais_id;
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
            'pais_id' => $this->getPaisId(),
            'nome' => $this->getNome(),
            'codigo' => $this->getCodigo(),
            'sigla' => $this->getSigla()
        );
    }
}
