-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2024 at 03:04 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko_buku_kripto`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`) VALUES
(1, 'admin', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `penulis` varchar(255) NOT NULL,
  `penerbit` varchar(255) NOT NULL,
  `tahun_terbit` year(4) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `stok` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `cover` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id_buku`, `judul`, `penulis`, `penerbit`, `tahun_terbit`, `kategori`, `harga`, `stok`, `deskripsi`, `cover`) VALUES
(6, 'Si Anak Spesial', 'Lora ', 'PT Sinar Mas', 2024, 'Drama', '50000.00', 6, 'Kisah anak dengan keunikan luar biasa yang menghadapi dunia penuh tantangan untuk menemukan tempatnya.', '673d1f30bc8b05.62091202.png'),
(7, 'Kala Itu Langit Biru', 'Senja Majumu', 'Togas', 2023, 'Romantis', '60000.00', 10, ' Nostalgia tentang persahabatan, cinta, dan kehangatan keluarga di bawah langit yang cerah.', '673d1f763f2236.65822185.png'),
(8, 'Dimana Hati Terjalin', 'Wongso', 'Pertamina', 2020, 'Politik', '65000.00', 9, 'Cinta, kehilangan, dan takdir berpadu dalam perjalanan menemukan tempat hati sejati.', '673d1fb8356703.30079844.png'),
(9, 'Dalamnya Lubuk Hati', 'Riang Gembira', 'Orbital', 2019, 'Pendidikan', '70000.00', 3, 'Sebuah pencarian makna hidup di tengah gelombang emosi dan rahasia terdalam jiwa.', '673d1ff21fa4e8.86239520.png'),
(10, 'Soul', 'Michael Myers', 'Tautan Kasih', 2018, 'Horror', '80000.00', 1, 'Sebuah perjalanan spiritual untuk menyelami arti hidup, kebahagiaan, dan kedamaian batin.', '673d2039595527.14594846.png');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `judul_buku` text NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  `status` varchar(10) DEFAULT 'Pending',
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `kunci` varchar(255) NOT NULL,
  `iv` varchar(32) NOT NULL,
  `steganografi_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_user`, `judul_buku`, `total_harga`, `status`, `bukti_pembayaran`, `created_at`, `updated_at`, `kunci`, `iv`, `steganografi_image`) VALUES
(8, 7, 'Soul (x1), Si Anak Spesial (x1)', '130000.00', 'Diterima', 'uploads/enc_673d20abdaa6b.enc', '2024-11-19 23:34:33', '2024-11-19 23:36:59', '55a5c4790a3b1bd0133803d119f6a5d8', 'e8da13d15d1fbc89af17d50fbe6b0733', 'uploads/stegano_673d20c476608.png'),
(9, 7, 'Dimana Hati Terjalin (x1), Kala Itu Langit Biru (x1)', '125000.00', 'Pending', NULL, '2024-11-20 01:58:25', '2024-11-20 01:58:25', '', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tanggal_lahir` varchar(20) NOT NULL,
  `profil_picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama`, `jenis_kelamin`, `alamat`, `telepon`, `tempat_lahir`, `tanggal_lahir`, `profil_picture`) VALUES
(6, 'fahmikarim', 'f11d50d63d3891a44c332e46d6d7d561', 'J$*80o\';(*#-', 'L$/4yHv+!', 'C\" *=-v$e_ue@%7-,1-;?', '{jpelw9t|w', 'E538\"&', 'ybycy 6`t ', '673d1e5944ce8.png'),
(7, 'Messi', 'c5aa3124b1adad080927ce4d144c6b33', 'F8 &36jmB*3,4&', 'L$/4yHv+!', 'C($?>!p\"3\'ue@&4/=(', '~`zda|2xw}', 'E9?9 %g', 'yb{dy~1`wv', '673d1ecd245c0.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
