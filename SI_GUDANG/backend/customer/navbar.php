<div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
  <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
    <span class="mdi mdi-menu"></span>
  </button>
  <div class="navbar-brand-wrapper">
    <a class="navbar-brand brand-logo" href="index_customer.php">
      <img src="../../assets/spica/images/logo.svg" alt="logo"/>
    </a>
    <a class="navbar-brand brand-logo-mini" href="index_customer.php">
      <img src="../../assets/spica/images/logo-mini.svg" alt="logo"/>
    </a>
  </div>
  <h4 class="font-weight-bold mb-0 d-none d-md-block mt-1">
    Welcome <?php echo $_SESSION['username']; ?>
  </h4>
  <ul class="navbar-nav navbar-nav-right">
    <li class="nav-item">
      <h4 class="mb-0 font-weight-bold d-none d-xl-block" id="realtime-clock"></h4>
    </li>
    <li class="nav-item dropdown me-1">
      <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center"
         id="messageDropdown" href="#" data-bs-toggle="dropdown">
        <i class="mdi mdi-calendar mx-0"></i>
        <span class="count bg-info">0</span>
      </a>
      <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
        <p class="mb-0 font-weight-normal float-left dropdown-header">Messages</p>
        <a class="dropdown-item">
          <div class="preview-item-content">
            <p class="font-weight-light small-text text-muted mb-0">Tidak ada pesan</p>
          </div>
        </a>
      </div>
    </li>
    <li class="nav-item dropdown me-2">
      <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center"
         id="notificationDropdown" href="#" data-bs-toggle="dropdown">
        <i class="mdi mdi-bell mx-0"></i>
        <span class="count bg-danger">0</span>
      </a>
      <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
        <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
        <a class="dropdown-item">
          <div class="preview-item-content">
            <p class="font-weight-light small-text mb-0 text-muted">Tidak ada notifikasi</p>
          </div>
        </a>
      </div>
    </li>
  </ul>
  <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
    <span class="mdi mdi-menu"></span>
  </button>
</div>

<div class="navbar-menu-wrapper navbar-search-wrapper d-none d-lg-flex align-items-center">
  <ul class="navbar-nav mr-lg-2">
    <li class="nav-item nav-search d-none d-lg-block">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search Here..." aria-label="search">
      </div>
    </li>
  </ul>
  <ul class="navbar-nav navbar-nav-right">
    <li class="nav-item nav-profile dropdown">
      <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
        <img src="../../assets/spica/images/faces/face5.jpg" alt="profile"/>
        <span class="nav-profile-name"><?php echo $_SESSION['username']; ?></span>
      </a>
      <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
        <a class="dropdown-item" href="../../proses.php?action=logout">
          <i class="mdi mdi-logout text-primary"></i>
          Logout
        </a>
      </div>
    </li>
    <li class="nav-item">
      <a href="#" class="nav-link icon-link"><i class="mdi mdi-plus-circle-outline"></i></a>
    </li>
    <li class="nav-item">
      <a href="#" class="nav-link icon-link"><i class="mdi mdi-web"></i></a>
    </li>
  </ul>
</div>

<script>
function updateClock() {
    const now = new Date();
    const hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    const bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    const namaHari = hari[now.getDay()];
    const tanggal = now.getDate();
    const namaBulan = bulan[now.getMonth()];
    const tahun = now.getFullYear();
    const jam = String(now.getHours()).padStart(2, '0');
    const menit = String(now.getMinutes()).padStart(2, '0');
    const detik = String(now.getSeconds()).padStart(2, '0');
    document.getElementById('realtime-clock').innerHTML =
        namaHari + ', ' + tanggal + ' ' + namaBulan + ' ' + tahun + ' | ' + jam + ':' + menit + ':' + detik;
}
updateClock();
setInterval(updateClock, 1000);
</script>