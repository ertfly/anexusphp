<?php

namespace AnexusPHP\Business\App\Repository;

use AnexusPHP\Business\App\Entity\AppAuthfastEntity;
use AnexusPHP\Business\App\Entity\AppEntity;
use AnexusPHP\Business\Authfast\Entity\AuthfastEntity;
use AnexusPHP\Business\Authfast\Repository\AuthfastRepository;
use AnexusPHP\Core\Database;
use AnexusPHP\Core\Libraries\Pagination\Pagination;

class AppAuthfastRepository
{
    /**
     * Retorna um registro do banco pelo id
     *
     * @param integer|null $id
     * @return AppAuthfastEntity
     */
    public static function byId($id)
    {
        $db = Database::getInstance();
        $cursor = $db->{AppAuthfastEntity::TABLE}->find(['_id' => intval($id)], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => AppAuthfastEntity::class,
            'document' => AppAuthfastEntity::class,
        ]);
        Database::closeInstance();
        foreach ($cursor as $r) {
            return $r;
        }
        return new AppAuthfastEntity();
    }

    /**
     * Retorna um registro do banco pelo authfast id
     * 
     * @param string|null $id
     * @return AppAuthfastEntity
     */
    public static function byAuthfastId($authfastId)
    {
        $db = Database::getInstance();
        $cursor = $db->{AppAuthfastEntity::TABLE}->find(['authfast_id' => intval($authfastId)], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => AppAuthfastEntity::class,
            'document' => AppAuthfastEntity::class,
        ]);
        Database::closeInstance();
        foreach ($cursor as $r) {
            return $r;
        }
        return new AppAuthfastEntity();
    }

    /**
     * Undocumented function
     *
     * @param AppEntity $app
     * @param AuthfastEntity $authfast
     * @return AppAuthfastEntity
     */
    public static function byAppAuthfast(AppEntity $app, AuthfastEntity $authfast)
    {
        $db = Database::getInstance();
        $cursor = $db->{AppAuthfastEntity::TABLE}->find(['app_id' => $app->getId(), 'authfast_id' => $authfast->getId()], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => AppAuthfastEntity::class,
            'document' => AppAuthfastEntity::class,
        ]);
        Database::closeInstance();
        foreach ($cursor as $r) {
            return $r;
        }
        return new AppAuthfastEntity();
    }

    /**
     * Retorna um registro do banco pelo authfast id e app
     * 
     * @param string $id
     * @param int $id
     * @return AppAuthfastEntity
     */
    public static function byAuthfastIdAndAppId($authfastId, $app)
    {
        $db = Database::getInstance();
        $cursor = $db->{AppAuthfastEntity::TABLE}->find(['app_id' => intval($app), 'authfast_id' => intval($authfastId)], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => AppAuthfastEntity::class,
            'document' => AppAuthfastEntity::class,
        ]);
        Database::closeInstance();
        foreach ($cursor as $r) {
            return $r;
        }
        return new AppAuthfastEntity();
    }

    /**
     * Retorna todos os registros do banco
     * 
     * @return AppAuthfastEntity[]
     */
    public static function all()
    {
        $db = Database::getInstance();

        $where = [];

        $options = [
            'sort' => [
                '_id' => 1
            ],
        ];

        $cursor = $db->{AppAuthfastEntity::TABLE}->find(
            $where,
            $options,
        );
        $cursor->setTypeMap([
            'root' => AppAuthfastEntity::class,
            'document' => AppAuthfastEntity::class,
        ]);

        Database::closeInstance();

        $rows = [];
        foreach ($cursor as $r) {
            $rows[] = $r;
        }

        return $rows;
    }

    /**
     * Retorna os registro do banco com paginacao
     * 
     * @param string $url
     * @param array $filters
     * @param int $currentPg
     * @param string $varPg
     * @param integer $perPg
     * @return Pagination[]
     */
    public static function allWithPagination($url, $filters = [], $currentPg, $varPg = 'pg', $perPg = 12)
    {
        $db = Database::getInstance();

        $where = [];
        if (isset($filters['search']) && trim($filters['search']) != '') {
            $authfast = AuthfastRepository::byCode($filters['search']);
            $where['authfast_id'] = $authfast->getId();
        }

        if (isset($filters['app_id']) && trim($filters['app_id']) != '') {
            $where['app_id'] = intval($filters['app_id']);
        }

        $total = $db->{AppAuthfastEntity::TABLE}->count($filters);

        $pagination = new Pagination($total, $perPg, $varPg, $currentPg, $url);

        $cursor = $db->{AppAuthfastEntity::TABLE}->find(
            $where,
            [
                'limit' => intval($perPg),
                'sort' => [
                    '_id' => 1
                ],
                'skip' => $pagination->getOffset(),
            ]
        );
        $cursor->setTypeMap([
            'root' => AppAuthfastEntity::class,
            'document' => AppAuthfastEntity::class,
        ]);

        Database::closeInstance();

        $rows = [];
        foreach ($cursor as $r) {
            $rows[] = $r;
        }

        $pagination->setRows($rows);

        return $pagination;
    }
}
