<?php
/**
 * Created by PhpStorm.
 * User: tik_squad
 * Date: 10/8/19
 * Time: 9:21 AM
 */

namespace DedeGunawan\TranskripAkademikUnsil\Templates;


use DedeGunawan\TranskripAkademikUnsil\Interfaces\Template;
use DedeGunawan\TranskripAkademikUnsil\Traits\LanguageSwitcherTrait;
use DedeGunawan\TranskripAkademikUnsil\TranskripAkademikUnsil;
use DedeGunawan\TranskripAkademikUnsil\Utilities\CustomPdf;


/**
 * Class BaseTemplate
 * @package DedeGunawan\TranskripAkademikUnsil\Templates
 * @method setJudul($value)
 * @method getJudul()
 * @method setNomor($value)
 * @method getNomor()
 * @method setNama($value)
 * @method getNama()
 * @method setTempatTanggalLahir($value),
 * @method getTempatTanggalLahir(),
 * @method setNpm($value),
 * @method getNpm(),
 * @method setFakultas($value),
 * @method getFakultas(),
 * @method setProdi($value),
 * @method getProdi(),
 * @method setKonsentrasi($value),
 * @method getKonsentrasi(),
 * @method setStatusAkreditasi($value),
 * @method getStatusAkreditasi(),
 * @method setTanggalLulus($value),
 * @method getTanggalLulus(),
 * @method setJumlahMataKuliah($value),
 * @method getJumlahMataKuliah(),
 * @method setJumlahTotal($value),
 * @method getJumlahTotal(),
 * @method setCatatan($value),
 * @method getCatatan(),
 * @method setIpk($value),
 * @method getIpk(),
 * @method setNik($value),
 * @method getNik(),
 * @method setPin($value),
 * @method getPin(),
 * @method setPredikatKelulusan($value),
 * @method getPredikatKelulusan(),
 */
class BaseTemplate implements Template
{
    use LanguageSwitcherTrait;
    protected $options=[
        'judul' => "TRANSKRIP AKADEMIK",
        'nomor' => "Nomor : ",

        'nama' => 'N a m a',
        'tempat_tanggal_lahir' => 'Tempat, Tanggal Lahir',
        'npm' => "Nomor Pokok Mahasiswa",
        'fakultas' => 'Fakultas',
        'prodi' => 'Program Studi',
        'konsentrasi' => 'Konsentrasi',
        'status_akreditasi' => 'Status Akreditasi',
        'tanggal_lulus' => 'Tanggal Lulus',

        'jumlah_mata_kuliah' => 'Jumlah Mata Kuliah : ',
        'jumlah_total' => 'Jumlah Total :',
        'catatan' => 'Catatan : Bila ada pencoretan nilai bagaimanapun bentuknya/alasannya, maka transkrip ini dinyatakan tidak sah',

        'ipk' => 'Indeks Prestasi Kumulatif (IPK) = ',
        'predikat_kelulusan' => 'Predikat Kelulusan : ',
        'nik' => 'NIK',
        'pin' => 'PIN',

        'with_header' => true,
        'with_footer' => true
    ];

    protected $optionsEn = [
        'judul' => 'TRANSCRIPT ACADEMIC',

        'nama' => 'Grants Certificate to',
        'tempat_tanggal_lahir' => 'Place, Date of Birth',
        'npm' => "Student Register Number",
        'fakultas' => 'Faculty',
        'prodi' => 'Program',
        'konsentrasi' => 'Concentration',
        'status_akreditasi' => 'Acreditation Status',
        'tanggal_lulus' => 'Graduate Date',
        'nik' => 'NIK',
        'pin' => 'PIN',

        'jumlah_mata_kuliah' => 'Number of Subjects : ',
        'jumlah_total' => 'Total Number :',
        'catatan' => 'Notes : If there is deletion value anyway shape / reason, then the transcript is declared invalid',

        'ipk' => 'Grade Point Average (GPA) = ',
        'predikat_kelulusan' => 'Predicates Graduation : ',

    ];

