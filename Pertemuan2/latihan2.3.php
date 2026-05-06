<?php 

class Belanja {

//ada 6 properti
    public $namaPembeli;
    public $namaBarang;
    public $hargaBarang;
    public $jumlahBarang;
    public $totalBayar;
    public $diskon;
    public $pajak=0.02;

    public function __construct($namaPembeli, $namaBarang, $hargaBarang, $jumlahBarang, $diskon) {
        $this->namaPembeli = $namaPembeli;
        $this->namaBarang = $namaBarang;
        $this->hargaBarang = $hargaBarang;
        $this->jumlahBarang = $jumlahBarang;
        $this->diskon = $diskon;
    }

    public function totalHarga(): int {
        $subtotal = $this->hargaBarang * $this->jumlahBarang; 
        return $subtotal;
    }
}

$belanja1 = new Belanja("Zaki", "Sabun", 5000, 11, 0.1);

echo "<pre>";
echo "Nama Pembeli: " . $belanja1->namaPembeli . "\n";
echo "Nama Barang: " . $belanja1->namaBarang . "\n";
echo "Subtotal: Rp " . $belanja1->totalHarga() . "\n";
echo "Diskon: Rp " . ($belanja1->totalHarga() * $belanja1->diskon) . "\n";
echo "Pajak: Rp " . ($belanja1->totalHarga() * $belanja1->pajak) . "\n";
echo "Total Bayar: Rp " . ($belanja1->totalHarga() - ($belanja1->totalHarga() * $belanja1->diskon) + ($belanja1->totalHarga() * $belanja1->pajak)) . "\n";
echo "</pre>";

?>