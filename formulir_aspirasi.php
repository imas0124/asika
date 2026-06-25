<?php
session_start();
include 'koneksi.php';

// Proteksi login
if (!isset($_SESSION['nisn'])) {
    header("Location: siswa.php");
    exit();
}

// --- PROSES SIMPAN DATA & MERAPIKAN ID DATABASE ---
if (isset($_POST['submit'])) {
    $nisn = $_POST['nisn'];
    $id_kategori = $_POST['id_kategori'];
    $lokasi = $_POST['lokasi'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal = date('Y-m-d H:i:s'); 
    $status = 'menunggu'; 

    mysqli_query($conn, "SET @num := 0");
    mysqli_query($conn, "UPDATE aspirasi SET id_aspirasi = (@num := @num + 1)");
    
    $cek_jumlah = mysqli_query($conn, "SELECT COUNT(*) as total FROM aspirasi");
    $data_jumlah = mysqli_fetch_assoc($cek_jumlah);
    $next_id = $data_jumlah['total'] + 1;
    mysqli_query($conn, "ALTER TABLE aspirasi AUTO_INCREMENT = $next_id");

    $query_simpan = "INSERT INTO aspirasi (nisn, id_kategori, lokasi, deskripsi, status, tanggal_input) 
                     VALUES ('$nisn', '$id_kategori', '$lokasi', '$deskripsi', '$status', '$tanggal')";

    if (mysqli_query($conn, $query_simpan)) {
        echo "<script>
                alert('Aspirasi berhasil terkirim!');
                window.location.href='menu_siswa.php';
              </script>";
    } else {
        echo "Gagal menyimpan: " . mysqli_error($conn);
    }
}

$query_kategori = mysqli_query($conn, "SELECT * FROM kategori");
$res_id = mysqli_query($conn, "SELECT MAX(id_aspirasi) as max_id FROM aspirasi");
$row_id = mysqli_fetch_assoc($res_id);
$estimasi_id = $row_id['max_id'] + 1;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/ico" href="img/logoo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASIKA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; font-family: 'Quicksand', sans-serif; }
        
        body {
            background: linear-gradient(to right, #fbc2eb 0%, #a6c1ee 100%);
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* --- NAVBAR --- */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 40px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 100%;
            position: fixed;
            top: 0;
            z-index: 1000;
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .navbar img {
            height: 50px;
        }

        /* --- FORM CONTENT --- */
        .main-content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 100px 20px 40px 20px; /* Padding top dikasih lebih agar tidak tertutup navbar */
        }

        .form-card {
            background: white;
            padding: 40px;
            border-radius: 30px;
            width: 100%;
            max-width: 500px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        h2 { color: #6a5acd; margin-bottom: 5px; font-weight: bold; font-size: 24px; }
        
        .form-group { text-align: left; margin-bottom: 15px; }
        .form-group label { display: block; color: #6a5acd; font-weight: bold; margin-bottom: 5px; font-size: 14px; }
        
        input, select, textarea {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 15px;
            background-color: #f0f3ff;
            outline: none;
            transition: 0.3s;
        }

        input:focus, select:focus, textarea:focus {
            background-color: #e8ebf7;
            box-shadow: 0 0 0 2px #a6c1ee;
        }

        textarea { resize: none; height: 100px; }

        .btn-submit {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 25px;
            background: linear-gradient(to right, #fbc2eb, #a6c1ee);
            color: white;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
            transition: 0.3s;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            opacity: 0.9;
        }

        .id-badge {
            background: #6a5acd;
            color: white;
            padding: 2px 10px;
            border-radius: 10px;
            font-size: 12px;
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="nav-left">
            <img src="img/logoo.png" alt="Logo ASIKA">
            <h1 class="text-xl font-bold text-white tracking-wider">ASIKA</h1>
        </div>
        
    </nav>

    <div class="main-content">
        <div class="form-card">
            <h2>Formulir Aspirasi</h2>
            <p style="color: #6a5acd; font-weight: bold; margin-bottom: 25px;">Silakan isi laporan Anda</p>
            
            <form action="" method="POST">
                <div class="form-group">
                    <label>ID Aspirasi <span class="id-badge">Otomatis Sistem</span></label>
                    <input type="text" value="#<?php echo $estimasi_id; ?>" readonly style="color: #999; font-style: italic;">
                </div>

                <div class="form-group">
                    <label>NISN</label>
                    <input type="text" name="nisn" value="<?php echo $_SESSION['nisn']; ?>" readonly>
                </div>

                <div class="form-group">
                    <label>Kategori Aspirasi</label>
                    <select name="id_kategori" required>
                        <option value="" disabled selected>-- Pilih Kategori --</option>
                        <?php while($kat = mysqli_fetch_assoc($query_kategori)): ?>
                            <option value="<?php echo $kat['id_kategori']; ?>">
                                <?php echo $kat['ket_kategori']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Lokasi Kejadian</label>
                    <input type="text" name="lokasi" placeholder="Contoh: Kantin Sekolah" required>
                </div>

                <div class="form-group">
                    <label>Deskripsi Aspirasi</label>
                    <textarea name="deskripsi" placeholder="Ceritakan detail aspirasi kamu..." required></textarea>
                </div>

                <button type="submit" name="submit" class="btn-submit">Kirim Aspirasi</button>
            </form>
            
            <div style="margin-top: 20px;">
                <a href="menu_siswa.php" class="text-slate-400 font-bold hover:text-indigo-600 transition-colors text-xs uppercase tracking-widest">
                    ← Kembali ke Menu
                </a>
            </div>
        </div>
    </div>

</body>
</html>