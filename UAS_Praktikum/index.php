<?php
define('ROOT', '.');
require_once ROOT . '/classes/Database.php';
require_once ROOT . '/classes/Barang.php';
require_once ROOT . '/classes/Supplier.php';
require_once ROOT . '/classes/Customer.php';
require_once ROOT . '/classes/Pembelian.php';
require_once ROOT . '/classes/Penjualan.php';

$db       = Database::getInstance();
$barang   = new Barang();
$supplier = new Supplier();
$customer = new Customer();

$totalBarang   = mysqli_num_rows($barang->getAll());
$totalSupplier = mysqli_num_rows($supplier->getAll());
$totalCustomer = mysqli_num_rows($customer->getAll());

$resPembelian  = $db->query("SELECT COUNT(*) as jml, SUM(total_hargaall) as total FROM tb_pembelian");
$dataPembelian = mysqli_fetch_assoc($resPembelian);
$resPenjualan  = $db->query("SELECT COUNT(*) as jml, SUM(total_hargaall) as total FROM tb_penjualan");
$dataPenjualan = mysqli_fetch_assoc($resPenjualan);

function rupiah($n) {
    return 'Rp ' . number_format($n, 0, ',', '.');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Beranda - Inventory Gudang</title>
  <link rel="stylesheet" href="<?= ROOT ?>/style.css">
</head>
<body>
<div class="judul">
  <h1>Aplikasi Inventory Gudang</h1>
</div>

<?php define('ROOT_NAV',''); include ROOT . '/includes/navbar.php'; ?>

<div class="container">
  <?php if(isset($_GET['pesan'])): ?>
    <p style="color:green;font-weight:600;"><?= htmlspecialchars($_GET['pesan']) ?></p>
  <?php endif; ?>

  <h3>SELAMAT DATANG ADMIN</h3>
  <h3>DI SISTEM INFORMASI STOK GUDANG BARANG</h3>


</div>
</body>
</html>
