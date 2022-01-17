<?php

namespace PequiPHP\Business\Region\Repository;

use PequiPHP\Business\Region\Entity\RegionCityEntity;
use PequiPHP\Business\Region\Entity\RegionStateEntity;
use PequiPHP\Core\Database;
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
        Database::closeInstance();
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

        $where = [
            'state_id' => intval($state->getId()),
        ];

        $options = [
            'sort' => [
                'name' => 1
            ],
        ];

        $cursor = $db->{RegionCityEntity::TABLE}->find(
            $where,
            $options,
        );
        $cursor->setTypeMap([
            'root' => RegionCityEntity::class,
            'document' => RegionCityEntity::class,
        ]);

        Database::closeInstance();

        $rows = [];
        foreach ($cursor as $r) {
            if (isset($options['array']) && $options['array']) {
                $rows[] = $r->toArray();
                continue;
            }
            $rows[] = $r;
        }

        return $rows;
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

        $where = [
            'state_id' => intval($state->getId()),
        ];

        $options = [
            'sort' => [
                'name' => 1
            ],
        ];

        $cursor = $db->{RegionCityEntity::TABLE}->find(
            $where,
            $options,
        );
        $cursor->setTypeMap([
            'root' => RegionCityEntity::class,
            'document' => RegionCityEntity::class,
        ]);

        Database::closeInstance();

        $rows = [];
        foreach ($cursor as $r) {
            $rows[] = $r;
        }
        return $rows;
    }
}
