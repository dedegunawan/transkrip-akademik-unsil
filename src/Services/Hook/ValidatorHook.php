<?php
/**
 * Created by PhpStorm.
 * User: tik_squad
 * Date: 22/10/19
 * Time: 10.06
 */

namespace DedeGunawan\TranskripAkademikUnsil\Services\Hook;


use DedeGunawan\TranskripAkademikUnsil\Interfaces\HookInterface;
use DedeGunawan\TranskripAkademikUnsil\Traits\BaseHookTrait;

class ValidatorHook implements HookInterface
{
    use BaseHookTrait;

    public function call()
    {
        //echo "Hooks called";die();
    }
}