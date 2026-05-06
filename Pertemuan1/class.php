<?php 

Class Belanja
{
    var $jumlah=3;
    var $hargaSatuan=2000;
    var $namaBarang="pencil";

    function totalHarga()
    {
        return $this->jumlah * $this->hargaSatuan;
    }

}

?>