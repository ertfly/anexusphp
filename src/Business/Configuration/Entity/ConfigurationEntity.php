<?php

namespace AnexusPHP\Business\Configuration\Entity;

use AnexusPHP\Core\MongoEntity;
use AnexusPHP\Core\Tools\Strings;

class ConfigurationEntity extends MongoEntity
{
    const TABLE = 'configuration';
    protected $_id;
    protected $value;
    protected $description;
    public function setId($id)
    {
        $this->_id = Strings::null($id);
        return $this;
    }
    public function getId()
    {
        return Strings::null($this->_id);
    }
    public function setValue($value)
    {
        $this->value = Strings::null($value);
        return $this;
    }
    public function getValue()
    {
        return Strings::null($this->value);
    }
    public function setDescription($description)
    {
        $this->description = Strings::null($description);
        return $this;
    }
    public function getDescription()
    {
        return Strings::null($this->description);
    }
    public function toArray()
    {
        return [
            '_id' => $this->getId(),
            'value' => $this->getValue(),
            'description' => $this->getDescription()
        ];
    }
}
