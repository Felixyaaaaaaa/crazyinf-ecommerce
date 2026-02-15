<?php
session_start();

// Cek apakah user sudah login dan role-nya admin
if (!isset($_SESSION['id_user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include "../contant/koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email    = $_POST['email'];
    $role     = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO user (username, password, email, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $password, $email, $role);

    if ($stmt->execute()) {
        echo "<script>alert('User berhasil ditambahkan'); window.location.href = 'tambahUser.php';</script>";
    } else {
        echo "Gagal menyimpan user: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Tambah User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar py-4 px-3 ">
                <h4 class="text-white mb-4">Halo, <?php echo $_SESSION['username']; ?></h4>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a class="nav-link" href="index.php"><i class="bi bi-house-door"></i> Dashboard</a></li>
                    <li class="nav-item mb-2"><a class="nav-link" href="tambahProduk.php"><i class="bi bi-plus-square"></i> Tambah Produk</a></li>
                    <li class="nav-item mb-2"><a class="nav-link" href="dataProduk.php"><i class="bi bi-list-ul"></i> Data Produk</a></li>
                    <li class="nav-item mb-2"><a class="nav-link" href="tambahUser.php"><i class="bi bi-person-add"></i> Tambah User</a></li>
                    <li class="nav-item mb-2"><a class="nav-link" href="kelolaUser.php"><i class="bi bi-person"></i> Kelola User</a></li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="dataPesanan.php"><i class="bi bi-basket"></i> Data Pesanan</a>
                    </li>
                    <li class="nav-item mb-2"><a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                </ul>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="card shadow p-4">
                    <h3 class="mb-4">Tambah User Baru</h3>
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan User</button>
                    </form>
                </div>
            </main>
        </div>
    </div>

</body>

</html>