<?php

namespace AnexusPHP\Business\App\Entity;

use AnexusPHP\Business\Authfast\Entity\AuthfastEntity;
use AnexusPHP\Business\Authfast\Repository\AuthfastRepository;
use AnexusPHP\Core\MongoEntity;
use AnexusPHP\Core\Tools\Number;
use AnexusPHP\Core\Tools\Strings;
use AnexusPHP\Core\Tools\Boolean;

class AppSessionEntity extends MongoEntity
{
    const TABLE = 'app_session';
    protected $_id;
    protected $token;
    protected $app_id;
    protected $authfast_id;
    protected $support_code;
    protected $type;
    protected $access_ip;
    protected $access_browser;
    protected $created_at;
    protected $updated_at;
    protected $authfast_token;
    protected $manager;
    public function setId($id)
    {
        $this->_id = Number::intNull($id);
        return $this;
    }
    public function getId()
    {
        return Number::intNull($this->_id);
    }
    public function setToken($token)
    {
        $this->token = Strings::null($token);
        return $this;
    }
    public function getToken()
    {
        return Strings::null($this->token);
    }
    public function setAppId($appId)
    {
        $this->app_id = Number::intNull($appId);
        return $this;
    }
    public function getAppId()
    {
        return Number::intNull($this->app_id);
    }
    public function setAuthfastId($authfastId)
    {
        $this->authfast_id = Number::intNull($authfastId);

        return $this;
    }
    public function getAuthfastId()
    {
        return Number::intNull($this->authfast_id);
    }
    public function getSupportCode()
    {
        return Strings::null($this->support_code);
    }
    public function setSupportCode($supportCode)
    {
        $this->support_code = Strings::null($supportCode);

        return $this;
    }
    public function setType($type)
    {
        $this->type = Strings::null($type);
        return $this;
    }
    public function getType()
    {
        return Strings::null($this->type);
    }
    public function setAccessIp($accessIp)
    {
        $this->access_ip = Strings::null($accessIp);
        return $this;
    }
    public function getAccessIp()
    {
        return Strings::null($this->access_ip);
    }
    public function setAccessBrowser($accessBrowser)
    {
        $this->access_browser = Strings::null($accessBrowser);
        return $this;
    }
    public function getAccessBrowser()
    {
        return Strings::null($this->access_browser);
    }
    public function setCreatedAt($createdAt)
    {
        if (is_string($createdAt)) {
            $createdAt = strtotime($createdAt);
        }
        $this->created_at = Number::intNull($createdAt);
        return $this;
    }
    public function getCreatedAt($format = false)
    {
        if (is_null($this->created_at)) {
            $this->created_at = strtotime(date('Y-m-d H:i:s'));
        }

        if (is_string($this->created_at)) {
            $this->created_at = strtotime($this->created_at);
        }

        if ($format && !is_null($this->created_at)) {
            return date('d/m/Y H:i:s', $this->created_at);
        }

        return Number::intNull($this->created_at);
    }
    public function setUpdatedAt($updateAt)
    {
        if (is_string($updateAt)) {
            $updateAt = strtotime($updateAt);
        }
        $this->updated_at = Number::intNull($updateAt);
        return $this;
    }
    public function getUpdatedAt($format = false)
    {
        if (is_null($this->updated_at)) {
            $this->updated_at = $this->getCreatedAt();
        }

        if (is_string($this->updated_at)) {
            $this->updated_at = strtotime($this->updated_at);
        }

        if ($format && !is_null($this->updated_at)) {
            return date('d/m/Y H:i:s', $this->updated_at);
        }

        return Number::intNull($this->updated_at);
    }
    public function getAuthfastToken()
    {
        return Strings::null($this->authfast_token);
    }
    public function setAuthfastToken($authfastToken)
    {
        $this->authfast_token = Strings::null($authfastToken);

        return $this;
    }
    public function getManager()
    {
        if (is_null($this->manager)) {
            $this->manager = false;
        }
        return Boolean::null($this->manager);
    }
    public function setManager($manager)
    {
        $this->manager = Boolean::null($manager);

        return $this;
    }
    public function toArray()
    {
        return [
            '_id' => $this->getId(),
            'token' => $this->getToken(),
            'app_id' => $this->getAppId(),
            'authfast_id' => $this->getAuthfastId(),
            'support_code' => $this->getSupportCode(),
            'type' => $this->getType(),
            'access_ip' => $this->getAccessIp(),
            'access_browser' => $this->getAccessBrowser(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt(),
            'authfast_token' => $this->getAuthfastToken(),
            'manager' => $this->getManager(),
        ];
    }

    /**
     * Undocumented variable
     *
     * @var AuthfastEntity
     */
    protected $authfast;

    /**
     * Undocumented function
     *
     * @return AuthfastEntity
     */
    public function getAuthfast($refresh = false, $cls = AuthfastEntity::class)
    {
        if (!$this->authfast || $refresh) {
            $this->authfast = AuthfastRepository::byId($this->authfast_id, $cls);
        }
        return $this->authfast;
    }

    /**
     * @return boolean
     */
    public function isLogged()
    {
        if ($this->getManager()) {
            return true;
        }

        $authfast = $this->getAuthfast();
        if (is_null($authfast->getId())) {
            return false;
        }

        if ($authfast->getExpiredAt()) {
            if (strtotime(date('Y-m-d H:i:s')) > $authfast->getExpiredAt()) {
                return false;
            }
        }

        return true;
    }
}
