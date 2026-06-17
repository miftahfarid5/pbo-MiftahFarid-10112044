<?php
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Barang.php';

/**
 * Class Penjualan - Model OOP untuk tb_penjualan + detail_penjualan
 */
class Penjualan {
    private $db;
    private $barang;

    public function __construct() {
        $this->db     = Database::getInstance();
        $this->barang = new Barang();
    }

    public function getAll() {
        return $this->db->query(
            "SELECT p.*, c.nama_customer FROM tb_penjualan p
             JOIN tb_customer c ON p.id_customer = c.id_customer
             ORDER BY p.no_penjualan DESC"
        );
    }

    public function getById($no_penjualan) {
        $no  = $this->db->escape($no_penjualan);
        $res = $this->db->query(
            "SELECT p.*, c.nama_customer FROM tb_penjualan p
             JOIN tb_customer c ON p.id_customer = c.id_customer
             WHERE p.no_penjualan='$no'"
        );
        return mysqli_fetch_assoc($res);
    }

    public function getDetail($no_penjualan) {
        $no = $this->db->escape($no_penjualan);
        return $this->db->query(
            "SELECT d.*, b.nama_barang, j.jenis, j.satuan
             FROM detail_penjualan d
             JOIN tb_barang b ON d.kd_barang = b.kd_barang
             JOIN tb_jenis j  ON d.kode_jenis = j.kode_jenis
             WHERE d.no_penjualan='$no'"
        );
    }

    public function simpan($header, $items) {
        $no     = $this->db->escape($header['no_penjualan']);
        $tgl    = $this->db->escape($header['tanggal_penjualan']);
        $custId = $this->db->escape($header['id_customer']);
        $totBrg   = 0;
        $totHarga = 0;

        foreach ($items as $item) {
            $totBrg   += (int)$item['jumlah_barang'];
            $totHarga += (int)$item['total_harga'];
        }

        $sqlH = "INSERT INTO tb_penjualan VALUES ('$no','$tgl','$custId',$totBrg,$totHarga)";
        if (!$this->db->query($sqlH)) return false;

        foreach ($items as $item) {
            $kd   = $this->db->escape($item['kd_barang']);
            $jns  = $this->db->escape($item['kode_jenis']);
            $jml  = (int)$item['jumlah_barang'];
            $hrg  = (int)$item['harga_barang'];
            $tot  = (int)$item['total_harga'];
            $sqlD = "INSERT INTO detail_penjualan
                     (no_penjualan, kd_barang, kode_jenis, jumlah_barang, harga_barang, total_harga)
                     VALUES ('$no','$kd','$jns',$jml,$hrg,$tot)";
            $this->db->query($sqlD);
            $this->barang->updateStok($item['kd_barang'], $jml, '-');
        }
        return true;
    }

    public function delete($no_penjualan) {
        $no      = $this->db->escape($no_penjualan);
        $details = $this->getDetail($no);
        while ($d = mysqli_fetch_assoc($details)) {
            $this->barang->updateStok($d['kd_barang'], $d['jumlah_barang'], '+');
        }
        $this->db->query("DELETE FROM detail_penjualan WHERE no_penjualan='$no'");
        return $this->db->query("DELETE FROM tb_penjualan WHERE no_penjualan='$no'");
    }

    public function generateNomor() {
        $res = $this->db->query(
            "SELECT no_penjualan FROM tb_penjualan ORDER BY no_penjualan DESC LIMIT 1"
        );
        if (mysqli_num_rows($res) == 0) return 'PJL-' . date('Ymd') . '-001';
        $row   = mysqli_fetch_assoc($res);
        $parts = explode('-', $row['no_penjualan']);
        $last  = (int)end($parts);
        return 'PJL-' . date('Ymd') . '-' . str_pad($last + 1, 3, '0', STR_PAD_LEFT);
    }
}
