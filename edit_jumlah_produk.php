<?php
session_start();
include "contant/koneksi.php";

$id_user = $_SESSION['id_user'] ?? null;

if (!$id_user) {
    echo "<script>alert('Anda belum login'); window.location='login.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_keranjang'], $_POST['jumlah_produk'])) {
    $id_keranjang = $_POST['id_keranjang'];
    $jumlah_produk = $_POST['jumlah_produk'];

    if ($jumlah_produk < 1) {
        echo "<script>alert('Jumlah minimal 1'); window.location='keranjang.php';</script>";
        exit;
    }

    $query = "UPDATE keranjang SET jumlah_produk = $jumlah_produk WHERE id_keranjang = $id_keranjang AND id_user = $id_user";
    mysqli_query($conn, $query);

    // Redirect balik ke keranjang tanpa alert agar smooth
    header("Location: keranjang.php");
    exit;
}

echo "<script>alert('Permintaan tidak valid'); window.location='keranjang.php';</script>";
?>
