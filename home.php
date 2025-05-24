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
    <script>
    if (localStorage.getItem('darkMode') === '1') {
        document.documentElement.classList.add('dark-mode');
    }
    </script>
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
            <div class="sidebar-dark-toggle">
                <button id="darkModeToggle" style="width:90%;margin:24px auto 16px auto;display:flex;align-items:center;gap:10px;justify-content:center;padding:10px 0;border:none;border-radius:6px;background:#f4f4f4;color:#333;cursor:pointer;font-size:1rem;transition:background 0.2s;">
                    <i class="bi bi-moon"></i> <span id="darkModeText">Dark Mode</span>
                </button>
            </div>
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
    <script>
        const darkModeToggle = document.getElementById('darkModeToggle');
        const darkModeText = document.getElementById('darkModeText');
        const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        const savedMode = localStorage.getItem('darkMode');

        function setDarkMode(on) {
            if (on) {
                document.body.classList.add('dark-mode');
                darkModeText.textContent = 'Light Mode';
                darkModeToggle.querySelector('i').className = 'bi bi-brightness-high';
                localStorage.setItem('darkMode', 'on');
            } else {
                document.body.classList.remove('dark-mode');
                darkModeText.textContent = 'Dark Mode';
                darkModeToggle.querySelector('i').className = 'bi bi-moon';
                localStorage.setItem('darkMode', 'off');
            }
        }

        if (savedMode === 'on' || (savedMode === null && prefersDark)) {
            setDarkMode(true);
        } else {
            setDarkMode(false);
        }

        darkModeToggle.onclick = function() {
            setDarkMode(!document.body.classList.contains('dark-mode'));
        };
    </script>
</body>
</html>