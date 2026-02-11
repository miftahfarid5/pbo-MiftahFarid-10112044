<?php 

class Belanja {

//ada 6 properti
    public $namaKasir;
    public $namaPembeli;
    public $namaBarang;
    public $hargaBarang;
    public $jumlahBarang;
    public $totalBayar;
    public $diskon;
    public $pajak=0.02;
    public $uangBayar;

    public function totalHarga(): int {
        $subtotal = $this->hargaBarang * $this->jumlahBarang; 
        return $subtotal;
    }
}

$belanja1 = new Belanja();
$belanja1->namaKasir="Ali";
$belanja1->namaPembeli="Zaki";
$belanja1->namaBarang="Sabun";
$belanja1->hargaBarang=5000;
$belanja1->jumlahBarang=3;
$belanja1->diskon=0.1;
$belanja1->pajak=0.02;
$belanja1->uangBayar=100000;
//var_dump($belanja1);

echo "<pre>";
echo "=======Sukses Lancar Rezeki=======\n";
echo "Kasir       : " . $belanja1->namaKasir . "\n";
echo "Pembeli     : " . $belanja1->namaPembeli . "\n";
echo "----------------------------------\n";
echo "Nama Barang : " . $belanja1->namaBarang . "\n";
echo "----------------------------------\n";
echo "Subtotal    : Rp " . $belanja1->totalHarga() . "\n";
echo "Diskon      : Rp " . ($belanja1->totalHarga() * $belanja1->diskon) . "\n";
echo "Pajak       : Rp " . ($belanja1->totalHarga() * $belanja1->pajak) . "\n";
echo "----------------------------------\n";
echo "Total Bayar : Rp " . ($belanja1->totalHarga() - ($belanja1->totalHarga() * $belanja1->diskon) + ($belanja1->totalHarga() * $belanja1->pajak)) . "\n";
echo "Uang Bayar  : Rp " . $belanja1->uangBayar . "\n";
echo "Kembalian   : Rp " . ($belanja1->uangBayar - ($belanja1->totalHarga() - ($belanja1->totalHarga() * $belanja1->diskon) + ($belanja1->totalHarga() * $belanja1->pajak))) . "\n";
echo "==================================\n";
echo "</pre>";

?>