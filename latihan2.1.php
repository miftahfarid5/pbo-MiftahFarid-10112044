<?php 

class Belanja {

//ada 7 properti
    public $namaPembeli="Zaki";
    public $namaBarang="Sabun Bolong";
    public $hargaBarang=5000;
    public $jumlahBarang=2;
    public $totalBayar;
    public $diskon=0.1;
    public $pajak=0.02;

    public function totalHarga(): int {
        $subtotal = $this->hargaBarang * $this->jumlahBarang; 
        return $subtotal;
    }
}

$belanja1 = new Belanja();
//var_dump($belanja1);

echo "Subtotal: Rp " . $belanja1->totalHarga() . "<br>";
echo "Diskon: Rp " . ($belanja1->totalHarga() * $belanja1->diskon) . "<br>";
?>