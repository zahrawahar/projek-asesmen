<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// Cek role dan arahkan ke halaman masing-masing
if ($_SESSION['role'] == 'walikelas') {
    header("Location: walikelas.php");
} else {
    header("Location: pembina.php");
}
exit;
