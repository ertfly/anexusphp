<?php

namespace PequiPHP\Business\Region\Entity;

use PequiPHP\Business\Region\Repository\RegionStateRepository;
use PequiPHP\Core\MongoEntity;

class RegionCityEntity extends MongoEntity
{
    const TABLE = 'region_city';
    protected $_id;
    protected $state_id;
    protected $name;
    protected $code;
    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }
    public function getId()
    {
        return $this->_id;
    }
    public function setStateId($stateId)
    {
        $this->state_id = intval($stateId);
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
            '_id' => $this->getId(),
            'state_id' => $this->getStateId(),
            'name' => $this->getName(),
            'code' => $this->getCode()
        ];
    }

    /**
     * Undocumented variable
     *
     * @var RegionStateEntity
     */
    private $state;


    /**
     * Get undocumented variable
     *
     * @return  RegionStateEntity
     */
    public function getState()
    {
        if (!$this->state) {
            $this->state = RegionStateRepository::byId($this->state_id);
        }
        return $this->state;
    }
}
