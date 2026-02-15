<?php
session_start();

// Cek apakah user sudah login dan role-nya admin
if (!isset($_SESSION['id_user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}


include "../contant/koneksi.php";

$query = "SELECT * FROM user ORDER BY id_user DESC";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Kelola User</title>
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
                        <a class="nav-link active" href="kelolaUser.php"><i class="bi bi-person"></i> Kelola User</a>
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
                    <h3 class="mb-3">Daftar User</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= htmlspecialchars($row['username']); ?></td>
                                        <td><?= htmlspecialchars($row['email']); ?></td>
                                        <td><?= htmlspecialchars($row['role']); ?></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editUserModal<?= $row['id_user']; ?>">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <a href="hapusUser.php?id=<?= $row['id_user']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus user ini?');">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>

                        <?php
                        // Reset ulang result agar bisa digunakan lagi untuk modal
                        $result->data_seek(0);
                        while ($row = $result->fetch_assoc()):
                        ?>
                            <div class="modal fade" id="editUserModal<?= $row['id_user']; ?>" tabindex="-1" aria-labelledby="editUserModalLabel<?= $row['id_user']; ?>" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <form action="editUser.php" method="POST" class="modal-content">
                                        <div class="modal-header text-white" style="background-color: #112D4E;">
                                            <h5 class="modal-title" id="editUserModalLabel<?= $row['id_user']; ?>">Edit User - <?= htmlspecialchars($row['username']); ?></h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <input type="hidden" name="id_user" value="<?= $row['id_user']; ?>">

                                            <div class="mb-3">
                                                <label class="form-label">Username</label>
                                                <input type="text" class="form-control" name="username" value="<?= htmlspecialchars($row['username']); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Email</label>
                                                <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($row['email']); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Role</label>
                                                <select class="form-select" name="role" required>
                                                    <option value="admin" <?= ($row['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                                                    <option value="user" <?= ($row['role'] == 'user') ? 'selected' : ''; ?>>User</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" name="update_user" class="btn btn-success">Simpan</button>
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
