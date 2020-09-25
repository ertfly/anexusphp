<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core\Libraries\FormValidation\Validations;

use Exception;

/**
 * Description of Required
 *
 * @author Eric Teixeira
 */
class RequiredValidation extends AbstractValidation
{

    private $message = 'O campo %s é obrigatório';

    public function validate()
    {
        if (trim($this->value) == '') {
            throw new Exception(sprintf($this->message, $this->description));
        }
        return;
    }
}
