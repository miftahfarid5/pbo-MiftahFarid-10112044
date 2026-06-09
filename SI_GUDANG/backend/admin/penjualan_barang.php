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
if(!isset($_GET['no_penjualan']) || empty($_GET['no_penjualan'])){
    echo "<script>alert('No penjualan tidak ditemukan!');window.location='transaksi_penjualan.php';</script>";
    exit;
}

$no_penjualan = $_GET['no_penjualan'];

// Ambil barang yang dipilih
$barang_dipilih = null;
if(isset($_GET['kd_barang'])){
    $kd = $_GET['kd_barang'];
    $barang_dipilih = mysqli_fetch_assoc(mysqli_query($conn,
        "SELECT tb_barang.*, tb_jenis.jenis FROM tb_barang
         LEFT JOIN tb_jenis ON tb_barang.kode_jenis = tb_jenis.kode_jenis
         WHERE tb_barang.kd_barang='$kd'"));
}

// PROSES SUBMIT
if(isset($_POST['submit'])){
    $kd_barang     = $_POST['kd_barang'];
    $kode_jenis    = $_POST['kode_jenis'];
    $jumlah_barang = $_POST['jumlah_barang'];
    $harga_barang  = $_POST['harga_barang'];
    $total_harga   = $jumlah_barang * $harga_barang;

    // Cek stok cukup
    $stok = mysqli_fetch_assoc(mysqli_query($conn, "SELECT stok FROM tb_barang WHERE kd_barang='$kd_barang'"));
    if($jumlah_barang > $stok['stok']){
        echo "<script>alert('Stok tidak cukup! Stok tersedia: {$stok['stok']}');history.back();</script>";
        exit;
    }
// no_item unik secara global, bukan per transaksi
    $last = mysqli_fetch_assoc(mysqli_query($conn,
        "SELECT MAX(no_item) as last_item FROM detail_penjualan"));
    $no_item = (int)($last['last_item'] ?? 0) + 1;

    // Cek duplikat sebelum insert
    $cek = mysqli_fetch_assoc(mysqli_query($conn,
        "SELECT no_item FROM detail_penjualan WHERE no_item='$no_item'"));
    if($cek){
        $no_item = $no_item + 1;
    }

    mysqli_query($conn, "INSERT INTO detail_penjualan
        (no_penjualan, kd_barang, kode_jenis, jumlah_barang, harga_barang, total_harga, no_item)
        VALUES ('$no_penjualan','$kd_barang','$kode_jenis',$jumlah_barang,$harga_barang,$total_harga,$no_item)");

    // Kurangi stok
    mysqli_query($conn, "UPDATE tb_barang SET stok = stok - $jumlah_barang WHERE kd_barang='$kd_barang'");

    // Update total di tb_penjualan
    mysqli_query($conn, "UPDATE tb_penjualan SET
        total_barangall = (SELECT SUM(jumlah_barang) FROM detail_penjualan WHERE no_penjualan='$no_penjualan'),
        total_hargaall  = (SELECT SUM(total_harga)   FROM detail_penjualan WHERE no_penjualan='$no_penjualan')
        WHERE no_penjualan='$no_penjualan'");

    echo "<script>alert('Barang berhasil ditambahkan!');
          window.location='penjualan_barang.php?no_penjualan=".urlencode($no_penjualan)."';</script>";
    exit;
}

// PROSES HAPUS ITEM
if(isset($_GET['hapus_item'])){
    $no_item   = $_GET['hapus_item'];
    $item_data = mysqli_fetch_assoc(mysqli_query($conn,
        "SELECT * FROM detail_penjualan WHERE no_penjualan='$no_penjualan' AND no_item=$no_item"));

    // Kembalikan stok
    mysqli_query($conn, "UPDATE tb_barang SET stok = stok + {$item_data['jumlah_barang']} WHERE kd_barang='{$item_data['kd_barang']}'");
    mysqli_query($conn, "DELETE FROM detail_penjualan WHERE no_penjualan='$no_penjualan' AND no_item=$no_item");
    mysqli_query($conn, "UPDATE tb_penjualan SET
        total_barangall = COALESCE((SELECT SUM(jumlah_barang) FROM detail_penjualan WHERE no_penjualan='$no_penjualan'),0),
        total_hargaall  = COALESCE((SELECT SUM(total_harga)   FROM detail_penjualan WHERE no_penjualan='$no_penjualan'),0)
        WHERE no_penjualan='$no_penjualan'");

    echo "<script>alert('Item berhasil dihapus!');
          window.location='penjualan_barang.php?no_penjualan=".urlencode($no_penjualan)."';</script>";
    exit;
}

$semua_barang = mysqli_query($conn,
    "SELECT tb_barang.*, tb_jenis.jenis FROM tb_barang
     LEFT JOIN tb_jenis ON tb_barang.kode_jenis = tb_jenis.kode_jenis
     WHERE tb_barang.stok > 0");

$detail = mysqli_query($conn,
    "SELECT dp.*, tb.nama_barang, tj.jenis FROM detail_penjualan dp
     LEFT JOIN tb_barang tb ON dp.kd_barang = tb.kd_barang
     LEFT JOIN tb_jenis tj ON dp.kode_jenis = tj.kode_jenis
     WHERE dp.no_penjualan='$no_penjualan'
     ORDER BY dp.no_item ASC");
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
  <title>Penjualan Barang</title>
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

    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">

          <!-- KIRI: TABEL PILIH BARANG -->
          <div class="col-md-7 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <h4 class="card-title mb-0">Pilih Data Barang</h4>
                  <a href="transaksi_penjualan.php" class="btn btn-danger btn-sm">Kembali</a>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Jenis</th>
                        <th>Stok</th>
                        <th>Harga Jual</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $no = 1; while($b = mysqli_fetch_assoc($semua_barang)): ?>
                      <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $b['kd_barang']; ?></td>
                        <td><?php echo $b['nama_barang']; ?></td>
                        <td><?php echo $b['jenis']; ?></td>
                        <td><?php echo $b['stok']; ?></td>
                        <td>Rp <?php echo number_format($b['harga_jual'],0,',','.'); ?>,00</td>
                        <td>
                          <a href="?no_penjualan=<?php echo urlencode($no_penjualan); ?>&kd_barang=<?php echo $b['kd_barang']; ?>"
                             class="btn btn-primary btn-sm">Pilih</a>
                        </td>
                      </tr>
                      <?php endwhile; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <!-- KANAN: FORM DETAIL -->
          <div class="col-md-5 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Detail Transaksi Penjualan - <?php echo $no_penjualan; ?></h4>
                <form method="POST">
                  <div class="form-group row mb-3">
                    <label class="col-sm-5 col-form-label font-weight-bold">No Faktur Penjualan</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control bg-light" value="<?php echo $no_penjualan; ?>" readonly>
                    </div>
                  </div>
                  <div class="form-group row mb-3">
                    <label class="col-sm-5 col-form-label font-weight-bold">Kode Barang</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control bg-light" name="kd_barang"
                             value="<?php echo $barang_dipilih['kd_barang'] ?? '-'; ?>" readonly>
                    </div>
                  </div>
                  <div class="form-group row mb-3">
                    <label class="col-sm-5 col-form-label font-weight-bold">Nama Barang</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control bg-light"
                             value="<?php echo $barang_dipilih['nama_barang'] ?? '-'; ?>" readonly>
                    </div>
                  </div>
                  <div class="form-group row mb-3">
                    <label class="col-sm-5 col-form-label font-weight-bold">Jenis Barang</label>
                    <div class="col-sm-7">
                      <input type="hidden" name="kode_jenis" value="<?php echo $barang_dipilih['kode_jenis'] ?? ''; ?>">
                      <p class="mt-2 mb-0"><?php echo $barang_dipilih['jenis'] ?? '-'; ?></p>
                    </div>
                  </div>
                  <div class="form-group row mb-3">
                    <label class="col-sm-5 col-form-label font-weight-bold">Stok Tersedia</label>
                    <div class="col-sm-7">
                      <p class="mt-2 mb-0"><?php echo $barang_dipilih['stok'] ?? '-'; ?></p>
                    </div>
                  </div>
                  <div class="form-group row mb-3">
                    <label class="col-sm-5 col-form-label font-weight-bold">Jumlah Barang</label>
                    <div class="col-sm-7">
                      <input type="number" class="form-control" name="jumlah_barang"
                             placeholder="Jumlah" min="1"
                             max="<?php echo $barang_dipilih['stok'] ?? 0; ?>"
                             <?php if(!$barang_dipilih) echo 'disabled'; ?> required>
                    </div>
                  </div>
                  <div class="form-group row mb-3">
                    <label class="col-sm-5 col-form-label font-weight-bold">Harga Jual</label>
                    <div class="col-sm-7">
                      <input type="number" class="form-control bg-light" name="harga_barang"
                             value="<?php echo $barang_dipilih['harga_jual'] ?? ''; ?>" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-7 offset-sm-5">
                      <?php if($barang_dipilih): ?>
                        <button type="submit" name="submit" class="btn btn-success me-1">Submit</button>
                        <a href="?no_penjualan=<?php echo urlencode($no_penjualan); ?>"
                           class="btn btn-warning me-1">Reset</a>
                        <a href="transaksi_penjualan.php" class="btn btn-danger">Cancel</a>
                      <?php else: ?>
                        <button type="button" class="btn btn-success me-1" disabled>Submit</button>
                        <button type="button" class="btn btn-warning me-1" disabled>Reset</button>
                        <a href="transaksi_penjualan.php" class="btn btn-danger">Cancel</a>
                      <?php endif; ?>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>

        </div>

        <!-- TABEL DETAIL TRANSAKSI -->
        <div class="row">
          <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Data Detail Transaksi Penjualan</h4>
                <div class="table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>No Faktur</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Harga Jual</th>
                        <th>Total Harga</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $no = 1; while($d = mysqli_fetch_assoc($detail)): ?>
                      <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $d['no_penjualan']; ?></td>
                        <td><?php echo $d['kd_barang']; ?></td>
                        <td><?php echo $d['nama_barang']; ?></td>
                        <td><?php echo $d['jenis']; ?></td>
                        <td><?php echo $d['jumlah_barang']; ?></td>
                        <td>Rp <?php echo number_format($d['harga_barang'],0,',','.'); ?>,00</td>
                        <td>Rp <?php echo number_format($d['total_harga'],0,',','.'); ?>,00</td>
                        <td>
                          <a href="?no_penjualan=<?php echo urlencode($no_penjualan); ?>&hapus_item=<?php echo $d['no_item']; ?>"
                             class="btn btn-danger btn-sm"
                             onclick="return confirm('Hapus item ini?')">Hapus</a>
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