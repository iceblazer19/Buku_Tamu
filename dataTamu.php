<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>To-Do List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            max-width: 100vw;
            overflow-x: hidden;
            overflow: hidden !important;
        }
        body {
            font-family: Arial, sans-serif;
            background: #f4f6fb;
            min-height: 100vh;
            width: 100vw;
            margin: 0;
            padding: 0;
            max-width: 100vw;
            overflow-x: hidden;
        }
        .container-flex {
            display: flex;
            min-height: 100vh;
            width: 100vw;
            max-width: 100vw;
            overflow-x: hidden;
            height: 100vh;
            overflow: hidden;
        }
        .sidebar {
            width: 210px; /* was 170px */
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
            overflow: hidden;
        }
        header {
            margin: 0;
            padding: 32px 32px 16px 32px;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            width: 100%;
        }
        h2 {
            font-size: 2.2rem;
            color: #333;
            margin: 0;
        }
        main {
            width: 100%;
            min-height: calc(100vh - 80px);
            display: flex;
            flex-direction: column;
            align-items: stretch;
            background: #f4f6fb;
            padding: 0;
            max-width: 100vw;
            overflow-x: auto;
        }
        section {
            width: 100%;
            padding: 0 32px;
            box-sizing: border-box;
        }
        .add-task-link {
            margin: 24px 0 0 0;
            display: inline-block;
            font-size: 1.1rem;
            color: #007BFF;
            text-decoration: none;
            font-weight: bold;
        }
        .add-task-link:hover {
            text-decoration: underline;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            overflow: hidden;
            margin-top: 24px;
        }
        th, td {
            padding: 16px 18px;
            text-align: left;
            border-bottom: 1px solid #eee;
            font-size: 1.1rem;
        }
        th {
            background-color: #f4f4f4;
            font-size: 1.15rem;
        }
        tr:last-child td {
            border-bottom: none;
        }
        td a {
            font-size: 1rem;
            color: #007bff;
            margin-right: 8px;
            text-decoration: none;
        }
        td a:last-child {
            margin-right: 0;
        }
        td a i {
            font-size: 1.3rem;
            vertical-align: middle;
            transition: color 0.2s;
        }
        td a[title="Edit"]:hover i {
            color: #15e684;
        }
        td a[title="Hapus"]:hover i {
            color: #c82333;
        }
        @media (max-width: 700px) {
            .container-flex {
                flex-direction: column;
            }
            .sidebar {
                flex-direction: row;
                width: 100vw;
                height: auto;
                border-right: none;
                border-bottom: 1px solid #e0e0e0;
                box-shadow: none;
                padding: 0;
            }
            .sidebar-title {
                display: none;
            }
            .sidebar-link {
                flex: 1;
                justify-content: center;
                padding: 12px 0;
                border-left: none;
                border-bottom: 4px solid transparent;
                margin-bottom: 0;
            }
            .sidebar-link:hover, .sidebar-link.active {
                background: #eaf4ff;
                color: #007bff;
                border-bottom: 4px solid #007bff;
            }
            header, section {
                padding: 0 8px;
            }
            table, th, td {
                font-size: 1rem;
                padding: 10px 6px;
            }
        }
        .sidebar-dark-toggle {
            margin-top: 32px; /* was auto, now fixed higher */
            margin-bottom: 24px;
            width: 100%;
            display: flex;
            justify-content: center;
        }

        body.dark-mode {
            background: #181a1b !important;
            color: #e0e0e0 !important;
        }
        body.dark-mode .sidebar {
            background: #23272b !important;
            color: #e0e0e0 !important;
            border-right: 1px solid #333 !important;
        }
        body.dark-mode .sidebar-link,
        body.dark-mode .sidebar-title {
            color: #e0e0e0 !important;
        }
        body.dark-mode .sidebar-link.active,
        body.dark-mode .sidebar-link:hover {
            background: #222c37 !important;
            color: #4fc3f7 !important;
            border-left: 4px solid #4fc3f7 !important;
        }
        body.dark-mode .main-content,
        body.dark-mode header {
            background: #181a1b !important;
            color: #e0e0e0 !important;
        }
        body.dark-mode .container,
        body.dark-mode table {
            background: #23272b !important;
            color: #e0e0e0 !important;
            box-shadow: 0 2px 12px rgba(0,0,0,0.4) !important;
        }
        body.dark-mode th {
            background: #23272b !important;
            color: #e0e0e0 !important;
        }
        body.dark-mode td a,
        body.dark-mode .add-task-link {
            color: #4fc3f7 !important;
        }
        body.dark-mode input,
        body.dark-mode textarea,
        body.dark-mode select {
            background: #23272b !important;
            color: #e0e0e0 !important;
            border: 1px solid #444 !important;
        }
        body.dark-mode input:focus,
        body.dark-mode textarea:focus {
            border-color: #4fc3f7 !important;
        }
        body.dark-mode .back-link {
            color: #4fc3f7 !important;
        }
        body.dark-mode #editModal > form,
        body.dark-mode #deleteModal > div {
            background: #23272b !important;
            color: #e0e0e0 !important;
        }
        body.dark-mode #darkModeToggle {
            background: #23272b !important;
            color: #e0e0e0 !important;
        }

        @media (max-width: 700px) {
            .sidebar-dark-toggle {
                margin: 0;
            }
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
            
            <div class="sidebar-dark-toggle">
                <button id="darkModeToggle" style="width:90%;margin:24px auto 16px auto;display:flex;align-items:center;gap:10px;justify-content:center;padding:10px 0;border:none;border-radius:6px;background:#f4f4f4;color:#333;cursor:pointer;font-size:1rem;transition:background 0.2s;">
                    <i class="bi bi-moon"></i> <span id="darkModeText">Dark Mode</span>
                </button>
            </div>
        </nav>
        <div class="main-content">
            <header>
                <h2>Daftar Tamu</h2>
            </header>
            <main>
                <section>
                    <form method="get" class="search-bar" style="margin:24px 0 0 0; display:flex; gap:12px; align-items:center; position:relative;" autocomplete="off" ;>
                        <input 
                            type="text" 
                            name="search" 
                            id="searchInput"
                            placeholder="Cari berdasarkan nama..." 
                            value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
                            style="padding:10px 36px 10px 16px; border-radius:6px; border:1px solid #ccc; font-size:1.08rem; flex:1;"
                            autocomplete="off"
                        >
                        <button 
                            type="button" 
                            id="clearSearch"
                            style="position:absolute; right:125px; background:transparent; border:none; font-size:1.5rem; color:#888; cursor:pointer; top:50%; transform:translateY(-50%); display:none;"
                            aria-label="Clear search"
                            tabindex="-1"
                        >×</button>
                        <button 
                            type="submit" 
                            style="padding:10px 22px; border-radius:6px; border:none; background:#007bff; color:#fff; font-size:1.08rem; font-weight:bold; cursor:pointer; transition:background 0.2s;"
                        >
                            <i class="bi bi-search"></i> Cari
                        </button>
                    </form>
                </section>
                <section>
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Instansi</th>
                                <th>Tujuan Kedatangan</th>
                                <th>Tanggal & Waktu kedatangan</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $where = "";
                            if (isset($_GET['search']) && $_GET['search'] !== "") {
                                $search = mysqli_real_escape_string($koneksi, $_GET['search']);
                                $where = "WHERE nama LIKE '%$search%'";
                            }
                            $data = mysqli_query($koneksi, "SELECT * FROM buku_tamu $where");
                            while ($d = mysqli_fetch_array($data)) :
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo htmlspecialchars($d['nama']); ?></td>
                                <td><?php echo htmlspecialchars($d['instansi']); ?></td>
                                <td><?php echo htmlspecialchars($d['tujuan']); ?></td>
                                <td>
                                    <?php
                                        $datetime = $d['tanggal'] . ' ' . $d['waktu'];
                                        echo htmlspecialchars(date('d/m/Y H:i:s', strtotime($datetime)));
                                    ?>
                                </td>
                                <td>
                                    <a href="#" class="edit-btn" 
                                       data-id="<?php echo $d['id']; ?>"
                                       data-nama="<?php echo htmlspecialchars($d['nama']); ?>"
                                       data-instansi="<?php echo htmlspecialchars($d['instansi']); ?>"
                                       data-tujuan="<?php echo htmlspecialchars($d['tujuan']); ?>"
                                       title="Edit"><i class="bi bi-pencil-square"></i></a>
                                    <a href="delete.php?id=<?php echo $d['id']; ?>" title="Hapus"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </section>
            </main>
        </div>
    </div>
    <div id="editModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center;">
        <form id="editForm" style="background:#fff; padding:24px; border-radius:8px; width:90%; max-width:400px;">
            <h3 style="margin:0 0 16px 0;">Edit Data Tamu</h3>
            <input type="hidden" id="edit_id" name="id">
            <div style="margin-bottom:12px;">
                <label for="edit_nama" style="display:block; margin-bottom:6px;">Nama</label>
                <input type="text" id="edit_nama" name="nama" required style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
            </div>
            <div style="margin-bottom:12px;">
                <label for="edit_instansi" style="display:block; margin-bottom:6px;">Instansi</label>
                <input type="text" id="edit_instansi" name="instansi" required style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
            </div>
            <div style="margin-bottom:12px;">
                <label for="edit_tujuan" style="display:block; margin-bottom:6px;">Tujuan</label>
                <input type="text" id="edit_tujuan" name="tujuan" required style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
            </div>
            <div style="display:flex; gap:12px; justify-content:flex-end;">
                <button type="button" id="closeModal" style="padding:8px 16px; border:none; background:#ccc; color:#333; border-radius:4px; cursor:pointer;">Batal</button>
                <button type="submit" style="padding:8px 16px; border:none; background:#007bff; color:#fff; border-radius:4px; cursor:pointer;">Simpan</button>
            </div>
        </form>
    </div>
    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.4); justify-content:center; align-items:center; z-index:9999;">
        <div style="background:#fff; border-radius:10px; max-width:340px; width:90%; padding:28px 22px 18px 22px; box-shadow:0 2px 16px rgba(0,0,0,0.18); text-align:center;">
            <div style="font-size:1.3rem; margin-bottom:16px;">Yakin ingin menghapus data ini?</div>
            <div style="display:flex; gap:12px; justify-content:center; margin-top:18px;">
                <button type="button" id="cancelDelete" style="padding:8px 18px; border:none; background:#ccc; color:#333; border-radius:4px; cursor:pointer;">Batal</button>
                <a href="#" id="confirmDelete" style="padding:8px 18px; background:#c82333; color:#fff; border-radius:4px; text-decoration:none; font-weight:bold;">Hapus</a>
            </div>
        </div>
    </div>
    <?php if (isset($_GET['deleted'])): ?>
    <script>
        alert('Data berhasil dihapus!');
        if (window.history.replaceState) {
            const url = new URL(window.location);
            url.searchParams.delete('deleted');
            window.history.replaceState({}, document.title, url.pathname + url.search);
        }
    </script>
    <?php endif; ?>
    <script>
        const searchInput = document.getElementById('searchInput');
        const clearBtn = document.getElementById('clearSearch');

        function toggleClearBtn() {
            if (searchInput.value.length > 0) {
                clearBtn.style.display = 'block';
            } else {
                clearBtn.style.display = 'none';
            }
        }

        if (clearBtn && searchInput) {
            clearBtn.onclick = function(e) {
                e.preventDefault();
                searchInput.value = '';
                toggleClearBtn();
                searchInput.focus();
            };
            searchInput.addEventListener('input', toggleClearBtn);
            // Initial state
            toggleClearBtn();
        }

        // Remove ?search=... from URL after page load (if present)
        window.addEventListener('DOMContentLoaded', function() {
            const url = new URL(window.location);
            if (url.searchParams.has('search')) {
                url.searchParams.delete('search');
                window.history.replaceState({}, document.title, url.pathname + url.search);
            }
        });

        document.querySelectorAll('.edit-btn').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                // Fill modal form with data
                document.getElementById('edit_id').value = this.dataset.id;
                document.getElementById('edit_nama').value = this.dataset.nama;
                document.getElementById('edit_instansi').value = this.dataset.instansi;
                document.getElementById('edit_tujuan').value = this.dataset.tujuan;
                document.getElementById('editModal').style.display = 'flex';
            });
        });
        document.getElementById('closeModal').onclick = function() {
            document.getElementById('editModal').style.display = 'none';
        };

        // Prevent interaction with background when modal is open
        document.getElementById('editModal').addEventListener('mousedown', function(e) {
            // Only close if the close button is clicked
            if (e.target === document.getElementById('editModal')) {
                // Do nothing (prevent accidental close)
                e.stopPropagation();
                e.preventDefault();
            }
        });

        // Handle form submit via AJAX
        document.getElementById('editForm').onsubmit = function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            fetch('edit.php', {
                method: 'POST',
                body: formData
            })
            .then(resp => resp.text())
            .then(resp => {
                // Optionally show success/error
                document.getElementById('editModal').style.display = 'none';
                location.reload(); // Reload to update table
            });
        };

        // Delete popup logic
        let deleteUrl = '';
        document.querySelectorAll('a[title="Hapus"]').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                deleteUrl = this.getAttribute('href');
                document.getElementById('deleteModal').style.display = 'flex';
            });
        });
        document.getElementById('cancelDelete').onclick = function() {
            document.getElementById('deleteModal').style.display = 'none';
            deleteUrl = '';
        };
        document.getElementById('confirmDelete').onclick = function(e) {
            e.preventDefault();
            if (deleteUrl) {
                window.location.href = deleteUrl;
            }
        };
        // Prevent closing modal by clicking outside
        document.getElementById('deleteModal').addEventListener('mousedown', function(e) {
            if (e.target === document.getElementById('deleteModal')) {
                e.stopPropagation();
                e.preventDefault();
            }
        });

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
