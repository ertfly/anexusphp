<?php

namespace AnexusPHP\Business\Region\Entity;

use AnexusPHP\Core\DatabaseEntity;

class RegionCityEntity extends DatabaseEntity
{
    const TABLE = 'region_city';
    protected $id;
    protected $state_id;
    protected $name;
    protected $code;
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
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }
    public function getCode()
    {
        return $this->code;
    }
    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'state_id' => $this->getStateId(),
            'name' => $this->getName(),
            'code' => $this->getCode()
        ];
    }
}
