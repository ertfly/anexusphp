<?php

namespace AnexusPHP\Business\App\Rule;

use AnexusPHP\Business\App\Entity\AppSessionEntity;
use AnexusPHP\Business\Authfast\Repository\AuthfastRepository;
use AnexusPHP\Business\Authfast\Rule\AuthfastRule;
use AnexusPHP\Business\Region\Repository\RegionCountryRepository;
use AnexusPHP\Core\Database;
use AnexusPHP\Core\Tools\Request;
use Exception;

class AppSessionRule
{
    public static function insert(AppSessionEntity &$record)
    {
        $db = Database::getInstance();
        if ($record->getId()) {
            throw new \Exception('Esse método serve inserir registros e não alterar');
        }

        $record->setCreatedAt(date('Y-m-d H:i:s'));
        $record->setUpdatedAt(date('Y-m-d H:i:s'));
        $record->save($db);
    }
    public static function update(AppSessionEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new \Exception('Esse método serve alterar registros e não inserir');
        }

        $record->setUpdatedAt(date('Y-m-d H:i:s'));
        $record->save($db);
    }
    public static function delete(AppSessionEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new \Exception('Esse método deve conter um ID');
        }
        $record->delete($db);
    }
    public static function createAuthfastToken(AppSessionEntity &$record, $appKey, $secretKey, $baseUrl)
    {
        $headers = [
            'appKey: ' . $appKey,
            'secretKey: ' . $secretKey,
        ];
        $response = Request::sendPostJson(trim($baseUrl, '/') . '/api/account/token', [
            'type' => $record->getType(),
            'access_ip' => $record->getAccessIp(),
            'access_browser' => $record->getAccessBrowser(),
        ], $headers, false, false);
        $response = @json_decode($response['response'], true);
        if (!isset($response['response']) || !isset($response['response']['code']) || !isset($response['response']['msg']) || !isset($response['data'])) {
            throw new Exception('Dados da integração para geração de token inválidos!');
        }
        $record->setAuthfastToken($response['data']['token']);
        self::update($record);
    }
    public static function checkAuthfastToken(AppSessionEntity &$record, $appKey, $secretKey, $baseUrl, $authfastToken, $countryCode)
    {
        $headers = [
            'appKey: ' . $appKey,
            'secretKey: ' . $secretKey,
            'token: ' . $authfastToken,
            'countryCode' => $countryCode,
        ];
        $response = Request::sendGetJson(trim($baseUrl, '/') . '/api/account/login', $headers, false, false);
        $response = @json_decode($response['response'], true);
        if (!isset($response['response']) || !isset($response['response']['code']) || !isset($response['response']['msg']) || !isset($response['data'])) {
            throw new Exception('Dados da integração para geração de token inválidos!');
        }

        $data = $response['data'];
        if ($data['logged']) {
            $authfast = AuthfastRepository::byCode($data['user']['code']);
            $country = RegionCountryRepository::byCode($countryCode);
            $authfast
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
        } else {
            if ($record->getAuthfastId()) {
                $record->setAuthfastId(null);
            }
        }
        self::update($record);
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
        $record->setAuthfastId(null);
        self::update($record);
    }
}