    protected static $pdf;

    public static function getPdf()
    {
        if (self::$pdf==null) {
            self::$pdf = new CustomPdf();
        }
        return self::$pdf;
    }

    public function BuatHeaderTranskrip()
    {
        $transkrip_akademik = TranskripAkademikUnsil::getInstance();
        $mahasiswa = $transkrip_akademik->getMahasiswa();
        $konsentrasi = $transkrip_akademik->getKonsentrasi();

        $p = self::getPdf();

        $lbr = 195;
        $p->SetFont('Helvetica', 'B', 12);
        $p->Ln(7);
        $this->getJudul();
        $p->Cell($lbr, 7, $this->getJudul(), 0, 1, 'C');

        $p->SetFont('Helvetica', '', 9);
        //$p->Cell(184,2,'Nomor : '.$nomor.' / UN58 / PP.03.01 / '.$bln.' / '.$tahun,0,1,'C');
        //$p->Cell(184,3,'',0,1,'C');
        $p->Cell($lbr, 2, $this->getNomor().$transkrip_akademik->getNomorTranskrip(), 0, 1, 'C');
        $p->Cell($lbr, 3, '', 0, 1, 'C');
        $p->Cell(184, 1.5, '', 0, 1, 'C');



        $arr   = array();
        $arr[] = array(
            $this->getNama(),
            ':',
            strtoupper($mahasiswa->getNamaMahasiswa())
        );
        $arr[] = array(
            $this->getTempatTanggalLahir(),
            ':',
            strtoupper($mahasiswa->getTempatTanggalLahir())
        );
        $arr[] = array(
            $this->getNpm(),
            ':',
            TranskripAkademikUnsil::getInstance()->getNpm()
        );
        $arr[] = array(
            $this->getFakultas(),
            ':',
            strtoupper($konsentrasi->getNamaFakultas())
        );
        $arr[] = array(
            $this->getProdi(),
            ':',
            strtoupper($konsentrasi->getNamaProdi())
        );

        if (!empty($konsentrasi) && $konsentrasi->getNamaKonsentrasi()) {
            $arr[] = array(
                $this->getKonsentrasi(),
                ':',
                ucwords(strtolower($konsentrasi->getNamaKonsentrasi()))
            );
            $t = 3.6;
        } else {
            $t = 4;
        }
        $arr[] = array(
            $this->getStatusAkreditasi(),
            ':',
            strtoupper($konsentrasi->getStatusAkreditasi())
        );

        $arr[] = array(
            $this->getTanggalLulus(),
            ':',
            strtoupper($transkrip_akademik->getKelulusan()->getTanggalLulus()->getFormatTextualMonth())
        );
        $arr[] = array(
            $this->getNik(),
            ':',
            strtoupper($mahasiswa->getNik())
        );
        if ($mahasiswa->getPin())
        {
            $arr[] = array(
                $this->getPin(),
                ':',
                strtoupper($mahasiswa->getPin())
            );
        }

        //HEADER NAMA
        foreach ($arr as $a) {
            // Kolom 1
            $p->SetFont('Helvetica', '', 8.5);
            $p->SetX(27);
            $p->Cell(50, $t, @$a[0], 0, 0);
            $p->Cell(3, $t, @$a[1], 0, 0);
            $p->SetFont('Helvetica', 'B', 8.5);
            $p->Cell(70, $t, @$a[2], 0, 0);
            $p->Cell(10);
            // Kolom 2
            $p->SetFont('Helvetica', '', 8.5);
            $p->Cell(30, $t, @$a[3], 0, 0);
            $p->Cell(3, $t, @$a[4], 0, 0);
            $p->SetFont('Helvetica', 'B', 8.5);
            $p->Cell(50, $t, @$a[5], 0, 0);
            $p->Ln($t);
        }

    }

