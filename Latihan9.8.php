<?php 

class manusia{
    //
    protected $nama="Ardi";
    var $kelas="SI 2";

    //method manusia
    protected function m_nama(){
        return $this->nama;
    }

    public function tampilan_nama(){
        return $this->m_nama();
    }

    public function tampilan_kelas(){
        return $this->kelas;
    }

}
//instansiasi class manusia
$manusia = new manusia ();

//memanggil method tampilkan_nama dari class manusia
echo "Nama : ".$manusia->tampilan_nama()."<br/>";
echo "Kelas : ".$manusia->tampilan_kelas();

?>