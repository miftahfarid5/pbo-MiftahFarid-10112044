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
?>
<!DOCTYPE html>
<html lang="en">

<head>

<style>
  .sidebar .nav .sub-menu .nav-item .nav-link {
    white-space: normal;
  }
</style>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Spica Admin</title>
  <!-- base:css -->
  <link rel="stylesheet" href="../../assets/spica/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../assets/spica/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../assets/spica/css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../../assets/spica/images/favicon.png" />
</head>
<body>
<?php include('probanner.php'); ?>

  <!-- SIDEBAR -->
 <nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item sidebar-category">
      <p>Navigation</p>
      <span></span>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="index_customer.php">
        <i class="mdi mdi-view-quilt menu-icon"></i>
        <span class="menu-title">Dashboard Customer</span>
      </a>
    </li>

    <li class="nav-item sidebar-category">
      <p>Components</p>
      <span></span>
    </li>

    <!-- Data Barang (read only) -->
    <li class="nav-item">
      <a class="nav-link" href="data_barang.php">
        <i class="mdi mdi-package-variant menu-icon"></i>
        <span class="menu-title">Data Barang</span>
      </a>
    </li>

    <!-- Transaksi -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#transaksi" aria-expanded="false" aria-controls="transaksi">
        <i class="mdi mdi-cart menu-icon"></i>
        <span class="menu-title">Transaksi</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="transaksi">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"><a class="nav-link" href="transaksi_penjualan.php">Transaksi Penjualan</a></li>
        </ul>
      </div>
    </li>

    <!-- Profil -->
    <li class="nav-item">
      <a class="nav-link" href="profil.php">
        <i class="mdi mdi-account menu-icon"></i>
        <span class="menu-title">Profil Saya</span>
      </a>
    </li>

  </ul>
</nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:./partials/_navbar.html -->
      <nav class="navbar col-lg-12 col-12 px-0 py-0 py-lg-4 d-flex flex-row">
       <?php include('navbar.php'); ?>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <?php include('main_panel.php'); ?>
          <!-- row end -->
          <div class="row">
            <div class="col-md-4 grid-margin stretch-card">
              <div class="card bg-facebook d-flex align-items-center">
                <div class="card-body py-5">
                  <div
                    class="d-flex flex-row align-items-center flex-wrap justify-content-md-center justify-content-xl-start py-1">
                    <i class="mdi mdi-facebook text-white icon-lg"></i>
                    <div class="ms-3 ml-md-0 ml-xl-3">
                      <h5 class="text-white font-weight-bold">2.62 Subscribers</h5>
                      <p class="mt-2 text-white card-text">You main list growing</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
              <div class="card bg-google d-flex align-items-center">
                <div class="card-body py-5">
                  <div
                    class="d-flex flex-row align-items-center flex-wrap justify-content-md-center justify-content-xl-start py-1">
                    <i class="mdi mdi-google-plus text-white icon-lg"></i>
                    <div class="ms-3 ml-md-0 ml-xl-3">
                      <h5 class="text-white font-weight-bold">3.4k Followers</h5>
                      <p class="mt-2 text-white card-text">You main list growing</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
              <div class="card bg-twitter d-flex align-items-center">
                <div class="card-body py-5">
                  <div
                    class="d-flex flex-row align-items-center flex-wrap justify-content-md-center justify-content-xl-start py-1">
                    <i class="mdi mdi-twitter text-white icon-lg"></i>
                    <div class="ms-3 ml-md-0 ml-xl-3">
                      <h5 class="text-white font-weight-bold">3k followers</h5>
                      <p class="mt-2 text-white card-text">You main list growing</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- row end -->
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:./partials/_footer.html -->
        <footer class="footer">
          <div class="card">
            <div class="card-body">
              <div class="d-sm-flex justify-content-center justify-content-sm-between py-2">
                <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © <a href="https://www.bootstrapdash.com/" target="_blank">bootstrapdash.com </a>2021</span>
                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Only the best <a href="https://www.bootstrapdash.com/" target="_blank"> Bootstrap dashboard </a> templates</span>
              </div>
            </div>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- base:js -->
  <script src="../../assets/spica/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <script src="../../assets/spica/vendors/chart.js/Chart.min.js"></script>
  <script src="../../assets/spica/js/jquery.cookie.js" type="text/javascript"></script>
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="../../assets/spica/js/off-canvas.js"></script>
  <script src="../../assets/spica/js/hoverable-collapse.js"></script>
  <script src="../../assets/spica/js/template.js"></script>
  <!-- endinject -->
  <!-- plugin js for this page -->
    <script src="../../assets/spica/js/jquery.cookie.js" type="text/javascript"></script>
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <script src="../../assets/spica/js/dashboard.js"></script>
  <!-- End custom js for this page-->


</body>

</html>