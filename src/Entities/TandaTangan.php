<?php
/**
 * Created by PhpStorm.
 * User: tik_squad
 * Date: 10/8/19
 * Time: 8:57 AM
 */

namespace DedeGunawan\TranskripAkademikUnsil\Entities;


class TandaTangan extends BaseEntity
{
    protected $nama_jabatan;
    protected $nama_pejabat;
    protected $nip_pejabat;
    protected $url_tanda_tangan;

    /**
     * @return mixed
     */
    public function getNamaJabatan()
    {
        return $this->nama_jabatan;
    }

    /**
     * @param mixed $nama_jabatan
     */
    public function setNamaJabatan($nama_jabatan)
    {
        $this->nama_jabatan = $nama_jabatan;
    }

    /**
     * @return mixed
     */
    public function getNamaPejabat()
    {
        return $this->nama_pejabat;
    }

    /**
     * @param mixed $nama_pejabat
     */
    public function setNamaPejabat($nama_pejabat)
    {
        $this->nama_pejabat = $nama_pejabat;
    }

    /**
     * @return mixed
     */
    public function getNipPejabat()
    {
        return $this->nip_pejabat;
    }

    /**
     * @param mixed $nip_pejabat
     */
    public function setNipPejabat($nip_pejabat)
    {
        $this->nip_pejabat = $nip_pejabat;
    }

    /**
     * @return mixed
     */
    public function getUrlTandaTangan()
    {
        return $this->url_tanda_tangan;
    }

    /**
     * @param mixed $url_tanda_tangan
     */
    public function setUrlTandaTangan($url_tanda_tangan)
    {
        $this->url_tanda_tangan = $url_tanda_tangan;
    }

}