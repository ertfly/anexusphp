<?php

namespace PequiPHP\Business\App\Rule;

use PequiPHP\Business\App\Entity\AppSessionEntity;
use PequiPHP\Business\Authfast\Repository\AuthfastRepository;
use PequiPHP\Business\Authfast\Rule\AuthfastRule;
use PequiPHP\Business\Region\Repository\RegionCountryRepository;
use PequiPHP\Core\Database;
use PequiPHP\Core\Tools\Request;
use Exception;

class AppSessionRule
{
    public static function install()
    {
        $db = Database::getInstance();
        $db->{AppSessionEntity::TABLE}->createIndex([
            'token' => 1,
        ], ['name' => AppSessionEntity::TABLE . '_idx_token']);
        $db->{AppSessionEntity::TABLE}->createIndex([
            'app_id' => 1,
        ], ['name' => AppSessionEntity::TABLE . '_idx_app_id']);
        $db->{AppSessionEntity::TABLE}->createIndex([
            'authfast_id' => 1,
        ], ['name' => AppSessionEntity::TABLE . '_idx_authfast_id']);
        $db->{AppSessionEntity::TABLE}->createIndex([
            'authfast_token' => 1,
        ], ['name' => AppSessionEntity::TABLE . '_idx_authfast_token']);
        $db->{AppSessionEntity::TABLE}->createIndex([
            'created_at' => 1,
        ], ['name' => AppSessionEntity::TABLE . '_idx_created_at']);
        Database::closeInstance();
    }
    public static function insert(AppSessionEntity &$record)
    {
        $db = Database::getInstance();
        if ($record->getId()) {
            throw new \Exception('Esse método serve inserir registros e não alterar');
        }
        $record->insert($db);
        Database::closeInstance();
    }
    public static function update(AppSessionEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new \Exception('Esse método serve alterar registros e não inserir');
        }
        $record
            ->setUpdatedAt(strtotime(date('Y-m-d H:i:s')))
            ->update($db);
        Database::closeInstance();
    }
    public static function destroy(AppSessionEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new \Exception('Esse método deve conter um ID');
        }
        $record->destroy($db);
        Database::closeInstance();
    }
    public static function createAuthfastToken(AppSessionEntity &$record, $appKey, $secretKey, $baseUrl, $appId = null)
    {
        $headers = [
            'appKey: ' . $appKey,
            'secretKey: ' . $secretKey,
        ];
        $response = Request::sendPostJson(trim($baseUrl, '/') . '/api/account/token', [
            'app_id' => $appId,
            'type' => $record->getType(),
            'access_ip' => $record->getAccessIp(),
            'access_browser' => $record->getAccessBrowser(),
            'manager' => $record->getManager(),
        ], $headers, false, false);
        $response = @json_decode($response['response'], true);
        if (!isset($response['response']) || !isset($response['response']['code']) || !isset($response['response']['msg']) || !isset($response['data'])) {
            throw new Exception('Dados da integração para geração de token inválidos!');
        }
        if ($response['response']['code'] != 0) {
            throw new Exception('Erro na integração do módulo de cadastro: ' . $response['response']['code'] . ' - ' . $response['response']['msg']);
        }
        $record->setAuthfastToken($response['data']['token']);
        self::update($record);
        Database::closeInstance();
    }
    public static function checkAuthfastToken(AppSessionEntity &$record, $appKey, $secretKey, $baseUrl, $authfastToken, $countryCode, $forceAuthfastCode = null)
    {
        $headers = [
            'appKey: ' . $appKey,
            'secretKey: ' . $secretKey,
            'token: ' . $authfastToken,
            'countryCode: ' . $countryCode,
        ];
        $response = Request::sendGetJson(trim($baseUrl, '/') . '/api/account/login?forceAuthfastCode=' . $forceAuthfastCode, $headers, false, false);
        $response = @json_decode($response['response'], true);
        if (!isset($response['response']) || !isset($response['response']['code']) || !isset($response['response']['msg']) || !isset($response['data'])) {
            throw new Exception('Dados da integração para geração de token inválidos!');
        }

        if ($response['response']['code'] != 0) {
            throw new Exception('Erro na integração do módulo de cadastro: ' . $response['response']['code'] . ' - ' . $response['response']['msg']);
        }

        $data = $response['data'];
        if ($data['logged']) {
            if (!$record->getManager()) {
                $authfast = AuthfastRepository::byCode($data['user']['code']);
                $country = RegionCountryRepository::byCode($countryCode);
                $authfast
                    ->setType($data['user']['type'])
                    ->setCode($data['user']['code'])
                    ->setFirstname($data['user']['firstname'])
                    ->setLastname($data['user']['lastname'])
                    ->setUsername($data['user']['username'])
                    ->setEmail($data['user']['email'])
                    ->setDocument($data['user']['document'])
                    ->setPhoto(str_replace('http://', 'https://', $data['user']['photo']))
                    ->setBanner(str_replace('http://', 'https://', $data['user']['banner']))
                    ->setRegionCountryId($country->getId());
                if (!$authfast->getId()) {
                    AuthfastRule::insert($authfast);
                } else {
                    AuthfastRule::update($authfast);
                }
                $record->setAuthfastId($authfast->getId());
            }
        } else {
            $record->setAuthfastId(null);
            $record->setManager(false);
        }
        self::update($record);
        Database::closeInstance();
    }

    public static function logoutAuthfast(AppSessionEntity &$record, $appKey, $secretKey, $baseUrl, $authfastToken, $countryCode)
    {
        $headers = [
            'appKey: ' . $appKey,
            'secretKey: ' . $secretKey,
            'token: ' . $authfastToken,
            'countryCode' => $countryCode,
        ];
        $response = Request::sendPostJson(trim($baseUrl, '/') . '/api/account/logout', [], $headers, false, false);
        $response = @json_decode($response['response'], true);
        if (!isset($response['response']) || !isset($response['response']['code']) || !isset($response['response']['msg']) || !isset($response['data'])) {
            throw new Exception('Dados da integração para geração de token inválidos!');
        }

        if ($response['response']['code'] != 0) {
            throw new Exception('Erro na integração do módulo de cadastro: ' . $response['response']['code'] . ' - ' . $response['response']['msg']);
        }

        $record->setAuthfastId(null);
        self::update($record);
        Database::closeInstance();
    }
}
