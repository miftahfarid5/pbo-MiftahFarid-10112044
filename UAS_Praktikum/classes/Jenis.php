<?php
require_once __DIR__ . '/Database.php';

/**
 * Class Jenis - Model OOP untuk tb_jenis
 */
class Jenis {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll() {
        return $this->db->query("SELECT * FROM tb_jenis ORDER BY kode_jenis");
    }

    public function getById($kode_jenis) {
        $kd  = $this->db->escape($kode_jenis);
        $res = $this->db->query("SELECT * FROM tb_jenis WHERE kode_jenis='$kd'");
        return mysqli_fetch_assoc($res);
    }

    public function insert($data) {
        $kd  = $this->db->escape($data['kode_jenis']);
        $jns = $this->db->escape($data['jenis']);
        $sat = $this->db->escape($data['satuan']);
        return $this->db->query("INSERT INTO tb_jenis VALUES ('$kd','$jns','$sat')");
    }

    public function update($data) {
        $kd  = $this->db->escape($data['kode_jenis']);
        $jns = $this->db->escape($data['jenis']);
        $sat = $this->db->escape($data['satuan']);
        return $this->db->query(
            "UPDATE tb_jenis SET jenis='$jns', satuan='$sat' WHERE kode_jenis='$kd'"
        );
    }

    public function delete($kode_jenis) {
        $kd = $this->db->escape($kode_jenis);
        return $this->db->query("DELETE FROM tb_jenis WHERE kode_jenis='$kd'");
    }

    public function generateKode() {
        $res = $this->db->query("SELECT kode_jenis FROM tb_jenis ORDER BY kode_jenis DESC LIMIT 1");
        if (mysqli_num_rows($res) == 0) return 'JNS001';
        $row  = mysqli_fetch_assoc($res);
        $last = (int)substr($row['kode_jenis'], 3);
        return 'JNS' . str_pad($last + 1, 3, '0', STR_PAD_LEFT);
    }
}
