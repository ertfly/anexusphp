<?php

namespace AnexusPHP\Business\Authfast\Repository;

use AnexusPHP\Business\Authfast\Entity\AuthfastEntity;
use AnexusPHP\Business\Authfast\Entity\AuthfastPermissionEntity;

use AnexusPHP\Core\Database;
use AnexusPHP\Core\Libraries\Pagination\Pagination;
use PDO;

class AuthfastPermissionRepository
{
    /**
     * Retorna um registro do banco pelo id
     * 
     * @param integer|null $id
     * @return AuthfastPermissionEntity
     */
    public static function byId(?int $id)
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . AuthfastPermissionEntity::TABLE . ' where id = :id limit 1', ['id' => (int)$id])->fetchObject(AuthfastPermissionEntity::class);
        if ($reg === false) {
            return new AuthfastPermissionEntity();
        }

        return $reg;
    }

    /**
     * Retorna todos os registros do banco
     * 
     * @return AuthfastPermissionEntity[]
     */
    public static function all()
    {
        $db = Database::getInstance();
        $regs = $db->query('select * from ' . AuthfastPermissionEntity::TABLE . ' where trash is false')->fetchAll(PDO::FETCH_CLASS, AuthfastPermissionEntity::class);

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

        $total = $db->query('select count(1) as total from ' . AuthfastPermissionEntity::TABLE . ' a where ' . $where, $bind)->fetch();

        $pagination = new Pagination($total['total'], $perPg, $varPg, $currentPg, $url);

        $regs = $db->query('select a.* from ' . AuthfastPermissionEntity::TABLE . ' a where ' . $where . ' order by a.id desc limit ' . $perPg . ' OFFSET ' . $pagination->getOffset(), $bind)->fetchAll(PDO::FETCH_CLASS, AuthfastPermissionEntity::class);

        $pagination->setRows($regs);

        return $pagination;
    }

    /**
     * Retorna um registro do banco pelo id do Authfast
     * 
     * @param integer|null $authfastId
     * @return AuthfastPermissionEntity[]
     */
    public static function byAuthfast(AuthfastEntity $authfast)
    {
        $db = Database::getInstance();
        $regs = $db->query('select * from ' . AuthfastPermissionEntity::TABLE . ' where authfast_id = :authfastId', ['authfastId' => (int)$authfast->getId()])->fetchAll(PDO::FETCH_CLASS, AuthfastPermissionEntity::class);
        if (empty($regs)) {
            return [new AuthfastPermissionEntity()];
        }

        return $regs;
    }

    /**
     * @param AuthfastEntity $authfast
     * @param int $moduleId
     * @return AuthfastPermissionEntity
     */
    public static function byAuthfastAndModule(AuthfastEntity $authfast, $moduleId)
    {
        $db = Database::getInstance();

        $reg = $db->query(
            'select * from 
        ' . AuthfastPermissionEntity::TABLE . ' 
        where authfast_id = :authfast_id and module_id = :module_id',
            ['authfast_id' => $authfast->getId(), 'module_id' => $moduleId]
        )->fetchObject(AuthfastPermissionEntity::class);

        if ($reg === false) {
            return new AuthfastPermissionEntity;
        }

        return $reg;
    }
}
