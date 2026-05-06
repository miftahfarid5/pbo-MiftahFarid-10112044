<?php

class Segitiga {
public $tinggi;
public $lebar;

// constructor (WAJIB __construct)
function __construct($tinggi, $lebar) {
$this->tinggi = $tinggi;
$this->lebar = $lebar;
}

function luas() {
$luas = ($this->tinggi * $this->lebar) / 2;
echo "Tinggi Segitiga: " . $this->tinggi . "
";
echo "Lebar Segitiga: " . $this->lebar . "
";
echo "
Luas Segitiga = $luas";
}
}

// buat object
$segitiga = new Segitiga(200, 500);
$segitiga->luas();

?>