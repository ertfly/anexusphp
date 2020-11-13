<?php

namespace AnexusPHP\Business\App\Repository;

use AnexusPHP\Business\App\Entity\AppAuthfastEntity;
use AnexusPHP\Core\Database;
use AnexusPHP\Core\Libraries\Pagination\Pagination;
use PDO;

class AppAuthfastRepository
{
    /**
     * Retorna um registro do banco pelo id
     *
     * @param integer|null $id
     * @return AppAuthfastEntity
     */
    public static function byId(?int $id)
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . AppAuthfastEntity::TABLE . ' where id = :id limit 1', ['id' => (int)$id])->fetchObject(AppAuthfastEntity::class);
        if ($reg === false) {
            return new AppAuthfastEntity();
        }

        return $reg;
    }

    /**
     * Retorna um registro do banco pelo authfast id
     * 
     * @param string|null $id
     * @return AppAuthfastEntity
     */
    public static function byAuthfastId(?string $authfastId)
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . AppAuthfastEntity::TABLE . ' where authfast_id = :authfast_id limit 1', ['authfast_id' => $authfastId])->fetchObject(AppAuthfastEntity::class);
        if ($reg === false) {
            return new AppAuthfastEntity();
        }

        return $reg;
    }

    /**
     * Retorna um registro do banco pelo authfast id e app
     * 
     * @param string $id
     * @param int $id
     * @return AppAuthfastEntity
     */
    public static function byAuthfastIdAndAppId(string $authfastId, int $app)
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . AppAuthfastEntity::TABLE . ' where authfast_id = :authfast_id and app_id = :app_id limit 1', ['authfast_id' => $authfastId, 'app_id' => $app])->fetchObject(AppAuthfastEntity::class);
        if ($reg === false) {
            return new AppAuthfastEntity();
        }

        return $reg;
    }

    /**
     * Retorna todos os registros do banco
     * 
     * @return AppAuthfastEntity[]
     */
    public static function all()
    {
        $db = Database::getInstance();
        $regs = $db->query('select * from ' . AppAuthfastEntity::TABLE . ' where trash is false')->fetchAll(PDO::FETCH_CLASS, AppAuthfastEntity::class);

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
    public static function allWithPagination($url, $filters = [], $currentPg, $varPg = 'pg', $perPg = 12)
    {
        $db = Database::getInstance();

        $bind = [];
        $where = "1 = 1 ";

        if (isset($filters['search']) && trim($filters['search']) != '') {
            $where .= " and a.authfast_id = (select b.id from authfast b where b.code like '%'||:code||'%' limit 1) ";
            $bind['code'] = $filters['search'];
        }

        if (isset($filters['app_id']) && trim($filters['app_id']) != '') {
            $where .= " and a.app_id = :app_id ";
            $bind['app_id'] = $filters['app_id'];
        }

        $total = $db->query('select count(1) as total from ' . AppAuthfastEntity::TABLE . ' a where ' . $where, $bind)->fetch();

        $pagination = new Pagination($total['total'], $perPg, $varPg, $currentPg, $url);

        $regs = $db->query('select a.* from ' . AppAuthfastEntity::TABLE . ' a where ' . $where . ' order by a.authfast_id desc limit ' . $perPg . ' OFFSET ' . $pagination->getOffset(), $bind)->fetchAll(PDO::FETCH_CLASS, AppAuthfastEntity::class);

        $pagination->setRows($regs);

        return $pagination;
    }
}
