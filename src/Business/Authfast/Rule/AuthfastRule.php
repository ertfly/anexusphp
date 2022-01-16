<?php

namespace AnexusPHP\Business\Authfast\Rule;

use AnexusPHP\Business\Authfast\Entity\AuthfastEntity;
use AnexusPHP\Business\Authfast\Repository\AuthfastRepository;
use AnexusPHP\Business\Region\Repository\RegionCountryRepository;
use AnexusPHP\Core\Database;
use AnexusPHP\Core\Tools\Request;
use AnexusPHP\Core\Translate;
use Exception;

class AuthfastRule
{
    public static function insert(AuthfastEntity &$record)
    {
        $db = Database::getInstance();
        if ($record->getId()) {
            throw new Exception('Esse método serve inserir registros e não alterar');
        }
        $record->insert($db);
        Database::closeInstance();
    }
    public static function update(AuthfastEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método serve alterar registros e não inserir');
        }
        $record->setUpdatedAt(strtotime(date('Y-m-d H:i:s')))
            ->update($db);
        Database::closeInstance();
    }
    public static function delete(AuthfastEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método deve conter um ID');
        }
        $record->delete($db);
        Database::closeInstance();
    }
    /**
     * Undocumented function
     *
     * @param string $authfastCode
     * @param string $appKey
     * @param string $secretKey
     * @param string $baseUrl
     * @return AuthfastEntity
     */
    public static function createOrUpdateAuthfast($authfastCode, $appKey, $secretKey, $baseUrl, $classname = AuthfastEntity::class, $forceAuthorization = false)
    {
        $response = self::requestProfile($authfastCode, $appKey, $secretKey, $baseUrl, $forceAuthorization);

        $authfast = AuthfastRepository::byCode($response['data']['authfast_id'], $classname);
        $country = RegionCountryRepository::byCode($response['data']['country']);

        $authfast
            ->setType($response['data']['type'])
            ->setCode($response['data']['authfast_id'])
            ->setFirstname($response['data']['firstname'])
            ->setLastname($response['data']['lastname'])
            ->setUsername($response['data']['username'])
            ->setEmail($response['data']['email'])
            ->setDocument($response['data']['document'])
            ->setPhoto(str_replace('http://', 'https://', $response['data']['photo']))
            ->setBanner(str_replace('http://', 'https://', $response['data']['banner']))
            ->setRegionCountryId($country->getId());
        if (!$authfast->getId()) {
            AuthfastRule::insert($authfast);
        } else {
            AuthfastRule::update($authfast);
        }

        return $authfast;
    }

    public static function requestProfile($authfastCode, $appKey, $secretKey, $baseUrl, $forceAuthorization = false)
    {
        $headers = [
            'appKey: ' . $appKey,
            'secretKey: ' . $secretKey,
        ];
        $response = Request::sendGetJson(trim($baseUrl, '/') . '/api/profile/' . $authfastCode . '?' . ($forceAuthorization ? 'forceAuthorization=1' : ''), $headers, false, false);
        $response = @json_decode($response['response'], true);
        if (!isset($response['response']) || !isset($response['response']['code']) || !isset($response['response']['msg']) || !isset($response['data'])) {
            throw new Exception(Translate::get('authfast', 'error_module_api_response', 'Dados da integração para geração de token inválidos!'));
        }
        if ($response['response']['code'] != 0) {
            throw new Exception(sprintf(Translate::get('authfast', 'error_module_api_return', 'Erro na integração do módulo de cadastro: %s - %s'), $response['response']['code'], $response['response']['msg']));
        }

        if (!isset($response['data']['authfast_id'])) {
            throw new Exception(sprintf(Translate::get('authfast', 'error_module_api_info', 'Erro ao buscar informações do usuário "%s" no módulo de cadastro!'), $authfastCode));
        }

        return $response;
    }

    /**
     * Undocumented function
     *
     * @param string $appKey
     * @param string $secretKey
     * @param string $baseUrl
     * @return array
     */
    public static function requestRule($appKey, $secretKey, $baseUrl)
    {
        $headers = [
            'appKey: ' . $appKey,
            'secretKey: ' . $secretKey,
        ];
        $response = Request::sendGetJson(trim($baseUrl, '/') . '/api/rule', $headers, false, false);
        $response = @json_decode($response['response'], true);
        if (!isset($response['response']) || !isset($response['response']['code']) || !isset($response['response']['msg']) || !isset($response['data'])) {
            throw new Exception(Translate::get('authfast', 'error_module_api_response', 'Dados da integração para geração de token inválidos!'));
        }
        if ($response['response']['code'] != 0) {
            throw new Exception(sprintf(Translate::get('authfast', 'error_module_api_return', 'Erro na integração do módulo de cadastro: %s - %s'), $response['response']['code'], $response['response']['msg']));
        }

        if (!isset($response['data']['rules'])) {
            throw new Exception(Translate::get('authfast', 'error_module_api_rule_list', 'Erro ao buscar lista de regras'));
        }

        return $response;
    }

    /**
     * Undocumented function
     *
     * @param string $authfastCode
     * @param string $appKey
     * @param string $secretKey
     * @param string $baseUrl
     * @return array
     */
    public static function requestWarning($authfastCode, $appKey, $secretKey, $baseUrl, array $rules = [])
    {
        $strRules = '';
        if (count($rules) > 0) {
            $strRules = implode(',', $rules);
        }
        $headers = [
            'appKey: ' . $appKey,
            'secretKey: ' . $secretKey,
            'rules: ' . $strRules,
        ];
        $response = Request::sendGetJson(trim($baseUrl, '/') . '/api/warning/' . $authfastCode, $headers, false, false);
        $response = @json_decode($response['response'], true);
        if (!isset($response['response']) || !isset($response['response']['code']) || !isset($response['response']['msg']) || !isset($response['data'])) {
            throw new Exception(Translate::get('authfast', 'error_module_api_response', 'Dados da integração para geração de token inválidos!'));
        }
        if ($response['response']['code'] != 0) {
            throw new Exception(sprintf(Translate::get('authfast', 'error_module_api_return', 'Erro na integração do módulo de cadastro: %s - %s'), $response['response']['code'], $response['response']['msg']));
        }

        if (!isset($response['data']['pending'])) {
            throw new Exception(sprintf(Translate::get('authfast', 'error_module_api_pending', 'Erro ao buscar os avisos do módulo de cadastro para o usuário "%s"!'), $authfastCode));
        }

        return $response;
    }
}
