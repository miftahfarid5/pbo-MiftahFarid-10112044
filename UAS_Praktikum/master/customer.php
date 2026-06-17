<?php
define('ROOT', '..');
require_once ROOT . '/classes/Customer.php';

$customer = new Customer();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aksi = $_POST['aksi'];
    $data = [
        'id_customer'      => $_POST['id_customer'],
        'nama_customer'    => $_POST['nama_customer'],
        'jenis_kelamin'    => $_POST['jenis_kelamin'],
        'alamat_customer'  => $_POST['alamat_customer'],
        'telepon_customer' => $_POST['telepon_customer'],
        'email_customer'   => $_POST['email_customer'],
        'pass_customer'    => $_POST['pass_customer'],
    ];
    if ($aksi === 'tambah') {
        $customer->insert($data);
        header("location: customer.php?pesan=Customer+berhasil+ditambahkan");
    } else {
        $customer->update($data);
        header("location: customer.php?pesan=Customer+berhasil+diupdate");
    }
    exit;
}
if (isset($_GET['hapus'])) {
    $customer->delete($_GET['hapus']);
    header("location: customer.php?pesan=Customer+berhasil+dihapus");
    exit;
}

$editData = null;
$autoId   = $customer->generateId();
if (isset($_GET['edit'])) $editData = $customer->getById($_GET['edit']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Customer</title>
  <link rel="stylesheet" href="<?= ROOT ?>/style.css">
</head>
<body>
<div class="judul">
  <h1>Aplikasi Inventory Gudang</h1>
  <h2>Data Master - Customer</h2>
</div>
<?php include ROOT . '/includes/navbar.php'; ?>
<div class="container">
  <?php if(isset($_GET['pesan'])): ?>
    <p style="color:green;font-weight:600;"><?= htmlspecialchars($_GET['pesan']) ?></p>
  <?php endif; ?>

  <h3><?= $editData ? 'Edit' : 'Tambah' ?> Data Customer</h3>
  <form action="customer.php" method="post">
    <input type="hidden" name="aksi" value="<?= $editData ? 'update' : 'tambah' ?>">
    <table>
      <tr><td>ID Customer</td>
        <td><input type="text" name="id_customer"
             value="<?= $editData ? $editData['id_customer'] : $autoId ?>"
             <?= $editData ? 'readonly' : '' ?> required></td></tr>
      <tr><td>Nama Customer</td>
        <td><input type="text" name="nama_customer" value="<?= $editData['nama_customer'] ?? '' ?>" required></td></tr>
      <tr><td>Jenis Kelamin</td>
        <td>
          <select name="jenis_kelamin">
            <option value="Laki-laki" <?= (isset($editData) && $editData['jenis_kelamin']=='Laki-laki')?'selected':'' ?>>Laki-laki</option>
            <option value="Perempuan" <?= (isset($editData) && $editData['jenis_kelamin']=='Perempuan')?'selected':'' ?>>Perempuan</option>
          </select>
        </td></tr>
      <tr><td>Alamat</td>
        <td><textarea name="alamat_customer"><?= $editData['alamat_customer'] ?? '' ?></textarea></td></tr>
      <tr><td>Telepon</td>
        <td><input type="text" name="telepon_customer" value="<?= $editData['telepon_customer'] ?? '' ?>"></td></tr>
      <tr><td>Email</td>
        <td><input type="email" name="email_customer" value="<?= $editData['email_customer'] ?? '' ?>"></td></tr>
      <tr><td>Password</td>
        <td><input type="text" name="pass_customer" value="<?= $editData['pass_customer'] ?? '' ?>"></td></tr>
      <tr><td></td>
        <td>
          <input type="submit" value="<?= $editData ? 'Update' : 'Simpan' ?>">
          <?php if($editData): ?>&nbsp;<a href="customer.php">Batal</a><?php endif; ?>
        </td></tr>
    </table>
  </form>

  <br>
  <h3>Daftar Customer</h3>
  <table border="1" class="table">
    <tr><th>No</th><th>ID</th><th>Nama</th><th>JK</th><th>Alamat</th><th>Telepon</th><th>Email</th><th>Opsi</th></tr>
    <?php $no=1; $res=$customer->getAll(); while($d=mysqli_fetch_assoc($res)): ?>
    <tr>
      <td><?= $no++ ?></td>
      <td><?= $d['id_customer'] ?></td>
      <td><?= $d['nama_customer'] ?></td>
      <td><?= $d['jenis_kelamin'] ?></td>
      <td><?= $d['alamat_customer'] ?></td>
      <td><?= $d['telepon_customer'] ?></td>
      <td><?= $d['email_customer'] ?></td>
      <td>
        <a class="edit" href="customer.php?edit=<?= urlencode($d['id_customer']) ?>">Edit</a>
        <a class="hapus" href="customer.php?hapus=<?= urlencode($d['id_customer']) ?>"
           onclick="return confirm('Hapus customer ini?')">Hapus</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
</div>
</body>
</html>
