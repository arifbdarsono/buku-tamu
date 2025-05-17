-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 17, 2025 at 10:59 AM
-- Server version: 5.7.11
-- PHP Version: 7.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bukutamu`
--

-- --------------------------------------------------------

--
-- Table structure for table `tamu`
--

CREATE TABLE `tamu` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `pesan` text NOT NULL,
  `waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(45) DEFAULT NULL,
  `user_agent` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tamu`
--

INSERT INTO `tamu` (`id`, `nama`, `pesan`, `waktu`, `ip`, `user_agent`) VALUES
(2, 'Budi', 'Halo kawan! Ini Budi', '2025-05-13 12:13:33', NULL, NULL),
(3, 'Tom', 'Halo, saya thomas, saya pemeran utama film kartun Tom and Jerry yang pasti sudah tidak asing di telinga anda karena film tersebut sudah sangat dikenal luas.', '2025-05-13 15:03:17', NULL, NULL),
(4, 'Jerry', 'Halo, aku jerry mouse, aku juga pemeran utama serial kartun Tom &amp; Jerry. Kalian pasti kenal aku :)', '2025-05-13 15:59:22', NULL, NULL),
(5, 'Diana', 'Hi Tom, hi jerry, i\'m Diana &amp; i am a big fan both of u. Cheers...', '2025-05-13 16:01:40', NULL, NULL),
(6, 'Ini Budi', 'Saya juga penggemar film kartun Tom and Jerry. Terimakasih kalian telah menjadi teman masa kecilku dan menemani hari-hariku menjadi lebih berwarna.', '2025-05-13 16:04:26', NULL, NULL),
(7, 'Uncle Gober', 'Halo, salam kenal semuanya, apakah kalian ada yang mengenaliku? ^_^', '2025-05-13 16:06:26', NULL, NULL),
(8, 'Mickey', 'Hai uncle gober, tentu saja kami mengenalimu. kamu juga merupakan tokoh kartun legendaris kan', '2025-05-13 16:08:33', NULL, NULL),
(9, 'Arif Budiman', 'Halo semua. saya programmer yang membuat buku tamu ini. Salam kenal semuanya.', '2025-05-13 16:53:34', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0'),
(10, 'Ini_Budi_lagi', 'Halo Arif, terimakasih telah membuat buku tamu ini sehingga kami dapat saling berkomunikasi.', '2025-05-13 17:24:56', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0'),
(11, 'Budiansyah', 'Halo arif, senang mengenal si pembuat buku tamu ini. terus berkarya ya!', '2025-05-13 17:28:31', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0'),
(12, 'Budi lagi', 'Halo arif, fitur apa lagi yang rencananya akan Anda tambahkan pada aplikasi buku tamu ini? bisakah saya menyarankan sebuah fitur baru kepada Anda?', '2025-05-13 17:31:19', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0'),
(13, 'arif', 'update csrf token dan struktur direktori pada aplikasi', '2025-05-16 16:00:55', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0'),
(14, 'dewa', 'halo, bagaimana kelanjutan dari proyek ini?', '2025-05-17 04:05:02', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0'),
(15, 'dewi', 'tes isian dengan karakter khusus seperti \'!\' "#<>"', '2025-05-17 04:08:13', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tamu`
--
ALTER TABLE `tamu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tamu`
--
ALTER TABLE `tamu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
