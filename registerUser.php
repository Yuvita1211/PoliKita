<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_ktp = $_POST['no_ktp']; 
    $no_hp = $_POST['no_hp'];

    //cek apakah pasien sudah terdaftar berdasarkan no ktp
    $query_check_pasien = "SELECT id, nama, no_rm FROM pasien WHERE no_ktp = '$no_ktp'";
    $result_check_pasien = mysqli_query($mysqli, $query_check_pasien);

    if (mysqli_num_rows($result_check_pasien) > 0) {
        $row = mysqli_fetch_assoc($result_check_pasien);

        if ($row['nama'] != $nama) {
            // ketika nama tidak sesuai dengan no_ktp
            echo "<script>alert('Nama pasien tidak sesuai dengan nomor KTP yang terdaftar.');</script>";
            echo "<meta http-equiv='refresh' content='0; url=../POLI_BK/registerUser.php'>";
            die();
    }
    $_SESSION['signup'] = true;
    $_SESSION['id'] = $row['id'];
    $_SESSION['username'] = $nama;
    $_SESSION['no_rm'] = $row['no_rm'];
    $_SESSION['akses'] = 'pasien';

    echo "<meta http-equiv='refresh' content='0; url=../Projek_BK/pasienhome.php'>";
    die();
}

    // Query untuk mendapatkan nomor pasien terakhir - YYYYMM-XXX -- 202312-004
    $queryGetRm = "SELECT MAX(SUBSTRING(no_rm, 8)) as last_queue_number FROM pasien";
    $resultRm = mysqli_query($mysqli, $queryGetRm);

    // Periksa hasil query
    if (!$resultRm) {
    die("Query gagal: " . mysqli_error($mysqli));
    }

    // Ambil nomor antrian terakhir dari hasil query
    $rowRm = mysqli_fetch_assoc($resultRm);
    $lastQueueNumber = $rowRm['last_queue_number'];

    // Jika tabel kosong, atur nomor antrian menjadi 0
    $lastQueueNumber = $lastQueueNumber ? $lastQueueNumber : 0;

    // Mendapatkan tahun saat ini (misalnya, 202312)
    $tahun_bulan = date("Ym");

    // Membuat nomor antrian baru dengan menambahkan 1 pada nomor antrian terakhir
    $newQueueNumber = $lastQueueNumber + 1;

    // Menyusun nomor rekam medis dengan format YYYYMM-XXX
    $no_rm = $tahun_bulan . "-" . str_pad ($newQueueNumber, 3, '0', STR_PAD_LEFT);

    //insert
    $query = "INSERT INTO pasien (nama, alamat, no_ktp, no_hp, no_rm) VALUES ('$nama', '$alamat', '$no_ktp', '$no_hp','$no_rm')";

    //eksekusi query
    if (mysqli_query($mysqli, $query)){
        //set session variables
        $_SESSION['signup']= true; //langsung ke dashboard
        $_SESSION['id']= mysqli_insert_id($mysqli);
        $_SESSION['nama']= $nama;
        $_SESSION['no_rm']= $no_rm;
        $_SESSION['akses']= 'pasien';

        //redirect ke dashboard
        echo "<meta http-equiv='refresh' content='0; url=../POLI_BK/PasienHome.php'>";
        die();
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($mysqli); 
    }


}
?>
 
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Registrasi Pasien</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="img/udinud.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="premysqliect">
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
<?php include_once("koneksi.php"); ?>
  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
              <div class="card mb-3">

                <div class="card-body">
                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Registrasi</h5>
                  </div>
                  <?php if (isset($_SESSION['error'])) :?>
                    <p> <?php echo $_SESSION['error'];
                    unset($_SESSION['error']); 
                    ?></p>
                    <?php endif; ?>
                  <form method="POST" action="" class="row g-3 needs-validation" novalidate>
                    <div class="col-12">
                      <label for="yourName" class="form-label">Nama</label>
                      <input type="text" name="nama" class="form-control" required>
                      <div class="invalid-feedback">Masukkan Nama</div>
                    </div>

                    <div class="col-12">
                      <label for="yourEmail" class="form-label">Alamat</label>
                      <input type="text" name="alamat" class="form-control" required>
                      <div class="invalid-feedback">Masukkan Alamat</div>
                    </div>

                    <div class="col-12">
                      <label for="yourEmail" class="form-label">No. KTP</label>
                      <input type="number" name="no_ktp" class="form-control" required>
                      <div class="invalid-feedback">Masukkan No. KTP</div>
                    </div>

                    <div class="col-12">
                      <label for="yourEmail" class="form-label">No. Handphone</label>
                      <input type="number" name="no_hp" class="form-control" required>
                      <div class="invalid-feedback">Masukkan No. HP</div>
                    </div>

                    <!--<div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" required>
                      <div class="invalid-feedback">Masukkan Password</div>
                    </div>-->
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit" name="submit">Daftar</button>
                    </div>
                    <div class="col-12 text-center">
                      <p class="small mb-0">Sudah punya akun? <a href="index.php?page=login_pasien">Masuk</a></p>
                    </div>
                  </form>

                </div>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

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
  <script src="assets/js/main.js"></script>

</body>

</html>