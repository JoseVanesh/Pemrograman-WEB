<?php
session_start();
include "../database/config.php";

$username = $_POST['username'];
$password = $_POST['password'];

$query = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username' AND password='$password'");
$cek = mysqli_num_rows($query);

if ($cek > 0) {
    $row = mysqli_fetch_assoc($query);
    $_SESSION['id_admin'] = $row['id_admin'];
    $_SESSION['nama_admin'] = $row['nama_admin'];
    $_SESSION['login'] = 'admin';
    header("location: ../page/admin/index.php");
} else {
    $_SESSION['notif'] = "<div class='notif-danger-a'>Username atau Password salah!</div>";
    echo "<script>document.location='../index.php'</script>";
}
?>
