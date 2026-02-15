<?php
session_start();

// Cek apakah user sudah login dan role-nya admin
if (!isset($_SESSION['id_user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}


include "../contant/koneksi.php";

if (isset($_POST['update_user'])) {
    $id_user = $_POST['id_user'];
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $role = $_POST['role'];

    $query = "UPDATE user SET username = ?, email = ?, role = ? WHERE id_user = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $username, $email, $role, $id_user);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Data user berhasil diperbarui.";
    } else {
        $_SESSION['error'] = "Gagal memperbarui data user.";
    }

    $stmt->close();
    $conn->close();

    header("Location: kelolaUser.php");
    exit;
} else {
    $_SESSION['error'] = "Akses tidak sah.";
    header("Location: kelolaUser.php");
    exit;
}
