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

// PROSES HAPUS
if(isset($_GET['hapus'])){
    $no = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM detail_penjualan WHERE no_penjualan='$no'");
    mysqli_query($conn, "DELETE FROM tb_penjualan WHERE no_penjualan='$no'");
    echo "<script>alert('Transaksi berhasil dihapus!');window.location='transaksi_penjualan.php';</script>";
    exit;
}

// PROSES TAMBAH TRANSAKSI
if(isset($_POST['submit'])){
    $tanggal_penjualan = $_POST['tanggal_penjualan'];
    $id_customer       = $_POST['id_customer'];

    // Generate no_penjualan otomatis
    $last = mysqli_fetch_assoc(mysqli_query($conn, "SELECT no_penjualan FROM tb_penjualan ORDER BY no_penjualan DESC LIMIT 1"));
    if($last){
        $num = (int)substr($last['no_penjualan'], 3) + 1;
        $no_penjualan = "JUL" . str_pad($num, 4, "0", STR_PAD_LEFT);
    } else {
        $no_penjualan = "JUL0001";
    }

    mysqli_query($conn, "INSERT INTO tb_penjualan (no_penjualan, tanggal_penjualan, id_customer, total_barangall, total_hargaall)
                          VALUES ('$no_penjualan','$tanggal_penjualan','$id_customer',0,0)");

    echo "<script>alert('Transaksi berhasil dibuat!');
          window.location='penjualan_barang.php?no_penjualan=".urlencode($no_penjualan)."';</script>";
    exit;
}

$customer = mysqli_query($conn, "SELECT * FROM tb_customer");
$data     = mysqli_query($conn, "SELECT tp.*, tc.nama_customer 
                                  FROM tb_penjualan tp
                                  LEFT JOIN tb_customer tc ON tp.id_customer = tc.id_customer
                                  ORDER BY tp.no_penjualan DESC");
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
        <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="true">
          <i class="mdi mdi-view-headline menu-icon"></i>
          <span class="menu-title">Kelola Transaksi</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse show" id="auth">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link" href="transaksi_pembelian.php">Transaksi Pembelian</a></li>
            <li class="nav-item"><a class="nav-link active" href="transaksi_penjualan.php">Transaksi Penjualan</a></li>
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

    <!-- Main Panel -->
<div class="container-fluid mt-4">
    <div class="row">
        <!-- KIRI: Data Transaksi Penjualan (Tabel) -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Data Transaksi Penjualan</h5>
                    <div class="mb-3">
                        <input type="text" id="searchCustomer" class="form-control"
                               placeholder="Cari No Faktur / Customer...">
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
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
                                <?php $no=1; while($row = mysqli_fetch_assoc($data)): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $row['no_penjualan']; ?></td>
                                    <td><?= date('d-m-Y', strtotime($row['tanggal_penjualan'])); ?></td>
                                    <td><?= $row['nama_customer']; ?></td>
                                    <td><?= $row['total_barangall']; ?></td>
                                    <td>Rp <?= number_format($row['total_hargaall'],0,',','.'); ?></td>
                                    <td>
                                        <a href="penjualan_barang.php?no_penjualan=<?= $row['no_penjualan']; ?>" class="btn btn-primary btn-sm">Detail</a>
                                        <a href="?hapus=<?= $row['no_penjualan']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- KANAN: Form Tambah Transaksi -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Tambah Transaksi Penjualan</h5>
                    <form method="POST" action="transaksi_penjualan.php">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Penjualan</label>
                            <input type="date" name="tanggal_penjualan" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Customer</label>
                            <select name="id_customer" class="form-select" required>
                                <option value="">Pilih Customer</option>
                                <?php while($c = mysqli_fetch_assoc($customer)): ?>
                                <option value="<?= $c['id_customer']; ?>">
                                    <?= htmlspecialchars($c['nama_customer']); ?>
                                </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" name="submit" class="btn btn-success">Buat Transaksi</button>
                            <button type="reset" class="btn btn-warning">Reset</button>
                        </div>
                    </form>
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
    document.getElementById('searchCustomer').addEventListener('keyup', function(){
        var keyword = this.value.toLowerCase();
        var rows    = document.querySelectorAll('table tbody tr');
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