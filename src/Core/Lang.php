<?php

namespace AnexusPHP\Core;

use AnexusPHP\Core\Session;
use AnexusPHP\Business\Configuration\Repository\ConfigurationRepository;
use AnexusPHP\Business\Language\Entity\LanguageEntity;
use AnexusPHP\Business\Language\Repository\LanguageRepository;
use AnexusPHP\Business\Region\Entity\RegionCountryEntity;
use Exception;

class Lang
{
    private static $country;

    public static function getCountry()
    {
        return self::$country;
    }

    public static function setCountry(RegionCountryEntity $country)
    {
        self::$country = $country;
    }

    public static function title($id)
    {
        if (!self::$country) {
            throw new Exception('Country not set');
        }

        $translations = Session::item('translations');
        if (!isset($translations) || !is_array($translations)) {
            $translations = [];
        }

        if (!isset($translations[self::getCountry()->getId()])) {
            $translations[self::getCountry()->getId()] = [];
        }

        if (!isset($translations[self::getCountry()->getId()][$id])) {
            $lang = LanguageRepository::byIdCountry($id, self::getCountry());
            if (!$lang->getId()) {
                throw new Exception('Title ' . $id . ' not exist');
            }
            $translations[self::getCountry()->getId()][$id] = $lang->getValue();
        }

        return $translations[self::getCountry()->getId()][$id];
    }

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

        $translate = self::toArray(LanguageRepository::byScreen($page, $country));
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
