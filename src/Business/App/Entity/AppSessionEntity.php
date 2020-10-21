<?php

namespace AnexusPHP\Business\App\Entity;

use AnexusPHP\Core\DatabaseEntity;

class AppSessionEntity extends DatabaseEntity
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
    public function setCreateAt($createAt)
    {
        $this->create_at = $createAt;
        return $this;
    }
    public function getCreateAt($format = false)
    {
        if($format && $this->create_at){
            return timeConverter($this->create_at, request()->country);
        }

        return $this->create_at;
    }
    public function setUpdatedAt($updateAt)
    {
        $this->updated_at = $updateAt;
        return $this;
    }
    public function getUpdatedAt($format = false)
    {
        if($format && $this->updated_at){
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
            'type' => $this->getType(),
            'access_ip' => $this->getAccessIp(),
            'access_browser' => $this->getAccessBrowser(),
            'create_at' => $this->getCreateAt(),
            'updated_at' => $this->getUpdatedAt(),
        ];
    }
}
