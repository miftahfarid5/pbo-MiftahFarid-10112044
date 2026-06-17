<?php
/**
 * Class Database - Koneksi Singleton ke MySQL
 */
class Database {
    private static $instance = null;
    private $koneksi;

    private function __construct() {
        $host     = "localhost";
        $username = "root";
        $password = "";
        $database = "db_inventory";
        $this->koneksi = mysqli_connect($host, $username, $password, $database);
        if (!$this->koneksi) {
            die("Koneksi gagal: " . mysqli_connect_error());
        }
        mysqli_set_charset($this->koneksi, "utf8");
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getKoneksi() {
        return $this->koneksi;
    }

    public function query($sql) {
        return mysqli_query($this->koneksi, $sql);
    }

    public function escape($value) {
        return mysqli_real_escape_string($this->koneksi, $value);
    }
}
