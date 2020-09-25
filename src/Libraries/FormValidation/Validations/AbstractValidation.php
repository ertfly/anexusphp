<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core\Libraries\FormValidation\Validations;

/**
 * Description of AbstractValidation
 *
 * @author Eric Teixeira
 */
abstract class AbstractValidation
{

    protected $value;
    protected $description;
    protected $options;

    public function __construct($value, $description, array $options = null)
    {
        $this->value = $value;
        $this->description = $description;
        $this->options = $options;
    }

    abstract public function validate();
}
