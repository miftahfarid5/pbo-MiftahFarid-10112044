<?php

class Mahasiswa {
    public $nama; 
    public $kelas;
    public $mataKuliah;
    public $nilai;
    public $status;

}

//buat array data
$data1 = [
    'nama' => 'Aditya',
    'kelas' => 'SI 2',
    'mataKuliah' => 'Pemrograman Berorientasi Objek',
    'nilai' => '80',
    'status' => 'Lulus Kuis'
];

$data2 = [
    'nama' => 'Shinta',
    'kelas' => 'SI 2',
    'mataKuliah' => 'Pemrograman Berorientasi Objek',
    'nilai' => '75',
    'status' => 'Lulus Kuis'
];

$data3 = [
    'nama' => 'Ineu',
    'kelas' => 'SI 2',
    'mataKuliah' => 'Pemrograman Berorientasi Objek',
    'nilai' => '55',
    'status' => 'Tidak Lulus Kuis'
];

//inisiasi objek belanja dari class Belanja
$mahasiswa1 = new Mahasiswa();
$mahasiswa1->nama = $data1["nama"];
$mahasiswa1->kelas = $data1["kelas"];
$mahasiswa1->mataKuliah = $data1["mataKuliah"];
$mahasiswa1->nilai = $data1["nilai"];
$mahasiswa1->status = $data1["status"];

$mahasiswa2 = new Mahasiswa();
$mahasiswa2->nama = $data2["nama"];
$mahasiswa2->kelas = $data2["kelas"];
$mahasiswa2->mataKuliah = $data2["mataKuliah"];
$mahasiswa2->nilai = $data2["nilai"];
$mahasiswa2->status = $data2["status"];

$mahasiswa3 = new Mahasiswa();
$mahasiswa3->nama = $data3["nama"];
$mahasiswa3->kelas = $data3["kelas"];
$mahasiswa3->mataKuliah = $data3["mataKuliah"];
$mahasiswa3->nilai = $data3["nilai"];
$mahasiswa3->status = $data3["status"];

// Output
echo "<h2>" . "Data Nilai Mahasiswa" . "</h2>";
echo "Nama Mahasiswa: " . $mahasiswa1->nama . "<br>";
echo "Kelas: " . $mahasiswa1->kelas . "<br>";
echo "Mata Kuliah: " . $mahasiswa1->mataKuliah . "<br>";
echo "Nilai: " . $mahasiswa1->nilai . "<br>";
echo "Status: " . $mahasiswa1->status . "<br>";
echo "<hr>";

echo "Nama Mahasiswa: " . $mahasiswa2->nama . "<br>";
echo "Kelas: " . $mahasiswa2->kelas . "<br>";
echo "Mata Kuliah: " . $mahasiswa2->mataKuliah . "<br>";
echo "Nilai: " . $mahasiswa2->nilai . "<br>";
echo "Status: " . $mahasiswa2->status . "<br>";
echo "<hr>";

echo "Nama Mahasiswa: " . $mahasiswa3->nama . "<br>";
echo "Kelas: " . $mahasiswa3->kelas . "<br>";
echo "Mata Kuliah: " . $mahasiswa3->mataKuliah . "<br>";
echo "Nilai: " . $mahasiswa3->nilai . "<br>";
echo "Status: " . $mahasiswa3->status . "<br>";



?>