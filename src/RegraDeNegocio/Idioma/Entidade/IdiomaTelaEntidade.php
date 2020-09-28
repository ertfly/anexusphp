<?php

namespace AnexusPHP\RegraDeNegocio\Idioma\Entidade;

use AnexusPHP\Core\DatabaseEntity;

class IdiomaTelaEntidade extends DatabaseEntity
{
    const TABELA = 'idioma_tela';
    protected $id;
    protected $descricao;
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }
    public function getDescricao()
    {
        return $this->descricao;
    }
    public function toArray()
    {
        return array(
            'descricao' => $this->getDescricao()
        );
    }
}
