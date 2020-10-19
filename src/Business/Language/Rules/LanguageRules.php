<?php

namespace AnexusPHP\Business\Language\Rules;

use AnexusPHP\Business\Language\Entity\LanguageEntity;
use AnexusPHP\Core\Database;

class LanguageRules
{
    public static function insert(LanguageEntity &$record)
    {
        $db = Database::getInstance();
        if ($record->getId()) {
            throw new \Exception('Esse método serve inserir registros e não alterar');
        }

        $record->save($db);
    }
    public static function update(LanguageEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new \Exception('Esse método serve alterar registros e não inserir');
        }
        $record->saveWhere($db, [
            'id' => $record->getId(),
            'local_country_id' => $record->getLocalCountryId(),
            'screen_id' => $record->getScreenId()
        ]);
    }
}
