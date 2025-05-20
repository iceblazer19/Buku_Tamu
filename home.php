<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $instansi = mysqli_real_escape_string($koneksi, $_POST['instansi']);
    $tujuan = mysqli_real_escape_string($koneksi, $_POST['tujuan']);

    // Set tanggal dan waktu otomatis
    date_default_timezone_set('Asia/Jakarta'); // Ganti sesuai zona waktu Anda
    $tanggal = date('Y-m-d');
    $waktu = date('H:i:s');

    $query = "INSERT INTO buku_tamu (nama, instansi, tujuan, tanggal, waktu) VALUES ('$nama', '$instansi', '$tujuan', '$tanggal', '$waktu')";
    if (mysqli_query($koneksi, $query)) {
        header("Location: dataTamu.php?success=1");
        exit;
    } else {
        $error = "Gagal menyimpan data!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Input Data Tamu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            max-width: 100vw;
            overflow-x: hidden;
        }
        body {
            font-family: Arial, sans-serif;
            background: #f4f6fb;
            min-height: 100vh;
            width: 100vw;
        }
        .container-flex {
            display: flex;
            min-height: 100vh;
            width: 100vw;
            max-width: 100vw;
            overflow-x: hidden;
        }
        .sidebar {
            width: 210px;
            background: #fff;
            border-right: 1px solid #e0e0e0;
            display: flex;
            flex-direction: column;
            align-items: stretch;
            padding: 32px 0 0 0;
            box-shadow: 2px 0 8px rgba(0,0,0,0.03);
            min-height: 100vh;
        }
        .sidebar-title {
            font-size: 1.1rem;
            font-weight: bold;
            color: #007bff;
            padding: 0 24px 18px 24px;
            margin-bottom: 8px;
            letter-spacing: 1px;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 12px 24px;
            color: #333;
            text-decoration: none;
            font-size: 1.05rem;
            border-left: 4px solid transparent;
            transition: background 0.2s, border-color 0.2s, color 0.2s;
            margin-bottom: 4px;
        }
        .sidebar-link i {
            margin-right: 10px;
            font-size: 1.2rem;
        }
        .sidebar-link:hover, .sidebar-link.active {
            background: #eaf4ff;
            color: #007bff;
            border-left: 4px solid #007bff;
        }
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            background: #f4f6fb;
            max-width: 100vw;
            overflow-x: auto;
            justify-content: center; /* Center vertically */
            align-items: center;     /* Center horizontally */
        }
        .container {
            max-width: 600px; /* Make form wider */
            width: 100%;
            margin: 48px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            padding: 40px 36px 32px 36px; /* More padding */
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        h2 {
            text-align: center;
            margin-bottom: 28px;
            color: #007bff;
            font-size: 2rem;
        }
        form label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }
        form input, form textarea {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
            box-sizing: border-box;
        }
        form button {
            width: 100%;
            padding: 12px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 1.08rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
        }
        form button:hover {
            background: #0056b3;
        }
        .back-link {
            display: inline-block;
            margin-top: 18px;
            color: #007bff;
            text-decoration: none;
            font-size: 1rem;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        .error {
            color: #c82333;
            margin-bottom: 16px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container-flex">
        <nav class="sidebar">
            <div class="sidebar-title">Menu</div>
            <a href="home.php" class="sidebar-link<?php echo basename($_SERVER['PHP_SELF']) == 'home.php' ? ' active' : ''; ?>">
                <i class="bi bi-house"></i> Home
            </a>
            <a href="dataTamu.php" class="sidebar-link<?php echo basename($_SERVER['PHP_SELF']) == 'dataTamu.php' ? ' active' : ''; ?>">
                <i class="bi bi-people"></i> Data Tamu
            </a>
        </nav>
        <div class="main-content">
            <div class="container">
                <h2>Input Data Tamu</h2>
                <?php if (!empty($error)): ?>
                    <div class="error"><?php echo $error; ?></div>
                <?php endif; ?>
                <form method="post" autocomplete="off">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" id="nama" required>

                    <label for="instansi">Instansi</label>
                    <input type="text" name="instansi" id="instansi" required>

                    <label for="tujuan">Tujuan Kedatangan</label>
                    <textarea name="tujuan" id="tujuan" rows="2" required></textarea>

                    <!-- Tanggal & Waktu tidak perlu diinput manual -->
                    <div style="margin-bottom:18px; color:#888; font-size:0.98rem;">
                        Tanggal dan waktu kedatangan akan diisi otomatis saat data ditambahkan.
                    </div>

                    <button type="submit"><i class="bi bi-save"></i> Simpan</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>