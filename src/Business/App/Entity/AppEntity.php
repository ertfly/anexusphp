<?php

namespace AnexusPHP\Business\App\Entity;

use AnexusPHP\Core\MongoEntity;

class AppEntity extends MongoEntity
{
    const TABLE = 'app';
    protected $_id;
    protected $name;
    protected $key;
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
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }
    public function getKey()
    {
        return $this->key;
    }
    public function toArray()
    {
        return [
            '_id' => $this->getId(),
            'name' => $this->getName(),
            'key' => $this->getKey()
        ];
    }
}
