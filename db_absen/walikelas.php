<?php
session_start();
include 'koneksi.php';

date_default_timezone_set('Asia/Makassar');

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'walikelas') {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id'];
$nama_tampil = $_SESSION['nama_guru'] ?? $_SESSION['username'] ?? 'Wali Kelas';

// Fungsi format tanggal Indonesia
function tgl_indo($tanggal)
{
    $bulan = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
    $pecahkan = explode('-', $tanggal);
    $hari = date('D', strtotime($tanggal));
    $list_hari = array('Sun' => 'Minggu', 'Mon' => 'Senin', 'Tue' => 'Selasa', 'Wed' => 'Rabu', 'Thu' => 'Kamis', 'Fri' => 'Jumat', 'Sat' => 'Sabtu');
    return $list_hari[$hari] . ', ' . $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}

// --- LOGIKA FILTER SEMESTER ---
$tahun_sekarang = date('Y');
$bulan_sekarang = date('n');
if ($bulan_sekarang >= 7) {
    $tgl_mulai_smt = "$tahun_sekarang-07-01";
    $tgl_selesai_smt = "$tahun_sekarang-12-31";
    $nama_semester = "Semester Ganjil " . $tahun_sekarang . "/" . ($tahun_sekarang + 1);
} else {
    $tgl_mulai_smt = "$tahun_sekarang-01-01";
    $tgl_selesai_smt = "$tahun_sekarang-06-30";
    $nama_semester = "Semester Genap " . ($tahun_sekarang - 1) . "/" . $tahun_sekarang;
}

// --- LOGIKA TAMBAH SISWA ---
if (isset($_POST['proses_tambah_massal'])) {
    $kelas = trim(mysqli_real_escape_string($conn, $_POST['kelas']));
    $jurusan = trim(mysqli_real_escape_string($conn, $_POST['jurusan']));
    $nomor_kelas = trim(mysqli_real_escape_string($conn, $_POST['nomor_kelas']));
    $nama_massal = $_POST['nama_massal'];

    $daftar_nama = explode("\n", str_replace("\r", "", $nama_massal));
    $berhasil = 0;

    foreach ($daftar_nama as $nama) {
        $nama = trim(mysqli_real_escape_string($conn, $nama));
        if (!empty($nama)) {
            $query = "INSERT INTO siswas (nama, kelas, jurusan, nomor_kelas, id_walikelas) 
                      VALUES ('$nama', '$kelas', '$jurusan', '$nomor_kelas', '$id_user')";
            if (mysqli_query($conn, $query)) {
                $berhasil++;
            }
        }
    }
    if ($berhasil > 0) {
        $_SESSION['notif'] = "Berhasil menambahkan $berhasil siswa!";
        $_SESSION['notif_type'] = "success";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

$cek_siswa = mysqli_query($conn, "SELECT * FROM siswas WHERE id_walikelas = '$id_user' ORDER BY nama ASC");
$jumlah_siswa = mysqli_num_rows($cek_siswa);
$tgl_hari_ini = date('Y-m-d');

// --- QUERY LAPORAN PEMBINA HARI INI (DISERTAI KETERANGAN) ---
$query_laporan = "SELECT a.status, a.keterangan, s.nama 
                  FROM absensi a 
                  JOIN siswas s ON a.id_siswa = s.id 
                  WHERE s.id_walikelas = '$id_user' 
                  AND a.tanggal = '$tgl_hari_ini' 
                  AND a.status != 'hadir'";
$res_laporan = mysqli_query($conn, $query_laporan);
$jml_laporan = mysqli_num_rows($res_laporan);

$riwayat_data = []; 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Absen | Wali Kelas</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary: #064e3b;
            --primary-light: #065f46;
            --accent: #10b981;
            --gold: #fbbf24;
            --danger: #ef4444;
            --bg-body: #f8fafc;
            --border-color: #e2e8f0;
            --card-shadow: 0 15px 30px -5px rgba(0, 0, 0, 0.05);
        }

        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg-body); margin: 0; color: #1e293b; overflow-x: hidden; }
        
        /* HEADER */
        .hero-header { 
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); 
            height: 380px; border-radius: 0 0 80px 80px; color: white; padding-top: 40px; position: relative; 
            box-shadow: 0 15px 30px rgba(6, 78, 59, 0.2); 
        }
        .header-top { max-width: 1100px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; padding: 0 30px; }
        .brand h2 { margin: 0; font-size: 2rem; font-weight: 800; color: var(--gold); letter-spacing: -1px; }
        .btn-logout { color: white; text-decoration: none; font-size: 0.9rem; font-weight: 700; background: rgba(255, 255, 255, 0.1); padding: 12px 24px; border-radius: 15px; border: 1px solid rgba(255, 255, 255, 0.2); transition: 0.3s; }

        .main-content { max-width: 1100px; margin: -150px auto 60px; padding: 0 25px; position: relative; }

        /* 3 CARDS ANIMATED */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 25px; margin-bottom: 40px; }
        .stat-card { 
            background: white; border-radius: 35px; padding: 30px; box-shadow: var(--card-shadow); 
            display: flex; align-items: center; gap: 20px; border: 2px solid transparent; 
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); cursor: pointer;
        }
        .stat-card:hover { 
            transform: translateY(-12px); 
            box-shadow: 0 25px 40px -10px rgba(0,0,0,0.1);
            border-color: rgba(251, 191, 36, 0.3);
        }
        .icon-box { width: 70px; height: 70px; border-radius: 22px; display: flex; align-items: center; justify-content: center; font-size: 2rem; transition: 0.3s; }
        .stat-card:hover .icon-box { transform: scale(1.1) rotate(5deg); }
        .green-box { background: #ecfdf5; color: var(--accent); }
        .gold-box { background: #fefce8; color: var(--gold); }
        .blue-box { background: #eff6ff; color: #3b82f6; }

        /* FORM TAMBAH SISWA */
        .main-card { background: white; border-radius: 40px; padding: 40px; box-shadow: var(--card-shadow); margin-bottom: 30px; border: 1px solid var(--border-color); }
        .manage-section { background: #fff; border: 2px solid #fde68a; }
        
        .modern-input { 
            padding: 14px 20px; border-radius: 18px; border: 2px solid #f1f5f9; 
            font-family: inherit; font-size: 0.95rem; font-weight: 600; outline: none; 
            transition: 0.3s; background: #f8fafc; width: 100%; box-sizing: border-box;
        }
        .modern-input:focus { border-color: var(--gold); background: #fff; box-shadow: 0 0 0 4px rgba(251, 191, 36, 0.1); }
        
        .btn-submit-gold { 
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); color: #78350f; 
            border: none; padding: 18px; border-radius: 20px; font-weight: 800; font-size: 1rem;
            cursor: pointer; transition: 0.3s; display: flex; align-items: center; justify-content: center; gap: 10px; width: 100%;
        }

        /* TABLE */
        .hidden { display: none !important; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #f8fafc; text-align: left; padding: 18px; color: var(--primary); font-size: 0.75rem; text-transform: uppercase; font-weight: 800; border-bottom: 2px solid #f1f5f9; }
        td { padding: 16px 18px; border-bottom: 1px solid #f1f5f9; font-weight: 600; color: #475569; }
        
        .radio-tile-group { display: flex; gap: 8px; justify-content: center; }
        .radio-label { width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 12px; border: 2px solid #e2e8f0; cursor: pointer; font-weight: 800; transition: 0.2s; }
        input[type="radio"]:checked+label.h { background: var(--accent); color: white; border-color: var(--accent); }
        input[type="radio"]:checked+label.s { background: var(--gold); color: white; border-color: var(--gold); }
        input[type="radio"]:checked+label.i { background: #3b82f6; color: white; border-color: #3b82f6; }
        input[type="radio"]:checked+label.a { background: var(--danger); color: white; border-color: var(--danger); }
    </style>
</head>
<body>

    <div class="hero-header">
        <div class="header-top">
            <div class="brand"><h2><i class="fas fa-fingerprint"></i> E-ABSEN</h2></div>
            <a href="logout.php" class="btn-logout"><i class="fas fa-power-off"></i> Keluar</a>
        </div>
        <div style="max-width:1100px; margin: 40px auto 0; padding: 0 30px;">
            <h1 style="font-size: 2.3rem; font-weight: 800; margin: 0;">Halo, <?= htmlspecialchars($nama_tampil); ?>! 👋</h1>
            <p style="opacity: 0.8; margin-top: 10px;"><i class="far fa-calendar-alt"></i> <?= tgl_indo(date('Y-m-d')); ?></p>
        </div>
    </div>

    <div class="main-content">
        <div class="stats-grid">
            <div class="stat-card" style="border-bottom: 4px solid #3b82f6;">
                <div class="icon-box blue-box"><i class="fas fa-user-graduate"></i></div>
                <div><h3 style="margin:0; font-size:1.5rem;"><?= $jumlah_siswa; ?></h3><p style="margin:0; color:#94a3b8; font-size:0.85rem; font-weight:600;">Total Siswa</p></div>
            </div>
            <div class="stat-card" onclick="toggleLaporan()" style="border-bottom: 4px solid var(--accent);">
                <div class="icon-box green-box"><i class="fas fa-bullhorn"></i></div>
                <div><h3 style="margin:0; font-size:1.5rem;"><?= $jml_laporan; ?></h3><p style="margin:0; color:#94a3b8; font-size:0.85rem; font-weight:600;">Laporan Pembina</p></div>
            </div>
            <div class="stat-card" onclick="toggleAturSiswa()" style="border-bottom: 4px solid var(--gold); background: #fffef0;">
                <div class="icon-box gold-box"><i class="fas fa-user-plus"></i></div>
                <div><h3 style="margin:0; font-size:1.3rem;">Atur Siswa</h3><p style="margin:0; color:#94a3b8; font-size:0.85rem; font-weight:600;">Kelola Data</p></div>
            </div>
        </div>

        <div id="sectionAturSiswa" class="main-card manage-section hidden">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:30px;">
                <h3 style="margin:0; color: #78350f;"><i class="fas fa-plus-circle"></i> Tambah Siswa Massal</h3>
                <button onclick="toggleAturSiswa()" style="background:none; border:none; color:#94a3b8; cursor:pointer; font-size:1.5rem;">&times;</button>
            </div>
            <form method="POST">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; margin-bottom: 20px;">
                    <div><label style="font-size:0.7rem; font-weight:800; color:#94a3b8;">KELAS</label>
                        <select name="kelas" class="modern-input"><option value="10">10</option><option value="11">11</option><option value="12">12</option></select>
                    </div>
                    <div><label style="font-size:0.7rem; font-weight:800; color:#94a3b8;">JURUSAN</label>
                        <select name="jurusan" class="modern-input"><option value="PPLG">PPLG</option><option value="DKV">DKV</option><option value="TJKT">TJKT</option></select>
                    </div>
                    <div><label style="font-size:0.7rem; font-weight:800; color:#94a3b8;">NOMOR</label>
                        <select name="nomor_kelas" class="modern-input"><option value="1">1</option><option value="2">2</option><option value="3">3</option></select>
                    </div>
                </div>
                <label style="font-size:0.7rem; font-weight:800; color:#94a3b8;">DAFTAR NAMA</label>
                <textarea name="nama_massal" rows="5" class="modern-input" style="margin-top:8px; margin-bottom:20px; resize:none;" placeholder="Masukkan nama siswa per baris..."></textarea>
                <button type="submit" name="proses_tambah_massal" class="btn-submit-gold"><i class="fas fa-save"></i> Simpan Siswa</button>
            </form>
        </div>

        <div class="main-card">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:25px;">
                <h3 style="margin:0;"><i class="fas fa-clipboard-check"></i> Presensi Hari Ini</h3>
                <input type="text" id="searchInput" onkeyup="searchTable()" class="modern-input" style="width:200px; height:40px;" placeholder="Cari nama...">
            </div>
            <form action="simpan_absen.php" method="POST">
                <div style="overflow-x:auto;">
                    <table id="siswaTable">
                        <thead><tr><th>No</th><th>Nama Lengkap</th><th style="text-align:center;">Kehadiran</th><th style="text-align:right;">Opsi</th></tr></thead>
                        <tbody>
                            <?php $no = 1; mysqli_data_seek($cek_siswa, 0); while ($s = mysqli_fetch_assoc($cek_siswa)): 
                                $id_s = $s['id'];
                                $cek_lp = mysqli_query($conn, "SELECT status FROM absensi WHERE id_siswa = '$id_s' AND tanggal = '$tgl_hari_ini'");
                                $data_lp = mysqli_fetch_assoc($cek_lp);
                                $status_final = ($data_lp) ? strtolower($data_lp['status']) : 'hadir';
                                
                                $q_r = mysqli_query($conn, "SELECT status, tanggal FROM absensi WHERE id_siswa = '$id_s' AND status != 'hadir' AND tanggal BETWEEN '$tgl_mulai_smt' AND '$tgl_selesai_smt' ORDER BY tanggal DESC LIMIT 5");
                                $riwayat_data[$s['nama']] = mysqli_fetch_all($q_r, MYSQLI_ASSOC);
                            ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><b style="color:var(--primary)"><?= htmlspecialchars($s['nama']); ?></b></td>
                                    <td>
                                        <div class="radio-tile-group">
                                            <input type="radio" class="hidden" id="h_<?= $id_s; ?>" name="absen[<?= $id_s; ?>]" value="hadir" <?=($status_final=='hadir')?'checked':'';?>><label for="h_<?= $id_s; ?>" class="radio-label h">H</label>
                                            <input type="radio" class="hidden" id="s_<?= $id_s; ?>" name="absen[<?= $id_s; ?>]" value="sakit" <?=($status_final=='sakit')?'checked':'';?>><label for="s_<?= $id_s; ?>" class="radio-label s">S</label>
                                            <input type="radio" class="hidden" id="i_<?= $id_s; ?>" name="absen[<?= $id_s; ?>]" value="izin" <?=($status_final=='izin')?'checked':'';?>><label for="i_<?= $id_s; ?>" class="radio-label i">I</label>
                                            <input type="radio" class="hidden" id="a_<?= $id_s; ?>" name="absen[<?= $id_s; ?>]" value="alfa" <?=($status_final=='alfa')?'checked':'';?>><label for="a_<?= $id_s; ?>" class="radio-label a">A</label>
                                        </div>
                                    </td>
                                    <td align="right"><button type="button" onclick="hapusSiswa(<?= $id_s; ?>)" style="background:none; border:none; color:#cbd5e1; cursor:pointer;"><i class="fas fa-trash"></i></button></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <button type="submit" class="btn-submit-gold" style="background:var(--primary); color:white; margin-top:30px;">Simpan Presensi</button>
            </form>
        </div>

        <div class="main-card" style="border-top: 6px solid var(--danger);">
            <h3><i class="fas fa-history"></i> Rekap Semester Ini</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 15px; margin-top:20px;">
                <?php $ada = false; foreach ($riwayat_data as $nama => $rows): if (!empty($rows)): $ada = true; ?>
                    <div style="padding:15px; background:#fef2f2; border-radius:15px; border:1px solid #fee2e2;">
                        <div style="font-weight:800; font-size:0.9rem; color:#991b1b;"><?= htmlspecialchars($nama); ?></div>
                        <?php foreach ($rows as $r): ?>
                            <div style="font-size:0.75rem; color:#4b5563; margin-top:5px;">
                                <span style="font-weight:bold; color:var(--danger);"><?=strtoupper($r['status']);?></span> | <?= tgl_indo($r['tanggal']); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; endforeach; ?>
            </div>
        </div>
    </div>

    <div id="modalLaporan" class="hidden" style="position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:9999; display:flex; align-items:center; justify-content:center; backdrop-filter:blur(5px);">
        <div class="main-card" style="width:90%; max-width:600px; max-height:80vh; overflow-y:auto;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                <h3 style="margin:0;"><i class="fas fa-bullhorn" style="color:var(--accent);"></i> Laporan Dari Pembina</h3>
                <button onclick="toggleLaporan()" style="background:none; border:none; font-size:1.5rem; cursor:pointer;">&times;</button>
            </div>
            <table style="width:100%;">
                <thead style="border-bottom: 2px solid #f1f5f9;">
                    <tr>
                        <th style="padding:10px;">Nama Siswa</th>
                        <th style="padding:10px; text-align:center;">Status</th>
                        <th style="padding:10px;">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    mysqli_data_seek($res_laporan, 0); 
                    if(mysqli_num_rows($res_laporan) > 0):
                        while ($l = mysqli_fetch_assoc($res_laporan)): 
                    ?>
                        <tr>
                            <td style="padding:12px; font-weight:800;"><?= htmlspecialchars($l['nama']); ?></td>
                            <td style="padding:12px; text-align:center;">
                                <span style="background:var(--danger); color:white; padding:4px 8px; border-radius:6px; font-size:0.7rem;">
                                    <?= strtoupper($l['status']); ?>
                                </span>
                            </td>
                            <td style="padding:12px; font-size:0.85rem; color:#64748b; font-style:italic;">
                                <?= !empty($l['keterangan']) ? htmlspecialchars($l['keterangan']) : '-'; ?>
                            </td>
                        </tr>
                    <?php 
                        endwhile; 
                    else: 
                    ?>
                        <tr><td colspan="3" align="center" style="padding:30px; color:#94a3b8;">Tidak ada laporan ketidakhadiran hari ini.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <button onclick="toggleLaporan()" class="btn-submit-gold" style="margin-top:20px; background:#64748b; color:white;">Tutup Laporan</button>
        </div>
    </div>

    <script>
        function toggleAturSiswa() { document.getElementById("sectionAturSiswa").classList.toggle("hidden"); }
        function toggleLaporan() { document.getElementById("modalLaporan").classList.toggle("hidden"); }
        function searchTable() {
            let input = document.getElementById("searchInput").value.toUpperCase();
            let tr = document.getElementById("siswaTable").getElementsByTagName("tr");
            for (let i = 1; i < tr.length; i++) {
                let td = tr[i].getElementsByTagName("td")[1];
                if (td) tr[i].style.display = td.innerText.toUpperCase().indexOf(input) > -1 ? "" : "none";
            }
        }
        function hapusSiswa(id) {
            Swal.fire({ title: 'Hapus?', text: "Data hilang selamanya!", icon: 'warning', showCancelButton: true, confirmButtonColor: '#ef4444', confirmButtonText: 'Ya, Hapus' })
            .then((res) => { if (res.isConfirmed) window.location.href = 'hapus_siswa.php?id=' + id; });
        }
    </script>
</body>
</html>