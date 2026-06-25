<?php
session_start();
include 'koneksi.php';

// 1. PROTEKSI HALAMAN
if (!isset($_SESSION['level']) || $_SESSION['level'] !== 'admin') {
    header("Location: login_admin.php");
    exit;
}

// 2. LOGIKA HAPUS SISWA
if (isset($_GET['hapus_nisn'])) {
    $nisn_hapus = mysqli_real_escape_string($conn, $_GET['hapus_nisn']);
    $query_hapus = "DELETE FROM siswa WHERE nisn = '$nisn_hapus'";
    
    if (mysqli_query($conn, $query_hapus)) {
        echo "<script>
                alert('Data siswa berhasil dihapus!'); 
                window.location.href='data_siswa.php';
              </script>";
    } else {
        echo "<script>alert('Gagal menghapus: " . mysqli_error($conn) . "');</script>";
    }
}

// --- 3. LOGIKA PENCARIAN SISWA ---
$keyword = "";
if (isset($_POST['cari'])) {
    $keyword = mysqli_real_escape_string($conn, $_POST['keyword']);
    $query = "SELECT nisn, nama, jk, password, no_hp FROM siswa 
              WHERE nama LIKE '%$keyword%' OR nisn LIKE '%$keyword%'
              ORDER BY nama ASC";
} else {
    $query = "SELECT nisn, nama, jk, password, no_hp FROM siswa ORDER BY nama ASC";
}

$sql = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/ico" href="img/logoo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASIKA | Data Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background: linear-gradient(135deg, #fce7f3 0%, #f3e8ff 100%); 
            background-attachment: fixed;
        }
        .glass-card { 
            background: rgba(255, 255, 255, 0.4); 
            backdrop-filter: blur(20px); 
            border-radius: 40px; 
            border: 1px solid rgba(255, 255, 255, 0.5); 
            box-shadow: 0 20px 40px rgba(0,0,0,0.05); 
        }
        th { 
            background-color: #1e1b4b !important; 
            color: #fff !important; 
            text-transform: uppercase; 
            font-size: 10px; 
            padding: 25px 15px; 
            letter-spacing: 1.5px; 
        }
        .btn-action {
            transition: all 0.3s ease;
        }
        .btn-action:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="min-h-screen">

    <main class="p-4 md:p-8 flex flex-col items-center">
        <header class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-bold text-indigo-900 mb-2">Manajemen Data Siswa</h1>
            <p class="text-indigo-600/70 italic text-xs md:text-sm font-medium">Pantau dan kelola data akun siswa terdaftar.</p>
        </header>

        <div class="w-full max-w-7xl mb-6">
            <form action="" method="POST" class="flex flex-col md:flex-row gap-3 items-center">
                <div class="relative w-full md:w-80">
                    <input type="text" name="keyword" value="<?php echo htmlspecialchars($keyword); ?>" 
                        placeholder="Cari Nama atau NISN..." 
                        class="w-full bg-white/60 border border-white px-5 py-3 rounded-full text-xs focus:outline-none focus:ring-2 focus:ring-indigo-400 shadow-sm">
                </div>
                <div class="flex gap-2">
                    <button type="submit" name="cari" class="bg-indigo-900 text-white px-8 py-3 rounded-full text-[10px] font-bold hover:bg-indigo-800 transition-all shadow-md tracking-widest">
                        CARI
                    </button>
                    <?php if(isset($_POST['cari'])): ?>
                        <a href="data_siswa.php" class="bg-white/80 text-indigo-900 px-6 py-3 rounded-full text-[10px] font-bold border border-white shadow-sm hover:bg-white transition-all">
                            RESET
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <div class="w-full max-w-7xl glass-card overflow-hidden mb-12">
            <div class="overflow-x-auto">
                <table class="w-full text-center border-collapse min-w-[900px]">
                    <thead>
                        <tr>
                            <th class="rounded-tl-[40px] w-16">NO</th>
                            <th>NISN</th> 
                            <th>NAMA LENGKAP</th> 
                            <th>JK</th>
                            <th>NO HP</th>
                            <th>PASSWORD</th>
                            <th class="rounded-tr-[40px]">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="text-indigo-900 font-medium bg-white/10 text-sm">
                        <?php 
                        $no = 1;
                        if (mysqli_num_rows($sql) > 0) {
                            while($d = mysqli_fetch_array($sql)) { 
                        ?>
                        <tr class="hover:bg-white/40 transition-colors border-b border-white/20 last:border-0">
                            <td class="p-6 font-bold text-indigo-300"><?php echo $no++; ?></td>
                            <td class="p-6">
                                <span class="bg-white/80 text-indigo-600 px-3 py-1 rounded-full text-[10px] font-bold border border-indigo-100 shadow-sm">
                                    <?php echo htmlspecialchars($d['nisn']); ?>
                                </span>
                            </td>
                            <td class="p-6 font-bold text-slate-800 text-left uppercase text-xs tracking-tight">
                                <?php echo htmlspecialchars($d['nama']); ?>
                            </td>
                            <td class="p-6">
                                <span class="px-3 py-1 rounded-lg text-[10px] font-bold <?php echo ($d['jk'] == 'L' || $d['jk'] == 'Laki-laki') ? 'bg-blue-100 text-blue-600' : 'bg-pink-100 text-pink-600'; ?>">
                                    <?php echo htmlspecialchars($d['jk']); ?>
                                </span>
                            </td>
                            <td class="p-6 text-xs font-semibold italic text-indigo-500">
                                <?php echo htmlspecialchars($d['no_hp']); ?>
                            </td>
                            <td class="p-6">
                                <span class="text-slate-500 font-mono text-[10px] bg-white/50 px-2 py-1 rounded border border-white/60">
                                    <?php echo htmlspecialchars($d['password']); ?>
                                </span>
                            </td>
                            <td class="p-6">
                                <div class="flex justify-center gap-2">
                                    <a href="edit_siswa.php?nisn=<?php echo $d['nisn']; ?>" 
                                       class="btn-action bg-amber-400 text-white px-4 py-1.5 rounded-xl text-[10px] font-bold shadow-sm hover:bg-amber-500">
                                        EDIT
                                    </a>
                                    <a href="data_siswa.php?hapus_nisn=<?php echo $d['nisn']; ?>" 
                                       onclick="return confirm('Apakah Anda yakin ingin menghapus data siswa ini?')" 
                                       class="btn-action bg-rose-500 text-white px-4 py-1.5 rounded-xl text-[10px] font-bold shadow-sm hover:bg-rose-600">
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
                            <td colspan="7" class="p-24 text-center text-indigo-300 italic">
                                <p>Data tidak ditemukan untuk kata kunci "<?php echo htmlspecialchars($keyword); ?>".</p>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <a href="menu_admin.php" class="group text-indigo-600 font-bold flex items-center gap-2 hover:gap-4 transition-all duration-300 uppercase tracking-widest text-xs bg-white/40 px-8 py-3 rounded-full shadow-sm hover:bg-white border border-white mb-10">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Dashboard
        </a>
    </main>

</body>
</html>