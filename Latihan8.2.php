<?php

class manusia {
    var $nama;
    var $warna;

    public function __construct() {
        echo "ini adalah medhod construct <br/>";
    }

    public function __destruct() {
        echo "ini adalah method destruct <br/>";
    }

    public function tampilkan_nama() {
        return "Nama saya Mahasiswa SI <br/>";
    }
}

$manusia = new manusia();
echo $manusia->tampilkan_nama();

?>