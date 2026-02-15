<?php
session_start();

// Cek apakah user sudah login dan role-nya admin       
if (!isset($_SESSION['id_user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include "../contant/koneksi.php";

if (isset($_POST['update_status'])) {
    $id_pesanan = $_POST['id_pesanan'];
    $status = $_POST['status'];

    // Update status pesanan
    $query = "UPDATE pesanan SET status = ? WHERE id_pesanan = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $status, $id_pesanan);

    if ($stmt->execute()) {
        echo "<script>alert('Status pesanan berhasil diperbarui'); window.location.href = 'dataPesanan.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui status pesanan'); window.location.href = 'dataPesanan.php';</script>";
    }
}
?>
