<?php
session_start();
include 'koneksi.php';

date_default_timezone_set('Asia/Makassar');

// 1. PROTEKSI HALAMAN
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'pembina') {
    header("Location: login.php");
    exit;
}

// Fungsi Tanggal Indonesia
function tgl_indo($tanggal)
{
    $bulan = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    $num_hari = date('w', strtotime($tanggal));
    $split = explode('-', $tanggal);
    return $hari[$num_hari] . ', ' . $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];
}

// 2. LOGIKA KIRIM LAPORAN
if (isset($_POST['kirim_laporan'])) {
    $tgl = date('Y-m-d');
    $nama_input = mysqli_real_escape_string($conn, $_POST['nama_siswa']);
    $status = $_POST['status'];
    $ket = mysqli_real_escape_string($conn, $_POST['keterangan']);

    $cari_siswa = mysqli_query($conn, "SELECT id FROM siswas WHERE nama = '$nama_input' LIMIT 1");
    if ($data_siswa = mysqli_fetch_assoc($cari_siswa)) {
        $id_siswa = $data_siswa['id'];

        $cek = mysqli_query($conn, "SELECT id FROM absensi WHERE id_siswa = '$id_siswa' AND tanggal = '$tgl'");
        if (mysqli_num_rows($cek) > 0) {
            $q = "UPDATE absensi SET status = '$status', keterangan = '$ket' WHERE id_siswa = '$id_siswa' AND tanggal = '$tgl'";
        } else {
            $q = "INSERT INTO absensi (id_siswa, tanggal, status, keterangan) VALUES ('$id_siswa', '$tgl', '$status', '$ket')";
        }
        mysqli_query($conn, $q);
    }
    header("Location: pembina.php");
    exit;
}

