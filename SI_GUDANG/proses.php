<?php
session_start();
include('koneksi.php');

$action = $_GET['action'] ?? '';

// ===== LOGIN =====
if($action == "login"){
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek sesuai tipe_user di tabel user
    $result = mysqli_query($conn, "SELECT * FROM user 
                                   WHERE username='$username' 
                                   AND password='$password'");

    if(mysqli_num_rows($result) > 0){
        $user = mysqli_fetch_assoc($result);
        $_SESSION['username']  = $username;
        $_SESSION['tipe_user'] = $user['tipe_user'];

        if($user['tipe_user'] == 'Administrator'){
            header("Location: backend/admin/index_admin.php");
            exit();
        }
        else if($user['tipe_user'] == 'Customer'){
            header("Location: backend/customer/index_customer.php");
            exit();
        }
        else if($user['tipe_user'] == 'Supplier'){
            header("Location: backend/supplier/index_supplier.php");
            exit();
        }
    }
    else{
        header("Location: login.php?error=gagal");
        exit();
    }
}

// ===== LOGOUT =====
else if($action == "logout"){
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

// ===== AKSES LANGSUNG TANPA ACTION =====
else{
    header("Location: login.php");
    exit();
}
?>