<?php
// 1. KONEKSI KE DATABASE
include 'koneksi.php';
session_start();

/** * Ambil data berdasarkan session. 
 * Default ke '123' untuk simulasi sesuai database kamu.
 */
$nisn_login = $_SESSION['nisn'] ?? '123'; 

$query  = "SELECT * FROM siswa WHERE nisn = '$nisn_login'";
$result = mysqli_query($conn, $query);
$data   = mysqli_fetch_assoc($result);

if (!$data) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='login.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Siswa - ASIKA Theme</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            /* Gradasi sesuai gambar ASIKA: Pink ke Lavender */
            background: linear-gradient(to right, #f8c2e0, #cfb1f8);
            font-family: 'Poppins', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            max-width: 550px;
            padding: 20px;
        }
        .card-profile {
            /* Efek Glassmorphism agar transparan cantik */
            background: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 25px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
        }
        h2 {
            color: #6a4fa3; /* Warna ungu gelap dari logo ASIKA */
            font-weight: 700;
            margin-bottom: 35px;
            text-align: center;
            letter-spacing: 1px;
        }
        .form-label {
            font-weight: 600;
            color: #555;
            font-size: 0.85rem;
            margin-bottom: 8px;
            margin-left: 2px;
        }
        .form-control {
            border-radius: 12px;
            border: 1px solid rgba(200, 200, 200, 0.5);
            padding: 12px 15px;
            background-color: rgba(255, 255, 255, 0.8);
            color: #333;
            transition: 0.3s;
        }
        .form-control:focus {
            border-color: #cfb1f8;
            box-shadow: 0 0 0 0.25rem rgba(207, 177, 248, 0.25);
            background-color: #fff;
        }
        /* Style untuk input yang tidak bisa diubah */
        .form-control[readonly] {
            background-color: rgba(255, 255, 255, 0.4);
            cursor: default;
        }
        .btn-show {
            background-color: #6a4fa3;
            color: white;
            border: none;
            border-radius: 0 12px 12px 0;
            padding: 0 20px;
            font-weight: 600;
            font-size: 0.75rem;
        }
        .btn-show:hover {
            background-color: #553d8a;
            color: white;
        }
        /* Tombol Keluar Style ASIKA */
        .btn-logout {
            background: linear-gradient(45deg, #f8c2e0, #cfb1f8);
            color: #6a4fa3 !important;
            border: 2px solid white;
            border-radius: 15px;
            padding: 12px;
            width: 100%;
            font-weight: 700;
            margin-top: 30px;
            text-decoration: none;
            display: block;
            text-align: center;
            transition: 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        .btn-logout:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            filter: brightness(1.02);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card card-profile">
        <h2>Profil Siswa</h2>
        
        <form action="" method="POST">
            <div class="mb-3">
                <label class="form-label">NISN</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($data['nisn'] ?? '-'); ?>" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Siswa</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($data['nama'] ?? '-'); ?>" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" id="passInput" class="form-control" value="<?= htmlspecialchars($data['password'] ?? ''); ?>" readonly>
                    <button class="btn btn-show" type="button" id="btnToggle">SHOW</button>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis Kelamin</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($data['jk'] ?? '-'); ?>" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Nomor HP</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($data['no_hp'] ?? '-'); ?>" readonly>
            </div>

            <a href="menu_siswa.php" class="back-link">kembali</a>
        </form>
    </div>
</div>

<script>
    const passInput = document.getElementById('passInput');
    const btnToggle = document.getElementById('btnToggle');

    btnToggle.addEventListener('click', () => {
        if (passInput.type === "password") {
            passInput.type = "text";
            btnToggle.innerText = "HIDE";
        } else {
            passInput.type = "password";
            btnToggle.innerText = "SHOW";
        }
    });
</script>

</body>
</html>