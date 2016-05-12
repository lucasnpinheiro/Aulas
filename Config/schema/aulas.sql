-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 12-Maio-2016 às 00:08
-- Versão do servidor: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aulas`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `fone` varchar(15) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `senha` varchar(32) DEFAULT NULL,
  `data_cadastro` datetime DEFAULT NULL,
  `data_alteracao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `clientes`
--

INSERT INTO `clientes` (`id`, `nome`, `cpf`, `fone`, `email`, `senha`, `data_cadastro`, `data_alteracao`) VALUES
(1, 'Fernando Calefi1', '30943923859', '36383551', 'fercalefi@hotmail.com', '819982db60c372c662d774cfc58752ec', '2016-01-27 22:13:28', '2016-04-14 02:24:49'),
(2, 'Cristina Aparecida Campos Calefi', '25344746857', '988394820', 'criscamposcalefi@gmail.com', 'fernando', '2016-02-21 19:47:44', NULL),
(3, 'Sophia Calefi', '45497750842', '32891988', 'sophiacalefi@gmail.com', 'sophiacalefi', '2016-02-21 19:49:24', NULL),
(5, 'Theodoro Manoel Calefi', '11111111111', '32891988', 'theodorocalefi@gmail.com', 'teodoro', '2016-02-21 19:51:40', '2016-02-28 14:44:23'),
(6, 'Mogan Zumerle', '99999999999', '15151515', 'mogan@consinco.com.br', 'e10adc3949ba59abbe56e057f20f883e', '2016-03-09 17:34:50', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `formas_pagto`
--

CREATE TABLE `formas_pagto` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `data_cadastro` datetime DEFAULT NULL,
  `data_alteracao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `formas_pagto`
--

INSERT INTO `formas_pagto` (`id`, `nome`, `data_cadastro`, `data_alteracao`) VALUES
(1, 'Dinheiro', '2016-02-21 20:06:07', NULL),
(2, 'Cheque à Vista', '2016-02-21 20:06:21', NULL),
(3, 'Cheque a Prazo', '2016-02-21 20:06:32', NULL),
(4, 'Boleto', '2016-02-21 20:06:39', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `data_pedido` date DEFAULT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `total` float(10,2) DEFAULT NULL,
  `forma_pagto_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `data_cadastro` datetime DEFAULT NULL,
  `data_alteracao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pedidos`
--

INSERT INTO `pedidos` (`id`, `data_pedido`, `cliente_id`, `total`, `forma_pagto_id`, `status`, `data_cadastro`, `data_alteracao`) VALUES
(1, '2016-03-02', 1, 10.00, 1, 0, '2016-03-02 00:00:00', '2016-03-08 01:57:20'),
(2, '2016-03-07', 2, 20.00, 2, 1, '2016-03-02 10:01:01', '2016-03-02 10:01:01'),
(3, '2016-03-02', 3, 55.00, 3, 1, '2016-03-02 10:01:01', '2016-03-02 10:01:01'),
(4, '2016-03-24', 1, 29.00, 1, 0, '2016-03-24 02:03:28', NULL),
(5, '2016-04-07', 1, 36.00, 1, 0, '2016-04-07 00:40:20', NULL),
(6, '2016-04-07', 1, 26.50, 1, 0, '2016-04-07 00:41:38', NULL),
(7, '2016-04-07', 1, 10.00, 2, 0, '2016-04-07 00:43:34', NULL),
(8, '2016-04-14', 1, 15.00, 1, 0, '2016-04-14 02:51:51', '2016-05-11 01:44:34');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedidos_itens`
--

CREATE TABLE `pedidos_itens` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) DEFAULT NULL,
  `produto_id` int(11) DEFAULT NULL,
  `qtde` float(10,2) DEFAULT NULL,
  `venda` float(10,2) DEFAULT NULL,
  `total` float(10,2) DEFAULT NULL,
  `data_cadastro` datetime DEFAULT NULL,
  `data_alteracao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pedidos_itens`
--

INSERT INTO `pedidos_itens` (`id`, `pedido_id`, `produto_id`, `qtde`, `venda`, `total`, `data_cadastro`, `data_alteracao`) VALUES
(1, 1, 1, 1.00, 1.00, 2.00, '2016-03-02 00:00:00', '2016-03-02 00:00:00'),
(2, 1, 2, 2.00, 2.00, 4.00, '2016-03-03 00:00:00', '2016-03-03 00:00:00'),
(3, 2, 3, 10.00, 10.00, 100.00, '2016-03-02 10:01:01', '2016-03-02 10:01:01'),
(4, 2, 1, 5.00, 5.00, 25.00, '2016-03-02 10:01:01', '2016-03-02 10:01:01'),
(5, 3, 2, 50.00, 10.00, 500.00, '2016-03-02 10:01:01', '2016-03-02 10:01:01'),
(6, 4, 2, 2.00, 5.50, 11.00, '2016-03-24 02:03:28', NULL),
(7, 4, 4, 2.00, 5.00, 10.00, '2016-03-24 02:03:28', NULL),
(8, 4, 5, 2.00, 1.00, 2.00, '2016-03-24 02:03:28', NULL),
(9, 4, 6, 1.00, 6.00, 6.00, '2016-03-24 02:03:28', NULL),
(10, 5, 1, 2.00, 10.00, 20.00, '2016-04-07 00:40:20', NULL),
(11, 5, 2, 2.00, 5.50, 11.00, '2016-04-07 00:40:20', NULL),
(12, 5, 4, 1.00, 5.00, 5.00, '2016-04-07 00:40:20', NULL),
(13, 6, 1, 1.00, 10.00, 10.00, '2016-04-07 00:41:38', NULL),
(14, 6, 2, 1.00, 5.50, 5.50, '2016-04-07 00:41:38', NULL),
(15, 6, 4, 1.00, 5.00, 5.00, '2016-04-07 00:41:38', NULL),
(16, 6, 6, 1.00, 6.00, 6.00, '2016-04-07 00:41:38', NULL),
(17, 7, 1, 1.00, 10.00, 10.00, '2016-04-07 00:43:34', NULL),
(18, 8, 1, 1.00, 10.00, 10.00, '2016-04-14 02:51:51', NULL),
(19, 8, 4, 1.00, 5.00, 5.00, '2016-04-14 02:51:51', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `codigo` varchar(13) NOT NULL,
  `nome` varchar(265) NOT NULL,
  `venda` float(10,2) DEFAULT NULL,
  `estoque` float(10,2) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `descricao_produto` text,
  `data_cadastro` datetime DEFAULT NULL,
  `data_alteracao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id`, `codigo`, `nome`, `venda`, `estoque`, `foto`, `descricao_produto`, `data_cadastro`, `data_alteracao`) VALUES
(1, '1', 'ARROZ', 10.00, 10.00, '571f2b6dbaeeb1d337ccce827fa24b0f.jpg', 'TESTES TESTES', NULL, '2016-04-07 02:36:59'),
(2, '2', 'FEIJAO', 5.50, 5.00, 'ee3e03b56f79d682e61448a2dc5075f2.jpg', 'TESTES FEIJAO', NULL, '2016-04-07 02:37:19'),
(3, '3', 'OLEO', 9.00, 99.00, '32d62a1b550429215c62b33ebbb3b5c0.jpg', 'TESTES OLEO', NULL, '2016-04-07 02:38:01'),
(4, '7894900011517', 'Coca Cola', 5.00, 1000.00, '394dd065c7a64574fe67ef2be1363ea2.jpg', 'Testes', '2016-02-21 20:18:02', '2016-04-07 02:37:08'),
(5, '7896800011517', 'LEITE NILZA', 1.00, 2585.00, '5e37e98090ee15a12560278afdc5d8be.jpg', 'Leite pasteurizado', '2016-02-21 20:22:42', '2016-04-07 02:37:50'),
(6, '7891000100103', 'LEITE COND. MOCA 350 ML', 6.00, 500.00, 'ac64b5d7292252ea4ac52e6a22d62234.jpg', 'TESTES LEITE MOCA', '2016-02-21 20:24:08', '2016-04-07 02:37:39'),
(7, '7894949494949', 'PERFUME', 50.00, 2.00, '89820aec60f6f23cfd7ef6bc517ff0b6.jpg', 'TESTES TESTES TESTES', '2016-02-24 23:37:10', '2016-04-07 02:38:31'),
(8, '789789', 'DESODORANTE', 15.00, 500.00, '09070f975694d1cdc539f1a60e798362.jpg', 'DESODORANTE REXONA', '2016-04-07 01:59:06', '2016-04-07 02:33:37'),
(9, '222', 'DESODORANTE 2', 10.00, 10.00, '495c429303ef0c649005d1f50b1ab8e3.jpg', 'testes', '2016-04-07 02:01:38', '2016-04-07 02:33:05');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `username` varchar(40) DEFAULT NULL,
  `senha` varchar(32) DEFAULT NULL,
  `data_cadastro` datetime DEFAULT NULL,
  `data_alteracao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `username`, `senha`, `data_cadastro`, `data_alteracao`) VALUES
