<?php
session_start();
include "contant/koneksi.php";

if (!isset($_SESSION['id_user'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location='login.php';</script>";
    exit;
}

$id_pesanan = $_POST['id_pesanan'];
$bukti_selesai = '';

if (isset($_FILES['bukti']) && $_FILES['bukti']['error'] == 0) {
    $target_dir = "img/bukti_selesai/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $file_name = time() . "_" . basename($_FILES["bukti"]["name"]);
    $file_path = $target_dir . $file_name;

    if (move_uploaded_file($_FILES["bukti"]["tmp_name"], $file_path)) {
        $bukti_selesai = $file_path;
    }
}

if ($bukti_selesai) {
    $query = "UPDATE pesanan SET status='Selesai', bukti_selesai='$bukti_selesai' WHERE id_pesanan=? AND id_user=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ii", $id_pesanan, $_SESSION['id_user']);
    mysqli_stmt_execute($stmt);

    echo "<script>alert('Pesanan telah dikonfirmasi selesai. Terima kasih!'); window.location='pesanan_saya.php';</script>";
} else {
    echo "<script>alert('Upload bukti gagal. Coba lagi.'); window.location='pesanan_selesai.php?id=$id_pesanan';</script>";
}
