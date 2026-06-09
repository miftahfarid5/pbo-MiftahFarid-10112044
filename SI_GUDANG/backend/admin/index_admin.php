<?php
session_start();
include('../../koneksi.php');
if(!isset($_SESSION['username'])){
    header("Location: ../../login.php");
    exit;
}
if($_SESSION['tipe_user'] != 'Administrator'){
    header("Location: ../../login.php");
    exit;
}
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
  <title>Halaman <?php echo $_SESSION['tipe_user']; ?></title>
  <link rel="stylesheet" href="../../assets/spica/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../assets/spica/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="../../assets/spica/css/style.css">
  <link rel="shortcut icon" href="../../assets/spica/images/favicon.png" />
</head>
<body>

<?php include('probanner.php'); ?>

  <div class="container-scroller d-flex">

    <!-- ===== SIDEBAR ===== -->
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
      <ul class="nav">
        <li class="nav-item sidebar-category">
          <p>Navigation</p>
          <span></span>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index_admin.php">
            <i class="mdi mdi-view-quilt menu-icon"></i>
            <span class="menu-title">Dashboard Admin</span>
          </a>
        </li>
        <li class="nav-item sidebar-category">
          <p>Components</p>
          <span></span>
        </li>

        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
            <i class="mdi mdi-view-headline menu-icon"></i>
            <span class="menu-title">Kelola Data</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="ui-basic">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item"><a class="nav-link" href="data_barang.php">Data Barang</a></li>
              <li class="nav-item"><a class="nav-link" href="data_customer.php">Data Customer</a></li>
              <li class="nav-item"><a class="nav-link" href="data_supplier.php">Data Supplier</a></li>
            </ul>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
            <i class="mdi mdi-view-headline menu-icon"></i>
            <span class="menu-title">Kelola Transaksi</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="auth">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item"><a class="nav-link" href="transaksi_pembelian.php">Transaksi Pembelian</a></li>
              <li class="nav-item"><a class="nav-link" href="transaksi_penjualan.php">Transaksi Penjualan</a></li>
            </ul>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#auth2" aria-expanded="false" aria-controls="auth2">
            <i class="mdi mdi-view-headline menu-icon"></i>
            <span class="menu-title">Kelola Laporan</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="auth2">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item"><a class="nav-link" href="laporan_pembelian.php">Laporan Transaksi Pembelian</a></li>
              <li class="nav-item"><a class="nav-link" href="laporan_penjualan.php">Laporan Transaksi Penjualan</a></li>
              <li class="nav-item"><a class="nav-link" href="laporan_customer.php">Laporan Data Customer</a></li>
              <li class="nav-item"><a class="nav-link" href="laporan_supplier.php">Laporan Data Supplier</a></li>
            </ul>
          </div>
        </li>
  <li class="nav-item">
        <a class="nav-link" href="profil.php">
          <i class="mdi mdi-account menu-icon"></i>
          <span class="menu-title">Profil Saya</span>
        </a>
      </li>
      </ul>
    </nav>
    <!-- ===== END SIDEBAR ===== -->

    <!-- ===== PAGE BODY WRAPPER (NAVBAR + MAIN PANEL) ===== -->
    <div class="container-fluid page-body-wrapper">

      <!-- ===== NAVBAR ===== -->
      <nav class="navbar col-lg-12 col-12 px-0 py-0 py-lg-4 d-flex flex-row">
        <?php include('navbar.php'); ?>
      </nav>
      <!-- ===== END NAVBAR ===== -->

      <!-- ===== MAIN PANEL ===== -->
      <div class="main-panel">
        <?php include('main_panel.php'); ?>
      </div>
      <!-- ===== END MAIN PANEL ===== -->

    </div>
    <!-- ===== END PAGE BODY WRAPPER ===== -->

  </div>
  <!-- container-scroller -->

  <script src="../../assets/spica/vendors/js/vendor.bundle.base.js"></script>
  <script src="../../assets/spica/vendors/chart.js/Chart.min.js"></script>
  <script src="../../assets/spica/js/jquery.cookie.js" type="text/javascript"></script>
  <script src="../../assets/spica/js/off-canvas.js"></script>
  <script src="../../assets/spica/js/hoverable-collapse.js"></script>
  <script src="../../assets/spica/js/template.js"></script>
  <script src="../../assets/spica/js/dashboard.js"></script>

</body>
</html>