<?php
session_start();
include "contant/koneksi.php";

if (!isset($_SESSION['id_user'])) {
    echo "<script>alert('Anda belum login'); window.location='login.php';</script>";
    exit;
}

$id_user = $_SESSION['id_user'];

// Jika menghapus satu item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_keranjang'])) {
    $id_keranjang = intval($_POST['id_keranjang']);

    $query = "DELETE FROM keranjang WHERE id_keranjang = $id_keranjang AND id_user = $id_user";
    mysqli_query($conn, $query);

    echo "<script>alert('Item berhasil dihapus dari keranjang.'); window.location='keranjang.php';</script>";
    exit;
}

// Jika ingin hapus semua item
if (isset($_GET['all']) && $_GET['all'] === 'true') {
    $query = "DELETE FROM keranjang WHERE id_user = $id_user";
    mysqli_query($conn, $query);

    echo "<script>alert('Semua item di keranjang telah dihapus.'); window.location='keranjang.php';</script>";
    exit;
}

// Jika tidak valid
echo "<script>alert('Permintaan tidak valid'); window.location='keranjang.php';</script>";
?>