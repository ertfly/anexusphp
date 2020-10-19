<?php

namespace AnexusPHP\Business\App\Repository;

use AnexusPHP\Business\App\Entity\AppEntity;
use AnexusPHP\Core\Database;

class AppRepository
{
    /**
     * Retorna um registro do banco
     *
     * @param integer|null $id
     * @return void
     */
    public static function perId(?int $id)
    {
        $db = Database::getInstance();
        $reg = $db->query('select * from ' . AppEntity::TABLE . ' where id = :id limit 1', ['id' => (int)$id])->fetchObject(AppEntity::class);
        if ($reg === false) {
            return new AppEntity();
        }

        return $reg;
    }
}
