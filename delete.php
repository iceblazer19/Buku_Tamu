<?php
// filepath: c:\xampp\htdocs\Buku_Tamu\delete.php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "DELETE FROM buku_tamu WHERE id = $id";
    if (mysqli_query($koneksi, $query)) {
        header("Location: dataTamu.php?deleted=1");
        exit;
    } else {
        header("Location: dataTamu.php?deleted=0");
        exit;
    }
} else {
    header("Location: dataTamu.php");
    exit;
}