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

if(!isset($_GET['id_customer']) || empty($_GET['id_customer'])){
    echo "<script>alert('ID Customer tidak ditemukan!');window.location='data_customer.php';</script>";
    exit;
}

$id_customer = $_GET['id_customer'];

$hapus = mysqli_query($conn, "DELETE FROM tb_customer WHERE id_customer='$id_customer'");

if($hapus){
    echo "<script>alert('Data berhasil dihapus!');window.location='data_customer.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus data!');window.location='data_customer.php';</script>";
}
?>