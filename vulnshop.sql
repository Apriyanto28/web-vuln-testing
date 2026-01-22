-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 22, 2026 at 08:38 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vulnshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `items` text DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `items`, `total`, `created_at`) VALUES
(1, 2, '[1]', 99.99, '2025-11-05 23:24:22'),
(2, 2, '[1,2]', 149.49, '2025-11-05 23:35:38'),
(3, 33, '[4]', 10.00, '2025-11-07 11:03:43'),
(4, 19, '[3]', 199.00, '2025-11-07 11:04:44'),
(5, 30, '[6]', 100.05, '2025-11-07 11:04:52'),
(6, 23, '[3,1]', 298.99, '2025-11-07 11:12:03'),
(7, 5, '[1]', 99.99, '2025-11-07 11:13:12'),
(8, 37, '[2]', 49.50, '2025-11-17 11:31:33'),
(9, 39, '[1]', 99.99, '2025-11-17 11:31:52'),
(10, 37, '[1]', 99.99, '2025-11-17 11:32:08'),
(11, 39, '[3,6]', 299.05, '2025-11-17 11:32:09'),
(12, 38, '[5]', 5.00, '2025-11-17 11:32:52'),
(13, 41, '[6,3,5]', 304.05, '2025-11-17 11:32:53'),
(14, 37, '[3,3]', 199.00, '2025-11-17 11:33:42'),
(15, 43, '[6]', 100.05, '2025-11-20 11:02:44');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`) VALUES
(1, 'T-Shirt Viral', 'Kaos distro, bahan katun', 99.99),
(2, 'Botol Minum', 'Botol stainless steel 500ml', 49.50),
(3, 'Headset Gaming', 'Stereo dengan mic', 199.00),
(4, 'Headset Gaming Lagi', 'Ini adalah headset gaming yang disukai orang lain', 10.00),
(5, 'Mouse Gaming', 'Ini mouse yang digunakan untuk bermain game', 5.00),
(6, 'Keyboard Mechanical', 'Ini merupakan keyboard yang diminati para gamer untuk digunakan', 100.05);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `fullname`, `email`, `is_admin`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'Administrator', 'admin@example.com', 1),
(2, 'alice', '7abdccbea8473767e91378e37850d296', 'Alice Example', 'alice@example.com', 0),
(3, 'apri', '67e9acd4ac497173a47cd34bba980475', '', 'apri@mail.com', 0),
(4, 'mustika', 'fe6f18f24a1779c9d79bd91448fec828', 'Mustika Ulina', 'mustika@ulina.com', 0),
(5, 'chin', 'd8a8f908d1dcb28475f606a7f42f8963', 'chincin', 'cin@gmail.com', 0),
(6, 'Nini', '11012fc2b1fb55729a5824fdda6344aa', 'Nini kiyut', 'nini12@gmail.com', 0),
(7, 'Maya', 'e101c9ae473b1eeb13745d045d60d917', 'Maya Maheswara', 'mayas@gmail.com', 0),
(8, 'dancing', '752093e12c1cb53acf4494cd87038624', 'dancingcuy', 'danluv@yahoo.com', 0),
(9, 'lala', 'a2d10a3211b415832791a6bc6031f9ab', 'lala imut', 'lala@gmail.com', 0),
(10, 'cer', '1a0b485c3fb590314ab926391fbf1d8e', 'cerrr', 'apri@mail.com', 0),
(11, 'sya', 'b3847bb6c268de7ab59390f92f3f9857', 'sya', 'apri@mail.com', 0),
(12, 'yaya', '4409eae53c2e26a65cfc24b3a2359eb9', 'Yaya simantura', 'yayalais@gmail.com', 0),
(13, 'richard', 'c98703aed69284552ffffea25a1706d9', 'Richard blaze', 'gamebeat@mail.com', 0),
(14, 'nanagoreng', '735402f2475bf90bf614c8b6dbeef337', 'nana terbang', 'nana@gmail.com', 0),
(15, 'pukimakwati', '23ca12a904095365633b33a789a8f1d6', 'RONALDO WATI', 'pukimakwati@wati.com', 0),
(16, 'Ririn', '66d3f007c48a4a8e01c650302f3ea727', 'Ririn', 'aku@gmail.com', 0),
(17, 'teven', 'a8d2fcadc3967d4c5a356adc521e534b', 'winda bikkhuni', 'windapakpak@gmail.com', 0),
(18, 'isaa', 'c8d9f3daca7f87ad8dd020db9f4ccd22', 'isabelle', 'aprishop@gmail.com', 0),
(19, 'serty123', '67ff32d40fb51f1a2fd2c4f1b1019785', 'serty wildan', 'serty123@gmail.com', 0),
(20, 'atinnn23', '3c9b6b61884d341df2444c824821ed05', 'ATINNN', 'atinnn23@gmail.com', 0),
(21, 'Lucy', '8de13959395270bf9d6819f818ab1a00', 'Lucy Hiroshima', 'Lucian@yahoo.com', 0),
(22, 'mmllccdd', '0dffd4077089505743e6d68b39309c5b', 'mantapmania', 'maxmax@mail.com', 0),
(23, 'jokocihuyy78', 'eb6a487321f260aeb00916f5c996ba21', 'joko hendra vitryani', 'jokoanddodo@gmail.com', 0),
(24, 'eca imut', '4c36f5f25c3788e7f3f286d2af289593', 'neisya adellia', 'ecasimbolon@gmail.com', 0),
(25, 'headcone932', 'e1b2e526b8484ab49be9bd48ee4768a4', 'wilson', 'aprishop@gmail.com', 0),
(26, 'seplin', '71c05e46512338afc873be1e0473c815', 'seplin peronika', 'seplinsinaga@gmail.com', 0),
(27, 'joko123123', 'fb1c5cad320de99bd876cbd095da77d9', 'jokko lim', 'joko12123@gmail.com', 0),
(28, 'tia', '827ccb0eea8a706c4c34a16891f84e7b', 'tia leya', 'tia@gmail.com', 0),
(29, 'jessi', '7f9c20d8fd63aa735be5ad091edd7090', 'jessian', 'jessi@gmail.com', 0),
(30, 'zia', 'e10adc3949ba59abbe56e057f20f883e', 'zia pithecanrhopus erectus', 'apri@gmail.com', 0),
(31, 'ciaa', '66dd49363ad9629ffb087914dceff25f', 'grace', 'jeongwoo07@gmail.com', 0),
(32, 'Chenra', '6531401f9a6807306651b87e44c05751', 'Zhong Chenra', 'chenra@gmail.com', 0),
(33, 'apasajadeh', '509a46482f6bc760ae2b1cab4a05f60f', 'Apriyanto Kayaknya', 'apri@mail.com', 0),
(34, 'SariMukri', '6de8b30b056d0fabacc837639d39ba4f', 'SariMukri123', 'SariMukri@gmail.com', 0),
(35, 'indra23', 'b3947ae16c9b9a08b8c874873cd8c615', 'in dra', 'panipahan43@gmail.com', 0),
(36, 'Zenco', 'e9677bf8fd2b7d0b70baf7f01ac09aeb', 'Zenco Calvandra', 'zenco@gmail.com', 0),
(37, 'fandy', '5b9aec960677a112cf58abc31398a3b1', 'fandy ahmad simamora', 'fandymora@gmail.com', 0),
(38, 'maulana', '1b26b790e7b7f8c03e640b37a503bf3a', 'maulanaganteng', 'encotcreww89@gmail.com', 0),
(39, 'Saya Ripat', 'a337fb63cf5429664d341f7e5d5cb341', 'Ripat nih boss', 'EmailSaya@gmail.com', 0),
(40, 'Clay', '691919ae1a12cbd54fd2baeb31825732', 'Clayton', 'clay@aprishop.co.id', 0),
(41, 'KnowJust12', '00f9272605d291716813eee719222371', 'Siapa Namanya Dimana Rumahnya', 'RA_Chan.Haiiiii@gmail.com', 0),
(42, 'Alfajar Alvin', '7dbd3c5f3b2e7ba179612a9231aa81fb', 'Alfajar Alvin Permana Tambunan', 'neroozoldcyk@gmail.com', 0),
(43, 'apriyanto', 'e10adc3949ba59abbe56e057f20f883e', 'Apriyanto', 'apri@maillagi.com', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
