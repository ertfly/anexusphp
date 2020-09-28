<?php

namespace AnexusPHP\RegraDeNegocio\Idioma\Entidade;

use AnexusPHP\Core\DatabaseEntity;

class IdiomaEntidade extends DatabaseEntity
{
    const TABELA = 'idioma';
    private $id;
    private $local_pais_id;
    private $valor;
    private $tela_id;
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setLocalPaisId($localPaisId)
    {
        $this->local_pais_id = $localPaisId;
        return $this;
    }
    public function getLocalPaisId()
    {
        return $this->local_pais_id;
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
    public function setTelaId($telaId)
    {
        $this->tela_id = $telaId;
        return $this;
    }
    public function getTelaId()
    {
        return $this->tela_id;
    }
    public function toArray()
    {
        return array(
            'local_pais_id' => $this->getLocalPaisId(),
            'valor' => $this->getValor(),
            'tela_id' => $this->getTelaId()
        );
    }
}