(1, 'FERNANDO', 'fernandocalefi', 'f261b5d8b440a8a4f92bf553c4ea1c1e', '2016-02-03 20:08:25', '2016-03-10 00:23:22'),
(2, 'SOPHIA', 'scalefi', 'sophia', '2016-02-03 20:08:25', NULL),
(3, 'TESTE', 'steste', 'teste', '2016-02-03 20:08:25', NULL),
(4, 'CRISTINA', 'scristina', 'teste', '2016-02-03 20:08:25', NULL),
(5, 'CRISTINA2', 'tia', 'e10adc3949ba59abbe56e057f20f883e', '2016-02-03 20:08:25', '2016-02-17 23:32:48'),
(8, 'CALEFI22214', 'fercalefi2', 'testestestes', NULL, '2016-02-17 22:27:22'),
(11, 'Calefi5555', 'fercalefi2', 'testestestes', NULL, NULL),
(12, 'CALEFI222223', 'fercalefi2', 'testestestes', '2016-02-17 22:25:42', NULL),
(13, 'Fernando Calefi 2', 'testes', '6e7906b7fb3f8e1c6366c0910050e595', '2016-02-17 23:57:57', NULL),
(14, 'ddddddddddd', 'dddddddddddddd', '706db108edd9c5bcaca5e8b17a3cad25', '2016-02-18 00:13:51', NULL),
(15, 'FERNANDOggggggg', 'fercalefi56666', 'ef879f38cb4c886c4693cc91fc7c86d5', '2016-02-18 00:29:07', NULL),
(16, 'fdfgfdg', 'dgdfgdfgfhfhfghgf', '3d4044d65abdda407a92991f1300ec97', '2016-02-18 00:30:50', NULL),
(17, 'Cristina', 'crisapcampos', 'e10adc3949ba59abbe56e057f20f883e', '2016-02-28 14:43:30', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `vendedores`
--

CREATE TABLE `vendedores` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `data_cadastro` datetime DEFAULT NULL,
  `data_alteracao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `formas_pagto`
--
ALTER TABLE `formas_pagto`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pedidos_itens`
--
ALTER TABLE `pedidos_itens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendedores`
--
ALTER TABLE `vendedores`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `formas_pagto`
--
ALTER TABLE `formas_pagto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `pedidos_itens`
--
ALTER TABLE `pedidos_itens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `vendedores`
--
ALTER TABLE `vendedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
