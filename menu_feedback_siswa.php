<?php
session_start();
include 'koneksi.php';

$user_level = 'siswa';
$id_aspirasi = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';

$link_kembali = "riwayat_aspirasi_siswa.php";
$label_kembali = "KEMBALI KE RIWAYAT SAYA";

$query = "SELECT feedback.*, aspirasi.nisn 
          FROM feedback 
          INNER JOIN aspirasi ON feedback.id_aspirasi = aspirasi.id_aspirasi 
          WHERE feedback.id_aspirasi = '$id_aspirasi'
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
    <title>ASIKA - Tanggapan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background: linear-gradient(to right, #fbc2eb 0%, #a6c1ee 100%); 
            min-height: 100vh;
        }
        .glass-card { 
            background: rgba(255, 255, 255, 0.8); 
            border-radius: 30px; 
            box-shadow: 0 15px 35px rgba(0,0,0,0.05); 
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        /* Header Tabel Tetap Soft tapi Tegas */
        th { 
            background-color: rgba(106, 90, 205, 0.1) !important; 
            color: #6a4fa3 !important; 
            text-transform: uppercase; 
            font-size: 10px; 
            padding: 20px 15px;
            white-space: nowrap;
            border-bottom: 2px solid #fbc2eb;
        }

        /* Perbaikan untuk HP */
        @media (max-width: 768px) {
            .glass-card { border-radius: 15px; }
            th, td { padding: 12px 10px !important; font-size: 11px !important; }
            .isi-pesan { min-width: 200px; text-align: left !important; }
            h1 { font-size: 1.5rem !important; margin-bottom: 1.5rem !important; }
        }
    </style>
</head>
<body class="p-4 md:p-8 flex flex-col items-center">

    <h1 class="text-3xl md:text-4xl font-bold text-white mb-8 mt-4 text-center drop-shadow-md">Tanggapan Petugas</h1>

    <div class="w-full max-w-7xl glass-card overflow-hidden mb-10">
        <div class="overflow-x-auto">
            <table class="w-full text-center border-collapse">
                <thead>
                    <tr>
                        <th class="rounded-tl-[30px] md:rounded-tl-[40px]">NO</th>
                        <th>NISN</th> 
                        <th>ID Aspirasi</th> 
                        <th>ID Tanggapan</th>
                        <th>Tanggal Balasan</th>
                        <th>Petugas</th>
                        <th class="w-1/3">Isi Tanggapan</th>
                        <th class="rounded-tr-[30px] md:rounded-tr-[40px]">STATUS</th>
                    </tr>
                </thead>
                <tbody class="text-slate-600">
                    <?php 
                    if (mysqli_num_rows($sql) > 0) {
                        while($row = mysqli_fetch_array($sql)) { 
                    ?>
                        <tr class="hover:bg-white/50 transition-colors border-b border-gray-100 last:border-0">
                            <td class="p-4 md:p-8 font-bold"><?php echo $no++; ?></td>
                            <td class="p-4 md:p-8 font-bold text-pink-500">#<?php echo $row['nisn']; ?></td>
                            <td class="p-4 md:p-8">
                                <span class="bg-purple-100 text-purple-600 px-3 py-1 rounded-full text-[10px] font-bold">ID: <?php echo $row['id_aspirasi']; ?></span>
                            </td>
                            <td class="p-4 md:p-8 font-semibold"><?php echo $row['id_feedback']; ?></td>
                            <td class="p-4 md:p-8 text-[10px] text-gray-400"><?php echo $row['tanggal_feedback']; ?></td>
                            <td class="p-4 md:p-8 font-semibold text-slate-800"><?php echo $row['id_admin']; ?></td>
                            <td class="p-4 md:p-8 italic text-xs md:text-sm text-gray-500 isi-pesan">
                                "<?php echo $row['pesan']; ?>"
                            </td>
                            <td class="p-4 md:p-8">
                                <span class="bg-green-100 text-green-600 px-3 py-1 md:px-4 md:py-2 rounded-full text-[9px] md:text-[10px] font-bold uppercase tracking-widest">
                                    Diterima
                                </span>
                            </td>
                        </tr>
                    <?php 
                        } 
                    } else { 
                    ?>
                        <tr>
                            <td colspan="8" class="p-20 text-gray-400 italic text-lg">Belum ada balasan dari petugas.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <a href="<?php echo $link_kembali; ?>" class="text-white bg-purple-500/50 hover:bg-purple-500 px-6 py-2 rounded-full font-bold flex items-center gap-2 transition-all duration-300 uppercase tracking-widest text-sm mb-10 shadow-lg">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        <?php echo $label_kembali; ?>
    </a>

</body>
</html>