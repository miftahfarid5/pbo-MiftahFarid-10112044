<?php
define('ROOT', '..');
require_once ROOT . '/classes/Barang.php';
require_once ROOT . '/classes/Jenis.php';

$barang = new Barang();
$jenis  = new Jenis();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aksi = $_POST['aksi'] ?? '';
    $data = [
        'kd_barang'   => $_POST['kd_barang'],
        'kode_jenis'  => $_POST['kode_jenis'],
        'nama_barang' => $_POST['nama_barang'],
        'stok'        => $_POST['stok'],
        'harga_beli'  => $_POST['harga_beli'],
        'harga_jual'  => $_POST['harga_jual'],
    ];
    if ($aksi === 'tambah') {
        $barang->insert($data);
        header("location: barang.php?pesan=Barang+berhasil+ditambahkan");
    } else {
        $barang->update($data);
        header("location: barang.php?pesan=Barang+berhasil+diupdate");
    }
    exit;
}

if (isset($_GET['hapus'])) {
    $barang->delete($_GET['hapus']);
    header("location: barang.php?pesan=Barang+berhasil+dihapus");
    exit;
}

$editData = null;
$autoKode = $barang->generateKode();
if (isset($_GET['edit'])) {
    $editData = $barang->getById($_GET['edit']);
}

function rupiah($n) { return 'Rp ' . number_format($n, 0, ',', '.'); }
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Barang</title>
  <link rel="stylesheet" href="<?= ROOT ?>/style.css">
</head>
<body>
<div class="judul">
  <h1>Aplikasi Inventory Gudang</h1>
  <h2>Data Master - Barang</h2>
</div>
<?php include ROOT . '/includes/navbar.php'; ?>
<div class="container">
  <?php if(isset($_GET['pesan'])): ?>
    <p style="color:green;font-weight:600;"><?= htmlspecialchars($_GET['pesan']) ?></p>
  <?php endif; ?>

  <h3><?= $editData ? 'Edit' : 'Tambah' ?> Data Barang</h3>
  <form action="barang.php" method="post">
    <input type="hidden" name="aksi" value="<?= $editData ? 'update' : 'tambah' ?>">
    <table>
      <tr>
        <td>Kode Barang</td>
        <td><input type="text" name="kd_barang"
             value="<?= $editData ? $editData['kd_barang'] : $autoKode ?>"
             <?= $editData ? 'readonly' : '' ?> required></td>
      </tr>
      <tr>
        <td>Jenis Barang</td>
        <td>
          <select name="kode_jenis" required>
            <option value="">-- Pilih Jenis --</option>
            <?php $resJ = $jenis->getAll(); while($j = mysqli_fetch_assoc($resJ)): ?>
              <option value="<?= $j['kode_jenis'] ?>"
                <?= (isset($editData) && $editData['kode_jenis'] == $j['kode_jenis']) ? 'selected' : '' ?>>
                <?= $j['jenis'] ?> (<?= $j['satuan'] ?>)
              </option>
            <?php endwhile; ?>
          </select>
        </td>
      </tr>
      <tr>
        <td>Nama Barang</td>
        <td><input type="text" name="nama_barang" value="<?= $editData['nama_barang'] ?? '' ?>" required></td>
      </tr>
      <tr>
        <td>Stok Awal</td>
        <td><input type="number" name="stok" value="<?= $editData['stok'] ?? 0 ?>" min="0" required></td>
      </tr>
      <tr>
        <td>Harga Beli</td>
        <td><input type="number" name="harga_beli" value="<?= $editData['harga_beli'] ?? 0 ?>" min="0" required></td>
      </tr>
      <tr>
        <td>Harga Jual</td>
        <td><input type="number" name="harga_jual" value="<?= $editData['harga_jual'] ?? 0 ?>" min="0" required></td>
      </tr>
      <tr>
        <td></td>
        <td>
          <input type="submit" value="<?= $editData ? 'Update' : 'Simpan' ?>">
          <?php if($editData): ?>&nbsp;<a href="barang.php">Batal</a><?php endif; ?>
        </td>
      </tr>
    </table>
  </form>

  <br>
  <h3>Daftar Barang</h3>
  <table border="1" class="table">
    <tr>
      <th>No</th><th>Kode</th><th>Nama Barang</th><th>Jenis</th>
      <th>Satuan</th><th>Stok</th><th>Harga Beli</th><th>Harga Jual</th><th>Opsi</th>
    </tr>
    <?php $no=1; $res=$barang->getAll(); while($d=mysqli_fetch_assoc($res)): ?>
    <tr>
      <td><?= $no++ ?></td>
      <td><?= $d['kd_barang'] ?></td>
      <td><?= $d['nama_barang'] ?></td>
      <td><?= $d['jenis'] ?></td>
      <td><?= $d['satuan'] ?></td>
      <td style="text-align:center;<?= $d['stok']<5?'color:#d32f2f;font-weight:700;':'' ?>"><?= $d['stok'] ?></td>
      <td><?= rupiah($d['harga_beli']) ?></td>
      <td><?= rupiah($d['harga_jual']) ?></td>
      <td>
        <a class="edit" href="barang.php?edit=<?= urlencode($d['kd_barang']) ?>">Edit</a>
        <a class="hapus" href="barang.php?hapus=<?= urlencode($d['kd_barang']) ?>"
           onclick="return confirm('Hapus barang ini?')">Hapus</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
</div>
</body>
</html>
