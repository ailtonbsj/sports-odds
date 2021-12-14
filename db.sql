Č
-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 04/02/2017 às 20:30:28
-- Versão do Servidor: 10.1.20-MariaDB
-- Versão do PHP: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `u234125999_db`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `bills`
--

CREATE TABLE IF NOT EXISTS `bills` (
  `user` varchar(16) NOT NULL,
  `matchjson` varchar(10000) NOT NULL,
  `valor` float NOT NULL,
  `apostador` varchar(16) NOT NULL,
  `hash` varchar(40) NOT NULL,
  `estado` int(1) NOT NULL,
  `data_criado` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `premio` float NOT NULL,
  PRIMARY KEY (`hash`),
  KEY `fk_usr` (`user`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `bills`
--

INSERT INTO `bills` (`user`, `matchjson`, `valor`, `apostador`, `hash`, `estado`, `data_criado`, `premio`) VALUES
('rogerio', '[[104873,"Bnei Sakhnin X Hapoel Ironi Kiryat Shmona","16/01/2017 14:30:00","Fora",2.7,"4755733"],[104874,"Hapoel Tel Aviv X Maccabi Tel Aviv","16/01/2017 17:00:00","Fora",1.2,"4755740"],[104880,"Hapoel Nazareth Illit X Hapoel Nir Ramat HaSharon","16/01/2017 15:00:00","Casa",2.2,"4840754"],[104881,"Hapoel Ramat Gan X Maccabi Netanya","16/01/2017 15:00:00","Casa",3.8,"4840817"],[106066,"Maccabi Shaaraim X Maccabi Ahi Nazareth","16/01/2017 15:00:00","Fora",2.4,"4840884"]]', 3, 'Igor', '7bcbd507550de85543da7526525e44bae48804ec', 2, '2017-01-16 08:52:51', 195.022);

-- --------------------------------------------------------

--
-- Estrutura da tabela `matchs`
--

CREATE TABLE IF NOT EXISTS `matchs` (
  `id_mat` int(11) NOT NULL,
  `house1` int(11) DEFAULT NULL,
  `visit1` int(11) DEFAULT NULL,
  `house2` int(11) DEFAULT NULL,
  `visit2` int(11) DEFAULT NULL,
  `name` varchar(45) NOT NULL,
  `data` date NOT NULL,
  PRIMARY KEY (`id_mat`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `matchs`
--

INSERT INTO `matchs` (`id_mat`, `house1`, `visit1`, `house2`, `visit2`, `name`, `data`) VALUES
(105788, 1, 0, 1, 1, 'Salgueiro X Flamengo Arcoverde', '2017-01-15');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usrs`
--

CREATE TABLE IF NOT EXISTS `usrs` (
  `user` varchar(16) NOT NULL,
  `pass` varchar(16) NOT NULL,
  `name` varchar(45) NOT NULL,
  `cpf` bigint(11) NOT NULL,
  `tipo` varchar(4) NOT NULL DEFAULT 'bank',
  `saldo` int(11) NOT NULL,
  PRIMARY KEY (`user`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usrs`
--

INSERT INTO `usrs` (`user`, `pass`, `name`, `cpf`, `tipo`, `saldo`) VALUES
('confirm1', 'jailton1', 'Confirmador', 321, 'conf', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
