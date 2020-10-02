<?php

namespace AnexusPHP\Core\Libraries\FormValidation\Validations;

class StrLenMinValidation extends AbstractValidation
{
    private $message = 'O campo %s deve conter no mínimo %s caracteres';

    public function validate()
    {
        if (!isset($this->options['size'])) {
            throw new \Exception('Informe o tamanho mínimo dos caracteres');
        }
        $value = trim($this->value);
        if(mb_strlen($value)<$this->options['size']){
            throw new \Exception(sprintf($this->message, $this->description, $this->options['size']));
        }
        return;
    }
}
