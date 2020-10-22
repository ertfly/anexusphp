<?php

namespace AnexusPHP\Business\Api\Entity;

use AnexusPHP\Core\DatabaseEntity;

class ApiKeyEntity extends DatabaseEntity
{
    const TABLE = 'api_key';
    protected $id;
    protected $api_id;
    protected $app_key;
    protected $secret_key;
    protected $uri_domain;
    protected $uri_hook;
    protected $created_at;
    protected $updated_at;
    protected $expired_at;
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setApiId($api_id)
    {
        $this->api_id = $api_id;
        return $this;
    }
    public function getApiId()
    {
        return $this->api_id;
    }
    public function setAppKey($app_key)
    {
        $this->app_key = $app_key;
        return $this;
    }
    public function getAppKey()
    {
        return $this->app_key;
    }
    public function setSecretKey($secret_key)
    {
        $this->secret_key = $secret_key;
        return $this;
    }
    public function getSecretKey()
    {
        return $this->secret_key;
    }
    public function setUriDomain($uri_domain)
    {
        $this->uri_domain = $uri_domain;
        return $this;
    }
    public function getUriDomain()
    {
        return $this->uri_domain;
    }
    public function setUriHook($uri_hook)
    {
        $this->uri_hook = $uri_hook;
        return $this;
    }
    public function getUriHook()
    {
        return $this->uri_hook;
    }
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
        return $this;
    }
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
        return $this;
    }
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
    public function setExpiredAt($expired_at)
    {
        $this->expired_at = $expired_at;
        return $this;
    }
    public function getExpiredAt()
    {
        return $this->expired_at;
    }
    public function toArray()
    {
        return [
            'api_id' => $this->getApiId(),
            'app_key' => $this->getAppKey(),
            'secret_key' => $this->getSecretKey(),
            'uri_domain' => $this->getUriDomain(),
            'uri_hook' => $this->getUriHook(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt(),
            'expired_at' => $this->getExpiredAt(),
        ];
    }
}
