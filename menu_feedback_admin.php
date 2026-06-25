<?php
session_start();
include 'koneksi.php';

// 1. PROTEKSI HALAMAN
if (!isset($_SESSION['admin_user'])) {
    header("Location: login.php");
    exit();
}

// 2. QUERY TAMPIL DATA
$query = "SELECT feedback.*, aspirasi.nisn, aspirasi.status
          FROM feedback 
          INNER JOIN aspirasi ON feedback.id_aspirasi = aspirasi.id_aspirasi 
          ORDER BY feedback.id_feedback DESC";

$sql = mysqli_query($conn, $query);
$no = 1;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/ico" href="img/logoo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASIKA - Riwayat Tanggapan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background: linear-gradient(135deg, #fbc2eb 0%, #a6c1ee 100%);
            min-height: 100vh;
        }
        .glass-card { 
            background: rgba(255, 255, 255, 0.85); 
            backdrop-filter: blur(15px);
            border-radius: 30px; 
            box-shadow: 0 15px 35px rgba(0,0,0,0.05); 
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        th { 
            background: #e0c3fc !important; 
            color: #6a5acd !important; 
            text-transform: uppercase; 
            font-size: 10px; 
            font-weight: 700;
            padding: 20px 15px; 
            white-space: nowrap;
            letter-spacing: 1px;
        }
        tr:hover {
            background-color: rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body class="p-4 md:p-10 flex flex-col items-center">

    <header class="text-center mb-10">
        <h1 class="text-3xl md:text-4xl font-bold text-white drop-shadow-lg">Riwayat Tanggapan</h1>
        <p class="text-white/90 text-xs md:text-sm mt-2 italic font-medium">Data Balasan Admin ASIKA</p>
    </header>

    <div class="w-full max-w-7xl glass-card overflow-hidden mb-8">
        <div class="overflow-x-auto">
            <table class="w-full text-center border-collapse min-w-[900px]">
                <thead>
                    <tr>
                        <th class="rounded-tl-[30px] w-16">NO</th>
                        <th>NISN</th> 
                        <th>ID ASPIRASI</th> 
                        <th>TANGGAL</th>
                        <th>ADMIN</th>
                        <th class="text-left w-1/3">PESAN BALASAN</th>
                        <th class="rounded-tr-[30px]">STATUS</th>
                    </tr>
                </thead>
                <tbody class="text-slate-600">
                    <?php 
                    if (mysqli_num_rows($sql) > 0) {
                        while($row = mysqli_fetch_array($sql)) { 
                    ?>
                        <tr class="transition-colors border-b border-purple-50 last:border-0">
                            <td class="p-5 font-bold text-sm text-purple-400"><?php echo $no++; ?></td>
                            <td class="p-5 font-bold text-pink-500 text-sm">#<?php echo $row['nisn']; ?></td>
                            <td class="p-5">
                                <span class="bg-indigo-50 text-indigo-400 px-3 py-1 rounded-full text-[10px] font-bold border border-indigo-100">
                                    ASP-<?php echo $row['id_aspirasi']; ?>
                                </span>
                            </td>
                            <td class="p-5 text-[11px] text-slate-400">
                                <?php echo date('d M Y', strtotime($row['tanggal_feedback'])); ?>
                            </td>
                            <td class="p-5 font-semibold text-xs text-indigo-500 uppercase">
                                <?php echo htmlspecialchars($row['id_admin']); ?>
                            </td>
                            <td class="p-5 italic text-xs text-slate-500 leading-relaxed text-left">
                                "<?php echo htmlspecialchars($row['pesan']); ?>"
                            </td>
                            <td class="p-5">
                                <span class="bg-emerald-100 text-emerald-600 px-4 py-1.5 rounded-full text-[9px] font-bold uppercase tracking-wider border border-emerald-200 shadow-sm">
                                    <?php echo htmlspecialchars($row['status']); ?>
                                </span>
                            </td>
                        </tr>
                    <?php 
                        } 
                    } else { 
                    ?>
                        <tr><td colspan="7" class="p-20 text-slate-400 italic text-center text-lg">Belum ada riwayat tanggapan.</td></tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <a href="menu_admin.php" class="flex items-center gap-2 text-pink-400 bg-white hover:text-pink-500 px-8 py-3 rounded-full shadow-md font-bold transition-all text-xs tracking-widest uppercase active:scale-95">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        Kembali ke Beranda
    </a>

</body>
</html>