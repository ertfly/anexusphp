<?php

namespace AnexusPHP\Business\Configuration\Rules;

use AnexusPHP\Business\Configuration\Entity\ConfigurationEntity;
use AnexusPHP\Core\Database;

class ConfigurationRules
{
    public static function insert(ConfigurationEntity &$record)
    {
        $db = Database::getInstance();
        if ($record->getId()) {
            throw new \Exception('Esse método serve inserir registros e não alterar');
        }
        $record->save($db);
    }
    public static function update(ConfigurationEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new \Exception('Esse método serve alterar registros e não inserir');
        }
        $record->save($db);
    }
    public static function delete(ConfigurationEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new \Exception('Esse método deve conter um ID');
        }
        $record->delete($db);
    }
    public static function destroy(ConfigurationEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new \Exception('Esse método deve conter um ID');
        }
        $record->destroy($db);
    }
}
