<?php

namespace AnexusPHP\Business\App\Rule;

use AnexusPHP\Business\App\Entity\AppEntity;
use AnexusPHP\Core\Database;

class AppRule
{
    public static function insert(AppEntity &$record)
    {
        $db = Database::getInstance();
        if ($record->getId()) {
            throw new \Exception('Esse método serve inserir registros e não alterar');
        }
        $record->save($db);
    }
    public static function update(AppEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new \Exception('Esse método serve alterar registros e não inserir');
        }
        $record->save($db);
    }
    public static function delete(AppEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new \Exception('Esse método deve conter um ID');
        }
        $record->delete($db);
    }
    public static function destroy(AppEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new \Exception('Esse método deve conter um ID');
        }
        $record->destroy($db);
    }
}
