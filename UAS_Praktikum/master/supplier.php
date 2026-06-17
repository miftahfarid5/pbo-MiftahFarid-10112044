<?php
define('ROOT', '..');
require_once ROOT . '/classes/Supplier.php';

$supplier = new Supplier();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aksi = $_POST['aksi'];
    $data = [
        'id_supplier'      => $_POST['id_supplier'],
        'nama_supplier'    => $_POST['nama_supplier'],
        'alamat_supplier'  => $_POST['alamat_supplier'],
        'telepon_supplier' => $_POST['telepon_supplier'],
        'email_supplier'   => $_POST['email_supplier'],
        'pass_supplier'    => $_POST['pass_supplier'],
    ];
    if ($aksi === 'tambah') {
        $supplier->insert($data);
        header("location: supplier.php?pesan=Supplier+berhasil+ditambahkan");
    } else {
        $supplier->update($data);
        header("location: supplier.php?pesan=Supplier+berhasil+diupdate");
    }
    exit;
}
if (isset($_GET['hapus'])) {
    $supplier->delete($_GET['hapus']);
    header("location: supplier.php?pesan=Supplier+berhasil+dihapus");
    exit;
}

$editData = null;
$autoId   = $supplier->generateId();
if (isset($_GET['edit'])) $editData = $supplier->getById($_GET['edit']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Supplier</title>
  <link rel="stylesheet" href="<?= ROOT ?>/style.css">
</head>
<body>
<div class="judul">
  <h1>Aplikasi Inventory Gudang</h1>
  <h2>Data Master - Supplier</h2>
</div>
<?php include ROOT . '/includes/navbar.php'; ?>
<div class="container">
  <?php if(isset($_GET['pesan'])): ?>
    <p style="color:green;font-weight:600;"><?= htmlspecialchars($_GET['pesan']) ?></p>
  <?php endif; ?>

  <h3><?= $editData ? 'Edit' : 'Tambah' ?> Data Supplier</h3>
  <form action="supplier.php" method="post">
    <input type="hidden" name="aksi" value="<?= $editData ? 'update' : 'tambah' ?>">
    <table>
      <tr>
        <td>ID Supplier</td>
        <td><input type="text" name="id_supplier"
             value="<?= $editData ? $editData['id_supplier'] : $autoId ?>"
             <?= $editData ? 'readonly' : '' ?> required></td>
      </tr>
      <tr><td>Nama Supplier</td>
        <td><input type="text" name="nama_supplier" value="<?= $editData['nama_supplier'] ?? '' ?>" required></td></tr>
      <tr><td>Alamat</td>
        <td><textarea name="alamat_supplier"><?= $editData['alamat_supplier'] ?? '' ?></textarea></td></tr>
      <tr><td>Telepon</td>
        <td><input type="text" name="telepon_supplier" value="<?= $editData['telepon_supplier'] ?? '' ?>"></td></tr>
      <tr><td>Email</td>
        <td><input type="email" name="email_supplier" value="<?= $editData['email_supplier'] ?? '' ?>"></td></tr>
      <tr><td>Password</td>
        <td><input type="text" name="pass_supplier" value="<?= $editData['pass_supplier'] ?? '' ?>"></td></tr>
      <tr><td></td>
        <td>
          <input type="submit" value="<?= $editData ? 'Update' : 'Simpan' ?>">
          <?php if($editData): ?>&nbsp;<a href="supplier.php">Batal</a><?php endif; ?>
        </td>
      </tr>
    </table>
  </form>

  <br>
  <h3>Daftar Supplier</h3>
  <table border="1" class="table">
    <tr><th>No</th><th>ID</th><th>Nama</th><th>Alamat</th><th>Telepon</th><th>Email</th><th>Opsi</th></tr>
    <?php $no=1; $res=$supplier->getAll(); while($d=mysqli_fetch_assoc($res)): ?>
    <tr>
      <td><?= $no++ ?></td>
      <td><?= $d['id_supplier'] ?></td>
      <td><?= $d['nama_supplier'] ?></td>
      <td><?= $d['alamat_supplier'] ?></td>
      <td><?= $d['telepon_supplier'] ?></td>
      <td><?= $d['email_supplier'] ?></td>
      <td>
        <a class="edit" href="supplier.php?edit=<?= urlencode($d['id_supplier']) ?>">Edit</a>
        <a class="hapus" href="supplier.php?hapus=<?= urlencode($d['id_supplier']) ?>"
           onclick="return confirm('Hapus supplier ini?')">Hapus</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
</div>
</body>
</html>
