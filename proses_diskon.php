<?php
class Diskon {
    public $kartu;
    public $belanja;

    public function __construct($kartu, $belanja) {
        $this->kartu = $kartu;
        $this->belanja = $belanja;
    }

    public function hitungDiskon() {
        $diskon = 0;

        if ($this->kartu == 1) {
            if ($this->belanja >= 500000) {
                $diskon = 50000;
            } elseif ($this->belanja >= 100000) {
                $diskon = 15000;
            }
        } else {
            if ($this->belanja >= 100000) {
                $diskon = 5000;
            }
        }

        return $diskon;
    }

    public function totalBayar() {
        return $this->belanja - $this->hitungDiskon();
    }

    public function formatRupiah($angka) {
        return "Rp " . number_format($angka, 0, ',', '.');
    }
}

$kartu = $_POST['kartu'];
$belanja = $_POST['belanja'];

$obj = new Diskon($kartu, $belanja);
$diskon = $obj->hitungDiskon();
$total = $obj->totalBayar();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hasil Diskon</title>
</head>
<body>
    <h2>Hasil Perhitungan</h2>
    <table>
        <tr>
            <td>Kartu Member</td>
            <td>: <?= $kartu == 1 ? "Ya" : "Tidak" ?></td>
        </tr>
        <tr>
            <td>Total Belanja</td>
            <td>: <?= $obj->formatRupiah($belanja) ?></td>
        </tr>
        <tr>
            <td>Diskon</td>
            <td>: <?= $obj->formatRupiah($diskon) ?></td>
        </tr>
        <tr>
            <td>Total Bayar</td>
            <td>: <b><?= $obj->formatRupiah($total) ?></b></td>
        </tr>
    </table>
    <br>
    <a href="form_diskon.php">Kembali ke Form</a>
</body>
</html>