    public function BuatHeaderKolom()
    {
        $p = self::getPdf();
        //garis kolom 1
        if ($this->getOption('with_header')) {
            $p->setXY(15.5, 90);
        } else {
            $p->setX(15.5);
        }
        $p->Cell(7, 176, '', "LTR", 0, 'C'); // NO
        $p->Cell(20, 176, '', "LTR", 0, 'C'); //KODE MK
        $p->Cell(110, 176, '', "LTR", 0, 'C'); //NAMA MK
        $p->Cell(12, 176, '', "LTR", 0, 'C'); //SKS
        $p->Cell(12, 176, '', "LTR", 0, 'C');
        $p->Cell(12, 176, '', "LTR", 0, 'C');
        $p->Cell(12, 176, '', "LTR", 0, 'C');

        //garis kolom 2
        /*$p->setXY(108,100);
        $p->Cell(4, 122.75, '', 1, 0, 'C'); // NO
        $p->Cell(14.5, 122.75, '', 1, 0, 'C'); //KODE MK
        $p->Cell(63.5, 122.75, '', 1, 0, 'C'); //NAMA MK
        $p->Cell(5, 122.75, '', 1, 0, 'C'); //SKS
        $p->Cell(5.25, 122.75, '', 1, 0, 'C');  //HURUF
        $p->Cell(5, 122.75, '', 1, 0, 'C');
        $p->Cell(5, 122.75, '', 1, 0, 'C');
        */

        //<---  KOORDINAT HEADER TABEL KIRI
        if ($this->getOption('with_header')) {
            $p->setXY(15.5, 83);
        } else {
            $p->setX(15.5);
        }

        // Judul tabel [1]
        $t = 7;
        $p->SetFont('Helvetica', 'B', 6.5);

//        //jika versi Eng
//        $p->Cell(7, $t, 'NO', 1, 0, 'C');
//        $p->Cell(20, $t, 'KODE MK', 1, 0, 'C');
//        $p->Cell(110, $t, 'MATA KULIAH', 1, 0, 'C');
//        $p->Cell(12, $t, 'SKS', 1, 0, 'C');
//        $p->Cell(12, $t / 2, 'HURUF', 'TLR', 0, 'C');
//        $p->Cell(12, $t / 2, 'ANGKA', 'TLR', 0, 'C');
//        $p->Cell(12, $t, 'JML', 1, 0, 'C');
//        $p->Cell(0, $t / 2, '', 0, 1, 'C');
//        $p->Cell(154.5, $t, '', 0, 0, 'C');
//        $p->Cell(12, $t / 2, 'MUTU', 'BLR', 0, 'C');
//        $p->Cell(12, $t / 2, 'MUTU', 'BLR', 0, 'C');
//        $p->Ln($t);

        if ($this->getLanguage()=='en') {
            $p->Cell(7, $t, 'NO', 1, 0, 'C');
            $p->Cell(20, $t, 'SUBJECT CODES', 1, 0, 'C');
            $p->Cell(110, $t, 'SUBJECTS', 1, 0, 'C');
            $p->Cell(12, $t, 'CREDITS', 1, 0, 'C');
            $p->Cell(12, $t, 'GRADES', 'TLR', 0, 'C');
            $p->Cell(12, $t, 'SCORE', 'TLR', 0, 'C');
            $p->Cell(12, $t, 'POINT', 1, 0, 'C');

            $p->Ln($t);
        } else {
            $p->Cell(7, $t, 'NO', 1, 0, 'C');
            $p->Cell(20, $t, 'KODE MK', 1, 0, 'C');
            $p->Cell(110, $t, 'MATA KULIAH', 1, 0, 'C');
            $p->Cell(12, $t, 'SKS', 1, 0, 'C');
            $p->Cell(12, $t / 2, 'HURUF', 'TLR', 0, 'C');
            $p->Cell(12, $t / 2, 'ANGKA', 'TLR', 0, 'C');
            $p->Cell(12, $t, 'JML', 1, 0, 'C');
            $p->Cell(0, $t / 2, '', 0, 1, 'C');
            $p->Cell(154.3, $t, '', 0, 0, 'C');
            $p->Cell(12, $t / 2, 'MUTU', 'BLR', 0, 'C');
            $p->Cell(12, $t / 2, 'MUTU', 'BLR', 0, 'C');
            $p->Ln($t);
        }
    }

