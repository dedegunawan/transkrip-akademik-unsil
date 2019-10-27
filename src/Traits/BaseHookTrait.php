<?php
/**
 * Created by PhpStorm.
 * User: tik_squad
 * Date: 22/10/19
 * Time: 10.07
 */

namespace DedeGunawan\TranskripAkademikUnsil\Traits;


use DedeGunawan\TranskripAkademikUnsil\TranskripAkademikUnsil;

trait BaseHookTrait
{
    /**
     * @var TranskripAkademikUnsil
     */
    protected $transkripAkademikUnsil;

    /**
     * @return TranskripAkademikUnsil
     */
    public function getTranskripAkademikUnsil()
    {
        return $this->transkripAkademikUnsil;
    }

    /**
     * @param TranskripAkademikUnsil $transkripAkademikUnsil
     */
    public function setTranskripAkademikUnsil(TranskripAkademikUnsil $transkripAkademikUnsil)
    {
        $this->transkripAkademikUnsil = $transkripAkademikUnsil;
    }
}