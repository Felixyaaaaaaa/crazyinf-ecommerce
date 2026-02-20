-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for db_crazyinf
CREATE DATABASE IF NOT EXISTS `db_crazyinf` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `db_crazyinf`;

-- Dumping structure for table db_crazyinf.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `id_admin` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_crazyinf.admin: ~1 rows (approximately)
INSERT INTO `admin` (`id_admin`, `username`, `password`) VALUES
	(1, 'admin', '123123');

-- Dumping structure for table db_crazyinf.keranjang
CREATE TABLE IF NOT EXISTS `keranjang` (
  `id_keranjang` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `id_produk` int NOT NULL,
  `ukuran_produk` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `jumlah_produk` int NOT NULL,
  PRIMARY KEY (`id_keranjang`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_crazyinf.keranjang: ~3 rows (approximately)
INSERT INTO `keranjang` (`id_keranjang`, `id_user`, `id_produk`, `ukuran_produk`, `jumlah_produk`) VALUES
	(18, 7, 3, 'S', 2),
	(19, 7, 3, 'M', 1),
	(21, 12, 2, 'S', 1);

-- Dumping structure for table db_crazyinf.pesanan
CREATE TABLE IF NOT EXISTS `pesanan` (
  `id_pesanan` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `nama_penerima` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_general_ci NOT NULL,
  `metode_pembayaran` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `opsi_pembayaran` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `bukti_pembayaran` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `bukti_selesai` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `total_harga` decimal(12,2) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_pesan` datetime NOT NULL,
  PRIMARY KEY (`id_pesanan`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_crazyinf.pesanan: ~3 rows (approximately)
INSERT INTO `pesanan` (`id_pesanan`, `id_user`, `nama_penerima`, `no_hp`, `alamat`, `metode_pembayaran`, `opsi_pembayaran`, `bukti_pembayaran`, `bukti_selesai`, `total_harga`, `status`, `tanggal_pesan`) VALUES
	(2, 7, 'retno', '123', 'qwe', 'bank', 'BCA', 'img/bukti pembayaran/1745249829_Cuplikan layar 2023-07-09 232829.png', 'img/bukti_selesai/1759672609_Cuplikan layar 2025-10-03 105758.png', 150000.00, 'Selesai', '2025-04-21 17:37:09'),
	(3, 7, 'retno', '123', 'asd', 'bank', 'BNI', 'img/bukti pembayaran/1745251481_Cuplikan layar 2023-08-22 101016.png', '', 850000.00, 'Selesai', '2025-04-21 18:04:41'),
	(4, 12, 'felix', '08123', 'rt1', 'ewallet', '', 'img/bukti pembayaran/1745372363_Cuplikan layar 2023-07-09 232829.png', '', 150000.00, 'Sedang Dikemas', '2025-04-23 03:39:23');

-- Dumping structure for table db_crazyinf.pesanan_detail
CREATE TABLE IF NOT EXISTS `pesanan_detail` (
  `id_detail` int NOT NULL AUTO_INCREMENT,
  `id_pesanan` int NOT NULL,
  `id_produk` int NOT NULL,
  `ukuran_produk` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `jumlah_produk` int NOT NULL,
  `harga_satuan` decimal(12,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  PRIMARY KEY (`id_detail`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_crazyinf.pesanan_detail: ~4 rows (approximately)
INSERT INTO `pesanan_detail` (`id_detail`, `id_pesanan`, `id_produk`, `ukuran_produk`, `jumlah_produk`, `harga_satuan`, `subtotal`) VALUES
	(3, 2, 3, 'S', 1, 150000.00, 150000.00),
	(4, 3, 3, 'S', 1, 150000.00, 150000.00),
	(5, 3, 8, 'S', 2, 350000.00, 700000.00),
	(6, 4, 3, 'S', 1, 150000.00, 150000.00);

-- Dumping structure for table db_crazyinf.produk
CREATE TABLE IF NOT EXISTS `produk` (
  `id_produk` int NOT NULL AUTO_INCREMENT,
  `nama_produk` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `harga` int NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_produk`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_crazyinf.produk: ~12 rows (approximately)
INSERT INTO `produk` (`id_produk`, `nama_produk`, `category`, `harga`, `img`) VALUES
	(2, 'Graphic hoodie', 'hoodie', 250000, 'produk2.png'),
	(3, 'Oversized Hoodie', 'hoodie', 150000, 'produk3.png'),
	(4, 'Zip-Up T-Shirt', 'tshirt', 170000, 'produk4.png'),
	(5, 'Casual T-Shirt', 'tshirt', 150000, 'produk5.png'),
	(6, 'Classic T-Shirt', 'tshirt', 200000, 'produk6.png'),
	(7, 'Graphic Crewneck', 'crewneck', 300000, 'produk7.png'),
	(8, 'Oversized Hoodie', 'hoodie', 350000, 'produk8.png'),
	(9, 'Classic T-Shirt', 'tshirt', 300000, 'produk9.png'),
	(10, 'Classic T-Shirt', 'tshirt', 300000, 'produk10.png'),
	(16, 'Oversized Hoodie', 'hoodie', 150000, 'produk11.png'),
	(17, 'Graphic Crewneck', 'crewneck', 250000, 'produk14.png'),
	(19, 'Casual T-Shirt', 'tshirt', 150000, 'produk17.png');

-- Dumping structure for table db_crazyinf.user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_crazyinf.user: ~6 rows (approximately)
INSERT INTO `user` (`id_user`, `username`, `password`, `email`, `role`) VALUES
	(7, 'retno', '$2y$10$T90gCJY0CGHh2i.F0ITguu4Z8p6B4M8bLAK/tktrnAtk.2mPh4xNW', 'eresident188@gmail.com', 'admin'),
	(9, 'joko', '$2y$10$vVegkbhD1iVCRIbIl3PdL.RR9u4VcQy7Vi7NeSMgTOPbQthTbjCe.', 'eresident188@gmail.com', 'user'),
	(10, 'Dono', '$2y$10$E3sM1q.nTOST6tgmSnEK0.73dREmbnSc13Mkd1TPrFE9Jk2MLxx3y', 'dono@gmail.com', 'admin'),
	(11, 'aji', '$2y$10$JoGRL3jH9n6l3AORsopwROzQp5mF/Gn.JX1BMwP/19wE/VG64l.BG', 'aji@gmail.com', 'user'),
	(12, 'felix', '$2y$10$n9LpIF71vWunTpIhfdaehOd9z.XjR.GOpaQqfPVyaV9AuSZm.AAnK', 'felix@gmail.com', 'user'),
	(13, 'dono', '$2y$10$gsIXI7.kPNlQVUxjrIj38O0BVyipfj8Yrrmul5gv22QgAknXFVrUa', 'dono@gmail.com', 'user');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
