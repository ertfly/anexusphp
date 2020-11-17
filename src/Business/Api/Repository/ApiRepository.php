<?php

namespace AnexusPHP\Business\Api\Repository;

use AnexusPHP\Business\Api\Entity\ApiEntity;
use AnexusPHP\Core\Database;
use AnexusPHP\Core\Libraries\Pagination\Pagination;
use PDO;

class ApiRepository
{
    /**
     * Retorna um registro do banco pelo id
     *
     * @param string|null $id
     * @return ApiEntity
     */
    public static function byId(?string $id, $className = ApiEntity::class)
    {
        $db = Database::getInstance();
        $row = $db->query('select * from ' . ApiEntity::TABLE . ' where id = :id and trash = false limit 1', ['id' => $id])->fetchObject($className);
        if ($row === false) {
            return new $className();
        }

        return $row;
    }

    /**
     * Undocumented function
     *
     * @return ApiEntity[]
     */
    public static function all($className = ApiEntity::class)
    {
        $db = Database::getInstance();
        $rows = $db->query('select * from ' . ApiEntity::TABLE.' where trash = false')->fetchAll(PDO::FETCH_CLASS, $className);

        return $rows;
    }


    /**
     * Undocumented function
     *
     * @param string $url
     * @param array $filters
     * @param int $page
     * @param string $varPage
     * @param int $perPage
     * @param string $className
     * @return Pagination
     */
    public static function allWithPagination($url, $filters = array(), $page, $varPage = 'pg', $perPage = 12, $className = ApiEntity::class)
    {
        $db = Database::getInstance();

        $bind = array();
        $where = ' trash = false ';

        if (isset($filters['authfast_id']) && trim($filters['authfast_id']) != '') {
            $where .= " and authfast_id = :authfast_id ";
            $bind['authfast_id'] = $filters['authfast_id'];
        }

        if (isset($filters['search']) && trim($filters['search']) != '') {
            $where .= " and upper(a.name) like upper('%'||:name||'%') ";
            $bind['name'] = $filters['search'];
        }

        $total = $db->query('select count(1) as total from ' . ApiEntity::TABLE . ' a where ' . $where, $bind)->fetch();

        $pagination = new Pagination($total['total'], $perPage, $varPage, $page, $url);

        $rows = $db->query('select a.* from ' . ApiEntity::TABLE . ' a where ' . $where . ' order by a.id desc limit ' . $perPage . ' OFFSET ' . $pagination->getOffset(), $bind)->fetchAll(PDO::FETCH_CLASS, $className);

        if (!$rows) {
            return $pagination;
        }

        $pagination->setRows($rows);

        return $pagination;
    }
}
