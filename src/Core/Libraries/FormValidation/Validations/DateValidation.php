<?php

namespace AnexusPHP\Core\Libraries\FormValidation\Validations;

use AnexusPHP\Core\Tools\Date;
use AnexusPHP\Core\Translate;
use Exception;

class DateValidation extends AbstractValidation
{
    private $message;

    public function validate()
    {
        $this->message = Translate::get('validation', 'DateValidation', 'A data do campo %s é inválida');
        if (!isset($this->options['format'])) {
            throw new \Exception('Favor especificar o formato da validação da data');
        }
        $time = Date::formatToTime($this->options['format'], $this->value);
        if (trim($this->value) != '' && date($this->options['format'], $time) != $this->value) {
            throw new \Exception(sprintf($this->message, $this->description));
        }
        if (trim($this->value) != '' && isset($this->options['valid_operation']) && isset($this->options['valid_time']) && isset($this->options['valid_msg'])) {
            if ($this->options['valid_operation'] == '<=') {
                if (!($time <= strtotime($this->options['valid_time']))) {
                    throw new Exception($this->options['valid_msg']);
                }
            }
        }

        if (isset($this->options['format_to'])) {
            return date($this->options['format_to'], $time);
        }
        return;
    }
}
