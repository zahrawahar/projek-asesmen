<?php
include 'koneksi.php';
$tgl_sekarang = date('Y-m-d');

// Statistik Ringkas
$res_total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as t FROM siswas"))['t'] ?? 0;
$res_absen = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as t FROM absensi WHERE tanggal = '$tgl_sekarang' AND status != 'hadir'"))['t'] ?? 0;
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGAP | Sistem Informasi & Presensi Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">

    <style>
        :root {
            --primary: #064e3b;
            --primary-light: #065f46;
            --accent: #10b981;
            --gold: #fbbf24;
            --white: #ffffff;
            --soft-bg: #f0fdf4;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
            background: var(--white);
            color: #1e293b;
            scroll-behavior: smooth;
            overflow-x: hidden;
        }

        /* NAVIGATION */
        nav {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            padding: 20px 0;
            transition: 0.4s;
            background: transparent;
        }

        nav.scrolled {
            background: rgba(6, 78, 59, 0.95);
            backdrop-filter: blur(10px);
            padding: 15px 0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .logo-text {
            color: white;
            font-weight: 800;
            font-size: 1.5rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* HERO SECTION - REVISED FOR BETTER SPACING */
        .hero {
            background: linear-gradient(rgba(6, 78, 59, 0.8), rgba(6, 78, 59, 0.9)),
                url('https://images.unsplash.com/photo-1523050853063-915894372073?auto=format&fit=crop&q=80&w=2070');
            background-size: cover;
            background-position: center;
            height: 95vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            padding: 20px;
            clip-path: ellipse(120% 100% at 50% 0%);
        }

        .hero-content h1 {
            font-size: 3.8rem;
            font-weight: 800;
            margin: 0;
            line-height: 1.2;
            /* Jarak antar baris diperbaiki */
            letter-spacing: -1px;
        }

        .hero-title-sub {
            display: block;
            margin-top: 15px;
            /* Jarak antara baris 1 dan baris 2 */
            color: var(--gold);
            font-size: 3.2rem;
            filter: drop-shadow(0 4px 10px rgba(0, 0, 0, 0.3));
        }

        .hero-content p {
            font-size: 1.1rem;
            margin: 30px 0 45px;
            opacity: 0.9;
            max-width: 750px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }

        .btn-gold {
            background: var(--gold);
            color: var(--primary);
            padding: 18px 40px;
            border-radius: 15px;
            text-decoration: none;
            font-weight: 800;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 10px 25px rgba(251, 191, 36, 0.3);
        }

        .btn-gold:hover {
            transform: translateY(-5px);
            background: white;
            box-shadow: 0 15px 30px rgba(255, 255, 255, 0.2);
        }

        /* STATS OVERLAY */
        .stats-wrapper {
            max-width: 1000px;
            margin: -100px auto 0;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            padding: 0 20px;
            position: relative;
            z-index: 10;
        }

        .stat-card {
            background: white;
            padding: 35px;
            border-radius: 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
            text-align: center;
            border-top: 5px solid var(--gold);
        }

        .stat-card h2 {
            font-size: 3rem;
            margin: 0;
            color: var(--primary);
        }

        .stat-card span {
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1px;
        }

        /* SECTION STYLING */
        .section-padding {
            padding: 100px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-header h2 {
            font-size: 2.5rem;
            color: var(--primary);
            margin: 0;
        }

        .section-header .divider {
            width: 60px;
            height: 5px;
            background: var(--gold);
            margin: 15px auto;
            border-radius: 10px;
        }

        /* ALUR KERJA */
        .workflow-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .work-step {
            text-align: center;
            position: relative;
        }

        .step-num {
            width: 50px;
            height: 50px;
            background: var(--primary);
            color: var(--gold);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-weight: 800;
            font-size: 1.2rem;
        }

        /* VISI MISI */
        .vm-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
        }

        .vm-card {
            background: var(--soft-bg);
            padding: 50px;
            border-radius: 40px;
            position: relative;
            overflow: hidden;
        }

        .vm-card::after {
            content: '\f06e';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            right: -20px;
            bottom: -20px;
            font-size: 10rem;
            color: rgba(6, 78, 59, 0.05);
        }

        /* FOOTER */
        footer {
            background: var(--primary);
            color: white;
            padding: 80px 20px 30px;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 50px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 50px;
        }

        .footer-link {
            color: white;
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
            opacity: 0.7;
            transition: 0.3s;
        }

        .footer-link:hover {
            opacity: 1;
            color: var(--gold);
            padding-left: 5px;
        }

        @media (max-width: 900px) {
            .hero-content h1 {
                font-size: 2.5rem;
            }

            .hero-title-sub {
                font-size: 2.2rem;
            }

            .stats-wrapper,
            .vm-container,
            .workflow-grid,
            .footer-content {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <nav id="navbar">
        <div class="nav-container">
            <a href="#" class="logo-text">
                <i class="fas fa-fingerprint" style="color: var(--gold);"></i> SIGAP
            </a>
            <a href="login.php" class="btn-gold" style="padding: 10px 25px; font-size: 0.9rem;">
                PORTAL LOGIN
            </a>
        </div>
    </nav>

    <section class="hero">
        <div class="hero-content" data-aos="fade-up">
            <div style="font-size: 3.5rem; margin-bottom: 25px;"><i class="fas fa-fingerprint" style="color: var(--gold);"></i></div>
            <h1>
                Sistem Digital
                <span class="hero-title-sub">Kehadiran Siswa MAKN Ende</span>
            </h1>
            <p>Membangun kedisiplinan masa depan dengan sistem monitoring presensi yang transparan, akurat, dan terintegrasi secara real-time demi mewujudkan generasi muslim terampil.</p>
            <div class="hero-btns">
                <a href="#tentang" class="btn-gold">PELAJARI SISTEM <i class="fas fa-chevron-down"></i></a>
            </div>
        </div>
    </section>

    <div class="stats-wrapper">
        <div class="stat-card" data-aos="zoom-in" data-aos-delay="100">
            <span>DATABASE SISWA</span>
            <h2><?= $res_total; ?></h2>
            <small>Siswa Terintegrasi</small>
        </div>
        <div class="stat-card" data-aos="zoom-in" data-aos-delay="200" style="border-top-color: var(--accent);">
            <span>AKTIVITAS HARI INI</span>
            <h2><?= $res_absen; ?></h2>
            <small>Siswa Tidak Hadir</small>
        </div>
        <div class="stat-card" data-aos="zoom-in" data-aos-delay="300">
            <span>KECEPATAN DATA</span>
            <h2>100%</h2>
            <small>Real-time Reporting</small>
        </div>
    </div>

    <section class="section-padding" id="tentang">
        <div class="section-header" data-aos="fade-up">
            <h2>Alur Kerja SIGAP</h2>
            <div class="divider"></div>
            <p style="color: #64748b;">Efisiensi Koordinasi Pembina & Wali Kelas</p>
        </div>

        <div class="workflow-grid">
            <div class="work-step" data-aos="fade-up" data-aos-delay="100">
                <div class="step-num">01</div>
                <h3>Pemeriksaan</h3>
                <p style="font-size: 0.9rem; color: #64748b;">Pembina mengecek kehadiran siswa di asrama atau lingkungan sekolah.</p>
            </div>
            <div class="work-step" data-aos="fade-up" data-aos-delay="200">
                <div class="step-num">02</div>
                <h3>Input Data</h3>
                <p style="font-size: 0.9rem; color: #64748b;">Data ketidakhadiran diinput langsung ke portal pembina secara instan.</p>
            </div>
            <div class="work-step" data-aos="fade-up" data-aos-delay="300">
                <div class="step-num">03</div>
                <h3>Notifikasi</h3>
                <p style="font-size: 0.9rem; color: #64748b;">Dashboard Wali Kelas terupdate secara otomatis tanpa perlu laporan fisik.</p>
            </div>
            <div class="work-step" data-aos="fade-up" data-aos-delay="400">
                <div class="step-num">04</div>
                <h3>Rekapitulasi</h3>
                <p style="font-size: 0.9rem; color: #64748b;">Memudahkan wali kelas dalam evaluasi laporan bulanan dan semester.</p>
            </div>
        </div>
    </section>

    <section class="section-padding" style="background: #fafafa;">
        <div class="vm-container">
            <div class="vm-card" data-aos="fade-right">
                <h2 style="color: var(--primary);"><i class="fas fa-rocket"></i> Visi</h2>
                <p style="font-weight: 600; line-height: 1.8;">“MENCIPTAKAN GENERASI MUSLIM TERAMPIL, INOVATIF, KREATIF, PROFESIONAL DAN BERKARAKTER ISLAMI”</p>
            </div>
            <div class="vm-card" data-aos="fade-left" style="background: var(--primary); color: white;">
                <h2 style="color: var(--gold);"><i class="fas fa-bullseye"></i> Misi</h2>
                <ul style="padding-left: 20px; opacity: 0.9; line-height: 1.7;">
                    <li>Menyiapkan calon pemimpin masa depan menguasai IPTEK, daya juang tinggi, dan landasan IMTAK yang kuat.</li>
                    <li>Menyiapkan generasi muslim yang menguasai Bahasa Arab dan Bahasa Inggris.</li>
                    <li>Menyiapkan generasi muslim yang menguasai Al-Quran dan Hadits serta mengamalkannya.</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="section-padding">
        <div class="section-header" data-aos="fade-up">
            <h2>Keunggulan SIGAP</h2>
            <div class="divider"></div>
        </div>

        <div class="workflow-grid" style="grid-template-columns: repeat(3, 1fr);">
            <div class="work-step" style="text-align: left; background: #fff; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
                <i class="fas fa-shield-halved" style="font-size: 2rem; color: var(--accent); margin-bottom: 15px;"></i>
                <h3>Keamanan Berlapis</h3>
                <p style="font-size: 0.9rem; color: #64748b;">Data dienkripsi dan hanya dapat diakses melalui kredensial resmi sekolah.</p>
            </div>
            <div class="work-step" style="text-align: left; background: #fff; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
                <i class="fas fa-chart-line" style="font-size: 2rem; color: var(--accent); margin-bottom: 15px;"></i>
                <h3>Analisis Performa</h3>
                <p style="font-size: 0.9rem; color: #64748b;">Statistik real-time memudahkan evaluasi kedisiplinan siswa secara akurat.</p>
            </div>
            <div class="work-step" style="text-align: left; background: #fff; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
                <i class="fas fa-cloud" style="font-size: 2rem; color: var(--accent); margin-bottom: 15px;"></i>
                <h3>Sistem Terpusat</h3>
                <p style="font-size: 0.9rem; color: #64748b;">Akses data presensi kapan saja dan di mana saja melalui jaringan internet.</p>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <div>
                <h2 style="color: var(--gold); margin: 0 0 20px;">SIGAP MAKN Ende</h2>
                <p style="opacity: 0.7; line-height: 1.8;">Inovasi digital untuk mendukung manajemen kesiswaan yang lebih modern di lingkungan Madrasah Aliyah Kejuruan Negeri Ende.</p>
            </div>
            <div>
                <h4>Navigasi</h4>
                <a href="#" class="footer-link">Beranda</a>
                <a href="#tentang" class="footer-link">Tentang Sistem</a>
                <a href="login.php" class="footer-link">Portal Login</a>
            </div>
            <div>
                <h4>Kontak Sekolah</h4>
                <p style="opacity: 0.7;">Anaraja, Kec. Nangapanda, Kab. Ende<br>Nusa Tenggara Timur</p>
                <div style="display: flex; gap: 15px; margin-top: 20px;">
                    <a href="https://makn-ende.sch.id/" target="_blank" style="color: white; font-size: 1.2rem;"><i class="fas fa-globe"></i></a>
                    <a href="#" style="color: white; font-size: 1.2rem;"><i class="fab fa-instagram"></i></a>
                    <a href="#" style="color: white; font-size: 1.2rem;"><i class="fab fa-facebook"></i></a>
                </div>
            </div>
        </div>
        <div style="text-align: center; margin-top: 50px; opacity: 0.5; font-size: 0.8rem;">
            &copy; 2026 SIGAP MAKN Ende. All Rights Reserved.
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true
        });

        // Navbar Animation on Scroll
        window.addEventListener('scroll', function() {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 50) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });
    </script>
</body>

</html>