<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portal Penilaian | SMP Negeri 4 Tangerang Selatan</title>
  <link rel="icon" href="assets/icon/favicon.png">
  <style>
    /* RESET */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: linear-gradient(135deg, #90CAF9, #1E88E5);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: flex-start;
      color: #333;
    }

    header {
      text-align: center;
      color: #fff;
      margin-top: 50px;
    }

    header h1 {
      font-size: 2.5em;
      font-weight: 700;
      text-shadow: 1px 1px 5px rgba(0,0,0,0.3);
    }

    header p {
      font-size: 1em;
      opacity: 0.9;
      margin-top: 8px;
    }

    hr {
      width: 70%;
      height: 2px;
      background-color: rgba(255,255,255,0.5);
      border: none;
      margin: 20px auto;
    }

    .container {
      background: #fff;
      width: 90%;
      max-width: 850px;
      border-radius: 20px;
      display: flex;
      overflow: hidden;
      margin-top: 40px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.2);
      animation: fadeIn 0.8s ease-in-out;
    }

    .left {
      flex: 1;
      padding: 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .right {
      flex: 1;
      background: url('assets/img/smp4.jpg') center/cover no-repeat;
      min-height: 300px;
    }

    fieldset {
      border: 2px solid #1E88E5;
      border-radius: 12px;
      padding: 25px;
    }

    legend {
      font-weight: 700;
      color: #1E88E5;
      padding: 0 10px;
      font-size: 1.1em;
    }

    input[type="text"], input[type="number"], input[type="password"] {
      width: 95%;
      padding: 10px;
      margin: 10px 0 15px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 0.95em;
      transition: 0.2s;
    }

    input:focus {
      border-color: #1E88E5;
      box-shadow: 0 0 5px rgba(30,136,229,0.3);
    }

    button.login-btn {
      width: 100%;
      padding: 12px;
      background: #1E88E5;
      color: #fff;
      border: none;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    button.login-btn:hover {
      background: #1565C0;
      transform: scale(1.03);
    }

    .notif-success, .notif-danger-a, .notif-warning {
      margin: 10px 0;
      padding: 10px;
      border-radius: 8px;
      text-align: center;
      font-weight: 500;
    }

    .notif-success { background: #d4edda; color: #155724; }
    .notif-danger-a { background: #f8d7da; color: #721c24; }
    .notif-warning { background: #fff3cd; color: #856404; }

    footer {
      color: #fff;
      text-align: center;
      font-size: 0.9em;
      padding: 15px;
      margin-top: 50px;
      opacity: 0.9;
    }

    @media (max-width: 768px) {
      .container {
        flex-direction: column;
      }
      .right {
        height: 200px;
      }
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>

<body>

  <header>
    <h1>SMP Negeri 4 Tangerang Selatan</h1>
    <p>Portal Sistem Informasi Penilaian</p>
    <hr>
  </header>

  <div class="container">
    <div class="left">
      <fieldset>
        <legend>
          <?php 
            if(isset($_SESSION['login'])) 
              echo "ANDA LOGIN SEBAGAI"; 
            else 
              echo "LOGIN PORTAL";
          ?>
        </legend>

        <?php if (isset($_SESSION['login'])) { ?>
          <div class="notif-success">
            <?php echo strtoupper($_SESSION['login']); ?>
          </div>
          <a href="page/<?php echo $_SESSION['login']; ?>/index.php">
            <button class="login-btn">Masuk ke Beranda</button>
          </a><br><br>
          <a href="action/logout.php">
            <button class="login-btn" style="background:#e53935;">Logout</button>
          </a>
        <?php } else { ?>

          <div id="title_login">
            <?php
              if (isset($_SESSION['notif'])){
                echo $_SESSION['notif'];
                unset($_SESSION['notif']);
              } else {
                echo "<p>Silakan pilih tipe login Anda:</p>";
              }
            ?>
          </div>

          <div style="display:flex; gap:10px; margin-top:15px;">
            <button onclick="show_login_siswa()" class="login-btn" style="background:#42A5F5;">Login Siswa</button>
            <button onclick="show_login_admin()" class="login-btn" style="background:#FFB300;">Login Admin/Kepsek</button>
          </div>

          <div id="login_process" style="display:none;" class="notif-warning">
            Memproses login...
          </div>

          <div id="login_siswa" style="display:none; margin-top:15px;">
            <h3>Login Siswa</h3>
            <form action="action/login_siswa.php" method="post" onsubmit="show_login_process()">
              <input type="number" name="nis" placeholder="Masukkan NIS" required>
              <input type="password" name="password" placeholder="Masukkan Password" required>
              <button class="login-btn" type="submit">LOGIN</button>
            </form>
          </div>

          <div id="login_admin" style="display:none; margin-top:15px;">
            <h3>Login Admin / Kepala Sekolah</h3>
            <form action="action/login_admin.php" method="post" onsubmit="show_login_process()">
              <input type="text" name="username" placeholder="Masukkan Username" required>
              <input type="password" name="password" placeholder="Masukkan Password" required>
              <button class="login-btn" type="submit">LOGIN</button>
            </form>
          </div>

        <?php } ?>
      </fieldset>
    </div>

    <div class="right"></div>
  </div>

  <footer>
    © 2025 SMP Negeri 4 Tangerang Selatan — Sistem Informasi Penilaian Sekolah
  </footer>

<script>
  const login_siswa = document.getElementById('login_siswa');
  const login_admin = document.getElementById('login_admin');
  const title_login = document.getElementById('title_login');
  const login_process = document.getElementById('login_process');

  function show_login_siswa(){
    login_siswa.style.display = 'block';
    login_admin.style.display = 'none';
    title_login.style.display = 'none';
  }

  function show_login_admin(){
    login_admin.style.display = 'block';
    login_siswa.style.display = 'none';
    title_login.style.display = 'none';
  }

  function show_login_process(){
    login_siswa.style.display = 'none';
    login_admin.style.display = 'none';
    title_login.style.display = 'none';
    login_process.style.display = 'block';
  }
</script>
</body>
</html>
