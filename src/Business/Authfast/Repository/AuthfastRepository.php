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
    public static function byId($id, $cls = AuthfastEntity::class)
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . $cls::TABLE . ' where id = :id limit 1', ['id' => (int)$id])->fetchObject($cls);
        if ($reg === false) {
            return new $cls();
        }

        return $reg;
    }

    /**
     * Retorna um registro do banco pelo id
     * 
     * @param string|null $code
     * @return AuthfastEntity
     */
    public static function byCode($code, $cls = AuthfastEntity::class)
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . $cls::TABLE . ' where code = :code limit 1', ['code' => $code])->fetchObject($cls);
        if ($reg === false) {
            return new $cls();
        }

        return $reg;
    }

    /**
     * Retorna um registro do banco pelo id
     * 
     * @param string|null $username
     * @return AuthfastEntity
     */
    public static function byUsername($username, $cls = AuthfastEntity::class)
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . $cls::TABLE . ' where username = :username limit 1', ['username' => $username])->fetchObject($cls);
        if ($reg === false) {
            return new $cls();
        }

        return $reg;
    }

    /**
     * Retorna um registro do banco pelo id
     * 
     * @param string|null $email
     * @return AuthfastEntity
     */
    public static function byEmail($email, $cls = AuthfastEntity::class)
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . $cls::TABLE . ' where email = :email limit 1', ['email' => $email])->fetchObject($cls);
        if ($reg === false) {
            return new $cls();
        }

        return $reg;
    }

    /**
     * Retorna um registro do banco pelo id
     * 
     * @param string|null $document
     * @return AuthfastEntity
     */
    public static function byDocument($document, $cls = AuthfastEntity::class)
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . $cls::TABLE . ' where document = :document limit 1', ['document' => $document])->fetchObject($cls);
        if ($reg === false) {
            return new $cls();
        }

        return $reg;
    }

    /**
     * Retorna todos os registros
     * 
     * @return AuthfastEntity[]
     */
    public static function all($cls = AuthfastEntity::class)
    {
        $db = Database::getInstance();
        $regs = $db->query('select * from ' . $cls::TABLE . ' ')->fetchAll(PDO::FETCH_CLASS, $cls);

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
     * @return Pagination
     */
    public static function allWithPagination($url, $filters = array(), $currentPg, $varPg = 'pg', $perPg = 12, $cls = AuthfastEntity::class, $orderBy = 'a.id desc')
    {
        $db = Database::getInstance();

        $bind = array();
        $where = "";

        if (isset($filters['search']) && trim($filters['search']) != '') {
            $where .= " and upper(concat(a.firstname, ' ', a.lastname)) like upper('%'||:name||'%') ";
            $bind['name'] = $filters['search'];
        }

        $total = $db->query('select count(1) as total from ' . $cls::TABLE . ' a ' . $where, $bind)->fetch();

        $pagination = new Pagination($total['total'], $perPg, $varPg, $currentPg, $url);

        $regs = $db->query('select a.* from ' . $cls::TABLE . ' a ' . $where . ' order by ' . $orderBy . ' limit ' . $perPg . ' OFFSET ' . $pagination->getOffset(), $bind)->fetchAll(PDO::FETCH_CLASS, $cls);

        $pagination->setRows($regs);

        return $pagination;
    }
}
