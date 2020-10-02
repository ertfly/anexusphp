<?php

namespace AnexusPHP\Core;

use AnexusPHP\Core\Session;
use AnexusPHP\RegraDeNegocio\Configuracao\Repositorio\ConfiguracaoRepositorio;
use AnexusPHP\RegraDeNegocio\Idioma\Repositorio\IdiomaRepositorio;
use AnexusPHP\RegraDeNegocio\Local\Entidade\LocalPaisEntidade;

class Lang
{
    /**
     * @param integer $page
     * @param LocalPaisEntidade $country
     * @param boolean $fromCache
     * @return array
     */
    public static function loadPage(int $page, LocalPaisEntidade $country = null, bool $fromCache = true)
    {
        if ($fromCache) {
            return self::searchInCache($page, $country);
        }

        return self::toArray(IdiomaRepositorio::porTela($page, $country->getId()));
    }

    /**
     * @param integer $page
     * @param LocalPaisEntidade $country
     * @return array
     */
    private static function searchInCache(int $page, LocalPaisEntidade $country)
    {
        $version = (ConfiguracaoRepositorio::porId('TRANSLATION_VERSION'))->getValor();
        $translations = Session::item('translations');

        if (self::isValidCache($version, $translations, $page, $country)) {
            return $translations[$country->getId()][$page];
        }

        $translate = self::toArray(IdiomaRepositorio::porTela($page, $country->getId()));
        $translate['SCREEN_CACHE_VERSION'] = $version;

        $translations[$country->getId()][$page] = $translate;
        Session::data('translations', $translations);

        return $translate;
    }

    /**
     * @param integer $version
     * @param array|bool $translations
     * @param integer $page
     * @param LocalPaisEntidade $country
     * @return boolean
     */
    private static function isValidCache(int $version, $translations, int $page, LocalPaisEntidade $country): bool
    {
        if ($translations && is_array($translations) && isset($translations[$country->getId()])) {
            if (isset($translations[$country->getId()][$page]) && $translations[$country->getId()][$page]['SCREEN_CACHE_VERSION'] == $version) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param IdiomaEntidade[] $translate
     * @return array
     */
    private static function toArray(array $translate): array
    {
        foreach ($translate as $key => $value) {
            $translate[$key] = $value->getvalor();
        }
        return $translate;
    }
}
