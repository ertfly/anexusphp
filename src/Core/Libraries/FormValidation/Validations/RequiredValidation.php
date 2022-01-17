<?php

namespace AnexusPHP\Core\Libraries\FormValidation\Validations;

use AnexusPHP\Core\Translate;

class RequiredValidation extends AbstractValidation
{
    private $message;

    public function validate()
    {
        $this->message = Translate::get('validation', 'RequiredValidation', 'O campo %s é obrigatório');
        if (trim($this->value) == '') {
            throw new \Exception(sprintf($this->message, $this->description));
        }
        return;
    }
}
