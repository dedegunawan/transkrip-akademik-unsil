<?php
/**
 * Created by PhpStorm.
 * User: tik_squad
 * Date: 10/8/19
 * Time: 8:40 AM
 */

namespace DedeGunawan\TranskripAkademikUnsil\Entities;


use DedeGunawan\TranskripAkademikUnsil\Traits\LanguageSwitcherTrait;

class Tanggal extends BaseEntity
{
    use LanguageSwitcherTrait;
    protected $tanggal;
    protected $bulan;
    protected $tahun;
    protected $object;

    /**
     * @return mixed
     */
    public function getTanggal()
    {
        return $this->tanggal;
    }

    /**
     * @param mixed $tanggal
     */
    public function setTanggal($tanggal)
    {
        $this->tanggal = $tanggal;
        $this->rebuildObject();
    }

    /**
     * @return mixed
     */
    public function getBulan()
    {
        return $this->bulan;
    }

    /**
     * @param mixed $bulan
     */
    public function setBulan($bulan)
    {
        $this->bulan = $bulan;
        $this->rebuildObject();
    }

    /**
     * @return mixed
     */
    public function getTahun()
    {
        return $this->tahun;
    }

    /**
     * @param mixed $tahun
     */
    public function setTahun($tahun)
    {
        $this->tahun = $tahun;
        $this->rebuildObject();
    }

    /**
     * @return \DateTime
     */
    public function getObject()
    {
        if (!$this->object instanceof \DateTime) $this->rebuildObject();
        return $this->object;
    }

    public function rebuildObject()
    {
        if ($this->getTanggal() && $this->getBulan() && $this->getTanggal()) {
            $this->object = \DateTime::createFromFormat(
                'Y-m-d',
                $this->getTahun()."-".$this->getBulan().'-'.$this->getTanggal()
            );
        }
    }

    public function getWithFormat($format)
    {
        $Flocation = strpos($format, "F");
        $hasF = $Flocation!==false;
        $formetter = $this->getObject()->format($format);
        if ($hasF && $this->getLanguage()=='id') return $this->changeFFunction($formetter);
        return $formetter;
    }

    public static function getListBulan()
    {
        return array(
            'January' => 'Januari',
            'February' => 'Pebruari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember',
        );
    }

    public function changeFFunction($formatter)
    {
        $FIndonesias = self::getListBulan();
        foreach ($FIndonesias as $key => $FIndonesia) {
            $formatter = str_replace($key, $FIndonesia, $formatter);
        }
        return $formatter;
    }


    public function getFormatYmd()
    {
        return $this->getWithFormat("Y-m-d");
    }
    public function getFormatTextualMonth()
    {
        return $this->getWithFormat("d F Y");
    }

    public static function setLocaleIndonesia()
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            setlocale (LC_TIME, 'INDONESIA');
        } else {
            setlocale (LC_TIME, 'id_ID');
        }
    }

    public static function buildWithFormat($format, $plain)
    {
        $dateTime = \DateTime::createFromFormat(
            $format,
            $plain
        );
        return self::build([
            'tanggal' => $dateTime->format("d"),
            'bulan' => $dateTime->format("m"),
            'tahun' => $dateTime->format("Y"),
        ]);
    }
    public static function buildFormatYmd($plain)
    {
        return self::buildWithFormat("Y-m-d", $plain);
    }

    public static function buildUnknownFormat($plain)
    {
        $dateTime = new \DateTime($plain);
        return self::build([
            'tanggal' => $dateTime->format("d"),
            'bulan' => $dateTime->format("m"),
            'tahun' => $dateTime->format("Y"),
        ]);
    }

    public function isToday()
    {
        return date('Y-m-d')==$this->getFormatYmd();
    }

    public static function getRomawiBulan($bulan)
    {
        $bln="";
        $bulan = (int) $bulan;
        if ($bulan == 1) {
            $bln = 'I';
        } elseif ($bulan == 2) {
            $bln = 'II';
        } elseif ($bulan == 3) {
            $bln = 'III';
        } elseif ($bulan == 4) {
            $bln = 'IV';
        } elseif ($bulan == 5) {
            $bln = 'V';
        } elseif ($bulan == 6) {
            $bln = 'VI';
        } elseif ($bulan == 7) {
            $bln = 'VII';
        } elseif ($bulan == 8) {
            $bln = 'VIII';
        } elseif ($bulan == 9) {
            $bln = 'IX';
        } elseif ($bulan == 10) {
            $bln = 'X';
        } elseif ($bulan == 11) {
            $bln = 'XI';
        } elseif ($bulan == 12) {
            $bln = 'XII';
        }
        return $bln;
    }

}