<?php
include 'koneksi.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $instansi = mysqli_real_escape_string($koneksi, $_POST['instansi']);
    $tujuan = mysqli_real_escape_string($koneksi, $_POST['tujuan']);
    $query = "UPDATE buku_tamu SET nama='$nama', instansi='$instansi', tujuan='$tujuan' WHERE id=$id";
    if (mysqli_query($koneksi, $query)) {
        echo "success";
    } else {
        echo "error";
    }
}
?>