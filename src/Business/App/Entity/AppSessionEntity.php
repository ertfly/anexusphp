<?php

namespace AnexusPHP\Business\App\Entity;

class AppSessionEntity
{
    const TABLE = 'app_session';
    protected $id;
    protected $token;
    protected $app_id;
    protected $person_id;
    protected $type;
    protected $access_ip;
    protected $access_browser;
    protected $create_at;
    protected $updated_at;
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }
    public function getToken()
    {
        return $this->token;
    }
    public function setAppId($appId)
    {
        $this->app_id = $appId;
        return $this;
    }
    public function getAppId()
    {
        return $this->app_id;
    }
    public function setPersonId($personId)
    {
        $this->person_id = $personId;
        return $this;
    }
    public function getPersonId()
    {
        return $this->person_id;
    }
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
    public function getType()
    {
        return $this->type;
    }
    public function setAccessIp($acessoIp)
    {
        $this->acesso_ip = $acessoIp;
        return $this;
    }
    public function getAccessIp()
    {
        return $this->acesso_ip;
    }
    public function setAccessBrowser($accessBrowser)
    {
        $this->acesso_navegador = $accessBrowser;
        return $this;
    }
    public function getAccessBrowser()
    {
        return $this->acesso_navegador;
    }
    public function setDtaInicio($dtaInicio)
    {
        $this->dta_inicio = $dtaInicio;
        return $this;
    }
    public function getDtaInicio()
    {
        return $this->dta_inicio;
    }
    public function setDtaAtualizacao($dtaAtualizacao)
    {
        $this->dta_atualizacao = $dtaAtualizacao;
        return $this;
    }
    public function getDtaAtualizacao()
    {
        return $this->dta_atualizacao;
    }
    public function toArray()
    {
        return array(
            'token' => $this->getToken(),
            'app_id' => $this->getAppId(),
            'person_id' => $this->getPessoaId(),
            'tipo' => $this->getTipo(),
            'acesso_ip' => $this->getAcessoIp(),
            'acesso_navegador' => $this->getAcessoNavegador(),
            'dta_inicio' => $this->getDtaInicio(),
            'dta_atualizacao' => $this->getDtaAtualizacao(),
        );
    }
}
