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
  <title>Dashboard Siswa | SMP Negeri 4 Tangerang Selatan</title>
  <style>
    * {margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
    body {
      background: linear-gradient(135deg,#2196F3,#42A5F5);
      min-height:100vh;
      display:flex;flex-direction:column;color:#333;overflow-x:hidden;
    }
    header {
      background: rgba(255,255,255,0.15);
      backdrop-filter: blur(10px);
      color:#fff;display:flex;justify-content:space-between;align-items:center;
      padding:15px 40px;box-shadow:0 4px 10px rgba(0,0,0,0.2);
      position:sticky;top:0;z-index:10;
    }
    header a {
      text-decoration:none;color:#fff;background:rgba(255,255,255,0.2);
      padding:10px 20px;border-radius:8px;transition:.3s;
    }
    header a:hover {background:#fff;color:#1565C0;transform:scale(1.05);}
    .dashboard-container {
      width:90%;max-width:1200px;margin:40px auto;
      display:grid;grid-template-columns:300px 1fr;gap:30px;
    }
    .sidebar {
      background:#fff;border-radius:20px;padding:25px;
      box-shadow:0 6px 20px rgba(0,0,0,0.15);text-align:center;
    }
    .sidebar h3 {margin-top:10px;color:#1565C0;}
    .profile-info {margin-top:15px;text-align:left;line-height:1.8em;}
    .profile-info p strong {color:#1565C0;}
    .main {
      background:#fff;border-radius:20px;padding:30px;
      box-shadow:0 6px 20px rgba(0,0,0,0.15);
    }
    .main h2 {color:#1565C0;margin-bottom:15px;font-weight:600;}
    .card-container {
      display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
      gap:20px;margin-top:25px;
    }
    .card {
      background:#f6fbff;border-radius:15px;padding:20px;
      box-shadow:0 3px 10px rgba(0,0,0,0.1);transition:.3s;cursor:pointer;
    }
    .card:hover {transform:translateY(-5px);}
    .card h4 {color:#1565C0;margin-bottom:10px;}
    footer {
      text-align:center;padding:20px;color:#fff;font-size:.9em;
      margin-top:auto;background:rgba(0,0,0,0.15);
    }
    @media(max-width:900px){.dashboard-container{grid-template-columns:1fr;}}
    /* Modal */
    .modal{
      display:none;position:fixed;z-index:100;left:0;top:0;width:100%;height:100%;
      background:rgba(0,0,0,0.6);justify-content:center;align-items:center;
    }
    .modal-content{
      background:#fff;padding:25px;border-radius:15px;width:90%;max-width:420px;
      box-shadow:0 5px 20px rgba(0,0,0,0.3);
      animation:fadeIn .3s ease;
    }
    .modal-content h3{color:#1565C0;margin-bottom:15px;text-align:center;}
    select,textarea,button{
      width:100%;padding:10px;margin-top:10px;border-radius:8px;border:1px solid #ccc;
    }
    button.submit-btn{
      background:#2196F3;color:#fff;font-weight:bold;border:none;cursor:pointer;
      transition:0.3s;
    }
    button.submit-btn:hover{background:#1976D2;}
    /* Rating */
    .rating {
      display: flex;
      flex-direction: row-reverse;
      justify-content: center;
      margin: 10px 0;
    }
    .rating input {display:none;}
    .rating label {
      font-size: 30px;
      color: #ccc;
      cursor: pointer;
      transition: 0.3s;
    }
    .rating input:checked ~ label,
    .rating label:hover,
    .rating label:hover ~ label {
      color: #FFD700;
    }
  </style>
</head>

<body>
  <header>
    <h2>SMP Negeri 4 Tangerang Selatan</h2>
    <a href="../../action/logout.php">Logout</a>
  </header>

  <div class="dashboard-container">
    <div class="sidebar">
      <img src="https://cdn-icons-png.flaticon.com/512/1946/1946429.png" width="100" height="100" alt="Profile">
      <h3><?php echo $_SESSION['nama_siswa']; ?></h3>
      <div class="profile-info">
        <p><strong>NIS:</strong> <?php echo $_SESSION['nis']; ?></p>
        <p><strong>Kelas:</strong> <?php echo $_SESSION['id_kelas']; ?></p>
        <p><strong>Alamat:</strong> <?php echo $_SESSION['alamat']; ?></p>
      </div>
    </div>

    <div class="main">
      <h2>Selamat Datang 👋</h2>
      <p>Halo <strong><?php echo $_SESSION['nama_siswa']; ?></strong>!  
        Selamat datang di portal penilaian guru SMP Negeri 4 Tangerang Selatan.</p>

      <div class="card-container">
        <div class="card">
          <h4>📢 Pengumuman</h4>
          <p>Ujian Tengah Semester dimulai pada <strong>5 November 2025</strong>.</p>
        </div>
        <div class="card">
          <h4>📊 Penilaian Guru</h4>
          <p>Beri penilaian dan saran untuk guru Anda.</p>
          <button style="margin-top:10px;background:#2196F3;color:#fff;border:none;padding:8px 15px;border-radius:6px;cursor:pointer;" onclick="openModal()">Isi Penilaian</button>
        </div>
      </div>
    </div>
  </div>

 <!-- Modal Penilaian -->
<div id="penilaianModal" class="modal">
  <div class="modal-content">
    <h3>🧑‍🏫 Form Penilaian Guru</h3>
    <form action="../../action/penilaian_guru.php" method="POST">
      <label>Pilih Guru</label>
      <select name="id_guru" required>
        <option value="">-- Pilih Guru --</option>
        <?php
        $guru = mysqli_query($conn, "SELECT * FROM guru");
        while($g = mysqli_fetch_assoc($guru)){
          echo "<option value='".$g['id_guru']."'>".$g['nama_guru']."</option>";
        }
        ?>
      </select>

      <label>Kedisiplinan</label>
      <div class="rating">
        <input type="radio" name="nilai_kedisiplinan" id="kedis1" value="20" required><label for="kedis1">★</label>
        <input type="radio" name="nilai_kedisiplinan" id="kedis2" value="40"><label for="kedis2">★</label>
        <input type="radio" name="nilai_kedisiplinan" id="kedis3" value="60"><label for="kedis3">★</label>
        <input type="radio" name="nilai_kedisiplinan" id="kedis4" value="80"><label for="kedis4">★</label>
        <input type="radio" name="nilai_kedisiplinan" id="kedis5" value="100"><label for="kedis5">★</label>
      </div>

      <label>Penguasaan Materi</label>
      <div class="rating">
        <input type="radio" name="nilai_penguasaan_materi" id="materi1" value="20" required><label for="materi1">★</label>
        <input type="radio" name="nilai_penguasaan_materi" id="materi2" value="40"><label for="materi2">★</label>
        <input type="radio" name="nilai_penguasaan_materi" id="materi3" value="60"><label for="materi3">★</label>
        <input type="radio" name="nilai_penguasaan_materi" id="materi4" value="80"><label for="materi4">★</label>
        <input type="radio" name="nilai_penguasaan_materi" id="materi5" value="100"><label for="materi5">★</label>
      </div>

      <label>Interaksi dengan Siswa</label>
      <div class="rating">
        <input type="radio" name="nilai_interaksi" id="inter1" value="20" required><label for="inter1">★</label>
        <input type="radio" name="nilai_interaksi" id="inter2" value="40"><label for="inter2">★</label>
        <input type="radio" name="nilai_interaksi" id="inter3" value="60"><label for="inter3">★</label>
        <input type="radio" name="nilai_interaksi" id="inter4" value="80"><label for="inter4">★</label>
        <input type="radio" name="nilai_interaksi" id="inter5" value="100"><label for="inter5">★</label>
      </div>

      <label>Komentar / Saran</label>
      <textarea name="komentar" placeholder="Tulis komentar Anda..." required></textarea>

      <button type="submit" class="submit-btn">Kirim Penilaian</button>
      <button type="button" class="submit-btn" style="background:#dc3545;margin-top:10px;" onclick="closeModal()">Batal</button>
    </form>
  </div>
</div>

  <footer>
    &copy; <?php echo date('Y'); ?> SMP Negeri 4 Tangerang Selatan | Portal Penilaian Guru
  </footer>

  <script>
    function openModal(){document.getElementById('penilaianModal').style.display='flex';}
    function closeModal(){document.getElementById('penilaianModal').style.display='none';}
    window.onclick=function(e){if(e.target==document.getElementById('penilaianModal'))closeModal();}
  </script>
</body>
</html>

<?php 
} else { 
  echo "<script>document.location='../../index.php'</script>";
}
?>
