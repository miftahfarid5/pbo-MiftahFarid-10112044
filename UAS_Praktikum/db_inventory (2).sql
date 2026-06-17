-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2026 at 07:27 AM
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
-- Database: `db_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_pembelian`
--

CREATE TABLE `detail_pembelian` (
  `no_pembelian` varchar(30) DEFAULT NULL,
  `kd_barang` varchar(100) DEFAULT NULL,
  `kode_jenis` varchar(50) DEFAULT NULL,
  `jumlah_barang` int(11) DEFAULT NULL,
  `harga_barang` int(11) DEFAULT NULL,
  `total_harga` int(11) DEFAULT NULL,
  `no_item` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_pembelian`
--

INSERT INTO `detail_pembelian` (`no_pembelian`, `kd_barang`, `kode_jenis`, `jumlah_barang`, `harga_barang`, `total_harga`, `no_item`) VALUES
('BUY-202505215501', 'BRG02', 'ALT', 3, 22000, 66000, NULL),
('BUY-202505215501', 'BRG06', 'KOM', 1, 320000, 320000, NULL),
('BUY-202505215501', 'BRG03', 'ALT', 3, 32000, 96000, NULL),
('BUY-202505294106', 'BRG01', 'ALT', 5, 15200, 76000, NULL),
('BUY-202505294106', 'BRG01', 'ALT', 5, 15200, 76000, NULL),
('PBL-20260617-202505294107', 'BRG19', 'ALT', 3, 12000, 36000, NULL),
('PBL-20260617-202505294108', 'BRG07', 'ALT', 1, 32000, 32000, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `detail_penjualan`
--

CREATE TABLE `detail_penjualan` (
  `no_penjualan` varchar(30) DEFAULT NULL,
  `kd_barang` varchar(100) DEFAULT NULL,
  `kode_jenis` varchar(30) DEFAULT NULL,
  `jumlah_barang` int(11) DEFAULT NULL,
  `harga_barang` int(11) DEFAULT NULL,
  `total_harga` int(11) DEFAULT NULL,
  `no_item` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_penjualan`
--

INSERT INTO `detail_penjualan` (`no_penjualan`, `kd_barang`, `kode_jenis`, `jumlah_barang`, `harga_barang`, `total_harga`, `no_item`) VALUES
('PJL-20260617-001', 'BRG14', 'ALT', 1, 6000, 6000, NULL),
('PJL-20260617-001', 'BRG02', 'ALT', 1, 25000, 25000, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_barang`
--

CREATE TABLE `tb_barang` (
  `kd_barang` varchar(100) NOT NULL,
  `kode_jenis` varchar(20) DEFAULT NULL,
  `nama_barang` varchar(255) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `harga_beli` int(11) DEFAULT NULL,
  `harga_jual` int(11) DEFAULT NULL,
  `gambar_produk` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_barang`
--

INSERT INTO `tb_barang` (`kd_barang`, `kode_jenis`, `nama_barang`, `stok`, `harga_beli`, `harga_jual`, `gambar_produk`) VALUES
('BRG01', 'ALT', 'Spidol Besar', 70, 15200, 15800, 'b6413af4-d89e-409a-8e27-58797c81bb73.jpg'),
('BRG02', 'ALT', 'Pensil 2B', 62, 22000, 25000, 'Pencil Pensil Joyko P-88 2B_ Pencil 2B for Computer.jpg'),
('BRG03', 'ALT', 'Ball Point Standard', 43, 32000, 33500, 'The classic BIC Cristal Original pen is the….jpg'),
('BRG04', 'ALT', 'Stabillo Faber Castle', 10, 65000, 68500, 'FABER CASTELL Textliner Classic Marker Pen….jpg'),
('BRG05', 'ALT', 'Karet Penghapus Faber Castell', 5, 15000, 18000, 'Merk _ Faber-Castell_Panjang _ 4 Cm__Penghapus….jpg'),
('BRG06', 'KOM', 'Flashdisk Sandisk', 31, 320000, 335000, 'Flashdisk Sandisk Cz50 32Gb.jpg'),
('BRG07', 'ALT', 'Staples', 12, 32000, 33500, 'Limited-time deal_ Amazon Basics Stapler with 1000….jpg'),
('BRG08', 'ALT', 'Maped Gum Stick Rubber Eraser', 35, 15000, 15500, 'La gomme absorbante, très douce et malléable….jpg'),
('BRG09', 'ALT', 'PRONTO Clear Holder A4 10 Lembar', 24, 32000, 33000, '10 pièces_lot Vertical Transparent vinyle….jpg'),
('BRG10', 'KOM', 'Loose Leaf', 33, 18000, 20000, 'Deskripsi Produk __Bamboo Loose Leaf A5 isi [50….jpg'),
('BRG11', 'ALT', 'Joyko Pulpen Gell', 30, 45000, 50000, 'HARGA TERBUT ADALAH HARGA 1 PACK ISI 12 PCS PULPEN….jpg'),
('BRG12', 'ALT', 'Alat pendeteksi uang palsu Joyko', 10, 150000, 200000, 'Mesin Hitung Uang Dynamic 993 EV.jpg'),
('BRG13', 'ALT', 'Correction Tape Joyko', 20, 12000, 13000, 'Tipex _ Correction Tape Joyko CT 559__Jenis_ Tipex….jpg'),
('BRG14', 'ALT', 'Sticky Notes Joyko', 39, 5000, 6000, 'Merk _ Joyko_Kode _ MMS-1_Tipe _ Memo Stick….jpg'),
('BRG15', 'ALT', 'Binder Clip', 10, 35000, 40000, 'Binder clips no_105__Price listed is for small per….jpg'),
('BRG16', 'ALT', 'Cutter Joyko', 15, 3200, 4000, 'Eine Uhr für die Bedürfnisse der Kinder - Galaxus.jpg'),
('BRG17', 'ALT', 'Dispenser Tape', 10, 8200, 10000, 'PRICES MAY VARY_ HEAVY DUTY DESKTOP TAPE DISPENSER….jpg'),
('BRG18', 'ALT', 'Isi Staples', 40, 3000, 5000, 'Isi staples max No_10-1m untuk staples HD-10 atau….jpg'),
('BRG19', 'ALT', 'Gunting Joyko', 18, 12000, 15000, 'HARGA 1 PCS_BERAT _ 110 GRAM__MOHON BACA DESKRIPSI….jpg'),
('BRG20', 'ALT', 'Pensil Warna Joyko', 20, 42000, 50000, 'HALO SOBAT SMART_NIH MIMIN READY PRODUK___ JOYKO….jpg'),
('BRG21', 'ALT', 'Crayon Warna Joyko', 5, 50000, 52000, 'Crayon Joyko Putar Silky 24 Warna.jpg'),
('BRG22', 'ALT', 'Alat Pembolong Kertas', 30, 38000, 40000, '10 Rekomendasi Alat Pembolong Kertas _ Perforator….jpg'),
('BRG24', 'ALT', 'Pulpen Faster', 30, 32000, 33500, 'Pulpen Faster C6 (cetek cetek)_ketebalan garis….jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tb_customer`
--

CREATE TABLE `tb_customer` (
  `id_customer` varchar(100) NOT NULL,
  `nama_customer` text DEFAULT NULL,
  `jenis_kelamin` varchar(100) DEFAULT NULL,
  `alamat_customer` text DEFAULT NULL,
  `telepon_customer` varchar(100) DEFAULT NULL,
  `email_customer` varchar(100) DEFAULT NULL,
  `pass_customer` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_customer`
--

INSERT INTO `tb_customer` (`id_customer`, `nama_customer`, `jenis_kelamin`, `alamat_customer`, `telepon_customer`, `email_customer`, `pass_customer`) VALUES
('1', 'customer', NULL, NULL, NULL, 'customer@gmail.com', 'customer');

-- --------------------------------------------------------

--
-- Table structure for table `tb_jenis`
--

CREATE TABLE `tb_jenis` (
  `kode_jenis` varchar(20) NOT NULL,
  `jenis` varchar(50) DEFAULT NULL,
  `satuan` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_jenis`
--

INSERT INTO `tb_jenis` (`kode_jenis`, `jenis`, `satuan`) VALUES
('ALT', 'ALAT TULIS', 'PCS'),
('ARC', 'ARCHRIVER', 'PCS'),
('CET', 'CETAKAN', 'PCS'),
('HELP', 'HELPER', 'PCS'),
('KOM', 'KOMPUTER', 'PCS');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pembelian`
--

CREATE TABLE `tb_pembelian` (
  `no_pembelian` varchar(100) NOT NULL,
  `tanggal_pembelian` varchar(30) DEFAULT NULL,
  `id_supplier` varchar(100) DEFAULT NULL,
  `total_barangall` int(11) DEFAULT NULL,
  `total_hargaall` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_pembelian`
--

INSERT INTO `tb_pembelian` (`no_pembelian`, `tanggal_pembelian`, `id_supplier`, `total_barangall`, `total_hargaall`) VALUES
('BUY-202505215501', '2025-04-30', 'SUP001', 7, 482000),
('BUY-202505294106', '2025-05-29', 'SUP001', 10, 152000),
('PBL-20260617-202505294107', '2026-06-17', 'SUP001', 3, 36000),
('PBL-20260617-202505294108', '2026-06-17', 'SUP002', 1, 32000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_penjualan`
--

CREATE TABLE `tb_penjualan` (
  `no_penjualan` varchar(30) NOT NULL,
  `tanggal_penjualan` varchar(30) DEFAULT NULL,
  `id_customer` varchar(100) DEFAULT NULL,
  `total_barangall` int(11) DEFAULT NULL,
  `total_hargaall` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_penjualan`
--

INSERT INTO `tb_penjualan` (`no_penjualan`, `tanggal_penjualan`, `id_customer`, `total_barangall`, `total_hargaall`) VALUES
('PJL-20260617-001', '2026-06-17', '1', 2, 31000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_supplier`
--

CREATE TABLE `tb_supplier` (
  `id_supplier` varchar(100) NOT NULL,
  `nama_supplier` text DEFAULT NULL,
  `alamat_supplier` text DEFAULT NULL,
  `telepon_supplier` varchar(100) DEFAULT NULL,
  `email_supplier` varchar(100) DEFAULT NULL,
  `pass_supplier` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_supplier`
--

INSERT INTO `tb_supplier` (`id_supplier`, `nama_supplier`, `alamat_supplier`, `telepon_supplier`, `email_supplier`, `pass_supplier`) VALUES
('SUP001', 'PT.AW FABER CASTELL INDONESIA', 'Jl. Raya Cibubur No. 88, Depok', '02198765432', 'faber2@pt.co.id', 'passfaber2'),
('SUP002', 'PT.MEGATRON ELEKTRONIK', 'Jl. Batam Center No. 9, Batam', '0778123123', 'megatron@pt.co.id', 'passmega'),
('SUP004', 'PT.GEMILANG PRATAMA', 'Jl. Merdeka No. 10, Jakarta', '02112345678', 'gemilang@pt.co.id', 'passgemilang');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `tipe_user` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `tipe_user`) VALUES
(11, 'admin', 'admin', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  ADD KEY `no_pembelian` (`no_pembelian`),
  ADD KEY `kd_barang` (`kd_barang`),
  ADD KEY `kode_jenis` (`kode_jenis`);

--
-- Indexes for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD KEY `no_penjualan` (`no_penjualan`),
  ADD KEY `kd_barang` (`kd_barang`),
  ADD KEY `kode_jenis` (`kode_jenis`);

--
-- Indexes for table `tb_barang`
--
ALTER TABLE `tb_barang`
  ADD PRIMARY KEY (`kd_barang`),
  ADD KEY `kode_jenis` (`kode_jenis`);

--
-- Indexes for table `tb_customer`
--
ALTER TABLE `tb_customer`
  ADD PRIMARY KEY (`id_customer`);

--
-- Indexes for table `tb_jenis`
--
ALTER TABLE `tb_jenis`
  ADD PRIMARY KEY (`kode_jenis`);

--
-- Indexes for table `tb_pembelian`
--
ALTER TABLE `tb_pembelian`
  ADD PRIMARY KEY (`no_pembelian`),
  ADD KEY `id_supplier` (`id_supplier`);

--
-- Indexes for table `tb_penjualan`
--
ALTER TABLE `tb_penjualan`
  ADD PRIMARY KEY (`no_penjualan`),
  ADD KEY `id_customer` (`id_customer`);

--
-- Indexes for table `tb_supplier`
--
ALTER TABLE `tb_supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  ADD CONSTRAINT `detail_pembelian_ibfk_1` FOREIGN KEY (`no_pembelian`) REFERENCES `tb_pembelian` (`no_pembelian`),
  ADD CONSTRAINT `detail_pembelian_ibfk_2` FOREIGN KEY (`kd_barang`) REFERENCES `tb_barang` (`kd_barang`),
  ADD CONSTRAINT `detail_pembelian_ibfk_3` FOREIGN KEY (`kode_jenis`) REFERENCES `tb_jenis` (`kode_jenis`);

--
-- Constraints for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD CONSTRAINT `detail_penjualan_ibfk_1` FOREIGN KEY (`no_penjualan`) REFERENCES `tb_penjualan` (`no_penjualan`),
  ADD CONSTRAINT `detail_penjualan_ibfk_2` FOREIGN KEY (`kd_barang`) REFERENCES `tb_barang` (`kd_barang`),
  ADD CONSTRAINT `detail_penjualan_ibfk_3` FOREIGN KEY (`kode_jenis`) REFERENCES `tb_jenis` (`kode_jenis`);

--
-- Constraints for table `tb_barang`
--
ALTER TABLE `tb_barang`
  ADD CONSTRAINT `tb_barang_ibfk_1` FOREIGN KEY (`kode_jenis`) REFERENCES `tb_jenis` (`kode_jenis`);

--
-- Constraints for table `tb_pembelian`
--
ALTER TABLE `tb_pembelian`
  ADD CONSTRAINT `tb_pembelian_ibfk_1` FOREIGN KEY (`id_supplier`) REFERENCES `tb_supplier` (`id_supplier`);

--
-- Constraints for table `tb_penjualan`
--
ALTER TABLE `tb_penjualan`
  ADD CONSTRAINT `tb_penjualan_ibfk_1` FOREIGN KEY (`id_customer`) REFERENCES `tb_customer` (`id_customer`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
