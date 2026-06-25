<?php
session_start();
include 'koneksi.php';

// Proteksi login
if (!isset($_SESSION['admin_user'])) {
    header("Location: login.php");
    exit;
}
$nama_display = $_SESSION['admin_user'];

// --- HITUNG DATA ---
$total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM aspirasi"))['jml'];
$proses = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM aspirasi WHERE status = 'proses'"))['jml'];
$menunggu = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM aspirasi WHERE status = 'menunggu'"))['jml'];
$selesai = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM aspirasi WHERE status = 'selesai'"))['jml'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/ico" href="img/logoo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASIKA - Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Quicksand', sans-serif; 
            background: linear-gradient(to bottom right, #fdf2f8, #f5f3ff, #eff6ff); 
        }
        .stat-card {
            background: rgba(255, 255, 255, 0.7);
            border-radius: 1.5rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
        }
        .sidebar-active { 
            background: linear-gradient(to right, #fbcfe8, #ddd6fe); 
            color: white !important; 
        }
        /* Transisi halus untuk sidebar mobile */
        #sidebar {
            transition: transform 0.3s ease-in-out;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col md:flex-row overflow-x-hidden">

    <div class="md:hidden flex items-center justify-between p-5 bg-white/60 backdrop-blur-md sticky top-0 z-50 border-b border-purple-100">
        <h1 class="text-xl font-bold text-purple-600">ASIKA</h1>
        <button id="menu-open" class="text-purple-600 text-3xl focus:outline-none">
            ☰
        </button>
    </div>

    <aside id="sidebar" class="fixed inset-y-0 left-0 z-[60] w-72 p-8 flex flex-col justify-between bg-white shadow-2xl transform -translate-x-full md:translate-x-0 md:relative md:flex md:bg-transparent md:shadow-none">
        <div>
            <div class="flex justify-between items-center mb-12">
                <h1 class="text-2xl font-bold text-purple-600 tracking-wider">ASIKA</h1>
                <button id="menu-close" class="md:hidden text-gray-400 text-2xl">&times;</button>
            </div>
            <nav class="space-y-4">
                <a href="menu_admin.php" class="block px-6 py-3 rounded-2xl sidebar-active font-bold shadow-sm">Dashboard</a>
                <a href="data_aspirasi.php" class="block px-6 py-3 text-gray-500 hover:text-purple-600 transition font-semibold">Data Pengaduan</a>
                <a href="data_admin.php" class="block px-6 py-3 text-gray-500 hover:text-purple-600 transition font-semibold">Data Petugas</a>
                <a href="data_siswa.php" class="block px-6 py-3 text-gray-500 hover:text-purple-600 transition font-semibold">Data Siswa</a>
                <a href="menu_feedback_admin.php" class="block px-6 py-3 text-gray-500 hover:text-purple-600 transition font-semibold">Feedback</a>
                <a href="kategori.php" class="block px-6 py-3 text-gray-500 hover:text-purple-600 transition font-semibold">Kategori</a>
            </nav>
        </div>
        <div class="mt-10">
            <a href="logout.php" class="px-6 py-3 text-red-400 italic hover:text-red-600 transition font-medium">keluar</a>
        </div>
    </aside>

    <div id="sidebar-overlay" class="fixed inset-0 bg-black/30 z-[55] hidden opacity-0 transition-opacity duration-300"></div>

    <main class="flex-1 p-6 md:p-12">
        <header class="mb-10 md:mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-slate-700 leading-tight">
                Selamat Datang, <br class="md:hidden"> 
                <span class="text-purple-500"><?php echo $nama_display; ?>!</span>
            </h2>
            <p class="text-slate-400 mt-2 text-base md:text-lg">Berikut ringkasan laporan hari ini.</p>
        </header>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
            <div class="stat-card p-8 md:p-10 flex flex-col items-center">
                <span class="text-blue-400 text-[10px] md:text-xs font-bold uppercase tracking-[0.2em] mb-4">Total Laporan</span>
                <span class="text-5xl md:text-6xl font-bold text-blue-500"><?php echo $total; ?></span>
            </div>
            <div class="stat-card p-8 md:p-10 flex flex-col items-center">
                <span class="text-orange-400 text-[10px] md:text-xs font-bold uppercase tracking-[0.2em] mb-4">Proses</span>
                <span class="text-5xl md:text-6xl font-bold text-orange-400"><?php echo $proses; ?></span>
            </div>
            <div class="stat-card p-8 md:p-10 flex flex-col items-center">
                <span class="text-pink-400 text-[10px] md:text-xs font-bold uppercase tracking-[0.2em] mb-4">Menunggu</span>
                <span class="text-5xl md:text-6xl font-bold text-pink-400"><?php echo $menunggu; ?></span>
            </div>
            <div class="stat-card p-8 md:p-10 flex flex-col items-center">
                <span class="text-emerald-400 text-[10px] md:text-xs font-bold uppercase tracking-[0.2em] mb-4">Selesai</span>
                <span class="text-5xl md:text-6xl font-bold text-emerald-400"><?php echo $selesai; ?></span>
            </div>
        </div>
    </main>

    <script>
        const btnOpen = document.getElementById('menu-open');
        const btnClose = document.getElementById('menu-close');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        function openMenu() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
            setTimeout(() => overlay.classList.add('opacity-100'), 10);
            document.body.style.overflow = 'hidden'; // Biar gak bisa scroll saat menu buka
        }

        function closeMenu() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.remove('opacity-100');
            setTimeout(() => {
                overlay.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }, 300);
        }

        btnOpen.addEventListener('click', openMenu);
        btnClose.addEventListener('click', closeMenu);
        overlay.addEventListener('click', closeMenu);
    </script>

</body>
</html>