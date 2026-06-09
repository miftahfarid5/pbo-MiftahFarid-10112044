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
    $no = mysqli_real_escape_string($conn, $_GET['hapus']);
    mysqli_query($conn, "DELETE FROM detail_penjualan WHERE no_penjualan='$no'");
    mysqli_query($conn, "DELETE FROM tb_penjualan WHERE no_penjualan='$no'");
    echo "<script>alert('Transaksi berhasil dihapus!');window.location='transaksi_penjualan.php';</script>";
    exit;
}

// PROSES EDIT TRANSAKSI
if(isset($_POST['submit_edit'])){
    $no_edit           = mysqli_real_escape_string($conn, $_POST['no_penjualan_edit']);
    $tanggal_penjualan = mysqli_real_escape_string($conn, $_POST['tanggal_penjualan']);
    $id_customer       = mysqli_real_escape_string($conn, $_POST['id_customer']);

    mysqli_query($conn, "UPDATE tb_penjualan 
                         SET tanggal_penjualan='$tanggal_penjualan', id_customer='$id_customer'
                         WHERE no_penjualan='$no_edit'");
    echo "<script>alert('Transaksi berhasil diperbarui!');window.location='transaksi_penjualan.php';</script>";
    exit;
}

// PROSES TAMBAH TRANSAKSI
if(isset($_POST['submit'])){
    $tanggal_penjualan = mysqli_real_escape_string($conn, $_POST['tanggal_penjualan']);
    $id_customer       = mysqli_real_escape_string($conn, $_POST['id_customer']);

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

$customer = mysqli_query($conn, "SELECT * FROM tb_customer ORDER BY nama_customer ASC");
$data     = mysqli_query($conn, "SELECT tp.*, tc.nama_customer 
                                  FROM tb_penjualan tp
                                  LEFT JOIN tb_customer tc ON tp.id_customer = tc.id_customer
                                  ORDER BY tp.no_penjualan DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Transaksi Penjualan</title>
  <link rel="stylesheet" href="../../assets/spica/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../assets/spica/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="../../assets/spica/css/style.css">
  <link rel="shortcut icon" href="../../assets/spica/images/favicon.png" />
  <style>
    .sidebar .nav .sub-menu .nav-item .nav-link {
      white-space: normal;
    }
    .card {
      border-radius: 10px;
    }
    .table thead th {
      font-size: 13px;
      vertical-align: middle;
    }
    .table tbody td {
      vertical-align: middle;
      font-size: 13px;
    }
    .badge-status {
      font-size: 12px;
      padding: 5px 10px;
      border-radius: 20px;
    }
    .search-box {
      position: relative;
    }
    .search-box .mdi {
      position: absolute;
      left: 10px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 18px;
      color: #9b9b9b;
    }
    .search-box input {
      padding-left: 35px;
    }
    .btn-action {
      padding: 4px 8px;
      font-size: 12px;
    }
    #formCard {
      position: sticky;
      top: 20px;
    }
  </style>
</head>
<body>
<div class="container-scroller d-flex">

  <!-- ===== SIDEBAR ===== -->
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
  <!-- ===== END SIDEBAR ===== -->

  <div class="container-fluid page-body-wrapper">

    <!-- NAVBAR -->
    <nav class="navbar col-lg-12 col-12 px-0 py-0 py-lg-4 d-flex flex-row">
      <?php include('navbar.php'); ?>
    </nav>

    <!-- ===== MAIN CONTENT ===== -->
    <div class="main-panel">
      <div class="content-wrapper">

        <!-- Page Header -->
        <div class="row mb-3">
          <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
              <div>
                <h4 class="font-weight-bold mb-0">Transaksi Penjualan</h4>
                <p class="text-muted mb-0" style="font-size:13px;">
                  <i class="mdi mdi-home"></i> Dashboard &rsaquo; Transaksi Penjualan
                </p>
              </div>
            </div>
          </div>
        </div>

        <div class="row">

          <!-- ====== KIRI: TABEL DATA ====== -->
          <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <h5 class="card-title mb-0">
                    <i class="mdi mdi-cart-outline me-1 text-primary"></i>
                    Data Transaksi Penjualan
                  </h5>
                  <!-- Search Box -->
                  <div class="search-box" style="width:230px;">
                    <i class="mdi mdi-magnify"></i>
                    <input type="text" id="searchInput" class="form-control form-control-sm"
                           placeholder="Cari no faktur / customer...">
                  </div>
                </div>

                <div class="table-responsive">
                  <table class="table table-bordered table-hover" id="tabelPenjualan">
                    <thead class="table-dark">
                      <tr>
                        <th>No</th>
                        <th>No Faktur</th>
                        <th>Tanggal</th>
                        <th>Customer</th>
                        <th>Total Barang</th>
                        <th>Total Harga</th>
                        <th class="text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      if(mysqli_num_rows($data) > 0):
                        while($row = mysqli_fetch_assoc($data)):
                      ?>
                      <tr>
                        <td><?= $no++; ?></td>
                        <td>
                          <span class="badge bg-primary badge-status">
                            <?= htmlspecialchars($row['no_penjualan']); ?>
                          </span>
                        </td>
                        <td>
                          <i class="mdi mdi-calendar-outline me-1 text-muted"></i>
                          <?= date('d M Y', strtotime($row['tanggal_penjualan'])); ?>
                        </td>
                        <td>
                          <i class="mdi mdi-account-outline me-1 text-muted"></i>
                          <?= htmlspecialchars($row['nama_customer']); ?>
                        </td>
                        <td class="text-center">
                          <span class="badge bg-info text-dark">
                            <?= $row['total_barangall']; ?> item
                          </span>
                        </td>
                        <td>
                          <strong>Rp <?= number_format($row['total_hargaall'], 0, ',', '.'); ?></strong>
                        </td>
                        <td class="text-center">
                          <div class="d-flex gap-1 justify-content-center flex-wrap">
                            <!-- Detail -->
                            <a href="penjualan_barang.php?no_penjualan=<?= urlencode($row['no_penjualan']); ?>"
                               class="btn btn-primary btn-action" title="Detail">
                              <i class="mdi mdi-eye"></i>
                            </a>
                            <!-- Edit -->
                            <button type="button"
                                    class="btn btn-warning btn-action"
                                    title="Edit"
                                    onclick="openEdit('<?= htmlspecialchars($row['no_penjualan']); ?>',
                                                       '<?= htmlspecialchars($row['tanggal_penjualan']); ?>',
                                                       '<?= htmlspecialchars($row['id_customer']); ?>')">
                              <i class="mdi mdi-pencil"></i>
                            </button>
                            <!-- Cetak -->
                            <a href="cetak_penjualan.php?no_penjualan=<?= urlencode($row['no_penjualan']); ?>"
                               target="_blank"
                               class="btn btn-success btn-action" title="Cetak">
                              <i class="mdi mdi-printer"></i>
                            </a>
                            <!-- Hapus -->
                            <a href="javascript:void(0);"
                               class="btn btn-danger btn-action"
                               title="Hapus"
                               onclick="konfirmasiHapus('<?= urlencode($row['no_penjualan']); ?>')">
                              <i class="mdi mdi-delete"></i>
                            </a>
                          </div>
                        </td>
                      </tr>
                      <?php
                        endwhile;
                      else:
                      ?>
                      <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                          <i class="mdi mdi-inbox-outline" style="font-size:40px;"></i>
                          <p class="mb-0 mt-2">Belum ada data transaksi penjualan.</p>
                        </td>
                      </tr>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>
                <!-- Info jumlah data -->
                <div class="d-flex justify-content-between align-items-center mt-2">
                  <small class="text-muted" id="infoJumlah"></small>
                </div>
              </div>
            </div>
          </div>
          <!-- ====== END TABEL ====== -->

          <!-- ====== KANAN: FORM ====== -->
          <div class="col-md-4 grid-margin stretch-card">
            <div class="card" id="formCard">
              <div class="card-body">
                <!-- Judul form dinamis -->
                <h5 class="card-title mb-1" id="formTitle">
                  <i class="mdi mdi-plus-circle-outline me-1 text-success"></i>
                  Tambah Transaksi Penjualan
                </h5>
                <p class="text-muted mb-3" style="font-size:12px;" id="formSubtitle">
                  Isi form berikut untuk membuat transaksi baru.
                </p>
                <hr>

                <!-- Form Tambah -->
                <form method="POST" action="transaksi_penjualan.php" id="formTambah">
                  <input type="hidden" name="mode" value="tambah">
                  <div class="mb-3">
                    <label class="form-label fw-semibold">
                      <i class="mdi mdi-calendar-check-outline me-1"></i>Tanggal Penjualan
                    </label>
                    <input type="date" name="tanggal_penjualan" id="inputTanggal"
                           class="form-control" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label fw-semibold">
                      <i class="mdi mdi-account-outline me-1"></i>Customer
                    </label>
                    <select name="id_customer" id="inputCustomer" class="form-select" required>
                      <option value="">-- Pilih Customer --</option>
                      <?php
                        mysqli_data_seek($customer, 0);
                        while($c = mysqli_fetch_assoc($customer)):
                      ?>
                      <option value="<?= $c['id_customer']; ?>">
                        <?= htmlspecialchars($c['nama_customer']); ?>
                      </option>
                      <?php endwhile; ?>
                    </select>
                  </div>
                  <div class="d-flex gap-2 mt-3">
                    <button type="submit" name="submit" class="btn btn-success w-100" id="btnSubmit">
                      <i class="mdi mdi-check-circle-outline me-1"></i>Buat Transaksi
                    </button>
                    <button type="reset" class="btn btn-outline-secondary" onclick="resetForm()">
                      <i class="mdi mdi-refresh"></i>
                    </button>
                  </div>
                </form>

                <!-- Form Edit (hidden by default) -->
                <form method="POST" action="transaksi_penjualan.php" id="formEdit" style="display:none;">
                  <input type="hidden" name="mode" value="edit">
                  <input type="hidden" name="no_penjualan_edit" id="editNoFaktur">
                  <div class="mb-3">
                    <label class="form-label fw-semibold">
                      <i class="mdi mdi-calendar-check-outline me-1"></i>Tanggal Penjualan
                    </label>
                    <input type="date" name="tanggal_penjualan" id="editTanggal"
                           class="form-control" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label fw-semibold">
                      <i class="mdi mdi-account-outline me-1"></i>Customer
                    </label>
                    <select name="id_customer" id="editCustomer" class="form-select" required>
                      <option value="">-- Pilih Customer --</option>
                      <?php
                        mysqli_data_seek($customer, 0);
                        while($c = mysqli_fetch_assoc($customer)):
                      ?>
                      <option value="<?= $c['id_customer']; ?>">
                        <?= htmlspecialchars($c['nama_customer']); ?>
                      </option>
                      <?php endwhile; ?>
                    </select>
                  </div>
                  <div class="d-flex gap-2 mt-3">
                    <button type="submit" name="submit_edit" class="btn btn-warning w-100">
                      <i class="mdi mdi-content-save-outline me-1"></i>Simpan Perubahan
                    </button>
                    <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                      <i class="mdi mdi-close"></i>
                    </button>
                  </div>
                </form>

              </div>
            </div>
          </div>
          <!-- ====== END FORM ====== -->

        </div>
      </div>
      <!-- ===== END CONTENT ===== -->
    </div>
  </div>
</div>

<!-- ====== SCRIPTS ====== -->
<script src="../../assets/spica/vendors/js/vendor.bundle.base.js"></script>
<script src="../../assets/spica/vendors/chart.js/Chart.min.js"></script>
<script src="../../assets/spica/js/jquery.cookie.js"></script>
<script src="../../assets/spica/js/off-canvas.js"></script>
<script src="../../assets/spica/js/hoverable-collapse.js"></script>
<script src="../../assets/spica/js/template.js"></script>

<script>
// ---- SET TANGGAL DEFAULT HARI INI ----
document.addEventListener('DOMContentLoaded', function(){
  const today = new Date().toISOString().split('T')[0];
  document.getElementById('inputTanggal').value = today;
  updateInfoJumlah();
});

// ---- KONFIRMASI HAPUS ----
function konfirmasiHapus(no) {
  if(confirm('Yakin ingin menghapus transaksi ini?\nSemua detail transaksi juga akan ikut terhapus!')) {
    window.location = 'transaksi_penjualan.php?hapus=' + no;
  }
}

// ---- BUKA FORM EDIT ----
function openEdit(noFaktur, tanggal, idCustomer) {
  // Tampilkan form edit, sembunyikan form tambah
  document.getElementById('formTambah').style.display = 'none';
  document.getElementById('formEdit').style.display   = 'block';

  // Isi judul
  document.getElementById('formTitle').innerHTML =
    '<i class="mdi mdi-pencil-circle-outline me-1 text-warning"></i> Edit Transaksi';
  document.getElementById('formSubtitle').textContent =
    'Ubah data transaksi: ' + noFaktur;

  // Isi field
  document.getElementById('editNoFaktur').value  = noFaktur;
  document.getElementById('editTanggal').value   = tanggal;
  document.getElementById('editCustomer').value  = idCustomer;

  // Scroll ke form
  document.getElementById('formCard').scrollIntoView({behavior:'smooth'});
}

// ---- RESET KE FORM TAMBAH ----
function resetForm() {
  document.getElementById('formTambah').style.display = 'block';
  document.getElementById('formEdit').style.display   = 'none';
  document.getElementById('formTitle').innerHTML =
    '<i class="mdi mdi-plus-circle-outline me-1 text-success"></i> Tambah Transaksi Penjualan';
  document.getElementById('formSubtitle').textContent =
    'Isi form berikut untuk membuat transaksi baru.';
  document.getElementById('formTambah').reset();
  const today = new Date().toISOString().split('T')[0];
  document.getElementById('inputTanggal').value = today;
}

// ---- SEARCH / FILTER TABEL ----
document.getElementById('searchInput').addEventListener('keyup', function(){
  const keyword = this.value.toLowerCase();
  const rows    = document.querySelectorAll('#tabelPenjualan tbody tr');
  let visible   = 0;
  rows.forEach(function(row){
    const text = row.textContent.toLowerCase();
    if(text.includes(keyword)){
      row.style.display = '';
      visible++;
    } else {
      row.style.display = 'none';
    }
  });
  document.getElementById('infoJumlah').textContent =
    visible + ' data ditemukan';
});

function updateInfoJumlah(){
  const rows = document.querySelectorAll('#tabelPenjualan tbody tr');
  document.getElementById('infoJumlah').textContent = rows.length + ' data transaksi';
}
</script>
</body>
</html>