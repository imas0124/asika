<?php
session_start();
include 'koneksi.php';

// Proteksi Login
if (!isset($_SESSION['admin_user'])) {
    header("Location: login.php");
    exit();
}

// Proses Simpan Kategori
if(isset($_POST['simpan'])){
    $ket = mysqli_real_escape_string($conn, $_POST['ket_kategori']);
    mysqli_query($conn, "INSERT INTO kategori (ket_kategori) VALUES ('$ket')");
    echo "<script>window.location.href='kategori.php';</script>";
    exit;
}

// Proses Hapus Kategori
if(isset($_GET['hapus'])){
    $id = mysqli_real_escape_string($conn, $_GET['hapus']);
    mysqli_query($conn, "DELETE FROM kategori WHERE id_kategori = '$id'");
    echo "<script>window.location.href='kategori.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/ico" href="img/logoo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASIKA | Kelola Kategori</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Quicksand', sans-serif; 
            /* Gradasi Soft Pink ke Soft Purple */
            background: linear-gradient(135deg, #fce7f3 0%, #f3e8ff 50%, #e0e7ff 100%); 
            background-attachment: fixed;
            min-height: 100vh;
        }
        .glass-card { 
            background: rgba(255, 255, 255, 0.45); 
            backdrop-filter: blur(15px); 
            border-radius: 30px; 
            border: 1px solid rgba(255, 255, 255, 0.6); 
            box-shadow: 0 15px 35px rgba(255, 182, 193, 0.2); 
        }
        .nav-gradient {
            background: linear-gradient(90deg, #fbcfe8, #e9d5ff);
        }
    </style>
</head>
<body class="p-6 md:p-10 flex flex-col items-center">
    
    <div class="w-full max-w-2xl">
        <header class="text-center mb-10">
            <h1 class="text-3xl font-bold text-indigo-900 tracking-tight">Kelola Kategori</h1>
            <p class="text-indigo-400 text-xs mt-1 font-bold italic">Atur klasifikasi aspirasi dengan gaya aesthetic ✨</p>
        </header>

        <div class="glass-card p-6 mb-8">
            <form method="POST" class="flex flex-col md:flex-row gap-3">
                <input type="text" name="ket_kategori" placeholder="Nama kategori baru..." 
                       class="flex-1 p-4 rounded-2xl bg-white/70 border border-pink-100 outline-none focus:ring-4 focus:ring-pink-200 transition-all text-sm font-semibold text-indigo-900 placeholder-indigo-300" 
                       required>
                <button type="submit" name="simpan" 
                        class="bg-gradient-to-r from-pink-400 to-purple-400 text-white px-8 py-4 rounded-2xl font-bold hover:scale-105 transition-all shadow-lg active:scale-95 text-xs uppercase tracking-widest">
                    Simpan
                </button>
            </form>
        </div>

        <div class="glass-card overflow-hidden">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-white/50 text-indigo-600">
                        <th class="p-5 w-20 text-center text-[10px] font-bold tracking-widest uppercase border-b border-pink-50">No</th>
                        <th class="p-5 text-left text-[10px] font-bold tracking-widest uppercase border-b border-pink-50">Kategori</th>
                        <th class="p-5 w-24 text-center text-[10px] font-bold tracking-widest uppercase border-b border-pink-50">Hapus</th>
                    </tr>
                </thead>
                <tbody class="text-indigo-900">
                    <?php 
                    $no = 1;
                    $data = mysqli_query($conn, "SELECT * FROM kategori ORDER BY id_kategori DESC");
                    if(mysqli_num_rows($data) > 0) {
                        while($d = mysqli_fetch_array($data)){
                    ?>
                        <tr class="border-b border-white/20 hover:bg-white/30 transition-colors">
                            <td class="p-5 font-bold text-center text-sm text-pink-400"><?php echo $no++; ?></td>
                            <td class="p-5 text-sm font-bold capitalize">
                                <span class="bg-white/60 px-3 py-1 rounded-lg border border-pink-50 shadow-sm">
                                    <?php echo htmlspecialchars($d['ket_kategori']); ?>
                                </span>
                            </td>
                            <td class="p-5 text-center">
                                <a href="kategori.php?hapus=<?php echo $d['id_kategori']; ?>" 
                                   onclick="return confirm('Hapus kategori ini?')"
                                   class="text-rose-400 hover:text-rose-600 transition-all inline-block hover:rotate-12">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                </a>
                            </td>
                        </tr>
                    <?php 
                        } 
                    } else {
                    ?>
                        <tr><td colspan="3" class="p-16 text-indigo-300 italic text-center text-sm opacity-60">Belum ada kategori.</td></tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="mt-10 text-center">
            <a href="menu_admin.php" class="inline-flex items-center gap-2 text-indigo-500 font-bold hover:gap-4 transition-all text-[10px] bg-white/50 px-8 py-3 rounded-full border border-white shadow-sm uppercase tracking-widest">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Kembali
            </a>
        </div>
    </div>

</body>
</html>