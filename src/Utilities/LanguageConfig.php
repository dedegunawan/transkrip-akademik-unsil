<?php
/**
 * Created by PhpStorm.
 * User: tik_squad
 * Date: 27/10/19
 * Time: 08.54
 */

namespace DedeGunawan\TranskripAkademikUnsil\Utilities;


class LanguageConfig
{

    protected static $language='id';
    protected static $knownLanguageFormat=array('id' => 'Bahasa Indonesia', 'en' => 'English Language');

    /**
     * @return string
     */
    public static function getLanguage()
    {
        return self::$language;
    }

    /**
     * @param string $language
     * @throws \Exception
     */
    public static function setLanguage($language)
    {
        $language = strtolower($language);
        if (!array_key_exists($language, self::$knownLanguageFormat))
            throw new \Exception("Language code unknown");
        self::$language = $language;
    }

    /**
     * @throws \Exception
     */
    public static function setDefaultLanguage()
    {
        self::setLanguage('id');
    }

    public static function getKnownLanguageFormat()
    {
        return self::$knownLanguageFormat;
    }
    public static function addKnownLanguageFormat($index, $label)
    {
        self::$knownLanguageFormat[$index] = $label;
    }

    public static function __callStatic($name, $arguments)
    {
        if ($name == 'getInstance') return self::getInstance();
        $instance = self::getInstance();
        return call_user_func_array([$instance, $name], $arguments);
    }

    public static function getInstance() {
        static $instance;
        if ($instance==null) {
            $instance = new static();
        }
        return $instance;
    }
}