<?php
session_start();
include 'koneksi.php';

// Proteksi Login
if (!isset($_SESSION['admin_user'])) {
    header("Location: login.php");
    exit();
}

// Ambil ID Aspirasi dari URL
$id_asp_otomatis = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_feedback      = mysqli_real_escape_string($conn, $_POST['id_feedback']); 
    $id_aspirasi      = mysqli_real_escape_string($conn, $_POST['id_aspirasi']);
    $id_admin         = mysqli_real_escape_string($conn, $_POST['id_admin']);
    $pesan            = mysqli_real_escape_string($conn, $_POST['pesan']);
    $tanggal_feedback = date('Y-m-d H:i:s');

    // Query simpan ke tabel feedback
    $query = "INSERT INTO feedback (id_feedback, id_aspirasi, id_admin, pesan, tanggal_feedback) 
              VALUES ('$id_feedback', '$id_aspirasi', '$id_admin', '$pesan', '$tanggal_feedback')";

    if (mysqli_query($conn, $query)) {
        // Otomatis update status aspirasi menjadi selesai
        mysqli_query($conn, "UPDATE aspirasi SET status='selesai' WHERE id_aspirasi='$id_aspirasi'");
        
        echo "<script>alert('Tanggapan Berhasil Dikirim! Status Laporan menjadi SELESAI.'); window.location.href='menu_feedback_admin.php';</script>";
    } else {
        echo "<script>alert('Gagal! Periksa apakah ID Tanggapan sudah digunakan.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/ico" href="img/logoo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASIKA | Kirim Tanggapan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Quicksand', sans-serif; 
            background: linear-gradient(135deg, #fdf2f8 0%, #f5f3ff 50%, #eff6ff 100%); 
            min-height: 100vh;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            border-radius: 2rem;
            border: 1px solid white;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="flex items-center justify-center p-4 md:p-10">

    <div class="w-full max-w-lg glass-card p-8 md:p-12">
        <header class="text-center mb-8">
            <div class="inline-block p-3 bg-indigo-100 rounded-2xl mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#4f46e5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
            </div>
            <h1 class="text-2xl font-bold text-slate-800">Kirim Tanggapan</h1>
            <p class="text-slate-500 text-xs mt-1">Berikan solusi atau informasi terkait aspirasi #<?php echo $id_asp_otomatis; ?></p>
        </header>

        <form action="" method="POST" class="space-y-6">
            <input type="hidden" name="id_aspirasi" value="<?php echo $id_asp_otomatis; ?>">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 mb-2 uppercase tracking-widest pl-1">ID Tanggapan</label>
                    <input type="number" name="id_feedback" 
                           class="w-full p-4 rounded-2xl bg-white/50 border border-slate-100 outline-none focus:ring-2 focus:ring-indigo-400 focus:bg-white transition-all text-sm font-semibold" 
                           placeholder="Cth: 101" required>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 mb-2 uppercase tracking-widest pl-1">ID Petugas (Anda)</label>
                    <input type="number" name="id_admin" 
                           class="w-full p-4 rounded-2xl bg-white/50 border border-slate-100 outline-none focus:ring-2 focus:ring-indigo-400 focus:bg-white transition-all text-sm font-semibold" 
                           placeholder="Masukkan ID" required>
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-slate-400 mb-2 uppercase tracking-widest pl-1">Isi Pesan Balasan</label>
                <textarea name="pesan" rows="5" 
                          class="w-full p-4 rounded-2xl bg-white/50 border border-slate-100 outline-none focus:ring-2 focus:ring-indigo-400 focus:bg-white transition-all text-sm leading-relaxed" 
                          placeholder="Tuliskan tanggapan atau instruksi untuk siswa..." required></textarea>
            </div>

            <button type="submit" 
                    class="w-full py-4 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 active:scale-[0.98] uppercase text-xs tracking-widest">
                Kirim Tanggapan Sekarang
            </button>
            
            <div class="pt-4 text-center">
                <a href="data_aspirasi.php" class="text-slate-400 font-bold hover:text-indigo-600 transition text-[11px] uppercase tracking-widest flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    Batal & Kembali
                </a>
            </div>
        </form>
    </div>

</body>
</html>