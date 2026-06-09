<?php
global $koneksi;
session_start();
include('../../koneksi.php');
if(!isset($_SESSION['username'])){
    header("Location: ../../login.php");
    exit;
}
if($_SESSION['tipe_user'] != 'Supplier'){
    header("Location: ../../login.php");
    exit;
}

$username = $_SESSION['username'];

// Ambil data supplier
$cek_supplier = mysqli_fetch_assoc(mysqli_query($koneksi, 
    "SELECT * FROM tb_supplier WHERE nama_supplier='$username' OR email_supplier='$username'"));

// PROSES UPDATE
if(isset($_POST['update'])){
    $nama     = $_POST['nama_supplier'];
    $alamat   = $_POST['alamat_supplier'];
    $telepon  = $_POST['telepon_supplier'];
    $email    = $_POST['email_supplier'];
    $password = $_POST['password'];

    if(!empty($password)){
        $query = "UPDATE tb_supplier SET 
                    nama_supplier='$nama',
                    alamat_supplier='$alamat',
                    telepon_supplier='$telepon',
                    email_supplier='$email',
                    pass_supplier='$password'
                  WHERE id_supplier='".$cek_supplier['id_supplier']."'";
    } else {
        $query = "UPDATE tb_supplier SET 
                    nama_supplier='$nama',
                    alamat_supplier='$alamat',
                    telepon_supplier='$telepon',
                    email_supplier='$email'
                  WHERE id_supplier='".$cek_supplier['id_supplier']."'";
    }

    if(mysqli_query($koneksi, $query)){
        echo "<script>alert('Profil berhasil diupdate!');window.location='profil.php';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal update profil!');</script>";
    }
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
  <title>Profil Supplier</title>
  <link rel="stylesheet" href="../../assets/spica/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../assets/spica/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="../../assets/spica/css/style.css">
  <link rel="shortcut icon" href="../../assets/spica/images/favicon.png" />
</head>
<body>
<div class="container-scroller d-flex">

  <div class="row p-0 m-0 proBanner" id="proBanner">
    <div class="col-md-12 p-0 m-0">
      <div class="card-body card-body-padding d-flex align-items-center justify-content-between">
        <div class="ps-lg-1">
          <div class="d-flex align-items-center justify-content-between">
            <p class="mb-0 font-weight-medium me-3 buy-now-text">Free 24/7 customer support, updates, and more with this template!</p>
            <a href="https://www.bootstrapdash.com/product/spica-admin/" target="_blank" class="btn me-2 buy-now-btn border-0">Get Pro</a>
          </div>
        </div>
        <div class="d-flex align-items-center justify-content-between">
          <a href="https://www.bootstrapdash.com/product/spica-admin/"><i class="mdi mdi-home me-3 text-white"></i></a>
          <button id="bannerClose" class="btn border-0 p-0">
            <i class="mdi mdi-close text-white mr-0"></i>
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- SIDEBAR -->
  <nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item sidebar-category">
        <p>Navigation</p>
        <span></span>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index_supplier.php">
          <i class="mdi mdi-view-quilt menu-icon"></i>
          <span class="menu-title">Dashboard Supplier</span>
        </a>
      </li>
      <li class="nav-item sidebar-category">
        <p>Components</p>
        <span></span>
      </li>
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
        <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false">
          <i class="mdi mdi-view-headline menu-icon"></i>
          <span class="menu-title">Kelola Transaksi</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="auth">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link" href="transaksi_pembelian.php">Transaksi Pembelian</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="profil.php">
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
                <h4 class="card-title mb-4">Profil Supplier</h4>

                <?php if(!$cek_supplier): ?>
                <div class="alert alert-warning">
                  Data profil belum tersedia. Silakan hubungi admin untuk mendaftarkan data Anda.
                </div>
                <?php else: ?>

                <form method="POST" action="profil.php">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>ID Supplier</label>
                        <input type="text" class="form-control" value="<?php echo $cek_supplier['id_supplier']; ?>" readonly>
                      </div>
                      <div class="form-group">
                        <label>Nama Supplier</label>
                        <input type="text" name="nama_supplier" class="form-control" value="<?php echo $cek_supplier['nama_supplier']; ?>" required>
                      </div>
                      <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="alamat_supplier" class="form-control" rows="3"><?php echo $cek_supplier['alamat_supplier']; ?></textarea>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Telepon</label>
                        <input type="text" name="telepon_supplier" class="form-control" value="<?php echo $cek_supplier['telepon_supplier']; ?>">
                      </div>
                      <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email_supplier" class="form-control" value="<?php echo $cek_supplier['email_supplier']; ?>">
                      </div>
                      <div class="form-group">
                        <label>Password Baru <small class="text-muted">(kosongkan jika tidak ingin ubah)</small></label>
                        <input type="password" name="password" class="form-control" placeholder="Password baru...">
                      </div>
                    </div>
                  </div>
                  <div class="mt-3">
                    <button type="submit" name="update" class="btn btn-primary">Update Profil</button>
                    <a href="index_supplier.php" class="btn btn-secondary ml-2">Batal</a>
                  </div>
                </form>

                <?php endif; ?>

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