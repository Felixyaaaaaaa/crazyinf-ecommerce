<?php
session_start();

// Cek apakah user sudah login dan role-nya admin
if (!isset($_SESSION['id_user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}


include "../contant/koneksi.php";

if (isset($_GET['id'])) {
    $id_user = $_GET['id'];

    if ($id_user == $_SESSION['id_user']) {
        $_SESSION['popup_error'] = "Anda tidak bisa menghapus akun Anda sendiri.";
        header("Location: kelolaUser.php");
        exit;
    }

    $query = "DELETE FROM user WHERE id_user = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_user);

    if ($stmt->execute()) {
        $_SESSION['popup_success'] = "User berhasil dihapus.";
    } else {
        $_SESSION['popup_error'] = "Gagal menghapus user.";
    }

    $stmt->close();
    $conn->close();
} else {
    $_SESSION['popup_error'] = "Permintaan tidak valid.";
}

header("Location: kelolaUser.php");
exit;
