<?php

use AnexusPHP\Business\App\Constant\AppTypeConstant;
use AnexusPHP\Business\App\Entity\AppEntity;
use AnexusPHP\Business\App\Repository\AppSessionRepository;
use AnexusPHP\Business\App\Rule\AppSessionRule;
use AnexusPHP\Business\Authfast\Repository\AuthfastPermissionRepository;
use AnexusPHP\Business\Language\Repository\LanguageRepository;
use AnexusPHP\Business\Region\Entity\RegionCountryEntity;
use AnexusPHP\Business\Region\Repository\RegionCountryRepository;
use AnexusPHP\Core\Session;
use AnexusPHP\Core\Tools\Date;
use AnexusPHP\Core\Tools\Form;
use AnexusPHP\Core\Tools\Request as ToolsRequest;
use AnexusPHP\Core\Tools\Strings;
use Pecee\SimpleRouter\SimpleRouter as Router;
use Pecee\Http\Url;
use Pecee\Http\Response;
use Pecee\Http\Request;

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
    $protocol = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? "https://" : "http://";
    $domainName = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : $_SERVER['HTTP_HOST'];
    return rtrim($protocol . $domainName . url($name, $parameters, $getParams), '/');
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
        switch ($method) {
            case 'get':
                $value = ToolsRequest::get($index);
                break;
            case 'post':
                $value = ToolsRequest::post($index);
                break;
            case 'json':
                $value = ToolsRequest::json($index);
                break;
            default:
                $value = ToolsRequest::get($index);
                break;
        }
        if (!$value) {
            return $defaultValue;
        }
    }
    return $value;
}

/**
 * @param [type] $name
 * @param boolean $isGet
 * @return string|int|array
 */
function input_form($name, $defaultValue = null, $isGet = false)
{
    return Form::input($name, $defaultValue, $isGet);
}

function input_selected($name, $value, $defaultValue = null, $checkGet = false)
{
    return Form::selected($name, $value, $defaultValue, $checkGet);
}

function input_checked($name, $value, $defaultValue = null, $checkGet = false)
{
    return Form::checked($name, $value, $defaultValue, $checkGet);
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
        switch ($method) {
            case 'json':
                $value = ToolsRequest::json($index, $description, $validations, $options);
                break;
            case 'get':
                $value = ToolsRequest::get($index, $description, $validations, $options);
                break;
            case 'post':
                $value = ToolsRequest::post($index, $description, $validations, $options);
                break;
        }
    }
    return $value;
}

function input_json($index, $defaultValue = null)
{
    $value = $defaultValue;
    if ($index !== null) {
        $value = ToolsRequest::json($index);
    }
    if (!$value) {
        $value = $defaultValue;
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

/**
 * Undocumented function
 *
 * @param array $data
 * @param integer $code
 * @param string $msg
 * @return array
 */
function responseApi(array $data, $code = 0, $msg = 'Success')
{
    return response()->json([
        'response' => [
            'code' => $code,
            'msg' => $msg,
        ],
        'data' => $data,
    ]);
}

/**
 * Undocumented function
 *
 * @param \Exception $e
 * @return array
 */
function responseApiError(\Exception $e)
{
    $code = -1;
    if ($e->getCode() > 0) {
        $code = $e->getCode();
    }
    return response()->json([
        'response' => [
            'code' => $code,
            'msg' => $e->getMessage(),
        ],
        'data' => [],
    ]);
}

//Retona a url do asset em questão
function asset(string $path, $time = true)
{
    $fileUrl = url_absolute('assets/' . $path);
    $fileUrl = rtrim($fileUrl, '/');
    $fileDir = PATH_PUBLIC . 'assets' . DS . $path;

    if ($time && file_exists($fileDir)) {
        $fileUrl .= '?v=' . filemtime($fileDir);
    }

    return $fileUrl;
}

function upload(string $path, $time = false)
{
    $fileUrl = url_absolute('uploads/' . $path);
    $fileUrl = rtrim($fileUrl, '/');
    $fileDir = PATH_PUBLIC . 'uploads' . DS . $path;

    if ($time && file_exists($fileDir)) {
        $fileUrl .= '?v=' . filemtime($fileDir);
    }

    return $fileUrl;
}

function sid(AppEntity $app, $className)
{
    if (!$app->getId()) {
        throw new \Exception('App inválido');
    }

    $token = Session::item('token');

    $sid = AppSessionRepository::byToken($token, $className);
    if (!$sid->getId()) {
        $token = Strings::token();
        $sid->setToken($token)
            ->setAppId($app->getId())
            ->setType(AppTypeConstant::BROWSER)
            ->setAccessIp((isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null))
            ->setAccessBrowser((isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null));
        AppSessionRule::insert($sid);
        Session::data('token', $token);
    } else {
        AppSessionRule::update($sid);
    }

    return $sid;
}

function timeConverter(string $time, RegionCountryEntity $country)
{
    return Date::timeConverter($time, $country);
}

function is_logged()
{
    if (Session::item('manager')) {
        return true;
    }

    $person = request()->sid->getAuthfast();
    if ($person->getId()) {
        if ($person->getExpiredAt() == null) {
            return true;
        }
    }

    return false;
}

function isLoggedApi()
{
    $person = request()->sid->getAuthfast();
    if ($person->getId()) {
        if ($person->getExpiredAt() == null) {
            return true;
        }
    }

    return false;
}

/**
 * @param integer $module
 * @param integer $event
 * @return boolean
 */
function verifyPermission(int $module, int $event): bool
{
    $module = AuthfastPermissionRepository::byAuthfastAndModule(request()->sid->getAuthfast(), $module);

    return in_array($event, explode(',', (string)$module->getEvents()));
}

function GUID()
{
    if (function_exists('com_create_guid') === true) {
        return trim(com_create_guid(), '{}');
    }

    return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}

function dd($value)
{
    var_dump($value);
    die();
}

/**
 * Undocumented function
 *
 * @param string $id
 * @param int $countryId
 * @param string $countryClass
 * @return string
 */
function lang($id)
{
    
}
