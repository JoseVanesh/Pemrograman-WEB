<?php
session_start();
include "../database/config.php";

if($_SESSION['login'] == 'siswa'){
  $nis = $_SESSION['nis'];
  $id_guru = $_POST['id_guru'];
  $nilai_kedisiplinan = $_POST['nilai_kedisiplinan'];
  $nilai_penguasaan_materi = $_POST['nilai_penguasaan_materi'];
  $nilai_interaksi = $_POST['nilai_interaksi'];
  $komentar = $_POST['komentar'];

  $query = "INSERT INTO penilaian_guru 
            (nis, id_guru, nilai_kedisiplinan, nilai_penguasaan_materi, nilai_interaksi, komentar)
            VALUES 
            ('$nis', '$id_guru', '$nilai_kedisiplinan', '$nilai_penguasaan_materi', '$nilai_interaksi', '$komentar')";

  if (mysqli_query($conn, $query)) {
    $_SESSION['notif'] = "<div class='notif-success'>Penilaian berhasil dikirim!</div>";
    header("Location: ../page/siswa/index.php");
  } else {
    $_SESSION['notif'] = "<div class='notif-danger-a'>Terjadi kesalahan saat menyimpan data.</div>";
    header("Location: ../page/siswa/penilaian.php");
  }
} else {
  header("Location: ../index.php");
}
?>
