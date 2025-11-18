<?php
session_start();
include 'koneksi.php';

// Jika sudah login, lempar langsung ke dashboard (Gak perlu login lagi)
if (isset($_SESSION['status_login']) && $_SESSION['status_login'] == true) {
  header("Location: dashboard.php");
  exit;
}

// LOGIKA LOGIN
if (isset($_POST['login'])) {
  $user = mysqli_real_escape_string($conn, $_POST['user']);
  $pass = mysqli_real_escape_string($conn, $_POST['pass']);

  // Cek username & password di database
  $cek = mysqli_query($conn, "SELECT * FROM admin WHERE username = '$user' AND password = '$pass'");

  if (mysqli_num_rows($cek) > 0) {
    $d = mysqli_fetch_object($cek);
    $_SESSION['status_login'] = true;
    $_SESSION['admin_global'] = $d;
    $_SESSION['id'] = $d->id;

    echo '<script>window.location="dashboard.php"</script>';
  } else {
    echo '<script>alert("Username atau Password Salah!")</script>';
  }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin - Gitar Surabaya</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background-color: #F5F6FA;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .login-card {
      background: #fff;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
      width: 100%;
      max-width: 400px;
      text-align: center;
    }

    .login-card h2 {
      margin-bottom: 10px;
      font-weight: 600;
      color: #333;
    }

    .login-card p {
      margin-bottom: 30px;
      color: #888;
      font-size: 14px;
    }

    .form-group {
      margin-bottom: 20px;
      text-align: left;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-size: 14px;
      font-weight: 500;
    }

    .form-control {
      width: 100%;
      padding: 12px;
      border: 1px solid #ddd;
      border-radius: 8px;
      outline: none;
      transition: 0.3s;
    }

    .form-control:focus {
      border-color: #000;
    }

    .btn-login {
      width: 100%;
      padding: 12px;
      background-color: #000;
      color: #fff;
      border: none;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      transition: 0.3s;
    }

    .btn-login:hover {
      background-color: #333;
    }
  </style>
</head>

<body>

  <div class="login-card">
    <h2>Admin Panel</h2>
    <p>Silakan login untuk mengelola toko.</p>

    <form action="" method="POST">
      <div class="form-group">
        <label>Username</label>
        <input type="text" name="user" class="form-control" placeholder="Masukkan username" required>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="pass" class="form-control" placeholder="Masukkan password" required>
      </div>
      <button type="submit" name="login" class="btn-login">Masuk Dashboard</button>
    </form>
  </div>

</body>

</html>