<?php

/**
 * 3.a & 3.b: Class Parent (Uang Tabungan)
 */
class uang_tabungan {
    // 3.d: Encapsulation - Properti protected agar bisa diakses class anak saja
    protected $saldo;
    private $nama; // Private agar benar-benar tersembunyi

    // 3.f & 3.g: Constructor untuk inisialisasi awal
    public function __construct($nama, $saldo_awal) {
        $this->nama = $nama;
        $this->saldo = $saldo_awal;
    }

    // Method untuk menampilkan informasi saldo (Getter)
    public function cek_saldo() {
        return $this->saldo;
    }

    public function get_nama() {
        return $this->nama;
    }
}

/**
 * 3.c: Class Child (Inheritance)
 * Memisahkan tiap siswa sebagai class tersendiri
 */
class siswa_1 extends uang_tabungan {
    public function setor($jumlah) {
        $this->saldo += $jumlah;
    }

    public function tarik($jumlah) {
        if ($jumlah <= $this->saldo) {
            $this->saldo -= $jumlah;
            return true;
        }
        return false;
    }
}

class siswa_2 extends uang_tabungan {
    public function setor($jumlah) {
        $this->saldo += $jumlah;
    }

    public function tarik($jumlah) {
        if ($jumlah <= $this->saldo) {
            $this->saldo -= $jumlah;
            return true;
        }
        return false;
    }
}

class siswa_3 extends uang_tabungan {
    public function setor($jumlah) {
        $this->saldo += $jumlah;
    }

    public function tarik($jumlah) {
        if ($jumlah <= $this->saldo) {
            $this->saldo -= $jumlah;
            return true;
        }
        return false;
    }
}

// 3.f: Inisialisasi data dalam Array (Mirip gaya CRUD di kodinganmu sebelumnya)
$daftar_tabungan = [
    1 => new siswa_1("Miftah", 50000),
    2 => new siswa_2("Zaki", 75000),
    3 => new siswa_3("Farel", 100000)
];

/**
 * 3.f & 3.i: Program Utama (CLI & Loops)
 */
while (true) {
    echo "\n=== PROGRAM TABUNGAN SEKOLAH ===\n";
    foreach ($daftar_tabungan as $key => $siswa) {
        echo "$key. " . $siswa->get_nama() . " (Saldo: Rp " . number_format($siswa->cek_saldo(), 0, ',', '.') . ")\n";
    }
    echo "0. Keluar\n";
    echo "Pilih Siswa (1-3): ";

    // Mengambil input (Mirip Pertemuan 8 hal 13)
    $pilihan = trim(fgets(STDIN));

    if ($pilihan === '0') {
        echo "Keluar dari program. Terima kasih!\n";
        break;
    }

    // 3.f: Percabangan Validasi
    if (isset($daftar_tabungan[$pilihan])) {
        $objSiswa = $daftar_tabungan[$pilihan];
        
        echo "\nMenu " . $objSiswa->get_nama() . ":\n";
        echo "1. Setor Tunai\n";
        echo "2. Tarik Tunai\n";
        echo "Pilih Aksi: ";
        $aksi = trim(fgets(STDIN));

        // 3.h: Logika Perhitungan
        if ($aksi === '1') {
            echo "Masukkan jumlah setor: ";
            $nominal = (int)trim(fgets(STDIN));
            $objSiswa->setor($nominal);
            echo "Berhasil! Saldo " . $objSiswa->get_nama() . " kini: Rp " . number_format($objSiswa->cek_saldo(), 0, ',', '.') . "\n";
        } elseif ($aksi === '2') {
            echo "Masukkan jumlah tarik: ";
            $nominal = (int)trim(fgets(STDIN));
            if ($objSiswa->tarik($nominal)) {
                echo "Berhasil! Sisa saldo: Rp " . number_format($objSiswa->cek_saldo(), 0, ',', '.') . "\n";
            } else {
                echo "Gagal! Saldo tidak mencukupi untuk penarikan.\n";
            }
        } else {
            echo "Aksi tidak valid.\n";
        }
    } else {
        echo "Nomor siswa tidak ditemukan.\n";
    }
}
?>