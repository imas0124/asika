<?php 
include 'koneksi.php'; 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/ico" href="img/logoo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>ASIKA - Riwayat</title>
    <style>
        * { box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        body { 
            background: linear-gradient(to right, #fbc2eb 0%, #a6c1ee 100%); 
            margin: 0; 
            padding: 20px 10px; 
            min-height: 100vh; 
        }

        .container { 
            background-color: white; 
            width: 100%; 
            max-width: 1200px; 
            padding: 25px; 
            border-radius: 25px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            margin: auto;
        }

        h2 { color: #6a5acd; text-align: center; margin-bottom: 25px; font-size: 26px; }

        .btn-kembali { 
            display: inline-block; 
            background: linear-gradient(to right, #fbc2eb, #a6c1ee); 
            color: white; 
            padding: 10px 20px; 
            border-radius: 20px; 
            text-decoration: none; 
            font-weight: bold; 
            margin-bottom: 20px; 
            font-size: 14px;
        }

        /* TABEL DESKTOP */
        .table-wrapper { border-radius: 15px; overflow: hidden; border: 1px solid #eee; }
        table { width: 100%; border-collapse: collapse; }
        thead th { background-color: #333; color: white; padding: 15px 10px; text-transform: uppercase; font-size: 12px; }
        td { padding: 15px 10px; border-bottom: 1px solid #f2f2f2; text-align: center; font-size: 14px; color: #444; }

        /* STATUS BADGE */
        .status-badge { padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: bold; text-transform: uppercase; display: inline-block; }
        .status-menunggu { background: #ffeaa7; color: #d35400; }
        .status-proses { background: #81ecec; color: #0097e6; }
        .status-selesai { background: #55efc4; color: #00b894; }

        .btn-lihat { background-color: #00d2ff; color: white; padding: 8px 15px; border-radius: 8px; text-decoration: none; font-size: 12px; font-weight: bold; display: inline-block; }

        /* --- MAGIC HAPPENS HERE: RESPONSIVE HP --- */
        @media screen and (max-width: 768px) {
            /* Sembunyikan Header Tabel Asli */
            thead { display: none; }

            /* Ubah setiap baris (TR) jadi sebuah Kotak/Card */
            tr { 
                display: block; 
                margin-bottom: 20px; 
                border: 2px solid #6a5acd22; 
                border-radius: 15px; 
                background: #fff;
                overflow: hidden;
                box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            }

            /* Ubah setiap kolom (TD) jadi baris di dalam kartu */
            td { 
                display: flex; 
                justify-content: space-between; 
                align-items: center; 
                text-align: right; 
                border-bottom: 1px solid #eee; 
                padding: 12px 15px;
            }

            td:last-child { border-bottom: none; background: #f9f9f9; justify-content: center; }

            /* Munculkan label di sisi kiri menggunakan atribut data-label */
            td::before {
                content: attr(data-label);
                font-weight: bold;
                color: #6a5acd;
                text-align: left;
                flex: 1;
                font-size: 12px;
            }

            .btn-lihat { width: 100%; text-align: center; padding: 12px; }
            h2 { font-size: 22px; }
        }
    </style>
</head>
<body>

<div class="container">
    <a href="menu_siswa.php" class="btn-kembali">← Kembali</a>
    
    <h2>Riwayat Pengaduan</h2>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>NO</th>
                    <th>ID</th>
                    <th>TANGGAL</th>
                    <th>NISN</th>
                    <th>ISI LAPORAN</th>
                    <th>STATUS</th>
                    <th>OPSI</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $sql = "SELECT * FROM aspirasi ORDER BY tanggal_input DESC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $st = strtolower($row['status']);
                        $class = ($st == 'selesai') ? 'status-selesai' : (($st == 'proses') ? 'status-proses' : 'status-menunggu');
                ?>
                <tr>
                    <td data-label="NO"><?= $no++; ?></td>
                    <td data-label="ID"><?= $row['id_aspirasi']; ?></td>
                    <td data-label="TANGGAL"><?= date('d/m/Y', strtotime($row['tanggal_input'])); ?></td>
                    <td data-label="NISN"><?= $row['nisn']; ?></td>
                    <td data-label="ISI LAPORAN" style="text-align: right;"><?= $row['deskripsi']; ?></td>
                    <td data-label="STATUS">
                        <span class="status-badge <?= $class; ?>"><?= $row['status']; ?></span>
                    </td>
                    <td data-label="">
                        <a href="menu_feedback_siswa.php?id=<?= $row['id_aspirasi']; ?>" class="btn-lihat">Lihat Feedback</a>
                    </td>
                </tr>
                <?php 
                    }
                } else {
                    echo "<tr><td colspan='7'>Belum ada data.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>