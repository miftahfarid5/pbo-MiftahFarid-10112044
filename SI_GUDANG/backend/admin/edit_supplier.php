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

if(!isset($_GET['id_supplier']) || empty($_GET['id_supplier'])){
    echo "<script>alert('ID Supplier tidak ditemukan!');window.location='data_supplier.php';</script>";
    exit;
}

$id_supplier = $_GET['id_supplier'];
$row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tb_supplier WHERE id_supplier='$id_supplier'"));

if(!$row){
    echo "<script>alert('Data tidak ditemukan!');window.location='data_supplier.php';</script>";
    exit;
}

if(isset($_POST['submit'])){
    $nama_supplier    = $_POST['nama_supplier'];
    $alamat_supplier  = $_POST['alamat_supplier'];
    $telepon_supplier = $_POST['telepon_supplier'];
    $email_supplier   = $_POST['email_supplier'];

    // Update password hanya jika diisi
    if(!empty($_POST['pass_supplier'])){
        $pass_supplier = password_hash($_POST['pass_supplier'], PASSWORD_DEFAULT);
        mysqli_query($conn, "UPDATE tb_supplier SET 
            nama_supplier='$nama_supplier', alamat_supplier='$alamat_supplier',
            telepon_supplier='$telepon_supplier', email_supplier='$email_supplier',
            pass_supplier='$pass_supplier'
            WHERE id_supplier='$id_supplier'");
    } else {
        mysqli_query($conn, "UPDATE tb_supplier SET 
            nama_supplier='$nama_supplier', alamat_supplier='$alamat_supplier',
            telepon_supplier='$telepon_supplier', email_supplier='$email_supplier'
            WHERE id_supplier='$id_supplier'");
    }

    echo "<script>alert('Data berhasil diupdate!');window.location='data_supplier.php';</script>";
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
  <title>Edit Supplier</title>
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
        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="true">
          <i class="mdi mdi-view-headline menu-icon"></i>
          <span class="menu-title">Kelola Data</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse show" id="ui-basic">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link" href="data_barang.php">Data Barang</a></li>
            <li class="nav-item"><a class="nav-link" href="data_customer.php">Data Customer</a></li>
            <li class="nav-item"><a class="nav-link active" href="data_supplier.php">Data Supplier</a></li>
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
          <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <h4 class="card-title mb-0">Edit Supplier</h4>
                  <a href="data_supplier.php" class="btn btn-danger btn-sm">Kembali</a>
                </div>
                <form method="POST">
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">ID Supplier</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control bg-light" value="<?php echo $row['id_supplier']; ?>" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Nama Supplier</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="nama_supplier" value="<?php echo $row['nama_supplier']; ?>" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Alamat</label>
                    <div class="col-sm-8">
                      <textarea class="form-control" name="alamat_supplier" rows="3" required><?php echo $row['alamat_supplier']; ?></textarea>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Telepon</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="telepon_supplier" value="<?php echo $row['telepon_supplier']; ?>" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Email</label>
                    <div class="col-sm-8">
                      <input type="email" class="form-control" name="email_supplier" value="<?php echo $row['email_supplier']; ?>" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Password Baru</label>
                    <div class="col-sm-8">
                      <input type="password" class="form-control" name="pass_supplier" placeholder="Kosongkan jika tidak ingin mengubah password">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-8 offset-sm-4">
                      <button type="submit" name="submit" class="btn btn-success me-2">Update</button>
                      <a href="data_supplier.php" class="btn btn-danger">Batal</a>
                    </div>
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