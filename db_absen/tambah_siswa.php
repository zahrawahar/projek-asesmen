<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'walikelas') {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Siswa | E-Absen</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1b5e20;
            --primary-light: #2e7d32;
            --accent: #ffd700;
            --white: #ffffff;
            --bg: #f0f4f3;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg);
            background-image: radial-gradient(circle at 0% 0%, rgba(27, 94, 32, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 100% 100%, rgba(255, 215, 0, 0.05) 0%, transparent 50%);
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 600px;
            padding: 20px;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        /* Dekorasi Sudut */
        .glass-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 8px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h2 {
            color: var(--primary);
            margin: 0;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .header p {
            color: #666;
            font-size: 0.9rem;
            margin-top: 5px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 8px;
            margin-left: 5px;
        }

        textarea {
            width: 100%;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 16px;
            font-family: inherit;
            font-size: 0.95rem;
            resize: none;
            min-height: 150px;
            box-sizing: border-box;
            transition: all 0.3s ease;
            background: #fdfdfd;
        }

        textarea:focus {
            border-color: var(--primary-light);
            outline: none;
            box-shadow: 0 0 15px rgba(46, 125, 50, 0.1);
            background: #fff;
        }

        .grid-inputs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            background: white;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        select:focus {
            border-color: var(--primary-light);
            outline: none;
        }

        .jurusan-flex {
            display: flex;
            gap: 5px;
        }

        .btn-submit {
            width: 100%;
            background: linear-gradient(45deg, var(--primary), var(--primary-light));
            color: white;
            border: none;
            padding: 18px;
            border-radius: 16px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(27, 94, 32, 0.2);
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 25px rgba(27, 94, 32, 0.3);
            filter: brightness(1.1);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #888;
            text-decoration: none;
            font-size: 0.85rem;
            transition: 0.3s;
        }

        .back-link:hover {
            color: var(--primary);
        }

        /* Animasi masuk */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .glass-card {
            animation: fadeInUp 0.6s ease-out;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="glass-card">
            <div class="header">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/af/Kementerian_Agama_new_logo.png/600px-Kementerian_Agama_new_logo.png" style="width: 50px; margin-bottom: 10px;">
                <h2>Input Data Siswa</h2>
                <p>Daftarkan seluruh siswa Anda sekaligus dalam hitungan detik.</p>
            </div>

            <form action="tambah_siswa.php" method="POST">
                <div class="form-group">
                    <label>Daftar Nama (Pisahkan dengan Enter)</label>
                    <textarea name="nama_massal" placeholder="Contoh:&#10;Muhammad Ali&#10;Siti Fatimah&#10;Zulkifli Mansur" required></textarea>
                </div>

                <div class="grid-inputs">
                    <div class="form-group">
                        <label>Pilih Kelas</label>
                        <select name="kelas" required>
                            <option value="">Tingkat</option>
                            <option value="10">Kelas 10</option>
                            <option value="11">Kelas 11</option>
                            <option value="12">Kelas 12</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Jurusan & Ruang</label>
                        <div class="jurusan-flex">
                            <select name="jurusan" required>
                                <option value="">Jurusan</option>
                                <option value="PPLG">PPLG</option>
                                <option value="DKV">DKV</option>
                            </select>
                            <select name="nomor_kelas" required style="max-width: 70px;">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    🚀 Simpan Semua Siswa
                </button>
            </form>

            <a href="walikelas.php" class="back-link"> Kembali ke Dashboard</a>
        </div>
    </div>

</body>

</html>