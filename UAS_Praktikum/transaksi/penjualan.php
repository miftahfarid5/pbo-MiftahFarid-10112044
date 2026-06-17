<?php
define('ROOT', '..');
require_once ROOT . '/classes/Penjualan.php';
require_once ROOT . '/classes/Customer.php';
require_once ROOT . '/classes/Barang.php';

$penjualan = new Penjualan();
$customer  = new Customer();
$barang    = new Barang();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $header = [
        'no_penjualan'      => $_POST['no_penjualan'],
        'tanggal_penjualan' => $_POST['tanggal_penjualan'],
        'id_customer'       => $_POST['id_customer'],
    ];
    $items      = [];
    $kdBarangs  = $_POST['kd_barang']     ?? [];
    $kdJenis    = $_POST['kode_jenis']    ?? [];
    $jmls       = $_POST['jumlah_barang'] ?? [];
    $hrgBarangs = $_POST['harga_barang']  ?? [];
    foreach ($kdBarangs as $i => $kd) {
        if (empty($kd)) continue;
        $jml = (int)$jmls[$i];
        $hrg = (int)$hrgBarangs[$i];
        $items[] = [
            'kd_barang'     => $kd,
            'kode_jenis'    => $kdJenis[$i],
            'jumlah_barang' => $jml,
            'harga_barang'  => $hrg,
            'total_harga'   => $jml * $hrg,
        ];
    }
    if ($penjualan->simpan($header, $items)) {
        header("location: penjualan.php?pesan=Transaksi+penjualan+berhasil+disimpan");
    } else {
        header("location: penjualan.php?pesan=Gagal+menyimpan+transaksi");
    }
    exit;
}

if (isset($_GET['hapus'])) {
    $penjualan->delete($_GET['hapus']);
    header("location: penjualan.php?pesan=Transaksi+berhasil+dihapus");
    exit;
}

$viewDetail = null;
$viewHeader = null;
if (isset($_GET['detail'])) {
    $viewHeader = $penjualan->getById($_GET['detail']);
    $viewDetail = $penjualan->getDetail($_GET['detail']);
}

$autoNo = $penjualan->generateNomor();

function rupiah($n) { return 'Rp ' . number_format($n, 0, ',', '.'); }

