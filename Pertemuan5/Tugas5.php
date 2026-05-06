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

        if ($this->kartu == 1) { // Punya kartu
            if ($this->belanja > 500000) {
                $diskon = 50000;
            } elseif ($this->belanja > 100000) {
                $diskon = 15000;
            }
        } else { // Tidak punya kartu
            if ($this->belanja > 100000) {
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

$dataUji = [
    ['kartu' => 1, 'belanja' => 200000],
    ['kartu' => 1, 'belanja' => 570000],
    ['kartu' => 0, 'belanja' => 120000],
    ['kartu' => 0, 'belanja' => 90000]
];

echo "=========================<br>";
echo "  PROGRAM HITUNG DISKON        <br>";
echo "=========================<br><br>";

foreach ($dataUji as $i => $d) {
    $obj = new Diskon($d['kartu'], $d['belanja']);
    $diskon = $obj->hitungDiskon();
    $total = $obj->totalBayar();

    echo "Pembeli " . ($i + 1) . "<br>";
    echo "Kartu Member  : " . ($d['kartu'] == 1 ? "Ya" : "Tidak") . "<br>";
    echo "Total Belanja : " . $obj->formatRupiah($d['belanja']) . "<br>";
    echo "Diskon        : " . $obj->formatRupiah($diskon) . "<br>";
    echo "Total Bayar   : " . $obj->formatRupiah($total) . "<br>";
    echo "-------------------------------------<br>";
}

?>