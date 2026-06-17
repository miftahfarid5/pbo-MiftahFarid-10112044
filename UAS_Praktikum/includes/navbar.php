<?php
// includes/navbar.php
// Sertakan di setiap halaman: include ROOT . '/includes/navbar.php';
?>
<nav class="menu">
  <div class="container">
    <ul>
      <li><a href="<?= ROOT ?>/index.php">Beranda</a></li>
      <li>
        <a href="#">Data Master ▾</a>
        <ul>
          <li><a href="<?= ROOT ?>/master/">Data Gudang</a></li>
          <li><a href="<?= ROOT ?>/master/barang.php">Data Barang</a></li>
          <li><a href="<?= ROOT ?>/master/supplier.php">Data Supplier</a></li>
          <li><a href="<?= ROOT ?>/master/customer.php">Data Customer</a></li>
          <li><a href="<?= ROOT ?>/master/">Data Stok</a></li>
        </ul>
      </li>
      <li>
        <a href="#">Transaksi ▾</a>
        <ul>
          <li><a href="<?= ROOT ?>/transaksi/pembelian.php">Data Pembelian</a></li>
          <li><a href="<?= ROOT ?>/transaksi/penjualan.php">Data Penjualan</a></li>
        </ul>
      </li>
      <li>
        <a href="#">Laporan ▾</a>
        <ul>
          <li><a href="<?= ROOT ?>/laporan/penjualan.php">Laporan Penjualan</a></li>
        </ul>
      </li>
    </ul>
  </div>
</nav>
