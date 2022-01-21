<?php

namespace AnexusPHP\Business\Api\Entity;

use AnexusPHP\Core\MongoEntity;
use AnexusPHP\Core\Tools\Number;
use AnexusPHP\Core\Tools\Strings;
use AnexusPHP\Core\Tools\Boolean;

class ApiEntity extends MongoEntity
{
    const TABLE = 'api';
    protected $_id;
    protected $name;
    protected $created_at;
    protected $updated_at;
    protected $expired_at;
    protected $trash;
    public function setId($id)
    {
        $this->_id = Number::intNull($id);
        return $this;
    }
    public function getId()
    {
        return Number::intNull($this->_id);
    }
    public function setName($name)
    {
        $this->name = Strings::null($name);
        return $this;
    }
    public function getName()
    {
        return Strings::null($this->name);
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

        return Number::intNull($this->created_at);
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
        return  Number::intNull($this->updated_at);
    }
    public function setExpiredAt($expiredAt)
    {
        if (is_string($expiredAt)) {
            $expiredAt = strtotime($expiredAt);
        }
        $this->expired_at = Number::intNull($expiredAt);
        return $this;
    }
    public function getExpiredAt($format = false, $f = 'd/m/Y H:i:s')
    {
        if (!is_null($this->expired_at)) {
            if (is_string($this->expired_at)) {
                $this->expired_at = strtotime($this->expired_at);
            }
            if ($format) {
                return date($f, Number::intNull($this->expired_at));
            }
        }
        return Number::intNull($this->expired_at);
    }
    public function getTrash()
    {
        if (is_null($this->trash)) {
            $this->trash = false;
        }
        return Boolean::null($this->trash);
    }
    public function setTrash($trash)
    {
        $this->trash = Boolean::null($trash);

        return $this;
    }
    public function toArray()
    {
        return [
            '_id' => $this->getId(),
            'name' => $this->getName(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt(),
            'expired_at' => $this->getExpiredAt(),
            'trash' => $this->getTrash(),
        ];
    }
}
