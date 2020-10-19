<?php

namespace AnexusPHP\Business\Region\Repository;

use AnexusPHP\Business\Region\Entity\RegionCityEntity;
use AnexusPHP\Core\Database;
use Exception;
use PDO;

class RegionCityRepository
{
    /**
     * Retorna um registro da tabela pelo id
     *
     * @param integer|null $id
     * @return RegionCityEntity
     */
    public static function perId(?int $id): RegionCityEntity
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . RegionCityEntity::TABLE . ' where id = :id limit 1', ['id' => (int)$id])->fetchObject(RegionCityEntity::class);
        if ($reg === false) {
            return new RegionCityEntity();
        }

        return $reg;
    }

    /**
     * Retorna registros da tabela pelo Estado
     *
     * @param RegionStateEntity $uf
     * @param array $opcoes
     * @return RegionCityEntity[]
     */
    public static function searchByState($uf, array $opcoes = [])
    {
        $db = Database::getInstance();

        if (!$uf->getId()) {
            throw new Exception('UF inválido');
        }

        $regs = $db->query('
            select 
                a.id as id,
                a.uf_id as uf_id,
                a.nome as nome
            from ' . RegionCityEntity::TABLE . ' a
            where a.uf_id = :region_uf_id
            order by a.nome asc
        ', [
            'region_uf_id' => $uf->getId(),
        ])->fetchAll(PDO::FETCH_CLASS, RegionCityEntity::class);

        foreach ($regs as $key => $reg) {
            if (isset($opcoes['array']) && $opcoes['array']) {
                $regs[$key] = $regs[$key] = $reg->toArray();
            }
        }

        return $regs;
    }

    /**
     * Retorna todos os registros da tabela
     *
     * @return RegionCityEntity[]
     */
    public static function searchAll()
    {
        $db = Database::getInstance();
        return $db->query('select * from ' . RegionCityEntity::TABLE . ' where lixo = 0')->fetchAll(PDO::FETCH_CLASS, RegionCityEntity::class);
    }
}
