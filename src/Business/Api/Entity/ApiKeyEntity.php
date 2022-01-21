<?php

namespace AnexusPHP\Business\Api\Entity;

use AnexusPHP\Business\Api\Repository\ApiRepository;
use AnexusPHP\Core\MongoEntity;

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
        $this->_id = intval($id);
        return $this;
    }
    public function getId()
    {
        if (!is_null($this->_id)) {
            $this->_id = intval($this->_id);
        }
        return $this->_id;
    }
    public function setApiId($apiId)
    {
        $this->api_id = trim($apiId) != '' ? intval($apiId) : null;
        return $this;
    }
    public function getApiId()
    {
        if (!is_null($this->api_id)) {
            $this->api_id = intval($this->api_id);
        }
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
        $this->webhook = boolval($webhook);

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
    public function setCreatedAt($createdAt)
    {
        if (is_string($createdAt)) {
            $createdAt = strtotime($createdAt);
        }
        $this->created_at = intval($createdAt);
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
        $this->updated_at = $updatedAt;
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
        $this->expired_at = intval($expiredAt);
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
        return boolval($this->trash);
    }
    public function setTrash($trash)
    {
        $this->trash = boolval($trash);

        return $this;
    }
    public function getWebhookLog()
    {
        return $this->webhook_log;
    }
    public function setWebhookLog($webhookLog)
    {
        $this->webhook_log = $webhookLog;

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
