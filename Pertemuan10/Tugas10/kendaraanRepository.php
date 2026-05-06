<?php

class KendaraanRepository {

    public function getAll(){
        return [
            ["merek"=>"Yamaha Mio",    "jumlahRoda"=>2, "harga"=>10000000,  "warna"=>"Merah", "bahanBakar"=>"Premium"],
            ["merek"=>"Toyota Yaris",  "jumlahRoda"=>4, "harga"=>160000000, "warna"=>"Merah", "bahanBakar"=>"Premium"],
            ["merek"=>"Honda Scoopy",  "jumlahRoda"=>2, "harga"=>13000000,  "warna"=>"Putih", "bahanBakar"=>"Premium"],
            ["merek"=>"Isuzu Panther", "jumlahRoda"=>4, "harga"=>170000000, "warna"=>"Merah", "bahanBakar"=>"Solar"]
        ];
    }
}