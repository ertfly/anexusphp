<?php

namespace AnexusPHP\Business\Language\Entity;

use AnexusPHP\Core\DatabaseEntity;

class LanguageScreenEntity extends DatabaseEntity
{
    const TABLE = 'language_screen';
    protected $id;
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
            'description' => $this->getDescription()
        );
    }
}
