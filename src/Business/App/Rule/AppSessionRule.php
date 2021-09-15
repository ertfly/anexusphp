<?php

namespace AnexusPHP\Business\App\Rule;

use AnexusPHP\Business\App\Entity\AppSessionEntity;
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
        $record->setAuthfastToken($response['response']['data']['token']);
        self::update($record);
    }
    public static function checkAuthfastToken($appKey, $secretKey, $baseUrl, $authfastToken, $countryCode)
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

        return $response['data'];
    }
}
