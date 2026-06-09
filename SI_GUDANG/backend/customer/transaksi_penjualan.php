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

$username = $_SESSION['username'];

// Cari customer berdasarkan nama_customer = username
$cek_customer = mysqli_fetch_assoc(mysqli_query($koneksi, 
    "SELECT * FROM tb_customer WHERE nama_customer='$username' OR email_customer='$username'"));
// Kalau customer belum ada di tb_customer, tampilkan tabel kosong
if($cek_customer){
    $id_customer = $cek_customer['id_customer'];
    $data = mysqli_query($koneksi, "SELECT tp.*, tc.nama_customer 
                                    FROM tb_penjualan tp
                                    LEFT JOIN tb_customer tc ON tp.id_customer = tc.id_customer
                                    WHERE tp.id_customer = '$id_customer'
                                    ORDER BY tp.no_penjualan DESC");
} else {
    // Customer belum terdaftar di tb_customer, query kosong
    $data = mysqli_query($koneksi, "SELECT tp.*, tc.nama_customer 
                                    FROM tb_penjualan tp
                                    LEFT JOIN tb_customer tc ON tp.id_customer = tc.id_customer
                                    WHERE 1=0");
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
  <title>Transaksi Penjualan</title>
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


    </ul>
  </nav>

  <div class="container-fluid page-body-wrapper">
    <nav class="navbar col-lg-12 col-12 px-0 py-0 py-lg-4 d-flex flex-row">
      <?php include('navbar.php'); ?>
    </nav>

    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
          <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <h4 class="card-title mb-0">Transaksi Penjualan Saya</h4>
                </div>

                <?php if(!$cek_customer): ?>
                <div class="alert alert-info">
                  Anda belum terdaftar sebagai customer. Silakan hubungi admin untuk mendaftarkan data Anda.
                </div>
                <?php endif; ?>

                <div class="mb-3">
                  <input type="text" id="searchTransaksi" class="form-control" placeholder="Cari No Faktur...">
                </div>
                <div class="table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>No Faktur</th>
                        <th>Tanggal</th>
                        <th>Customer</th>
                        <th>Total Barang</th>
                        <th>Total Harga</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      $no = 1; 
                      $ada_data = false;
                      while($row = mysqli_fetch_assoc($data)): 
                      $ada_data = true;
                      ?>
                      <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $row['no_penjualan']; ?></td>
                        <td><?php echo date('d-m-Y', strtotime($row['tanggal_penjualan'])); ?></td>
                        <td><?php echo $row['nama_customer']; ?></td>
                        <td><?php echo $row['total_barangall']; ?></td>
                        <td>Rp <?php echo number_format($row['total_hargaall'],0,',','.'); ?></td>
                        <td>
                          <a href="detail_penjualan.php?no_penjualan=<?php echo $row['no_penjualan']; ?>" class="btn btn-primary btn-sm">Detail</a>
                        </td>
                      </tr>
                      <?php endwhile; ?>
                      <?php if(!$ada_data): ?>
                      <tr>
                        <td colspan="7" class="text-center text-muted">Belum ada transaksi</td>
                      </tr>
                      <?php endif; ?>
                    </tbody>
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
<script>
document.addEventListener('DOMContentLoaded', function(){
    document.getElementById('searchTransaksi').addEventListener('keyup', function(){
        var keyword = this.value.toLowerCase();
        var rows = document.querySelectorAll('table tbody tr');
        rows.forEach(function(row){
            var text = row.textContent.toLowerCase();
            row.style.display = text.includes(keyword) ? '' : 'none';
        });
    });
});
</script>
<script src="../../assets/spica/vendors/chart.js/Chart.min.js"></script>
<script src="../../assets/spica/js/jquery.cookie.js"></script>
<script src="../../assets/spica/js/off-canvas.js"></script>
<script src="../../assets/spica/js/hoverable-collapse.js"></script>
<script src="../../assets/spica/js/template.js"></script>
</body>
</html>