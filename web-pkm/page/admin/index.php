<?php
session_start();
if($_SESSION && $_SESSION['login'] == 'admin'){ 
include "../../database/config.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Penilaian Guru | SMP Negeri 4 Tangerang Selatan</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f2f6fc;
      margin: 0;
      padding: 30px;
      color: #333;
    }

    h2 {
      color: #1565C0;
      text-align: center;
      margin-bottom: 25px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    }

    th, td {
      padding: 14px 16px;
      text-align: center;
    }

    th {
      background: #1565C0;
      color: #fff;
      text-transform: uppercase;
      font-size: 0.9em;
      letter-spacing: 0.5px;
    }

    tr:nth-child(even) {
      background: #f8fbff;
    }

    tr:hover {
      background-color: #eaf2ff;
      transition: 0.2s;
    }

    .stars {
      color: #FFD700;
      font-size: 18px;
    }

    td textarea {
      border: none;
      background: #f5f5f5;
      border-radius: 8px;
      padding: 6px 10px;
      resize: none;
      font-family: inherit;
    }

    footer {
      text-align: center;
      color: #555;
      margin-top: 30px;
      font-size: 0.9em;
    }
  </style>
</head>

<body>
  <h2>📊 Data Penilaian Guru oleh Siswa</h2>
  <table>
    <tr>
      <th>No</th>
      <th>Nama Siswa</th>
      <th>Guru Dinilai</th>
      <th>Rating</th>
      <th>Komentar</th>
      <th>Tanggal</th>
    </tr>
    <?php
    $no = 1;
    $result = mysqli_query($conn, "
      SELECT p.*, s.nama_siswa, g.nama_guru
      FROM penilaian_guru p
      JOIN siswa s ON p.nis = s.nis
      JOIN guru g ON p.id_guru = g.id_guru
      ORDER BY p.tanggal DESC
    ");

    while($row = mysqli_fetch_assoc($result)){
      // Hitung rata-rata rating dari ketiga aspek
      $avg = round(($row['nilai_kedisiplinan'] + $row['nilai_penguasaan_materi'] + $row['nilai_interaksi']) / 3);
      $stars = str_repeat("⭐", round($avg / 20)); // konversi ke 5 bintang

      echo "
      <tr>
        <td>{$no}</td>
        <td>{$row['nama_siswa']}</td>
        <td>{$row['nama_guru']}</td>
        <td class='stars'>{$stars}</td>
        <td><textarea readonly>{$row['komentar']}</textarea></td>
        <td>{$row['tanggal']}</td>
      </tr>";
      $no++;
    }
    ?>
  </table>

  <footer>
    © 2025 SMP Negeri 4 Tangerang Selatan | Sistem Informasi Penilaian Guru
  </footer>
</body>
</html>

<?php 
} else { 
  echo "<script>document.location='../../index.php'</script>";
}
?>
