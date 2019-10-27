<?php
/**
 * Created by PhpStorm.
 * User: tik_squad
 * Date: 10/14/19
 * Time: 11:25 AM
 */

namespace DedeGunawan\TranskripAkademikUnsil\Services\Resolver;


use DedeGunawan\TranskripAkademikUnsil\Collections\KrsCollection;
use DedeGunawan\TranskripAkademikUnsil\Entities\Kelulusan;
use DedeGunawan\TranskripAkademikUnsil\Entities\Konsentrasi;
use DedeGunawan\TranskripAkademikUnsil\Entities\Mahasiswa;
use DedeGunawan\TranskripAkademikUnsil\Entities\TandaTangan;
use DedeGunawan\TranskripAkademikUnsil\Entities\Tanggal;
use DedeGunawan\TranskripAkademikUnsil\Exceptions\NpmException;
use DedeGunawan\TranskripAkademikUnsil\Interfaces\ResolverInterface;
use DedeGunawan\TranskripAkademikUnsil\Traits\LanguageSwitcherTrait;
use DedeGunawan\TranskripAkademikUnsil\TranskripAkademikUnsil;

class MysqliResolver implements ResolverInterface
{
    use LanguageSwitcherTrait;
    protected $transkripAkademikUnsil;
    public function resolve()
    {
        $npm = $this->getTranskripAkademikUnsil()->getNpm();
        if (!$npm) throw new NpmException();

        $this->stopIfNotLulus();

        $this->setupNomorTranskrip();

        $this->setupKonsentrasi();

        $this->setupMahasiswa();

        $this->getTranskripAkademikUnsil()->setTanggalCetak(Tanggal::buildUnknownFormat("2019-10-20"));

        $this->getTranskripAkademikUnsil()->setKotaCetak("Tasikmalaya");

        $this->setupDefaultTandaTangan();

        $this->setupKrsCollection();

    }

