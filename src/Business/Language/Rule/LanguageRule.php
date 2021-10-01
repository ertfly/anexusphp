<?php

namespace AnexusPHP\Business\Language\Rule;

use AnexusPHP\Business\Language\Entity\LanguageEntity;
use AnexusPHP\Core\Database;

class LanguageRule
{
    public static function update(LanguageEntity &$record)
    {
        $db = Database::getInstance();
        if (!$record->getId()) {
            throw new \Exception('Esse método serve alterar registros e não inserir');
        }
        $record->save($db, [
            'id' => $record->getId(),
            'region_country_id' => $record->getRegionCountryId(),
            'screen_id' => $record->getScreenId()
        ]);
    }
}
