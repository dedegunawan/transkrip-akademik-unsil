<?php
/**
 * Created by PhpStorm.
 * User: tik_squad
 * Date: 21/10/19
 * Time: 13.33
 */

namespace DedeGunawan\TranskripAkademikUnsil\Databases;




use DedeGunawan\TranskripAkademikUnsil\Databases\Builder\BaseDatabaseBuilder;

class ConnectionManager implements \ArrayAccess
{

    protected $connections = [];

    protected $active='default';

    /**
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return isset($this->array[$offset]);
    }

    /**
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return isset($this->array[$offset]) ? $this->array[$offset] : null;
    }

    /**
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) $offset='default';
        $this->array[$offset] = $value;
    }

    /**
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        unset($this->array[$offset]);
    }

    /**
     * @return array
     */
    public function getConnections(): array
    {
        return $this->connections;
    }


    public function setConnection($key, BaseDatabaseBuilder $database)
    {
        $this->connections[$key] = $database;
    }

    /**
     * @param $key
     * @return BaseDatabaseBuilder | null
     */
    public function getConnection($key=null)
    {
        if (is_null($key)) $key=$this->getActive();
        $connection = @$this->connections[$key];
        if (!$connection && count($this->connections) == 1) {
            $cn = array_values($this->connections);
            $connection = @$cn[0];
        }
        return $connection;
    }

    /**
     *
     */
    public function resetConnections()
    {
        $this->connections=array();
    }

    /**
     * @return string
     */
    public function getActive(): string
    {
        return $this->active;
    }

    /**
     * @param string $active
     * @throws \Exception
     */
    public function setActive(string $active)
    {
        if (!array_key_exists($active, $this->getConnections()))
            throw new \Exception("Koneksi tidak ditemukan");
        $this->active = $active;
    }

    public static function getInstance()
    {
        static $intance;
        if ($intance==null) {
            $intance = new self();
        }
        return $intance;
    }

}