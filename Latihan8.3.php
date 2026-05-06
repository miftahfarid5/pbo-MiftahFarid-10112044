<?php

echo "Siapa nama kamu: ";
$input_nama = fopen("php://stdin", "r");
$nama = trim(fgets($input_nama));

echo "Hallo $nama, apa kabar?\n";

?>