// Fitur Hapus
if (isset($_GET['hapus'])) {
    $id_hapus = mysqli_real_escape_string($conn, $_GET['hapus']);
    mysqli_query($conn, "DELETE FROM absensi WHERE id = '$id_hapus'");
    header("Location: pembina.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Absen | Pembina Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #064e3b;
            --accent: #10b981;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f8fafc;
            margin: 0;
            color: #1e293b;
        }

        .hero {
            background: linear-gradient(135deg, #064e3b 0%, #065f46 100%);
            height: 320px;
            border-radius: 0 0 60px 60px;
            padding: 40px 20px;
            color: white;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .welcome-text h2 {
            font-size: 2rem;
            font-weight: 800;
            margin: 0;
        }

        .welcome-text p {
            opacity: 0.9;
            font-size: 1rem;
            margin: 5px 0 0;
        }

        .main-wrapper {
            margin-top: -100px;
            padding: 0 20px 50px;
        }

        .glass-card {
            background: white;
            border-radius: 35px;
            padding: 35px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
            margin-bottom: 40px;
            border: 1px solid #f1f5f9;
        }

        .form-row {
            display: grid;
            grid-template-columns: 2fr 1fr 1.5fr auto;
            gap: 15px;
            align-items: end;
        }

        .input-box label {
            display: block;
            font-size: 0.75rem;
            font-weight: 800;
            color: #94a3b8;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .input-style {
            width: 100%;
            padding: 16px;
            border-radius: 15px;
            border: 2px solid #f1f5f9;
            background: #f8fafc;
            font-family: inherit;
            box-sizing: border-box;
            outline: none;
            transition: 0.3s;
        }

        .input-style:focus {
            border-color: var(--primary);
            background: white;
        }

        .btn-save {
            background: var(--primary);
            color: white;
            border: none;
            padding: 16px 30px;
            border-radius: 15px;
            font-weight: 800;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-save:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        /* Rekap Grid ke Samping */
        .rekap-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
            margin-top: 25px;
        }

        .card-item {
            background: white;
            border-radius: 25px;
            padding: 25px;
            border: 1px solid #f1f5f9;
            transition: 0.3s ease;
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .card-item:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
            border-color: var(--accent);
        }

        .badge {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 6px 12px;
            border-radius: 10px;
            font-weight: 800;
            font-size: 0.7rem;
            text-transform: uppercase;
        }

        .Sakit {
            background: #fef9c3;
            color: #854d0e;
        }

        .Izin {
            background: #dcfce7;
            color: #166534;
        }

        .Alfa {
            background: #fee2e2;
            color: #991b1b;
        }

        .name {
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--primary);
            margin: 0 0 5px;
            padding-right: 60px;
        }

        .meta {
            font-size: 0.8rem;
            color: #64748b;
            font-weight: 700;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .tag-info {
            background: #f1f5f9;
            padding: 4px 10px;
            border-radius: 8px;
        }

        .note-box {
            margin-top: 15px;
            padding: 12px;
            background: #f8fafc;
            border-radius: 12px;
            font-size: 0.85rem;
            color: #475569;
            border-left: 4px solid var(--primary);
            flex-grow: 1;
        }

        .btn-del {
            margin-top: 15px;
            color: #ef4444;
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        @media (max-width: 850px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <div class="hero">
        <div class="container">
            <div class="header-nav">
                <div class="welcome-text">
                    <h2>Selamat Datang Pembina! 👋</h2>
                    <p><i class="fas fa-calendar-day"></i> <?= tgl_indo(date('Y-m-d')); ?></p>
                </div>
                <a href="logout.php" style="color:white; text-decoration:none; background:rgba(255,255,255,0.2); padding:12px 25px; border-radius:15px; font-weight:700; backdrop-filter:blur(10px);">Keluar</a>
            </div>
            <h1 style="margin-top:40px; font-size:3.5rem; font-weight:900;"><?= date('H:i'); ?> <small style="font-size:1rem; opacity:0.8;">WITA</small></h1>
        </div>
    </div>

    <div class="main-wrapper">
        <div class="container">

            <div class="glass-card">
                <h3 style="margin:0 0 20px; color:var(--primary); font-weight:800;"><i class="fas fa-edit"></i> Laporan Santri Tidak Hadir</h3>
                <form action="" method="POST" autocomplete="off">
                    <div class="form-row">
                        <div class="input-box">
                            <label>Nama Santri</label>
                            <input type="text" name="nama_siswa" list="siswaList" class="input-style" placeholder="Cari nama santri..." required>
                            <datalist id="siswaList">
                                <?php
                                $res = mysqli_query($conn, "SELECT nama, kelas, jurusan, nomor_kelas FROM siswas ORDER BY nama ASC");
                                while ($r = mysqli_fetch_assoc($res)) {
                                    // Menambahkan SPASI antara Jurusan dan Nomor Kelas
                                    $detail = $r['jurusan'] . " " . $r['nomor_kelas'];
                                    echo "<option value='" . htmlspecialchars($r['nama']) . "'>Kelas " . $r['kelas'] . " (" . $detail . ")</option>";
                                }
                                ?>
                            </datalist>
                        </div>
                        <div class="input-box">
                            <label>Status</label>
                            <select name="status" class="input-style">
                                <option value="Sakit">Sakit</option>
                                <option value="Izin">Izin</option>
                                <option value="Alfa">Alfa</option>
                            </select>
                        </div>
                        <div class="input-box">
                            <label>Keterangan Alasan</label>
                            <input type="text" name="keterangan" class="input-style" placeholder="Alasan ketidakhadiran...">
                        </div>
                        <button type="submit" name="kirim_laporan" class="btn-save">SIMPAN</button>
                    </div>
                </form>
            </div>

            <h3 style="color:var(--primary); font-weight:800; margin-left:10px;">
                <i class="fas fa-history"></i> Rekap Ketidakhadiran Hari Ini
            </h3>

            <div class="rekap-grid">
                <?php
                $today = date('Y-m-d');
                $q = mysqli_query($conn, "SELECT a.*, s.nama, s.kelas, s.jurusan, s.nomor_kelas 
                                     FROM absensi a 
                                     JOIN siswas s ON a.id_siswa = s.id 
                                     WHERE a.tanggal = '$today' AND a.status != 'hadir' 
                                     ORDER BY a.id DESC");

                if (mysqli_num_rows($q) > 0):
                    while ($row = mysqli_fetch_assoc($q)): ?>
                        <div class="card-item">
                            <span class="badge <?= $row['status']; ?>"><?= $row['status']; ?></span>
                            <div>
                                <h4 class="name"><?= htmlspecialchars($row['nama']); ?></h4>
                                <div class="meta">
                                    <span class="tag-info">Kelas <?= $row['kelas']; ?></span>
                                    <span class="tag-info"><?= $row['jurusan']; ?> <?= $row['nomor_kelas']; ?></span>
                                </div>
                            </div>

                            <div class="note-box">
                                <b style="font-size: 0.7rem; color: #94a3b8; text-transform: uppercase;">Keterangan:</b><br>
                                <?= htmlspecialchars($row['keterangan']) ?: '<i style="color:#cbd5e1">Tidak ada rincian</i>'; ?>
                            </div>

                            <a href="pembina.php?hapus=<?= $row['id']; ?>" class="btn-del" onclick="return confirm('Hapus data ini?')">
                                <i class="fas fa-trash-alt"></i> Hapus
                            </a>
                        </div>
                    <?php endwhile;
                else: ?>
                    <div style="grid-column: 1/-1; text-align: center; padding: 60px; background: white; border-radius: 30px; color: #94a3b8; border: 2px dashed #e2e8f0;">
                        <i class="fas fa-check-circle" style="font-size: 3rem; margin-bottom: 15px; opacity: 0.2;"></i>
                        <p style="font-weight: 700;">Belum ada laporan ketidakhadiran untuk hari ini.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <footer style="text-align:center; padding:30px; color:#94a3b8; font-size:0.8rem; font-weight:600;">
        &copy; <?= date('Y'); ?> E-Absensi Digital • Portal Pembina v5.1
    </footer>

</body>

</html>