<?php
session_start();
include "../../database/config.php";

if($_SESSION && $_SESSION['login'] == 'siswa') {
    $id_siswa = $_SESSION['id_siswa'];
    $id_guru = $_POST['id_guru'];
    $kedisiplinan = $_POST['nilai_kedisiplinan'];
    $materi = $_POST['nilai_penguasaan_materi'];
    $interaksi = $_POST['nilai_interaksi'];
    $komentar = $_POST['komentar'];

    $query = "INSERT INTO penilaian_guru 
        (id_siswa, id_guru, nilai_kedisiplinan, nilai_penguasaan_materi, nilai_interaksi, komentar) 
        VALUES 
        ('$id_siswa', '$id_guru', '$kedisiplinan', '$materi', '$interaksi', '$komentar')";
    
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Penilaian berhasil dikirim!');document.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal mengirim penilaian!');document.location='penilaian.php';</script>";
    }
} else {
    echo "<script>document.location='../../index.php'</script>";
}
?>