$allBarang = [];
$resB = $barang->getAll();
while ($b = mysqli_fetch_assoc($resB)) { $allBarang[] = $b; }
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Transaksi Penjualan</title>
  <link rel="stylesheet" href="<?= ROOT ?>/style.css">
  <style>
    .btn-add { background:#2d89ef; color:#fff; border:none; padding:6px 12px; cursor:pointer; border-radius:3px; font-size:13px; }
    .btn-del { background:#d24a4a; color:#fff; border:none; padding:4px 8px; cursor:pointer; border-radius:3px; font-size:12px; }
    .detail-table input[type=number] { width:90px; }
    .detail-table select { width:160px; }
  </style>
</head>
<body>
<div class="judul">
  <h1>Aplikasi Inventory Gudang</h1>
  <h2>Transaksi Penjualan</h2>
</div>
<?php include ROOT . '/includes/navbar.php'; ?>
<div class="container">
  <?php if(isset($_GET['pesan'])): ?>
    <p style="color:green;font-weight:600;"><?= htmlspecialchars($_GET['pesan']) ?></p>
  <?php endif; ?>

  <?php if ($viewHeader): ?>
    <h3>Detail Penjualan: <?= $viewHeader['no_penjualan'] ?></h3>
    <table>
      <tr><td>No Penjualan</td><td>: <?= $viewHeader['no_penjualan'] ?></td></tr>
      <tr><td>Tanggal</td><td>: <?= $viewHeader['tanggal_penjualan'] ?></td></tr>
      <tr><td>Customer</td><td>: <?= $viewHeader['nama_customer'] ?></td></tr>
      <tr><td>Total Barang</td><td>: <?= $viewHeader['total_barangall'] ?></td></tr>
      <tr><td>Total Harga</td><td>: <?= rupiah($viewHeader['total_hargaall']) ?></td></tr>
    </table>
    <br>
    <table border="1" class="table">
      <tr><th>No</th><th>Kode</th><th>Nama Barang</th><th>Jenis</th><th>Satuan</th><th>Jumlah</th><th>Harga</th><th>Total</th></tr>
      <?php $no=1; while($d=mysqli_fetch_assoc($viewDetail)): ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= $d['kd_barang'] ?></td>
        <td><?= $d['nama_barang'] ?></td>
        <td><?= $d['jenis'] ?></td>
        <td><?= $d['satuan'] ?></td>
        <td><?= $d['jumlah_barang'] ?></td>
        <td><?= rupiah($d['harga_barang']) ?></td>
        <td><?= rupiah($d['total_harga']) ?></td>
      </tr>
      <?php endwhile; ?>
    </table>
    <br><a class="tombol" href="penjualan.php">← Kembali</a>

  <?php else: ?>
    <h3>Form Transaksi Penjualan Baru</h3>
    <form action="penjualan.php" method="post">
      <table>
        <tr><td>No Penjualan</td>
          <td><input type="text" name="no_penjualan" value="<?= $autoNo ?>" readonly></td></tr>
        <tr><td>Tanggal</td>
          <td><input type="date" name="tanggal_penjualan" value="<?= date('Y-m-d') ?>" required></td></tr>
        <tr><td>Customer</td>
          <td>
            <select name="id_customer" required>
              <option value="">-- Pilih Customer --</option>
              <?php $resC=$customer->getAll(); while($c=mysqli_fetch_assoc($resC)): ?>
                <option value="<?= $c['id_customer'] ?>"><?= $c['nama_customer'] ?></option>
              <?php endwhile; ?>
            </select>
          </td></tr>
      </table>

      <br>
      <h3>Detail Barang</h3>
      <table border="1" class="table detail-table" id="tblDetail">
        <tr>
          <th>No</th><th>Pilih Barang</th><th>Jenis</th><th>Stok</th>
          <th>Harga Jual</th><th>Jumlah</th><th>Subtotal</th><th>Aksi</th>
        </tr>
        <tr id="row1">
          <td>1</td>
          <td>
            <select name="kd_barang[]" onchange="isiHarga(this)" required>
              <option value="">-- Pilih --</option>
              <?php foreach($allBarang as $b): ?>
                <option value="<?= $b['kd_barang'] ?>"
                        data-jenis="<?= $b['kode_jenis'] ?>"
                        data-harga="<?= $b['harga_jual'] ?>"
                        data-stok="<?= $b['stok'] ?>">
                  <?= $b['nama_barang'] ?> (Stok: <?= $b['stok'] ?>)
                </option>
              <?php endforeach; ?>
            </select>
            <input type="hidden" name="kode_jenis[]" class="kode_jenis_field">
          </td>
          <td class="jenis_label">-</td>
          <td class="stok_label">-</td>
          <td><input type="number" name="harga_barang[]" class="harga_field" value="0" min="0" onchange="hitungSubtotal(this)"></td>
          <td><input type="number" name="jumlah_barang[]" value="1" min="1" onchange="hitungSubtotal(this)"></td>
          <td class="subtotal_label">Rp 0</td>
          <td><button type="button" class="btn-del" onclick="hapusBaris(this)">✕</button></td>
        </tr>
      </table>
      <button type="button" class="btn-add" onclick="tambahBaris()">+ Tambah Barang</button>
      <br><br>
      <strong>Total: <span id="grandTotal">Rp 0</span></strong>
      <br><br>
      <input type="submit" value="Simpan Penjualan">
    </form>

    <br>
    <h3>History Penjualan</h3>
    <table border="1" class="table">
      <tr><th>No</th><th>No Penjualan</th><th>Tanggal</th><th>Customer</th><th>Total Barang</th><th>Total Harga</th><th>Opsi</th></tr>
      <?php $no=1; $res=$penjualan->getAll(); while($d=mysqli_fetch_assoc($res)): ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= $d['no_penjualan'] ?></td>
        <td><?= $d['tanggal_penjualan'] ?></td>
        <td><?= $d['nama_customer'] ?></td>
        <td><?= $d['total_barangall'] ?></td>
        <td><?= rupiah($d['total_hargaall']) ?></td>
        <td>
          <a class="edit" href="penjualan.php?detail=<?= urlencode($d['no_penjualan']) ?>">Detail</a>
          <a class="hapus" href="penjualan.php?hapus=<?= urlencode($d['no_penjualan']) ?>"
             onclick="return confirm('Hapus transaksi? Stok akan dikembalikan.')">Hapus</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </table>
  <?php endif; ?>
</div>
<script>
function isiHarga(sel) {
    const opt  = sel.options[sel.selectedIndex];
    const row  = sel.closest('tr');
    const harga = opt.getAttribute('data-harga') || 0;
    const jenis = opt.getAttribute('data-jenis') || '-';
    const stok  = opt.getAttribute('data-stok')  || '-';
    row.querySelector('.harga_field').value          = harga;
    row.querySelector('.kode_jenis_field').value     = jenis;
    row.querySelector('.jenis_label').textContent    = jenis;
    row.querySelector('.stok_label').textContent     = stok;
    row.querySelector('[name="jumlah_barang[]"]').max = stok;
    hitungSubtotal(row.querySelector('.harga_field'));
}

function hitungSubtotal(el) {
    const row = el.closest('tr');
    const hrg = parseInt(row.querySelector('[name="harga_barang[]"]').value) || 0;
    const jml = parseInt(row.querySelector('[name="jumlah_barang[]"]').value) || 0;
    const sub = hrg * jml;
    row.querySelector('.subtotal_label').textContent = 'Rp ' + sub.toLocaleString('id-ID');
    hitungGrand();
}

function hitungGrand() {
    let total = 0;
    document.querySelectorAll('.subtotal_label').forEach(el => {
        total += parseInt(el.textContent.replace(/[^0-9]/g, '')) || 0;
    });
    document.getElementById('grandTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
}

let rowCount = 1;
function tambahBaris() {
    rowCount++;
    const tbl     = document.getElementById('tblDetail');
    const template = document.getElementById('row1');
    const newRow  = template.cloneNode(true);
    newRow.id = 'row' + rowCount;
    newRow.querySelector('td:first-child').textContent = rowCount;
    newRow.querySelector('select').value = '';
    newRow.querySelector('.harga_field').value = 0;
    newRow.querySelector('[name="jumlah_barang[]"]').value = 1;
    newRow.querySelector('.jenis_label').textContent  = '-';
    newRow.querySelector('.stok_label').textContent   = '-';
    newRow.querySelector('.kode_jenis_field').value   = '';
    newRow.querySelector('.subtotal_label').textContent = 'Rp 0';
    tbl.appendChild(newRow);
}

function hapusBaris(btn) {
    const rows = document.querySelectorAll('#tblDetail tr[id^=row]');
    if (rows.length <= 1) return alert('Minimal 1 barang harus ada.');
    btn.closest('tr').remove();
    hitungGrand();
}
</script>
</body>
</html>
