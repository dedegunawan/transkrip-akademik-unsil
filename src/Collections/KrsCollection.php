<?php
/**
 * Created by PhpStorm.
 * User: tik_squad
 * Date: 10/8/19
 * Time: 8:56 AM
 */

namespace DedeGunawan\TranskripAkademikUnsil\Collections;


use DedeGunawan\TranskripAkademikUnsil\Entities\Krs;

class KrsCollection extends BaseCollection
{

    /**
     * @return string
     */
    public static function getCollectionType(): string
    {
        return Krs::class;
    }

    public function getTotalBobot()
    {
        return $this->reduce(function ($acc, $current) {
            return $acc+$current->getJumlahBobot();
        }, 0);
    }

    public function getTotalSks()
    {
        return $this->sum('sks');
    }

    public function getIpk()
    {
        return $this->getTotalBobot()/$this->getTotalSks();
    }
}