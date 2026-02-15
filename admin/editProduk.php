<?php
session_start();

// Cek apakah user sudah login dan role-nya admin
if (!isset($_SESSION['id_user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include "../contant/koneksi.php";

if (isset($_POST['update'])) {
    $id = $_POST['id_produk'];
    $nama = $_POST['nama_produk'];
    $kategori = $_POST['category'];
    $harga = $_POST['harga'];

    // Jika gambar di-upload
    if ($_FILES['gambar']['name'] != '') {
        $gambar = basename($_FILES["gambar"]["name"]);
        $target = "../img/produk/" . $gambar;
        move_uploaded_file($_FILES["gambar"]["tmp_name"], $target);

        $query = "UPDATE produk SET nama_produk=?, category=?, harga=?, img=? WHERE id_produk=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssisi", $nama, $kategori, $harga, $gambar, $id);
    } else {
        $query = "UPDATE produk SET nama_produk=?, category=?, harga=? WHERE id_produk=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssii", $nama, $kategori, $harga, $id);
    }

    if ($stmt->execute()) {
        header("Location: dataProduk.php");
    } else {
        echo "Gagal update: " . $stmt->error;
    }
}
?>
