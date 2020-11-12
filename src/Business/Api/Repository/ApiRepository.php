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
    public static function byId(?string $id)
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . ApiEntity::TABLE . ' where id = :id limit 1', ['id' => $id])->fetchObject(ApiEntity::class);
        if ($reg === false) {
            return new ApiEntity();
        }

        return $reg;
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
    public static function allWithPagination($url, $filters = array(), $currentPg, $varPg = 'pg', $perPg = 12)
    {
        $db = Database::getInstance();

        $bind = array();
        $where = "";

        if (isset($filters['search']) && trim($filters['search']) != '') {
            $where .= " and upper(a.name) like upper('%'||:name||'%') ";
            $bind['name'] = $filters['search'];
        }

        if (isset($filters['authfast_id']) && trim($filters['authfast_id']) != '') {
            $where .= " authfast_id = :authfast_id ";
            $bind['authfast_id'] = $filters['authfast_id'];
        }

        $total = $db->query('select count(1) as total from ' . ApiEntity::TABLE . ' a where ' . $where, $bind)->fetch();

        $pagination = new Pagination($total['total'], $perPg, $varPg, $currentPg, $url);

        $regs = $db->query('select a.* from ' . ApiEntity::TABLE . ' a where ' . $where . ' order by a.id desc limit ' . $perPg . ' OFFSET ' . $pagination->getOffset(), $bind)->fetchAll(PDO::FETCH_CLASS, ApiEntity::class);

        $pagination->setRows($regs);

        return $pagination;
    }
}
