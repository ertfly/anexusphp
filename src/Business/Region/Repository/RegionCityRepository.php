<?php

namespace AnexusPHP\Business\Region\Repository;

use AnexusPHP\Business\Region\Entity\RegionCityEntity;
use AnexusPHP\Business\Region\Entity\RegionStateEntity;
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
    public static function byId($id)
    {
        $db = Database::getInstance();
        $cursor = $db->{RegionCityEntity::TABLE}->find(['_id' => intval($id)], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => RegionCityEntity::class,
            'document' => RegionCityEntity::class,
        ]);
        foreach ($cursor as $r) {
            return $r;
        }
        return new RegionCityEntity();
    }

    /**
     * Retorna registros da tabela pelo Estado
     *
     * @param RegionStateEntity $state
     * @param array $options
     * @return RegionCityEntity[]
     */
    public static function searchByState($state, array $options = [])
    {
        $db = Database::getInstance();

        if (!$state->getId()) {
            throw new Exception('Estado inválido');
        }

        $regs = $db->query('
            select 
                a.id as id,
                a.state_id as state_id,
                a.name as name
            from ' . RegionCityEntity::TABLE . ' a
            where a.state_id = :region_state_id
            order by a.name asc
        ', [
            'region_state_id' => $state->getId(),
        ])->fetchAll(PDO::FETCH_CLASS, RegionCityEntity::class);

        foreach ($regs as $key => $reg) {
            if (isset($options['array']) && $options['array']) {
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
        return $db->query('select * from ' . RegionCityEntity::TABLE . ' where trash = 0')->fetchAll(PDO::FETCH_CLASS, RegionCityEntity::class);
    }

    /**
     * Undocumented function
     *
     * @param RegionStateEntity $state
     * @return RegionCityEntity[]
     */
    public static function byState(RegionStateEntity $state)
    {
        $db = Database::getInstance();
        return $db->query('select * from ' . RegionCityEntity::TABLE . ' where state_id = :state_id order by "name" asc', ['state_id' => $state->getId()])->fetchAll(PDO::FETCH_CLASS, RegionCityEntity::class);
    }
}
