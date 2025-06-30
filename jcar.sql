-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 01/07/2025 às 00:26
-- Versão do servidor: 8.0.40
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `jcar`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `carros`
--

CREATE TABLE `carros` (
  `idCarro` int NOT NULL,
  `fotoCarro` varchar(255) NOT NULL,
  `nomeCarro` varchar(50) NOT NULL,
  `descricaoCarro` text NOT NULL,
  `marcaCarro` varchar(30) NOT NULL,
  `modeloCarro` varchar(30) NOT NULL,
  `anoCarro` int NOT NULL,
  `corCarro` varchar(7) NOT NULL,
  `placaCarro` varchar(8) NOT NULL,
  `valorCarro` decimal(10,2) NOT NULL,
  `dataCadastro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `disponivel` varchar(10) NOT NULL DEFAULT 'Disponível'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `carros`
--

INSERT INTO `carros` (`idCarro`, `fotoCarro`, `nomeCarro`, `descricaoCarro`, `marcaCarro`, `modeloCarro`, `anoCarro`, `corCarro`, `placaCarro`, `valorCarro`, `dataCadastro`, `disponivel`) VALUES
(3, 'img/Fusca_Azul.jpeg', 'Fusca', 'VW Fusca Azul 1972', 'Volkswagen', 'Fusca', 1972, '#0000FF', 'GHI-9012', 20000.00, '2025-06-09 22:40:35', 'Esgotado'),
(14, 'img/carro_6850b360eb5ba.jpg', 'Honda City', 'Honda City Flex', 'Honda', 'Confort', 2025, '#000000', 'ABC-1235', 50000.00, '2025-06-17 00:14:24', 'disponivel'),
(15, 'img/carro_6850b39c54ad7.jpg', 'Fiat Mobi', 'Slim', 'Fiat', 'Mobi', 2020, '#ff0000', 'ABC-1111', 30000.00, '2025-06-17 00:15:24', 'Esgotado'),
(16, 'img/carro_6850b3c3344bf.jpg', 'Ferrari', 'Ferrari VW', 'Ferrari', 'Sports', 2015, '#ff0000', 'ABC-1515', 500000.00, '2025-06-17 00:16:03', 'disponivel'),
(17, 'img/carro_6850b3f6f35a4.jpg', 'Mustang', 'Mustang WV', 'FORD', 'Sport', 2025, '#ffc800', 'ABC-1555', 400000.00, '2025-06-17 00:16:55', 'disponivel'),
(18, 'img/carro_6850b424ae1a2.jpg', 'Ferrari', 'Ferrari Sport', 'Ferrari', 'Sport', 2018, '#ff6b00', 'ABC-9999', 500000.00, '2025-06-17 00:17:40', 'disponivel'),
(19, 'img/carro_6850b4b3ded29.jpg', 'Honda Civic', 'Honda Civic', 'Honda', 'Civic', 2023, '#fafafa', 'ABC-7777', 75000.00, '2025-06-17 00:20:03', 'disponivel'),
(20, 'img/carro_6850b5152bc4f.jpg', 'Mustang', 'Mustang', 'Mercedes', 'Mustang Slim', 2019, '#0f0f0f', 'ABC-6622', 100000.00, '2025-06-17 00:21:41', 'disponivel');

-- --------------------------------------------------------

--
-- Estrutura para tabela `compras`
--

CREATE TABLE `compras` (
  `idCompra` int NOT NULL,
  `idUsuario` int DEFAULT NULL,
  `idCarro` int DEFAULT NULL,
  `dataCompra` date DEFAULT NULL,
  `horaCompra` time DEFAULT NULL,
  `valorCompra` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `compras`
--

INSERT INTO `compras` (`idCompra`, `idUsuario`, `idCarro`, `dataCompra`, `horaCompra`, `valorCompra`) VALUES
(3, 3, 15, '2025-06-16', '21:41:57', 30000.00),
(4, 3, 14, '2025-06-23', '19:06:23', 50000.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int NOT NULL,
  `tipoUsuario` varchar(15) NOT NULL,
  `fotoUsuario` varchar(100) NOT NULL,
  `nomeUsuario` varchar(50) NOT NULL,
  `dataNascimentoUsuario` date NOT NULL,
  `cidadeUsuario` varchar(30) NOT NULL,
  `telefoneUsuario` varchar(20) NOT NULL,
  `emailUsuario` varchar(50) NOT NULL,
  `senhaUsuario` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `tipoUsuario`, `fotoUsuario`, `nomeUsuario`, `dataNascimentoUsuario`, `cidadeUsuario`, `telefoneUsuario`, `emailUsuario`, `senhaUsuario`) VALUES
(1, 'administrador', 'img/images.jpg', 'Joao', '2000-03-26', 'telemacoBorba', '(99) 99999-9999', 'joao@gmail.com', '202cb962ac59075b964b07152d234b70'),
(3, 'cliente', 'img/fiat-mobi-2023.jpg', 'John', '2001-03-26', 'Telemaco Borba', '(99) 99999-9999', 'john@gmail.com', '202cb962ac59075b964b07152d234b70');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `carros`
--
ALTER TABLE `carros`
  ADD PRIMARY KEY (`idCarro`),
  ADD UNIQUE KEY `placaCarro` (`placaCarro`);

--
-- Índices de tabela `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`idCompra`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `carros`
--
ALTER TABLE `carros`
  MODIFY `idCarro` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `compras`
--
ALTER TABLE `compras`
  MODIFY `idCompra` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
