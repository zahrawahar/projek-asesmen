<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'walikelas') {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $id_walikelas = $_SESSION['id'];

    // Kita hapus dulu data absensi siswa ini agar tidak error (Foreign Key Constraint)
    mysqli_query($conn, "DELETE FROM absensi WHERE id_siswa = '$id'");

    // Baru hapus siswanya
    $query = "DELETE FROM siswas WHERE id = '$id' AND id_walikelas = '$id_walikelas'";

    if (mysqli_query($conn, $query)) {
        // Kirim status sukses ke URL
        header("Location: walikelas.php?status=deleted");
    } else {
        // Kirim status gagal ke URL
        header("Location: walikelas.php?status=error");
    }
} else {
    header("Location: walikelas.php");
}
exit;
