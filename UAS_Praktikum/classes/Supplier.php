<?php
require_once __DIR__ . '/Database.php';

/**
 * Class Supplier - Model OOP untuk tb_supplier
 */
class Supplier {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll() {
        return $this->db->query("SELECT * FROM tb_supplier ORDER BY id_supplier");
    }

    public function getById($id_supplier) {
        $id  = $this->db->escape($id_supplier);
        $res = $this->db->query("SELECT * FROM tb_supplier WHERE id_supplier='$id'");
        return mysqli_fetch_assoc($res);
    }

    public function insert($data) {
        $id    = $this->db->escape($data['id_supplier']);
        $nama  = $this->db->escape($data['nama_supplier']);
        $almt  = $this->db->escape($data['alamat_supplier']);
        $telp  = $this->db->escape($data['telepon_supplier']);
        $email = $this->db->escape($data['email_supplier']);
        $pass  = $this->db->escape($data['pass_supplier']);
        return $this->db->query(
            "INSERT INTO tb_supplier VALUES ('$id','$nama','$almt','$telp','$email','$pass')"
        );
    }

    public function update($data) {
        $id    = $this->db->escape($data['id_supplier']);
        $nama  = $this->db->escape($data['nama_supplier']);
        $almt  = $this->db->escape($data['alamat_supplier']);
        $telp  = $this->db->escape($data['telepon_supplier']);
        $email = $this->db->escape($data['email_supplier']);
        $pass  = $this->db->escape($data['pass_supplier']);
        return $this->db->query(
            "UPDATE tb_supplier SET nama_supplier='$nama', alamat_supplier='$almt',
             telepon_supplier='$telp', email_supplier='$email', pass_supplier='$pass'
             WHERE id_supplier='$id'"
        );
    }

    public function delete($id_supplier) {
        $id = $this->db->escape($id_supplier);
        return $this->db->query("DELETE FROM tb_supplier WHERE id_supplier='$id'");
    }

    public function generateId() {
        $res = $this->db->query("SELECT id_supplier FROM tb_supplier ORDER BY id_supplier DESC LIMIT 1");
        if (mysqli_num_rows($res) == 0) return 'SUP001';
        $row  = mysqli_fetch_assoc($res);
        $last = (int)substr($row['id_supplier'], 3);
        return 'SUP' . str_pad($last + 1, 3, '0', STR_PAD_LEFT);
    }
}
