<?php

namespace AnexusPHP\RegraDeNegocio\App\Entidade;

use AnexusPHP\Core\DatabaseEntity;

class AppEntidade extends DatabaseEntity
{
    const TABELA = 'app';
    private $id;
    private $nome;
    private $chave;
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    public function getId()
    {
        return $this->id;
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
    public function setChave($chave)
    {
        $this->chave = $chave;
        return $this;
    }
    public function getChave()
    {
        return $this->chave;
    }
    public function toArray()
    {
        return array(
            'nome' => $this->getNome(),
            'chave' => $this->getChave()
        );
    }
}

