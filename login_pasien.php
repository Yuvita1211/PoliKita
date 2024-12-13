<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("koneksi.php");
// Inisialisasi pesan error
$err = "";
$username = "";
$password ="";


if (isset($_POST['submit'])) {
    // Pastikan koneksi PDO sudah diinisialisasi sebelumnya
    // Contoh:
    // $pdo = new PDO('mysql:host=localhost;dbname=nama_database', 'username', 'password');
    
    $username = stripslashes($_POST['nama']);
    $password = $_POST['alamat'];
    
    if ($username == 'admin') {
        if ($password == 'admin') {
            $_SESSION['login'] = true;
            $_SESSION['id'] = null;
            $_SESSION['username'] = 'admin';
            $_SESSION['akses'] = 'admin';
            echo "<meta http-equiv='refresh' content='0;url=../Projek_BK/adminhome.php'>";
            die();
        }
    } else {
        $cek_username = $pdo->prepare("SELECT * FROM pasien WHERE nama = '$username'; ");
        try {
           
            $cek_username->execute();
            if ($cek_username->rowCount() == 1) {
                $baris = $cek_username->fetchAll(PDO::FETCH_ASSOC);
                
                if ($password == $baris[0]['alamat']) {
                    $_SESSION['login'] = true;
                    $_SESSION['id'] = $baris[0]['id'];
                    $_SESSION['username'] = $baris[0]['nama'];
                    $_SESSION['no_rm'] = $baris[0]['no_rm'];
                    $_SESSION['akses'] = 'pasien';
                    echo "<meta http-equiv='refresh' content='0;url=../POLI_BK/PasienHome.php'>";
                    die();
                
                }
    }
} catch (PDOException $e) {
    $_SESSION['error'] = $e->getMessage();
    echo "<meta http-equiv='refresh' content='0;'>";
    die();
}
    }
   $_SESSION['error']= 'Username dan Password Tidak cocok';
   echo "<meta http-equiv='refresh' content='0;'>";
   die(); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

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
                    <h5 class="card-title text-center pb-0 fs-4">Login</h5>
                  </div>
                  <?php
                    if (isset($_SESSION['error'])) : 
                    ?>
   
                    <p> <?php echo $_SESSION['error'];
                    unset($_SESSION['error']); 
                    ?></p>
                    <?php endif; ?>

                  <form method="POST" action="" class="row g-3 needs-validation" novalidate>
                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Nama</label>
                      <div class="input-group has-validation">
                        <input type="text" name="nama" class="form-control" id="" required>
                        <div class="invalid-feedback">Masukkan Nama</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Alamat</label>
                      <input type="password" name="alamat" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Masukkan Alamat</div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit" name="submit" value="Login">Login</button>
                    </div>
                    <div class="col-12 text-center">
                      <p class="small mb-0">Belum punya akun? <a href="index.php?page=registerUser">Daftar</a></p>
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