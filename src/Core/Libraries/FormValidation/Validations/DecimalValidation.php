<?php

namespace PequiPHP\Core\Libraries\FormValidation\Validations;

use PequiPHP\Core\Tools\Number;
use PequiPHP\Core\Translate;

class DecimalValidation extends AbstractValidation
{
    private $message;

    public function validate()
    {
        $this->message = Translate::get('validation', 'DecimalValidation', 'O campo %s deve ser informado um valor decimal válido');
        if (!isset($this->options['dec'])) {
            throw new \Exception('Informe as casas decimais');
        }
        $decimal = Number::toDecimal($this->value, $this->options['dec']);
        if (trim($this->value) != '' && !is_numeric($decimal)) {
            throw new \Exception(sprintf($this->message, $this->description));
        }
        return;
    }
}
