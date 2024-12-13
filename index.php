<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>POLIKLINIK KITA</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="img/udinus.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="style.css" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container-fluid">
    <header id="header" class="fixed-top header-transparent ">
     <div class="container d-flex align-items-center justify-content-between">
      <div class="logo">
        <h1><a href="index.php">POLIKITA</a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
      </div>
       <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="index.php">Beranda</a></li>
        </ul>
        <?php
                if(!isset($_SESSION)) 
                { 
                    session_start(); 
                } 
                if (isset($_SESSION['username'])) {
                    // Jika user relah login, tampil "Logout"
                ?>
                    <ul class="navbar-nav ms-auto">
                        <li><a class="getstarted scrollto" href="index.php?page=logout">Keluar</a></li>
                    </ul>
                <?php
                } else {
                    // Jika pengguna belum login, tampilkan tombol "Login" dan "Register"
                ?>
                    <ul class="navbar-nav ms-auto">
                        <li><a class="getstarted scrollto" href="index.php?page=registerUser">Login Pasien</a></li>
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        <li><a class="getstarted scrollto" href="index.php?page=loginUser">Login Dokter</a></li>
                    </ul>
                <?php
                }
                ?>
      </nav>
      </div>
        </header>
    </div>
        
</body>
</html>
<main role="main" class="container-fluid">
    <?php
        if (isset($_GET['page'])) {
    ?>
        <!-- <h2><?php echo ucwords($_GET['page']) ?></h2> -->
    <?php
        include($_GET['page'] . ".php");
    } else {
        include("beranda.php");
    }
    ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>