<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <!-- Deklarasi tipe dokumen HTML5 -->
    <!-- Menentukan bahasa halaman sebagai Bahasa Indonesia -->
    <meta charset="UTF-8"> <!-- Mengatur karakter encoding menjadi UTF-8 untuk mendukung berbagai karakter -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Membuat halaman responsif sesuai dengan lebar perangkat -->
    <title>HomePage</title> <!-- Judul halaman yang akan muncul di tab browser -->

    <!-- Memuat Bootstrap CSS untuk mendukung tata letak dan komponen bawaan -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Memuat Bootstrap JavaScript untuk mengaktifkan komponen interaktif seperti navbar dan carousel -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Memuat ikon dari Bootstrap Icons untuk digunakan dalam UI -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <!-- Memuat font Poppins dari Google Fonts untuk tampilan teks yang lebih menarik -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- Menghubungkan file CSS eksternal untuk menambahkan gaya khusus -->
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <!-- Container header yang berisi tombol sidebar, tombol keranjang, dan logo -->
    <div class="header-container mb-5">
        <!-- Tombol sidebar untuk membuka navigasi samping -->
        <button class="sidebar-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
            <i class="bi bi-list" style="font-size: 30px;"></i> <!-- Ikon menu dari Bootstrap Icons -->
        </button>

        <!-- Tombol menuju halaman keranjang belanja -->
        <a href="keranjang.php">
            <button class="cart-btn">
                <i class="bi bi-cart" style="font-size: 30px;"></i> <!-- Ikon keranjang dari Bootstrap Icons -->
            </button>
        </a>

        <!-- Sidebar menu navigasi yang akan muncul dari sisi kiri layar -->
        <div class="offcanvas offcanvas-start text-white" tabindex="-1" id="sidebar">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title fw-bold">MENU</h5> <!-- Judul sidebar -->
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button> <!-- Tombol untuk menutup sidebar -->
            </div>
            <div class="offcanvas-body">
                <!-- Daftar menu navigasi utama -->
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <a href="index.php" class="text-decoration-none text-white fw-bold d-block p-2 rounded">
                            <i class="bi bi-house-door fs-5 me-2 text-white"></i> HOME
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="shop.php" class="text-decoration-none text-white fw-bold d-block p-2 rounded">
                            <i class="bi bi-cart fs-5 me-2 text-white"></i> SHOP
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="lookbook.php" class="text-decoration-none text-white fw-bold d-block p-2 rounded">
                            <i class="bi bi-image fs-5 me-2 text-white"></i> LOOKBOOK
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="about.php" class="text-decoration-none text-white fw-bold d-block p-2 rounded">
                            <i class="bi bi-info-circle fs-5 me-2 text-white"></i> ABOUT
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="store.php" class="text-decoration-none text-white fw-bold d-block p-2 rounded">
                            <i class="bi bi-shop fs-5 me-2 text-white"></i> STORE
                        </a>
                    </li>
                </ul>
            </div>
            <div class="offcanvas-header px-4 py-4 bg-dark shadow-sm">
                <?php if (isset($_SESSION['username'])): ?>
                    <!-- Sudah login -->
                    <div class="d-flex flex-column text-white w-100">
                        <!-- Bagian atas: Username, Email, dan Logout -->
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="d-flex align-items-start gap-3">
                                <i class="bi bi-person-circle fs-3 text-success"></i>
                                <div class="d-flex flex-column">
                                    <span class="fw-semibold fs-5 mb-0"><?= htmlspecialchars($_SESSION['username']); ?></span>
                                    <small class="text-white-50"><?= htmlspecialchars($_SESSION['email']); ?></small>
                                </div>
                            </div>
                            <a href="logout.php" class="text-decoration-none" title="Logout">
                                <i class="bi bi-box-arrow-right fs-3 text-danger"></i>
                            </a>
                        </div>

                        <!-- Separator dan link ke pesanan saya -->
                        <hr class="border-light my-2">
                        <a href="pesanan_saya.php" class="text-decoration-none text-info d-flex align-items-center gap-2">
                            <i class="bi bi-bag-check-fill fs-5"></i>
                            <span class="fw-semibold">Pesanan Saya</span>
                        </a>
                    </div>


                <?php else: ?>
                    <!-- Belum login -->
                    <div class="d-flex justify-content-between align-items-center w-100 text-white">
                        <div class="d-flex align-items-center gap-3">
                            <span class="fw-semibold fs-6">Kamu belum memiliki akun nii, login dulu yukk</span>
                        </div>
                        <a href="login.php" class="text-decoration-none" title="Login">
                            <i class="bi bi-box-arrow-in-right fs-2 text-info"></i>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>


        <!-- Logo toko, ditautkan ke halaman utama -->
        <div class="logo-container">
            <a href="index.php"><img src="img/CRAZY.IN.png" alt="MAUSTORE"></a>
        </div>
    </div>

    <br>

    <!-- Container untuk carousel yang menampilkan gambar produk secara otomatis -->
    <div class="containerCarousel">
        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <!-- Slide pertama dengan dua gambar produk -->
                <div class="carousel-item active">
                    <div class="row">
                        <div class="col-md-6 p-1">
                            <img src="img/produk/KATALOG/model1.jpg" class="d-block w-100">
                        </div>
                        <div class="col-md-6 p-1">
                            <img src="img/produk/KATALOG/model2.png" class="d-block w-100">
                        </div>
                    </div>
                </div>
                <!-- Slide kedua dengan dua gambar produk -->
                <div class="carousel-item">
                    <div class="row">
                        <div class="col-md-6 p-1">
                            <img src="img/produk/KATALOG/model3.jpg" class="d-block w-100">
                        </div>
                        <div class="col-md-6 p-1">
                            <img src="img/produk/KATALOG/model4.png" class="d-block w-100">
                        </div>
                    </div>
                </div>
                <!-- Slide ketiga dengan dua gambar produk -->
                <div class="carousel-item">
                    <div class="row">
                        <div class="col-md-6 p-1">
                            <img src="img/produk/KATALOG/model5.jpg" class="d-block w-100">
                        </div>
                        <div class="col-md-6 p-1">
                            <img src="img/produk/KATALOG/model6.png" class="d-block w-100">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol navigasi untuk berpindah antar slide -->
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </div>

    <br><br><br>

    <!-- Navbar bagian bawah dengan tautan ke halaman lain -->
    <nav class="navbar navbar-expand-lg">
        <div class="container justify-content-center">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">HOME</a>
                </li>
                <span class="separator">|</span>
                <li class="nav-item">
                    <a class="nav-link" href="shop.php">SHOP</a>
                </li>
                <span class="separator">|</span>
                <li class="nav-item">
                    <a class="nav-link" href="lookbook.php">LOOKBOOK</a>
                </li>
                <span class="separator">|</span>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">ABOUT</a>
                </li>
                <span class="separator">|</span>
                <li class="nav-item">
                    <a class="nav-link" href="store.php">STORE</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Bagian footer dengan informasi hak cipta -->
    <p class="text-center mt-5 mb-5 fs-6">Copyright© 2025 Crazy.INF</p>
</body>

</html>