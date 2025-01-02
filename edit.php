<?php
include("koneksi.php");
session_start();

if (isset($_SESSION['login'])) {
    $_SESSION['login'] = true;
} else {
    echo "<meta http-equiv='refresh' content='0; url=loginUser.php'>";
    die();
}

$nama = $_SESSION['username'];
$akses = $_SESSION['akses'];
$id_dokter = $_SESSION['id'];

if ($akses != 'dokter') {
    echo "<meta http-equiv='refresh' content='0; url=..'>";
    die();
}

$url = $_SERVER['REQUEST_URI'];
$url = explode("/", $url);
$id = $url[count($url) - 1];

$pasiens = query("SELECT
                          pasien.id AS id_pasien,
                          periksa.biaya_periksa AS biaya_periksa,
                          pasien.nama AS nama_pasien,
                          periksa.catatan AS catatan,
                          periksa.tgl_periksa AS tgl_periksa,
                          daftar_poli.id AS id_daftar_poli,
                          daftar_poli.no_antrian AS no_antrian,
                          daftar_poli.keluhan AS keluhan,
                          daftar_poli.status_periksa AS status_periksa
                        FROM pasien
                        INNER JOIN daftar_poli ON pasien.id = daftar_poli.id_pasien
                        INNER JOIN periksa ON daftar_poli.id = periksa.id_daftar_poli
                        WHERE periksa.id = '$id'")[0];

$obat = query("SELECT * FROM obat");

$selected_obat = [];
$detail_periksa = query("SELECT * FROM detail_periksa WHERE id_periksa='" . $id . "'");
foreach ($detail_periksa as $dp) {
  $selected_obat[] = $dp['id_obat'];
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
    </div><!-- End Logo -->
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
            <span class="d-none d-md-block dropdown-toggle ps-2"></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?= $dokter["nama"]; ?></h6>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="profil.php">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
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
        <a class="nav-link " href="DokterHome.php">
          <i class="bi bi-grid"></i>
          <span>Home</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="index_jadwal.php">
          <i class="ri-draft-line"></i>
          <span>Jadwal Periksa</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="DokterPeriksa.php">
          <i class="bi bi-person"></i>
          <span>Pasien</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="riwayat_pasien.php">
          <i class="bi bi-person"></i>
          <span>Riwayat Pasien</span>
        </a>
      </li>

    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="DokterHome.php">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div>
            <div class="container-fluid py-2" style="background-color:#FFF5E4;">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h3>Periksa Pasien</h3>
                        </div>
                        <div class="mx-auto">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Memeriksa pasien</h3>
                                </div>
                                <div class="card-body">
                                    <form action="" method="POST">
                                        <div class="form-group">
                                            <input type="hidden" name="id_dokter" value="<?=$pasiens["id"]?>">
                                            <label for="nama_pasien">Nama Pasien</label>
                                            <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" value="<?= $$pasiens["nama_pasien"]?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="tgl_periksa">Tanggal Periksa</label>
                                            <input type="datetime-local" class="form-control" id="tgl_periksa" name="tgl_periksa">
                                        </div>
                                        <div class="form-group">
                                            <label for="catatan">Catatan</label>
                                            <input type="text" class="form-control" id="catatan" name="catatan">
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_pasien">Obat</label>
                                            <select class="form-control" name="obat[]" multiple id="id_obat">
                                                <?php foreach ($obat as $obats) : ?>
                                                        <option value="<?= $obats['id']; ?>|<?= $obats['harga'] ?>"><?= $obats['nama_obat']; ?> - <?= $obats['kemasan']; ?> - Rp.<?= $obats['harga']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="total_harga">Total Harga</label>
                                            <input type="text" class="form-control" id="harga" name="harga" readonly value="<?= $pasiens["biaya_periksa"] ?>>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn btn-success" id="simpan_periksa" name="simpan_periksa">Save</button>
                                        </div>
                                    </form>
                                    <?php
                                                        if (isset($_POST['simpan_periksa'])) {
                                                        $biaya_periksa = 150000;
                                                        $total_biaya_obat = 0;
                                                        $obat = isset($_POST['obat']) ? $_POST['obat'] : [];
                                                        $tgl_periksa = $_POST['tgl_periksa'];
                                                        $catatan = $_POST['catatan'];
                                                        $id_obat = [];
                                                        for ($i = 0; $i < count($obat); $i++) {
                                                            $data_obat = explode("|", $obat[$i]);
                                                            // var_dump($data_obat);
                                                            $id_obat[] = $data_obat[0];
                                                            $total_biaya_obat += $data_obat[1];
                                                        }
                                                        $total_biaya = $biaya_periksa + $total_biaya_obat;
                                                        // var_dump($total_biaya);
                                                        // die();

                                                        $id_daftar_poli = $pasiens['id_daftar_poli'];
                                                        $query = "UPDATE periksa SET
                                                                        tgl_periksa = '$tgl_periksa',
                                                                        catatan = '$catatan',
                                                                        biaya_periksa = '$total_biaya'
                                                                    WHERE id_daftar_poli = $id_daftar_poli";
                                                        $query2 = "DELETE FROM detail_periksa WHERE id_periksa = $id";
                                                        $query3 = "INSERT INTO detail_periksa (id_obat, id_periksa) VALUES ";

                                                        if (count($id_obat) > 0) {
                                                            for ($i = 0; $i < count($id_obat); $i++) {
                                                                $query3 .= "($id_obat[$i], $id),";
                                                            }
                                                            $query3 = substr($query3, 0, -1);

                                                            $result3 = mysqli_query($conn, $query3);
                                                        } else {
                                                            $result3 = true; // tidak ada obat untuk dimasukkan, jadi anggap berhasil
                                                        }

                                                        $result = mysqli_query($conn, $query);
                                                        $result2 = mysqli_query($conn, $query2);

                                                        if ($result && $result2 && $result3) {
                                                            echo "
                                                            <script>
                                                                alert('Data berhasil diubah');
                                                                document.location.href = '../ ';
                                                            </script>
                                                            ";
                                                        } else {
                                                            echo "
                                                            <script>
                                                                alert('Data gagal diubah');
                                                                alert('$query');
                                                                document.location.href = '../edit.php/$id';
                                                            </script>
                                                            ";
                                                        }
                                                        }
                                                        ?>

  </div>
</div>
<script>
    $(document).ready(function() {
        $('#id_obat').select2();
        $('#id_obat').on('change.select2', function (e) {
            var selectedValuesArray = $(this).val();
            
            // Calculate the sum
            var sum = 150000;
            if (selectedValuesArray) {
                for (var i = 0; i < selectedValuesArray.length; i++) {
                    // Split the value and get the second part after "|"
                    var parts = selectedValuesArray[i].split("|");
                    console.log(parts);
                    if (parts.length === 2) {
                    sum += parseFloat(parts[1]);
                    }
                }
            }
            
            $('#harga').val(sum); 
        });
    });
</script>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

  </main><!-- End #main -->

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