    public function BuatIsiTranskrip()
    {
        $transkrip_akademik = TranskripAkademikUnsil::getInstance();
        $krs_collection = $transkrip_akademik->getKrsCollection();

        $p = self::getPdf();


        $p->SetFont('Helvetica', '', 6.25);

        // <---  KOORDINAT ISI TABEL KIRI
        if ($this->getOption('with_header')) {
            $p->setXY(15.5, 90.5);
        } else {
            $p->setX(15.5);
        }

        $ti = $this->getTinggiBaris();

        foreach ($krs_collection as $n => $krs) {
            $p->setX(15.5);
            $p->Cell(7, $ti, $n+1, 'L', 0, 'C');
            $p->Cell(20, $ti, $krs['kode_matakuliah'], 'L', 0, 'C');
            $p->Cell(110, $ti, $krs['nama_matakuliah'], 'L', 0);
            $p->Cell(12, $ti, $krs['sks'], 'L', 0, 'C');
            $p->Cell(12, $ti, $krs['huruf_mutu'], 'L', 0, 'C');
            $p->Cell(12, $ti, number_format($krs['angka_mutu'], 2, ".", ","), 'L', 0, 'C');
            $p->Cell(12, $ti, $krs->getJumlahBobot(), 'LR', 0, 'C');
            $p->Ln($ti);
        }

        $this->BuatFooterIsiTranskrip();

    }

    public function BuatFooterIsiTranskrip()
    {
        $p = self::getPdf();
        $transkrip_akademik = TranskripAkademikUnsil::getInstance();
        $krs_collection = $transkrip_akademik->getKrsCollection();


        if ($this->getOption('with_header')) {
            $p->setXY(15.5, 266);
        } else {
            $p->setX(15.5);
        }

        // Jumlah matakuliah
        $p->SetFont('Helvetica', 'B', 6.5);
        $p->Cell(92.5, 4.5, $this->getJumlahMataKuliah() . $krs_collection->count(), 1, 0, 'C');

        $t = 4.5;

        if ($this->getOption('with_header')) {
            $p->setXY(108, 266);
        } else {
            $p->setX(108);
        }


        $p->SetFont('Helvetica', 'B', 6.5);
        $p->Cell(44.5, $t, $this->getJumlahTotal(), 'BT', 0, 'R');

        $p->Cell(12, $t, $krs_collection->getTotalSks(), 'BT', 0, 'C');
        $p->Cell(12, $t, '', 'BT', 0);
        $p->Cell(12, $t, '', 'BT', 0);
        $p->Cell(12, $t, $krs_collection->getTotalBobot(), 'BRT', 0, 'C');
        $p->Ln(5);
    }

