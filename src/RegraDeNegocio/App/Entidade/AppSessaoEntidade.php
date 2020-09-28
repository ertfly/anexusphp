<?php

namespace AnexusPHP\RegraDeNegocio\App\Entidade;

use AnexusPHP\Core\DatabaseEntity;
use AnexusPHP\RegraDeNegocio\App\Repositorio\AppRepositorio;

class AppSessaoEntidade extends DatabaseEntity
{
    const TABELA = 'app_sessao';
    private $id;
    private $token;
    private $app_id;
    private $pessoa_id;
    private $tipo;
    private $acesso_ip;
    private $acesso_navegador;
    private $dta_inicio;
    private $dta_atualizacao;
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

    private $app;

    /**
     * @return  AppEntidade
     */
    public function getApp()
    {
        if (!$this->app) {
            $this->app = AppRepositorio::porId($this->app_id);
        }

        return $this->app;
    }

    // /**
    //  * @var PessoaEntidade
    //  */
    // private $pessoa;

    // /**
    //  * @return  PessoaEntidade
    //  */
    // public function getPessoa($admin = false)
    // {
    //     if ($admin) {
    //         if (!is_null(request()->sid->getPessoaId()) && request()->sid->getPessoaId() == '0' && request()->sid->getAppId() == 2) {
    //             $this->pessoa = (new PessoaEntidade)
    //                 ->setId(0)
    //                 ->setNome('Anexus')
    //                 ->setSobrenome('Network')
    //                 ->setFoto('anexus.png');
    //         }
    //     }
    //     if (!$this->pessoa) {
    //         $this->pessoa = PessoaRepositorio::porId($this->pessoa_id);
    //     }
    //     return $this->pessoa;
    // }

    // /**
    //  * @var EmpresaEntidade
    //  */
    // private $empresa;

    // /**
    //  * @return  EmpresaEntidade
    //  */
    // public function getEmpresa()
    // {
    //     if (!$this->empresa && Session::item('empresa_id')) {
    //         $this->empresa = PessoaRepositorio::porId(Session::item('empresa_id'));
    //     }
    //     return $this->empresa;
    // }

    // public function getPessoaOuEmpresa()
    // {
    //     if (Session::item('empresa_id')) {
    //         return $this->getEmpresa();
    //     }
    //     return $this->getPessoa();
    // }

    // /**
    //  * @return boolean
    //  */
    // public function isLogged($admin = false)
    // {
    //     $pessoa = $this->getPessoa($admin);
    //     if (is_null($pessoa->getId()) || $pessoa->getLixo()) {
    //         return false;
    //     }

    //     return true;
    // }

    // /**
    //  * @return boolean
    //  */
    // public function isEmpresa()
    // {
    //     if (Session::item('empresa_id')) {
    //         return true;
    //     }
    //     return false;
    // }
}

