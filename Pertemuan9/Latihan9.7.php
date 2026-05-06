<?php 

class manusia{
    //
    private $nama="Ardi";
    private $kelas="SI 2";

    //method manusia
    private function m_nama(){
        return $this->nama;
    }

    public function tampilan_nama(){
        return $this->m_nama();
    }

    function tampilan_kelas(){
        return $this->kelas;
    }

}
//instansiasi class manusia
$manusia = new manusia ();

//memanggil method tampilkan_nama dari class manusia
echo "Nama : ".$manusia->tampilan_nama()."<br/>";
echo "Kelas : ".$manusia->tampilan_kelas();

?>