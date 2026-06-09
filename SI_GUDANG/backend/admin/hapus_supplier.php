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

if(!isset($_GET['id_supplier']) || empty($_GET['id_supplier'])){
    echo "<script>alert('ID Supplier tidak ditemukan!');window.location='data_supplier.php';</script>";
    exit;
}

$id_supplier = $_GET['id_supplier'];

$hapus = mysqli_query($conn, "DELETE FROM tb_supplier WHERE id_supplier='$id_supplier'");

if($hapus){
    echo "<script>alert('Data berhasil dihapus!');window.location='data_supplier.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus data!');window.location='data_supplier.php';</script>";
}
?>