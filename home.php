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
    <link rel="stylesheet" href="style.css">
    
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