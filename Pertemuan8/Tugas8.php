<?php

class Karyawan {
    public $nama;
    public $golongan;
    public $jamLembur;
    public $gajiPokok;
    public $gajiLembur;
    public $totalGaji;

    // Constructor dengan parameter
    public function __construct($nama, $golongan, $jamLembur) {
        $this->nama = $nama;
        $this->golongan = $golongan;
        $this->jamLembur = $jamLembur;
        $this->gajiPokok = $this->getGajiPokok();
        $this->gajiLembur = $this->getGajiLembur();
        $this->totalGaji = $this->gajiPokok + $this->gajiLembur;
    }

    // Method getGajiPokok dengan array
    public function getGajiPokok() {
        $daftarGaji = [
            "Ib" => 1250000,
            "Ic" => 1300000,
            "Id" => 1350000,
            "IIa" => 2000000,
            "IIb" => 2100000,
            "IIc" => 2200000,
            "IId" => 2300000,
            "IIIc" => 2800000,
            "IVb" => 3100000
        ];

        if (array_key_exists($this->golongan, $daftarGaji)) {
            return $daftarGaji[$this->golongan];
        } else {
            return 0;
        }
    }

    // Method hitung gaji lembur
    public function getGajiLembur() {
        return $this->jamLembur * 15000;
    }

    // Destructor
    public function __destruct() {
        // Destructor dipanggil saat objek dihapus
    }
}

// ========== CRUD ==========

// Format Rupiah tanpa desimal
function rp($angka) {
    return "Rp" . number_format($angka, 0, ',', '.');
}

// Tampilkan semua data (format tabel)
function tampilData($daftar) {
    echo "\n====== DATA GAJI KARYAWAN ======\n";
    echo "No | Nama | Golongan | Jam Lembur | Total Gaji\n";
    echo "----------------------------------------------\n";
    
    if (count($daftar) == 0) {
        echo "Belum ada data karyawan.\n";
    } else {
        foreach ($daftar as $index => $k) {
            $no = $index + 1;
            echo "$no | {$k->nama} | {$k->golongan} | {$k->jamLembur} | " . rp($k->totalGaji) . "\n";
        }
    }
    echo "================================\n";
}

// Tambah data
function tambahData(&$daftar) {
    echo "\n--- TAMBAH DATA KARYAWAN ---\n";
    echo "Nama Karyawan: ";
    $nama = trim(fgets(STDIN));
    
    // Validasi golongan
    do {
        echo "Golongan (Ib/Ic/Id/IIa/IIb/IIc/IId): ";
        $golongan = trim(fgets(STDIN));
        $golonganValid = ["Ib", "Ic", "Id", "IIa", "IIb", "IIc", "IId"];
        if (!in_array($golongan, $golonganValid)) {
            echo "Golongan tidak valid!\n";
        }
    } while (!in_array($golongan, $golonganValid));
    
    echo "Jam Lembur: ";
    $jamLembur = (int) trim(fgets(STDIN));
    
    $karyawan = new Karyawan($nama, $golongan, $jamLembur);
    $daftar[] = $karyawan;
    echo "\nData berhasil ditambahkan!\n";
}

// Update data
function updateData(&$daftar) {
    if (count($daftar) == 0) {
        echo "\nBelum ada data karyawan!\n";
        return;
    }
    
    tampilData($daftar);
    echo "Pilih nomor karyawan yang akan diupdate: ";
    $index = (int) trim(fgets(STDIN)) - 1;
    
    if (isset($daftar[$index])) {
        echo "\n--- UPDATE DATA KARYAWAN ---\n";
        echo "Nama Baru: ";
        $namaBaru = trim(fgets(STDIN));
        
        do {
            echo "Golongan Baru (Ib/Ic/Id/IIa/IIb/IIc/IId): ";
            $golonganBaru = trim(fgets(STDIN));
            $golonganValid = ["Ib", "Ic", "Id", "IIa", "IIb", "IIc", "IId"];
            if (!in_array($golonganBaru, $golonganValid)) {
                echo "Golongan tidak valid!\n";
            }
        } while (!in_array($golonganBaru, $golonganValid));
        
        echo "Jam Lembur Baru: ";
        $jamLemburBaru = (int) trim(fgets(STDIN));
        
        $daftar[$index] = new Karyawan($namaBaru, $golonganBaru, $jamLemburBaru);
        echo "\nData berhasil diupdate!\n";
    } else {
        echo "\nNomor tidak valid!\n";
    }
}

// Hapus data
function hapusData(&$daftar) {
    if (count($daftar) == 0) {
        echo "\nBelum ada data karyawan!\n";
        return;
    }
    
    tampilData($daftar);
    echo "Pilih nomor karyawan yang akan dihapus: ";
    $index = (int) trim(fgets(STDIN)) - 1;
    
    if (isset($daftar[$index])) {
        $nama = $daftar[$index]->nama;
        unset($daftar[$index]);
        $daftar = array_values($daftar);
        echo "\nData karyawan $nama berhasil dihapus!\n";
    } else {
        echo "\nNomor tidak valid!\n";
    }
}

// ========== PROGRAM UTAMA ==========
$daftarKaryawan = [];

$daftarKaryawan[] = new Karyawan("Winny", "IIb", 30);
$daftarKaryawan[] = new Karyawan("Stendy", "IIIc", 32);
$daftarKaryawan[] = new Karyawan("Alfred", "IVb", 30);

do {
    echo "\n==== MENU GAJI KARYAWAN ====\n";
    echo "1. Tampilkan Data\n";
    echo "2. Tambah Data\n";
    echo "3. Update Data\n";
    echo "4. Hapus Data\n";
    echo "5. Keluar\n";
    echo "Pilih menu: ";
    
    $menu = trim(fgets(STDIN));
    
    switch ($menu) {
        case '1':
            tampilData($daftarKaryawan);
            break;
        case '2':
            tambahData($daftarKaryawan);
            break;
        case '3':
            updateData($daftarKaryawan);
            break;
        case '4':
            hapusData($daftarKaryawan);
            break;
        case '5':
            echo "\nProgram selesai. Terima kasih!\n";
            break;
        default:
            echo "\nPilihan tidak valid!\n";
    }
    
} while ($menu != '5');

?>