<?php
/**
 * Created by PhpStorm.
 * User: tik_squad
 * Date: 22/10/19
 * Time: 09.58
 */

namespace DedeGunawan\TranskripAkademikUnsil\Interfaces;


use DedeGunawan\TranskripAkademikUnsil\TranskripAkademikUnsil;

interface HookInterface
{
    public function setTranskripAkademikUnsil(TranskripAkademikUnsil $transkripAkademikUnsil);
    public function call();
}