<?php

namespace AnexusPHP\Core\Libraries\DinamicField;

class DinamicField
{
    private $html = '';
    private $customHtmlField = '';
    private $key = '';
    private $fields = [];

    /**
     * @param array $fields
     * @param string $key
     */
    public function __construct(array $fields = [], string $key = '')
    {
        $this->key = $key;
        if (trim($this->key) != '') {
            $this->key .= '_';
        }
        $this->fields = $fields;
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        return $this->html;
    }

    /**
     * @param string $customHtmlField
     * @return DinamicField
     */
    public function addCustomHtmlField(string $customHtmlField): DinamicField
    {
        $this->customHtmlField .= $customHtmlField;
        return $this;
    }

    /**
     * @param boolean $returnHtml
     * @return string
     */
    public function render(bool $returnHtml = false)
    {
        $this->html = '<div class="form-row">';

        foreach ($this->fields as $field) {
            $this->html .= '<div class="form-group col-md-' . $field->getColuna() . '">';
            $this->html .= '<label>' . $field->getDescricao() . '</label>';

            $this->renderField($field);

            $this->html .= '</div>';
        }

        $this->html .= $this->customHtmlField;
        $this->html .= '</div>';

        if ($returnHtml) {
            return $this->getHtml();
        }
        echo $this->html;
    }

    /**
     * @param PessoaCampoEntidade $field
     * @return DinamicField
     */
    private function renderField(PessoaCampoEntidade $field): DinamicField
    {
        switch ($field->getTipo()) {
            case PessoaCampoTipoConstante::TEXTO:
                $this->html .= $this->texto($field);
                break;
            case PessoaCampoTipoConstante::NUMERO:
                $this->html .= $this->numero($field);
                break;
            case PessoaCampoTipoConstante::MASCARA:
                $this->html .= $this->mascara($field);
                break;
            case PessoaCampoTipoConstante::SELECAO_UNICA:
                $this->html .= $this->selecao($field);
                break;
            default:
                throw new \Exception("Constante {$field->getTipo()} não implementada.");
        }
        return $this;
    }

    /**
     * @param PessoaCampoEntidade $field
     * @return string
     */
    private function texto(PessoaCampoEntidade $field): string
    {
        $readonly = ($field->getEditar() || is_null($field->getEditar())) ? '' : ' readonly="readonly"';
        $validation = $this->getValidation($field);

        return "<input type='text' class='form-control {$validation->class}' placeholder='{$field->getDescricao()}' {$readonly} name='{$this->key}{$field->getChave()}' id='{$this->key}{$field->getChave()}' value='" . input_form($this->key . $field->getChave(), $field->getValor(true)) . "' />" . $validation->html;
    }

    /**
     * @param PessoaCampoEntidade $field
     * @return string
     */
    private function numero(PessoaCampoEntidade $field): string
    {
        $readonly = ($field->getEditar() || is_null($field->getEditar())) ? '' : ' readonly="readonly"';
        $validation = $this->getValidation($field);

        $html = "<input type='text' class='form-control {$validation->class}' placeholder='{$field->getDescricao()}' {$readonly} name='{$this->key}{$field->getChave()}' id='{$this->key}{$field->getChave()}' value='" . input_form($this->key . $field->getChave(), $field->getValor(true)) . "' />" . $validation->html;

        $html .= '<script>(function() {$.fn.mask( "' . $this->key . $field->getChave() . '",  "num");})();</script>';

        return $html;
    }

    /**
     * @param PessoaCampoEntidade $field
     * @return string
     */
    private function mascara(PessoaCampoEntidade $field): string
    {
        $readonly = ($field->getEditar() || is_null($field->getEditar())) ? '' : ' readonly="readonly"';
        $validation = $this->getValidation($field);

        $html = "<input type='text' class='form-control {$validation->class}' placeholder='{$field->getDescricao()}' {$readonly} name='{$this->key}{$field->getChave()}' id='{$this->key}{$field->getChave()}' value='" . input_form($this->key . $field->getChave(), $field->getValor(true)) . "' />" . $validation->html;

        $html .= '<script>(function() {$.fn.mask( "' . $this->key . $field->getChave() . '",  "' . $field->getMascara() . '");})();</script>';

        return $html;
    }

    /**
     * @param PessoaCampoEntidade $field
     * @return string
     */
    private function selecao(PessoaCampoEntidade $field): string
    {
        $readonly = ($field->getEditar() || is_null($field->getEditar())) ? '' : ' disabled="disabled"';
        $validation = $this->getValidation($field);
        $opt = json_decode($field->getOpcoes(), true);

        $html = " <select id='{$this->key}{$field->getChave()}' name='{$this->key}{$field->getChave()}' class='form-control {$validation->class}'  {$readonly}>";
        $html .= "<option value=''>Selecione</option>";
        foreach ($opt as $row) {
            $html .= '<option value="' . $row['id'] . '"' . input_selected($this->key . $field->getChave(), $row['id'], $field->getValor()) . '>' . $row['descricao'] . '</option>';
        }
        $html .= "</select>" . $validation->html;

        return $html;
    }

    private function getValidation(PessoaCampoEntidade $field)
    {
        $response = (object)['class' => '', 'html' => ''];

        switch ($field->getAutenticado()) {
            case PessoaCampoValorConstante::AUTENTICADO:
                $response->class = 'border-success';
                $response->html = '<i><span class="text-success">Campo autenticado pelo suporte</span></i>';
                break;
            case PessoaCampoValorConstante::REPROVADO:
                $response->class = 'border-danger';
                $response->html = '<i><span class="text-danger">Campo reprovado pelo suporte</span></i>';
                break;
            case PessoaCampoValorConstante::PENDENTE:
                $response->class = 'border-warning';
                $response->html = '<i><span class="text-warning">Campo está em análise</span></i>';
                break;
        }

        return $response;
    }
}

