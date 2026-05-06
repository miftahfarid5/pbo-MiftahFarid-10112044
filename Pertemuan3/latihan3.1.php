<?php
class kendaraan {
    var $jumlahRoda;
    var $warna;
    var $bahanBakar; 
    var $harga;
    var $merek;
    var $tahunPembuatan;

    function statusHarga() {
        if ($this->harga > 50000000) $status = 'Mahal';
        else $status = 'Murah';
        return $status;
    }

    function statusBBM() {
        if ($this->bahanBakar == 'Pertalite') $status = 'Dapat Subsidi';
        else $status = 'Tidak Dapat Subsidi';
        return $status;
    }

    function hargaBekas() {
        $hargaBekas = $this->harga * 0.9;
        return $hargaBekas;
    }
}

    $objekKendaraan1 = new kendaraan();
    $objekKendaraan1->merek="Yamaha MIO";
    $objekKendaraan1->warna="Hitam";
    $objekKendaraan1->jumlahRoda="2";
    $objekKendaraan1->harga="10000000";
    $objekKendaraan1->bahanBakar="Pertamax";
    $objekKendaraan1->tahunPembuatan="2015";

    $objekKendaraan2 = new kendaraan();
    $objekKendaraan2->merek="Toyota Avanza";
    $objekKendaraan2->warna="Putih";
    $objekKendaraan2->jumlahRoda="4";
    $objekKendaraan2->harga="100000000";
    $objekKendaraan2->bahanBakar="Pertalite";
    $objekKendaraan2->tahunPembuatan="2005";

    echo "Merek: ".$objekKendaraan1->merek;
    echo "<br>";
    echo "Warna: ".$objekKendaraan1->warna;
    echo "<br>";
    echo "Jumlah Roda: ".$objekKendaraan1->jumlahRoda;
    echo "<br>";
    echo "Nominal Harga: ".$objekKendaraan1->harga;
    echo "<br>";
    echo "Status Harga Kendaraan: ".$objekKendaraan1->statusHarga();
    echo "<br>";
    echo "Status BBM Kendaraan: ".$objekKendaraan1->statusBBM();
    echo "<br>";
    echo "Tahun Pembuatan: ".$objekKendaraan1->tahunPembuatan;
    echo "<br>";
    echo "Harga Bekas: ".$objekKendaraan1->hargaBekas();
    echo "<br><br>";

    echo "Merek: ".$objekKendaraan2->merek;
    echo "<br>";
    echo "Warna: ".$objekKendaraan2->warna;
    echo "<br>";
    echo "Jumlah Roda: ".$objekKendaraan2->jumlahRoda;
    echo "<br>";
    echo "Nominal Harga: ".$objekKendaraan2->harga;
    echo "<br>";
    echo "Status Harga Kendaraan: ".$objekKendaraan2->statusHarga();
    echo "<br>";
    echo "Status BBM Kendaraan: ".$objekKendaraan2->statusBBM();
    echo "<br>";
    echo "Tahun Pembuatan: ".$objekKendaraan2->tahunPembuatan;
    echo "<br>";
    echo "Harga Bekas: ".$objekKendaraan2->hargaBekas();
    
?>