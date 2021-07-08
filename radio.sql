-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 08-Jul-2021 às 18:24
-- Versão do servidor: 10.3.29-MariaDB-0+deb10u1
-- versão do PHP: 7.3.29-1~deb10u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `radio`
--
CREATE DATABASE IF NOT EXISTS `radio` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `radio`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `estacoes`
--

CREATE TABLE `estacoes` (
  `id` int(11) NOT NULL,
  `nome` varchar(20) NOT NULL,
  `url` varchar(100) NOT NULL,
  `logo` varchar(20) NOT NULL DEFAULT 'logo/'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `estacoes`
--

INSERT INTO `estacoes` (`id`, `nome`, `url`, `logo`) VALUES
(1, 'Austrian Rock Radio', 'https://live.antenne.at/arr', 'logo/aar.png'),
(2, 'Antena 1', 'https://antenaone.crossradio.com.br/stream/1;?type', 'logo/a1.png'),
(3, 'Jovem Pan - Sorocaba', 'https://cast2.hoost.com.br:20149/stream', 'logo/jovem-pan.png'),
(4, 'Kiss', 'https://cloud2.cdnseguro.com:20000/stream/1/', 'logo/kiss.png'),
(5, '89 Radio Rock', 'https://20833.live.streamtheworld.com/RADIO_89FM_SC', 'logo/89-a-rock.png'),
(6, 'Fox Rock', 'https://bcast.brapostreaming.com.br/radio/8010/radio.mp3?1615304751', 'logo/fox-rock.png');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `estacoes`
--
ALTER TABLE `estacoes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `estacoes`
--
ALTER TABLE `estacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
