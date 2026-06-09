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

$where = "";
$tgl_dari   = "";
$tgl_sampai = "";

if(isset($_POST['filter'])){
    $tgl_dari   = $_POST['tgl_dari'];
    $tgl_sampai = $_POST['tgl_sampai'];
    $where = "WHERE tb_penjualan.tanggal_penjualan BETWEEN '$tgl_dari' AND '$tgl_sampai'";
}

$data = mysqli_query($conn, "SELECT tb_penjualan.*, tb_customer.nama_customer
                              FROM tb_penjualan
                              LEFT JOIN tb_customer ON tb_penjualan.id_customer = tb_customer.id_customer
                              $where
                              ORDER BY tb_penjualan.tanggal_penjualan ASC");

$total_harga_all  = 0;
$total_barang_all = 0;
$rows = [];
while($row = mysqli_fetch_assoc($data)){
    $rows[] = $row;
    $total_harga_all  += $row['total_hargaall'];
    $total_barang_all += $row['total_barangall'];
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
  <title>Laporan Transaksi Penjualan</title>
  <link rel="stylesheet" href="../../assets/spica/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../assets/spica/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="../../assets/spica/css/style.css">
  <link rel="shortcut icon" href="../../assets/spica/images/favicon.png" />
  <style>
    @media print {
      .no-print { display: none !important; }
      .card { border: none !important; box-shadow: none !important; }
      body { background: white !important; }
    }
  </style>
</head>
<body>
<div class="container-scroller d-flex">

  <nav class="sidebar sidebar-offcanvas no-print" id="sidebar">
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
        <a class="nav-link" data-bs-toggle="collapse" href="#auth2" aria-expanded="true">
          <i class="mdi mdi-view-headline menu-icon"></i>
          <span class="menu-title">Kelola Laporan</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse show" id="auth2">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link" href="laporan_pembelian.php">Laporan Transaksi Pembelian</a></li>
            <li class="nav-item"><a class="nav-link active" href="laporan_penjualan.php">Laporan Transaksi Penjualan</a></li>
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
   <nav class="navbar col-lg-12 col-12 px-0 py-0 py-lg-4 d-flex flex-row no-print">
      <?php include("navbar.php"); ?>
    </nav>


    <div class="main-panel">
      <div class="content-wrapper">

        <!-- FILTER -->
        <div class="row no-print">
          <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Filter Laporan Transaksi Penjualan</h4>
                <form method="POST" class="d-flex align-items-end gap-3">
                  <div class="form-group me-3 mb-0">
                    <label>Dari Tanggal</label>
                    <input type="date" class="form-control" name="tgl_dari" value="<?php echo $tgl_dari; ?>" required>
                  </div>
                  <div class="form-group me-3 mb-0">
                    <label>Sampai Tanggal</label>
                    <input type="date" class="form-control" name="tgl_sampai" value="<?php echo $tgl_sampai; ?>" required>
                  </div>
                  <div class="form-group mb-0">
                    <button type="submit" name="filter" class="btn btn-primary me-2">Filter</button>
                    <a href="laporan_penjualan.php" class="btn btn-secondary">Reset</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!-- TABEL LAPORAN -->
        <div class="row">
          <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3 no-print">
                  <h4 class="card-title mb-0">
                    Laporan Transaksi Penjualan
                    <?php if($tgl_dari && $tgl_sampai): ?>
                      <small class="text-muted">(<?php echo $tgl_dari; ?> s/d <?php echo $tgl_sampai; ?>)</small>
                    <?php endif; ?>
                  </h4>
                  <button onclick="window.print()" class="btn btn-info btn-sm">
                    <i class="mdi mdi-printer"></i> Print
                  </button>
                </div>

                <div class="text-center mb-4" id="print-header" style="display:none;">
                  <h4>Laporan Transaksi Penjualan</h4>
                  <?php if($tgl_dari && $tgl_sampai): ?>
                    <p>Periode: <?php echo $tgl_dari; ?> s/d <?php echo $tgl_sampai; ?></p>
                  <?php else: ?>
                    <p>Semua Data</p>
                  <?php endif; ?>
                </div>

                <div class="table-responsive">
                  <table class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>No Faktur</th>
                        <th>Tanggal</th>
                        <th>Customer</th>
                        <th>Total Barang</th>
                        <th>Total Harga</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if(empty($rows)): ?>
                        <tr><td colspan="6" class="text-center">Tidak ada data</td></tr>
                      <?php else: ?>
                        <?php $no = 1; foreach($rows as $row): ?>
                        <tr>
                          <td><?php echo $no++; ?></td>
                          <td><?php echo $row['no_penjualan']; ?></td>
                          <td><?php echo $row['tanggal_penjualan']; ?></td>
                          <td><?php echo $row['nama_customer']; ?></td>
                          <td><?php echo $row['total_barangall']; ?></td>
                          <td>Rp <?php echo number_format($row['total_hargaall'],0,',','.'); ?>,00</td>
                        </tr>
                        <?php endforeach; ?>
                        <tr class="table-dark font-weight-bold">
                          <td colspan="4" class="text-right"><strong>TOTAL</strong></td>
                          <td><strong><?php echo $total_barang_all; ?></strong></td>
                          <td><strong>Rp <?php echo number_format($total_harga_all,0,',','.'); ?>,00</strong></td>
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
<script>
  window.onbeforeprint = function(){ document.getElementById('print-header').style.display = 'block'; }
  window.onafterprint  = function(){ document.getElementById('print-header').style.display = 'none'; }
</script>
<script src="../../assets/spica/vendors/js/vendor.bundle.base.js"></script>
<script src="../../assets/spica/vendors/chart.js/Chart.min.js"></script>
<script src="../../assets/spica/js/jquery.cookie.js"></script>
<script src="../../assets/spica/js/off-canvas.js"></script>
<script src="../../assets/spica/js/hoverable-collapse.js"></script>
<script src="../../assets/spica/js/template.js"></script>
</body>
</html>