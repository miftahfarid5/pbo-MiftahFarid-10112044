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

// Generate No Faktur otomatis
$no_pembelian = "BUY - " . date("Ymd") . rand(100, 999);

// Ambil data supplier
$supplier = mysqli_query($conn, "SELECT * FROM tb_supplier");

// PROSES SUBMIT
if(isset($_POST['submit'])){
    $no_pembelian  = $_POST['no_pembelian'];
    $tgl           = $_POST['tanggal_pembelian'];
    $id_supplier   = $_POST['id_supplier'];

    // Cek apakah no_pembelian sudah ada
    $cek = mysqli_query($conn, "SELECT * FROM tb_pembelian WHERE no_pembelian='$no_pembelian'");
    if(mysqli_num_rows($cek) > 0){
        echo "<script>alert('Nomor faktur sudah ada!');</script>";
    } else {
        $insert = mysqli_query($conn, "INSERT INTO tb_pembelian (no_pembelian, tanggal_pembelian, id_supplier, total_barangall, total_hargaall) 
                                       VALUES ('$no_pembelian', '$tgl', '$id_supplier', 0, 0)");
        if($insert){
            echo "<script>alert('Transaksi berhasil dibuat!');
                  window.location='pembelian_barang.php?no_pembelian=".urlencode($no_pembelian)."&action=pilih_barang';</script>";
        } else {
            echo "<script>alert('Gagal menyimpan!');</script>";
        }
    }
}

// PROSES HAPUS
if(isset($_GET['hapus'])){
    $no = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM detail_pembelian WHERE no_pembelian='$no'");
    mysqli_query($conn, "DELETE FROM tb_pembelian WHERE no_pembelian='$no'");
    echo "<script>alert('Data berhasil dihapus!');window.location='transaksi_pembelian.php';</script>";
}

// Ambil semua data transaksi pembelian
$data = mysqli_query($conn, "SELECT tp.*, ts.nama 
                              FROM tb_pembelian tp 
                              LEFT JOIN tb_supplier ts ON tp.id_supplier = ts.id_supplier 
                              ORDER BY tp.no_pembelian DESC");
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
  <title>Transaksi Pembelian</title>
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
        <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="true">
          <i class="mdi mdi-view-headline menu-icon"></i>
          <span class="menu-title">Kelola Transaksi</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse show" id="auth">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link active" href="transaksi_pembelian.php">Transaksi Pembelian</a></li>
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
  <!-- END SIDEBAR -->

  <div class="container-fluid page-body-wrapper">

    <!-- NAVBAR -->
    <nav class="navbar col-lg-12 col-12 px-0 py-0 py-lg-4 d-flex flex-row">
      
        
           <?php include('navbar.php'); ?>
    </nav>
    <!-- END NAVBAR -->

    <!-- MAIN PANEL -->
    <div class="main-panel">
      <div class="content-wrapper">

        <!-- FORM TAMBAH TRANSAKSI -->
        <div class="row">
          <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Form Transaksi Pembelian (Barang Masuk)</h4>
                <form method="POST">
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Nomor Faktur Pembelian</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="no_pembelian" value="<?php echo $no_pembelian; ?>" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Tanggal Pembelian</label>
                    <div class="col-sm-8">
                      <input type="date" class="form-control" name="tanggal_pembelian" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Supplier</label>
                    <div class="col-sm-8">
                      <select class="form-control" name="id_supplier" required>
                        <option value="">Pilih Supplier</option>
                        <?php while($s = mysqli_fetch_assoc($supplier)): ?>
                          <option value="<?php echo $s['id_supplier']; ?>"><?php echo $s['nama_supplier']; ?></option>
                        <?php endwhile; ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-8 offset-sm-4">
                      <button type="submit" name="submit" class="btn btn-success me-2">Submit</button>
                      <button type="reset" class="btn btn-warning me-2">Reset</button>
                      <a href="index_admin.php" class="btn btn-danger">Back</a>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!-- TABEL DATA TRANSAKSI PEMBELIAN -->
        <div class="row">
          <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Data Transaksi Pembelian (Barang Masuk)</h4>
                <div class="mb-3">
                    <input type="text" id="searchSupplier" class="form-control"
                           placeholder="Cari No Faktur / Supplier...">
                </div>
                <div class="table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>No Faktur Pembelian</th>
                        <th>Tanggal Pembelian</th>
                        <th>ID Supplier</th>
                        <th>Nama Supplier</th>
                        <th>Total Barang</th>
                        <th>Total Harga</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      while($row = mysqli_fetch_assoc($data)):
                      ?>
                      <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $row['no_pembelian']; ?></td>
                        <td><?php echo $row['tanggal_pembelian']; ?></td>
                        <td><?php echo $row['id_supplier']; ?></td>
                        <td><?php echo $row['nama_supplier']; ?></td>
                        <td><?php echo $row['total_barangall']; ?></td>
                        <td>Rp <?php echo number_format($row['total_hargaall'], 0, ',', '.'); ?>,00</td>
                        <td>
                        <a href="pembelian_barang.php?no_pembelian=<?php echo urlencode($row['no_pembelian']); ?>&action=pilih_barang"
                             class="btn btn-info btn-sm">Detail Transaksi</a>
                          <a href="?hapus=<?php echo urlencode($row['no_pembelian']); ?>" 
                             class="btn btn-danger btn-sm"
                             onclick="return confirm('Yakin hapus transaksi ini?')">Hapus</a>
                        </td>
                      </tr>
                      <?php endwhile; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
    <!-- END MAIN PANEL -->

  </div>
</div>

<script src="../../assets/spica/vendors/js/vendor.bundle.base.js"></script>
<script src="../../assets/spica/vendors/chart.js/Chart.min.js"></script>
<script src="../../assets/spica/js/jquery.cookie.js"></script>
<script src="../../assets/spica/js/off-canvas.js"></script>
<script src="../../assets/spica/js/hoverable-collapse.js"></script>
<script src="../../assets/spica/js/template.js"></script>
<script src="../../assets/spica/vendors/js/vendor.bundle.base.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
    document.getElementById('searchSupplier').addEventListener('keyup', function(){
        var keyword = this.value.toLowerCase();
        var rows    = document.querySelectorAll('table tbody tr');
        rows.forEach(function(row){
            var text = row.textContent.toLowerCase();
            row.style.display = text.includes(keyword) ? '' : 'none';
        });
    });
});
</script>
</body>
</html>