<?php
session_start();
include 'koneksi.php';

// Set timezone agar sama dengan dashboard
date_default_timezone_set('Asia/Makassar');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['absen'])) {
    $tgl_hari_ini = date('Y-m-d');
    $berhasil = 0;

    foreach ($_POST['absen'] as $id_siswa => $status) {
        $id_siswa = mysqli_real_escape_string($conn, $id_siswa);
        $status = mysqli_real_escape_string($conn, $status);

        // --- LOGIKA ANTI DUPLIKAT ---
        // 1. Cek apakah siswa ini sudah absen HARI INI
        $cek = mysqli_query($conn, "SELECT id FROM absensi WHERE id_siswa = '$id_siswa' AND tanggal = '$tgl_hari_ini'");
        
        if (mysqli_num_rows($cek) > 0) {
            // 2. Jika SUDAH ADA, maka kita UPDATE statusnya saja
            $query = "UPDATE absensi SET status = '$status' WHERE id_siswa = '$id_siswa' AND tanggal = '$tgl_hari_ini'";
        } else {
            // 3. Jika BELUM ADA, baru kita INSERT baris baru
            $query = "INSERT INTO absensi (id_siswa, status, tanggal) VALUES ('$id_siswa', '$status', '$tgl_hari_ini')";
        }

        if (mysqli_query($conn, $query)) {
            $berhasil++;
        }
    }

    // Berikan notifikasi ke user
    $_SESSION['notif'] = "Presensi berhasil diperbarui untuk $berhasil siswa.";
    $_SESSION['notif_type'] = "success";
    
    // Redirect kembali ke halaman dashboard walikelas
    header("Location:walikelas.php"); 
    exit;
} else {
    // Jika akses langsung ke file ini tanpa POST
    header("Location:walikelas.php");
    exit;
}
?>