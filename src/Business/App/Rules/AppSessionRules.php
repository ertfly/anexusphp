<?php

namespace AnexusPHP\Business\App\Rules;

use AnexusPHP\Business\App\Entity\AppSessionEntity;
use AnexusPHP\Core\Database;

class AppSessionRules
{
    public static function insert(AppSessionEntity $record)
    {
        $db = Database::getInstance();
        if ($record->getId()) {
            throw new \Exception('Esse método serve inserir registros e não alterar');
        }

        $record->setCreateAt(date('Y-m-d H:i:s'));
        $record->setUpdatedAt(date('Y-m-d H:i:s'));
        $record->save($db);
    }
    public static function update(AppSessionEntity $record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new \Exception('Esse método serve alterar registros e não inserir');
        }

        $record->setUpdatedAt(date('Y-m-d H:i:s'));
        $record->save($db);
    }
    public static function delete(AppSessionEntity $record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new \Exception('Esse método deve conter um ID');
        }
        $record->delete($db);
    }
    public static function destroy(AppSessionEntity $record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new \Exception('Esse método deve conter um ID');
        }
        $record->destroy($db);
    }
}
