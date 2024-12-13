<?php 
$databaseHost = 'localhost';
$databaseName = 'poliklinikbk';
$databaseUsername = 'root';
$databasePassword = '';
 
    try {
    // Koneksi PDO
    $pdo = new PDO("mysql:host=$databaseHost;dbname=$databaseName", $databaseUsername, $databasePassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("PDO connection failed: " . $e->getMessage());
}

$mysqli = mysqli_connect($databaseHost, 
    $databaseUsername, $databasePassword, $databaseName);

if (!$mysqli){
    die("Connection failed: " . mysqli_connect_error());
}else {

}

function query($query)
{
    global $mysqli;
    $result = mysqli_query($mysqli, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

function ubahDokter($data)
{
    global $mysqli;

    $id = $data["id"];
    $nama = mysqli_real_escape_string($mysqli, $data["nama"]);
    $alamat = mysqli_real_escape_string($mysqli, $data["alamat"]);
    $no_hp = mysqli_real_escape_string($mysqli, $data["no_hp"]);

    $query = "UPDATE dokter SET nama = '$nama', alamat = '$alamat', no_hp = '$no_hp' WHERE id = $id ";

    if (mysqli_query($mysqli, $query)) {
        return mysqli_affected_rows($mysqli); // Return the number of affected rows
    } else {
        // Handle the error
        echo "Error updating record: " . mysqli_error($mysqli);
        return -1; // Or any other error indicator
    }
}

function tambahJadwalPeriksa($data)
{
    try {
        global $mysqli;

        $id_dokter = $data["id_dokter"];
        $hari = mysqli_real_escape_string($mysqli, $data["hari"]);
        $jam_mulai = mysqli_real_escape_string($mysqli, $data["jam_mulai"]);
        $jam_selesai = mysqli_real_escape_string($mysqli, $data["jam_selesai"]);
        $status = mysqli_real_escape_string($mysqli, $data["status"]);

        $query = "INSERT INTO jadwal_periksa VALUES ('', '$id_dokter', '$hari', '$jam_mulai', '$jam_selesai', '$status')";

        if (mysqli_query($mysqli, $query)) {
            return mysqli_affected_rows($mysqli); // Return the number of affected rows
        } else {
            // Handle the error
            echo "Error updating record: " . mysqli_error($mysqli);
            return -1; // Or any other error indicator
        }
    } catch (\Exception $e) {
        var_dump($e->getMessage());
    }
}

function updateJadwalPeriksa($data, $id)
{
    try {
        global $mysqli;

        // $hari = mysqli_real_escape_string($mysqli, $data["hari"]);
        // $jam_mulai = mysqli_real_escape_string($mysqli, $data["jam_mulai"]);
        // $jam_selesai = mysqli_real_escape_string($mysqli, $data["jam_selesai"]);
        $status = mysqli_real_escape_string($mysqli, $data["status"]);

        // $query = "UPDATE jadwal_periksa SET hari = '$hari', jam_mulai = '$jam_mulai', jam_selesai = '$jam_selesai', status = '$status' WHERE id = $id ";
        $query = "UPDATE jadwal_periksa SET status = '$status' WHERE id = $id ";

        if (mysqli_query($mysqli, $query)) {
            return mysqli_affected_rows($mysqli); // Return the number of affected rows
        } else {
            // Handle the error
            echo "Error updating record: " . mysqli_error($mysqli);
            return -1; // Or any other error indicator
        }
    } catch (\Exception $e) {
        var_dump($e->getMessage());
        die();
    }
}

function hapusJadwalPeriksa($id)
{
    try {
        global $mysqli;

        $query = "DELETE FROM jadwal_periksa WHERE id = $id";

        if (mysqli_query($mysqli, $query)) {
            return mysqli_affected_rows($mysqli); // Return the number of affected rows
        } else {
            // Handle the error
            echo "Error updating record: " . mysqli_error($mysqli);
            return -1; // Or any other error indicator
        }
    } catch (\Exception $e) {
        var_dump($e->getMessage());
    }
}

function TambahPeriksa($data)

{
    global $mysqli;
     // ambil data dari tiap elemen dalam form
     $tgl_periksa = htmlspecialchars($data["tgl_periksa"]);
     $catatan = htmlspecialchars($data["catatan"]);
     

    // query insert data
    $query = "INSERT INTO periksa
                VALUES
                ('', '$tgl_periksa','$catatan');
            ";

    mysqli_query($mysqli, $query);

    return mysqli_affected_rows($mysqli);
}

function TambahDetailPeriksa($data){
    global $mysqli;
     // ambil data dari tiap elemen dalam form
     $tgl_periksa = htmlspecialchars($data["tgl_periksa"]);
     $catatan = htmlspecialchars($data["catatan"]);
     

      // query insert data
    $query = "INSERT INTO detail_periksa
                VALUES
                ('', '$tgl_periksa','$catatan');
            ";

    mysqli_query($mysqli, $query);

    return mysqli_affected_rows($mysqli);
}

function daftarPoli($data)
{
    global $pdo;

    try {
        $id_pasien = $data["id_pasien"];
        $id_jadwal = $data["id_jadwal"];
        $keluhan = $data["keluhan"];
        $no_antrian = getLatestNoAntrian($id_jadwal, $pdo) + 1;
        $status_periksa = 0;

        $query = "INSERT INTO daftar_poli VALUES (NULL, :id_pasien, :id_jadwal, :keluhan, :no_antrian, :status_periksa)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_pasien', $id_pasien);
        $stmt->bindParam(':id_jadwal', $id_jadwal);
        $stmt->bindParam(':keluhan', $keluhan);
        $stmt->bindParam(':no_antrian', $no_antrian);
        $stmt->bindParam(':status_periksa', $status_periksa);


        if ($stmt->execute()) {
            return $stmt->rowCount(); // Return the number of affected rows
        } else {
            // Handle the error
            echo "Error updating record: " . $stmt->errorInfo()[2];
            return -1; // Or any other error indicator
        }
    } catch (\Exception $e) {
        var_dump($e->getMessage());
    }
}

function getLatestNoAntrian($id_jadwal, $pdo)
{
    // Ambil nomor antrian terbaru untuk jadwal tertentu
    $latestNoAntrian = $pdo->prepare("SELECT MAX(no_antrian) as max_no_antrian FROM daftar_poli WHERE id_jadwal = :id_jadwal");
    $latestNoAntrian->bindParam(':id_jadwal', $id_jadwal);
    $latestNoAntrian->execute();

    $row = $latestNoAntrian->fetch();
    return $row['max_no_antrian'] ? $row['max_no_antrian'] : 0;
}
?>