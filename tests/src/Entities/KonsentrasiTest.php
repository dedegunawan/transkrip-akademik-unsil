<?php
/**
 * Created by PhpStorm.
 * User: tik_squad
 * Date: 10/8/19
 * Time: 9:29 AM
 */

namespace DedeGunawan\TranskripAkademikUnsil\Tests\Entities;


use DedeGunawan\TranskripAkademikUnsil\Entities\Konsentrasi;
use PHPUnit\Framework\TestCase;

class KonsentrasiTest extends TestCase
{
    public function testKonsentrasiCanBuildEntity()
    {
        $konsentrasi = Konsentrasi::build([
            'status_akreditasi' => 'status_akreditasi',
            'nama_konsentrasi' => 'nama_konsentrasi',
            'kode_prodi' => 'kode_prodi',
            'nama_prodi' => 'nama_prodi',
            'kode_fakultas' => 'kode_fakultas',
            'nama_fakultas' => 'nama_fakultas',
        ]);

        $this->assertObjectHasAttribute('status_akreditasi', $konsentrasi);
        $this->assertObjectHasAttribute('nama_konsentrasi', $konsentrasi);
        $this->assertObjectHasAttribute('kode_prodi', $konsentrasi);
        $this->assertObjectHasAttribute('nama_prodi', $konsentrasi);
        $this->assertObjectHasAttribute('kode_fakultas', $konsentrasi);
        $this->assertObjectHasAttribute('nama_fakultas', $konsentrasi);

        $this->assertEquals('status_akreditasi', $konsentrasi->getStatusAkreditasi());
        $this->assertEquals('nama_konsentrasi', $konsentrasi->getNamaKonsentrasi());
        $this->assertEquals('kode_prodi', $konsentrasi->getKodeProdi());
        $this->assertEquals('nama_prodi', $konsentrasi->getNamaProdi());
        $this->assertEquals('kode_fakultas', $konsentrasi->getKodeFakultas());
        $this->assertEquals('nama_fakultas', $konsentrasi->getNamaFakultas());
    }
}