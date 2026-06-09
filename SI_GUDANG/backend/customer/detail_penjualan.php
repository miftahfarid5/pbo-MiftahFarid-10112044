<?php
session_start();
include('../../koneksi.php');
if(!isset($_SESSION['username'])){
    header("Location: ../../login.php");
    exit;
}
if($_SESSION['tipe_user'] != 'Customer'){
    header("Location: ../../login.php");
    exit;
}
if(!isset($_GET['no_penjualan']) || empty($_GET['no_penjualan'])){
    echo "<script>alert('No penjualan tidak ditemukan!');window.location='transaksi_penjualan.php';</script>";
    exit;
}

$no_penjualan = $_GET['no_penjualan'];

// Ambil data detail transaksi
$detail = mysqli_query($koneksi,
    "SELECT dp.*, tb.nama_barang, tj.jenis FROM detail_penjualan dp
     LEFT JOIN tb_barang tb ON dp.kd_barang = tb.kd_barang
     LEFT JOIN tb_jenis tj ON dp.kode_jenis = tj.kode_jenis
     WHERE dp.no_penjualan='$no_penjualan'
     ORDER BY dp.no_item ASC");

// Ambil data header transaksi
$header = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT tp.*, tc.nama_customer FROM tb_penjualan tp
     LEFT JOIN tb_customer tc ON tp.id_customer = tc.id_customer
     WHERE tp.no_penjualan='$no_penjualan'"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<style>
  .sidebar .nav .sub-menu .nav-item .nav-link {
    white-space: normal;
  }
</style>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Detail Penjualan</title>
  <link rel="stylesheet" href="../../assets/spica/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../assets/spica/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="../../assets/spica/css/style.css">
  <link rel="shortcut icon" href="../../assets/spica/images/favicon.png" />
</head>
<body>
<div class="container-scroller d-flex">

  <!-- SIDEBAR -->
  <nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item sidebar-category"><p>Navigation</p><span></span></li>
      <li class="nav-item">
        <a class="nav-link" href="index_customer.php">
          <i class="mdi mdi-view-quilt menu-icon"></i>
          <span class="menu-title">Dashboard Customer</span>
        </a>
      </li>
      <li class="nav-item sidebar-category"><p>Components</p><span></span></li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false">
          <i class="mdi mdi-view-headline menu-icon"></i>
          <span class="menu-title">Kelola Data</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-basic">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link" href="data_barang.php">Data Barang</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="true">
          <i class="mdi mdi-view-headline menu-icon"></i>
          <span class="menu-title">Kelola Transaksi</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse show" id="auth">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link active" href="transaksi_penjualan.php">Transaksi Penjualan</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="profil.php">
          <i class="mdi mdi-account menu-icon"></i>
          <span class="menu-title">Profil Saya</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../../proses.php?action=logout">
          <i class="mdi mdi-logout menu-icon"></i>
          <span class="menu-title">Logout</span>
        </a>
      </li>
    </ul>
  </nav>

  <div class="container-fluid page-body-wrapper">
    <nav class="navbar col-lg-12 col-12 px-0 py-0 py-lg-4 d-flex flex-row">
      <?php include('navbar.php'); ?>
    </nav>

    <div class="main-panel">
      <div class="content-wrapper">

        <!-- INFO HEADER TRANSAKSI -->
        <div class="row">
          <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <h4 class="card-title mb-0">Detail Transaksi Penjualan</h4>
                  <a href="transaksi_penjualan.php" class="btn btn-danger btn-sm">Kembali</a>
                </div>

               <!-- Info Header -->
<div class="row mb-4">
  <div class="col-md-6">
    <table class="table table-borderless">
      <tr>
        <td class="font-weight-bold" width="150">No Faktur</td>
        <td>: <?php echo $header['no_penjualan']; ?></td>
      </tr>
      <tr>
        <td class="font-weight-bold">Tanggal</td>
        <td>: <?php echo date('d-m-Y', strtotime($header['tanggal_penjualan'])); ?></td>
      </tr>
      <tr>
        <td class="font-weight-bold">Customer</td>
        <td>: <?php echo $header['nama_customer']; ?></td>
      </tr>
     
    </table>
  </div>
  <div class="col-md-6">
    <table class="table table-borderless">
      <tr>
        <td class="font-weight-bold" width="150">Total Barang</td>
        <td>: <?php echo $header['total_barangall']; ?> item</td>
      </tr>
      <tr>
        <td class="font-weight-bold">Total Harga</td>
        <td>: Rp <?php echo number_format($header['total_hargaall'],0,',','.'); ?>,00</td>
      </tr>
       <tr>
        <td class="font-weight-bold">Keterangan</td>
        <td>: <?php 
          // Ambil nama admin yang memproses
          $admin = mysqli_fetch_assoc(mysqli_query($koneksi, 
            "SELECT username FROM user WHERE tipe_user='Administrator' LIMIT 1"));
          echo "Diproses oleh Administrator (".$admin['username'].")"; 
        ?></td>
      </tr>
    </table>
  </div>
</div>

                <!-- Tabel Detail -->
                <div class="table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Harga Jual</th>
                        <th>Total Harga</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      $ada_data = false;
                      while($d = mysqli_fetch_assoc($detail)):
                      $ada_data = true;
                      ?>
                      <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $d['kd_barang']; ?></td>
                        <td><?php echo $d['nama_barang']; ?></td>
                        <td><?php echo $d['jenis']; ?></td>
                        <td><?php echo $d['jumlah_barang']; ?></td>
                        <td>Rp <?php echo number_format($d['harga_barang'],0,',','.'); ?>,00</td>
                        <td>Rp <?php echo number_format($d['total_harga'],0,',','.'); ?>,00</td>
                      </tr>
                      <?php endwhile; ?>
                      <?php if(!$ada_data): ?>
                      <tr>
                        <td colspan="7" class="text-center text-muted">Belum ada item dalam transaksi ini</td>
                      </tr>
                      <?php endif; ?>
                    </tbody>
                    <?php if($ada_data): ?>
                    <tfoot>
                      <tr>
                        <th colspan="4" class="text-right">Total</th>
                        <th><?php echo $header['total_barangall']; ?> item</th>
                        <th></th>
                        <th>Rp <?php echo number_format($header['total_hargaall'],0,',','.'); ?>,00</th>
                      </tr>
                    </tfoot>
                    <?php endif; ?>
                  </table>
                </div>

              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<script src="../../assets/spica/vendors/js/vendor.bundle.base.js"></script>
<script src="../../assets/spica/vendors/chart.js/Chart.min.js"></script>
<script src="../../assets/spica/js/jquery.cookie.js"></script>
<script src="../../assets/spica/js/off-canvas.js"></script>
<script src="../../assets/spica/js/hoverable-collapse.js"></script>
<script src="../../assets/spica/js/template.js"></script>
</body>
</html>