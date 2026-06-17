<?php
require_once __DIR__ . '/Database.php';

/**
 * Class Customer - Model OOP untuk tb_customer
 */
class Customer {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll() {
        return $this->db->query("SELECT * FROM tb_customer ORDER BY id_customer");
    }

    public function getById($id_customer) {
        $id  = $this->db->escape($id_customer);
        $res = $this->db->query("SELECT * FROM tb_customer WHERE id_customer='$id'");
        return mysqli_fetch_assoc($res);
    }

    public function insert($data) {
        $id    = $this->db->escape($data['id_customer']);
        $nama  = $this->db->escape($data['nama_customer']);
        $jk    = $this->db->escape($data['jenis_kelamin']);
        $almt  = $this->db->escape($data['alamat_customer']);
        $telp  = $this->db->escape($data['telepon_customer']);
        $email = $this->db->escape($data['email_customer']);
        $pass  = $this->db->escape($data['pass_customer']);
        return $this->db->query(
            "INSERT INTO tb_customer VALUES ('$id','$nama','$jk','$almt','$telp','$email','$pass')"
        );
    }

    public function update($data) {
        $id    = $this->db->escape($data['id_customer']);
        $nama  = $this->db->escape($data['nama_customer']);
        $jk    = $this->db->escape($data['jenis_kelamin']);
        $almt  = $this->db->escape($data['alamat_customer']);
        $telp  = $this->db->escape($data['telepon_customer']);
        $email = $this->db->escape($data['email_customer']);
        $pass  = $this->db->escape($data['pass_customer']);
        return $this->db->query(
            "UPDATE tb_customer SET nama_customer='$nama', jenis_kelamin='$jk',
             alamat_customer='$almt', telepon_customer='$telp',
             email_customer='$email', pass_customer='$pass'
             WHERE id_customer='$id'"
        );
    }

    public function delete($id_customer) {
        $id = $this->db->escape($id_customer);
        return $this->db->query("DELETE FROM tb_customer WHERE id_customer='$id'");
    }

    public function generateId() {
        $res = $this->db->query("SELECT id_customer FROM tb_customer ORDER BY id_customer DESC LIMIT 1");
        if (mysqli_num_rows($res) == 0) return 'CUST001';
        $row  = mysqli_fetch_assoc($res);
        $last = (int)substr($row['id_customer'], 4);
        return 'CUST' . str_pad($last + 1, 3, '0', STR_PAD_LEFT);
    }
}
