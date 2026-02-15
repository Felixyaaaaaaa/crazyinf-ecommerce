<?php
session_start();

// Cek apakah user sudah login dan role-nya admin
if (!isset($_SESSION['id_user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar py-4 px-3 ">
                <h4 class="text-white mb-4">Halo, <?php echo $_SESSION['username']; ?></h4>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="index.php"><i class="bi bi-house-door"></i> Dashboard</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="tambahProduk.php"><i class="bi bi-plus-square"></i> Tambah Produk</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="dataProduk.php"><i class="bi bi-list-ul"></i> Data Produk</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="tambahUser.php"><i class="bi bi-person-add"></i> Tambah User</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="kelolaUser.php"><i class="bi bi-person"></i> Kelola User</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="dataPesanan.php"><i class="bi bi-basket"></i> Data Pesanan</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
                    </li>
                </ul>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <h2>Selamat Datang, <?php echo $_SESSION['username']; ?>!</h2>
                <p>Ini adalah halaman utama admin. Di sini kamu bisa mengelola konten, user, dan lainnya.</p>
            </main>


        </div>
    </div>

</body>

</html>