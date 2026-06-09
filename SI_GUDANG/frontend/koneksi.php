<?php
// Aktifkan mode pelaporan error agar mysqli melempar Exception saat gagal
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = "localhost";
$username = "root";
$password = "";
$database = "db_Inventory";

try {
    // Mencoba melakukan koneksi ke database
    $koneksi = mysqli_connect($host, $username, $password, $database);
    
} catch (mysqli_sql_exception $e) {
    // Jika gagal, error ditangkap di sini secara halus tanpa mematikan paksa web
    echo "<div style='color: red; padding: 15px; border: 1px solid red; background: #fff0f0;'>";
    echo "<h3>MAAF, Gagal Terhubung ke Database!</h3>";
    echo "Pesan Kesalahan: " . $e->getMessage();
    echo "</div>";
    
    // Kita buat variabel $koneksi menjadi false agar file index.php tahu kalau koneksi gagal
    $koneksi = false; 
}
?>
