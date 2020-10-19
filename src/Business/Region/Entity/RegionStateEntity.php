<?php

namespace AnexusPHP\Business\Region\Entity;

use AnexusPHP\Core\DatabaseEntity;

class RegionStateEntity extends DatabaseEntity
{
    const TABLE = 'region_state';
    protected $id;
    protected $country_id;
    protected $name;
    protected $code;
    protected $initials;
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setCountryId($countryId)
    {
        $this->country_id = $countryId;
        return $this;
    }
    public function getCountryId()
    {
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
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }
    public function getCode()
    {
        return $this->code;
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
            'country_id' => $this->getCountryId(),
            'name' => $this->getName(),
            'code' => $this->getCode(),
            'initials' => $this->getInitials()
        ];
    }
}
