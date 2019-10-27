<?php
/**
 * Created by PhpStorm.
 * User: tik_squad
 * Date: 10/8/19
 * Time: 8:43 AM
 */

namespace DedeGunawan\TranskripAkademikUnsil\Entities;


class Krs extends BaseEntity
{
    protected $id_matakuliah;
    protected $kode_matakuliah;
    protected $nama_matakuliah;
    protected $sks;
    protected $huruf_mutu;
    protected $angka_mutu;

    /**
     * @return mixed
     */
    public function getIdMatakuliah()
    {
        return $this->id_matakuliah;
    }

    /**
     * @param mixed $id_matakuliah
     */
    public function setIdMatakuliah($id_matakuliah)
    {
        $this->id_matakuliah = $id_matakuliah;
    }

    /**
     * @return mixed
     */
    public function getKodeMatakuliah()
    {
        return $this->kode_matakuliah;
    }

    /**
     * @param mixed $kode_matakuliah
     */
    public function setKodeMatakuliah($kode_matakuliah)
    {
        $this->kode_matakuliah = $kode_matakuliah;
    }

    /**
     * @return mixed
     */
    public function getNamaMatakuliah()
    {
        return $this->nama_matakuliah;
    }

    /**
     * @param mixed $nama_matakuliah
     */
    public function setNamaMatakuliah($nama_matakuliah)
    {
        $this->nama_matakuliah = $nama_matakuliah;
    }

    /**
     * @return mixed
     */
    public function getSks()
    {
        return $this->sks;
    }

    /**
     * @param mixed $sks
     */
    public function setSks($sks)
    {
        $this->sks = $sks;
    }

    /**
     * @return mixed
     */
    public function getHurufMutu()
    {
        return $this->huruf_mutu;
    }

    /**
     * @param mixed $huruf_mutu
     */
    public function setHurufMutu($huruf_mutu)
    {
        $this->huruf_mutu = $huruf_mutu;
    }

    /**
     * @return mixed
     */
    public function getAngkaMutu()
    {
        return $this->angka_mutu;
    }

    /**
     * @param mixed $angka_mutu
     */
    public function setAngkaMutu($angka_mutu)
    {
        $this->angka_mutu = $angka_mutu;
    }

    /**
     * @return float|int
     */
    public function getJumlahBobot()
    {
        return $this->getAngkaMutu()*$this->getSks();
    }


}