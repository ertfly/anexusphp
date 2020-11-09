<?php

namespace AnexusPHP\Business\Permission\Repository;

use AnexusPHP\Business\Permission\Entity\PermissionMenuEntity;

use AnexusPHP\Core\Database;
use AnexusPHP\Core\Libraries\Pagination\Pagination;
use PDO;

class PermissionMenuRepository
{
    /**
     * Retorna um registro do banco pelo id
     * 
     * @param integer|null $id
     * @return PermissionMenuEntity
     */
    public static function byId(?int $id)
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . PermissionMenuEntity::TABLE . ' where id = :id limit 1', ['id' => (int)$id])->fetchObject(PermissionMenuEntity::class);
        if ($reg === false) {
            return new PermissionMenuEntity();
        }

        return $reg;
    }

    /**
     * @param integer|null $id
     * @return PermissionMenuEntity[]
     */
    public static function byCategoryId(?int $id)
    {
        $db = Database::getInstance();
        $regs = $db->query('select * from ' . PermissionMenuEntity::TABLE . ' where category_id = :category_id and trash = false limit 1', ['category_id' => (int)$id])->fetchAll(PDO::FETCH_CLASS, PermissionMenuEntity::class);

        return $regs;
    }

    /**
     * Retorna todos os registros do banco
     * 
     * @return PermissionMenuEntity[]
     */
    public static function all()
    {
        $db = Database::getInstance();
        $regs = $db->query('select * from ' . PermissionMenuEntity::TABLE . ' where trash is false')->fetchAll(PDO::FETCH_CLASS, PermissionMenuEntity::class);

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

        // if (isset($filters['search']) && trim($filters['search']) != '') {
        //     //$where .= " and upper(concat(a.nome, ' ', a.sobrenome)) like upper('%'||:nome||'%') ";
        //     //$bind['name'] = $filters['search'];
        // }

        $total = $db->query('select count(1) as total from ' . PermissionMenuEntity::TABLE . ' a where ' . $where, $bind)->fetch();

        $pagination = new Pagination($total['total'], $perPg, $varPg, $currentPg, $url);

        $regs = $db->query('select a.* from ' . PermissionMenuEntity::TABLE . ' a where ' . $where . ' order by a.id desc limit ' . $perPg . ' OFFSET ' . $pagination->getOffset(), $bind)->fetchAll(PDO::FETCH_CLASS, PermissionMenuEntity::class);

        $pagination->setRows($regs);

        return $pagination;
    }
}
