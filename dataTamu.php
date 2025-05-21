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
                    <form method="get" class="search-bar" autocomplete="off">
                        <input 
                            type="text" 
                            name="search" 
                            id="searchInput"
                            placeholder="Cari berdasarkan nama..." 
                            value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
                            autocomplete="off"
                        >
                        <button 
                            type="button" 
                            id="clearSearch"
                            aria-label="Clear search"
                            tabindex="-1"
                        >×</button>
                        <select name="sort" id="sortSelect" style="height:44px; border-radius:6px; border:1px solid #ccc; font-size:1.08rem; margin:0 6px; padding:0 10px;">
                            <option value="">Urutkan</option>
                            <option value="nama_asc" <?php if(isset($_GET['sort']) && $_GET['sort']=='nama_asc') echo 'selected'; ?>>Nama A-Z</option>
                            <option value="nama_desc" <?php if(isset($_GET['sort']) && $_GET['sort']=='nama_desc') echo 'selected'; ?>>Nama Z-A</option>
                            <option value="tanggal_desc" <?php if(isset($_GET['sort']) && $_GET['sort']=='tanggal_desc') echo 'selected'; ?>>Tanggal Terbaru</option>
                            <option value="tanggal_asc" <?php if(isset($_GET['sort']) && $_GET['sort']=='tanggal_asc') echo 'selected'; ?>>Tanggal Terlama</option>
                        </select>
                        <button 
                            type="submit" 
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
                            $order = "ORDER BY id DESC";
                            if (isset($_GET['search']) && $_GET['search'] !== "") {
                                $search = mysqli_real_escape_string($koneksi, $_GET['search']);
                                $where = "WHERE nama LIKE '%$search%'";
                            }
                            if (isset($_GET['sort'])) {
                                switch ($_GET['sort']) {
                                    case 'nama_asc':
                                        $order = "ORDER BY nama ASC";
                                        break;
                                    case 'nama_desc':
                                        $order = "ORDER BY nama DESC";
                                        break;
                                    case 'tanggal_asc':
                                        $order = "ORDER BY tanggal ASC, waktu ASC";
                                        break;
                                    case 'tanggal_desc':
                                        $order = "ORDER BY tanggal DESC, waktu DESC";
                                        break;
                                }
                            }
                            $data = mysqli_query($koneksi, "SELECT * FROM buku_tamu $where $order");
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
