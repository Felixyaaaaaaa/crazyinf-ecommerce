<?php
session_start();
include "contant/koneksi.php";

$id_user = $_SESSION['id_user'] ?? null;
$result = null;

if ($id_user) {
    // Ambil data keranjang dari database
    $query = "SELECT keranjang.id_keranjang, produk.nama_produk, produk.harga, produk.img, keranjang.ukuran_produk, keranjang.jumlah_produk
              FROM keranjang
              JOIN produk ON keranjang.id_produk = produk.id_produk
              WHERE keranjang.id_user = '$id_user'";
    $result = mysqli_query($conn, $query);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <!-- Menentukan karakter encoding dan viewport untuk responsivitas -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Judul halaman -->
    <title>KeranjangPage</title>

    <!-- Memuat Bootstrap untuk styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Memuat ikon Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <!-- Memuat font Poppins dari Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- Memuat file CSS eksternal -->
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <!-- Header dengan tombol sidebar dan keranjang belanja -->
    <div class="header-container mb-5">
        <!-- Tombol untuk membuka sidebar menu -->
        <button class="sidebar-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
            <i class="bi bi-list" style="font-size: 30px;"></i>
        </button>

        <!-- Tombol keranjang belanja -->
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

        <!-- Logo di tengah header -->
        <div class="logo-container">
            <a href="index.php"><img src="img/CRAZY.IN.png" alt="MAUSTORE"></a>
        </div>
    </div>

    <div class="container my-5">
        <!-- <h3 class="mb-4">Keranjang Belanja Anda</h3> -->

        <?php if ($result && mysqli_num_rows($result) > 0): ?>
            <table class="table table-bordered align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Ukuran</th>
                        <th>Quantity</th>
                        <th>Harga Satuan</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    while ($row = mysqli_fetch_assoc($result)):
                        $subtotal = $row['harga'] * $row['jumlah_produk'];
                        $total += $subtotal;

                    ?>
                        <tr>
                            <td><img src="img/produk/<?= htmlspecialchars($row['img']) ?>" width="80" class="img-thumbnail"></td>
                            <td><?= htmlspecialchars($row['nama_produk']) ?></td>
                            <td><?= htmlspecialchars($row['ukuran_produk']) ?></td>
                            <td>
                                <form action="edit_jumlah_produk.php" method="post" class="d-flex align-items-center justify-content-center gap-2">
                                    <input type="hidden" name="id_keranjang" value="<?= $row['id_keranjang'] ?>">
                                    <input type="number" name="jumlah_produk" value="<?= $row['jumlah_produk'] ?>" min="1"
                                        class="form-control form-control-sm" style="width: 70px;"
                                        onchange="this.form.submit()">
                                </form>

                            </td>
                            <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                            <td>Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                            <td>
                                <form action="hapusKeranjang.php" method="post" onsubmit="return confirm('Yakin ingin menghapus item ini?')">
                                    <input type="hidden" name="id_keranjang" value="<?= htmlspecialchars($row['id_keranjang']) ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <div class="text-end">
                <h4>Total: Rp <?= number_format($total, 0, ',', '.') ?></h4>
                <!-- Tombol untuk membuka modal -->
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#checkoutModal">Checkout</button>
            </div>


        <?php else: ?>
            <div class=" text-center">Keranjang Anda masih kosong.</div>
        <?php endif; ?>
    </div>
    <!-- Modal Checkout -->
    <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="checkoutModalLabel">Checkout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form Checkout -->
                    <form method="POST" action="process_checkout.php" enctype="multipart/form-data">
                        <!-- Input Nama Pengguna (otomatis terisi dari session) -->
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama_penerima" value="<?= htmlspecialchars($_SESSION['username']); ?>" required>
                        </div>

                        <!-- Input Nomor HP -->
                        <div class="mb-3">
                            <label for="nomor_hp" class="form-label">Nomor HP</label>
                            <input type="text" class="form-control" id="nomor_hp" name="no_hp" placeholder="Masukkan nomor yang bisa dihubungi" required>
                        </div>

                        <!-- Input Alamat Pengiriman -->
                        <!-- <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat Pengiriman</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                        </div> -->
                        <div class="mb-3">
                            <label class="form-label">Alamat Pengiriman</label>
                            <select id="provinsi" name="provinsi" class="form-select mb-3" required>
                                <option value="">-- Pilih Provinsi --</option>
                            </select>

                            <select id="kabupaten" name="kabupaten" class="form-select mb-3" required>
                                <option value="">-- Pilih Kabupaten/Kota --</option>
                            </select>

                            <select id="kecamatan" name="kecamatan" class="form-select mb-3" required>
                                <option value="">-- Pilih Kecamatan --</option>
                            </select>

                            <select id="kelurahan" name="kelurahan" class="form-select mb-3" required>
                                <option value="">-- Pilih Kelurahan --</option>
                            </select>

                            <textarea class="form-control" id="detail_alamat" name="detail_alamat" rows="2" placeholder="Detail (RT/RW, No. Rumah, dll)" required></textarea>
                        </div>

                        <!-- Metode Pembayaran -->
                        <div class="mb-3">
                            <label for="metode" class="form-label">Metode Pembayaran</label>
                            <select class="form-select" id="metode" name="metode_pembayaran" required onchange="tampilkanOpsi()">
                                <option value="">-- Pilih Metode --</option>
                                <option value="bank">Transfer Bank</option>
                                <option value="ewallet">E-Wallet</option>
                            </select>
                        </div>

                        <!-- Pilihan Bank -->
                        <div class="mb-3 d-none" id="opsi-bank">
                            <label class="form-label">Pilih Bank</label>
                            <select class="form-select" id="bank" onchange="tampilkanInfoPembayaran('bank')">
                                <option value="">-- Pilih Bank --</option>
                                <option value="BCA">BCA</option>
                                <option value="BNI">BNI</option>
                                <option value="Mandiri">Mandiri</option>
                                <option value="BRI">BRI</option>
                            </select>
                        </div>

                        <!-- Pilihan E-Wallet -->
                        <div class="mb-3 d-none" id="opsi-ewallet">
                            <label class="form-label">Pilih E-Wallet</label>
                            <select class="form-select" id="ewallet" onchange="tampilkanInfoPembayaran('ewallet')">
                                <option value="">-- Pilih E-Wallet --</option>
                                <option value="OVO">OVO</option>
                                <option value="DANA">DANA</option>
                                <option value="Gopay">Gopay</option>
                                <option value="ShopeePay">ShopeePay</option>
                            </select>
                        </div>

                        <!-- Informasi yang dikirim ke server -->
                        <input type="hidden" name="opsi_pembayaran" id="opsi_pembayaran_final">

                        <!-- Informasi Nomor Pembayaran -->
                        <div id="info-pembayaran" class="alert alert-info d-none"></div>


                        <!-- Input Bukti Pembayaran (opsional) -->
                        <div class="mb-3">
                            <label for="bukti_pembayaran" class="form-label">Bukti Pembayaran</label>
                            <input type="file" class="form-control" id="bukti_pembayaran" name="bukti_pembayaran" accept="image/*" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Selesaikan Pembayaran</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigasi footer -->
    <nav class="navbar navbar-expand-lg ">
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
                    <a class="nav-link" href="store.php">STORE</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Hak cipta -->
    <p class="text-center mt-5 mb-5 fs-6">Copyright© 2025 CRAZY.INF</p>

    <script src="script.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function(){
    // Load provinsi
    $.post("get_wilayah.php", {tipe: "provinsi"}, function(data){
        data.forEach(p => {
            $('#provinsi').append(`<option value="${p.id}">${p.nama}</option>`);
        });
    });

    $('#provinsi').change(function(){
        const id = $(this).val();
        $('#kabupaten').html(`<option value="">-- Pilih Kabupaten/Kota --</option>`);
        $('#kecamatan').html(`<option value="">-- Pilih Kecamatan --</option>`);
        $('#kelurahan').html(`<option value="">-- Pilih Kelurahan --</option>`);
        if(id){
            $.post("get_wilayah.php", {tipe:"kabupaten", id:id}, function(data){
                data.forEach(k => {
                    $('#kabupaten').append(`<option value="${k.id}">${k.nama}</option>`);
                });
            });
        }
    });

    $('#kabupaten').change(function(){
        const id = $(this).val();
        $('#kecamatan').html(`<option value="">-- Pilih Kecamatan --</option>`);
        $('#kelurahan').html(`<option value="">-- Pilih Kelurahan --</option>`);
        if(id){
            $.post("get_wilayah.php", {tipe:"kecamatan", id:id}, function(data){
                data.forEach(kc => {
                    $('#kecamatan').append(`<option value="${kc.id}">${kc.nama}</option>`);
                });
            });
        }
    });

    $('#kecamatan').change(function(){
        const id = $(this).val();
        $('#kelurahan').html(`<option value="">-- Pilih Kelurahan --</option>`);
        if(id){
            $.post("get_wilayah.php", {tipe:"kelurahan", id:id}, function(data){
                data.forEach(kl => {
                    $('#kelurahan').append(`<option value="${kl.id}">${kl.nama}</option>`);
                });
            });
        }
    });
});
    </script>
