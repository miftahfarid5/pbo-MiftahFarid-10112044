<?php

class Kendaraan {

    private $merek;
    private $jumlahRoda;
    private $harga;
    private $warna;
    private $bahanBakar;

    public function setData($merek, $jumlahRoda, $harga, $warna, $bahanBakar){
        $this->merek      = $merek;
        $this->jumlahRoda = $jumlahRoda;
        $this->harga      = $harga;
        $this->warna      = $warna;
        $this->bahanBakar = $bahanBakar;
    }

    public function getMerek(){
        return $this->merek;
    }

    public function getJumlahRoda(){
        return $this->jumlahRoda;
    }

    public function getHarga(){
        return $this->harga;
    }

    public function getWarna(){
        return $this->warna;
    }

    public function getBahanBakar(){
        return $this->bahanBakar;
    }
}