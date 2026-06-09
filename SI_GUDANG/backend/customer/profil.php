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

// Ambil data customer
$cek_customer = mysqli_fetch_assoc(mysqli_query($koneksi, 
    "SELECT * FROM tb_customer WHERE nama_customer='$username' OR email_customer='$username'"));

// PROSES UPDATE PROFIL
if(isset($_POST['update'])){
    $nama     = $_POST['nama_customer'];
    $jk       = $_POST['jenis_kelamin'];
    $alamat   = $_POST['alamat_customer'];
    $telepon  = $_POST['telepon_customer'];
    $email    = $_POST['email_customer'];
    $password = $_POST['password'];

    if(!empty($password)){
        $query = "UPDATE tb_customer SET 
                    nama_customer='$nama',
                    jenis_kelamin='$jk',
                    alamat_customer='$alamat',
                    telepon_customer='$telepon',
                    email_customer='$email',
                    pass_customer='$password'
                  WHERE id_customer='".$cek_customer['id_customer']."'";
    } else {
        $query = "UPDATE tb_customer SET 
                    nama_customer='$nama',
                    jenis_kelamin='$jk',
                    alamat_customer='$alamat',
                    telepon_customer='$telepon',
                    email_customer='$email'
                  WHERE id_customer='".$cek_customer['id_customer']."'";
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
  <title>Profil Saya</title>
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
        <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false">
          <i class="mdi mdi-view-headline menu-icon"></i>
          <span class="menu-title">Kelola Transaksi</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="auth">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link" href="transaksi_penjualan.php">Transaksi Penjualan</a></li>
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
                <h4 class="card-title mb-4">Profil Saya</h4>

                <?php if(!$cek_customer): ?>
                <div class="alert alert-warning">
                  Data profil belum tersedia. Silakan hubungi admin untuk mendaftarkan data Anda.
                </div>
                <?php else: ?>

                <form method="POST" action="profil.php">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>ID Customer</label>
                        <input type="text" class="form-control" value="<?php echo $cek_customer['id_customer']; ?>" readonly>
                      </div>
                      <div class="form-group">
                        <label>Nama Customer</label>
                        <input type="text" name="nama_customer" class="form-control" value="<?php echo $cek_customer['nama_customer']; ?>" required>
                      </div>
                      <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control">
                          <option value="Laki-laki" <?php echo ($cek_customer['jenis_kelamin'] == 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                          <option value="Perempuan" <?php echo ($cek_customer['jenis_kelamin'] == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="alamat_customer" class="form-control" rows="3"><?php echo $cek_customer['alamat_customer']; ?></textarea>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Telepon</label>
                        <input type="text" name="telepon_customer" class="form-control" value="<?php echo $cek_customer['telepon_customer']; ?>">
                      </div>
                      <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email_customer" class="form-control" value="<?php echo $cek_customer['email_customer']; ?>">
                      </div>
                      <div class="form-group">
                        <label>Password Baru <small class="text-muted">(kosongkan jika tidak ingin ubah)</small></label>
                        <input type="password" name="password" class="form-control" placeholder="Password baru...">
                      </div>
                    </div>
                  </div>
                  <div class="mt-3">
                    <button type="submit" name="update" class="btn btn-primary">Update Profil</button>
                    <a href="index_customer.php" class="btn btn-secondary ml-2">Batal</a>
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