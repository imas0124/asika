<?php
session_start(); // Memulai sesi agar bisa menghapusnya

// Menghapus semua data session
session_unset();
session_destroy();

// Mengarahkan kembali ke halaman login
echo "<script>
    alert('Anda telah berhasil logout.');
    window.location.href = 'siswa.php';
</script>";
exit();
?>