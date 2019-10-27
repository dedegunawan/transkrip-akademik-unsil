<?php
/**
 * Created by PhpStorm.
 * User: tik_squad
 * Date: 10/8/19
 * Time: 8:38 AM
 */

namespace DedeGunawan\TranskripAkademikUnsil;


use DedeGunawan\TranskripAkademikUnsil\Collections\KrsCollection;
use DedeGunawan\TranskripAkademikUnsil\Databases\ConnectionManager;
use DedeGunawan\TranskripAkademikUnsil\Entities\Kelulusan;
use DedeGunawan\TranskripAkademikUnsil\Entities\Konsentrasi;
use DedeGunawan\TranskripAkademikUnsil\Entities\Mahasiswa;
use DedeGunawan\TranskripAkademikUnsil\Entities\TandaTangan;
use DedeGunawan\TranskripAkademikUnsil\Entities\Tanggal;
use DedeGunawan\TranskripAkademikUnsil\Interfaces\HookInterface;
use DedeGunawan\TranskripAkademikUnsil\Interfaces\ResolverInterface;
use DedeGunawan\TranskripAkademikUnsil\Services\Hook\ValidatorHook;
use DedeGunawan\TranskripAkademikUnsil\Templates\BaseTemplate;
use DedeGunawan\TranskripAkademikUnsil\Traits\LanguageSwitcherTrait;
use Illuminate\Support\Collection;

class TranskripAkademikUnsil
{
    use LanguageSwitcherTrait;
    protected $npm;
    protected $nomor_transkrip;
    /**
     * @var $mahasiswa Mahasiswa
     */
    protected $mahasiswa;
    /**
     * @var $tanda_tangan_kiri TandaTangan
     */
    protected $tanda_tangan_kiri;
    /**
     * @var $tanda_tangan_kanan TandaTangan
     */
    protected $tanda_tangan_kanan;
    /**
     * @var $tanggal_cetak Tanggal
     */
    protected $tanggal_cetak;
    /**
     * @var $konsentrasi Konsentrasi
     */
    protected $konsentrasi;

    /**
     * @var $kelulusan Kelulusan
     */
    protected $kelulusan;

    protected $kota_cetak;

    /**
     * @var $krsCollection KrsCollection
     */
    protected $krsCollection;

    /**
     * @var $template BaseTemplate
     */
    protected $template;

    /**
     * @var $resolver ResolverInterface
     */
    protected $resolver;

    /**
     * @var $connection_manager ConnectionManager
     */
    protected $connection_manager;

    /**
     * @var $hooks Collection
     */
    protected $hooks;

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
    public function getNomorTranskrip()
    {
        return $this->nomor_transkrip;
    }

    /**
     * @param mixed $nomor_transkrip
     */
    public function setNomorTranskrip($nomor_transkrip)
    {
        $this->nomor_transkrip = $nomor_transkrip;
    }

    /**
     * @return Mahasiswa
     */
    public function getMahasiswa(): Mahasiswa
    {
        return $this->mahasiswa;
    }

    /**
     * @param Mahasiswa $mahasiswa
     */
    public function setMahasiswa(Mahasiswa $mahasiswa)
    {
        $this->mahasiswa = $mahasiswa;
    }

    /**
     * @return TandaTangan
     */
    public function getTandaTanganKiri()
    {
        return $this->tanda_tangan_kiri;
    }

    /**
     * @param TandaTangan $tanda_tangan_kiri
     */
    public function setTandaTanganKiri(TandaTangan $tanda_tangan_kiri)
    {
        $this->tanda_tangan_kiri = $tanda_tangan_kiri;
    }

    /**
     * @return TandaTangan
     */
    public function getTandaTanganKanan()
    {
        return $this->tanda_tangan_kanan;
    }

    /**
     * @param TandaTangan $tanda_tangan_kanan
     */
    public function setTandaTanganKanan(TandaTangan $tanda_tangan_kanan)
    {
        $this->tanda_tangan_kanan = $tanda_tangan_kanan;
    }

    /**
     * @return Tanggal
     */
    public function getTanggalCetak(): Tanggal
    {
        return $this->tanggal_cetak;
    }

    /**
     * @param Tanggal $tanggal_cetak
     */
    public function setTanggalCetak(Tanggal $tanggal_cetak)
    {
        $this->tanggal_cetak = $tanggal_cetak;
    }

    /**
     * @return Konsentrasi
     */
    public function getKonsentrasi(): Konsentrasi
    {
        return $this->konsentrasi;
    }

    /**
     * @param Konsentrasi $konsentrasi
     */
    public function setKonsentrasi(Konsentrasi $konsentrasi)
    {
        $this->konsentrasi = $konsentrasi;
    }

    /**
     * @return Kelulusan
     */
    public function getKelulusan(): Kelulusan
    {
        return $this->kelulusan;
    }

    /**
     * @param Kelulusan $kelulusan
     */
    public function setKelulusan(Kelulusan $kelulusan)
    {
        $this->kelulusan = $kelulusan;
    }

    /**
     * @return mixed
     */
    public function getKotaCetak()
    {
        return $this->kota_cetak;
    }

    /**
     * @param mixed $kota_cetak
     */
    public function setKotaCetak($kota_cetak)
    {
        $this->kota_cetak = $kota_cetak;
    }

    /**
     * @return KrsCollection
     */
    public function getKrsCollection(): KrsCollection
    {
        return $this->krsCollection;
    }

    /**
     * @param KrsCollection $krsCollection
     */
    public function setKrsCollection(KrsCollection $krsCollection)
    {
        $this->krsCollection = $krsCollection;
    }

    /**
     * @return BaseTemplate
     */
    public function getTemplate(): BaseTemplate
    {
        return $this->template;
    }

    /**
     * @param BaseTemplate $template
     */
    public function setTemplate(BaseTemplate $template)
    {
        $this->template = $template;
    }

    public static function getInstance()
    {
        static $instance;
        if ($instance==null) {
            $instance = new self();
        }
        return $instance;
    }

    /**
     * @return ResolverInterface
     */
    public function getResolver(): ResolverInterface
    {
        return $this->resolver;
    }

    /**
     * @param ResolverInterface $resolver
     */
    public function setResolver(ResolverInterface $resolver)
    {
        $this->resolver = $resolver;
    }

    public function resolve()
    {
        foreach ($this->hooks as $hook) {
            $hook->setTranskripAkademikUnsil($this);
            $hook->call();
        }
        $this->getResolver()->setTranskripAkademikUnsil($this);
        $this->getResolver()->resolve();
    }

    /**
     * @return ConnectionManager
     */
    public function getConnectionManager(): ConnectionManager
    {
        return $this->connection_manager;
    }

    /**
     * @param ConnectionManager $connection_manager
     */
    public function setConnectionManager(ConnectionManager $connection_manager)
    {
        $this->connection_manager = $connection_manager;
    }

    /**
     * @param $hook HookInterface
     */
    public function addHook($hook)
    {
        $this->hooks->put(spl_object_hash($hook), $hook);
    }

    /**
     * @param $hook HookInterface
     */
    public function removeHook($hook)
    {
        $this->hooks->forget(spl_object_hash($hook), $hook);
    }

    public function __construct()
    {
        $this->hooks = new Collection();
    }

}