<?php

namespace AnexusPHP\Core\Libraries\FormValidation\Validations;
namespace AnexusPHP\Core\Libraries\FormValidation\Validations;
class NumericValidation extends AbstractValidation
{
    private $message = 'O campo %s deve conter apenas número';

    public function validate()
    {
        if (trim($this->value) != '' && !is_numeric($this->value)) {
            throw new \Exception(sprintf($this->message, $this->description));
        }
        return;
    }
}
