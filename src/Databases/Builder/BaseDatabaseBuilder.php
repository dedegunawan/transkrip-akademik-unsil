<?php
/**
 * Created by PhpStorm.
 * User: tik_squad
 * Date: 21/10/19
 * Time: 13.34
 */

namespace DedeGunawan\TranskripAkademikUnsil\Databases\Builder;


use DedeGunawan\TranskripAkademikUnsil\Entities\BaseEntity;

abstract class BaseDatabaseBuilder extends BaseEntity
{
    const ERROR_MODE_SILENT = 0;
    const ERROR_MODE_EXCEPTION = 1;
    protected static $errorMode;

    protected $error_message;
    protected $connection;

    /**
     * @return mixed
     */
    public function getConnection()
    {
        if ($this->getErrorMessage()) return null;
        return $this->connection;
    }

    public static function build(array $datas)
    {
        $object = parent::build($datas);
        $object->connect();
        return $object;
    }


    abstract function connect();

    public function reconnect() {
        return $this->connect(true);
    }

    abstract function disconnect();

    /**
     * @return mixed
     */
    public function getErrorMessage()
    {
        return $this->error_message;
    }

    /**
     * @param mixed $error_message
     */
    protected function setErrorMessage($error_message)
    {
        $this->error_message = $error_message;
    }

    /**
     * @return mixed
     */
    public static function getErrorMode()
    {
        return self::$errorMode;
    }

    /**
     * @param mixed $errorMode
     */
    public static function setErrorMode($errorMode)
    {
        self::$errorMode = $errorMode;
    }

    abstract function numRows($query);
    abstract function select($query, $one=false);
    abstract function selectAll($query);
    abstract function selectOne($query);
    abstract function selectField($query, $field='');


}