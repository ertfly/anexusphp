<?php

namespace AnexusPHP\Business\Api\Repository;

use AnexusPHP\Business\Api\Entity\ApiEntity;
use AnexusPHP\Business\Api\Entity\ApiKeyEntity;
use AnexusPHP\Core\Database;
use PDO;

class ApiKeyRepository
{
    /**
     * Retorna um registro do banco pelo id
     *
     * @param string|null $id
     * @return ApiKeyEntity
     */
    public static function byId(?string $id, $className = ApiKeyEntity::class)
    {
        $db = Database::getInstance();
        $row = $db->query('select * from ' . ApiKeyEntity::TABLE . ' where id = :id and trash = false limit 1', ['id' => $id])->fetchObject($className);
        if ($row === false) {
            return new ApiKeyEntity();
        }

        return $row;
    }

    /**
     * Retorna um registro do banco pela appKey
     *
     * @param string $appKey
     * @return instanceof ApiKeyEntity
     */
    public static function byAppKey($appKey, $className = ApiKeyEntity::class)
    {
        $db = Database::getInstance();
        $row = $db->query('select * from ' . ApiKeyEntity::TABLE . ' where app_key = :app_key and trash = false limit 1', ['app_key' => $appKey])->fetchObject($className);
        if ($row === false) {
            return new $className();
        }

        return $row;
    }

    /**
     * Retorna um registro do banco pela secret key
     *
     * @param string $secretKey
     * @return ApiKeyEntity
     */
    public static function bySecretKey($secretKey, $className = ApiKeyEntity::class)
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . ApiKeyEntity::TABLE . ' where secret_key = :secret_key and trash = false limit 1', ['secret_key' => $secretKey])->fetchObject($className);
        if ($reg === false) {
            return new ApiKeyEntity();
        }

        return $reg;
    }

    /**
     * Retorna todos os registros do banco
     *
     * @return ApiKeyEntity[]
     */
    public static function all($className = ApiKeyEntity::class)
    {
        $db = Database::getInstance();
        $rows = $db->query('select * from ' . ApiKeyEntity::TABLE . ' where trash = false order by id asc')->fetchAll(PDO::FETCH_CLASS, $className);

        return $rows;
    }


    /**
     * Retorna todos os registros do banco por aplicativo
     *
     * @param ApiEntity $api
     * @return ApiKeyEntity[]
     */
    public static function allByApi(ApiEntity $api, $className = ApiKeyEntity::class)
    {
        $db = Database::getInstance();
        $rows = $db->query('select * from ' . ApiKeyEntity::TABLE . ' where api_id = :api_id and trash = false order by id asc', ['api_id' => (int)$api->getId()])->fetchAll(PDO::FETCH_CLASS, $className);

        return $rows;
    }
}
