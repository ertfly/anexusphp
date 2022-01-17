<?php

namespace AnexusPHP\Core\Libraries\FormValidation\Validations;

use AnexusPHP\Core\Translate;

class EmailValidation extends AbstractValidation
{
    private $message;

    public function validate()
    {
        $this->message = Translate::get('validation', 'EmailValidation', 'O %s esta inválido');
        if (trim($this->value) != '' && !filter_var(trim($this->value), FILTER_VALIDATE_EMAIL)) {
            throw new \Exception(sprintf($this->message, $this->description));
        }
        return;
    }
}
