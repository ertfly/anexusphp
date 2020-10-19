<?php

namespace AnexusPHP\Business\Language\Entity;

use AnexusPHP\Core\DatabaseEntity;

class LanguageEntity extends DatabaseEntity
{
    const TABLE = 'language';
    protected $id;
    protected $region_country_id;
    protected $value;
    protected $screen_id;
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setRegionCountryId($regionCountryId)
    {
        $this->region_country_id = $regionCountryId;
        return $this;
    }
    public function getRegionCountryId()
    {
        return $this->region_country_id;
    }
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
    public function getValue()
    {
        return $this->value;
    }
    public function setScreenId($screenId)
    {
        $this->screen_id = $screenId;
        return $this;
    }
    public function getScreenId()
    {
        return $this->screen_id;
    }
    public function toArray()
    {
        return [
            'region_country_id' => $this->getRegionCountryId(),
            'value' => $this->getValue(),
            'screen_id' => $this->getScreenId()
        ];
    }
}
