<?php

namespace AnexusPHP\Business\Permission\Repository;

use AnexusPHP\Business\Permission\Entity\PermissionCategoryMenuEntity;

use AnexusPHP\Core\Database;
use AnexusPHP\Core\Libraries\Pagination\Pagination;
use PDO;

class PermissionCategoryMenuRepository
{
    /**
     * Retorna um registro do banco pelo id
     * 
     * @param integer|null $id
     * @return PermissionCategoryMenuEntity
     */
    public static function byId(?int $id)
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . PermissionCategoryMenuEntity::TABLE . ' where id = :id limit 1', ['id' => (int)$id])->fetchObject(PermissionCategoryMenuEntity::class);
        if ($reg === false) {
            return new PermissionCategoryMenuEntity();
        }

        return $reg;
    }

    /**
     * Retorna todos os registros do banco
     * 
     * @return PermissionCategoryMenuEntity[]
     */
    public static function all()
    {
        $db = Database::getInstance();
        $regs = $db->query('select * from ' . PermissionCategoryMenuEntity::TABLE . ' where trash is false')->fetchAll(PDO::FETCH_CLASS, PermissionCategoryMenuEntity::class);

        return $regs;
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
        $where = " a.trash = false ";

        if (isset($filters['search']) && trim($filters['search']) != '') {
            //$where .= " and upper(a.description) like upper('%'||:description||'%') ";
            //$bind['description'] = $filters['search'];
        }

        $total = $db->query('select count(1) as total from ' . PermissionCategoryMenuEntity::TABLE . ' a where ' . $where, $bind)->fetch();

        $pagination = new Pagination($total['total'], $perPg, $varPg, $currentPg, $url);

        $regs = $db->query('select a.* from ' . PermissionCategoryMenuEntity::TABLE . ' a where ' . $where . ' order by a.id desc limit ' . $perPg . ' OFFSET ' . $pagination->getOffset(), $bind)->fetchAll(PDO::FETCH_CLASS, PermissionCategoryMenuEntity::class);

        $pagination->setRows($regs);

        return $pagination;
    }
}