</body>

</html>


<!-- 
<div id="payment-form" class="container mt-4 p-3 border rounded" style="display: none; max-width: 400px;">
    <h3 class="text-center">Form Pembayaran</h3>
    <label for="namaRekening/Ewallet">Nama Pemilik Rekening/E-wallet:</label>
    <input type="text" id="nama" class="form-control my-2" placeholder="Nama Rekening/E-wallet">
    <label for="nomorRekening/Ewallet">Nomor Rekening/E-Wallet:</label>
    <input type="nomor" id="nomor" class="form-control my-2" placeholder="Nomor Rekening/E-wallet">


    <label for="metodePembayaran">Metode Pembayaran:</label>
    <select id="metodePembayaran" class="form-control my-2" onchange="updatePaymentOptions()">
        <option value="">Pilih Metode Pembayaran</option>
        <option value="Transfer Bank">Transfer Bank</option>
        <option value="E-Wallet">E-Wallet</option>
    </select>


    <div id="rekeningContainer" class="mt-2" style="display: none;">
        <label for="rekeningSelect">Pilih Bank/E-Wallet:</label>
        <select id="rekeningSelect" class="form-control my-2"></select>
    </div>
    <p id="rekeningInfo" class="text-center fw-bold mt-2"></p>

    <button class="btn btn-primary w-100 mt-2" onclick="processPayment()">Konfirmasi Pembayaran</button>
</div> -->