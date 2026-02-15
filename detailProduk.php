<?php
session_start();
include "contant/koneksi.php";

$pesan_error = '';

if (isset($_POST['add_to_cart'])) {
    if (!isset($_SESSION['id_user'])) {
        $pesan_error = "Silakan login terlebih dahulu untuk menambahkan ke keranjang.";
    } else {
        $id_user = $_SESSION['id_user'];
        $id_produk = $_POST['id_produk'];
        $ukuran_produk = $_POST['ukuran_produk'];
        $jumlah_produk = $_POST['jumlah_produk'];

        $cek = mysqli_query($conn, "SELECT * FROM keranjang WHERE id_user='$id_user' AND id_produk='$id_produk' AND ukuran_produk='$ukuran_produk'");

        if (mysqli_num_rows($cek) == 0) {
            $insert = mysqli_query($conn, "INSERT INTO keranjang (id_user, id_produk, ukuran_produk, jumlah_produk) VALUES ('$id_user', '$id_produk', '$ukuran_produk', '$jumlah_produk')");
            if ($insert) {
                header("Location: detailProduk.php?id=$id_produk&status=berhasil");
                exit;
            } else {
                $pesan_error = "Gagal menambahkan ke keranjang.";
            }
        } else {
            header("Location: detailProduk.php?id=$id_produk&status=sudah_ada");
            exit;
        }
    }
}

if (isset($_GET['id'])) {
    $id_produk = mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "SELECT * FROM produk WHERE id_produk = '$id_produk'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $produk = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Produk tidak ditemukan!'); window.location='shop.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('ID produk tidak valid!'); window.location='shop.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="modal fade" id="validasiModal" tabindex="-1" aria-labelledby="validasiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-warning">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-dark" id="validasiModalLabel">Peringatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body text-dark">
                    <?= isset($pesan_error) ? htmlspecialchars($pesan_error) : '' ?>
                </div>
            </div>
        </div>
    </div>

    <div class="header-container mb-5">
        <button class="sidebar-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
            <i class="bi bi-list" style="font-size: 30px;"></i>
        </button>

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
                    <div class="d-flex justify-content-between align-items-center w-100 text-white">
                        <div class="d-flex flex-column">
                            <div class="d-flex align-items-center gap-3">
                                <i class="bi bi-person-fill fs-5 text-success"></i>
                                <span class="fw-semibold fs-5 mb-0"><?= htmlspecialchars($_SESSION['username']); ?></span>
                            </div>
                            <small class="ms-4 text-white-50 fs-7"><?= htmlspecialchars($_SESSION['email']); ?></small>
                        </div>
                        <a href="logout.php" class="text-decoration-none" title="Logout">
                            <i class="bi bi-box-arrow-right fs-2 text-danger"></i>
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

        <div class="logo-container">
            <a href="index.php"><img src="img/CRAZY.IN.png" alt="MAUSTORE"></a>
        </div>
    </div>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <div class="product-img-container">
                    <img src="img/produk/<?= htmlspecialchars($produk['img']) ?>" class="product-img img-fluid" id="zoom-img">
                </div>
            </div>
            <div class="col-md-5">

                <h2 class="fw-bold"><?= htmlspecialchars($produk['nama_produk']) ?></h2>
                <h4 class="text-success">Rp <?= number_format($produk['harga'], 0, ',', '.') ?></h4>
                <p class="text-muted">Kategori: <?= htmlspecialchars($produk['category']) ?></p>

                <form method="POST" action="">
                    <input type="hidden" name="id_produk" value="<?= $produk['id_produk']; ?>">

                    <label for="size-select"><b>Pilih Ukuran:</b></label>
                    <select id="size-select" class="form-control" name="ukuran_produk" required>
                        <option value="S">S</option>
                        <option value="M">M</option>
                        <option value="L">L</option>
                        <option value="XL">XL</option>
                    </select>

                    <label for="jumlah_produk" class="mt-3"><b>Jumlah Produk:</b></label>
                    <input type="number" name="jumlah_produk" id="jumlah_produk" class="form-control" required min="1" value="1">

                    <button class="btn-keranjang-detail mt-3" type="submit" name="add_to_cart">ADD TO CART</button>
                </form>

            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg">
        <div class="container justify-content-center">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="index.php">HOME</a></li>
                <span class="separator">|</span>
                <li class="nav-item"><a class="nav-link" href="shop.php">SHOP</a></li>
                <span class="separator">|</span>
                <li class="nav-item"><a class="nav-link" href="lookbook.php">LOOKBOOK</a></li>
                <span class="separator">|</span>
                <li class="nav-item"><a class="nav-link" href="about.php">ABOUT</a></li>
                <span class="separator">|</span>
                <li class="nav-item"><a class="nav-link" href="store.php">STORE</a></li>
            </ul>
        </div>
    </nav>

    <p class="text-center mt-5 mb-5 fs-6">Copyright© 2025 CRAZY.INF</p>

    <script>
        // Efek Zoom
        const img = document.getElementById("zoom-img");
        const container = document.querySelector(".product-img-container");

        container.addEventListener("mousemove", (event) => {
            const {
                left,
                top,
                width,
                height
            } = container.getBoundingClientRect();
            const x = ((event.clientX - left) / width) * 100;
            const y = ((event.clientY - top) / height) * 100;
            img.style.transformOrigin = `${x}% ${y}%`;
            img.style.transform = "scale(2)";
        });

        container.addEventListener("mouseleave", () => {
            img.style.transform = "scale(1)";
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
<?php if (!empty($pesan_error)): ?>
    <script>
        const myModal = new bootstrap.Modal(document.getElementById('validasiModal'), {
            keyboard: true
        });
        window.addEventListener('load', () => {
            myModal.show();
        });
    </script>
<?php endif; ?>

</html>

<?php if (isset($_GET['status'])): ?>
    <script>
        <?php if ($_GET['status'] == 'berhasil'): ?>
            alert("Produk berhasil ditambahkan ke keranjang!");
        <?php elseif ($_GET['status'] == 'sudah_ada'): ?>
            alert("Produk sudah ada di keranjang.");
        <?php endif; ?>

        // Hapus ?status=... dari URL
        if (window.history.replaceState) {
            const url = new URL(window.location);
            url.searchParams.delete('status');
            window.history.replaceState(null, '', url);
        }
    </script>
<?php endif; ?>