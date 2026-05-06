<?php
//parent class
class Produk {
    public $nama;//property
    public $harga;

    //medhod
    //($nama, $harga) = parameter
    public function __construct($nama, $harga) {
        $this->nama = $nama;//this=deklarasi
        $this->harga = $harga;
    }

    //medhod
    public function getInfo() {
        return "Produk: $this->nama - Rp" . number_format($this->harga, 0, ',', '.');
    }
}

//child class
class ProdukDigital extends Produk {
    public $ukuranFile; //property tambahan untuk produk digital

    //medhod
    //($nama, $harga, $ukuranFile) = parameter
    public function __construct($nama, $harga, $ukuranFile) {
        parent::__construct($nama, $harga);
        $this->ukuranFile = $ukuranFile;
    }

    //medhod
    public function getInfo() {
        return "Produk Digital: $this->nama - Rp" . number_format($this->harga, 0, ',', '.') . " - Ukuran File: $this->ukuranFile MB";
    }
}

$p1 = new Produk ("Laptop", 12000000);
$p2 = new ProdukDigital ("Ebook PHP", 12000, 100);

echo $p1->getInfo();
echo "<br>";
echo $p2->getInfo();
?>