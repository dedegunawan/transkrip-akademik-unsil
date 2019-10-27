<?php
/**
 * Created by PhpStorm.
 * User: tik_squad
 * Date: 10/8/19
 * Time: 9:03 AM
 */

namespace DedeGunawan\TranskripAkademikUnsil\Entities;



class Konsentrasi extends BaseEntity
{
    protected $status_akreditasi;
    protected $nama_konsentrasi;
    protected $kode_prodi;
    protected $nama_prodi;
    protected $kode_fakultas;
    protected $nama_fakultas;

    /**
     * @return mixed
     */
    public function getStatusAkreditasi()
    {
        return $this->status_akreditasi;
    }

    /**
     * @param mixed $status_akreditasi
     */
    public function setStatusAkreditasi($status_akreditasi)
    {
        $this->status_akreditasi = $status_akreditasi;
    }

    /**
     * @return mixed
     */
    public function getNamaKonsentrasi()
    {
        return $this->nama_konsentrasi;
    }

    /**
     * @param mixed $nama_konsentrasi
     */
    public function setNamaKonsentrasi($nama_konsentrasi)
    {
        $this->nama_konsentrasi = $nama_konsentrasi;
    }

    /**
     * @return mixed
     */
    public function getKodeProdi()
    {
        return $this->kode_prodi;
    }

    /**
     * @param mixed $kode_prodi
     */
    public function setKodeProdi($kode_prodi)
    {
        $this->kode_prodi = $kode_prodi;
    }

    /**
     * @return mixed
     */
    public function getNamaProdi()
    {
        return $this->nama_prodi;
    }

    /**
     * @param mixed $nama_prodi
     */
    public function setNamaProdi($nama_prodi)
    {
        $this->nama_prodi = $nama_prodi;
    }

    /**
     * @return mixed
     */
    public function getKodeFakultas()
    {
        return $this->kode_fakultas;
    }

    /**
     * @param mixed $kode_fakultas
     */
    public function setKodeFakultas($kode_fakultas)
    {
        $this->kode_fakultas = $kode_fakultas;
    }

    /**
     * @return mixed
     */
    public function getNamaFakultas()
    {
        return $this->nama_fakultas;
    }

    /**
     * @param mixed $nama_fakultas
     */
    public function setNamaFakultas($nama_fakultas)
    {
        $this->nama_fakultas = $nama_fakultas;
    }



}