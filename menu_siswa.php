<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/ico" href="img/logoo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASIKA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            /* Background gradasi */
            background: linear-gradient(to right, #fbc2eb 0%, #a6c1ee 100%);
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* --- NAVBAR BARU --- */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 40px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 100%;
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .navbar img {
            height: 50px;
        }

        /* Tombol Logout di Navbar */
        .btn-logout-nav {
            background-color: #ff6b6b;
            color: white;
            padding: 8px 18px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: bold;
            font-size: 13px;
            transition: 0.3s;
        }

        .btn-logout-nav:hover {
            background-color: #ee5253;
            transform: scale(1.05);
        }

        /* --- KONTEN TENGAH --- */
        .main-content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .menu-card {
            background-color: white;
            padding: 40px;
            border-radius: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            width: 90%;
            max-width: 400px;
            text-align: center;
        }

        .welcome-text {
            color: #6a5acd;
            margin-bottom: 30px;
        }

        .welcome-text h2 {
            margin: 0;
            font-size: 22px;
        }

        #namaDisplay {
            color: #d81b60;
            text-transform: capitalize;
        }

        .button-group {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .btn-menu {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 25px; 
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: block;
        }

        .btn-gradient {
            background: linear-gradient(to right, #fbc2eb, #a6c1ee);
            color: white;
            box-shadow: 0 4px 15px rgba(166, 193, 238, 0.4);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid #ff4757;
            color: #ff4757;
        }

        .btn-menu:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            opacity: 0.9;
        }

        .btn-outline:hover {
            background: #ff4757;
            color: white;
        }
    </style>
</head>
<body>
    
    <nav class="navbar">
        <div class="nav-left">
            <img src="img/logoo.png" alt="Logo">
            <h1 class="text-xl font-bold text-white tracking-wider">ASIKA</h1>
        </div>
        <div class="nav-right">
            <a href="logout.php" class="btn-logout-nav" onclick="logout()">Logout</a>
        </div>
    </nav>

    <div class="main-content">
        <div class="menu-card">
            <div class="welcome-text">
                <h2>Selamat Datang,</h2>
                <h2 id="namaDisplay">Siswa</h2>
            </div>

            <div class="button-group">
                <button class="btn-menu btn-gradient" onclick="location.href='formulir_aspirasi.php'">
                    Formulir Aspirasi
                </button>

                <button class="btn-menu btn-gradient" onclick="location.href='riwayat_aspirasi_siswa.php'">
                    Riwayat Aspirasi
                </button>

                <button class="btn-menu btn-gradient" onclick="location.href='profil_siswa.php'">
                    Profil
                </button>
            </div>
        </div>
    </div>

    <script>
        // Mengambil nama dari localStorage
        const nama = localStorage.getItem('namaSiswa');

        // Menampilkan nama di elemen id="namaDisplay"
        if (nama) {
            document.getElementById('namaDisplay').innerText = nama;
        } else {
            // Jika tidak ada data nama (belum login), balikkan ke halaman login
            window.location.href = 'login.php';
        }

        // Fungsi Logout
        function logout() {
            localStorage.clear(); // Hapus data nama
            window.location.href = 'index.php'; // Pindah ke landing page
        }
    </script>

</body>
</html>