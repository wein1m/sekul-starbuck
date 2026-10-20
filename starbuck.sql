-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 20, 2026 at 02:31 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `starbuck`
--

-- --------------------------------------------------------

--
-- Table structure for table `Detail_Transaksi`
--

CREATE TABLE `Detail_Transaksi` (
  `id_detail_transaksi` int(11) NOT NULL,
  `id_kasir` int(11) DEFAULT NULL,
  `id_produk` int(11) DEFAULT NULL,
  `id_nota` varchar(10) DEFAULT NULL,
  `id_transaksi` int(11) DEFAULT NULL,
  `kategori` enum('Makanan','Minuman','Tambahan') DEFAULT NULL,
  `kuantitas` int(11) DEFAULT NULL,
  `kuantitas_harga` decimal(12,2) DEFAULT NULL,
  `harga` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `Detail_Transaksi`
--

INSERT INTO `Detail_Transaksi` (`id_detail_transaksi`, `id_kasir`, `id_produk`, `id_nota`, `id_transaksi`, `kategori`, `kuantitas`, `kuantitas_harga`, `harga`) VALUES
(1, 1002, 1, 'Chk 2639', 1, 'Minuman', 1, 123.77, 123.76),
(2, 1002, 2, 'Chk 2639', 1, 'Minuman', 2, 24.93, 12.47),
(3, 1002, 3, 'Chk 2639', 1, 'Minuman', 1, 105.96, 100.00),
(4, 1002, 4, 'Chk 2639', 1, 'Tambahan', 1, 14.25, 14.25),
(5, 1002, 5, 'Chk 2639', 1, 'Makanan', 1, 57.88, 57.88),
(6, 1005, 2, 'Chk 2640', 2, 'Minuman', 3, 37.40, 12.47),
(7, 1005, 6, 'Chk 2640', 2, 'Minuman', 1, 30.00, 30.00),
(8, 1005, 7, 'Chk 2640', 2, 'Minuman', 5, 135.00, 27.00);

-- --------------------------------------------------------

--
-- Table structure for table `Kasir`
--

CREATE TABLE `Kasir` (
  `id_kasir` int(11) NOT NULL,
  `nama_kasir` varchar(50) DEFAULT NULL,
  `no_telp` varchar(24) DEFAULT NULL,
  `alamat` varchar(120) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `Kasir`
--

INSERT INTO `Kasir` (`id_kasir`, `nama_kasir`, `no_telp`, `alamat`, `email`) VALUES
(1002, 'Olivia', '08912313131231', 'Jalan Bypass Ngurah Rai', 'Oliv@gmail.com'),
(1003, 'Dilla', '08912313131232', 'Jalan Pulau Sailus', 'dilla21@gmail.com'),
(1004, 'Nitha', '08912313131233', 'Jalan Taman Pancing', 'nit24@yahoo.com'),
(1005, 'Ade', '08912313131234', 'Jalan Danau Tempe', 'ade788@email.com'),
(1006, 'Magnum', '08912313131235', 'Jalan Monang Maning', 'mag@gmail.com\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `Produk`
--

CREATE TABLE `Produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(100) DEFAULT NULL,
  `harga` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `Produk`
--

INSERT INTO `Produk` (`id_produk`, `nama_produk`, `harga`) VALUES
(1, 'Venti Mocha Latte', 123.76),
(2, 'Oat Milk', 12.47),
(3, 'Grande Caramel Macchiato', 105.96),
(4, 'Extra Shot', 14.25),
(5, 'Tall Pike Place Roast', 57.88),
(6, 'Matcha Latte', 30.00),
(7, 'Americanno', 27.00);

-- --------------------------------------------------------

--
-- Table structure for table `Transaksi`
--

CREATE TABLE `Transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `subtotal` decimal(12,2) DEFAULT NULL,
  `pajak` decimal(12,2) DEFAULT NULL,
  `total` decimal(12,2) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `waktu` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `Transaksi`
--

INSERT INTO `Transaksi` (`id_transaksi`, `subtotal`, `pajak`, `total`, `tanggal`, `waktu`) VALUES
(1, 326.77, 35.94, 362.72, '2026-03-18', '10:52:41'),
(2, 202.40, 22.26, 224.66, '2026-03-19', '12:45:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Detail_Transaksi`
--
ALTER TABLE `Detail_Transaksi`
  ADD PRIMARY KEY (`id_detail_transaksi`),
  ADD KEY `fk_kasir` (`id_kasir`),
  ADD KEY `fk_produk` (`id_produk`),
  ADD KEY `fk_transaksi` (`id_transaksi`);

--
-- Indexes for table `Kasir`
--
ALTER TABLE `Kasir`
  ADD PRIMARY KEY (`id_kasir`);

--
-- Indexes for table `Produk`
--
ALTER TABLE `Produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `Transaksi`
--
ALTER TABLE `Transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Detail_Transaksi`
--
ALTER TABLE `Detail_Transaksi`
  MODIFY `id_detail_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `Kasir`
--
ALTER TABLE `Kasir`
  MODIFY `id_kasir` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1007;

--
-- AUTO_INCREMENT for table `Produk`
--
ALTER TABLE `Produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `Transaksi`
--
ALTER TABLE `Transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Detail_Transaksi`
--
ALTER TABLE `Detail_Transaksi`
  ADD CONSTRAINT `fk_kasir` FOREIGN KEY (`id_kasir`) REFERENCES `Kasir` (`id_kasir`),
  ADD CONSTRAINT `fk_produk` FOREIGN KEY (`id_produk`) REFERENCES `Produk` (`id_produk`),
  ADD CONSTRAINT `fk_transaksi` FOREIGN KEY (`id_transaksi`) REFERENCES `Transaksi` (`id_transaksi`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
