<?php

namespace AnexusPHP\Business\Api\Entity;

use AnexusPHP\Business\Api\Repository\ApiRepository;
use AnexusPHP\Core\DatabaseEntity;
use AnexusPHP\Core\Tools\Boolean;
use AnexusPHP\Core\Tools\Strings;

class ApiKeyEntity extends DatabaseEntity
{
    const TABLE = 'api_key';
    protected $id;
    protected $api_id;
    protected $name;
    protected $app_key;
    protected $secret_key;
    protected $webhook;
    protected $uri_domain;
    protected $uri_hook;
    protected $created_at;
    protected $updated_at;
    protected $expired_at;
    protected $trash;
    protected $webhook_log;
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
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    public function getName()
    {
        return $this->name;
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
    public function getWebhook()
    {
        if (is_null($this->webhook)) {
            $this->webhook = false;
        }
        return boolval($this->webhook);
    }
    public function setWebhook($webhook)
    {
        $this->webhook = Boolean::null($webhook);

        return $this;
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
    public function getExpiredAt($format = false)
    {
        if ($format && $this->expired_at) {
            return date('d/m/Y', strtotime($this->expired_at));
        }

        return $this->expired_at;
    }
    public function getTrash()
    {
        if (is_null($this->trash)) {
            $this->trash = false;
        }
        return $this->trash;
    }
    public function setTrash($trash)
    {
        $this->trash = Boolean::null($trash);

        return $this;
    }
    public function getWebhookLog()
    {
        return $this->webhook_log;
    }
    public function setWebhookLog($webhookLog)
    {
        $this->webhook_log = Strings::null($webhookLog);

        return $this;
    }
    public function toArray()
    {
        return [
            'api_id' => $this->getApiId(),
            'name' => $this->getName(),
            'app_key' => $this->getAppKey(),
            'secret_key' => $this->getSecretKey(),
            'webhook' => $this->getWebhook(),
            'uri_domain' => $this->getUriDomain(),
            'uri_hook' => $this->getUriHook(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt(),
            'expired_at' => $this->getExpiredAt(),
            'trash' => $this->getTrash(),
            'webhook_log' => $this->getWebhookLog(),
        ];
    }

    /**
     * @var ApiEntity
     */
    private $api;

    /**
     * @return  ApiEntity
     */
    public function getApi($refresh = false, $cls = ApiEntity::class)
    {
        if (!$this->api || $refresh) {
            $this->api = ApiRepository::byId($this->api_id, $cls);
        }
        return $this->api;
    }
}
