<?php
session_start();
include 'koneksi.php';

// Proteksi Login
if (!isset($_SESSION['admin_user'])) {
    header("Location: login.php");
    exit();
}

// --- PROSES UPDATE STATUS ---
if (isset($_POST['status']) && isset($_POST['id_aspirasi'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id_aspirasi']);
    $status_baru = mysqli_real_escape_string($conn, $_POST['status']);

    $query_update = "UPDATE aspirasi SET status = '$status_baru' WHERE id_aspirasi = '$id'";
    if (mysqli_query($conn, $query_update)) {
        header("Location: data_aspirasi.php?msg=success");
        exit;
    }
}

// Query untuk data yang BELUM selesai (Aktif)
$sql_aktif = "SELECT aspirasi.*, kategori.ket_kategori 
              FROM aspirasi 
              LEFT JOIN kategori ON aspirasi.id_kategori = kategori.id_kategori 
              WHERE status != 'selesai'
              ORDER BY aspirasi.id_aspirasi DESC";

// Query untuk data yang SUDAH selesai (Arsip)
$sql_selesai = "SELECT aspirasi.*, kategori.ket_kategori 
                FROM aspirasi 
                LEFT JOIN kategori ON aspirasi.id_kategori = kategori.id_kategori 
                WHERE status = 'selesai'
                ORDER BY aspirasi.id_aspirasi DESC";

$data_aktif = mysqli_query($conn, $sql_aktif);
$data_selesai = mysqli_query($conn, $sql_selesai);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASIKA | Data Aspirasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Quicksand', sans-serif; background: linear-gradient(135deg, #fdf2f8 0%, #f5f3ff 50%, #eff6ff 100%); }
        .glass-card { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(15px); border-radius: 1.5rem; border: 1px solid white; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05); }
        th { background-color: #0f172a !important; color: #fff !important; text-transform: uppercase; font-size: 10px; padding: 20px 15px; text-align: center !important; }
    </style>
</head>
<body class="min-h-screen pb-10">

    <nav class="bg-white/60 backdrop-blur-md px-6 md:px-12 py-4 flex justify-between items-center shadow-sm sticky top-0 z-50">
        <div class="flex items-center gap-3">
            <span class="text-slate-800 text-xl md:text-2xl font-bold">ASIKA</span>
        </div>
        <a href="menu_admin.php" class="bg-slate-800 text-white px-5 py-2 rounded-xl text-xs font-bold hover:bg-slate-700 transition">← KEMBALI</a>
    </nav>

    <main class="p-4 md:p-10 max-w-7xl mx-auto">
        
        <header class="mb-6">
            <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-2">
                <span class="w-2 h-8 bg-indigo-600 rounded-full"></span>
                Aspirasi Perlu Tindakan
            </h1>
        </header>

        <div class="glass-card overflow-hidden mb-16">
            <div class="overflow-x-auto">
                <table class="w-full text-center border-collapse min-w-[1000px]">
                    <thead>
                        <tr>
                            <th class="w-12">NO</th>
                            <th>NISN</th>
                            <th>KATEGORI</th> <th>TANGGAL</th>
                            <th>LOKASI</th>
                            <th class="w-1/4">DESKRIPSI</th>
                            <th>STATUS</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="text-slate-600 text-sm bg-white/30">
                        <?php $no = 1; while($d = mysqli_fetch_array($data_aktif)) { ?>
                        <tr class="hover:bg-white/60 border-b border-gray-100 transition-all">
                            <td class="p-5 font-bold"><?php echo $no++; ?></td>
                            <td class="p-5 text-indigo-600 font-bold">#<?php echo $d['nisn']; ?></td>
                            <td class="p-5">
                                <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-[10px] font-bold uppercase">
                                    <?php echo $d['ket_kategori'] ?? 'Umum'; ?>
                                </span>
                            </td>
                            <td class="p-5 text-[11px]"><?php echo date('d/m/Y H:i', strtotime($d['tanggal_input'])); ?></td>
                            <td class="p-5 font-medium"><?php echo $d['lokasi']; ?></td>
                            <td class="p-5 italic text-xs px-10">"<?php echo substr($d['deskripsi'], 0, 100); ?>..."</td>
                            <td class="p-5">
                                <form action="" method="POST">
                                    <input type="hidden" name="id_aspirasi" value="<?php echo $d['id_aspirasi']; ?>">
                                    <select name="status" onchange="this.form.submit()" 
                                        class="text-[10px] font-bold uppercase py-2 px-3 rounded-xl border-none shadow-sm cursor-pointer <?php echo ($d['status'] == 'proses') ? 'bg-blue-100 text-blue-600' : 'bg-amber-100 text-amber-600'; ?>">
                                        <option value="menunggu" <?php if($d['status'] == 'menunggu') echo 'selected'; ?>>Menunggu</option>
                                        <option value="proses" <?php if($d['status'] == 'proses') echo 'selected'; ?>>Proses</option>
                                        <option value="selesai">Selesaikan</option>
                                    </select>
                                </form>
                            </td>
                            <td class="p-5">
                                <a href="formulir_feedback.php?id=<?php echo $d['id_aspirasi']; ?>" 
                                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl text-[10px] font-bold shadow-md transition-all">
                                    TANGGAPI
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <header class="mb-6">
            <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-2">
                <span class="w-2 h-8 bg-emerald-500 rounded-full"></span>
                Arsip Selesai
            </h1>
        </header>

        <div class="glass-card overflow-hidden opacity-80">
            <div class="overflow-x-auto">
                <table class="w-full text-center border-collapse min-w-[1000px]">
                    <thead>
                        <tr class="opacity-70">
                            <th class="w-12">NO</th>
                            <th>NISN</th>
                            <th>KATEGORI</th> <th>TANGGAL</th>
                            <th>LOKASI</th>
                            <th class="w-1/4">DESKRIPSI</th>
                            <th>STATUS</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="text-slate-500 text-sm bg-gray-50/50">
                        <?php $no_s = 1; while($ds = mysqli_fetch_array($data_selesai)) { ?>
                        <tr class="border-b border-gray-100">
                            <td class="p-5"><?php echo $no_s++; ?></td>
                            <td class="p-5 font-bold">#<?php echo $ds['nisn']; ?></td>
                            <td class="p-5">
                                <span class="bg-gray-200 text-gray-600 px-3 py-1 rounded-full text-[10px] font-bold uppercase">
                                    <?php echo $ds['ket_kategori'] ?? 'Umum'; ?>
                                </span>
                            </td>
                            <td class="p-5 text-[11px]"><?php echo date('d/m/Y', strtotime($ds['tanggal_input'])); ?></td>
                            <td class="p-5"><?php echo $ds['lokasi']; ?></td>
                            <td class="p-5 italic text-xs px-10">"<?php echo substr($ds['deskripsi'], 0, 80); ?>..."</td>
                            <td class="p-5">
                                <span class="bg-emerald-100 text-emerald-600 text-[10px] font-bold uppercase py-2 px-4 rounded-xl">
                                    SELESAI
                                </span>
                            </td>
                            <td class="p-5">
                                <button disabled class="bg-gray-300 text-gray-500 px-5 py-2.5 rounded-xl text-[10px] font-bold cursor-not-allowed">
                                    TERKUNCI
                                </button>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <?php if(isset($_GET['msg']) && $_GET['msg'] == 'success'): ?>
    <div id="toast" class="fixed bottom-5 right-5 bg-emerald-500 text-white px-6 py-3 rounded-2xl shadow-2xl text-sm font-bold">
        ✓ Status diperbarui & Dipindahkan ke Arsip
    </div>
    <script>setTimeout(() => { document.getElementById('toast').remove(); }, 3000);</script>
    <?php endif; ?>

</body>
</html>