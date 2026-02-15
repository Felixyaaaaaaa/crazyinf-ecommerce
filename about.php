<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <!-- Menentukan karakter encoding sebagai UTF-8 agar mendukung berbagai karakter -->
    <meta charset="UTF-8">
    <!-- Mengatur tampilan agar responsif pada berbagai perangkat -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AboutPage</title>

    <!-- Menghubungkan Bootstrap untuk memudahkan styling dan layout -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Menyertakan Bootstrap Icons untuk ikon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <!-- Menghubungkan font dari Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- Menghubungkan file CSS eksternal untuk custom styling -->
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <!-- Header yang berisi tombol sidebar dan tombol keranjang -->
    <div class="header-container mb-5">
        <!-- Tombol untuk membuka sidebar -->
        <button class="sidebar-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
            <i class="bi bi-list" style="font-size: 30px;"></i>
        </button>

        <!-- Tombol untuk menuju halaman keranjang -->
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
        
        <!-- Logo Website -->
        <div class="logo-container">
            <a href="index.php"><img src="img/CRAZY.IN.png" alt="MAUSTORE"></a>
        </div>
    </div>

    <!-- Konten utama halaman About -->
    <div class="container-sm text-center mx-auto col-md-9">
        <b>
            <h1 class="mb-4">#STAYCRAZY #STAYSTYLISH</h1>
        </b>

        <!-- Paragraf yang menjelaskan brand -->
        <p class="mb-1 lh-base">
            Selamat datang di Crazy.INF, destinasi utama bagi pria yang ingin tampil stylish dengan outfit kasual
            berkualitas tinggi. Kami menghadirkan koleksi t-shirt, hoodie, dan crewneck dengan desain trendi yang
            mengutamakan kenyamanan dan gaya.
        </p>

        <p class="mb-1 lh-base">
            Terinspirasi dari atmosfer urban yang santai, Crazy.INF menawarkan pengalaman belanja yang simpel, modern,
            dan tanpa ribet. Setiap produk dipilih dengan cermat untuk memastikan kamu selalu tampil percaya diri di
            setiap kesempatan.
        </p>

        <p class="mb-4 lh-base">
            Meskipun berlokasi di Antartika, semangat kami tetap panas! Kami siap menghadirkan fashion terbaik ke mana
            pun kamu berada. Crazy.INF bukan sekadar brand, tapi ekspresi gaya hidup bagi mereka yang ingin tampil keren
            dengan effortless.
        </p>

        <!-- Slogan atau pernyataan utama brand -->
        <b>
            <h2 class="mb-2 lh-base">
                CRAZY.INF – SIMPEL, STYLISH, DAN TANPA RIBET. TAMPIL KEREN DENGAN KOLEKSI T-SHIRT, HOODIE, DAN CREWNECK
                BERKUALITAS. DARI ANTARTIKA UNTUK GAYA TERBAIKMU! 
            </h2>
        </b>

        <!-- Kontak melalui WhatsApp -->
        <b>
            <p class="mb-4 lh-base">
                HUBUNGI KAMI MELALUI WHATSAPP:
                <a href="https://api.whatsapp.com/send/?phone=6287853078157&text&type=phone_number&app_absent=0"
                    class="text-decoration-none">0878-5307-8157</a>
            </p>
        </b>
    </div>

    <!-- Gambar ilustrasi tentang brand -->
    <center><img src="img/about.png" alt="about.png" width="70%"></center>
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
                    <a class="nav-link active" href="about.php">ABOUT</a>
                </li>
                <span class="separator">|</span>
                <li class="nav-item">
                    <a class="nav-link" href="store.php">STORE</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Hak Cipta -->
    <p class="text-center mt-5 mb-5 fs-6">Copyright© 2025 CRAZY.INF</p>

</body>
</html>