    public function BuatFooterTranskrip()
    {
        $p = self::getPdf();
        $transkrip_akademik = TranskripAkademikUnsil::getInstance();
        $mahasiswa = $transkrip_akademik->getMahasiswa();
        $t = 4;

        $p->SetFont('Helvetica', 'I', 7);
        $p->setX(15);
        $p->Cell(125, $t, $this->getCatatan(), 0, 1, 'L');


        $p->Ln(1);

        $p->SetFont('Helvetica', 'B', 8);
        $p->Cell(15, $t, '', 0, 0, 'L');
        //jika versi Eng
        $p->Cell(50, $t, $this->getIpk(). $transkrip_akademik->getKelulusan()->getIpk(), 0, 0, 'L');
        $p->Cell(59, $t, '', 0, 0, 'L');
        $p->Cell(50, $t, $this->getPredikatKelulusan() . $transkrip_akademik->getKelulusan()->getPredikat(), 0, 1, 'L');

        //jika versi Eng
        if ($this->getLanguage()=='en') {
            $ml  = 25;
            $js  = 'Title of Thesis :';
            $ex  = 50;
            $leb = 150;
        } else {
            $transkrip_akademik = TranskripAkademikUnsil::getInstance();
            $npm = $transkrip_akademik->getNpm();
            $isTeknik = substr($npm, 2, 2)=='70';
            $isPerbankan = substr($npm, 2, 4)=='3404';
            if ($isTeknik || $isPerbankan) {
                $ml  = 25;
                $js  = 'Judul Skripsi/Tugas Akhir :';
                $ex  = 65;
                $leb = 135;
            } else {
                $ml  = 25;
                $js  = 'Judul Skripsi :';
                $ex  = 50;
                $leb = 150;
            }
        }

        $lbr = 20;
        $p->SetFont('Helvetica', '', 8);
        $p->Cell($lbr, 5, '', 0, 1, 'L');
        $p->SetXY($ml, 282);
        $p->Cell(190, $t, $js, 0, 0, 'L');
        $p->Cell(190, 1, '', 0, 1, 'C');
        $p->SetXY($ex - 5, 281);

        $t = 3; //ENTER BUAT JUDUL
        $p->SetFont('Helvetica', '', 7);


        $formatJudul = function($text) {
            $text = trim($text);
            $text = strtolower($text);
            $textArray = explode(" ", $text);
            $arraySize = count($textArray);
            for($i=0;$i<$arraySize;$i++) {
                $current = $textArray[$i];
                $next = @$textArray[$i+1];
                $current = ucfirst($current);
                $textArray[$i] = $current;
            }
            $datas = implode(" ", $textArray);
            $datas = explode("++", $datas);
            $lengthDatas = count($datas);
            for ($i=0; $i < $lengthDatas; $i++) {
                if ($i%2 == 1) {
                    $datas[$i] = strtoupper($datas[$i]);
                }
            }
            $datas = implode("", $datas);
            $datas = explode("--", $datas);
            $lengthDatas = count($datas);
            for ($i=0; $i < $lengthDatas; $i++) {
                if ($i%2 == 1) {
                    $datas[$i] = strtolower($datas[$i]);
                }
            }
            return implode("", $datas);
        };

        // $judul = $formatJudul($judul);

        //$p->MultiCell($leb + 5, $t, $judul, 0, 'J');

        $enterX=$p->GetX();

        $cetakJudulIjazah = function ($text) use($enterX, $p) {
            $maxPosition = 200;
            $boldToken = "**";
            $italicToken = "__";
            $textArray = explode(" ", $text);
            $arraySize = count($textArray);
            $onBold = 0;
            $onItalic = 0;
            for ($i=0; $i < $arraySize; $i++) {
                $current = $textArray[$i];
                $isBoldToken = $current == $boldToken;
                if ($isBoldToken) $onBold = !$onBold;

                $isItalicToken = $current == $italicToken;
                if ($isItalicToken) $onItalic = !$onItalic;

                if ($isBoldToken || $isItalicToken) continue;

                $format = '';
                $format .= $onBold ? "B" : "";
                $format .= $onItalic ? "I" : "";
                $p->SetFont('Helvetica',$format,7);
                $current = $current." ";
                if ($p->GetX()+$p->GetStringWidth($current) > 199) {
                    $p->Ln();
                    $p->SetX($enterX);
                }
                $p->Cell($p->GetStringWidth($current),3,$current, 0, 'L');

            }

        };

        $cetakJudulIjazah($transkrip_akademik->getKelulusan()->getJudul());

        $p->SetAutoPageBreak(false);
        $p->SetFont('Helvetica', '', 8);
        $t = 3.5; //ENTER BUAT  SETELAH JUDUL
        $p->SetXY(144, 293);


        $p->Cell($lbr, $t, $transkrip_akademik->getKotaCetak(). ', ' . $transkrip_akademik->getTanggalCetak()->getFormatTextualMonth(), 0, 1, 'L');

        $p->Ln(1);

        $kanan = $transkrip_akademik->getTandaTanganKanan();
        $kiri = $transkrip_akademik->getTandaTanganKiri();


        $p->Cell(20, $t, '', 0, 0, 'L');
        $p->Cell(114, $t, $kiri->getNamaJabatan() . ',', 0, 0, 'L');
        $p->Cell(50, $t, $kanan->getNamaJabatan() . ',', 0, 1, 'L');
        $p->SetXY(10, 317);
        $p->SetFont('Helvetica', 'B', 8);
        $p->Cell(20, $t, '', 0, 0, 'L');
        $p->Cell(114, $t, $kiri->getNamaPejabat(), 0, 0, 'L');
        $p->Cell(50, $t, $kanan->getNamaPejabat(), 0, 1, 'L');
        $p->SetFont('Helvetica', '', 8);
        $p->Cell(19.9, $t, '', 0, 0, 'L');
        $p->Cell(114, $t, '' . $kiri->getNipPejabat(), 0, 0, 'L');
        $p->Cell(50, $t, '' . $kanan->getNipPejabat(), 0, 1, 'L');

        $p->SetXY(110, 295);
        $p->Cell(15, 20, 'FOTO', 1, 0, 'C');
    }

