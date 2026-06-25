<?php
session_start();
include 'koneksi.php';

// Proteksi Login
if (!isset($_SESSION['admin_user'])) {
    header("Location: login.php");
    exit();
}

// 1. Ambil ID dari URL
$id_admin = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';

if (empty($id_admin)) {
    header("Location: data_admin.php");
    exit();
}

// 2. Ambil data admin berdasarkan ID
$query_data = mysqli_query($conn, "SELECT * FROM admin WHERE id_admin = '$id_admin'");
$data = mysqli_fetch_assoc($query_data);

if (!$data) {
    echo "<script>alert('Data petugas tidak ditemukan!'); window.location.href='data_admin.php';</script>";
    exit;
}

// 3. Logika Update
if (isset($_POST['update_admin'])) {
    $user_baru = mysqli_real_escape_string($conn, $_POST['username']);
    $pass_baru = mysqli_real_escape_string($conn, $_POST['password']);
    
    $sql_update = "UPDATE admin SET username = '$user_baru', password = '$pass_baru' WHERE id_admin = '$id_admin'";

    if (mysqli_query($conn, $sql_update)) {
        echo "<script>alert('Data Petugas Berhasil Diperbarui!'); window.location.href='data_admin.php';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal memperbarui data!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/ico" href="img/logoo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASIKA | Edit Data Petugas</title>
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

    <div class="w-full max-w-md glass-card p-10 relative overflow-hidden">
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-purple-200 rounded-full blur-3xl opacity-50"></div>
        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-pink-200 rounded-full blur-3xl opacity-50"></div>

        <header class="text-center mb-10 relative z-10">
            <div class="inline-block p-4 bg-white/60 rounded-3xl mb-4 shadow-sm border border-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#a855f7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
            </div>
            <h1 class="text-xl font-bold text-slate-800 uppercase tracking-tight">Edit Petugas</h1>
            <p class="text-purple-500 font-bold text-sm mt-1 italic">ID Petugas: #<?php echo $id_admin; ?></p>
        </header>

        <form method="POST" class="space-y-6 relative z-10">
            <div>
                <label class="block text-[10px] font-bold text-slate-400 mb-2 uppercase tracking-[0.2em] ml-1">Username Baru</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">@</span>
                    <input type="text" name="username" value="<?php echo htmlspecialchars($data['username']); ?>" 
                           class="w-full pl-10 pr-4 py-4 rounded-2xl bg-white/80 border border-purple-50 outline-none focus:ring-4 focus:ring-purple-100 transition-all text-slate-700 font-semibold" 
                           required>
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-slate-400 mb-2 uppercase tracking-[0.2em] ml-1">Password Baru</label>
                <input type="text" name="password" value="<?php echo htmlspecialchars($data['password']); ?>" 
                       class="w-full p-4 rounded-2xl bg-white/80 border border-purple-50 outline-none focus:ring-4 focus:ring-purple-100 transition-all text-slate-700 font-semibold" 
                       required>
            </div>

            <div class="flex flex-col gap-3 pt-4">
                <button type="submit" name="update_admin" 
                        class="w-full py-4 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-bold rounded-2xl hover:opacity-90 transition-all shadow-lg shadow-purple-100 active:scale-[0.98] uppercase text-[10px] tracking-widest">
                    Simpan Perubahan
                </button>
                <a href="data_admin.php" 
                   class="w-full py-4 bg-white/50 text-slate-500 font-bold rounded-2xl hover:bg-rose-50 hover:text-rose-500 text-center transition-all border border-white uppercase text-[10px] tracking-widest">
                    Batal
                </a>
            </div>
        </form>
    </div>

</body>
</html>