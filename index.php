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
    </style>
</head>
<body>
    <div class="container-flex">
        <nav class="sidebar">
            <div class="sidebar-title">Menu</div>
            <a href="index.php" class="sidebar-link"><i class="bi bi-house"></i> Home</a>
            <a href="data_tamu.php" class="sidebar-link"><i class="bi bi-people"></i> Data Tamu</a>
        </nav>
        <div class="main-content">
            <header>
                <h2>To Do CRUD</h2>
            </header>
            <main>
                <section>
                    <form method="get" class="search-bar" style="margin:24px 0 0 0; display:flex; gap:12px; align-items:center;">
                        <input 
                            type="text" 
                            name="search" 
                            placeholder="Cari berdasarkan nama..." 
                            value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
                            style="padding:10px 16px; border-radius:6px; border:1px solid #ccc; font-size:1.08rem; flex:1;"
                        >
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
                                        echo htmlspecialchars(date('H:i d-m-Y', strtotime($datetime)));
                                    ?>
                                </td>
                                <td>
                                    <a href="edit.php?id=<?php echo $d['id']; ?>" title="Edit"><i class="bi bi-pencil-square"></i></a>
                                    <a href="delete.php?id=<?php echo $d['id']; ?>" title="Hapus" onclick="return confirm('Yakin ingin menghapus data ini?');"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </section>
            </main>
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
</body>
</html>
