<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/ico" href="img/logoo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASIKA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');

        body {
            margin: 0;
            font-family: "Poppins", Arial, sans-serif;
            background: linear-gradient(135deg, #f8d7e8, #e6d9ff);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar Responsif */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background: linear-gradient(90deg, #f4b6d8, #cdb4ff);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .navbar img {
            height: 40px; /* Ukuran logo lebih kecil untuk HP */
        }

        .nav-right {
            display: flex;
            gap: 10px;
        }

        .nav-right a {
            text-decoration: none;
            color: #ffffff;
            font-weight: 600;
            font-size: 14px;
            padding: 6px 12px;
            border-radius: 15px;
            background-color: rgba(255,255,255,0.25);
            transition: 0.3s;
            white-space: nowrap; /* Agar teks tidak turun ke bawah */
        }

        /* Konten Tengah */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 20px;
        }

        .main-content img {
            width: 150px; /* Ukuran logo tengah disesuaikan */
            max-width: 80%;
            margin-bottom: 20px;
        }

        .welcome-title {
            color: #6a4c93;
            font-size: 20px; /* Ukuran default untuk HP */
            background-color: rgba(255,255,255,0.6);
            padding: 15px 25px;
            border-radius: 25px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            font-weight: bold;
            width: fit-content;
            max-width: 90%;
        }

        /* Pengaturan khusus untuk layar PC (Lebar) */
        @media (min-width: 768px) {
            .navbar { padding: 15px 40px; }
            .navbar img { height: 60px; }
            .nav-right a { font-size: 16px; padding: 8px 16px; }
            .welcome-title { font-size: 32px; }
            .main-content img { width: 220px; }
        }
    </style>
</head>
<body>

    <div class="navbar">
        <div class="nav-left">
            <img src="img/logoo.png" alt="Logo">
            <h1 class="text-xl md:text-2xl font-bold text-white tracking-wider">ASIKA</h1>
        </div>

        <div class="nav-right">
            <a href="siswa.php">Siswa</a>
            <a href="admin.php">Admin</a>
        </div>
    </div>

    <div class="main-content">
        <img src="img/logoo.png" alt="Logo Utama">
        <h1 class="welcome-title">Selamat Datang di Aspirasi Siswa</h1>
    </div>

</body>
</html>