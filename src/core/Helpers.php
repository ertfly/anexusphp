<?php

use AnexusPHP\Core\Libraries\FormValidation\FormValidation;
use AnexusPHP\Core\Session;
use AnexusPHP\Core\Tools\Form;
use AnexusPHP\Core\Tools\Strings;
use AnexusPHP\RegraDeNegocio\App\Constante\AppTipoConstante;
use AnexusPHP\RegraDeNegocio\App\Entidade\AppEntidade;
use AnexusPHP\RegraDeNegocio\App\RegraDeNegocio\AppSessaoRegraDeNegocio;
use AnexusPHP\RegraDeNegocio\App\Repositorio\AppSessaoRepositorio;
use Pecee\SimpleRouter\SimpleRouter as Router;
use Pecee\Http\Url;
use Pecee\Http\Response;
use Pecee\Http\Request;

$_JSON = file_get_contents('php://input');
$_JSON = @json_decode($_JSON, true);

/**
 * @param string|null $name
 * @param string|array|null $parameters
 * @param array|null $getParams
 * @return \Pecee\Http\Url
 * @throws \InvalidArgument\Exception
 */
function url(?string $name = null, $parameters = null, ?array $getParams = null): Url
{
    return Router::getUrl($name, $parameters, $getParams);
}

function url_absolute(?string $name = null, $parameters = null, ?array $getParams = null)
{
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
    $urlAbsolute = url($name, $parameters, $getParams)->getAbsoluteUrl();
    return $protocol . $urlAbsolute;
}

/**
 * @return \Pecee\Http\Response
 */
function response(): Response
{
    return Router::response();
}

/**
 * @return \Pecee\Http\Request
 */
function request(): Request
{
    return Router::request();
}

/**
 * @param string|null $index Parameter index name
 * @param string|null $defaultValue Default return value
 * @param array ...$methods Default methods
 * @return \Pecee\Http\Input\InputHandler|array|string|null
 */
function input($index = null, $defaultValue = null, $method)
{
    $value = null;
    if ($index !== null) {
        $value = request()->getInputHandler()->value($index, $defaultValue, $method);
    }
    return $value;
}

/**
 * @param [type] $name
 * @param boolean $isGet
 * @return string
 */
function  input_form($name, $defaultValue = null, $isGet = false)
{
    return Form::input($name, $defaultValue, $isGet);
}

function input_selected($name, $value, $defaultValue = null, $checkGet = false)
{
    return Form::selected($name, $value, $defaultValue, $checkGet);
}

/**
 * @param string $method
 * @param string $index
 * @param string $description
 * @param array $validations
 * @param array $options
 * @return \Pecee\Http\Input\InputHandler|array|string|null
 */
function input_validation($method, $index, $description = null, $validations = [], $options = [])
{
    $value = null;
    if ($index !== null) {
        if ($method == 'json') {
            $value = input_json($index);
        } else {
            $value = trim(request()->getInputHandler()->value($index, null, $method));
        }
    }
    if (isset($description) && isset($validations) && is_string($description) && is_array($validations) && count($validations) > 0) {
        new FormValidation($value, $description, $validations, $options);
    }
    return $value;
}

function input_json($index, $defaultValue = null)
{
    $value = $defaultValue;
    if ($index !== null) {
        if (isset($_JSON[$index]) && trim($_JSON[$index]) != '') {
            $value = trim($_JSON[$index]);
        }
    }
    return $value;
}

/**
 * @param string $url
 * @param int|null $code
 */
function redirect(string $url, ?int $code = null): void
{
    if ($code !== null) {
        response()->httpCode($code);
    }

    response()->redirect($url);
}

//Retona a url do asset em questão
function asset(string $path, $time = true)
{
    $fileUrl = url('assets/' . $path);
    $fileUrl = rtrim($fileUrl, '/');
    $fileDir = PATH_PUBLIC . 'assets' . DS . $path;

    if ($time && file_exists($fileDir)) {
        $fileUrl .= '?v=' . filemtime($fileDir);
    }

    return $fileUrl;
}

function upload(string $path, $time = false)
{
    $fileUrl = url('uploads/' . $path);
    $fileUrl = rtrim($fileUrl, '/');
    $fileDir = PATH_PUBLIC . 'uploads' . DS . $path;

    if ($time && file_exists($fileDir)) {
        $fileUrl .= '?v=' . filemtime($fileDir);
    }

    return $fileUrl;
}

function  sid(AppEntidade $app, $className)
{
    if (!$app->getId()) {
        throw new \Exception('App inválido');
    }

    $token = Session::item('token');

    $sid = AppSessaoRepositorio::porToken($token,$className);
    if (!$sid->getId()) {
        $token = Strings::token();
        $sid->setToken($token)
            ->setAppId($app->getId())
            ->setTipo(AppTipoConstante::NAVEGADOR)
            ->setAcessoIp((isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null))
            ->setAcessoNavegador((isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null));
        AppSessaoRegraDeNegocio::inserir($sid);
        Session::data('token', $token);
    } else {
        AppSessaoRegraDeNegocio::alterar($sid);
    }

    return $sid;
}
