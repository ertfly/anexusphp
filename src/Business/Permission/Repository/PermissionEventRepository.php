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
    public static function byId(?int $id, $cls = PermissionEventEntity::class)
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . $cls::TABLE . ' where id = :id limit 1', ['id' => (int)$id])->fetchObject($cls);
        if ($reg === false) {
            return new $cls();
        }

        return $reg;
    }

    /**
     * Retorna todos os registros do banco
     * 
     * @return PermissionEventEntity[]
     */
    public static function all($cls = PermissionEventEntity::class)
    {
        $db = Database::getInstance();
        $regs = $db->query('select * from ' . $cls::TABLE . ' where trash is false order by description asc')->fetchAll(PDO::FETCH_CLASS, $cls);

        return $regs;
    }

    /**
     * Retorna todos os registros do banco
     * 
     * @return PermissionEventEntity[]
     */
    public static function byLevelEqualOrHigher(int $level,$cls = PermissionEventEntity::class)
    {
        $db = Database::getInstance();
        $regs = $db->query('select * from ' . $cls::TABLE . ' where trash is false and level >= :level order by description asc', ['level' => $level])->fetchAll(PDO::FETCH_CLASS, $cls);

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
    public static function allWithPagination($url, $filters = array(), $currentPg, $varPg = 'pg', $perPg = 12, $cls = PermissionEventEntity::class)
    {
        $db = Database::getInstance();

        $bind = array();
        $where = " a.trash = false ";

        if (isset($filters['search']) && trim($filters['search']) != '') {
            $where .= " and upper(a.description) like upper('%'||:description||'%') ";
            $bind['description'] = $filters['search'];
        }

        $total = $db->query('select count(1) as total from ' . $cls::TABLE . ' a where ' . $where, $bind)->fetch();

        $pagination = new Pagination($total['total'], $perPg, $varPg, $currentPg, $url);

        $regs = $db->query('select a.* from ' . $cls::TABLE . ' a where ' . $where . ' order by a.id desc limit ' . $perPg . ' OFFSET ' . $pagination->getOffset(), $bind)->fetchAll(PDO::FETCH_CLASS, $cls);

        $pagination->setRows($regs);

        return $pagination;
    }
}
