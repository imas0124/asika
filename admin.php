<?php
session_start();
include 'koneksi.php';

$pesan = "";

// Cek apakah tombol login ditekan
if (isset($_POST['login'])) {
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);

    // Query mencari admin yang cocok
    $query = mysqli_query($conn, "SELECT * FROM admin WHERE username='$user' AND password='$pass'");
    
    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
        $_SESSION['admin_user'] = $data['username'];
        $_SESSION['level']      = 'admin';
        
        header("Location: menu_admin.php");
        exit;
    } else {
        $pesan = "❌ Username / Password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASIKA - Login Admin</title>
    <link rel="icon" href="img/logoo.png">
    <style>
        * { box-sizing: border-box; font-family: "Poppins", sans-serif; }
        
        body {
            margin: 0; min-height: 100vh;
            background: linear-gradient(135deg, #f8d7e8, #e6d9ff);
            display: flex; justify-content: center; align-items: center; padding: 20px;
        }

        .login-box {
            background: #fff; padding: 30px; width: 100%; max-width: 400px;
            border-radius: 25px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        h2 { text-align: center; color: #6a4c93; margin-bottom: 20px; }
        label { font-size: 14px; color: #6a4c93; font-weight: 600; display: block; margin-bottom: 5px; }

        input {
            width: 100%; padding: 12px; margin-bottom: 20px;
            border-radius: 20px; border: none; background: #f3e8ff; outline: none;
        }

        button {
            width: 100%; padding: 12px; border: none; border-radius: 20px;
            background: linear-gradient(90deg, #f4b6d8, #cdb4ff);
            color: white; font-weight: bold; cursor: pointer;
        }

        .error {
            text-align: center; color: #d9534f; background: #f8d7da;
            padding: 10px; border-radius: 10px; margin-bottom: 15px; font-size: 14px;
        }

        p { text-align: center; font-size: 14px; color: #666; }
        a { color: #a066c9; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Login Admin</h2>

    <?php if ($pesan): ?>
        <div class="error"><?= $pesan ?></div>
    <?php endif; ?>

    <form method="post">
        <label>Username</label>
        <input type="text" name="username" placeholder="Username" required>

        <label>Password</label>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit" name="login">Login</button>
    </form>

    <p>Kembali ke <a href="index.php">Home</a></p>
</div>

</body>
</html>