<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core\Libraries\FormValidation\Validations;

use Core\Number;
use Exception;

/**
 * Description of Required
 *
 * @author Eric Teixeira
 */
class DecimalValidation extends AbstractValidation
{

    private $message = 'O campo %s deve ser informado um valor decimal válido';

    public function validate()
    {
        if (!isset($this->options['dec'])) {
            throw new Exception('Informe as casas decimais');
        }
        $decimal = Number::toDecimal($this->value, $this->options['dec']);
        if (trim($this->value) != '' && !is_numeric($decimal)) {
            throw new Exception(sprintf($this->message, $this->description));
        }
        return;
    }
}
