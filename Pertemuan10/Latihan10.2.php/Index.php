<?php

require_once "tagihanListrik.php";
require_once "tagihanRepositori.php";

function formatRupiah($angka){
    return "Rp " . number_format($angka, 0, ',', '.');
}

$repo = new TagihanRepository();
$data = $repo->getAll();

echo "<h2>DATA TAGIHAN LISTRIK</h2>";

echo "<table border='1' cellpadding='6'>";
echo "<tr>
<th>No</th>
<th>Nama</th>
<th>KWH</th>
<th>Total</th>
</tr>";

$no = 1;

foreach($data as $d){

    $obj = new TagihanListrik();
    $obj->setData($d["nama"], $d["kwh"]);

    echo "<tr>";
    echo "<td>".$no++."</td>";
    echo "<td>".$obj->getNama()."</td>";
    echo "<td>".$obj->getKwh()."</td>";
    echo "<td>".formatRupiah($obj->hitungTotal())."</td>";
    echo "</tr>";
}

echo "</table>";

?>