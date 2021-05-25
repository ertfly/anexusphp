<?php

namespace AnexusPHP\Business\Authfast\Rule;

use AnexusPHP\Business\Authfast\Entity\AuthfastActivityEntity;

use AnexusPHP\Core\Database;
use Exception;

class AuthfastActivityRule
{
    public static function insert(AuthfastActivityEntity &$record)
    {
        $db = Database::getInstance();
        if ($record->getId()) {
            throw new Exception('Esse método serve inserir registros e não alterar');
        }
        $record->setCreatedAt(date('Y-m-d H:i:s'))
            ->save($db);
    }
    public static function update(AuthfastActivityEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método serve alterar registros e não inserir');
        }
        $record->save($db);
    }
    public static function destroy(AuthfastActivityEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new Exception('Esse método deve conter um ID');
        }
        $record->destroy($db);
    }
}
