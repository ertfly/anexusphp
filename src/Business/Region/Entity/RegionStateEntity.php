<?php

namespace AnexusPHP\Business\Region\Entity;

use AnexusPHP\Business\Region\Repository\RegionCountryRepository;
use AnexusPHP\Core\MongoEntity;
use AnexusPHP\Core\Tools\Number;
use AnexusPHP\Core\Tools\Strings;

class RegionStateEntity extends MongoEntity
{
    const TABLE = 'region_state';
    protected $_id;
    protected $country_id;
    protected $name;
    protected $initials;
    public function setId($id)
    {
        $this->_id = Number::intNull($id);
        return $this;
    }
    public function getId()
    {
        return Number::intNull($this->_id);
    }
    public function setCountryId($countryId)
    {
        $this->country_id = Number::intNull($countryId);
        return $this;
    }
    public function getCountryId()
    {
        return Number::intNull($this->country_id);
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
    public function setInitials($initials)
    {
        $this->initials = Strings::null($initials);
        return $this;
    }
    public function getInitials()
    {
        return Strings::null($this->initials);
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
