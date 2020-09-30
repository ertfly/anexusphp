<?php

namespace AnexusPHP\Core\Libraries\FormValidation\Validations;

class RequiredValidation extends AbstractValidation
{
    private $message = 'O campo %s é obrigatório';

    public function validate()
    {
        if (trim($this->value) == '') {
            throw new \Exception(sprintf($this->message, $this->description));
        }
        return;
    }
}
