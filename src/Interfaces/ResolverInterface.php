<?php
/**
 * Created by PhpStorm.
 * User: tik_squad
 * Date: 10/14/19
 * Time: 11:24 AM
 */

namespace DedeGunawan\TranskripAkademikUnsil\Interfaces;


use DedeGunawan\TranskripAkademikUnsil\TranskripAkademikUnsil;

interface ResolverInterface
{
    public function setTranskripAkademikUnsil(TranskripAkademikUnsil $transkripAkademikUnsil);
    public function resolve();
}