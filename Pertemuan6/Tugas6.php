<?php
// Fungsi untuk format angka
function formatAngka($angka) {
    return number_format($angka, 2, '.', '');
}

// Class BangunRuang
class BangunRuang {
    public $jenis;
    public $sisi;
    public $jari;
    public $tinggi;

    public function hitungVolume() {
        $phi = 22/7;
        
        if ($this->jenis == "Bola") {
            return (4/3) * $phi * pow($this->jari, 3);
        } elseif ($this->jenis == "Kerucut") {
            return (1/3) * $phi * pow($this->jari, 2) * $this->tinggi;
        } elseif ($this->jenis == "Limas Segi Empat") {
            $luasAlas = pow($this->sisi, 2);
            return (1/3) * $luasAlas * $this->tinggi;
        } elseif ($this->jenis == "Kubus") {
            return pow($this->sisi, 3);
        } elseif ($this->jenis == "Tabung") {
            return $phi * pow($this->jari, 2) * $this->tinggi;
        } else {
            return 0;
        }
    }
}

// Array data bangun ruang
$dataBangun = [
    ["Bola", 0, 7, 0],
    ["Kerucut", 0, 14, 10],
    ["Limas Segi Empat", 8, 0, 24],
    ["Kubus", 30, 0, 0],
    ["Tabung", 0, 7, 10]
];

// Tabel HTML
echo "<table border='1' cellpadding='6'>";
echo "<tr>
    <th>Jenis Bangun Ruang</th>
    <th>Sisi</th>
    <th>Jari-jari</th>
    <th>Tinggi</th>
    <th>Volume</th>
</tr>";

// Perulangan foreach
foreach ($dataBangun as $item) {
    $bangun = new BangunRuang();
    $bangun->jenis = $item[0];
    $bangun->sisi = $item[1];
    $bangun->jari = $item[2];
    $bangun->tinggi = $item[3];
    
    $volume = $bangun->hitungVolume();
    
    echo "<tr>";
    echo "<td>" . $bangun->jenis . "</td>";
    echo "<td>" . $bangun->sisi . "</td>";
    echo "<td>" . $bangun->jari . "</td>";
    echo "<td>" . $bangun->tinggi . "</td>";
    echo "<td>" . formatAngka($volume) . "</td>";
    echo "</tr>";
}

echo "</table>";
?>