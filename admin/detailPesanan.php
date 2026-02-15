<?php
session_start();

// Cek login dan role
if (!isset($_SESSION['id_user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include '../contant/koneksi.php';

// Ambil ID pesanan
$id_pesanan = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id_pesanan <= 0) {
    die("ID pesanan tidak valid.");
}

// Ambil data pesanan
$sql = "SELECT * FROM pesanan WHERE id_pesanan = $id_pesanan";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}
$pesanan = mysqli_fetch_assoc($result);

// Ambil detail produk
$sql_detail = "
    SELECT pd.*, p.nama_produk 
    FROM pesanan_detail pd
    JOIN produk p ON pd.id_produk = p.id_produk
    WHERE pd.id_pesanan = $id_pesanan
";
$detail = mysqli_query($conn, $sql_detail);
if (!$detail) {
    die("Query detail gagal: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Detail Pesanan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-dark text-white">
                <h4 class="mb-0"><i class="bi bi-receipt-cutoff me-2"></i>Detail Pesanan #<?= $pesanan['id_pesanan'] ?></h4>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Nama Penerima:</strong> <?= htmlspecialchars($pesanan['nama_penerima']) ?></p>
                        <p><strong>No HP:</strong> <?= htmlspecialchars($pesanan['no_hp']) ?></p>
                        <p><strong>Alamat:</strong> <?= htmlspecialchars($pesanan['alamat']) ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Metode Pembayaran:</strong> <?= $pesanan['metode_pembayaran'] ?> - <?= $pesanan['opsi_pembayaran'] ?></p>
                        <p><strong>Status:</strong> <span class="badge bg-info text-dark"><?= $pesanan['status'] ?></span></p>
                        <div class="d-flex me-5">
                            <p><strong>Bukti Pembayaran:</strong><br>
                                <?php if ($pesanan['bukti_pembayaran']): ?>
                                    <img src="../<?= $pesanan['bukti_pembayaran'] ?>" width="200" class="img-thumbnail" data-bs-toggle="modal" data-bs-target="#zoomBukti">
                                <?php else: ?>
                                    <span class="text-danger">Belum ada</span>
                                <?php endif; ?>
                            </p>
                            <div class="ps-5">
                                <p><strong>Bukti Selesai:</strong><br>
                                    <?php if ($pesanan['bukti_selesai']): ?>
                                        <img src="../<?= $pesanan['bukti_selesai'] ?>" width="200" class="img-thumbnail" data-bs-toggle="modal" data-bs-target="#zoomSelesai">
                                    <?php else: ?>
                                        <span class="text-danger">Belum ada</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <h5 class="mb-3">Daftar Produk</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>Nama Produk</th>
                                <th>Ukuran</th>
                                <th>Jumlah</th>
                                <th>Harga Satuan</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($detail)): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['nama_produk']) ?></td>
                                    <td><?= $row['ukuran_produk'] ?></td>
                                    <td><?= $row['jumlah_produk'] ?></td>
                                    <td>Rp<?= number_format($row['harga_satuan'], 0, ',', '.') ?></td>
                                    <td>Rp<?= number_format($row['subtotal'], 0, ',', '.') ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <h5 class="text-end mt-3">Total: <span class="text-success">Rp<?= number_format($pesanan['total_harga'], 0, ',', '.') ?></span></h5>
                <div class="text-end mt-3">
                    <a href="dataPesanan.php" class="btn btn-secondary"><i class="bi bi-arrow-left-circle"></i> Kembali ke Daftar Pesanan</a>
                </div>
            </div>
        </div>
    </div>

    <?php if ($pesanan['bukti_pembayaran']): ?>
        <!-- Modal Zoom Gambar -->
        <div class="modal fade" id="zoomBukti" tabindex="-1" aria-labelledby="zoomBuktiLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content bg-transparent border-0">
                    <div class="modal-body text-center p-0">
                        <img src="../<?= $pesanan['bukti_pembayaran'] ?>" alt="Bukti Pembayaran" class="img-fluid w-100" style="max-height: 90vh; object-fit: contain;">
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($pesanan['bukti_selesai']): ?>
        <!-- Modal Zoom Gambar Bukti Selesai -->
        <div class="modal fade" id="zoomSelesai" tabindex="-1" aria-labelledby="zoomSelesaiLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content bg-transparent border-0">
                    <div class="modal-body text-center p-0">
                        <img src="../<?= $pesanan['bukti_selesai'] ?>" alt="Bukti Selesai" class="img-fluid w-100" style="max-height: 90vh; object-fit: contain;">
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>