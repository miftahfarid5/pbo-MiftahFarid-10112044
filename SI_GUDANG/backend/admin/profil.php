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

$username = $_SESSION['username'];

// Ambil data admin dari tabel user
$data_admin = mysqli_fetch_assoc(mysqli_query($koneksi, 
    "SELECT * FROM user WHERE username='$username'"));

// PROSES UPDATE
if(isset($_POST['update'])){
    $username_baru = $_POST['username'];
    $password_baru = $_POST['password'];

    if(!empty($password_baru)){
        $query = "UPDATE user SET 
                    username='$username_baru',
                    password='$password_baru'
                  WHERE id_user='".$data_admin['id_user']."'";
    } else {
        $query = "UPDATE user SET 
                    username='$username_baru'
                  WHERE id_user='".$data_admin['id_user']."'";
    }

    if(mysqli_query($koneksi, $query)){
        $_SESSION['username'] = $username_baru;
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
  <title>Profil Admin</title>
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
        <a class="nav-link" href="index_admin.php">
          <i class="mdi mdi-view-quilt menu-icon"></i>
          <span class="menu-title">Dashboard Admin</span>
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
            <li class="nav-item"><a class="nav-link" href="data_customer.php">Data Customer</a></li>
            <li class="nav-item"><a class="nav-link" href="data_supplier.php">Data Supplier</a></li>
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
            <li class="nav-item"><a class="nav-link" href="transaksi_penjualan.php">Transaksi Penjualan</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#auth2" aria-expanded="false">
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
                <h4 class="card-title mb-4">Profil Administrator</h4>

                <form method="POST" action="profil.php">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>ID User</label>
                        <input type="text" class="form-control" value="<?php echo $data_admin['id_user']; ?>" readonly>
                      </div>
                      <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" value="<?php echo $data_admin['username']; ?>" required>
                      </div>
                      <div class="form-group">
                        <label>Tipe User</label>
                        <input type="text" class="form-control" value="<?php echo $data_admin['tipe_user']; ?>" readonly>
                      </div>
                      <div class="form-group">
                        <label>Password Baru <small class="text-muted">(kosongkan jika tidak ingin ubah)</small></label>
                        <input type="password" name="password" class="form-control" placeholder="Password baru...">
                      </div>
                    </div>
                  </div>
                  <div class="mt-3">
                    <button type="submit" name="update" class="btn btn-primary">Update Profil</button>
                    <a href="index_admin.php" class="btn btn-secondary ml-2">Batal</a>
                  </div>
                </form>

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