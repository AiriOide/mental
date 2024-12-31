-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 31, 2024 at 07:20 AM
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
-- Database: `mental`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(12) NOT NULL,
  `name` varchar(64) NOT NULL,
  `birthday` date NOT NULL,
  `gender` text NOT NULL,
  `job` varchar(64) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `birthday`, `gender`, `job`, `email`, `password`) VALUES
(1, '山崎大助', '2002-01-01', '女性', '学生', 'user_1@example.com', ''),
(2, '', '0000-00-00', 'female', '', 'user_2@example.com', ''),
(3, 'Airi', '2024-12-02', 'female', '学生', 'user_3@example.com', ''),
(7, 'Airi', '2024-12-30', 'female', '学生', 'abc@cat.com', 'az'),
(19, 'Airi', '2024-12-30', 'female', '学生', 'a@cat.com', 'az'),
(21, 'Airi', '2024-12-30', 'female', '学生', 'q@cat.com', 'az'),
(22, 'AIRI OIDE', '2024-12-30', 'female', '学生', '123@gmail.com', 'abc'),
(23, 'ぽん', '2024-12-30', 'female', '学生', '1@cat.com', 'abc'),
(24, 'Airi', '2024-12-31', 'female', '学生', '21021237@gakushuin.ac.jp', 'abc');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
