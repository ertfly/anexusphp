<?php

namespace AnexusPHP\Business\App\Entity;

use AnexusPHP\Business\Authfast\Entity\AuthfastEntity;
use AnexusPHP\Business\Authfast\Repository\AuthfastRepository;
use AnexusPHP\Core\DatabaseEntity;
use AnexusPHP\Core\Session;

class AppSessionEntity extends DatabaseEntity
{
    const TABLE = 'app_session';
    protected $id;
    protected $token;
    protected $app_id;
    protected $person_id;
    protected $support_code;
    protected $type;
    protected $access_ip;
    protected $access_browser;
    protected $created_at;
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
    public function getSupportCode()
    {
        return $this->support_code;
    }
    public function setSupportCode($supportCode)
    {
        $this->support_code = $supportCode;

        return $this;
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
    public function setAccessIp($accessIp)
    {
        $this->access_ip = $accessIp;
        return $this;
    }
    public function getAccessIp()
    {
        return $this->access_ip;
    }
    public function setAccessBrowser($accessBrowser)
    {
        $this->access_browser = $accessBrowser;
        return $this;
    }
    public function getAccessBrowser()
    {
        return $this->access_browser;
    }
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
        return $this;
    }
    public function getCreatedAt($format = false)
    {
        if ($format && $this->created_at) {
            return timeConverter($this->created_at, request()->country);
        }

        return $this->created_at;
    }
    public function setUpdatedAt($updateAt)
    {
        $this->updated_at = $updateAt;
        return $this;
    }
    public function getUpdatedAt($format = false)
    {
        if ($format && $this->updated_at) {
            return timeConverter($this->updated_at, request()->country);
        }

        return $this->updated_at;
    }
    public function toArray()
    {
        return [
            'token' => $this->getToken(),
            'app_id' => $this->getAppId(),
            'person_id' => $this->getPersonId(),
            'support_code' => $this->getSupportCode(),
            'type' => $this->getType(),
            'access_ip' => $this->getAccessIp(),
            'access_browser' => $this->getAccessBrowser(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt(),
        ];
    }

    /**
     * Undocumented variable
     *
     * @var AuthfastEntity
     */
    protected $person;

    /**
     * Undocumented function
     *
     * @return AuthfastEntity
     */
    public function getPerson()
    {
        if (!$this->person) {
            $this->person = AuthfastRepository::byId($this->person_id);
        }
        return $this->person;
    }

    /**
     * @return boolean
     */
    public function isLogged()
    {
        if (Session::item('manager')) {
            return true;
        }
        
        $person = $this->getPerson();
        if (is_null($person->getId()) || strtotime(date('Y-m-d H:i:s')) > strtotime($person->getExpiredAt())) {
            return false;
        }

        return true;
    }
}
