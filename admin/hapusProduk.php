<?php
session_start();

// Cek apakah user sudah login dan role-nya admin
if (!isset($_SESSION['id_user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}


include "../contant/koneksi.php";

// Pastikan ada parameter ID
if (isset($_GET['id'])) {
    $id_produk = intval($_GET['id']);

    // Ambil nama gambar dulu
    $getGambar = $conn->prepare("SELECT img FROM produk WHERE id_produk = ?");
    $getGambar->bind_param("i", $id_produk);
    $getGambar->execute();
    $result = $getGambar->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $gambar = $row['img'];
        $pathGambar = "../img/produk/" . $gambar;

        // Hapus data dari DB
        $delete = $conn->prepare("DELETE FROM produk WHERE id_produk = ?");
        $delete->bind_param("i", $id_produk);

        if ($delete->execute()) {
            // Hapus gambar dari folder
            if (file_exists($pathGambar)) {
                unlink($pathGambar);
            }
            echo "<script>alert('Produk berhasil dihapus'); window.location.href = 'dataProduk.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus produk dari database'); window.location.href = 'dataProduk.php';</script>";
        }

        $delete->close();
    } else {
        echo "<script>alert('Produk tidak ditemukan'); window.location.href = 'dataProduk.php';</script>";
    }

    $getGambar->close();
    $conn->close();
} else {
    echo "<script>alert('ID Produk tidak ditemukan'); window.location.href = 'dataProduk.php';</script>";
}
?>
