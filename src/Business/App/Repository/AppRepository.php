<?php

namespace AnexusPHP\Business\App\Repository;

use AnexusPHP\Business\App\Entity\AppEntity;
use AnexusPHP\Core\Database;

class AppRepository
{
    /**
     * Retorna um registro do banco pelo id
     *
     * @param integer|null $id
     * @return AppEntity
     */
    public static function byId($id, $className = AppEntity::class)
    {
        $db = Database::getInstance();
        $cursor = $db->{AppEntity::TABLE}->find(['_id' => intval($id)], ['limit' => 1]);
        $cursor->setTypeMap([
            'root' => $className,
            'document' => 'array',
        ]);
        Database::closeInstance();
        foreach ($cursor as $r) {
            return $r;
        }
        $className = '\\' . $className;
        return new $className();
    }

    /**
     * Undocumented function
     *
     * @return AppEntity[]
     */
    public static function all()
    {
        $db = Database::getInstance();

        $where = [];

        $options = [
            'sort' => [
                '_id' => 1
            ],
        ];

        $cursor = $db->{AppEntity::TABLE}->find(
            $where,
            $options,
        );
        $cursor->setTypeMap([
            'root' => AppEntity::class,
            'document' => 'array',
        ]);

        Database::closeInstance();

        $rows = [];
        foreach ($cursor as $r) {
            $rows[] = $r;
        }

        return $rows;
    }
}
