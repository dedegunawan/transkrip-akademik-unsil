<?php
/**
 * Created by PhpStorm.
 * User: tik_squad
 * Date: 10/8/19
 * Time: 9:46 AM
 */

namespace DedeGunawan\TranskripAkademikUnsil\Tests\Entities;


use DedeGunawan\TranskripAkademikUnsil\Entities\Mahasiswa;
use DedeGunawan\TranskripAkademikUnsil\Entities\Tanggal;
use PHPUnit\Framework\TestCase;

class MahasiswaTest extends TestCase
{
    public function testMahasiswaCanBuildEntity()
    {
        $tanggal = Tanggal::build([
            'tanggal' => '12',
            'bulan' => '09',
            'tahun' => '1994',
        ]);
        $mahasiswa = Mahasiswa::build([
            'npm' => 'npm',
            'nama_mahasiswa' => 'nama_mahasiswa',
            'tempat_lahir' => 'tempat_lahir',
            'tanggal_lahir' => $tanggal,
            'url_foto' => 'url_foto',
        ]);

        $this->assertObjectHasAttribute('npm', $mahasiswa);
        $this->assertObjectHasAttribute('nama_mahasiswa', $mahasiswa);
        $this->assertObjectHasAttribute('tempat_lahir', $mahasiswa);
        $this->assertObjectHasAttribute('tanggal_lahir', $mahasiswa);
        $this->assertObjectHasAttribute('url_foto', $mahasiswa);

        $this->assertEquals('npm', $mahasiswa->getNpm());
        $this->assertEquals('nama_mahasiswa', $mahasiswa->getNamaMahasiswa());
        $this->assertEquals('tempat_lahir', $mahasiswa->getTempatLahir());
        $this->assertEquals($tanggal, $mahasiswa->getTanggalLahir());
        $this->assertEquals('url_foto', $mahasiswa->getUrlFoto());

        $this->assertInstanceOf( Mahasiswa::class, $mahasiswa);

    }
}