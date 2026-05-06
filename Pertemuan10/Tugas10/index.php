<?php

require_once "kendaraan.php";
require_once "kendaraanRepository.php";

function formatRupiah($angka){
    return "Rp " . number_format($angka, 0, ',', '.');
}

$repo = new KendaraanRepository();
$data = $repo->getAll();

echo "<h2>DATA KENDARAAN</h2>";

echo "<table border='1' cellpadding='6'>";
echo "<tr>
<th>No</th>
<th>Merek</th>
<th>Jumlah Roda</th>
<th>Harga</th>
<th>Warna</th>
<th>Bahan Bakar</th>
</tr>";

$no = 1;

foreach($data as $d){

    $obj = new Kendaraan();
    $obj->setData(
        $d["merek"],
        $d["jumlahRoda"],
        $d["harga"],
        $d["warna"],
        $d["bahanBakar"]
    );

    echo "<tr>";
    echo "<td>".$no++."</td>";
    echo "<td>".$obj->getMerek()."</td>";
    echo "<td>".$obj->getJumlahRoda()."</td>";
    echo "<td>".formatRupiah($obj->getHarga())."</td>";
    echo "<td>".$obj->getWarna()."</td>";
    echo "<td>".$obj->getBahanBakar()."</td>";
    echo "</tr>";
}

echo "</table>";

?>