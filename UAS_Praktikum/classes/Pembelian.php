<?php
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Barang.php';

/**
 * Class Pembelian - Model OOP untuk tb_pembelian + detail_pembelian
 */
class Pembelian {
    private $db;
    private $barang;

    public function __construct() {
        $this->db     = Database::getInstance();
        $this->barang = new Barang();
    }

    public function getAll() {
        return $this->db->query(
            "SELECT p.*, s.nama_supplier FROM tb_pembelian p
             JOIN tb_supplier s ON p.id_supplier = s.id_supplier
             ORDER BY p.no_pembelian DESC"
        );
    }

    public function getById($no_pembelian) {
        $no  = $this->db->escape($no_pembelian);
        $res = $this->db->query(
            "SELECT p.*, s.nama_supplier FROM tb_pembelian p
             JOIN tb_supplier s ON p.id_supplier = s.id_supplier
             WHERE p.no_pembelian='$no'"
        );
        return mysqli_fetch_assoc($res);
    }

    public function getDetail($no_pembelian) {
        $no = $this->db->escape($no_pembelian);
        return $this->db->query(
            "SELECT d.*, b.nama_barang, j.jenis, j.satuan
             FROM detail_pembelian d
             JOIN tb_barang b ON d.kd_barang = b.kd_barang
             JOIN tb_jenis j  ON d.kode_jenis = j.kode_jenis
             WHERE d.no_pembelian='$no'"
        );
    }

    public function simpan($header, $items) {
        $no    = $this->db->escape($header['no_pembelian']);
        $tgl   = $this->db->escape($header['tanggal_pembelian']);
        $supId = $this->db->escape($header['id_supplier']);
        $totBrg   = 0;
        $totHarga = 0;

        foreach ($items as $item) {
            $totBrg   += (int)$item['jumlah_barang'];
            $totHarga += (int)$item['total_harga'];
        }

        $sqlH = "INSERT INTO tb_pembelian VALUES ('$no','$tgl','$supId',$totBrg,$totHarga)";
        if (!$this->db->query($sqlH)) return false;

        foreach ($items as $item) {
            $kd   = $this->db->escape($item['kd_barang']);
            $jns  = $this->db->escape($item['kode_jenis']);
            $jml  = (int)$item['jumlah_barang'];
            $hrg  = (int)$item['harga_barang'];
            $tot  = (int)$item['total_harga'];
            $sqlD = "INSERT INTO detail_pembelian
                     (no_pembelian, kd_barang, kode_jenis, jumlah_barang, harga_barang, total_harga)
                     VALUES ('$no','$kd','$jns',$jml,$hrg,$tot)";
            $this->db->query($sqlD);
            $this->barang->updateStok($item['kd_barang'], $jml, '+');
        }
        return true;
    }

    public function delete($no_pembelian) {
        $no      = $this->db->escape($no_pembelian);
        $details = $this->getDetail($no);
        while ($d = mysqli_fetch_assoc($details)) {
            $this->barang->updateStok($d['kd_barang'], $d['jumlah_barang'], '-');
        }
        $this->db->query("DELETE FROM detail_pembelian WHERE no_pembelian='$no'");
        return $this->db->query("DELETE FROM tb_pembelian WHERE no_pembelian='$no'");
    }

    public function generateNomor() {
        $res = $this->db->query(
            "SELECT no_pembelian FROM tb_pembelian ORDER BY no_pembelian DESC LIMIT 1"
        );
        if (mysqli_num_rows($res) == 0) return 'PBL-' . date('Ymd') . '-001';
        $row   = mysqli_fetch_assoc($res);
        $parts = explode('-', $row['no_pembelian']);
        $last  = (int)end($parts);
        return 'PBL-' . date('Ymd') . '-' . str_pad($last + 1, 3, '0', STR_PAD_LEFT);
    }
}
