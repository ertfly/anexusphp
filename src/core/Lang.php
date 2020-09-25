<?php

namespace AnexusPHP\Tools;

use AnexusPHP\RegraDeNegocio\Configuracao\Repositorio\ConfiguracaoRepositorio;
use AnexusPHP\RegraDeNegocio\Local\Entidade\LocalPaisEntidade;

class Lang
{
    /**
     * @param integer $page
     * @param LocalPaisEntidade $country
     * @param boolean $fromCache
     * @return IdiomaEntidade[]
     */
    public static function loadPage(int $page, LocalPaisEntidade $country = null, bool $fromCache = true)
    {
        if ($fromCache) {
            return self::searchInCache($page, $country);
        }

        return IdiomaRepositorio::porTela($page, $country->getId());
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

        $translate = IdiomaRepositorio::porTela($page, $country->getId());
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
}
