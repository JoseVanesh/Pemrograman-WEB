<?php
session_start();
include "../database/config.php";

$nis = mysqli_real_escape_string($conn, $_POST['nis']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

$query = mysqli_query($conn, "SELECT * FROM siswa WHERE nis='$nis' AND password='$password'");
$cek = mysqli_num_rows($query);

if ($cek > 0) {
    $row = mysqli_fetch_assoc($query);
    $_SESSION['nis'] = $row['nis'];
    $_SESSION['nama_siswa'] = $row['nama_siswa'];
    $_SESSION['alamat'] = $row['alamat'];
    $_SESSION['id_kelas'] = $row['id_kelas'];
    $_SESSION['login'] = 'siswa';

    header("location: ../page/siswa/index.php");
} else {
    $_SESSION['notif'] = "<div class='notif-danger-a'>NIS/Password Salah</div>";
    echo "<script>document.location = '../index.php';</script>";
}
?>
