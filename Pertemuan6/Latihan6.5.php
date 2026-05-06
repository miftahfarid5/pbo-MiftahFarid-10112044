<?php

function formatRupiah($angka): string {
    return "Rp " . number_format(num: $angka, decimals: 0, decimal_separator: ",", thousands_separator: ".");
}

class BelanjaWarung {
    public $nama;
    public $barang;
    public $harga;
    public $jumlah;
    public $member;

    public function subtotal(): float|int {
        return $this->harga * $this->jumlah;
    }

    public function diskon($subtotal): int {
        $diskon = 0;

        if ($this->member == true) {
            if ($subtotal >= 500000) {
                $diskon = 50000;
            } elseif ($subtotal > 100000) {
                $diskon = 15000;
            }
        } else {
            if ($subtotal >= 100000) {
                $diskon = 5000;
            }
        }

        return $diskon;
    }

    public function total(): float|int {
        $subtotal = $this->subtotal();
        $diskon = $this->diskon($subtotal);
        return $subtotal - $diskon;
    }
}

$dataBelanja = [
    [
        "nama" => "Budhi",
        "barang" => "Gula",
        "harga" => 65000,
        "jumlah" => 2,
        "member" => true
    ],
    [
        "nama" => "Sinta",
        "barang" => "Minyak",
        "harga" => 140000,
        "jumlah" => 1,
        "member" => false
    ],
    [
        "nama" => "Rani",
        "barang" => "Tepung",
        "harga" => 50000,
        "jumlah" => 3,
        "member" => true
    ],
    [
        "nama" => "Resan",
        "barang" => "Susu",
        "harga" => 40000,
        "jumlah" => 3,
        "member" => true
    ],
    [
        "nama" => "Dida",
        "barang" => "Beras",
        "harga" => 50000,
        "jumlah" => 3,
        "member" => false
    ]
];

echo "<table border='1' cellpadding='6'>";

echo "<tr>
    <th>No</th>
    <th>Nama</th>
    <th>Member</th>
    <th>Barang</th>
    <th>Subtotal</th>
    <th>Diskon</th>
    <th>Total</th>
</tr>";

$no = 1;

foreach ($dataBelanja as $d) {
    $belanja = new BelanjaWarung();

    $belanja->nama = $d["nama"];
    $belanja->barang = $d["barang"];
    $belanja->harga = $d["harga"];
    $belanja->jumlah = $d["jumlah"];
    $belanja->member = $d["member"];

    $subtotal = $belanja->subtotal();
    $diskon = $belanja->diskon($subtotal);
    $total = $belanja->total();

    echo "<tr>";
    echo "<td>" . $no. "</td>";
    echo "<td>" . $belanja->nama . "</td>";
    echo "<td>" . ($belanja->member ? 'Ya' : 'Tidak') . "</td>";
    echo "<td>" . $belanja->barang . "</td>";
    echo "<td>" . formatRupiah($subtotal) . "</td>";
    echo "<td>" . formatRupiah($diskon) . "</td>";
    echo "<td>" . formatRupiah($total) . "</td>";
    echo "</tr>";

    $no++;

}

echo "</table>";

?>