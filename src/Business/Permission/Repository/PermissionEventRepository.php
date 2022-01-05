<?php

namespace AnexusPHP\Business\Permission\Repository;

use AnexusPHP\Business\Permission\Entity\PermissionEventEntity;

use AnexusPHP\Core\Database;
use AnexusPHP\Core\Libraries\Pagination\Pagination;
use PDO;

class PermissionEventRepository
{
    /**
     * Retorna um registro do banco pelo id
     * 
     * @param integer|null $id
     * @return PermissionEventEntity
     */
    public static function byId($id, $cls = PermissionEventEntity::class)
    {
        $db = Database::getInstance();
        $cursor = $db->{PermissionEventEntity::TABLE}->find(['_id' => intval($id)], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => $cls,
            'document' => $cls,
        ]);
        foreach ($cursor as $r) {
            return $r;
        }
        $cls = '\\' . $cls;
        return new $cls();
    }

    /**
     * Retorna todos os registros do banco
     * 
     * @return PermissionEventEntity[]
     */
    public static function all($cls = PermissionEventEntity::class)
    {
        $db = Database::getInstance();

        $where = [
            'trash' => false,
        ];

        $options = [
            'sort' => [
                'description' => 1
            ],
        ];

        $cursor = $db->{PermissionEventEntity::TABLE}->find(
            $where,
            $options,
        );
        $cursor->setTypeMap([
            'root' => $cls,
            'document' => $cls,
        ]);

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
    public static function allWithPagination($url, $filters = array(), $currentPg, $varPg = 'pg', $perPg = 12, $cls = PermissionEventEntity::class)
    {
        $db = Database::getInstance();

        $where = [
            'trash' => false,
        ];

        /* if (isset($filters['search']) && trim($filters['search']) != '') {
            $where .= " and upper(a.description) like upper('%'||:description||'%') ";
            $bind['description'] = $filters['search'];
        } */

        $total = $db->{PermissionEventEntity::TABLE}->count($filters);

        $pagination = new Pagination($total, $perPg, $varPg, $currentPg, $url);

        $cursor = $db->{PermissionEventEntity::TABLE}->find(
            $where,
            [
                'limit' => intval($perPg),
                'sort' => [
                    '_id' => -1
                ],
                'skip' => $pagination->getOffset(),
            ]
        );
        $cursor->setTypeMap([
            'root' => $cls,
            'document' => $cls,
        ]);

        $rows = [];
        foreach ($cursor as $r) {
            $rows[] = $r;
        }

        $pagination->setRows($rows);

        return $pagination;
    }
}
