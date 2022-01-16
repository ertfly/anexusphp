<?php

namespace AnexusPHP\Business\Api\Entity;

use AnexusPHP\Core\MongoEntity;

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
        $this->_id = $id;
        return $this;
    }
    public function getId()
    {
        return $this->_id;
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
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
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
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
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
    public function setExpiredAt($expired_at)
    {
        $this->expired_at = $expired_at;
        return $this;
    }
    public function getExpiredAt($format = false, $f = 'd/m/Y H:i:s')
    {
        if (!is_null($this->expired_at)) {
            if (is_string($this->expired_at)) {
                $this->expired_at = strtotime($this->expired_at);
            }
        }
        if ($format && $this->expired_at) {
            return date($f, $this->expired_at);
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
        $this->trash = $trash;

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
