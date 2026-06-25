<?php
session_start();
include 'koneksi.php';

// 1. PROTEKSI HALAMAN
if (!isset($_SESSION['level']) || $_SESSION['level'] !== 'admin') {
    header("Location: login_admin.php");
    exit;
}

// 2. AMBIL DATA SISWA BERDASARKAN NISN
$nisn = isset($_GET['nisn']) ? mysqli_real_escape_string($conn, $_GET['nisn']) : '';

if (empty($nisn)) {
    header("Location: data_siswa.php");
    exit();
}

$query_data = mysqli_query($conn, "SELECT * FROM siswa WHERE nisn = '$nisn'");
$d = mysqli_fetch_assoc($query_data);

if (!$d) {
    echo "<script>alert('Data siswa tidak ditemukan!'); window.location.href='data_siswa.php';</script>";
    exit;
}

// 3. LOGIKA UPDATE
if (isset($_POST['update_siswa'])) {
    $nama     = mysqli_real_escape_string($conn, $_POST['nama']);
    $jk       = mysqli_real_escape_string($conn, $_POST['jk']);
    $no_hp    = mysqli_real_escape_string($conn, $_POST['no_hp']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql_update = "UPDATE siswa SET 
                   nama = '$nama', 
                   jk = '$jk', 
                   no_hp = '$no_hp', 
                   password = '$password' 
                   WHERE nisn = '$nisn'";

    if (mysqli_query($conn, $sql_update)) {
        echo "<script>alert('Data siswa berhasil diperbarui!'); window.location.href='data_siswa.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/ico" href="img/logoo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASIKA | Edit Data Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background: linear-gradient(135deg, #fce7f3 0%, #f3e8ff 100%); 
            min-height: 100vh;
        }
        .glass-card { 
            background: rgba(255, 255, 255, 0.7); 
            backdrop-filter: blur(20px); 
            border-radius: 2.5rem; 
            border: 1px solid white; 
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08); 
        }
    </style>
</head>
<body class="flex items-center justify-center p-6">

    <div class="w-full max-w-lg glass-card p-8 md:p-12 relative overflow-hidden">
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-purple-200 rounded-full blur-3xl opacity-50"></div>
        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-pink-200 rounded-full blur-3xl opacity-50"></div>

        <header class="text-center mb-10 relative z-10">
            <h1 class="text-2xl font-bold text-slate-800 uppercase tracking-tight">Edit Profil Siswa</h1>
            <p class="text-purple-500 font-bold text-xs mt-1 italic uppercase tracking-widest">NISN: <?php echo $nisn; ?></p>
        </header>

        <form method="POST" class="space-y-5 relative z-10 text-sm">
            
            <div>
                <label class="block text-[10px] font-bold text-slate-400 mb-2 uppercase tracking-widest ml-1">Nama Lengkap</label>
                <input type="text" name="nama" value="<?php echo htmlspecialchars($d['nama']); ?>" 
                       class="w-full p-4 rounded-2xl bg-white/80 border border-purple-50 outline-none focus:ring-4 focus:ring-purple-100 transition-all text-slate-700 font-semibold" required>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-slate-400 mb-2 uppercase tracking-widest ml-1">Jenis Kelamin</label>
                <select name="jk" class="w-full p-4 rounded-2xl bg-white/80 border border-purple-50 outline-none focus:ring-4 focus:ring-purple-100 transition-all text-slate-700 font-semibold appearance-none">
                    <option value="L" <?php echo ($d['jk'] == 'L' || $d['jk'] == 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                    <option value="P" <?php echo ($d['jk'] == 'P' || $d['jk'] == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                </select>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-slate-400 mb-2 uppercase tracking-widest ml-1">Nomor WhatsApp</label>
                <input type="text" name="no_hp" value="<?php echo htmlspecialchars($d['no_hp']); ?>" 
                       class="w-full p-4 rounded-2xl bg-white/80 border border-purple-50 outline-none focus:ring-4 focus:ring-purple-100 transition-all text-slate-700 font-semibold" required>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-slate-400 mb-2 uppercase tracking-widest ml-1">Password Akun</label>
                <input type="text" name="password" value="<?php echo htmlspecialchars($d['password']); ?>" 
                       class="w-full p-4 rounded-2xl bg-white/80 border border-purple-50 outline-none focus:ring-4 focus:ring-purple-100 transition-all text-slate-700 font-semibold" required>
            </div>

            <div class="flex flex-col gap-3 pt-6">
                <button type="submit" name="update_siswa" 
                        class="w-full py-4 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-bold rounded-2xl hover:opacity-90 transition-all shadow-lg shadow-indigo-100 active:scale-[0.98] uppercase text-[10px] tracking-widest">
                    Update Data Siswa
                </button>
                <a href="data_siswa.php" 
                   class="w-full py-4 bg-white/50 text-slate-500 font-bold rounded-2xl hover:bg-rose-50 hover:text-rose-500 text-center transition-all border border-white uppercase text-[10px] tracking-widest">
                    Batal & Kembali
                </a>
            </div>
        </form>
    </div>

</body>
</html>