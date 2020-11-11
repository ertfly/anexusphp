<?php

namespace AnexusPHP\Business\Permission\Repository;

use AnexusPHP\Business\Authfast\Entity\AuthfastEntity;
use AnexusPHP\Business\Authfast\Entity\AuthfastPermissionEntity;
use AnexusPHP\Business\Permission\Entity\PermissionModuleEntity;

use AnexusPHP\Core\Database;
use AnexusPHP\Core\Libraries\Pagination\Pagination;
use PDO;

class PermissionModuleRepository
{
    /**
     * Retorna um registro do banco pelo id
     * 
     * @param integer|null $id
     * @return PermissionModuleEntity
     */
    public static function byId(?int $id)
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . PermissionModuleEntity::TABLE . ' where id = :id limit 1', ['id' => (int)$id])->fetchObject(PermissionModuleEntity::class);
        if ($reg === false) {
            return new PermissionModuleEntity();
        }

        return $reg;
    }

    /**
     * Retorna todos os registros do banco
     * 
     * @return PermissionModuleEntity[]
     */
    public static function all()
    {
        $db = Database::getInstance();
        $regs = $db->query('select * from ' . PermissionModuleEntity::TABLE . ' where trash is false')->fetchAll(PDO::FETCH_CLASS, PermissionModuleEntity::class);

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
            $where .= " and upper(a.name) like upper('%'||:name||'%') ";
            $bind['name'] = $filters['search'];
        }

        $total = $db->query('select count(1) as total from ' . PermissionModuleEntity::TABLE . ' a where ' . $where, $bind)->fetch();

        $pagination = new Pagination($total['total'], $perPg, $varPg, $currentPg, $url);

        $regs = $db->query('select a.* from ' . PermissionModuleEntity::TABLE . ' a where ' . $where . ' order by a.position asc limit ' . $perPg . ' OFFSET ' . $pagination->getOffset(), $bind)->fetchAll(PDO::FETCH_CLASS, PermissionModuleEntity::class);

        $pagination->setRows($regs);

        return $pagination;
    }

    /**
     * @param AuthfastEntity $authfast
     * @return string
     */
    public static function byAuthfast(AuthfastEntity $authfast)
    {
        $db = Database::getInstance();

        $regs = $db->query(
            'select module_id from 
        ' . AuthfastPermissionEntity::TABLE . ' 
        where authfast_id = :authfast_id',
            ['authfast_id' => $authfast->getId()]
        )->fetchAll(PDO::FETCH_UNIQUE);

        if ($regs === false) {
            $regs = [];
        }

        $regs = implode(',', array_keys($regs));
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
