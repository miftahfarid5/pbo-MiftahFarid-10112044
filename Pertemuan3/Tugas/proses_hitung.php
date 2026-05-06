<?php

class Produk {
    public $bs;
    public $bp;
    public $la;
    public $kt;
    
    public function hitungAngsuran() {
        $bunga = ($this->bp / 100) * $this->bs;
        $totalPinjaman = $this->bs + $bunga;
        $angsuranPerBulan = $totalPinjaman / $this->la;
        $dendaKeterlambatan = ($this->kt > 0) ? (0.0015 * $angsuranPerBulan * $this->kt) : 0;
        return $angsuranPerBulan + $dendaKeterlambatan;
    }
}

$produk1 = new Produk();
$produk1->bs = $_POST['bs'];
$produk1->bp = $_POST['bp'];
$produk1->la = $_POST['la'];
$produk1->kt = $_POST['kt'];

echo "<h2>Data Pinjaman Toko Pegadaian Syariah</h2>";
echo "Besar Pinjaman : Rp " . $_POST['bs'] . "<br>";
echo "Besar Bunga : " . $_POST['bp'] . "%<br>";
echo "Lama Angsuran : " . $_POST['la'] . " bulan<br>";
echo "Keterlambatan Angsuran : " . $_POST['kt'] . " hari<br>";
echo "Besaran Pembayaran : Rp " . number_format($produk1->hitungAngsuran(), 2, ',', '.') . "<br>";

?>