    public function setupMahasiswa()
    {
        $npm = $this->getTranskripAkademikUnsil()->getNpm();
        $database = $this->getTranskripAkademikUnsil()->getConnectionManager()->getConnection();
        $mhsw = $database->selectOne("
            SELECT 
            mhsw.MhswID as npm, mhsw.Nama as nama_mahasiswa, mhsw.TempatLahir as tempat_lahir,
            mhsw.TanggalLahir as tanggal_lahir, 
            IF(mhsw.FotoWisuda IS NULL OR mhsw.FotoWisuda='', mhsw.Foto, mhsw.FotoWisuda) as url_foto
            FROM mhsw WHERE MhswID='$npm' and StatusMhswID='L' 
        ");
        $mhsw['url_foto'] = "https://simak.unsil.ac.id/".(stripos($mhsw['url_foto'], 'us-unsil')===false?'us-unsil':'')."/".$mhsw['url_foto'];
        $mahasiswa = Mahasiswa::build($mhsw);
        $this->getTranskripAkademikUnsil()->setMahasiswa($mahasiswa);
    }

    public function stopIfNotLulus()
    {
        $npm = $this->getTranskripAkademikUnsil()->getNpm();
        $database = $this->getTranskripAkademikUnsil()->getConnectionManager()->getConnection();
        $mhsw = $database->query("SELECT * FROM mhsw WHERE MhswID='$npm' and StatusMhswID='L' ")->num_rows;
        if (!$mhsw) throw new \Exception("Mahasiswa belum lulus");
    }

    public function setupNomorTranskrip()
    {
        $npm = $this->getTranskripAkademikUnsil()->getNpm();
        $database = $this->getTranskripAkademikUnsil()->getConnectionManager()->getConnection();

        $predikat = $database->selectOne(
            "
            SELECT mhsw.IPK, mhsw.predikat FROM mhsw 
            WHERE mhsw.MhswID='$npm' and mhsw.StatusMhswID='L' 
            "
        );

        if (!$predikat) throw new \Exception("Mahasiswa belum dinyatakan lulus");
        if ($this->getLanguage()=='en') {
            $predikatEnglish = $database->selectField("SELECT Nama_en FROM predikat where Nama='".$predikat['predikat']."'");
            if (trim($predikatEnglish)) $predikat['predikat'] = $predikatEnglish;
        }

        $data = $database->selectOne("SELECT ta.noseri,ta.Tgllulus, ta.Judul FROM ta WHERE MhswID='$npm' ");
        $nomor_transkrip = $data['noseri'];
        $tanggal_lulus = $data['Tgllulus'];
        $judul = $data['Judul'];

        $this->getTranskripAkademikUnsil()->setNomorTranskrip($nomor_transkrip);
        $kelulusan = Kelulusan::build([
            'tanggal_lulus' => $tanggal_lulus,
            'ipk' => $predikat['IPK'],
            'predikat' => $predikat['predikat'],
            'judul' => $judul
        ]);
        $this->getTranskripAkademikUnsil()->setKelulusan($kelulusan);
    }

    public function setupKonsentrasi()
    {
        $npm = $this->getTranskripAkademikUnsil()->getNpm();
        $database = $this->getTranskripAkademikUnsil()->getConnectionManager()->getConnection();
        $ProdiID = substr($npm, 2, 4);

        $konsentrasi = $database->selectOne(
            "
            SELECT prodi.ProdiID as kode_prodi, concat(prodi.Nama, ' (', jenjang.Nama, ') ') as nama_prodi, 
            fakultas.Nama as nama_fakultas, fakultas.FakultasID as kode_fakultas, 
            prodi.Akreditasi as status_akreditasi, '' as nama_konsentrasi
            from prodi 
            JOIN fakultas on fakultas.FakultasID=prodi.FakultasID
            join jenjang on jenjang.JenjangID=prodi.JenjangID
            WHERE prodi.ProdiID='$ProdiID'
            "
        );

        // support english language
        if ($this->getLanguage()=='en') {
            $konsentrasi = $database->selectOne(
                "
            SELECT prodi.ProdiID as kode_prodi, 
            concat(IF(prodi.Nama_en <> '' and prodi.Nama_en IS NOT NULL, prodi.Nama_en, prodi.Nama), ' (', jenjang.Nama, ') ') 
            as nama_prodi, 
            fakultas.Nama_en as nama_fakultas, fakultas.FakultasID as kode_fakultas, 
            prodi.Akreditasi as status_akreditasi, '' as nama_konsentrasi
            from prodi 
            JOIN fakultas on fakultas.FakultasID=prodi.FakultasID
            join jenjang on jenjang.JenjangID=prodi.JenjangID
            WHERE prodi.ProdiID='$ProdiID'
            "
            );
        }

        $query = "select DISTINCT(m.KonsentrasiID) as _KonsentrasiID, COUNT(k.KRSID) as _countKID
            from krs k left outer join mk m on m.MKID=k.MKID and m.KodeID='UNSIL'
            where k.MhswID='$npm' and m.KonsentrasiID!=0 and k.KodeID='UNSIL'
            group by m.KonsentrasiID
            order by _countKID DESC";
        $KonsentrasiID = @$database->selectField($query);


        if (!$KonsentrasiID) {
            $konsentrasi_kode = $database->selectField("SELECT KonsentrasiKode from mhsw where MhswID='$npm'");
        } else {
            $konsentrasi_kode = $database->selectField("SELECT KonsentrasiKode from konsentrasi where KonsentrasiID='$KonsentrasiID' and NA='N' and KodeID='UNSIL'");
        }
        $nama_konsentrasi = $database->selectField("SELECT Nama from konsentrasi where KonsentrasiKode='$konsentrasi_kode' and NA='N' and KodeID='UNSIL'");

        if ($this->getLanguage()=='en') {
            $nama_konsentrasi = $database->selectField("
                SELECT IF(Nama_en <> '' and Nama_en IS NOT NULL, Nama_en,Nama) as Nama from konsentrasi 
                where KonsentrasiKode='$konsentrasi_kode' and NA='N' and KodeID='UNSIL'
            ");
        }

        $konsentrasi['nama_konsentrasi'] = $nama_konsentrasi;

        $konsentrasi = Konsentrasi::build($konsentrasi);
        $this->getTranskripAkademikUnsil()->setKonsentrasi($konsentrasi);
    }

    public function setupKrsCollection()
    {
        $npm = $this->getTranskripAkademikUnsil()->getNpm();
        $database = $this->getTranskripAkademikUnsil()->getConnectionManager()->getConnection();
        $ProdiID = substr($npm, 2, 4);

        if ($this->getLanguage()=='en') {
            $s = "select k.KRSID as id_matakuliah, k.MKKode as kode_matakuliah, IF(mk.Nama_en <> '' and mk.Nama_en IS NOT NULL, mk.Nama_en, k.Nama) as nama_matakuliah, 
            k.BobotNilai as angka_mutu, k.GradeNilai as huruf_mutu, k.SKS as sks
            from krs k
            left outer join mk mk on mk.MKID=k.MKID
            where k.MhswID = '$npm'
            and mk.ProdiID = '$ProdiID'
            and k.NA = 'N'
            and k.Tinggi = '*'
            and k.GradeNilai <> '' and k.GradeNilai <> '-'
            GROUP BY k.Nama
            order by mk.Sesi,k.MKKode
            ";
        } else {
            $s = "select k.KRSID as id_matakuliah, k.MKKode as kode_matakuliah, k.Nama as nama_matakuliah, 
            k.BobotNilai as angka_mutu, k.GradeNilai as huruf_mutu, k.SKS as sks
            from krs k
            left outer join mk mk on mk.MKID=k.MKID
            where k.MhswID = '$npm'
            and mk.ProdiID = '$ProdiID'
            and k.NA = 'N'
            and k.Tinggi = '*'
            and k.GradeNilai <> '' and k.GradeNilai <> '-'
            GROUP BY k.Nama
            order by mk.Sesi,k.MKKode
            ";
        }

        $krs_collection = KrsCollection::build($database->selectAll($s));

        $this->getTranskripAkademikUnsil()->setKrsCollection($krs_collection);
    }

    public function setupDefaultTandaTangan()
    {
        $npm = $this->getTranskripAkademikUnsil()->getNpm();
        $database = $this->getTranskripAkademikUnsil()->getConnectionManager()->getConnection();
        $ProdiID = substr($npm, 2, 4);
        $FakultasID = substr($npm, 2, 2);

        if (!$this->getTranskripAkademikUnsil()->getTandaTanganKanan()) {
            $kanan = $database->selectOne("
                SELECT Jabatan as nama_jabatan, Nama as nama_pejabat, NIP as nip_pejabat
                FROM pejabat where Jabatan='Rektor'
            ");
            if (
                $kanan['nama_jabatan']
                && $this->getLanguage()=='en'
                && $this->getNamaJabatanEnglish($kanan['nama_jabatan'])
            ) $kanan['nama_jabatan'] = $this->getNamaJabatanEnglish($kanan['nama_jabatan']);
            $kanan = TandaTangan::build($kanan);
            $this->getTranskripAkademikUnsil()->setTandaTanganKanan($kanan);
        }

        if (!$this->getTranskripAkademikUnsil()->getTandaTanganKiri()) {
            $kiri = $database->selectOne("
                SELECT Jabatan as nama_jabatan, Nama as nama_pejabat, NIP as nip_pejabat
                FROM pejabat where Jabatan='Dekan' 
                and FakultasID = '$FakultasID'
            ");
            if (
                $kiri['nama_jabatan']
                && $this->getLanguage()=='en'
                && $this->getNamaJabatanEnglish($kiri['nama_jabatan'])
            ) $kiri['nama_jabatan'] = $this->getNamaJabatanEnglish($kiri['nama_jabatan']);
            $kiri = TandaTangan::build($kiri);
            $this->getTranskripAkademikUnsil()->setTandaTanganKiri($kiri);
        }
    }

    public function getNamaJabatanEnglish($Jabatan)
    {
        $database = $this->getTranskripAkademikUnsil()->getConnectionManager()->getConnection();
        static $translates = array();
        if (!array_key_exists($Jabatan, $translates) || !trim($translates[$Jabatan])) {
            $translate = $database->selectField("SELECT Jabatan_en from pejabat_translator WHERE Jabatan='$Jabatan'");
            $translates[$Jabatan] = $translate;
        }
        return $translates[$Jabatan];
    }

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