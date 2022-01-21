<?php

namespace AnexusPHP\Business\Region\Entity;

use AnexusPHP\Core\MongoEntity;
use AnexusPHP\Core\Tools\Number;
use AnexusPHP\Core\Tools\Strings;
use Core\Tools\Boolean;

class RegionCountryEntity extends MongoEntity
{
    const TABLE = 'region_country';
    protected $_id;
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
        $this->_id = Number::intNull($id);
        return $this;
    }
    public function getId()
    {
        return Number::intNull($this->_id);
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
    public function setInitials($initials)
    {
        $this->initials = Strings::null($initials);
        return $this;
    }
    public function getInitials()
    {
        return Strings::null($this->initials);
    }
    public function setFlag($flag)
    {
        $this->flag = $flag;
        return $this;
    }
    public function getFlag(bool $withUrl = false)
    {
        if ($withUrl) {
            return CDN . $this->flag;
        }
        return $this->flag;
    }
    public function setPrincipal($principal)
    {
        $this->principal = Boolean::null($principal);
        return $this;
    }
    public function getPrincipal()
    {
        if (is_null($this->principal)) {
            $this->principal = false;
        }
        return Boolean::null($this->principal);
    }
    public function setVisible($visible)
    {
        $this->visible = Boolean::null($visible);
        return $this;
    }
    public function getVisible()
    {
        if (is_null($this->visible)) {
            $this->visible = false;
        }
        return Boolean::null($this->visible);
    }
    public function setDateFormat($dateFormat)
    {
        $this->date_format = Strings::null($dateFormat);
        return $this;
    }
    public function getDateFormat()
    {
        return Strings::null($this->date_format);
    }
    public function setDateHourFormat($dateHourFormat)
    {
        $this->date_hour_format = Strings::null($dateHourFormat);
        return $this;
    }
    public function getDateHourFormat()
    {
        return Strings::null($this->date_hour_format);
    }
    public function setLocale($locale)
    {
        $this->locale = Strings::null($locale);
        return $this;
    }
    public function getLocale()
    {
        return Strings::null($this->locale);
    }
    public function setTimezone($timezone)
    {
        $this->timezone = Strings::null($timezone);
        return $this;
    }
    public function getTimezone()
    {
        return Strings::null($this->timezone);
    }
    public function getMoneySymbolLeft()
    {
        return Strings::null($this->money_symbol_left);
    }
    public function setMoneySymbolLeft($moneySymbolLeft)
    {
        $this->money_symbol_left = Strings::null($moneySymbolLeft);

        return $this;
    }
    public function getMoneySymbolRight()
    {
        return Strings::null($this->money_symbol_right);
    }
    public function setMoneySymbolRight($moneySymbolRight)
    {
        $this->money_symbol_right = Strings::null($moneySymbolRight);

        return $this;
    }
    public function getMoneyDecimalPlace()
    {
        return Number::intNull($this->money_decimal_place);
    }
    public function setMoneyDecimalPlace($moneyDecimalPlace)
    {
        $this->money_decimal_place = Number::intNull($moneyDecimalPlace);

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
        return Number::doubleNull($this->money_exchange);
    }
    public function setMoneyExchange($moneyExchange)
    {
        $this->money_exchange = Number::doubleNull($moneyExchange);

        return $this;
    }
    public function getSeparatorDecimal()
    {
        return Strings::null($this->separator_decimal);
    }
    public function setSeparatorDecimal($separatorDecimal)
    {
        $this->separator_decimal = Strings::null($separatorDecimal);

        return $this;
    }
    public function getSeparatorThousands()
    {
        return Strings::null($this->separator_thousands);
    }
    public function setSeparatorThousands($separatorThousands)
    {
        $this->separator_thousands = Strings::null($separatorThousands);

        return $this;
    }
    public function toArray()
    {
        return [
            '_id' => $this->getId(),
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

    public function numberFormat($value, $decimalPlace = null)
    {
        if (is_null($decimalPlace)) {
            $decimalPlace = $this->getMoneyDecimalPlace();
        }
        return number_format($value, $decimalPlace, $this->getSeparatorDecimal(), $this->getSeparatorThousands());
    }

    public function moneyFormat($value, $exchange = true)
    {
        if ($exchange) {
            $value = $this->moneyExchange($value);
        }
        return trim($this->getMoneySymbolLeft() . ' ' . number_format($value, $this->getMoneyDecimalPlace(), $this->getSeparatorDecimal(), $this->getSeparatorThousands()) . ' ' . $this->getMoneySymbolRight());
    }

    public function moneyExchange($value)
    {
        return $value * $this->getMoneyExchange();
    }
}
