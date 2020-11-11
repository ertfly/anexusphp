<?php

namespace AnexusPHP\Business\Authfast\Repository;

use AnexusPHP\Business\Authfast\Entity\AuthfastEntity;
use AnexusPHP\Core\Database;
use AnexusPHP\Core\Libraries\Pagination\Pagination;
use PDO;

class AuthfastRepository
{
    /**
     * Retorna um registro do banco pelo id
     * 
     * @param integer|null $id
     * @return AuthfastEntity
     */
    public static function byId(?int $id)
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . AuthfastEntity::TABLE . ' where id = :id limit 1', ['id' => (int)$id])->fetchObject(AuthfastEntity::class);
        if ($reg === false) {
            return new AuthfastEntity();
        }

        return $reg;
    }

    /**
     * Retorna um registro do banco pelo id
     * 
     * @param string|null $id
     * @return AuthfastEntity
     */
    public static function byCode(?string $code)
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . AuthfastEntity::TABLE . ' where code = :code limit 1', ['code' => $code])->fetchObject(AuthfastEntity::class);
        if ($reg === false) {
            return new AuthfastEntity();
        }

        return $reg;
    }

    /**
     * Retorna todos os registros
     * 
     * @return AuthfastEntity[]
     */
    public static function all()
    {
        $db = Database::getInstance();
        $regs = $db->query('select * from ' . AuthfastEntity::TABLE . ' ')->fetchAll(PDO::FETCH_CLASS, AuthfastEntity::class);

        return $regs;
    }

    /**
     * Retorna todos os registros com filtros e paginação
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
            $where .= " and upper(concat(a.firstname, ' ', a.lastname)) like upper('%'||:name||'%') ";
            $bind['name'] = $filters['search'];
        }

        $total = $db->query('select count(1) as total from ' . AuthfastEntity::TABLE . ' a ' . $where, $bind)->fetch();

        $pagination = new Pagination($total['total'], $perPg, $varPg, $currentPg, $url);

        $regs = $db->query('select a.* from ' . AuthfastEntity::TABLE . ' a ' . $where . ' order by a.id desc limit ' . $perPg . ' OFFSET ' . $pagination->getOffset(), $bind)->fetchAll(PDO::FETCH_CLASS, AuthfastEntity::class);

        $pagination->setRows($regs);

        return $pagination;
    }
}
