<?php
session_start();
include 'koneksi.php';

$login_status = ""; // Variabel kontrol untuk SweetAlert
$target_url = "";
$nama_user = "";

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    $password_md5 = md5($password);

    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password_md5'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // SET SESSION
        $_SESSION['role'] = $row['role'];
        $_SESSION['id']   = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['nama_guru'] = (!empty($row['nama_lengkap'])) ? $row['nama_lengkap'] : $row['username'];

        $nama_user = $_SESSION['nama_guru'];

        // Tentukan Redirect
        if ($row['role'] == 'walikelas') {
            $target_url = "walikelas.php";
        } elseif ($row['role'] == 'pembina') {
            $target_url = "pembina.php";
        } elseif ($row['role'] == 'admin') {
            $target_url = "admin_dashboard.php";
        } else {
            $target_url = "dashboard.php";
        }

        $login_status = "success";
    } else {
        $login_status = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login E-Absensi | Digital Madrasah</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        :root {
            --primary: #064e3b;
            --primary-light: #065f46;
            --gold: #fbbf24;
            --bg-body: #f1f5f9;
        }

        * {
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--primary);
            background-image: radial-gradient(circle at top right, var(--primary-light), var(--primary));
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            overflow: hidden;
        }

        .login-card {
            background: white;
            padding: 50px 40px;
            border-radius: 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 420px;
            text-align: center;
            position: relative;
            border-bottom: 8px solid var(--gold);
            animation: fadeInDown 0.8s ease-out;
        }

        .login-card img {
            width: 90px;
            margin-bottom: 20px;
            filter: drop-shadow(0 5px 10px rgba(0, 0, 0, 0.1));
        }

        .login-card h2 {
            color: var(--primary);
            margin: 0;
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .subtitle {
            color: #64748b;
            font-size: 0.95em;
            margin-bottom: 35px;
            font-weight: 500;
        }

        .input-group {
            margin-bottom: 25px;
            text-align: left;
        }

        .input-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 10px;
            margin-left: 5px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            transition: 0.3s;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 15px 15px 15px 50px;
            border: 2px solid #e2e8f0;
            border-radius: 20px;
            outline: none;
            transition: 0.3s;
            font-size: 1rem;
            background: #f8fafc;
        }

        input:focus {
            border-color: var(--gold);
            background: white;
            box-shadow: 0 0 0 5px rgba(251, 191, 36, 0.1);
        }

        input:focus+i {
            color: var(--gold);
        }

        .btn-login {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            border: none;
            border-radius: 20px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
            box-shadow: 0 10px 20px -5px rgba(6, 78, 59, 0.4);
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 25px -5px rgba(6, 78, 59, 0.5);
        }

        .footer {
            margin-top: 35px;
            font-size: 0.8em;
            color: #94a3b8;
            line-height: 1.6;
        }

        /* --- Custom SweetAlert Style --- */
        .swal-popup-custom {
            border-radius: 35px !important;
            padding: 2.5rem !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
        }

        .swal-title-custom {
            color: var(--primary) !important;
            font-weight: 800 !important;
        }

        .swal-confirm-custom {
            border-radius: 15px !important;
            padding: 12px 35px !important;
            background: var(--primary) !important;
            font-weight: 700 !important;
        }
    </style>
</head>

<body>

    <div class="login-card">
        <img src="gambar/logo makn.png" alt="Logo">
        <h2>SIGAP</h2>
        <p class="subtitle">Sistem Informasi Guru & Absensi Pelajar</p>

        <form method="POST" id="loginForm">
            <div class="input-group">
                <label>Username</label>
                <div class="input-wrapper">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" placeholder="Masukkan username" required>
                </div>
            </div>

            <div class="input-group">
                <label>Password</label>
                <div class="input-wrapper">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" name="login" class="btn-login">
                Masuk ke Sistem <i class="fas fa-arrow-right" style="margin-left: 8px; font-size: 0.9rem;"></i>
            </button>
        </form>

        <div class="footer">
            &copy; <?= date("Y"); ?> <b>Digital Madrasah</b><br>
            Presensi Real-time & Monitoring Terpadu
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if ($login_status == "success"): ?>
                Swal.fire({
                    title: 'Berhasil Masuk!',
                    text: 'Selamat datang, <?= $nama_user; ?>. Mengalihkan ke dashboard...',
                    icon: 'success',
                    iconColor: '#10b981',
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    customClass: {
                        popup: 'swal-popup-custom',
                        title: 'swal-title-custom'
                    },
                    showClass: {
                        popup: 'animate__animated animate__zoomIn'
                    }
                }).then(function() {
                    window.location.href = "<?= $target_url; ?>";
                });

            <?php elseif ($login_status == "error"): ?>
                Swal.fire({
                    title: 'Akses Ditolak',
                    text: 'Username atau password salah. Silakan periksa kembali.',
                    icon: 'error',
                    iconColor: '#ef4444',
                    confirmButtonText: 'Coba Lagi',
                    customClass: {
                        popup: 'swal-popup-custom',
                        title: 'swal-title-custom',
                        confirmButton: 'swal-confirm-custom'
                    },
                    showClass: {
                        popup: 'animate__animated animate__headShake'
                    }
                });
            <?php endif; ?>
        });
    </script>

</body>

</html>