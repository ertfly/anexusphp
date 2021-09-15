<?php

namespace AnexusPHP\Business\App\Entity;

use AnexusPHP\Business\App\Rule\AppSessionRule;
use AnexusPHP\Business\Authfast\Entity\AuthfastEntity;
use AnexusPHP\Business\Authfast\Repository\AuthfastRepository;
use AnexusPHP\Business\Region\Entity\RegionCountryEntity;
use AnexusPHP\Core\DatabaseEntity;
use AnexusPHP\Core\Session;

class AppSessionEntity extends DatabaseEntity
{
    const TABLE = 'app_session';
    protected $id;
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
    public function setAuthfastId($authfastId)
    {
        $this->authfast_id = $authfastId;

        return $this;
    }
    public function getAuthfastId()
    {
        return $this->authfast_id;
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
    public function getAuthfastToken()
    {
        return $this->authfast_token;
    }
    public function setAuthfastToken($authfastToken)
    {
        $this->authfast_token = $authfastToken;

        return $this;
    }
    public function toArray()
    {
        return [
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
    public function getAuthfast()
    {
        if (!$this->authfast) {
            $this->authfast = AuthfastRepository::byId($this->authfast_id);
        }
        return $this->authfast;
    }

    /**
     * @return boolean
     */
    public function isLogged()
    {
        if (Session::item('manager')) {
            return true;
        }

        $authfast = $this->getAuthfast();
        if (is_null($authfast->getId())) {
            return false;
        }

        if ($authfast->getExpiredAt()) {
            if (strtotime(date('Y-m-d H:i:s')) > strtotime($authfast->getExpiredAt())) {
                return false;
            }
        }

        return true;
    }

    public function isLoggedAuthfast(RegionCountryEntity $country, $appKey, $secretKey, $baseUrl)
    {
        $data = AppSessionRule::checkAuthfastToken($appKey, $secretKey, $baseUrl, $this->getAuthfastToken(), $country->getCode());
        if ($data['logged']) {
            $authfast = AuthfastRepository::byCode($data['user']['code']);
            if (!$authfast->getId()) {
                $authfast
                    ->setCode($data['user']['code'])
                    ->setFirstname($data['user']['firstname'])
                    ->setLastname($data['user']['lastname'])
                    ->setUsername($data['user']['username'])
                    ->setEmail($data['user']['email'])
                    ->setDocument($data['user']['document'])
                    ->setPhoto(str_replace('http://', 'https://', $data['user']['photo']))
                    ->setBanner(str_replace('http://', 'https://', $data['user']['banner']))
                    ->setRegionCountryId($country->getId());
            }

            $this->authfast_id = $authfast->getId();
            AppSessionRule::update($this);
            return true;
        }

        return false;
    }
}
