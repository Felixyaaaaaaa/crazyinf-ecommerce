<?php
session_start();

// Cek apakah user sudah login dan role-nya admin
if (!isset($_SESSION['id_user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}


include "../contant/koneksi.php";

// Ambil data pesanan + user
$query = "SELECT pesanan.*, user.username FROM pesanan 
          JOIN user ON pesanan.id_user = user.id_user 
          ORDER BY pesanan.id_pesanan DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Data Pesanan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar py-4 px-3">
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
                <div class="card shadow p-4">
                    <h3 class="mb-3">Daftar Pesanan</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Pemesan</th>
                                    <th>Nama Penerima</th>
                                    <th>No HP</th>
                                    <th>Alamat</th>
                                    <th>Status</th>
                                    <th>Metode</th>
                                    <th>Bukti Bayar</th>
                                    <th>Bukti Selesai</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="text-center">
                                <?php $no = 1;
                                while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= htmlspecialchars($row['username']); ?></td>
                                        <td><?= htmlspecialchars($row['nama_penerima']); ?></td>
                                        <td><?= $row['no_hp']; ?></td>
                                        <td><?= $row['alamat']; ?></td>
                                        <td><?= $row['status']; ?></td>
                                        <td><?= $row['metode_pembayaran'] . ' - ' . $row['opsi_pembayaran']; ?></td>
                                        <td>
                                            <?php if ($row['bukti_pembayaran']): ?>
                                                <img src="../<?= $row['bukti_pembayaran']; ?>" width="60">
                                            <?php else: ?>
                                                <span class="text-danger">Belum ada</span>
                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <?php if (!empty($row['bukti_selesai'])): ?>
                                                <a href="../<?= $row['bukti_selesai']; ?>" target="_blank">
                                                    <img src="../<?= $row['bukti_selesai']; ?>" width="60">
                                                </a>
                                            <?php else: ?>
                                                <span class="text-danger">Belum ada</span>
                                            <?php endif; ?>
                                        </td>

                                        <td class="d-flex justify-content-center gap-2">
                                            <!-- Tombol Edit Status -->
                                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editStatusModal<?= $row['id_pesanan']; ?>">
                                                <i class="bi bi-pencil-square"></i> Edit Status
                                            </button>

                                            <!-- Tombol Detail -->
                                            <a href="detailPesanan.php?id=<?= $row['id_pesanan']; ?>" class="btn btn-sm btn-info">
                                                <i class="bi bi-info-circle"></i> Detail
                                            </a>
                                        </td>

                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <?php
    // Reset ulang result agar bisa di-loop lagi untuk modal
    $result->data_seek(0);
    while ($row = $result->fetch_assoc()):
    ?>

        <!-- Modal Edit Status -->
        <div class="modal fade" id="editStatusModal<?= $row['id_pesanan']; ?>" tabindex="-1" aria-labelledby="editStatusModalLabel<?= $row['id_pesanan']; ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <form action="editStatusPesanan.php" method="POST" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editStatusModalLabel<?= $row['id_pesanan']; ?>">Edit Status Pesanan - <?= htmlspecialchars($row['id_pesanan']); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_pesanan" value="<?= $row['id_pesanan']; ?>">
                        <div class="mb-3">
                            <label class="form-label">Status Pesanan</label>
                            <select class="form-select" name="status" required>
                                <option value="Sedang Dikemas" <?= ($row['status'] == 'Sedang Dikemas') ? 'selected' : ''; ?>>Sedang Dikemas</option>
                                <option value="Dalam Pengiriman" <?= ($row['status'] == 'Dalam Pengiriman') ? 'selected' : ''; ?>>Dalam Pengiriman</option>
                                <option value="Selesai" <?= ($row['status'] == 'Selesai') ? 'selected' : ''; ?>>Selesai</option>
                                <option value="Dibatalkan" <?= ($row['status'] == 'Dibatalkan') ? 'selected' : ''; ?>>Dibatalkan</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="update_status" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

    <?php endwhile; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>