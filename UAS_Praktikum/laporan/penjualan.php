<?php
define('ROOT', '..');
require_once ROOT . '/classes/Database.php';

$db = Database::getInstance();
function rupiah($n) { return 'Rp ' . number_format($n, 0, ',', '.'); }

$dari   = $_GET['dari']   ?? date('Y-m-01');
$sampai = $_GET['sampai'] ?? date('Y-m-d');

$res = $db->query(
    "SELECT p.*, c.nama_customer FROM tb_penjualan p
     JOIN tb_customer c ON p.id_customer = c.id_customer
     WHERE p.tanggal_penjualan BETWEEN '$dari' AND '$sampai'
     ORDER BY p.tanggal_penjualan ASC"
);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Penjualan</title>
  <link rel="stylesheet" href="<?= ROOT ?>/style.css">
  <style>@media print { nav, form, .no-print { display:none; } }</style>
</head>
<body>
<div class="judul">
  <h1>Aplikasi Inventory Gudang</h1>
  <h2>Laporan Transaksi Penjualan</h2>
</div>
<?php include ROOT . '/includes/navbar.php'; ?>
<div class="container">
  <form method="get" class="no-print" style="margin:16px 0;">
    <label>Dari: <input type="date" name="dari" value="<?= $dari ?>"></label>
    &nbsp;
    <label>Sampai: <input type="date" name="sampai" value="<?= $sampai ?>"></label>
    &nbsp;
    <input type="submit" value="Filter">
    &nbsp;
    <button type="button" onclick="window.print()" style="background:#2d89ef;color:#fff;border:none;padding:5px 14px;cursor:pointer;border-radius:3px;">🖨 Cetak</button>
  </form>

  <h3>Laporan Penjualan: <?= date('d/m/Y', strtotime($dari)) ?> s/d <?= date('d/m/Y', strtotime($sampai)) ?></h3>
  <table border="1" class="table">
    <tr>
      <th>No</th><th>No Penjualan</th><th>Tanggal</th><th>Customer</th>
      <th>Total Barang</th><th>Total Harga</th>
    </tr>
    <?php
    $no = 1; $grandTotal = 0; $grandBarang = 0;
    while ($d = mysqli_fetch_assoc($res)):
        $grandTotal  += $d['total_hargaall'];
        $grandBarang += $d['total_barangall'];
    ?>
    <tr>
      <td><?= $no++ ?></td>
      <td><?= $d['no_penjualan'] ?></td>
      <td><?= date('d/m/Y', strtotime($d['tanggal_penjualan'])) ?></td>
      <td><?= $d['nama_customer'] ?></td>
      <td style="text-align:center;"><?= $d['total_barangall'] ?></td>
      <td><?= rupiah($d['total_hargaall']) ?></td>
    </tr>
    <?php endwhile; ?>
    <tr style="font-weight:700; background:#eef4f6;">
      <td colspan="4" style="text-align:right;">TOTAL</td>
      <td style="text-align:center;"><?= $grandBarang ?></td>
      <td><?= rupiah($grandTotal) ?></td>
    </tr>
  </table>
</div>
</body>
</html>
