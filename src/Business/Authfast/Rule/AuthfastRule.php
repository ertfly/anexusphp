<?php

namespace AnexusPHP\Business\Authfast\Rule;

use AnexusPHP\Business\Authfast\Entity\AuthfastEntity;
use AnexusPHP\Business\Authfast\Repository\AuthfastRepository;
use AnexusPHP\Business\Region\Repository\RegionCountryRepository;
use AnexusPHP\Core\Database;
use AnexusPHP\Core\Tools\Request;
use Exception;

class AuthfastRule
{
    public static function insert(AuthfastEntity &$record)
    {
        $db = Database::getInstance();
        if ($record->getId()) {
            throw new Exception('Esse método serve inserir registros e não alterar');
        }
        $record->setCreatedAt(date('Y-m-d H:i:s'))
            ->save($db);
    }
    public static function update(AuthfastEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método serve alterar registros e não inserir');
        }
        $record->setUpdatedAt(date('Y-m-d H:i:s'))
            ->save($db);
    }
    public static function delete(AuthfastEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método deve conter um ID');
        }
        $record->delete($db);
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
    public static function createOrUpdateAuthfast($authfastCode, $appKey, $secretKey, $baseUrl, $classname = AuthfastEntity::class)
    {
        $headers = [
            'appKey: ' . $appKey,
            'secretKey: ' . $secretKey,
        ];
        $response = Request::sendGetJson(trim($baseUrl, '/') . '/api/profile/' . $authfastCode, $headers, false, false);
        $response = @json_decode($response['response'], true);
        if (!isset($response['response']) || !isset($response['response']['code']) || !isset($response['response']['msg']) || !isset($response['data'])) {
            throw new Exception('Dados da integração para geração de token inválidos!');
        }
        if ($response['response']['code'] != 0) {
            throw new Exception('Erro na integração do módulo de cadastro: ' . $response['response']['code'] . ' - ' . $response['response']['msg']);
        }

        if (!isset($data['data']['authfast_id'])) {
            throw new Exception('Erro ao buscar informações do usuário "' . $authfastCode . '" no módulo de cadastro!');
        }

        $authfast = AuthfastRepository::byCode($data['data']['authfast_id'], $classname);
        $country = RegionCountryRepository::byCode($data['data']['country']);

        $authfast
            ->setType($data['data']['type'])
            ->setCode($data['data']['authfast_id'])
            ->setFirstname($data['data']['firstname'])
            ->setLastname($data['data']['lastname'])
            ->setUsername($data['data']['username'])
            ->setEmail($data['data']['email'])
            ->setDocument($data['data']['document'])
            ->setPhoto(str_replace('http://', 'https://', $data['data']['photo']))
            ->setBanner(str_replace('http://', 'https://', $data['data']['banner']))
            ->setRegionCountryId($country->getId());
        if (!$authfast->getId()) {
            AuthfastRule::insert($authfast);
        } else {
            AuthfastRule::update($authfast);
        }

        return $authfast;
    }
}
