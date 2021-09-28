<?php

namespace AnexusPHP\Business\Authfast\Repository;

use AnexusPHP\Business\Authfast\Entity\AuthfastActivityEntity;
use AnexusPHP\Business\Authfast\Entity\AuthfastEntity;
use AnexusPHP\Core\Database;
use AnexusPHP\Core\Libraries\Pagination\Pagination;
use PDO;

class AuthfastActivityRepository
{
    /**
     * Retorna um registro do banco pelo id
     * 
     * @param integer|null $id
     * @return AuthfastActivityEntity
     */
    public static function byId($id)
    {
        $db = Database::getInstance();
        $row = $db->query('select * from ' . AuthfastActivityEntity::TABLE . ' where id = :id limit 1', ['id' => (int)$id])->fetchObject(AuthfastActivityEntity::class);
        if ($row === false) {
            return new AuthfastActivityEntity();
        }

        return $row;
    }

    /**
     * Retorna todos os registros do banco
     * 
     * @return AuthfastActivityEntity[]
     */
    public static function all()
    {
        $db = Database::getInstance();
        $rows = $db->query('select * from ' . AuthfastActivityEntity::TABLE . ' order by created_at desc')->fetchAll(PDO::FETCH_CLASS, AuthfastActivityEntity::class);

        return $rows;
    }

    /**
     * Retorna os registro do banco pelo authfast
     * 
     * @param AuthfastEntity $authfast
     * @return AuthfastActivityEntity[]
     */
    public static function allByAuthfast(AuthfastEntity $authfast)
    {
        $db = Database::getInstance();
        $rows = $db->query('select * from ' . AuthfastActivityEntity::TABLE . ' where authfast_id = :authfast_id order by created_at desc', ['authfast_id' => $authfast->getId()])->fetchAll(PDO::FETCH_CLASS, AuthfastActivityEntity::class);

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
     * @return Pagination
     */
    public static function allWithPagination($url, $filters = array(), $currentPg, $varPg = 'pg', $perPg = 12)
    {
        $db = Database::getInstance();

        $bind = array();
        $where = " 1=1 ";

        // if (isset($filters['search']) && trim($filters['search']) != '') {
        //     //$where .= " and upper(concat(a.nome, ' ', a.sobrenome)) like upper('%'||:nome||'%') ";
        //     //$bind['name'] = $filters['search'];
        // }

        $total = $db->query('select count(1) as total from ' . AuthfastActivityEntity::TABLE . ' a where ' . $where, $bind)->fetch();

        $pagination = new Pagination($total['total'], $perPg, $varPg, $currentPg, $url);

        $rows = $db->query('select a.* from ' . AuthfastActivityEntity::TABLE . ' a where ' . $where . ' order by a.id desc limit ' . $perPg . ' OFFSET ' . $pagination->getOffset(), $bind)->fetchAll(PDO::FETCH_CLASS, AuthfastActivityEntity::class);

        $pagination->setRows($rows);

        return $pagination;
    }
}
