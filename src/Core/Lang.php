<?php

namespace AnexusPHP\Core;

use AnexusPHP\Core\Session;
use AnexusPHP\Business\Configuration\Repository\ConfigurationRepository;
use AnexusPHP\Business\Language\Entity\LanguageEntity;
use AnexusPHP\Business\Language\Repository\LanguageRepository;
use AnexusPHP\Business\Region\Entity\RegionCountryEntity;

class Lang
{
    /**
     * @param integer $page
     * @param RegionCountryEntity $country
     * @param boolean $fromCache
     * @return array
     */
    public static function loadPage(int $page, RegionCountryEntity $country = null, bool $fromCache = true)
    {
        if ($fromCache) {
            return self::searchInCache($page, $country);
        }

        return self::toArray(LanguageRepository::byScreen($page, $country->getId()));
    }

    /**
     * @param integer $page
     * @param RegionCountryEntity $country
     * @return array
     */
    private static function searchInCache(int $page, RegionCountryEntity $country)
    {
        $version = (ConfigurationRepository::byId('TRANSLATION_VERSION'))->getValue();
        $translations = Session::item('translations');

        if (self::isValidCache($version, $translations, $page, $country)) {
            return $translations[$country->getId()][$page];
        }

        $translate = self::toArray(LanguageRepository::byScreen($page, $country->getId()));
        $translate['SCREEN_CACHE_VERSION'] = $version;

        $translations[$country->getId()][$page] = $translate;
        Session::data('translations', $translations);

        return $translate;
    }

    /**
     * @param integer $version
     * @param array|bool $translations
     * @param integer $page
     * @param RegionCountryEntity $country
     * @return boolean
     */
    private static function isValidCache(int $version, $translations, int $page, RegionCountryEntity $country): bool
    {
        if ($translations && is_array($translations) && isset($translations[$country->getId()])) {
            if (isset($translations[$country->getId()][$page]) && $translations[$country->getId()][$page]['SCREEN_CACHE_VERSION'] == $version) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param LanguageEntity[] $translate
     * @return array
     */
    private static function toArray(array $translate): array
    {
        foreach ($translate as $key => $value) {
            $translate[$key] = $value->getValue();
        }
        return $translate;
    }
}
