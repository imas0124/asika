<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil input nisn dan password dari form
    $nisn     = mysqli_real_escape_string($conn, $_POST['nisn']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query mencari siswa berdasarkan NISN & Password sesuai tabel 'siswa'
    $sql = "SELECT * FROM siswa WHERE nisn='$nisn' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // MENYIMPAN DATA KE SESSION UNTUK DIGUNAKAN DI FORMULIR ASPIRASI
        $_SESSION['nisn'] = $row['nisn'];
        $_SESSION['nama'] = $row['nama'];

        echo "<script>
                localStorage.setItem('namaSiswa', '" . $row['nama'] . "');
                window.location.href = 'menu_siswa.php';
              </script>";
    } else {
        echo "<script>alert('NISN atau Password Salah!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/ico" href="img/logoo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASIKA</title>
    <style>
        * { box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body {
            background: linear-gradient(to right, #fbc2eb, #a6c1ee);
            display: flex; justify-content: center; align-items: center;
            height: 100vh; margin: 0;
            position: relative; /* Menjadi acuan tombol logout */
        }

        /* --- TOMBOL LOGOUT POJOK ATAS --- */
        .btn-logout {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #ff6b6b;
            color: white;
            padding: 10px 20px;
            border-radius: 15px;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
            transition: 0.3s;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .btn-logout:hover {
            background-color: #ee5253;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 107, 107, 0.4);
        }
        /* ------------------------------- */

        .login-card {
            background-color: white; padding: 40px; border-radius: 30px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 380px; text-align: center;
        }
        h2 { color: #6a5acd; margin-bottom: 30px; }
        .input-group { text-align: left; margin-bottom: 20px; }
        .input-group label { display: block; color: #6a5acd; font-weight: bold; margin-bottom: 8px; font-size: 14px; }
        .input-group input {
            width: 100%; padding: 12px 15px; border: none; border-radius: 15px;
            background-color: #eef2ff; outline: none;
        }
        .btn-login {
            width: 100%; padding: 12px; border: none; border-radius: 20px;
            background: linear-gradient(to right, #fbc2eb, #a6c1ee);
            color: white; font-size: 16px; font-weight: bold; cursor: pointer;
        }
        .footer-text { margin-top: 20px; font-size: 13px; color: #6a5acd; }
        .footer-text a { color: #9c27b0; text-decoration: none; font-weight: bold; }
        .back-link { display: block; margin-top: 15px; color: #6a5acd; text-decoration: none; font-size: 13px; }
    </style>
</head>
<body>

    

    <div class="login-card">
        <h2>Login Siswa</h2>
        <form method="POST" action="">
            <div class="input-group">
                <label>NISN</label>
                <input type="text" name="nisn" placeholder="Masukkan NISN Anda" required>
            </div>
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="••••" required>
            </div>
            <button type="submit" class="btn-login">Login</button>
        </form>

        <p class="footer-text">
            Belum mempunyai akun? <a href="daftar_siswa.php">Daftar</a>
        </p>
        <a href="index.php" class="back-link">kembali</a>
    </div>

</body>
</html>