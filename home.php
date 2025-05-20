<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $instansi = mysqli_real_escape_string($koneksi, $_POST['instansi']);
    $tujuan = mysqli_real_escape_string($koneksi, $_POST['tujuan']);
    $tanggal = mysqli_real_escape_string($koneksi, $_POST['tanggal']);
    $waktu = mysqli_real_escape_string($koneksi, $_POST['waktu']);

    $query = "INSERT INTO buku_tamu (nama, instansi, tujuan, tanggal, waktu) VALUES ('$nama', '$instansi', '$tujuan', '$tanggal', '$waktu')";
    if (mysqli_query($koneksi, $query)) {
        header("Location: data_tamu.php?success=1");
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
        body {
            font-family: Arial, sans-serif;
            background: #f4f6fb;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 420px;
            margin: 48px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            padding: 32px 28px 24px 28px;
        }
        h2 {
            text-align: center;
            margin-bottom: 28px;
            color: #007bff;
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

            <label for="tanggal">Tanggal Kedatangan</label>
            <input type="date" name="tanggal" id="tanggal" required>

            <label for="waktu">Waktu Kedatangan</label>
            <input type="time" name="waktu" id="waktu" required>

            <button type="submit"><i class="bi bi-save"></i> Simpan</button>
        </form>
        <a href="data_tamu.php" class="back-link"><i class="bi bi-arrow-left"></i> Kembali ke Data Tamu</a>
    </div>
</body>
</html>