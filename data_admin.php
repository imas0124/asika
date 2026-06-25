<?php
session_start();
include 'koneksi.php';

// 1. PROTEKSI HALAMAN
if (!isset($_SESSION['admin_user'])) {
    header("Location: login.php");
    exit();
}

// 2. LOGIKA HAPUS
if (isset($_GET['hapus_id'])) {
    $id_hapus = mysqli_real_escape_string($conn, $_GET['hapus_id']);
    $query_hapus = "DELETE FROM admin WHERE id_admin = '$id_hapus'";
    
    if (mysqli_query($conn, $query_hapus)) {
        echo "<script>
                alert('Petugas berhasil dihapus!'); 
                window.location.href='data_admin.php';
              </script>";
    } else {
        echo "<script>alert('Gagal menghapus: " . mysqli_error($conn) . "');</script>";
    }
}

// --- LOGIKA PENCARIAN ---
$keyword = "";
if (isset($_POST['cari'])) {
    $keyword = mysqli_real_escape_string($conn, $_POST['keyword']);
    $query = "SELECT id_admin, username, password FROM admin 
              WHERE username LIKE '%$keyword%' OR id_admin LIKE '%$keyword%'
              ORDER BY id_admin ASC";
} else {
    $query = "SELECT id_admin, username, password FROM admin ORDER BY id_admin ASC";
}

$sql = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/ico" href="img/logoo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASIKA - Data Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background: linear-gradient(135deg, #fce7f3 0%, #f3e8ff 100%); 
            background-attachment: fixed;
            min-height: 100vh;
        }
        .glass-card { 
            background: rgba(255, 255, 255, 0.4); 
            backdrop-filter: blur(20px); 
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.5); 
            box-shadow: 0 10px 30px rgba(0,0,0,0.05); 
        }
        @media (min-width: 768px) {
            .glass-card { border-radius: 40px; }
        }
        th { 
            background-color: #1e1b4b !important;
            color: #fff !important; 
            text-transform: uppercase; 
            font-size: 10px; 
            padding: 20px 10px; 
            letter-spacing: 1px; 
        }
        .btn-action {
            transition: all 0.3s ease;
        }
        .btn-action:hover {
            transform: translateY(-2px);
            filter: brightness(1.05);
        }
    </style>
</head>
<body class="p-4 md:p-8 flex flex-col items-center">

    <header class="text-center mb-8">
        <h1 class="text-2xl md:text-4xl font-bold text-indigo-900 mb-2">Data Petugas Admin</h1>
        <p class="text-indigo-600/70 italic text-xs md:text-sm font-medium">Kelola akun petugas administrator sistem.</p>
    </header>

    <div class="w-full max-w-5xl mb-6 flex flex-col md:flex-row gap-4 justify-between items-center">
        <form action="" method="POST" class="flex w-full md:w-auto gap-2">
            <input type="text" name="keyword" value="<?php echo $keyword; ?>" placeholder="Cari username atau ID..." 
                class="bg-white/50 border border-white px-4 py-2.5 rounded-full text-xs focus:outline-none focus:ring-2 focus:ring-purple-400 w-full md:w-64 shadow-sm">
            <button type="submit" name="cari" class="bg-indigo-900 text-white px-5 py-2.5 rounded-full text-[10px] font-bold hover:bg-indigo-800 transition-all shadow-md">
                CARI
            </button>
            <?php if(isset($_POST['cari'])): ?>
                <a href="data_admin.php" class="bg-white text-indigo-900 px-5 py-2.5 rounded-full text-[10px] font-bold border border-indigo-100 shadow-md">RESET</a>
            <?php endif; ?>
        </form>

        <a href="daftar_admin.php" class="bg-gradient-to-r from-pink-500 to-purple-600 text-white px-6 py-3 rounded-full text-[10px] md:text-xs font-bold shadow-lg flex items-center gap-2 hover:scale-105 transition-transform">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            TAMBAH PETUGAS
        </a>
    </div>

    <div class="w-full max-w-5xl glass-card overflow-hidden mb-12">
        <div class="overflow-x-auto">
            <table class="w-full text-center border-collapse min-w-[700px]">
                <thead>
                    <tr>
                        <th class="w-16 rounded-tl-[20px] md:rounded-tl-[40px]">NO</th>
                        <th>ID</th> 
                        <th>USERNAME</th> 
                        <th>PASSWORD</th>
                        <th class="rounded-tr-[20px] md:rounded-tr-[40px]">AKSI</th>
                    </tr>
                </thead>
                <tbody class="text-indigo-900 bg-white/20 text-sm">
                    <?php 
                    $no = 1;
                    if (mysqli_num_rows($sql) > 0) {
                        while($d = mysqli_fetch_array($sql)) { 
                    ?>
                    <tr class="hover:bg-white/40 transition-colors border-b border-white/30 last:border-0">
                        <td class="p-5 font-bold text-indigo-400"><?php echo $no++; ?></td>
                        <td class="p-5">
                            <span class="bg-white/60 text-indigo-600 px-3 py-1 rounded-full text-[10px] font-bold border border-indigo-100">
                                #<?php echo $d['id_admin']; ?>
                            </span>
                        </td>
                        <td class="p-5 font-bold italic text-indigo-800">@<?php echo htmlspecialchars($d['username']); ?></td>
                        <td class="p-5">
                            <span class="font-mono text-[11px] bg-white/50 px-3 py-1.5 rounded-lg border border-white/60">
                                <?php echo htmlspecialchars($d['password']); ?>
                            </span>
                        </td>
                        <td class="p-5">
                            <div class="flex justify-center gap-2">
                                <a href="edit_admin.php?id=<?php echo $d['id_admin']; ?>" 
                                   class="btn-action bg-amber-400 text-white px-4 py-1.5 rounded-xl text-[10px] font-bold shadow-sm">
                                    EDIT
                                </a>
                                <a href="data_admin.php?hapus_id=<?php echo $d['id_admin']; ?>" 
                                   onclick="return confirm('Yakin ingin menghapus petugas ini?')" 
                                   class="btn-action bg-rose-500 text-white px-4 py-1.5 rounded-xl text-[10px] font-bold shadow-sm">
                                    HAPUS
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php 
                        } 
                    } else { 
                    ?>
                    <tr>
                        <td colspan="5" class="p-20 text-center text-indigo-400 italic font-medium">
                            Data tidak ditemukan untuk kata kunci "<?php echo htmlspecialchars($keyword); ?>".
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <a href="menu_admin.php" class="text-indigo-600 font-bold flex items-center gap-2 hover:gap-4 transition-all duration-300 uppercase tracking-widest text-[10px] md:text-xs bg-white/50 px-6 py-3 rounded-full shadow-md hover:bg-white mb-10 border border-white">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        Kembali ke Dashboard
    </a>

</body>
</html>