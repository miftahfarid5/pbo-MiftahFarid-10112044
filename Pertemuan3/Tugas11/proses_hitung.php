<?php
class Produk {
    public $bs;
    public $bp;
    public $la;
    public $kt;

    public function hitungDetail() {
        $bunga = ($this->bp / 100) * $this->bs;
        $totalPinjaman = $this->bs + $bunga;
        $angsuranDasar = $totalPinjaman / $this->la;
        $denda = 0.0015 * $angsuranDasar * $this->kt;
        $totalBayar = $angsuranDasar + $denda;

        return [
            'total_pinjaman' => $totalPinjaman,
            'angsuran' => $angsuranDasar,
            'denda' => $denda,
            'total_bayar' => $totalBayar
        ];
    }
}

$produk1 = new Produk();
$produk1->bs = $_POST['bs'];
$produk1->bp = $_POST['bp'];
$produk1->la = $_POST['la'];
$produk1->kt = $_POST['kt'];

$detail = $produk1->hitungDetail();

echo "<h2>Data Pinjaman Toko Pegadaian Syariah</h2>";
echo "Besar Pinjaman : Rp " . number_format($produk1->bs, 0, ',', '.') . "<br>";
echo "Total Pinjaman (Pinjaman + Bunga) : Rp " . number_format($detail['total_pinjaman'], 0, ',', '.') . "<br>";
echo "Besaran Angsuran : Rp " . number_format($detail['angsuran'], 0, ',', '.') . "<br>";
echo "-----------------------------------<br>";
echo "Keterlambatan Angsuran : " . $produk1->kt . " hari<br>";
echo "Denda Keterlambatan : Rp " . number_format($detail['denda'], 0, ',', '.') . "<br>";
echo "<strong>Besaran Pembayaran : Rp " . number_format($detail['total_bayar'], 0, ',', '.') . "</strong>";
?>