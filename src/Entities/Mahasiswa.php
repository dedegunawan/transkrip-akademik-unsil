<?php
/**
 * Created by PhpStorm.
 * User: tik_squad
 * Date: 10/8/19
 * Time: 9:13 AM
 */

namespace DedeGunawan\TranskripAkademikUnsil\Entities;


class Mahasiswa extends BaseEntity
{
    protected $npm;
    protected $nama_mahasiswa;
    protected $tempat_lahir;
    protected $nik;
    protected $pin;
    /**
     * @var $tanggal_lahir Tanggal
     */
    protected $tanggal_lahir;

    protected $url_foto;

    /**
     * @return mixed
     */
    public function getNpm()
    {
        return $this->npm;
    }

    /**
     * @param mixed $npm
     */
    public function setNpm($npm)
    {
        $this->npm = $npm;
    }

    /**
     * @return mixed
     */
    public function getNamaMahasiswa()
    {
        return $this->nama_mahasiswa;
    }

    /**
     * @param mixed $nama_mahasiswa
     */
    public function setNamaMahasiswa($nama_mahasiswa)
    {
        $this->nama_mahasiswa = $nama_mahasiswa;
    }

    /**
     * @return mixed
     */
    public function getTempatLahir()
    {
        return $this->tempat_lahir;
    }

    /**
     * @param mixed $tempat_lahir
     */
    public function setTempatLahir($tempat_lahir)
    {
        $this->tempat_lahir = $tempat_lahir;
    }

    /**
     * @return Tanggal
     */
    public function getTanggalLahir(): Tanggal
    {
        return $this->tanggal_lahir;
    }

    /**
     * @param Tanggal $tanggal_lahir
     */
    public function setTanggalLahir($tanggal_lahir)
    {

        if (!$tanggal_lahir instanceof Tanggal) {
            $tanggal_lahir = Tanggal::buildUnknownFormat($tanggal_lahir);
        }
        $this->tanggal_lahir = $tanggal_lahir;
    }

    /**
     * @return mixed
     */
    public function getUrlFoto()
    {
        return $this->url_foto;
    }

    /**
     * @param mixed $url_foto
     */
    public function setUrlFoto($url_foto)
    {
        $this->url_foto = $url_foto;
    }

    /**
     * @return mixed
     */
    public function getNik()
    {
        return $this->nik;
    }

    /**
     * @param mixed $nik
     */
    public function setNik($nik): void
    {
        $this->nik = $nik;
    }

    /**
     * @return mixed
     */
    public function getPin()
    {
        return $this->pin;
    }

    /**
     * @param mixed $pin
     */
    public function setPin($pin): void
    {
        $this->pin = $pin;
    }



    public function getTempatTanggalLahir()
    {
        Tanggal::setLocaleIndonesia();
        return sprintf(
            "%s, %s",
            $this->getTempatLahir(),
            $this->getTanggalLahir()->getFormatTextualMonth()
        );
    }

}
