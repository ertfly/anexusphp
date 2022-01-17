<?php

namespace PequiPHP\Business\Region\Entity;

use PequiPHP\Business\Region\Repository\RegionCountryRepository;
use PequiPHP\Core\MongoEntity;

class RegionStateEntity extends MongoEntity
{
    const TABLE = 'region_state';
    protected $_id;
    protected $country_id;
    protected $name;
    protected $initials;
    public function setId($id)
    {
        $this->_id = intval($id);
        return $this;
    }
    public function getId()
    {
        if (!is_null($this->_id)) {
            $this->_id = intval($this->_id);
        }
        return $this->_id;
    }
    public function setCountryId($countryId)
    {
        $this->country_id = intval($countryId);
        return $this;
    }
    public function getCountryId()
    {
        if (!is_null($this->country_id)) {
            $this->country_id = intval($this->country_id);
        }
        return $this->country_id;
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
    public function setInitials($initials)
    {
        $this->initials = $initials;
        return $this;
    }
    public function getInitials()
    {
        return $this->initials;
    }
    public function toArray()
    {
        return [
            '_id' => $this->getId(),
            'country_id' => $this->getCountryId(),
            'name' => $this->getName(),
            'initials' => $this->getInitials()
        ];
    }

    /**
     * Undocumented variable
     *
     * @var RegionCountryEntity
     */
    private $country;

    /**
     * Get undocumented variable
     *
     * @return  RegionCountryEntity
     */
    public function getCountry($className = RegionCountryEntity::class)
    {
        if (!$this->country) {
            $this->country = RegionCountryRepository::byId($this->country_id, $className);
        }
        return $this->country;
    }
}
