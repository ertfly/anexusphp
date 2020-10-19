<?php

namespace AnexusPHP\Business\Configuration\Entity;

use AnexusPHP\Core\DatabaseEntity;

class ConfigurationEntity extends DatabaseEntity
{
    const TABLE = 'configuration';
    protected $id;
    protected $value;
    protected $description;
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    public function getId()
    {
        return $this->id;
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
        return array(
            'value' => $this->getValue(),
            'description' => $this->getDescription()
        );
    }
}