    public function getTinggiBaris()
    {
        $ju = TranskripAkademikUnsil::getInstance()->getKrsCollection()->count();
        if ($ju == 68) {
            $ti = 2.57;
        } elseif ($ju == 67) {
            $ti = 2.6;
        } elseif ($ju == 66) {
            $ti = 2.65;
        } elseif ($ju == 65) {
            $ti = 2.7;
        } elseif ($ju == 64) {
            $ti = 2.74;
        } elseif ($ju == 63) {
            $ti = 2.77;
        } elseif ($ju == 62) {
            $ti = 2.82;
        } elseif ($ju == 61) {
            $ti = 2.865;
        } elseif ($ju == 60) {
            $ti = 2.92;
        } elseif ($ju == 59) {
            $ti = 2.97;
        } elseif ($ju == 58) {
            $ti = 3.02;
        } elseif ($ju == 57) {
            $ti = 3.07;
        } elseif ($ju == 56) {
            $ti = 3.13;
        } elseif ($ju == 55) {
            $ti = 3.18;
        } elseif ($ju == 54) {
            $ti = 3.235;
        } elseif ($ju == 53) {
            $ti = 3.3;
        } elseif ($ju == 52) {
            $ti = 3.36;
        } elseif ($ju == 51) {
            $ti = 3.43;
        } elseif ($ju == 50) {
            $ti = 3.5;
        } else {
            $ti = 3.56;
        }
        $ti = 3.56;
        return $ti;
    }

    public function render()
    {
        self::getPdf()->SetTitle("Transkrip Nilai");
        self::getPdf()->AddPage();
        if ($this->getOption('with_header')) $this->BuatHeaderTranskrip();
        $this->BuatHeaderKolom();
        $this->BuatIsiTranskrip();
        if ($this->getOption('with_footer')) $this->BuatFooterTranskrip();
        self::getPdf()->Output();
    }


    public function __construct()
    {
        if ($this->getLanguage()=='en') {
            $this->options = array_merge($this->options, $this->optionsEn);

        }
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }
    /**
     * @param mixed $key
     * @return mixed
     */
    public function getOption($key)
    {
        return $this->options[$key];
    }

    /**
     * @param mixed $key
     * @param mixed $value
     */
    public function setOption($key, $value)
    {
        $this->options[$key] = $value;
    }

    public function hasOption($key)
    {
        return array_key_exists($key);
    }

    public function __call($name, $arguments)
    {
        $reflection = new \ReflectionClass(get_called_class());
        if ($reflection->hasMethod($name)) return call_user_func_array(array($this, $name), $arguments);

        $sneak = $this->from_camel_case($name);
        $get = substr($sneak, 0, 4)=='get_';
        $set = substr($sneak, 0, 4)=='set_';
        $key = substr($sneak, 4);
        if ($get) return $this->getOption($key);
        if ($set) {
            array_unshift($arguments, $key);
            return call_user_func_array(array($this, 'setOption'), $arguments);
        }
        return NULL;

    }

    public function from_camel_case($input)
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }


}
