<?php
/**
 * Created by PhpStorm.
 * User: tik_squad
 * Date: 9/26/19
 * Time: 10:46 AM
 */

namespace DedeGunawan\TranskripAkademikUnsil\Collections;


use DedeGunawan\UtilityClass\MyCollection;

abstract class BaseCollection extends MyCollection
{
    /**
     * @return string
     */
    abstract public static function getCollectionType(): string;

    public static function build(array $datas) {
        $object = call_user_func_array([get_called_class(), 'getCollectionType'], []);
        foreach ($datas as $key => $data) {
            $datas[$key] = call_user_func_array([$object, 'build'], [$data]);
        }
        $class = new \ReflectionClass(get_called_class());
        return $class->newInstanceArgs([$datas]);
    }




}