<?php

class KonversiSuhu
{
   public $celcius;
   public $hasil = [];

   // Constructor
   public function __construct($celcius)
   {
       $this->celcius = (float)$celcius;

       // Array hasil konversi
       $this->hasil = [
           "Celcius" => $this->celcius,
           "Reamur" => $this->celcius * 4 / 5,
           "Fahrenheit" => ($this->celcius * 9 / 5) + 32,
           "Kelvin" => $this->celcius + 273.15
       ];
   }

   // Method tampil hasil
   public function tampilkanHasil()
   {
       echo "\n===== HASIL KONVERSI SUHU =====\n";

       foreach ($this->hasil as $jenis => $nilai) {
           // Percabangan
           if ($jenis == "Celcius") {
               echo "$jenis = $nilai derajat\n";
           } else {
               echo "$jenis = " . round($nilai, 2) . " derajat\n";
           }
       }
   }
}

// DATA AWAL
$konversi = new KonversiSuhu(36);

// MENU PROGRAM
do {
   echo "\n===== MENU KONVERSI SUHU =====\n";
   echo "1. Tampilkan Hasil Konversi\n";
   echo "2. Input Suhu Baru\n";
   echo "3. Keluar\n";
   echo "Pilih menu: ";

   $menu = trim(fgets(STDIN));

   switch ($menu) {
       case 1:
           $konversi->tampilkanHasil();
           break;

       case 2:
           echo "Masukkan suhu dalam Celcius: ";
           $celcius = trim(fgets(STDIN));

           if (!is_numeric($celcius)) {
               echo "Input suhu tidak valid!\n";
               break;
           }

           $konversi = new KonversiSuhu($celcius);
           echo "Suhu berhasil diperbarui.\n";
           break;

       case 3:
           echo "Program selesai.\n";
           break;

       default:
           echo "Menu tidak valid.\n";
   }

} while ($menu != 3);

?>