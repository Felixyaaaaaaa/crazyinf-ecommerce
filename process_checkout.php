<?php
session_start();
include "contant/koneksi.php";

if (!isset($_SESSION['id_user'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location='login.php';</script>";
    exit;
}

$id_user = $_SESSION['id_user'];

// Ambil data dari form
$nama_penerima     = $_POST['nama_penerima'];
$no_hp             = $_POST['no_hp'];
$metode_pembayaran = $_POST['metode_pembayaran'];
$opsi_pembayaran   = $_POST['opsi_pembayaran'];
$total_harga       = 0;

$provinsi_id  = $_POST['provinsi'];
$kabupaten_id = $_POST['kabupaten'];
$kecamatan_id = $_POST['kecamatan'];
$kelurahan_id = $_POST['kelurahan'];
$detail       = $_POST['detail_alamat'];

function get_json($path) {
    return file_exists($path) ? json_decode(file_get_contents($path), true) : [];
}

$base = __DIR__ . "/data-indonesia";

// Ambil nama berdasarkan id
$provinsi = '';
foreach(get_json("$base/provinsi.json") as $p){
    if($p['id']==$provinsi_id) $provinsi = $p['nama'];
}

$kabupaten = '';
foreach(get_json("$base/kabupaten/{$provinsi_id}.json") as $k){
    if($k['id']==$kabupaten_id) $kabupaten = $k['nama'];
}

$kecamatan = '';
foreach(get_json("$base/kecamatan/{$kabupaten_id}.json") as $kc){
    if($kc['id']==$kecamatan_id) $kecamatan = $kc['nama'];
}

$kelurahan = '';
foreach(get_json("$base/kelurahan/{$kecamatan_id}.json") as $kl){
    if($kl['id']==$kelurahan_id) $kelurahan = $kl['nama'];
}

$alamat = $detail . ", Kel. $kelurahan, Kec. $kecamatan, $kabupaten, $provinsi";

// Upload bukti pembayaran
$bukti_pembayaran = '';
if (isset($_FILES['bukti_pembayaran']) && $_FILES['bukti_pembayaran']['error'] == 0) {
    $target_dir = "img/bukti pembayaran/";
    $file_name = basename($_FILES["bukti_pembayaran"]["name"]);
    $file_path = $target_dir . time() . "_" . $file_name;

    if (move_uploaded_file($_FILES["bukti_pembayaran"]["tmp_name"], $file_path)) {
        $bukti_pembayaran = $file_path;
    }
}

// Ambil isi keranjang
$query_keranjang = mysqli_query($conn, "SELECT keranjang.*, produk.harga 
    FROM keranjang 
    JOIN produk ON keranjang.id_produk = produk.id_produk 
    WHERE keranjang.id_user = $id_user");

if (mysqli_num_rows($query_keranjang) == 0) {
    echo "<script>alert('Keranjang kosong.'); window.location='keranjang.php';</script>";
    exit;
}

// Hitung total harga
while ($row = mysqli_fetch_assoc($query_keranjang)) {
    $subtotal = $row['jumlah_produk'] * $row['harga'];
    $total_harga += $subtotal;
}

$status = "Menunggu Konfirmasi";
$tanggal_pesan = date("Y-m-d H:i:s");

$query_pesanan = "INSERT INTO pesanan (id_user, nama_penerima, no_hp, alamat, metode_pembayaran, opsi_pembayaran, bukti_pembayaran, total_harga, status, tanggal_pesan)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $query_pesanan);
mysqli_stmt_bind_param($stmt, "issssssdss", $id_user, $nama_penerima, $no_hp, $alamat, $metode_pembayaran, $opsi_pembayaran, $bukti_pembayaran, $total_harga, $status, $tanggal_pesan);
mysqli_stmt_execute($stmt);

$id_pesanan = mysqli_insert_id($conn);

// Kembali ke data keranjang
mysqli_data_seek($query_keranjang, 0);

// Insert detail pesanan
while ($row = mysqli_fetch_assoc($query_keranjang)) {
    $id_produk = $row['id_produk'];
    $ukuran    = $row['ukuran_produk'];
    $jumlah    = $row['jumlah_produk'];
    $harga     = $row['harga'];
    $subtotal  = $jumlah * $harga;

    $query_detail = "INSERT INTO pesanan_detail (id_pesanan, id_produk, ukuran_produk, jumlah_produk, harga_satuan, subtotal) 
                     VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_detail = mysqli_prepare($conn, $query_detail);
    mysqli_stmt_bind_param($stmt_detail, "iisidd", $id_pesanan, $id_produk, $ukuran, $jumlah, $harga, $subtotal);
    mysqli_stmt_execute($stmt_detail);
}

// Hapus keranjang
mysqli_query($conn, "DELETE FROM keranjang WHERE id_user = $id_user");

// Beri notifikasi dan redirect
echo "<script>alert('Pesanan berhasil dibuat!'); window.location='pesanan_saya.php';</script>";
?>
