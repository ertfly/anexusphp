<?php

namespace AnexusPHP\Core\Libraries\FormValidation\Validations;

class RequiredValidation extends AbstractValidation
{
    private $message;

    public function validate()
    {
        $this->message = translate('validation', 'RequiredValidation', 'O campo %s é obrigatório');
        if (trim($this->value) == '') {
            throw new \Exception(sprintf($this->message, $this->description));
        }
        return;
    }
}
