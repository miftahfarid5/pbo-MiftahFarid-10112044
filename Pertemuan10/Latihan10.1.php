<?php
// FUNCTION FORMAT RUPIAH
function formatRupiah($angka){
    return "Rp " . number_format($angka, 0, ',', '.');
}

// SUMBER DATA
class TagihanListrikRepository {

    private $data = [
        ["nama"=>"Budi","kwh"=>1200],
        ["nama"=>"Sinta","kwh"=>800],
        ["nama"=>"Rani","kwh"=>1500]
    ];

    public function getAll(){
        return $this->data;
    }
}

// MODEL (PROSES DATA)
class TagihanListrik {

    private $nama;
    private $kwh;
    private $tarif = 1500; // per kWh

    public function setData($nama, $kwh){
        $this->nama = $nama;
        $this->kwh  = $kwh;
    }

    public function getNama(){
        return $this->nama;
    }

    public function hitungTotal(){
        $total = $this->kwh * $this->tarif;

        // diskon jika pemakaian besar
        if($this->kwh > 1000){
            $total = $total - 50000;
        }

        return $total;
    }
}

// LOGIKA (ALUR PROGRAM)
$repo = new TagihanListrikRepository();
$data = $repo->getAll();

$hasil = [];

foreach($data as $d){

    $obj = new TagihanListrik();
    $obj->setData($d["nama"], $d["kwh"]);

    $hasil[] = [
        "nama"  => $obj->getNama(),
        "kwh"   => $d["kwh"],
        "total" => $obj->hitungTotal()
    ];
}

// VIEW (OUTPUT)
echo "<h2>DATA TAGIHAN LISTRIK</h2>";

echo "<table border='1' cellpadding='6'>";
echo "<tr>";
echo "<th>No</th>";
echo "<th>Nama</th>";
echo "<th>Pemakaian (kWh)</th>";
echo "<th>Total Bayar</th>";
echo "</tr>";

$no = 1;

foreach($hasil as $h){

    echo "<tr>";
    echo "<td>".$no++."</td>";
    echo "<td>".$h["nama"]."</td>";
    echo "<td>".$h["kwh"]."</td>";
    echo "<td>".formatRupiah($h["total"])."</td>";
    echo "</tr>";
}

echo "</table>";

?>