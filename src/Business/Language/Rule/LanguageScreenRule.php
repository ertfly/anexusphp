<?php

namespace AnexusPHP\Business\Language\Rule;

use AnexusPHP\Business\Language\Entity\LanguageScreenEntity;
use AnexusPHP\Core\Database;

class LanguageScreenRule
{
    public static function insert(LanguageScreenEntity &$registro)
    {
        $db = Database::getInstance();
        if ($registro->getId()) {
            throw new \Exception('Esse método serve inserir registros e não alterar');
        }

        $registro->save($db);
    }
    public static function update(LanguageScreenEntity &$registro)
    {
        $db = Database::getInstance();
        if (!$registro->getId()) {
            throw new \Exception('Esse método serve alterar registros e não inserir');
        }
        $registro->save($db);
    }
}
