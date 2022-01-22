<?php

namespace AnexusPHP\Business\Api\Entity;

use AnexusPHP\Business\Api\Repository\ApiRepository;
use AnexusPHP\Core\MongoEntity;
use AnexusPHP\Core\Tools\Number;
use AnexusPHP\Core\Tools\Strings;
use AnexusPHP\Core\Tools\Boolean;

class ApiKeyEntity extends MongoEntity
{
    const TABLE = 'api_key';
    protected $_id;
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
        $this->_id = Number::intNull($id);
        return $this;
    }
    public function getId()
    {
        return $this->_id;
    }
    public function setApiId($apiId)
    {
        $this->api_id = Number::intNull($apiId);
        return $this;
    }
    public function getApiId()
    {
        return $this->api_id;
    }
    public function setName($name)
    {
        $this->name = Strings::null($name);
        return $this;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setAppKey($appKey)
    {
        $this->app_key = Strings::null($appKey);
        return $this;
    }
    public function getAppKey()
    {
        return $this->app_key;
    }
    public function setSecretKey($secretKey)
    {
        $this->secret_key = Strings::null($secretKey);
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
        return $this->webhook;
    }
    public function setWebhook($webhook)
    {
        $this->webhook = Boolean::null($webhook);

        return $this;
    }
    public function setUriDomain($uri_domain)
    {
        $this->uri_domain = Strings::null($uri_domain);
        return $this;
    }
    public function getUriDomain()
    {
        return $this->uri_domain;
    }
    public function setUriHook($uri_hook)
    {
        $this->uri_hook = Strings::null($uri_hook);
        return $this;
    }
    public function getUriHook()
    {
        return $this->uri_hook;
    }
    public function setCreatedAt($createdAt)
    {
        if (is_string($createdAt)) {
            $createdAt = strtotime($createdAt);
        }
        $this->created_at = Number::intNull($createdAt);
        return $this;
    }
    public function getCreatedAt()
    {
        if (is_null($this->created_at)) {
            $this->created_at = strtotime(date('Y-m-d H:i:s'));
        }

        if (is_string($this->created_at)) {
            $this->created_at = strtotime($this->created_at);
        }

        return $this->created_at;
    }
    public function setUpdatedAt($updatedAt)
    {
        if (is_string($updatedAt)) {
            $updatedAt = strtotime($updatedAt);
        }
        $this->updated_at = Number::intNull($updatedAt);
        return $this;
    }
    public function getUpdatedAt()
    {
        if (!is_null($this->updated_at)) {
            if (is_string($this->updated_at)) {
                $this->updated_at = strtotime($this->updated_at);
            }
        }
        return $this->updated_at;
    }
    public function setExpiredAt($expiredAt)
    {
        if (is_string($expiredAt)) {
            $expiredAt = strtotime($expiredAt);
        }
        $this->expired_at = Number::intNull($expiredAt);
        return $this;
    }
    public function getExpiredAt($format = false)
    {
        if (!is_null($this->expired_at)) {
            if (is_string($this->expired_at)) {
                $this->expired_at = strtotime($this->expired_at);
            }
        }

        if ($format && $this->expired_at) {
            return date('d/m/Y', $this->expired_at);
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
            '_id' => $this->getId(),
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
