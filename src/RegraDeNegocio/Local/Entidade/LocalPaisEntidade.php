<?php

namespace AnexusPHP\RegraDeNegocio\Local\Entidade;

use AnexusPHP\Core\DatabaseEntity;

class LocalPaisEntidade extends DatabaseEntity
{
    const TABELA = 'local_pais';
    protected $id;
    protected $nome;
    protected $codigo;
    protected $sigla;
    protected $pessoa_campo_id;
    protected $empresa_campo_id;
    protected $bandeira;
    protected $principal;
    protected $visivel;
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
    public function setPessoaCampoId($pessoaCampoId)
    {
        $this->pessoa_campo_id = $pessoaCampoId;
        return $this;
    }
    public function getPessoaCampoId()
    {
        return $this->pessoa_campo_id;
    }
    public function setEmpresaCampoId($empresaCampoId)
    {
        $this->empresa_campo_id = $empresaCampoId;
        return $this;
    }
    public function getEmpresaCampoId()
    {
        return $this->empresa_campo_id;
    }
    public function setBandeira($bandeira)
    {
        $this->bandeira = $bandeira;
        return $this;
    }
    public function getBandeira(bool $comUrl = false)
    {
        if ($comUrl) {
            if (trim($this->bandeira) == '' || !is_file(PATH_UPLOADS . 'flags' . DS . $this->bandeira)) {
                return asset('app/img/bandeira-br.png');
            }
            return upload('flags/' . $this->bandeira);
        }
        return $this->bandeira;
    }
    public function setPrincipal($principal)
    {
        $this->principal = $principal;
        return $this;
    }
    public function getPrincipal()
    {
        return $this->principal;
    }
    public function setVisivel($visivel)
    {
        $this->visivel = $visivel;
        return $this;
    }
    public function getVisivel()
    {
        return $this->visivel;
    }
    public function toArray()
    {
        return array(
            'nome' => $this->getNome(),
            'codigo' => $this->getCodigo(),
            'sigla' => $this->getSigla(),
            'pessoa_campo_id' => $this->getPessoaCampoId(),
            'empresa_campo_id' => $this->getEmpresaCampoId(),
            'bandeira' => $this->getBandeira(),
            'principal' => $this->getPrincipal(),
            'visivel' => $this->getVisivel()
        );
    }
}
