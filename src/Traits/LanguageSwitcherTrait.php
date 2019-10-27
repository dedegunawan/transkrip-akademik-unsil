<?php
/**
 * Created by PhpStorm.
 * User: tik_squad
 * Date: 27/10/19
 * Time: 08.36
 */

namespace DedeGunawan\TranskripAkademikUnsil\Traits;


use DedeGunawan\TranskripAkademikUnsil\Utilities\LanguageConfig;

trait LanguageSwitcherTrait
{
    public function getLanguage()
    {
        return LanguageConfig::getLanguage();
    }

    public function setLanguage($key)
    {
        return LanguageConfig::setLanguage($key);
    }
}