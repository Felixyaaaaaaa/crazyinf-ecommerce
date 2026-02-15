<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <!-- Metadata dasar untuk kompatibilitas dan SEO -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StorePage</title>
    
    <!-- Menggunakan Bootstrap untuk styling dan responsivitas -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Menggunakan Bootstrap Icons untuk ikon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    
    <!-- Font Poppins dari Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    
    <!-- Menghubungkan ke file CSS eksternal untuk kustomisasi tambahan -->
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <!-- Bagian Header dengan Sidebar Menu dan Logo -->
    <div class="header-container mb-5">
        <!-- Tombol Sidebar Menu -->
        <button class="sidebar-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
            <i class="bi bi-list" style="font-size: 30px;"></i>
        </button>

        <!-- Tombol Keranjang Belanja -->
        <a href="keranjang.php">
            <button class="cart-btn">
                <i class="bi bi-cart" style="font-size: 30px;"></i>
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

        <!-- Logo di Header -->
        <div class="logo-container">
            <a href="index.php"><img src="img/CRAZY.IN.png" alt="MAUSTORE"></a>
        </div>
    </div>

    <!-- Google Maps untuk Menampilkan Lokasi Store -->
    <center>
        <iframe class="mt-3" src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d2206.1613177188283!2d-59.13149162235585!3d-62.24833327615719!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zNjLCsDE0JzU0LjAiUyA1OcKwMDcnNDQuMSJX!5e1!3m2!1sid!2sid!4v1741540508462!5m2!1sid!2sid" width="70%" height="700" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </center>
    
    <br><br>
    
    <!-- Navigasi Footer -->
    <nav class="navbar navbar-expand-lg">
        <div class="container justify-content-center">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">HOME</a>
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
                    <a class="nav-link active" href="store.php">STORE</a>
                </li>
            </ul>
        </div>
    </nav>
    
    <!-- Copyright Footer -->
    <p class="text-center mt-5 mb-5 fs-6">Copyright© 2025 CRAZY.INF</p>
</body>

</html>