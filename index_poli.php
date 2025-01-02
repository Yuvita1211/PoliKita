<?php
session_start();
include("koneksi.php");
// Ambil data pengguna dari sesi
$id_pasien = $_SESSION['id'];
$no_rm = $_SESSION['no_rm'];
$nama = $_SESSION['username'];

// Jika tombol submit ditekan
if (isset($_POST['submit'])) {
    // Periksa apakah jadwal dipilih
    if ($_POST['id_jadwal'] == "900") {
        echo "
            <script>
                alert('Jadwal tidak boleh kosong!');
            </script>    
        ";
        echo "<meta http-equiv='refresh' content='0'>";
        die();
    }

    // Panggil fungsi untuk mendaftar poli
    if (daftarPoli($_POST) > 0) {
        echo "
            <script>
                alert('Berhasil Mendaftar Poli!');
                window.location.href = '../PasienHome.php'; // Arahkan ke halaman home setelah berhasil
            </script>    
        ";
    } else {
        echo "
            <script>
                alert('Gagal Mendaftar Poli!');
                window.location.href = 'daftarPoli.php'; // Kembali ke halaman daftar poli
            </script>    
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard Pasien</title>
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
        <span class="d-none d-lg-block">Dashboard Pasien</span>
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
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="users-profile.html">
          <i class="bi bi-person"></i>
          <span>Daftar Poli</span>
        </a>
      </li><!-- End Profile Page Nav -->

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Daftar Poliklinik</h5>
                        <!-- Floating Labels Form -->
                        <form action="" method="POST" class="row g-3">
                            <div class="form-floating">
                                <input type="hidden" class="form-control" name="id_pasien" value="<?= $id_pasien?>">
                                <input type="text" class="form-control" name="no_rm" id="no_rm" value="<?= $no_rm?>">
                                <label for="no_rm">No. Rekam Medis</label>
                            </div>
                            <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="inputPoli">
                                <option>-- Pilih Poli --</option>
                                 <?php
                                $data= $pdo->prepare("SELECT* FROM poli");
                                $data->execute();
                                if ($data->rowCount() == 0){
                                    echo "<option>Tidak Ada Poli </option>";
                                }else{
                                    while($d = $data->fetch()){
                                ?>
                                <option value="<?= $d['id'] ?>"><?= $d['nama_poli'] ?></option>
                                <?php
                                    }
                                }
                                ?>
                                </select>
                                <label for="inputPoli">Pilih Poli</label>
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="inputJadwal" name="id_jadwal">
                                    <option>-- Pilih Jadwal --</option>
                                    <?php
                                $data= $pdo->prepare("SELECT* FROM jadwal_periksa");
                                $data->execute();
                                if ($data->rowCount() == 0){
                                    echo "<option>Tidak Ada Jadwal </option>";
                                }else{
                                    while($d = $data->fetch()){
                                ?>
                                <option value="<?= $d['id'] ?>"><?= $d['hari'] ?></option>
                                <?php
                                    }
                                }
                                ?>
                                </select>
                                <label for="inputJadwal">Pilih Jadwal</label>
                            </div>
                            </div>
                              <div class="form-floating">
                                <textarea class="form-control" name="keluhan" id="keluhan" style="height: 100px"></textarea>
                                <label for="Keluhan">Keluhan</label>
                              </div>
                            <div class="text-center">
                            <button type="submit" name="submit" class="btn btn-primary">Daftar</button>
                            </div>
                        </form><!-- End floating Labels Form -->
                </div>
            </div>
            <div class="card">
            <div class="card-body">
              <h5 class="card-title">Riwayat Pendaftaran Poli</h5>

              <!-- Default Table -->
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Poli</th>
                    <th scope="col">Dokter</th>
                    <th scope="col">Hari</th>
                    <th scope="col">Mulai</th>
                    <th scope="col">Selesai</th>
                    <th scope="col">Antrian</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $poli = $pdo->prepare("SELECT d.nama_poli as poli_nama,
                                                  c.nama as dokter_nama,
                                                  b.hari as jadwal_hari,
                                                  b.jam_mulai as jadwal_mulai,
                                                  b.jam_selesai as jadwal_selesai,
                                                  a.no_antrian as antrian,
                                                  a.id as poli_id
   
                                                  FROM daftar_poli as a

                                                  INNER JOIN jadwal_periksa as b
                                                  ON a.id_jadwal = b.id
                                                  INNER JOIN dokter as c
                                                  ON b.id_dokter = c.id
                                                  INNER JOIN poli as d
                                                  ON c.id_poli = d.id
                                                  WHERE a.id_pasien = $id_pasien
                                                  ORDER BY a.id desc");

                    $poli->execute();
                    $no = 0;
                    if ($poli->rowCount() == 0) {
                        echo "Tidak ada data";
                    } else {
                        while ($p = $poli->fetch()) {
                ?>
                <tr>
    <th scope="row">
         <?php
          ++$no; 
         if ($no == 1){
            echo "<span class='badge badge-info'>New</span>";
         }else {
            echo $no;
         }
         ?>
         </th>
    <td><?php echo $p['poli_nama']; ?></td>
    <td><?php echo $p['dokter_nama']; ?></td>
    <td><?php echo $p['jadwal_hari']; ?></td>
    <td><?php echo $p['jadwal_mulai']; ?></td>
    <td><?php echo $p['jadwal_selesai']; ?></td>
    <td><?php echo $p['antrian']; ?></td>
    <td>
        <a href="detail_poli.php/<?= $p['poli_id']?>">
            <button class="btn btn-success btn-sm">Detail</button>
        </a>
    </td>        
</tr>
<?php
    }
}
?>
                </tbody>
              </table>
              <!-- End Default Table Example -->
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