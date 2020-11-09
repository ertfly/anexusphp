<?php

namespace AnexusPHP\Business\Region\Entity;

use AnexusPHP\Core\DatabaseEntity;

class RegionCountryEntity extends DatabaseEntity
{
    const TABLE = 'region_country';
    protected $id;
    protected $name;
    protected $code;
    protected $initials;
    protected $flag;
    protected $principal;
    protected $visible;
    protected $date_format;
    protected $date_hour_format;
    protected $locale;
    protected $timezone;
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
    public function setFlag($flag)
    {
        $this->flag = $flag;
        return $this;
    }
    public function getFlag(bool $withUrl = false)
    {
        if ($withUrl) {
            if (trim($this->flag) == '' || !is_file(PATH_UPLOADS . 'flags' . DS . $this->flag)) {
                return asset('app/img/no-image.jpg');
            }
            return upload('flags/' . $this->flag);
        }
        return $this->flag;
    }
    public function setPrincipal($principal)
    {
        $this->principal = $principal;
        return $this;
    }
    public function getPrincipal()
    {
        return $this->principal;
    }
    public function setVisible($visible)
    {
        $this->visible = $visible;
        return $this;
    }
    public function getVisible()
    {
        return $this->visible;
    }
    public function setDateFormat($dateFormat)
    {
        $this->date_format = $dateFormat;
        return $this;
    }
    public function getDateFormat()
    {
        return $this->date_format;
    }
    public function setDateHourFormat($dateHourFormat)
    {
        $this->date_hour_format = $dateHourFormat;
        return $this;
    }
    public function getDateHourFormat()
    {
        return $this->date_hour_format;
    }
    public function setLocale($locale)
    {
        $this->locale = $locale;
        return $this;
    }
    public function getLocale()
    {
        return $this->locale;
    }
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;
        return $this;
    }
    public function getTimezone()
    {
        return $this->timezone;
    }
    public function toArray()
    {
        return [
            'name' => $this->getName(),
            'code' => $this->getCode(),
            'initials' => $this->getInitials(),
            'flag' => $this->getFlag(),
            'principal' => $this->getPrincipal(),
            'visible' => $this->getVisible(),
            'date_format' => $this->getDateFormat(),
            'date_hour_format' => $this->getDateHourFormat(),
            'locale' => $this->getLocale(),
            'timezone' => $this->getTimezone()
        ];
    }
}
