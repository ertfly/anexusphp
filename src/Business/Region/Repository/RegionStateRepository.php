<?php

namespace AnexusPHP\Business\Region\Repository;

use AnexusPHP\Business\Region\Entity\RegionStateEntity;
use AnexusPHP\Core\Database;
use PDO;

class RegionStateRepository
{
    /**
     * Retorna um registro da tabela pelo id
     * 
     * @param integer|null $id
     * @return RegionStateEntity
     */
    public static function byId(?int $id)
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . RegionStateEntity::TABLE . ' where id = :id limit 1', ['id' => (int)$id])->fetchObject(RegionStateEntity::class);
        if ($reg === false) {
            return new RegionStateEntity();
        }

        return $reg;
    }

    /** 
     * Retorna todos os registros da tabela
     * 
     * @return RegionStateEntity[]
     */
    public static function searchAll()
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . RegionStateEntity::TABLE . ' where trash = 0')->fetchAll(PDO::FETCH_CLASS, RegionStateEntity::class);

        return $reg;
    }
}