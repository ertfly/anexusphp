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
    public static function byId($id, $className = ApiKeyEntity::class)
    {
        $db = Database::getInstance();
        $cursor = $db->{ApiKeyEntity::TABLE}->find(['_id' => intval($id)], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => $className,
            'document' => $className,
        ]);
        foreach ($cursor as $r) {
            return $r;
        }
        $className = '\\' . $className;
        return new $className();
    }

    /**
     * Retorna um registro do banco pela appKey
     *
     * @param string $appKey
     * @return ApiKeyEntity
     */
    public static function byAppKey($appKey, $className = ApiKeyEntity::class)
    {
        $db = Database::getInstance();
        $cursor = $db->{ApiKeyEntity::TABLE}->find(['app_key' => $appKey], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => $className,
            'document' => $className,
        ]);
        foreach ($cursor as $r) {
            return $r;
        }
        $className = '\\' . $className;
        return new $className();
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
        $cursor = $db->{ApiKeyEntity::TABLE}->find(['secret_key' => $secretKey], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => $className,
            'document' => $className,
        ]);
        foreach ($cursor as $r) {
            return $r;
        }
        $className = '\\' . $className;
        return new $className();
    }

    /**
     * Undocumented function
     *
     * @param string $className
     * @param array $filter
     * @param array $sort
     * @return ApiKeyEntity[]
     */
    public static function all($className = ApiKeyEntity::class, array $filter = [], $sort = ['_id' => 1])
    {

        $db = Database::getInstance();

        $where = [
            'trash' => false
        ];

        if (isset($filter['api_id']) && trim($filter['api_id']) != '') {
            $where['api_id'] = intval($filter['api_id']);
        }

        $cursor = $db->{ApiEntity::TABLE}->find(
            $where,
            [
                'sort' => $sort,
            ]
        );
        $cursor->setTypeMap([
            'root' => $className,
            'document' => $className,
        ]);

        $rows = [];
        foreach ($cursor as $r) {
            $rows[] = $r;
        }

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
        return self::all($className, ['api_id' => $api->getId()]);
    }
}
