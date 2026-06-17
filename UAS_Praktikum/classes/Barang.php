<?php
require_once __DIR__ . '/Database.php';

/**
 * Class Barang - Model OOP untuk tb_barang
 */
class Barang {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll() {
        $sql = "SELECT b.*, j.jenis, j.satuan
                FROM tb_barang b
                JOIN tb_jenis j ON b.kode_jenis = j.kode_jenis
                ORDER BY b.kd_barang";
        return $this->db->query($sql);
    }

    public function getById($kd_barang) {
        $kd = $this->db->escape($kd_barang);
        $sql = "SELECT b.*, j.jenis, j.satuan
                FROM tb_barang b
                JOIN tb_jenis j ON b.kode_jenis = j.kode_jenis
                WHERE b.kd_barang='$kd'";
        $res = $this->db->query($sql);
        return mysqli_fetch_assoc($res);
    }

    public function insert($data) {
        $kd   = $this->db->escape($data['kd_barang']);
        $jns  = $this->db->escape($data['kode_jenis']);
        $nama = $this->db->escape($data['nama_barang']);
        $stok = (int)$data['stok'];
        $beli = (int)$data['harga_beli'];
        $jual = (int)$data['harga_jual'];
        $sql  = "INSERT INTO tb_barang (kd_barang, kode_jenis, nama_barang, stok, harga_beli, harga_jual)
                 VALUES ('$kd','$jns','$nama',$stok,$beli,$jual)";
        return $this->db->query($sql);
    }

    public function update($data) {
        $kd   = $this->db->escape($data['kd_barang']);
        $jns  = $this->db->escape($data['kode_jenis']);
        $nama = $this->db->escape($data['nama_barang']);
        $stok = (int)$data['stok'];
        $beli = (int)$data['harga_beli'];
        $jual = (int)$data['harga_jual'];
        $sql  = "UPDATE tb_barang SET kode_jenis='$jns', nama_barang='$nama',
                 stok=$stok, harga_beli=$beli, harga_jual=$jual
                 WHERE kd_barang='$kd'";
        return $this->db->query($sql);
    }

    public function delete($kd_barang) {
        $kd  = $this->db->escape($kd_barang);
        return $this->db->query("DELETE FROM tb_barang WHERE kd_barang='$kd'");
    }

    public function updateStok($kd_barang, $jumlah, $operasi = '+') {
        $kd  = $this->db->escape($kd_barang);
        $jml = (int)$jumlah;
        $op  = ($operasi === '+') ? '+' : '-';
        return $this->db->query("UPDATE tb_barang SET stok = stok $op $jml WHERE kd_barang='$kd'");
    }

    public function generateKode() {
        $res = $this->db->query("SELECT kd_barang FROM tb_barang ORDER BY kd_barang DESC LIMIT 1");
        if (mysqli_num_rows($res) == 0) return 'BRG001';
        $row  = mysqli_fetch_assoc($res);
        $last = (int)substr($row['kd_barang'], 3);
        return 'BRG' . str_pad($last + 1, 3, '0', STR_PAD_LEFT);
    }
}
