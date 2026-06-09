<?php
session_start();
include('koneksi.php');
global $koneksi;

$error   = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username  = $_POST['username'];
    $password  = $_POST['password'];
    $tipe_user = $_POST['tipe_user'];

    // cek username sudah ada atau belum
    $cek = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username'");
    if (mysqli_num_rows($cek) > 0) {
        $error = "Username sudah dipakai!";
    } else {
        $query = "INSERT INTO user (username, password, tipe_user) 
                  VALUES ('$username', '$password', '$tipe_user')";
        if (mysqli_query($koneksi, $query)) {
            $success = "Registrasi berhasil! Silakan login.";
        } else {
            $error = "Registrasi gagal, coba lagi!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Spica Admin</title>
  <link rel="stylesheet" href="assets/spica/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="assets/spica/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="assets/spica/css/style.css">
  <link rel="shortcut icon" href="assets/spica/images/favicon.png" />
</head>

<body>
  <div class="container-scroller d-flex">
    <div class="container-fluid page-body-wrapper full-page-wrapper d-flex">
      <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
        <div class="row flex-grow">
          <div class="col-lg-6 d-flex align-items-center justify-content-center">
            <div class="auth-form-transparent text-left p-3">
              <div class="brand-logo">
                <img src="assets/spica/images/logo-dark.svg" alt="logo">
              </div>
              <h4>New here?</h4>
              <h6 class="font-weight-light">Join us today! It takes only few steps</h6>
              <form class="pt-3" method="POST" action="">

                <?php if (!empty($error)): ?>
                  <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                <?php if (!empty($success)): ?>
                  <div class="alert alert-success"><?= $success ?></div>
                <?php endif; ?>

                <!-- Username -->
                <div class="form-group">
                  <label>Username</label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="mdi mdi-account-outline text-primary"></i>
                      </span>
                    </div>
                    <input type="text" name="username" class="form-control form-control-lg border-left-0" placeholder="Username">
                  </div>
                </div>

                <!-- Password -->
                <div class="form-group">
                  <label>Password</label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="mdi mdi-lock-outline text-primary"></i>
                      </span>
                    </div>
                    <input type="password" name="password" class="form-control form-control-lg border-left-0" placeholder="Password">
                  </div>
                </div>

                <!-- Tipe User -->
                <div class="form-group">
                  <label>Tipe User</label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="mdi mdi-account-key-outline text-primary"></i>
                      </span>
                    </div>
                    <select name="tipe_user" class="form-control form-control-lg border-left-0">
                      <option value="">-- Pilih Tipe User --</option>
                      <option value="Administrator">Administrator</option>
                      <option value="Customer">Customer</option>
                      <option value="Supplier">Supplier</option>
                    </select>
                  </div>
                </div>

                <!-- Agree Terms -->
                <div class="mb-4">
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="agreeTerms">
                    <label class="form-check-label text-muted" for="agreeTerms">
                      I agree to all Terms & Conditions
                    </label>
                  </div>
                </div>

                <div class="mt-3">
                  <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN UP</button>
                </div>
                <div class="text-center mt-4 font-weight-light">
                  Already have an account? <a href="login.php" class="text-primary">Login</a>
                </div>

              </form>
            </div>
          </div>
          <div class="col-lg-6 register-half-bg d-none d-lg-flex flex-row">
            <p class="text-white font-weight-medium text-center flex-grow align-self-end">Copyright &copy; 2021 All rights reserved.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/spica/vendors/js/vendor.bundle.base.js"></script>
  <script src="assets/spica/js/jquery.cookie.js" type="text/javascript"></script>
  <script src="assets/spica/js/off-canvas.js"></script>
  <script src="assets/spica/js/hoverable-collapse.js"></script>
  <script src="assets/spica/js/template.js"></script>
</body>

</html>