<?php

function formatRupiah($angka) {
    return "Rp " . number_format($angka, 0, ',', '.');
}

class Belanja {
    public $namaPembeli; 
    public $namaBarang;
    public $hargaBarang;
    public $jumlahBeli;

    public function hitungSubtotal(){
        return $this->hargaBarang * $this->jumlahBeli;
    }

    public function hitungTotalDenganDiskon($persenDiskon) {
        $subtotal = $this->hitungSubtotal();
        $diskon = ($persenDiskon / 100) * $subtotal;
        return $subtotal - $diskon;
    }
}

//buat array data pembelian
$data = [
    'namaPembeli' => 'Zaki',
    'namaBarang' => 'Mie Ayam',
    'hargaBarang' => 7000,
    'jumlahBeli' => 12,
];

//inisiasi objek belanja dari class Belanja
$belanja = new Belanja();
$belanja->namaPembeli = $data["namaPembeli"];
$belanja->namaBarang = $data["namaBarang"];
$belanja->hargaBarang = $data["hargaBarang"];
$belanja->jumlahBeli = $data["jumlahBeli"];

// Output
echo "<h2>" . "STRUK BELANJA WARUNG A" . "</h2>";
echo "Pembeli: " . $belanja->namaPembeli . "<br>";
echo "Barang: " . $belanja->namaBarang . "<br>"; 
echo "Subtotal: " . formatRupiah($belanja->hitungSubtotal()) . "<br>";
echo "Total (Diskon 10%): " . formatRupiah($belanja->hitungTotalDenganDiskon(10)) . "<br>";
?>