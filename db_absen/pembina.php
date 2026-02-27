<?php
// 1. Inisialisasi Session & Koneksi (Harus di paling atas)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'koneksi.php';

date_default_timezone_set('Asia/Makassar');

// 2. Proteksi Halaman
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'pembina') {
    header("Location: login.php");
    exit;
}

// 3. Fungsi Tanggal Indonesia
function tgl_indo($tanggal)
{
    $bulan = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    $num_hari = date('w', strtotime($tanggal));
    $split = explode('-', $tanggal);
    return $hari[$num_hari] . ', ' . $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];
}

// 4. Logika Kirim Laporan (Simpan/Update)
if (isset($_POST['kirim_laporan'])) {
    $tgl = date('Y-m-d');
    $nama_input = mysqli_real_escape_string($conn, $_POST['nama_siswa']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $ket = mysqli_real_escape_string($conn, $_POST['keterangan']);

    // Cari ID Siswa
    $cari_siswa = mysqli_query($conn, "SELECT id FROM siswas WHERE nama = '$nama_input' LIMIT 1");
    if ($data_siswa = mysqli_fetch_assoc($cari_siswa)) {
        $id_siswa = $data_siswa['id'];

        // Cek duplikasi di hari yang sama
        $cek = mysqli_query($conn, "SELECT id FROM absensi WHERE id_siswa = '$id_siswa' AND tanggal = '$tgl'");

        if (mysqli_num_rows($cek) > 0) {
            $q = "UPDATE absensi SET status = '$status', keterangan = '$ket' WHERE id_siswa = '$id_siswa' AND tanggal = '$tgl'";
        } else {
            $q = "INSERT INTO absensi (id_siswa, tanggal, status, keterangan) VALUES ('$id_siswa', '$tgl', '$status', '$ket')";
        }

        if (mysqli_query($conn, $q)) {
            $_SESSION['notif'] = "Berhasil memperbarui data $nama_input";
        }
    }
    header("Location: pembina.php");
    exit;
}

// 5. Fitur Hapus
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
    <title>Portal Pembina | E-Absensi</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #064e3b;
            --accent: #10b981;
            --danger: #ef4444;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f8fafc;
            margin: 0;
            color: #1e293b;
        }

        .hero-header {
            background: linear-gradient(135deg, #064e3b 0%, #065f46 100%);
            padding: 40px 20px;
            color: white;
            border-radius: 0 0 50px 50px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
        }

        .main-wrapper {
            margin-top: -60px;
            padding: 0 20px 50px;
        }

        .glass-card {
            background: white;
            padding: 30px;
            border-radius: 25px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            border: 1px solid #f1f5f9;
        }

        .form-row {
            display: grid;
            grid-template-columns: 2fr 1fr 1.5fr auto;
            gap: 15px;
            align-items: flex-end;
        }

        .input-style {
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            border: 2px solid #f1f5f9;
            background: #f8fafc;
            outline: none;
            transition: 0.3s;
            box-sizing: border-box;
        }

        .input-style:focus {
            border-color: var(--primary);
            background: white;
        }

        .btn-save {
            background: var(--primary);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 12px;
            font-weight: 800;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-save:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        .rekap-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 20px;
        }

        .card-item {
            background: white;
            padding: 25px;
            border-radius: 20px;
            position: relative;
            border: 1px solid #e2e8f0;
            transition: 0.3s;
        }

        .card-item:hover {
            transform: translateY(-5px);
            border-color: var(--accent);
        }

        .badge {
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 0.7rem;
            font-weight: 800;
            color: white;
            text-transform: uppercase;
            margin-bottom: 10px;
            display: inline-block;
        }

        .Sakit {
            background: #fbbf24;
        }

        .Izin {
            background: #3b82f6;
        }

        .Alfa {
            background: #ef4444;
        }

        .note-box {
            background: #f1f5f9;
            padding: 12px;
            border-radius: 12px;
            margin: 15px 0;
            font-size: 0.85rem;
            border-left: 4px solid var(--primary);
        }

        .btn-del {
            color: var(--danger);
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        @media (max-width: 900px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <div class="hero-header">
        <div class="container">
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <div>
                    <h2 style="margin:0;"><i class="fas fa-user-shield"></i> Portal Pembina</h2>
                    <p style="margin:5px 0 0; opacity:0.8;"><?= tgl_indo(date('Y-m-d')); ?></p>
                </div>
                <a href="logout.php" style="color:white; text-decoration:none; background:rgba(255,255,255,0.2); padding:12px 25px; border-radius:15px; font-weight:700; backdrop-filter:blur(10px);">Keluar</a>
            </div>
            <h1 style="margin-top:30px; font-size:3rem; font-weight:900;"><?= date('H:i'); ?> <small style="font-size:1rem;">WITA</small></h1>
        </div>
    </div>

    <div class="main-wrapper">
        <div class="container">
            <div class="glass-card">
                <h3 style="margin:0 0 20px; color:var(--primary); font-weight:800;"><i class="fas fa-edit"></i> Laporan Santri Tidak Hadir</h3>
                <form action="" method="POST" autocomplete="off">
                    <div class="form-row">
                        <div class="input-box">
                            <label style="font-size: 0.7rem; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Nama Santri</label>
                            <input type="text" name="nama_siswa" list="siswaList" class="input-style" placeholder="Cari nama..." required>
                            <datalist id="siswaList">
                                <?php
                                $res = mysqli_query($conn, "SELECT nama, kelas, jurusan FROM siswas ORDER BY nama ASC");
                                while ($r = mysqli_fetch_assoc($res)) {
                                    echo "<option value='" . htmlspecialchars($r['nama']) . "'>Kelas " . $r['kelas'] . " (" . $r['jurusan'] . ")</option>";
                                }
                                ?>
                            </datalist>
                        </div>
                        <div class="input-box">
                            <label style="font-size: 0.7rem; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Status</label>
                            <select name="status" class="input-style">
                                <option value="Sakit">Sakit</option>
                                <option value="Izin">Izin</option>
                                <option value="Alfa">Alfa</option>
                            </select>
                        </div>
                        <div class="input-box">
                            <label style="font-size: 0.7rem; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Keterangan</label>
                            <input type="text" name="keterangan" class="input-style" placeholder="Alasan...">
                        </div>
                        <button type="submit" name="kirim_laporan" class="btn-save">SIMPAN</button>
                    </div>
                </form>
            </div>

            <h3 style="color:var(--primary); font-weight:800; margin-bottom:20px;"><i class="fas fa-history"></i> Rekap Hari Ini</h3>
            <div class="rekap-grid">
                <?php
                $today = date('Y-m-d');
                $q = mysqli_query($conn, "SELECT a.*, s.nama, s.kelas, s.jurusan 
                                          FROM absensi a JOIN siswas s ON a.id_siswa = s.id 
                                          WHERE a.tanggal = '$today' AND a.status != 'hadir' 
                                          ORDER BY a.id DESC");

                if (mysqli_num_rows($q) > 0):
                    while ($row = mysqli_fetch_assoc($q)): ?>
                        <div class="card-item">
                            <span class="badge <?= $row['status']; ?>"><?= $row['status']; ?></span>
                            <h4 style="margin:0; color:var(--primary); font-weight:800;"><?= htmlspecialchars($row['nama']); ?></h4>
                            <small style="color:#64748b; font-weight:700;">Kelas <?= $row['kelas']; ?> | <?= $row['jurusan']; ?></small>

                            <div class="note-box">
                                <strong>Ket:</strong> <?= !empty($row['keterangan']) ? htmlspecialchars($row['keterangan']) : '<i>Tidak ada rincian</i>'; ?>
                            </div>

                            <a href="pembina.php?hapus=<?= $row['id']; ?>" class="btn-del" onclick="return confirm('Hapus data ini?')">
                                <i class="fas fa-trash-alt"></i> Hapus Laporan
                            </a>
                        </div>
                    <?php endwhile;
                else: ?>
                    <div style="grid-column: 1/-1; text-align: center; padding: 50px; background: white; border-radius: 20px; color: #94a3b8; border: 2px dashed #e2e8f0;">
                        <p>Belum ada laporan ketidakhadiran hari ini.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <footer style="text-align:center; padding:30px; color:#94a3b8; font-size:0.8rem;">
        &copy; <?= date('Y'); ?> E-Absensi Digital • Portal Pembina v5.2
    </footer>

</body>

</html>