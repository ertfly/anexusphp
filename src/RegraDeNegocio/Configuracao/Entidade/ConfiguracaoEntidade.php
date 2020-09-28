<?php

namespace AnexusPHP\RegraDeNegocio\Configuracao\Entidade;

use AnexusPHP\Core\DatabaseEntity;

class ConfiguracaoEntidade extends DatabaseEntity
{
    const TABELA = 'configuracao';
    protected $id;
    protected $valor;
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
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }
    public function getValor()
    {
        return $this->valor;
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
            'valor' => $this->getValor(),
            'descricao' => $this->getDescricao()
        );
    }
}
