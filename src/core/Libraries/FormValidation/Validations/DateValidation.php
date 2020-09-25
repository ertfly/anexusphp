<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core\Libraries\FormValidation\Validations;

use Core\Date;
use Exception;

/**
 * Description of DateValidation
 *
 * @author Eric Teixeira
 */
class DateValidation extends AbstractValidation
{

    private $message = 'A data do campo %s é inválida';

    public function validate()
    {
        if (!isset($this->options['format'])) {
            throw new Exception('Favor especificar o formato da validação da data');
        }
        $time = Date::formatToTime($this->options['format'], $this->value);
        if (trim($this->value) != '' && date($this->options['format'], $time) != $this->value) {
            throw new Exception(sprintf($this->message, $this->description));
        }
        return;
    }
}
