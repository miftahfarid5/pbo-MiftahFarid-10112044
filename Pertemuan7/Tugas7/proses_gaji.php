<?php
// CLASS PARENT
class Employee {
    public $nama;
    public $gaji;
    public $masaKerja;

    public function __construct($nama, $gaji, $masaKerja) {
        $this->nama = $nama;
        $this->gaji = $gaji;
        $this->masaKerja = $masaKerja;
    }

    public function hitungBonus() {
        return 0;
    }

    public function getTotalGaji() {
        return $this->gaji + $this->hitungBonus();
    }
}

// CLASS PROGRAMMER
class Programmer extends Employee {
    public function hitungBonus() {
        if ($this->masaKerja < 1) {
            return 0;
        } elseif ($this->masaKerja >= 1 && $this->masaKerja <= 10) {
            return $this->gaji * (0.01 * $this->masaKerja);
        } else {
            return $this->gaji * (0.02 * $this->masaKerja);
        }
    }
}

// CLASS DIREKTUR
class Direktur extends Employee {
    public function hitungBonus() {
        $bonus = 0.5 * $this->masaKerja;
        $tunjangan = 0.1 * $this->masaKerja;
        return $this->gaji * ($bonus + $tunjangan);
    }
}

// CLASS PEGAWAI MINGGUAN
class PegawaiMingguan extends Employee {
    public $hargaBarang;
    public $stockTarget;
    public $totalPenjualan;

    public function __construct($nama, $gaji, $masaKerja, $hargaBarang, $stockTarget, $totalPenjualan) {
        parent::__construct($nama, $gaji, $masaKerja);
        $this->hargaBarang = $hargaBarang;
        $this->stockTarget = $stockTarget;
        $this->totalPenjualan = $totalPenjualan;
    }

    public function hitungBonus() {
        $persenPenjualan = ($this->totalPenjualan / $this->stockTarget) * 100;
        
        if ($persenPenjualan > 70) {
            return ($this->hargaBarang * $this->totalPenjualan) * 0.1;
        } else {
            return ($this->hargaBarang * $this->totalPenjualan) * 0.03;
        }
    }
}

// AMBIL DATA DARI FORM
$nama = $_POST['nama'];
$jenis = $_POST['jenis'];
$gaji = $_POST['gaji'];
$masaKerja = $_POST['masaKerja'];

if ($jenis == "Programmer") {
    $karyawan = new Programmer($nama, $gaji, $masaKerja);
    $keterangan = "Programmer";
} elseif ($jenis == "Direktur") {
    $karyawan = new Direktur($nama, $gaji, $masaKerja);
    $keterangan = "Direktur";
} else {
    $hargaBarang = $_POST['hargaBarang'];
    $stockTarget = $_POST['stockTarget'];
    $totalPenjualan = $_POST['totalPenjualan'];
    $karyawan = new PegawaiMingguan($nama, $gaji, $masaKerja, $hargaBarang, $stockTarget, $totalPenjualan);
    $keterangan = "Pegawai Mingguan";
}

$bonus = $karyawan->hitungBonus();
$totalGaji = $karyawan->getTotalGaji();

function rp($angka) {
    return "Rp " . number_format($angka, 0, ',', '.');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hasil Hitung Gaji</title>
</head>
<body>
    <h2>PT. MAJU JAYA</h2>
    <h3>Hasil Perhitungan Gaji Karyawan</h3>

    Nama Karyawan : <?= $karyawan->nama ?><br>
    Jenis Karyawan : <?= $keterangan ?><br>
    Gaji Pokok : <?= rp($karyawan->gaji) ?><br>
    Masa Kerja : <?= $karyawan->masaKerja ?> tahun<br><br>

    Bonus / Tunjangan : <?= rp($bonus) ?><br>
    <b>Total Gaji Diterima : <?= rp($totalGaji) ?></b><br><br>

    <a href="form_gaji.php">Kembali ke Form</a>
</body>
</html>