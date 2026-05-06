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

    public function hitungDiskon($subtotal) {
        if ($subtotal > 100000) {
            return $subtotal * 0.1;
        }
        return 0;
    }
    
    public function hitungTotal() {
        $subtotal = $this->hitungSubtotal();
        $diskon = $this->hitungDiskon($subtotal);
        return $subtotal - $diskon;
    }
}

//buat array data pembelian
$data = [
    [
        'namaPembeli' => 'Zaki',
        'namaBarang' => 'Mie Ayam',
        'hargaBarang' => 7000,
        'jumlahBeli' => 3,
    ],
    [
        'namaPembeli' => 'Nasyid',
        'namaBarang' => 'Baklor',
        'hargaBarang' => 5000,
        'jumlahBeli' => 5,
    ],
    [
        'namaPembeli' => 'Parel',
        'namaBarang' => 'Nasi Goreng',
        'hargaBarang' => 12000,
        'jumlahBeli' => 2,
    ]
];

// TRANSAKSI 1
echo "<h2>Transaksi 1</h2>";

$errors1 = [];

$nama = $data[0]['namaPembeli'];
$barang = $data[0]['namaBarang'];
$harga = $data[0]['hargaBarang'];
$jumlah = $data[0]['jumlahBeli'];

if (empty($nama)) {
    $errors1[] = "Nama pembeli tidak boleh kosong.";
}
if ($harga <= 0) {
    $errors1[] = "Harga harus lebih dari 0.";
}
if ($jumlah <= 0) {
    $errors1[] = "Jumlah beli harus lebih dari 0.";
}

if (!empty($errors1)) {
    foreach ($errors1 as $error) {
        echo $error . "<br>";
    }
} else {
    $belanja1 = new Belanja();
    $belanja1->namaPembeli = $nama;
    $belanja1->namaBarang = $barang;
    $belanja1->hargaBarang = $harga;
    $belanja1->jumlahBeli = $jumlah;

    $subtotal1 = $belanja1->hitungSubtotal();
    $diskon1 = $belanja1->hitungDiskon($subtotal1);
    $total1 = $belanja1->hitungTotal();

    echo "Pembeli: " . $belanja1->namaPembeli . "<br>";
    echo "Barang: " . $belanja1->namaBarang . "<br>";
    echo "Subtotal: " . formatRupiah($subtotal1) . "<br>";
    echo "Diskon: " . formatRupiah($diskon1) . "<br>";
    echo "<b>Total: " . formatRupiah($total1) . "</b><br><br>";
}

// TRANSAKSI 2
echo "<h2>Transaksi 2</h2>";

$errors2 = [];

$nama = $data[1]['namaPembeli'];
$barang = $data[1]['namaBarang'];
$harga = $data[1]['hargaBarang'];
$jumlah = $data[1]['jumlahBeli'];

if (empty($nama)) {
    $errors2[] = "Nama pembeli tidak boleh kosong.";
}
if ($harga <= 0) {
    $errors2[] = "Harga harus lebih dari 0.";
}
if ($jumlah <= 0) {
    $errors2[] = "Jumlah beli harus lebih dari 0.";
}

if (!empty($errors2)) {
    foreach ($errors2 as $error) {
        echo $error . "<br>";
    }
} else {
    $belanja2 = new Belanja();
    $belanja2->namaPembeli = $nama;
    $belanja2->namaBarang = $barang;
    $belanja2->hargaBarang = $harga;
    $belanja2->jumlahBeli = $jumlah;

    $subtotal2 = $belanja2->hitungSubtotal();
    $diskon2 = $belanja2->hitungDiskon($subtotal2);
    $total2 = $belanja2->hitungTotal();

    echo "Pembeli: " . $belanja2->namaPembeli . "<br>";
    echo "Barang: " . $belanja2->namaBarang . "<br>";
    echo "Subtotal: " . formatRupiah($subtotal2) . "<br>";
    echo "Diskon: " . formatRupiah($diskon2) . "<br>";
    echo "<b>Total: " . formatRupiah($total2) . "</b><br><br>";
}

?>