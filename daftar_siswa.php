<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nisn     = mysqli_real_escape_string($conn, $_POST['nisn']);
    $nama     = mysqli_real_escape_string($conn, $_POST['nama']);
    $jk       = mysqli_real_escape_string($conn, $_POST['jk']); 
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $no_hp    = mysqli_real_escape_string($conn, $_POST['no_hp']);

    $sql = "INSERT INTO siswa (nisn, nama, jk, password, no_hp) 
            VALUES ('$nisn', '$nama', '$jk', '$password', '$no_hp')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Pendaftaran Siswa Berhasil!'); window.location='siswa.php';</script>";
    } else {
        echo "<script>alert('Gagal: " . $conn->error . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/ico" href="img/logoo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASIKA - Registrasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Quicksand', sans-serif; 
            background: linear-gradient(135deg, #fbc2eb 0%, #a6c1ee 100%); 
        }
        .daftar-box { 
            background: rgba(255, 255, 255, 0.9); 
            backdrop-filter: blur(10px);
            border-radius: 30px; 
            box-shadow: 0 20px 40px rgba(0,0,0,0.1); 
        }
        input, select { 
            background-color: #f8f0ff; 
            outline: none; 
            transition: all 0.3s ease; 
            border: 2px solid transparent;
        }
        input:focus, select:focus { 
            border-color: #cdb4ff;
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(205, 180, 255, 0.3);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 md:p-8">

    <div class="daftar-box w-full max-w-md p-8 md:p-10 mx-auto">
        <div class="text-center mb-8">
            <img src="img/logoo.png" alt="Logo" class="h-16 mx-auto mb-3">
            <h2 class="text-2xl font-extrabold text-[#6a4c93]">Registrasi Siswa</h2>
            <p class="text-gray-500 text-sm mt-1">Lengkapi data untuk membuat akun</p>
        </div>

        <form action="" method="POST" class="space-y-4">
            <div>
                <label class="text-xs font-bold text-[#6a4c93] uppercase tracking-wider ml-4">NISN</label>
                <input type="text" name="nisn" placeholder="Masukkan 10 digit NISN" 
                       class="w-full p-3.5 rounded-2xl mt-1 text-sm border-none shadow-sm" required>
            </div>

            <div>
                <label class="text-xs font-bold text-[#6a4c93] uppercase tracking-wider ml-4">Nama Lengkap</label>
                <input type="text" name="nama" placeholder="Nama lengkap sesuai raport" 
                       class="w-full p-3.5 rounded-2xl mt-1 text-sm border-none shadow-sm" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-bold text-[#6a4c93] uppercase tracking-wider ml-4">Jenis Kelamin</label>
                    <select name="jk" class="w-full p-3.5 rounded-2xl mt-1 text-sm border-none shadow-sm cursor-pointer" required>
                        <option value="" disabled selected>Pilih</option>
                        <option value="laki - laki">Laki-laki</option>
                        <option value="perempuan">Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-bold text-[#6a4c93] uppercase tracking-wider ml-4">No HP</label>
                    <input type="tel" name="no_hp" placeholder="08..." 
                           class="w-full p-3.5 rounded-2xl mt-1 text-sm border-none shadow-sm" required>
                </div>
            </div>

            <div>
                <label class="text-xs font-bold text-[#6a4c93] uppercase tracking-wider ml-4">Password</label>
                <input type="password" name="password" placeholder="Buat password aman" 
                       class="w-full p-3.5 rounded-2xl mt-1 text-sm border-none shadow-sm" required>
            </div>

            <button type="submit" class="w-full py-4 mt-4 bg-gradient-to-r from-[#f4b6d8] to-[#cdb4ff] text-white font-bold rounded-2xl hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 shadow-md">
                DAFTAR SEKARANG
            </button>
        </form>

        <div class="text-center mt-8 pt-6 border-t border-gray-100">
            <p class="text-sm text-gray-500">
                Sudah punya akun? <a href="siswa.php" class="text-[#6a4c93] font-bold hover:underline">Login di sini</a>
            </p>
        </div>
    </div>

</body>
</html>