<?php

namespace AnexusPHP\Business\Local\Entity;

use AnexusPHP\Core\DatabaseEntity;

class LocalCityEntity extends DatabaseEntity
{
    const TABLE = 'local_country';
    protected $id;
    protected $state_id;
    protected $name;
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setStateId($stateId)
    {
        $this->state_id = $stateId;
        return $this;
    }
    public function getStateId()
    {
        return $this->state_id;
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
    public function toArray()
    {
        return array(
            'id' => $this->getId(),
            'state_id' => $this->getStateId(),
            'name' => $this->getName()
        );
    }
}
