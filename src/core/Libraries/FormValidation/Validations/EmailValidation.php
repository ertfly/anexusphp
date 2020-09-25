<?php

namespace AnexusPHP\Core\Libraries\FormValidation\Validations;

class EmailValidation extends AbstractValidation
{
    private $message = 'O %s esta inválido';

    public function validate()
    {
        if (trim($this->value) != '' && !filter_var(trim($this->value), FILTER_VALIDATE_EMAIL)) {
            throw new \Exception(sprintf($this->message, $this->description));
        }
        return;
    }
}
