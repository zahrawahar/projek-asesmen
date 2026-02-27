<?php
session_start();
include 'koneksi.php';

date_default_timezone_set('Asia/Makassar');

// 1. PROTEKSI HALAMAN & FIX UNDEFINED INDEX id_user
if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit;
}

// Mengambil ID user dengan aman (menangani error Undefined Index)
$id_user = $_SESSION['id'] ?? $_SESSION['id_user'] ?? 0;

// 2. LOGIKA TANGGAL
$tgl_pilih = isset($_GET['tgl']) ? $_GET['tgl'] : date('Y-m-d');

// Fungsi format tanggal Indonesia
function tgl_indo($tanggal)
{
    $bulan = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
    $pecahkan = explode('-', $tanggal);
    $hari = date('D', strtotime($tanggal));
    $list_hari = array('Sun' => 'Minggu', 'Mon' => 'Senin', 'Tue' => 'Selasa', 'Wed' => 'Rabu', 'Thu' => 'Kamis', 'Fri' => 'Jumat', 'Sat' => 'Sabtu');
    return $list_hari[$hari] . ', ' . $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}

// 3. QUERY DATA ABSEN (Hanya yang tidak hadir)
$query = "SELECT s.nama, a.status 
          FROM absensi a 
          JOIN siswas s ON a.id_siswa = s.id 
          WHERE a.id_walikelas = '$id_user' 
          AND a.tanggal = '$tgl_pilih' 
          AND a.status != 'hadir'";
$result = mysqli_query($conn, $query);
$jumlah_tidak_hadir = mysqli_num_rows($result);

$waktu_teks = tgl_indo($tgl_pilih);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Absensi | E-Absen</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #064e3b;
            --primary-light: #065f46;
            --accent: #10b981;
            --gold: #fbbf24;
            --danger: #ef4444;
            --bg-body: #f8fafc;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-body);
            padding: 40px 20px;
            color: #1e293b;
            margin: 0;
        }

        .container {
            max-width: 650px;
            margin: auto;
            background: white;
            padding: 40px;
            border-radius: 40px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
            border: 1px solid #f1f5f9;
        }

        .header {
            text-align: center;
            margin-bottom: 35px;
        }

        .header h2 {
            color: var(--primary);
            font-weight: 800;
            font-size: 1.8rem;
            margin-bottom: 5px;
        }

        .header p {
            font-weight: 600;
            color: #64748b;
            background: #f1f5f9;
            display: inline-block;
            padding: 8px 20px;
            border-radius: 12px;
        }

        .status-box {
            padding: 20px 25px;
            border-radius: 20px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: 0.3s;
        }

        /* Skema Warna Status */
        .sakit {
            background: #fef9c3;
            color: #854d0e;
            border-left: 6px solid var(--gold);
        }

        .izin {
            background: #eff6ff;
            color: #1e40af;
            border-left: 6px solid #3b82f6;
        }

        .alfa {
            background: #fef2f2;
            color: #991b1b;
            border-left: 6px solid var(--danger);
        }

        .hadir-semua {
            background: #ecfdf5;
            color: #065f46;
            padding: 40px;
            border-radius: 30px;
            text-align: center;
            border: 2px dashed var(--accent);
        }

        .btn-group {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 40px;
        }

        .btn {
            text-decoration: none;
            background: var(--primary);
            color: white;
            padding: 15px 30px;
            border-radius: 18px;
            font-weight: 700;
            font-size: 0.95rem;
            border: none;
            cursor: pointer;
            transition: 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-secondary {
            background: #64748b;
        }

        .btn:hover {
            transform: translateY(-3px);
            opacity: 0.9;
        }

        @media print {
            .btn-group {
                display: none;
            }

            body {
                background: white;
                padding: 0;
            }

            .container {
                box-shadow: none;
                border: none;
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <i class="fas fa-clipboard-list" style="font-size: 3rem; color: var(--gold); margin-bottom: 15px;"></i>
            <h2>Laporan Hasil Absensi</h2>
            <p><i class="far fa-calendar-alt"></i> <?= $waktu_teks; ?></p>
        </div>

        <?php if ($jumlah_tidak_hadir > 0): ?>
            <p style="font-weight: 800; color: #475569; margin-bottom: 20px; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px;">
                Daftar Siswa Tidak Hadir:
            </p>

            <?php
            mysqli_data_seek($result, 0);
            while ($row = mysqli_fetch_assoc($result)):
                $status_key = strtolower($row['status']);
                // Handle jika pembina input "Alfa" tapi CSS kita "alpa" atau sebaliknya
                if ($status_key == 'alpa') $status_key = 'alfa';
            ?>
                <div class="status-box <?= $status_key; ?>">
                    <span style="font-size: 1.1rem;"><strong><?= htmlspecialchars($row['nama']); ?></strong></span>
                    <span style="font-size: 0.85rem; text-transform: uppercase; font-weight: 800; letter-spacing: 1px;">
                        <i class="fas fa-info-circle"></i> <?= $row['status']; ?>
                    </span>
                </div>
            <?php endwhile; ?>

        <?php else: ?>
            <div class="hadir-semua">
                <i class="fas fa-check-circle" style="font-size: 3.5rem; margin-bottom: 15px;"></i>
                <h3 style="margin:0; font-size: 1.5rem; font-weight: 800;">Alhamdulillah</h3>
                <p style="margin:10px 0 0; font-weight: 600; opacity: 0.8;">Seluruh siswa hadir lengkap hari ini.</p>
            </div>
        <?php endif; ?>

        <div class="btn-group">
            <a href="walikelas.php" class="btn">
                <i class="fas fa-home"></i> Kembali
            </a>
            <button onclick="window.print()" class="btn btn-secondary">
                <i class="fas fa-print"></i> Cetak Laporan
            </button>
        </div>
    </div>

</body>

</html>