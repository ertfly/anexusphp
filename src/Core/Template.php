<?php

namespace AnexusPHP\Core;

use AnexusPHP\Business\Configuration\Repository\ConfigurationRepository;
use League\Plates\Engine;

class Template
{
    private static $setting;

    public static function init()
    {
        if (!self::$setting) {
            self::$setting = @json_decode(ConfigurationRepository::getValue('template_config'), true);
            if (!self::$setting) {
                self::$setting = [];
            }

            $template = ConfigurationRepository::getValue('template');
            $assetsPath = PATH_PUBLIC . 'assets' . DS . 'template' . DS . $template . DS . 'setting' . DS;
            $templateFiles = scandir($assetsPath);
            unset($templateFiles[0]);
            unset($templateFiles[1]);
            if (count($templateFiles) < 2) {
                self::generateFiles();
            }
        }
    }

    public static function getSetting()
    {
        self::init();
        return self::$setting;
    }

    public static function getSettingByKey($name, $defaultValue = null, $isUpload = false)
    {
        self::init();
        if (!isset(self::$setting[$name])) {
            return $defaultValue;
        }

        return !$isUpload ? self::$setting[$name] : upload('template/' . self::$setting[$name]);
    }

    public static function generateFiles()
    {
        $template = ConfigurationRepository::getValue('template');
        $resourcePath = PATH_ROOT . 'src' . DS . 'App' . DS . 'Views' . DS . $template . DS . 'resource';
        $assetsPath = PATH_PUBLIC . 'assets' . DS . 'template' . DS . $template . DS . 'setting' . DS;

        $engine = new Engine($resourcePath, 'css');

        $templateFiles = scandir($resourcePath);
        unset($templateFiles[0]);
        unset($templateFiles[1]);

        if (!empty($templateFiles)) {
            foreach ($templateFiles as $file) {
                $fileParts = explode('.', $file);
                array_pop($fileParts);
                $fileName = implode('.', $fileParts);

                $fileContent = $engine->render($fileName);

                if(is_file($assetsPath . $file)){
                    @unlink($assetsPath . $file);
                }

                @file_put_contents($assetsPath . $file, $fileContent);
            }
        }
    }
}
