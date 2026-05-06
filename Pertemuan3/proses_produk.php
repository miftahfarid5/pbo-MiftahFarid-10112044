<?php

class Produk {
    public $nama;
    public $harga;

    public function statusHarga() {
        if ($this->harga > 100000){
        return "Produk Mahal";
        } else {
        return "Produk Terjangkau";
        }
    }
}

$produk1 = new Produk();

    $produk1->nama = 
    htmlspecialchars($_POST['nama']);
    $produk1->harga =
    htmlspecialchars($_POST['harga']);

    echo "<h2>Data Produk Warung Miftah</h2>";
    echo "Nama Produk : " . $produk1->nama . "<br>";
    echo "Harga : Rp " . $produk1->harga . "<br>";
    echo "Status Harga : " . $produk1->statusHarga() . "<br>";

?>