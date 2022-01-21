<?php

namespace AnexusPHP\Business\Region\Entity;

use AnexusPHP\Business\Region\Repository\RegionStateRepository;
use AnexusPHP\Core\MongoEntity;
use AnexusPHP\Core\Tools\Number;
use AnexusPHP\Core\Tools\Strings;

class RegionCityEntity extends MongoEntity
{
    const TABLE = 'region_city';
    protected $_id;
    protected $state_id;
    protected $name;
    protected $code;
    public function setId($id)
    {
        $this->_id = Number::intNull($id);
        return $this;
    }
    public function getId()
    {
        return Number::intNull($this->_id);
    }
    public function setStateId($stateId)
    {
        $this->state_id = Number::intNull($stateId);
        return $this;
    }
    public function getStateId()
    {
        return Number::intNull($this->state_id);
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
    public function setCode($code)
    {
        $this->code = Strings::null($code);
        return $this;
    }
    public function getCode()
    {
        return Strings::null($this->code);
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
