<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/ico" href="img/logoo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASIKA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Quicksand', sans-serif; 
            background: linear-gradient(135deg, #fdf2f8 0%, #f5f3ff 50%, #eff6ff 100%); 
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(15px);
            border-radius: 2.5rem;
            border: 1px solid white;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
        }
        th { 
            /* Header hitam pekat sesuai style tabel admin kamu */
            background-color: #6366f1 !important; 
            color: #fff !important; 
            text-transform: uppercase; 
            font-size: 11px; 
            letter-spacing: 1px;
            padding: 20px;
        }
    </style>
</head>
<body class="min-h-screen p-6 md:p-12 flex flex-col items-center justify-center">

    <header class="text-center mb-10">
        <h1 class="text-4xl font-bold text-slate-800 tracking-tight">Tanggapan Petugas</h1>
        <p class="text-indigo-500 mt-2 font-medium italic italic">Berikut adalah detail respon dari petugas untuk laporanmu.</p>
    </header>

    <div class="w-full max-w-6xl glass-card overflow-hidden mb-10">
        <div class="overflow-x-auto">
            <table class="w-full text-center border-collapse">
                <thead>
                    <tr>
                        <th class="border-r border-gray-800">NO</th>
                        <th class="border-r border-gray-800">ID ASPIRASI</th>
                        <th class="border-r border-gray-800">NISN</th>
                        <th class="border-r border-gray-800">ID KATEGORI</th>
                        <th class="border-r border-gray-800">LOKASI</th>
                        <th class="border-r border-gray-800 w-1/4">DESKRIPSI</th>
                        <th class="border-r border-gray-800">STATUS</th>
                        <th>TANGGAL INPUT</th>
                    </tr>
                </thead>
                <tbody class="text-slate-600">
                    <tr>
                        <td colspan="8" class="p-32 text-center">
                            <div class="flex flex-col items-center gap-4 text-slate-300">
                                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                </svg>
                                <p class="italic text-lg font-medium">Belum ada tanggapan yang bisa ditampilkan...</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="text-center">
        <a href="riwayat_aspirasi_siswa.php" class="bg-indigo-600 hover:bg-indigo-700 text-white px-10 py-3 rounded-2xl font-bold shadow-lg transition-all active:scale-95 flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            KEMBALI KE RIWAYAT
        </a>
    </div>

</body>
</html>