<?php
session_start();

// Cek apakah user sudah login dan role-nya admin
if (!isset($_SESSION['id_user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}


include "../contant/koneksi.php";
$query = "SELECT * FROM produk ORDER BY id_produk DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Data Produk</title>
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
                    <h3 class="mb-3">Daftar Produk</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Produk</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th>Gambar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php $no = 1;
                                while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= htmlspecialchars($row['nama_produk']); ?></td>
                                        <td><?= htmlspecialchars($row['category']); ?></td>
                                        <td>Rp<?= number_format($row['harga'], 0, ',', '.'); ?></td>
                                        <td>
                                            <img src="../img/produk/<?= $row['img']; ?>" alt="Produk" width="80" class="img-thumbnail">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id_produk']; ?>">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <a href="hapusProduk.php?id=<?= $row['id_produk']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus produk ini?');">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                        <?php
                        // Reset ulang result agar bisa di-loop lagi untuk modal
                        $result->data_seek(0);
                        while ($row = $result->fetch_assoc()):
                        ?>
                            <div class="modal fade" id="editModal<?= $row['id_produk']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $row['id_produk']; ?>" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <form action="editProduk.php" method="POST" enctype="multipart/form-data" class="modal-content">
                                        <div class="modal-header text-white" style="background-color: #112D4E;">
                                            <h5 class="modal-title" id="editModalLabel<?= $row['id_produk']; ?>">Edit Produk - <?= htmlspecialchars($row['nama_produk']); ?></h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <input type="hidden" name="id_produk" value="<?= $row['id_produk']; ?>">

                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Nama Produk</label>
                                                    <input type="text" class="form-control" name="nama_produk" value="<?= htmlspecialchars($row['nama_produk']); ?>" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Kategori</label>
                                                    <select class="form-select" name="category" required>
                                                        <option value="tshirt" <?= ($row['category'] == 'tshirt') ? 'selected' : ''; ?>>Tshirt</option>
                                                        <option value="hoodie" <?= ($row['category'] == 'hoodie') ? 'selected' : ''; ?>>Hoodie</option>
                                                        <option value="crewneck" <?= ($row['category'] == 'crewneck') ? 'selected' : ''; ?>>Crewneck</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Harga</label>
                                                    <input type="number" class="form-control" name="harga" value="<?= $row['harga']; ?>" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Ganti Gambar (opsional)</label>
                                                    <input type="file" class="form-control" name="gambar" accept="image/*">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" name="update" class="btn btn-success">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?php endwhile; ?>

                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>