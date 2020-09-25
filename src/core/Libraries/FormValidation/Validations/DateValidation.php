<?php

namespace AnexusPHP\Core\Libraries\FormValidation\Validations;

use AnexusPHP\Core\Tools\Date;

class DateValidation extends AbstractValidation
{
    private $message = 'A data do campo %s é inválida';

    public function validate()
    {
        if (!isset($this->options['format'])) {
            throw new \Exception('Favor especificar o formato da validação da data');
        }
        $time = Date::formatToTime($this->options['format'], $this->value);
        if (trim($this->value) != '' && date($this->options['format'], $time) != $this->value) {
            throw new \Exception(sprintf($this->message, $this->description));
        }
        return;
    }
}
