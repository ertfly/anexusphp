<?php

namespace AnexusPHP\Business\Api\Entity;

use AnexusPHP\Core\DatabaseEntity;
use AnexusPHP\Core\Tools\Boolean;

class ApiEntity extends DatabaseEntity
{
    const TABLE = 'api';
    protected $id;
    protected $name;
    protected $created_at;
    protected $updated_at;
    protected $expired_at;
    protected $trash;
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
    public function getExpiredAt($format = false, $f = 'd/m/Y H:i:s')
    {
        if ($format && $this->expired_at) {
            return date($f, strtotime($this->expired_at));
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
    public function toArray()
    {
        return [
            'name' => $this->getName(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt(),
            'expired_at' => $this->getExpiredAt(),
            'trash' => $this->getTrash(),
        ];
    }
}
