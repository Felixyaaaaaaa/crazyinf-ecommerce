<?php
session_start();

// Cek apakah user sudah login dan role-nya admin
if (!isset($_SESSION['id_user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

?>

<?php
include "../contant/koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_produk = $_POST['nama_produk'];
    $kategori    = $_POST['category'];
    $harga       = $_POST['harga'];

    // Upload gambar
    $gambar_name = basename($_FILES["gambar"]["name"]);
    $relative_path = "img/produk/" . $gambar_name;
    $target_file = "../" . $relative_path; 
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validasi tipe file
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowed_types)) {
        echo "<script>alert('Hanya file gambar yang diperbolehkan (JPG, JPEG, PNG, GIF)');</script>";
        exit;
    }

    // Upload file
    if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
        // Simpan ke database
        $stmt = $conn->prepare("INSERT INTO produk (nama_produk, category, harga, img) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $nama_produk, $kategori, $harga, $gambar_name);

        if ($stmt->execute()) {
            echo "<script>alert('Produk berhasil ditambahkan'); window.location.href = 'tambahProduk.php';</script>";
        } else {
            echo "Gagal menyimpan produk: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Gagal mengupload gambar.";
    }

    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
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
                    <h3 class="mb-4">Tambah Produk Baru</h3>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nama_produk" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="nama_produk" name="nama_produk" required>
                        </div>

                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <select class="form-select" id="category" name="category" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="tshirt">Tshirt</option>
                                <option value="hoodie">Hoodie</option>
                                <option value="crewneck">Crewneck</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga Produk (Rp)</label>
                            <input type="number" class="form-control" id="harga" name="harga" required>
                        </div>

                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar Produk</label>
                            <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" required>
                        </div>

                        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan Produk</button>
                    </form>
                </div>
            </main>


        </div>
    </div>

</body>

</html>