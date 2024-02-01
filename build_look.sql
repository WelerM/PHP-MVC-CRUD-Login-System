-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 18-Jan-2024 às 20:56
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `build_look`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `feet`
--

CREATE TABLE `feet` (
  `id` int(11) NOT NULL,
  `feet` text DEFAULT NULL,
  `img_name` text DEFAULT NULL,
  `min_temp` int(2) DEFAULT NULL,
  `max_temp` int(2) DEFAULT NULL,
  `season_1` text DEFAULT NULL,
  `season_2` text DEFAULT NULL,
  `being_used` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `legs`
--

CREATE TABLE `legs` (
  `id` int(11) NOT NULL,
  `legs` text DEFAULT NULL,
  `img_name` text DEFAULT NULL,
  `min_temp` int(2) DEFAULT NULL,
  `max_temp` int(2) DEFAULT NULL,
  `season_1` text DEFAULT NULL,
  `season_2` text DEFAULT NULL,
  `being_used` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `top`
--

CREATE TABLE `top` (
  `id` int(11) NOT NULL,
  `top` text NOT NULL,
  `img_name` text DEFAULT NULL,
  `min_temp` int(2) DEFAULT NULL,
  `max_temp` int(2) DEFAULT NULL,
  `season_1` text DEFAULT NULL,
  `season_2` text DEFAULT NULL,
  `being_used` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `torso`
--

CREATE TABLE `torso` (
  `id` int(11) NOT NULL,
  `torso` text DEFAULT NULL,
  `img_name` text DEFAULT NULL,
  `min_temp` int(2) DEFAULT NULL,
  `max_temp` int(2) DEFAULT NULL,
  `season_1` text DEFAULT NULL,
  `season_2` text DEFAULT NULL,
  `being_used` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `feet`
--
ALTER TABLE `feet`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `legs`
--
ALTER TABLE `legs`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `top`
--
ALTER TABLE `top`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `torso`
--
ALTER TABLE `torso`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `feet`
--
ALTER TABLE `feet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `legs`
--
ALTER TABLE `legs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `top`
--
ALTER TABLE `top`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de tabela `torso`
--
ALTER TABLE `torso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
