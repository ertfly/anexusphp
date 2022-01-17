<?php

namespace PequiPHP\Business\Configuration\Entity;

use PequiPHP\Core\MongoEntity;

class ConfigurationEntity extends MongoEntity
{
    const TABLE = 'configuration';
    protected $_id;
    protected $value;
    protected $description;
    public function setId($id)
    {
        $this->_id = strval($id);
        return $this;
    }
    public function getId()
    {
        return strval($this->_id);
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
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
    public function getDescription()
    {
        return $this->description;
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
