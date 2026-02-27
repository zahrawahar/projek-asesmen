<?php
session_start();
include 'koneksi.php';

date_default_timezone_set('Asia/Makassar'); // Zona NTT

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['absen'])) {
    $id_walikelas = $_SESSION['id'];
    $tanggal_db = date('Y-m-d');
    $hari_array = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
    $ket_waktu = $hari_array[date('w')] . ", " . date('d F Y');

    $data_absen = $_POST['absen'];

    foreach ($data_absen as $id_siswa => $status) {
        $id_siswa = mysqli_real_escape_string($conn, $id_siswa);
        $status = mysqli_real_escape_string($conn, $status);

        // Simpan ke database
        $query_insert = "INSERT INTO absensi (id_siswa, id_walikelas, tanggal, status, keterangan_waktu) 
                         VALUES ('$id_siswa', '$id_walikelas', '$tanggal_db', '$status', '$ket_waktu')";
        mysqli_query($conn, $query_insert);
    }

    // Setelah simpan, arahkan ke halaman laporan khusus hari ini
    header("Location: laporan_harian.php?tgl=$tanggal_db");
    exit;
}
