<?php

namespace AnexusPHP\Core\Libraries\FormValidation\Validations;

class NumericValidation extends AbstractValidation
{
    private $message;

    public function validate()
    {
        $this->message = translate('validation', 'NumericValidation', 'O campo %s deve conter apenas número');
        if (trim($this->value) != '' && !is_numeric($this->value)) {
            throw new \Exception(sprintf($this->message, $this->description));
        }
        return;
    }
}
