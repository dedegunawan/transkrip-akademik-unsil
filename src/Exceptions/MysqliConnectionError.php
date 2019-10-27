<?php
/**
 * Created by PhpStorm.
 * User: tik_squad
 * Date: 21/10/19
 * Time: 13.10
 */

namespace DedeGunawan\TranskripAkademikUnsil\Exceptions;


use Throwable;

class MysqliConnectionError extends \Exception
{
    public function __construct($message, Throwable $previous = null)
    {
        $code = "702";
        parent::__construct($message, $code, $previous);
    }
}