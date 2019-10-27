<?php
/**
 * Created by PhpStorm.
 * User: tik_squad
 * Date: 21/10/19
 * Time: 10.31
 */

namespace DedeGunawan\TranskripAkademikUnsil\Entities;


class Kelulusan extends BaseEntity
{
    protected $ipk;
    protected $predikat;
    protected $judul;
    /**
     * @var $tanggal_lulus Tanggal
     */
    protected $tanggal_lulus;

    /**
     * @return mixed
     */
    public function getIpk()
    {
        return $this->ipk;
    }

    /**
     * @param mixed $ipk
     */
    public function setIpk($ipk)
    {
        $this->ipk = $ipk;
    }

    /**
     * @return mixed
     */
    public function getPredikat()
    {
        return $this->predikat;
    }

    /**
     * @param mixed $predikat
     */
    public function setPredikat($predikat)
    {
        $this->predikat = $predikat;
    }

    /**
     * @return mixed
     */
    public function getJudul()
    {
        return $this->judul;
    }

    /**
     * @param mixed $judul
     */
    public function setJudul($judul)
    {
        $this->judul = $judul;
    }

    /**
     * @return Tanggal
     */
    public function getTanggalLulus(): Tanggal
    {
        return $this->tanggal_lulus;
    }

    /**
     * @param Tanggal $tanggal_lulus
     */
    public function setTanggalLulus($tanggal_lulus)
    {
        if (!$tanggal_lulus instanceof Tanggal) {
            $tanggal_lulus = Tanggal::buildUnknownFormat($tanggal_lulus);
        }
        $this->tanggal_lulus = $tanggal_lulus;
    }

}