<?php
session_start();
if($_SESSION && $_SESSION['login'] == 'siswa'){ 
include "../../database/config.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Penilaian Guru | SMPN 4 Tangsel</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #2196F3, #64B5F6);
      color: #333;
      margin: 0;
      padding: 0;
    }

    .container {
      width: 90%;
      max-width: 800px;
      margin: 50px auto;
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.15);
      padding: 30px 40px;
      animation: fadeIn 0.8s ease-in-out;
    }

    h2 {
      color: #1565C0;
      text-align: center;
      margin-bottom: 25px;
    }

    label {
      display: block;
      margin-top: 20px;
      font-weight: 600;
    }

    textarea {
      width: 100%;
      padding: 10px;
      border-radius: 8px;
      border: 1px solid #ccc;
      margin-top: 8px;
      font-size: 15px;
      resize: none;
      height: 100px;
    }

    .rating {
      display: flex;
      flex-direction: row-reverse;
      justify-content: flex-start;
      gap: 5px;
      margin-top: 5px;
    }

    .rating input {
      display: none;
    }

    .rating label {
      font-size: 28px;
      color: #ccc;
      cursor: pointer;
      transition: 0.3s;
    }

    .rating input:checked ~ label,
    .rating label:hover,
    .rating label:hover ~ label {
      color: #FFD700;
    }

    button {
      background: #2196F3;
      color: #fff;
      border: none;
      padding: 12px 20px;
      border-radius: 10px;
      margin-top: 25px;
      font-size: 16px;
      transition: 0.3s;
      cursor: pointer;
      width: 100%;
    }

    button:hover {
      background: #1976D2;
      transform: translateY(-2px);
    }

    a.back {
      display: inline-block;
      margin-top: 15px;
      color: #1565C0;
      text-decoration: none;
      font-weight: 500;
    }

    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(20px);}
      to {opacity: 1; transform: translateY(0);}
    }
  </style>
</head>

<body>
  <div class="container">
    <h2>🧑‍🏫 Penilaian Guru</h2>
    <form action="../../action/penilaian_guru.php" method="post">
      <label for="guru">Pilih Guru:</label>
      <select name="id_guru" required>
        <option value="">-- Pilih Guru --</option>
        <?php
        $guru = mysqli_query($conn, "SELECT * FROM guru");
        while($g = mysqli_fetch_assoc($guru)){
          echo "<option value='".$g['id_guru']."'>".$g['nama_guru']."</option>";
        }
        ?>
      </select>

      <!-- Rating Kedisiplinan -->
      <label>Kedisiplinan:</label>
      <div class="rating">
        <input type="radio" name="nilai_kedisiplinan" id="kedis1" value="20" required><label for="kedis1">★</label>
        <input type="radio" name="nilai_kedisiplinan" id="kedis2" value="40"><label for="kedis2">★</label>
        <input type="radio" name="nilai_kedisiplinan" id="kedis3" value="60"><label for="kedis3">★</label>
        <input type="radio" name="nilai_kedisiplinan" id="kedis4" value="80"><label for="kedis4">★</label>
        <input type="radio" name="nilai_kedisiplinan" id="kedis5" value="100"><label for="kedis5">★</label>
      </div>

      <!-- Rating Penguasaan Materi -->
      <label>Penguasaan Materi:</label>
      <div class="rating">
        <input type="radio" name="nilai_penguasaan_materi" id="materi1" value="20" required><label for="materi1">★</label>
        <input type="radio" name="nilai_penguasaan_materi" id="materi2" value="40"><label for="materi2">★</label>
        <input type="radio" name="nilai_penguasaan_materi" id="materi3" value="60"><label for="materi3">★</label>
        <input type="radio" name="nilai_penguasaan_materi" id="materi4" value="80"><label for="materi4">★</label>
        <input type="radio" name="nilai_penguasaan_materi" id="materi5" value="100"><label for="materi5">★</label>
      </div>

      <!-- Rating Interaksi -->
      <label>Interaksi dengan Siswa:</label>
      <div class="rating">
        <input type="radio" name="nilai_interaksi" id="inter1" value="20" required><label for="inter1">★</label>
        <input type="radio" name="nilai_interaksi" id="inter2" value="40"><label for="inter2">★</label>
        <input type="radio" name="nilai_interaksi" id="inter3" value="60"><label for="inter3">★</label>
        <input type="radio" name="nilai_interaksi" id="inter4" value="80"><label for="inter4">★</label>
        <input type="radio" name="nilai_interaksi" id="inter5" value="100"><label for="inter5">★</label>
      </div>

      <label>Komentar / Saran:</label>
      <textarea name="komentar" placeholder="Tulis pendapat atau saran Anda..."></textarea>

      <button type="submit">Kirim Penilaian</button>
    </form>

    <a href="index.php" class="back">⬅ Kembali ke Dashboard</a>
  </div>
</body>
</html>

<?php 
} else {
  echo "<script>document.location='../../index.php'</script>";
}
?>
