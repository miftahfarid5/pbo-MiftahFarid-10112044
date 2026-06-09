<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login - SI Gudang</title>
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
              <h4>Welcome back!</h4>
              <h6 class="font-weight-light">Happy to see you again!</h6>

              <?php if(isset($_GET['error'])): ?>
                <div class="alert alert-danger">
                  <?php
                    if($_GET['error'] == 'gagal') echo "Username atau password salah!";
                  ?>
                </div>
              <?php endif; ?>

              <form class="pt-3" method="POST" action="proses.php?action=login">

                <div class="form-group">
                  <label>Username</label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="mdi mdi-account-outline text-primary"></i>
                      </span>
                    </div>
                    <input type="text" name="username" class="form-control form-control-lg border-left-0" placeholder="Username" required>
                  </div>
                </div>

                <div class="form-group">
                  <label>Password</label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="mdi mdi-lock-outline text-primary"></i>
                      </span>
                    </div>
                    <input type="password" name="password" class="form-control form-control-lg border-left-0" placeholder="Password" required>
                  </div>
                </div>

                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="keepSignedIn">
                    <label class="form-check-label text-muted" for="keepSignedIn">Keep me signed in</label>
                  </div>
                  <a href="#" class="auth-link text-black">Forgot password?</a>
                </div>

                <div class="my-3">
                  <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">LOGIN</button>
                </div>

                <div class="text-center mt-4 font-weight-light">
                  Don't have an account? <a href="register.php" class="text-primary">Create</a>
                </div>

              </form>
            </div>
          </div>
          <div class="col-lg-6 login-half-bg d-none d-lg-flex flex-row">
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