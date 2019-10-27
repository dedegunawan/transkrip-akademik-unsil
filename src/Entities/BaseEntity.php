<?php
/**
 * Created by PhpStorm.
 * User: tik_squad
 * Date: 9/26/19
 * Time: 10:28 AM
 */

namespace DedeGunawan\TranskripAkademikUnsil\Entities;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Database\Eloquent\JsonEncodingException;

abstract class BaseEntity implements Arrayable, Jsonable, \JsonSerializable, \ArrayAccess
{

    public static function build(array $datas) {
        $class = new \ReflectionClass(get_called_class());
        $object = $class->newInstance();
        foreach ($datas as $key => $data) {
            $method = $object->convertToMethod($key);
            if ($class->hasMethod($method)) {
                call_user_func_array([$object, $method], [$data]);
            }
        }
        return $object;
    }
    protected function convertToMethod($string)
    {
        $str = str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
        return "set".$str;
    }

    protected function getProperties()
    {
        $class = new \ReflectionClass(get_called_class());
        $items = [];
        $object = $this;
        $properties = $class->getProperties();
        foreach ($properties as $property) {
            $name = $property->name;
            $items[$name] = $object->{$name};
        }
        return $items;
    }


    public function toArray()
    {
        $items = $this->getProperties();

        return array_map(function ($value) {
            return $value instanceof Arrayable ? $value->toArray() : $value;
        }, $items);
    }



    public function toJson($options = 0)
    {
        $json = json_encode($this->getProperties(), $options);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw JsonEncodingException::forModel($this, json_last_error_msg());
        }

        return $json;
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function offsetExists($offset)
    {
        $class = new \ReflectionClass(get_called_class());
        return $class->hasProperty($offset);
    }

    public function offsetGet($offset)
    {
        return $this->$offset;
    }

    public function offsetSet($offset, $value)
    {
        $class = new \ReflectionClass(get_called_class());
        $object = $this;
        $method = $object->convertToMethod($offset);
        if ($class->hasMethod($method)) {
            return call_user_func_array([$object, $method], [$value]);
        }
        return null;

    }

    public function offsetUnset($offset)
    {
        $class = new \ReflectionClass(get_called_class());
        $object = $this;
        $method = $object->convertToMethod($offset);
        if ($class->hasMethod($method)) {
            return call_user_func_array([$object, $method], [null]);
        }
        return null;
    }


}