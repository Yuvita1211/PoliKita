<?php
include_once "koneksi.php";
session_start();

if (isset($_SESSION['login'])) {
    $_SESSION['login'] = true;
} else {
    echo "<meta http-equiv='refresh' content='0; url=../../login.php'>";
    die();
}

$nama = $_SESSION['username'];
$akses = $_SESSION['akses'];
$id_dokter = $_SESSION['id'];

if ($akses != 'dokter') {
    echo "<meta http-equiv='refresh' content='0; url=..'>";
    die();
}

// Input data to db
if (isset($_POST["submit"])) {
  // Cek validasi
  if (empty($_POST["hari"]) || empty($_POST["jam_mulai"]) || empty($_POST["jam_selesai"]) || empty($_POST["status"])) {
      echo "
          <script>
              alert('Data tidak boleh kosong');
              document.location.href = 'create_jadwal.php';
          </script>
      ";
      die;
  } else {  
    // cek apakah data berhasil di tambahkan atau tidak
    if (tambahJadwalPeriksa($_POST) > 0) {
        echo "
            <script>
                alert('Data berhasil ditambahkan');
                document.location.href = 'index_jadwal.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data Gagal ditambahkan');
                document.location.href = 'index_jadwal.php';
            </script>
        ";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard Dokter</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="img/udinus.png" rel="icon">
  <link href="img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="style2.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">Dashboard Dokter</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="img/profil.jpeg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?= $nama?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?= $nama?></h6>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Keluar</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="index.html">
          <i class="bi bi-grid"></i>
          <span>Jadwal Periksa</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="users-profile.html">
          <i class="bi bi-person"></i>
          <span>Tambah Jadwal Periksa</span>
        </a>
      </li><!-- End Profile Page Nav -->

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Tambah Jadwal</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Tambah Jadwal</h5>
                        <!-- Floating Labels Form -->
                        <form action="" id="tambahJadwal" method="POST" class="row g-3">
                            <div class="form-floating">
                                <input type="hidden" class="form-control" name="id_dokter" value="<?= $id_dokter?>">
                            </div>
                            
                            <div class="form-floating">
                                <select class="form-select" id="hari" name="hari">
                                <option>-- Pilih Hari --</option>
                                <option>Senin</option>
                                <option>Selasa</option>
                                <option>Rabu</option>
                                <option>Kamis</option>
                                <option>Jumat</option>
                                <option>Sabtu</option>
                                </select>
                                <label for="hari">Hari</label>
                            </div>
                              <div class="form-floating">
                                <input type="time" class="form-control" name="jam_mulai" id="jam_mulai" style="height: 100px"></input>
                                <label for="Keluhan">Jam Mulai</label>
                              </div>
                              <div class="form-floating">
                                <input type="time" class="form-control" name="jam_selesai" id="jam_selesai" style="height: 100px"></input>
                                <label for="Keluhan">Jam Selesai</label>
                              </div>
                              <div class="form-group ml-3">
                                <label for="jam_selesai">Status</label>
                                <br/>
                                <!-- <input type="" name="status" id="jam_selesai" class="form-control"> -->
                                <input class="form-check-input" type="radio" name="status" id="flexRadioDefault1" value="Y">
                                <label class="form-check-label" for="flexRadioDefault1">
                                  Y
                                </label>
                                <br/>
                                <input class="form-check-input" type="radio" name="status" id="flexRadioDefault2" value="N" checked>
                                <label class="form-check-label" for="flexRadioDefault2">
                                N
                                </label>
                              </div>
                            <div class="text-center">
                            <button type="submit" name="submit" id="submitButton" class="btn btn-primary">Simpan</button>
                            </div>
                        </form><!-- End floating Labels Form -->
                </div>
            </div>
            
    </section>

  </main><!-- End #main -->
  <script>
    document.getElementById('inputPoli').addEventListener('change', function() {
    var poliId = this.value; // Ambil nilai ID poli yang dipilih
    loadJadwal(poliId); // Panggil fungsi untuk memuat jadwal dokter
});

function loadJadwal(poliId) {
    // Buat objek XMLHttpRequest
    var xhr = new XMLHttpRequest();

    // Konfigurasi permintaan Ajax
    xhr.open('GET', 'http://localhost/POLI_BK/get_jadwal.php?poli_id=' + poliId, true);

    // Atur header untuk menentukan bahwa respons yang diharapkan adalah HTML
    xhr.setRequestHeader('Content-Type', 'text/html');

    // Atur fungsi callback ketika permintaan selesai
    xhr.onload = function() {
        if (xhr.status == 200) {
            // Jika permintaan berhasil, perbarui opsi pada select pilih jadwal
            document.getElementById('inputJadwal').innerHTML = xhr.responseText;
        }
    };

    // Kirim permintaan
    xhr.send();
}
  </script>

  <!-- ======= Footer ======= -->
  

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="vendor/apexcharts/apexcharts.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/chart.js/chart.umd.js"></script>
  <script src="vendor/echarts/echarts.min.js"></script>
  <script src="vendor/quill/quill.js"></script>
  <script src="vendor/simple-datatables/simple-datatables.js"></script>
  <script src="vendor/tinymce/tinymce.min.js"></script>
  <script src="vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="js/main.js"></script>

</body>

</html>