<?php

namespace AnexusPHP\Business\Api\Entity;

use AnexusPHP\Core\DatabaseEntity;

class ApiEntity extends DatabaseEntity
{
    const TABLE = 'api';
    protected $id;
    protected $name;
    protected $img_logo;
    protected $terms_privacy;
    protected $terms_use;
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
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setImgLogo($img_logo)
    {
        $this->img_logo = $img_logo;
        return $this;
    }
    public function getImgLogo()
    {
        return $this->img_logo;
    }
    public function setTermsPrivacy($terms_privacy)
    {
        $this->terms_privacy = $terms_privacy;
        return $this;
    }
    public function getTermsPrivacy()
    {
        return $this->terms_privacy;
    }
    public function setTermsUse($terms_use)
    {
        $this->terms_use = $terms_use;
        return $this;
    }
    public function getTermsUse()
    {
        return $this->terms_use;
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
            'name' => $this->getName(),
            'img_logo' => $this->getImgLogo(),
            'terms_privacy' => $this->getTermsPrivacy(),
            'terms_use' => $this->getTermsUse(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt(),
            'expired_at' => $this->getExpiredAt(),
        ];
    }
}