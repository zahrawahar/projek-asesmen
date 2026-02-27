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
$query_laporan = "SELECT a.status, a.keterangan, s.nama 
                  FROM absensi a 
                  JOIN siswas s ON a.id_siswa = s.id 
                  WHERE s.id_walikelas = '$id_user' 
                  AND a.tanggal = '$tgl_hari_ini' 
                  AND a.status != 'hadir'";
$res_laporan = mysqli_query($conn, $query_laporan);
$jml_laporan = mysqli_num_rows($res_laporan);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Absen | Wali Kelas Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
        :root {
            --primary: #064e3b;
            --primary-light: #065f46;
            --accent: #10b981;
            --gold: #fbbf24;
            --danger: #ef4444;
            --bg-body: #f8fafc;
            --border-color: #cbd5e1;
            --card-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-body);
            margin: 0;
            color: #1e293b;
        }

        .hero-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            height: 380px;
            border-radius: 0 0 80px 80px;
            color: white;
            padding-top: 40px;
            position: relative;
            box-shadow: 0 15px 30px rgba(6, 78, 59, 0.2);
        }

        .header-top {
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 30px;
        }

        .brand h2 {
            margin: 0;
            font-size: 2.4rem;
            font-weight: 800;
            color: var(--gold);
            letter-spacing: -1.5px;
        }

        .btn-logout {
            color: white;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 700;
            background: rgba(255, 255, 255, 0.1);
            padding: 14px 28px;
            border-radius: 18px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(12px);
            transition: 0.3s;
        }

        .main-content {
            max-width: 1100px;
            margin: -150px auto 60px;
            padding: 0 25px;
            position: relative;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            border-radius: 35px;
            padding: 30px;
            box-shadow: var(--card-shadow);
            display: flex;
            align-items: center;
            gap: 20px;
            border: 2px solid transparent;
            transition: 0.3s;
            cursor: pointer;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            border-color: var(--border-color);
        }

        .icon-box {
            width: 70px;
            height: 70px;
            border-radius: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
        }

        .green-box { background: #ecfdf5; color: var(--accent); }
        .gold-box { background: #fefce8; color: var(--gold); }
        .blue-box { background: #eff6ff; color: #3b82f6; }

        .main-card {
            background: white;
            border-radius: 40px;
            padding: 40px;
            box-shadow: var(--card-shadow);
            margin-bottom: 30px;
            border: 1px solid var(--border-color);
        }

        .search-box {
            padding: 12px 20px;
            border-radius: 15px;
            border: 2px solid var(--border-color);
            width: 100%;
            outline: none;
            font-family: inherit;
        }

        .btn-save {
            width: 100%;
            padding: 20px;
            border-radius: 20px;
            border: none;
            background: var(--primary);
            color: white;
            font-weight: 800;
            font-size: 1.1rem;
            cursor: pointer;
            box-shadow: 0 10px 20px rgba(6, 78, 59, 0.2);
            display: block;
        }

        table { width: 100%; border-collapse: collapse; border: 2px solid var(--border-color); }
        th { background: #f1f5f9; text-align: left; padding: 18px; color: var(--primary); font-size: 0.85rem; text-transform: uppercase; font-weight: 800; border: 2px solid var(--border-color); }
        td { padding: 15px 18px; border: 2px solid var(--border-color); font-weight: 600; color: #334155; }

        .hidden { display: none !important; }

        /* Custom SweetAlert Styles */
        .swal2-modern-round { border-radius: 30px !important; }
        .btn-confirm-gg { border-radius: 15px !important; padding: 12px 25px !important; font-weight: 700 !important; box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3) !important; }
        .btn-cancel-gg { border-radius: 15px !important; padding: 12px 25px !important; font-weight: 700 !important; }

        /* Radio Design */
        .radio-tile-group { display: flex; gap: 10px; justify-content: center; }
        .radio-label { width: 42px; height: 42px; display: flex; align-items: center; justify-content: center; border-radius: 12px; border: 2px solid var(--border-color); font-weight: 800; cursor: pointer; transition: 0.2s; }
        input[type="radio"]:checked+label { color: white; transform: scale(1.1); }
        .radio-h:checked+label { background: var(--accent); border-color: var(--accent); }
        .radio-s:checked+label { background: var(--gold); border-color: var(--gold); }
        .radio-i:checked+label { background: #3b82f6; border-color: #3b82f6; }
        .radio-a:checked+label { background: var(--danger); border-color: var(--danger); }

        /* MODAL */
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.6); display: flex; justify-content: center; align-items: center; z-index: 1000; backdrop-filter: blur(4px); }
        .modal-content { width: 90%; max-width: 600px; max-height: 85vh; overflow-y: auto; animation: slideUp 0.3s ease-out; }

        @keyframes slideUp {
            from { transform: translateY(50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>
</head>

<body>

    <div class="hero-header">
        <div class="header-top">
            <div class="brand">
                <h2><i class="fas fa-fingerprint"></i> E-ABSEN</h2>
                <p style="margin:5px 0 0 0; font-weight:600; opacity:0.8;">Wali Kelas Dashboard</p>
            </div>
            <a href="logout.php" class="btn-logout"><i class="fas fa-power-off"></i> Keluar</a>
        </div>
        <div style="max-width:1100px; margin: 40px auto 0; padding: 0 30px;">
            <h1 style="font-size: 2.5rem; font-weight: 800; margin: 0;">Halo, <?= htmlspecialchars($nama_tampil); ?>! 👋</h1>
            <p style="font-size: 1.1rem; opacity: 0.9; margin-top: 10px;">
                <i class="far fa-calendar-check"></i> <?= tgl_indo(date('Y-m-d')); ?>
            </p>
        </div>
    </div>

    <div class="main-content">
        <div class="stats-grid">
            <div class="stat-card" style="border: 2px solid #3b82f6;">
                <div class="icon-box blue-box"><i class="fas fa-user-graduate"></i></div>
                <div class="stat-info">
                    <h3><?= $jumlah_siswa; ?></h3>
                    <p>Total Siswa</p>
                </div>
            </div>

            <div class="stat-card" onclick="toggleLaporan()" style="border: 2px solid var(--accent);">
                <div class="icon-box green-box"><i class="fas fa-bullhorn"></i></div>
                <div class="stat-info">
                    <h3><?= $jml_laporan; ?> Laporan</h3>
                    <p>Dari Pembina</p>
                </div>
            </div>

            <div class="stat-card" onclick="toggleAturSiswa()" style="border: 2px solid var(--gold);">
                <div class="icon-box gold-box"><i class="fas fa-user-plus"></i></div>
                <div class="stat-info">
                    <h3>Atur Siswa</h3>
                    <p>Tambah Murid Baru</p>
                </div>
            </div>
        </div>

        <div id="sectionAturSiswa" class="main-card hidden" style="border-left: 10px solid var(--gold); animation: slideUp 0.4s ease;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                <h3 style="margin:0;"><i class="fas fa-plus-circle"></i> Kelola Data Siswa</h3>
                <button onclick="toggleAturSiswa()" style="background:#fff1f2; border:none; color:var(--danger); font-weight:800; padding:8px 15px; border-radius:10px; cursor:pointer;">Tutup</button>
            </div>

            <form method="POST">
                <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap:20px; margin-bottom:20px;">
                    <div>
                        <label style="display:block; font-weight:700; margin-bottom:8px;">Kelas</label>
                        <select name="kelas" required class="search-box">
                            <option value="">Pilih Kelas</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>
                    <div>
                        <label style="display:block; font-weight:700; margin-bottom:8px;">Jurusan</label>
                        <select name="jurusan" required class="search-box">
                            <option value="">Pilih Jurusan</option>
                            <option value="PPLG">PPLG</option>
                            <option value="DKV">DKV</option>
                        </select>
                    </div>
                    <div>
                        <label style="display:block; font-weight:700; margin-bottom:8px;">No. Kelas</label>
                        <select name="nomor_kelas" required class="search-box">
                            <option value="">Pilih No</option>
                            <?php for ($i = 1; $i <= 3; $i++): ?>
                                <option value="<?= $i; ?>"><?= $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>

                <div style="margin-bottom:20px;">
                    <label style="display:block; font-weight:700; margin-bottom:8px;">Nama Siswa (Gunakan baris baru untuk banyak siswa)</label>
                    <textarea name="nama_massal" placeholder="Contoh:&#10;Ahmad Fauzi&#10;Budi Santoso" rows="5" class="search-box" style="height:auto;"></textarea>
                </div>

                <button type="submit" name="proses_tambah_massal" class="btn-save" style="background:var(--gold); color:#000; margin:0;">
                    <i class="fas fa-save"></i> Simpan Data Siswa
                </button>
            </form>
        </div>

        <div class="main-card">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:30px; border-bottom:2px solid var(--border-color); padding-bottom:15px;">
                <h3><i class="fas fa-list-ol"></i> Daftar Presensi Siswa</h3>
                <input type="text" id="searchInput" onkeyup="searchTable()" class="search-box" style="width:250px;" placeholder="Cari nama...">
            </div>

            <form action="simpan_absen.php" method="POST">
                <div style="overflow-x:auto;">
                    <table id="siswaTable">
                        <thead>
                            <tr>
                                <th style="width:50px; text-align:center;">No</th>
                                <th>Nama Lengkap</th>
                                <th style="text-align:center;">Kehadiran</th>
                                <th style="text-align:right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            mysqli_data_seek($cek_siswa, 0);
                            while ($s = mysqli_fetch_assoc($cek_siswa)):
                                $id_s = $s['id'];
                                $cek_lp = mysqli_query($conn, "SELECT status FROM absensi WHERE id_siswa = '$id_s' AND tanggal = '$tgl_hari_ini'");
                                $data_lp = mysqli_fetch_assoc($cek_lp);
                                $status_final = ($data_lp) ? strtolower($data_lp['status']) : 'hadir';
                            ?>
                                <tr>
                                    <td align="center"><?= $no++; ?></td>
                                    <td><?= htmlspecialchars($s['nama']); ?></td>
                                    <td>
                                        <div class="radio-tile-group">
                                            <input type="radio" class="radio-h hidden" id="h_<?= $id_s; ?>" name="absen[<?= $id_s; ?>]" value="hadir" <?= ($status_final == 'hadir') ? 'checked' : ''; ?>>
                                            <label for="h_<?= $id_s; ?>" class="radio-label">H</label>

                                            <input type="radio" class="radio-s hidden" id="s_<?= $id_s; ?>" name="absen[<?= $id_s; ?>]" value="sakit" <?= ($status_final == 'sakit') ? 'checked' : ''; ?>>
                                            <label for="s_<?= $id_s; ?>" class="radio-label">S</label>

                                            <input type="radio" class="radio-i hidden" id="i_<?= $id_s; ?>" name="absen[<?= $id_s; ?>]" value="izin" <?= ($status_final == 'izin') ? 'checked' : ''; ?>>
                                            <label for="i_<?= $id_s; ?>" class="radio-label">I</label>

                                            <input type="radio" class="radio-a hidden" id="a_<?= $id_s; ?>" name="absen[<?= $id_s; ?>]" value="alfa" <?= ($status_final == 'alfa') ? 'checked' : ''; ?>>
                                            <label for="a_<?= $id_s; ?>" class="radio-label">A</label>
                                        </div>
                                    </td>
                                    <td align="right">
                                        <button type="button" onclick="hapusSiswa(<?= $id_s; ?>)" style="background:#fff1f2; color:var(--danger); border:none; padding:10px; border-radius:10px; cursor:pointer;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <button type="submit" class="btn-save" style="margin-top:30px;">
                    <i class="fas fa-save"></i> Simpan Presensi Hari Ini
                </button>
            </form>
        </div>
    </div>

    <div id="modalLaporan" class="modal-overlay hidden">
        <div class="main-card modal-content">
            <h3><i class="fas fa-bullhorn"></i> Laporan Pembina</h3>
            <div style="overflow-x:auto; margin-top:20px;">
                <table>
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Status</th>
                            <th>Ket.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        mysqli_data_seek($res_laporan, 0);
                        if ($jml_laporan > 0):
                            while ($l = mysqli_fetch_assoc($res_laporan)): ?>
                                <tr>
                                    <td><?= htmlspecialchars($l['nama']); ?></td>
                                    <td><b style="color:var(--danger)"><?= strtoupper($l['status']); ?></b></td>
                                    <td><?= htmlspecialchars($l['keterangan']); ?></td>
                                </tr>
                            <?php endwhile;
                        else: ?>
                            <tr>
                                <td colspan="3" align="center">Tidak ada laporan ketidakhadiran.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <button onclick="toggleLaporan()" class="btn-save" style="background:#64748b; margin-top:20px;">Tutup</button>
        </div>
    </div>

    <script>
        // Logika Notifikasi SweetAlert dari PHP
        <?php if (isset($_SESSION['notif'])): ?>
            Swal.fire({
                icon: '<?= $_SESSION['notif_type'] ?? "success"; ?>',
                title: 'Informasi',
                text: '<?= $_SESSION['notif']; ?>',
                timer: 3000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end',
                timerProgressBar: true
            });
            <?php unset($_SESSION['notif']); unset($_SESSION['notif_type']); ?>
        <?php endif; ?>

        // Menangani status dari URL (Setelah hapus)
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('status') === 'deleted') {
            Swal.fire({
                icon: 'success',
                title: 'Terhapus!',
                text: 'Siswa berhasil dihapus dari sistem.',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            window.history.replaceState({}, document.title, window.location.pathname);
        }

        function toggleAturSiswa() {
            const section = document.getElementById("sectionAturSiswa");
            section.classList.toggle("hidden");
            if (!section.classList.contains("hidden")) {
                section.scrollIntoView({ behavior: 'smooth' });
            }
        }

        function toggleLaporan() {
            document.getElementById("modalLaporan").classList.toggle("hidden");
        }

        function searchTable() {
            let input = document.getElementById("searchInput").value.toUpperCase();
            let tr = document.getElementById("siswaTable").getElementsByTagName("tr");
            for (let i = 1; i < tr.length; i++) {
                let tdName = tr[i].getElementsByTagName("td")[1];
                if (tdName) {
                    tr[i].style.display = (tdName.textContent || tdName.innerText).toUpperCase().indexOf(input) > -1 ? "" : "none";
                }
            }
        }

        // FUNGSI HAPUS GG
        function hapusSiswa(id) {
            Swal.fire({
                title: 'Yakin hapus siswa?',
                text: "Seluruh riwayat absen siswa ini juga akan ikut terhapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'swal2-modern-round',
                    confirmButton: 'btn-confirm-gg',
                    cancelButton: 'btn-cancel-gg'
                },
                showClass: { popup: 'animate__animated animate__fadeInUp animate__faster' },
                hideClass: { popup: 'animate__animated animate__fadeOutDown animate__faster' }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses...',
                        allowOutsideClick: false,
                        didOpen: () => { Swal.showLoading() }
                    });
                    window.location.href = 'hapus_siswa.php?id=' + id;
                }
            })
        }
    </script>
</body>
</html>