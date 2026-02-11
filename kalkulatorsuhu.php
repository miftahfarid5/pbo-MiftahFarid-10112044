<?php

class kalkulatorSuhu {
public $celsius;

public function Fahrenheit() {
return ($this->celsius * 9/5) + 32;
}

public function Kelvin() {
return $this->celsius + 273.15;
}

}
$kalkulator1 = new kalkulatorSuhu();
$kalkulator1->celsius=27;

echo "<pre>";
echo "====Kalkulator Suhu====\n";
echo "satuan: celcius (°C)\n";  
echo "-----------------------\n";
echo "SUHU (C)  : " . $kalkulator1->celsius . " °C\n";
echo "FARENHEIT : " . $kalkulator1->Fahrenheit() . " °F\n";
echo "KELVIN    : " . $kalkulator1->Kelvin() . " K\n";
echo "=======================\n";
echo "<pre>";
?>