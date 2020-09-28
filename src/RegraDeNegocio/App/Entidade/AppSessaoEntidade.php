<?php

namespace AnexusPHP\RegraDeNegocio\App\Entidade;

use AnexusPHP\Core\DatabaseEntity;

class AppSessaoEntidade extends DatabaseEntity
{
    const TABELA = 'app_sessao';
    protected $id;
    protected $token;
    protected $app_id;
    protected $pessoa_id;
    protected $tipo;
    protected $acesso_ip;
    protected $acesso_navegador;
    protected $dta_inicio;
    protected $dta_atualizacao;
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
    public function setPessoaId($pessoaId)
    {
        $this->pessoa_id = $pessoaId;
        return $this;
    }
    public function getPessoaId()
    {
        return $this->pessoa_id;
    }
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }
    public function getTipo()
    {
        return $this->tipo;
    }
    public function setAcessoIp($acessoIp)
    {
        $this->acesso_ip = $acessoIp;
        return $this;
    }
    public function getAcessoIp()
    {
        return $this->acesso_ip;
    }
    public function setAcessoNavegador($acessoNavegador)
    {
        $this->acesso_navegador = $acessoNavegador;
        return $this;
    }
    public function getAcessoNavegador()
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
            'pessoa_id' => $this->getPessoaId(),
            'tipo' => $this->getTipo(),
            'acesso_ip' => $this->getAcessoIp(),
            'acesso_navegador' => $this->getAcessoNavegador(),
            'dta_inicio' => $this->getDtaInicio(),
            'dta_atualizacao' => $this->getDtaAtualizacao(),
        );
    }
}

