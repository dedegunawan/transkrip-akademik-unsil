<?php
/**
 * Created by PhpStorm.
 * User: tik_squad
 * Date: 10/14/19
 * Time: 11:41 AM
 */

namespace DedeGunawan\TranskripAkademikUnsil\Exceptions;


use Throwable;

class NpmException extends \Exception
{
    public function __construct(Throwable $previous = null)
    {
        $message = "NPM belum di set";
        $code = "701";
        parent::__construct($message, $code, $previous);
    }
}