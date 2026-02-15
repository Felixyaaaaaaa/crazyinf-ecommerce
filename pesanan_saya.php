<?php
session_start();
include "contant/koneksi.php";

if (!isset($_SESSION['id_user'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location='login.php';</script>";
    exit;
}

$id_user = $_SESSION['id_user'];
$query = mysqli_query($conn, "SELECT * FROM pesanan WHERE id_user = $id_user ORDER BY tanggal_pesan DESC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pesanan Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <style>
        .badge-status {
            font-size: 0.9rem;
        }

        .card-pesanan {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.08);
            border-radius: 12px;
        }

        .produk-item {
            border-top: 1px solid #ddd;
            padding-top: 8px;
            margin-top: 8px;
        }

        .produk-item:last-child {
            border-bottom: none;
        }

        .produk-nama {
            font-weight: 500;
        }
    </style>
</head>

<body class="bg-light">
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


    <div class="container mt-5">
        <h3 class="mb-4"><b>Pesanan Saya</b></h3>

        <?php if (mysqli_num_rows($query) > 0): ?>
            <div class="row">
                <?php while ($data = mysqli_fetch_assoc($query)) : ?>
                    <div class="col-md-6 mb-4">
                        <div class="card card-pesanan p-3">
                            <h5><?= htmlspecialchars($data['nama_penerima']) ?></h5>
                            <p class="mb-1 text-muted"><?= htmlspecialchars($data['alamat']) ?></p>
                            <p class="mb-1">Metode: <?= ucfirst($data['metode_pembayaran']) ?> - <?= $data['opsi_pembayaran'] ?></p>
                            <p class="mb-1">Tanggal: <?= date('d M Y - H:i', strtotime($data['tanggal_pesan'])) ?></p>
                            <p class="mb-1 fw-bold text-primary">Total: Rp <?= number_format($data['total_harga'], 0, ',', '.') ?></p>
                            <span class="badge 
                            <?=
                            $data['status'] ==
                                'Selesai' ? 'bg-success' : ($data['status'] ==
                                    'Sedang Dikemas' ? 'bg-warning text-dark' : ($data['status'] ==
                                        'Dibatalkan' ? 'bg-danger' : ($data['status'] ==
                                            'Dalam Pengiriman' ? 'bg-warning text-dark' : ($data['status'] ==
                                                'Selesai' ? 'bg-success' : 'bg-secondary'))))
                            ?> badge-status">
                                <?= $data['status'] ?>
                            </span>

                            <!-- Detail Produk -->
                            <?php
                            $id_pesanan = $data['id_pesanan'];
                            $produk_query = mysqli_query($conn, "SELECT pd.*, p.nama_produk 
                            FROM pesanan_detail pd 
                            JOIN produk p ON pd.id_produk = p.id_produk 
                            WHERE pd.id_pesanan = $id_pesanan");
                            ?>
                            <div class="mt-3">
                                <h6>Produk:</h6>
                                <?php while ($produk = mysqli_fetch_assoc($produk_query)) : ?>
                                    <div class="produk-item">
                                        <div class="produk-nama"><?= $produk['nama_produk'] ?> (Ukuran: <?= $produk['ukuran_produk'] ?>)</div>
                                        <div>Jumlah: <?= $produk['jumlah_produk'] ?> x Rp <?= number_format($produk['harga_satuan'], 0, ',', '.') ?></div>
                                        <div class="text-muted small">Subtotal: Rp <?= number_format($produk['subtotal'], 0, ',', '.') ?></div>
                                    </div>
                                <?php endwhile; ?>
                            </div>

                            <div class="mt-3 d-flex gap-2">
                                <a href="detail_pesanan.php?id=<?= $data['id_pesanan'] ?>"
                                    class="btn btn-sm btn-outline-primary">Lihat Detail</a>

                                <?php if ($data['status'] == 'Dalam Pengiriman'): ?>
                                    <a href="pesanan_selesai.php?id=<?= $data['id_pesanan'] ?>"
                                        class="btn btn-sm btn-success">Pesanan Selesai</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info">Belum ada pesanan.</div>
        <?php endif; ?>
    </div>

    <br><br>

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