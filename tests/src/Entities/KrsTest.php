<?php
/**
 * Created by PhpStorm.
 * User: tik_squad
 * Date: 10/8/19
 * Time: 9:40 AM
 */

namespace DedeGunawan\TranskripAkademikUnsil\Tests\Entities;


use DedeGunawan\TranskripAkademikUnsil\Entities\Krs;
use PHPUnit\Framework\TestCase;

final class KrsTest extends TestCase
{
    public function testKrsCanBuildEntity()
    {
        $krs = Krs::build([
            'id_matakuliah' => 'id_matakuliah',
            'kode_matakuliah' => 'kode_matakuliah',
            'nama_matakuliah' => 'nama_matakuliah',
            'sks' => 'sks',
            'huruf_mutu' => 'huruf_mutu',
            'angka_mutu' => 'angka_mutu',
        ]);



        $this->assertObjectHasAttribute('id_matakuliah', $krs);
        $this->assertObjectHasAttribute('kode_matakuliah', $krs);
        $this->assertObjectHasAttribute('nama_matakuliah', $krs);
        $this->assertObjectHasAttribute('sks', $krs);
        $this->assertObjectHasAttribute('huruf_mutu', $krs);
        $this->assertObjectHasAttribute('angka_mutu', $krs);

        $this->assertEquals('id_matakuliah', $krs->getIdMatakuliah());
        $this->assertEquals('kode_matakuliah', $krs->getKodeMatakuliah());
        $this->assertEquals('nama_matakuliah', $krs->getNamaMatakuliah());
        $this->assertEquals('sks', $krs->getSks());
        $this->assertEquals('huruf_mutu', $krs->getHurufMutu());
        $this->assertEquals('angka_mutu', $krs->getAngkaMutu());


    }
}