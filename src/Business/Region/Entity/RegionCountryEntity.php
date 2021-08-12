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
    protected $money_symbol_left;
    protected $money_symbol_right;
    protected $money_decimal_place;
    protected $money_exchange;
    protected $separator_decimal;
    protected $separator_thousands;
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
    public function getMoneySymbolLeft()
    {
        return $this->money_symbol_left;
    }
    public function setMoneySymbolLeft($moneySymbolLeft)
    {
        $this->money_symbol_left = $moneySymbolLeft;

        return $this;
    }
    public function getMoneySymbolRight()
    {
        return $this->money_symbol_right;
    }
    public function setMoneySymbolRight($moneySymbolRight)
    {
        $this->money_symbol_right = $moneySymbolRight;

        return $this;
    }
    public function getMoneyDecimalPlace()
    {
        return $this->money_decimal_place;
    }
    public function setMoneyDecimalPlace($moneyDecimalPlace)
    {
        $this->money_decimal_place = $moneyDecimalPlace;

        return $this;
    }
    public function getMoneyExchange($format = false)
    {
        if (is_null($this->money_exchange)) {
            $this->money_exchange = 1;
        }
        if ($format) {
            return number_format($this->money_exchange, $this->getMoneyDecimalPlace(), $this->getSeparatorDecimal(), $this->getSeparatorThousands());
        }
        return doubleval($this->money_exchange);
    }
    public function setMoneyExchange($moneyExchange)
    {
        $this->money_exchange = doubleval($moneyExchange);

        return $this;
    }
    public function getSeparatorDecimal()
    {
        return $this->separator_decimal;
    }
    public function setSeparatorDecimal($separatorDecimal)
    {
        $this->separator_decimal = $separatorDecimal;

        return $this;
    }
    public function getSeparatorThousands()
    {
        return $this->separator_thousands;
    }
    public function setSeparatorThousands($separatorThousands)
    {
        $this->separator_thousands = $separatorThousands;

        return $this;
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
            'timezone' => $this->getTimezone(),
            'money_symbol_left' => $this->getMoneySymbolLeft(),
            'money_symbol_right' => $this->getMoneySymbolRight(),
            'money_decimal_place' => $this->getMoneyDecimalPlace(),
            'money_exchange' => $this->getMoneyExchange(),
            'separator_decimal' => $this->getSeparatorDecimal(),
            'separator_thousands' => $this->getSeparatorThousands(),
        ];
    }

    public function numberFormat($value)
    {
        return number_format($value, $this->getMoneyDecimalPlace(), $this->getSeparatorDecimal(), $this->getSeparatorThousands());
    }

    public function moneyFormat($value, $exchange = true)
    {
        if($exchange){
            $value = $this->moneyExchange($value);
        }
        return trim($this->getMoneySymbolLeft() . ' ' . number_format($value, $this->getMoneyDecimalPlace(), $this->getSeparatorDecimal(), $this->getSeparatorThousands()) . ' ' . $this->getMoneySymbolRight());
    }

    public function moneyExchange($value)
    {
        return $value * $this->getMoneyExchange();
    }
}
