<?php

namespace AnexusPHP\Business\App\Entity;

use AnexusPHP\Core\DatabaseEntity;

class AppEntity extends DatabaseEntity
{
    const TABLE = 'app';
    protected $id;
    protected $name;
    protected $key;
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
        return array(
            'name' => $this->getName(),
            'key' => $this->getKey()
        );
    }
}
