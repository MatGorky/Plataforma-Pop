-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 02-Dez-2019 às 17:35
-- Versão do servidor: 10.1.21-MariaDB
-- versão do PHP: 7.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `plataforma_pop`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliacao`
--

CREATE TABLE `avaliacao` (
  `idusuario` int(11) NOT NULL,
  `idservico` int(11) NOT NULL,
  `comentario` text NOT NULL,
  `estrelas` float NOT NULL,
  `preco` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `avaliacao`
--

INSERT INTO `avaliacao` (`idusuario`, `idservico`, `comentario`, `estrelas`, `preco`) VALUES
(1, 22, 'Excelente serviço. Ótimo profissional', 5, 4),
(3, 20, 'Nao gostei', 1, 3),
(3, 21, 'Realmente bacana', 5, 3),
(8, 20, 'Maravilhoso', 5, 5),
(8, 22, 'Péssimo serviço. Contratei e chegou atrasado todas as vezes. ', 1, 2),
(15, 20, 'Nem bom nem ruim. Muito pelo contrário.', 3, 3),
(16, 20, 'Péssimo trabalho. Não recomendo > : (', 1, 1),
(17, 22, 'Péssimo trabalho', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `bairro`
--

CREATE TABLE `bairro` (
  `identificador` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `bairro`
--

INSERT INTO `bairro` (`identificador`, `nome`) VALUES
(10, 'Centro'),
(11, 'Zona Sul'),
(12, 'Barra da Tijuca'),
(13, 'Grande Bangu'),
(14, 'Zona Oeste'),
(15, 'Grande Tijuca'),
(16, 'Grande Méier'),
(17, 'Ilha do Governador'),
(18, 'Zona Norte');

-- --------------------------------------------------------

--
-- Estrutura da tabela `bairro_usuario`
--

CREATE TABLE `bairro_usuario` (
  `idbairro` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `bairro_usuario`
--

INSERT INTO `bairro_usuario` (`idbairro`, `idusuario`) VALUES
(10, 1),
(10, 15),
(10, 17),
(11, 1),
(11, 15),
(11, 17),
(12, 1),
(12, 15),
(12, 17),
(13, 3),
(14, 15),
(15, 1),
(15, 15),
(16, 1),
(17, 3),
(18, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupo_servico`
--

CREATE TABLE `grupo_servico` (
  `identificador` int(11) NOT NULL,
  `nome_grupo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `grupo_servico`
--

INSERT INTO `grupo_servico` (`identificador`, `nome_grupo`) VALUES
(2, 'Serviço Doméstico'),
(3, 'Reformas'),
(4, 'Serviços Gerais'),
(5, 'Assistência'),
(6, 'Eventos'),
(7, 'Aulas'),
(8, 'Automóveis'),
(9, 'Tecnologias');

-- --------------------------------------------------------

--
-- Estrutura da tabela `servico`
--

CREATE TABLE `servico` (
  `identificador` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `tipo_servico` int(11) NOT NULL,
  `titulo` varchar(27) NOT NULL,
  `descricao_servico` text NOT NULL,
  `estrelas` int(11) NOT NULL DEFAULT '0',
  `preco` int(11) NOT NULL DEFAULT '0',
  `fotopath` varchar(30) NOT NULL DEFAULT '',
  `totavaliacoes` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `servico`
--

INSERT INTO `servico` (`identificador`, `idusuario`, `tipo_servico`, `titulo`, `descricao_servico`, `estrelas`, `preco`, `fotopath`, `totavaliacoes`) VALUES
(20, 1, 52, 'Desenvolvimento Web', 'Faço sites para qualquer área. Trabalho com o design, desenvolvimento e implementação.', 10, 12, 'servico_20.jpg', 4),
(21, 1, 53, 'Desenvolvimento de App', 'Desenvolverei um aplicativo do jeito que você quiser.', 5, 3, 'servico_21.jpg', 1),
(22, 3, 54, 'Desenvolvimento de Sites', 'Eu desenvolvo sites para qualquer pessoa ou empresa. Faço o trabalho completo.', 7, 7, 'servico_22.jpg', 3),
(23, 15, 59, 'Book de Fotos completo', 'Faço fotografia do book completo de fotos. Para casamento e outras festas.', 0, 0, 'servico_23.jpg', 0),
(26, 3, 43, 'Servico1', 'Uma longa descricao', 0, 0, 'servico_26.jpg', 0),
(27, 3, 2, 'Apenas um teste', 'Descrição', 0, 0, 'servico_27.jpg', 0),
(28, 3, 2, 'Apenas um teste', 'Descrição', 0, 0, 'servico_28.jpg', 0),
(29, 3, 2, 'Apenas um teste', 'Descrição', 0, 0, 'servico_29.jpg', 0),
(30, 3, 2, 'Apenas um teste', 'Descrição', 0, 0, 'servico_30.jpg', 0),
(31, 3, 2, 'Apenas um teste', 'Descrição', 0, 0, 'servico_31.jpg', 0),
(32, 3, 2, 'Apenas um teste', 'Descrição', 0, 0, 'servico_32.jpg', 0),
(35, 3, 2, 'Apenas um teste', 'Descrição', 0, 0, 'servico_35.jpg', 0),
(36, 17, 7, 'Caminhador de Cachorro', 'Caminho com seu cachorro por hora.', 0, 0, 'servico_36.jpg', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_servico`
--

CREATE TABLE `tipo_servico` (
  `identificador` int(11) NOT NULL,
  `nome_servico` varchar(20) NOT NULL,
  `grupo_servico` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tipo_servico`
--

INSERT INTO `tipo_servico` (`identificador`, `nome_servico`, `grupo_servico`) VALUES
(2, 'Cozinheira', 2),
(3, 'Diarista', 2),
(4, 'Passadeira', 2),
(5, 'Babá', 2),
(6, 'Motorista', 2),
(7, 'Dog Walker', 2),
(8, 'Arquiteto', 3),
(9, 'Engenheiro', 3),
(10, 'Pedreiro', 3),
(11, 'Eletricista', 3),
(12, 'Encanador', 3),
(13, 'Pintor', 3),
(14, 'Dedetizador', 3),
(15, 'Marceneiro', 3),
(16, 'Decorador', 3),
(17, 'Jardineiro', 3),
(18, 'Paisagista', 3),
(19, 'Fonoaudiólogo', 4),
(20, 'Nutricionista', 4),
(21, 'Psicólogo', 4),
(22, 'Cuidador de Idoso', 4),
(23, 'Enfermeira', 4),
(24, 'Eletrônicos', 5),
(25, 'Televisores', 5),
(26, 'Eletrodomésticos', 5),
(27, 'Informática Geral', 5),
(28, 'Cabeamento e Rede', 5),
(29, 'Garçons e Copeiras', 6),
(30, 'Recepcionista', 6),
(31, 'Segurança', 6),
(32, 'Equipamento', 6),
(33, 'Bartender', 6),
(34, 'Churrasqueiro', 6),
(35, 'Confeiteira', 6),
(36, 'Buffet Completo', 6),
(37, 'Animação Infantil', 6),
(38, 'DJs', 6),
(39, 'Brindes', 6),
(40, 'Fotografia', 6),
(41, 'Aulas Particulares', 7),
(42, 'Idiomas', 7),
(43, 'Concursos', 7),
(44, 'Música', 7),
(45, 'Dança', 7),
(46, 'Esportes', 7),
(47, 'Artes', 7),
(48, 'Funilaria e Pintura', 8),
(49, 'Auto Elétrica', 8),
(50, 'Vidraçaria', 8),
(51, 'Mecânica', 8),
(52, 'Desenvolvimento Web', 9),
(53, 'Desenvolvimento App', 9),
(54, 'Web Design', 9),
(55, 'Marketing Digital', 9),
(56, 'Mateirais Gráficos', 9),
(57, 'Design Gráfico', 9),
(58, 'Edição de Vídeo', 9),
(59, 'Fotografia', 9),
(60, 'Animações', 9),
(61, 'Modelagem 3D', 9);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `identificador` int(11) NOT NULL,
  `cpf` bigint(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `senha` varchar(60) NOT NULL,
  `email` varchar(320) NOT NULL,
  `celular` bigint(11) NOT NULL,
  `estrelas` int(11) NOT NULL DEFAULT '0',
  `fotopath` varchar(30) DEFAULT NULL,
  `descricao` varchar(58) DEFAULT '',
  `descricao_completa` text,
  `totavaliacoes` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`identificador`, `cpf`, `nome`, `senha`, `email`, `celular`, `estrelas`, `fotopath`, `descricao`, `descricao_completa`, `totavaliacoes`) VALUES
(1, 18211691744, 'Vinicius Proença', '$2y$10$49.4IbQeZ0VUKDN06lrH8.i40T4hR.PW1/lc8Fy2JDAjnnaYvkaDS', 'viniciuslettieri@me.com', 21987470283, 15, 'perfil_1.jpg', 'Trabalho desde cedo na carpintaria junto com meu pai.', 'Trabalho desde cedo na carpintaria de meu pai, ajudando ele em seus trabalhos. Aprendi muitas técnicas com ele mas também fiz muitos cursos para aprimorar meu trabalho. \r\nJá trabalhei tanto em empresas quanto por conta própria, fazendo móveis de alta qualidade para casas e escritórios.', 4),
(3, 12312312312, 'Perceu Afonso', '$2y$10$49.4IbQeZ0VUKDN06lrH8.i40T4hR.PW1/lc8Fy2JDAjnnaYvkaDS', 'perceuafonso@email.com', 21999999999, 7, 'perfil_3.jpg', '', '', 3),
(8, 12312312311, 'Matheus Moura', '$2y$10$49.4IbQeZ0VUKDN06lrH8.i40T4hR.PW1/lc8Fy2JDAjnnaYvkaDS', 'matheusmoura@email.com', 21999999999, 0, 'perfil_8.jpg', '', '', 0),
(9, 11111111111, 'Pedro Poppolino', '$2y$10$z1gVHS/y/Fe4DSRPG/ii.OEP5ce24QxUjPACTdg9qSTz9sIGFjGLW', 'pedropoppolino@email.com', 21999999999, 0, 'perfil_9.jpg', '', NULL, 0),
(13, 22222222222, 'Matheus da Silva', '$2y$10$AcwLkDe6qT5W8i9S.JD0iOybSB/8fI01AqsI/W4Cyi3rLImz4qzO.', 'matheusdasilva@email.com', 211231231231, 0, 'perfil_13.png', '', '', 0),
(15, 33333333333, 'Claudio Rodrigues', '$2y$10$QtMaWaHKwaAObiyHeEtqjO.6zRtHrDuUDAqNsczJCTx92JoQFe7z6', 'claudiorodrigues@email.com', 2112312312312312312, 0, 'perfil_15.jpg', 'Não sabia muito o que dizer ', 'Aqui digo mais alguma coisa pra completar meu perfil maravilhoso.', 0),
(16, 44444444444, 'Marcelo Castro', '$2y$10$t4u/dPDeLycc2Js/I3zU6.205nORVGV4xWUkOCn8oxdaAM0vKilfW', 'marcelocastro@email.com', 21987470283, 0, 'perfil_16.png', 'Aqui fica uma breve descrição', 'Aqui está uma longa descrição', 0),
(17, 12345678900, 'Victor Carvalho', '$2y$10$DH61QkBcV/TrfWWkU30HvOGEq3NOpa8oaN.TAAg0VhQ6J1KIFvl0y', 'victorcarvalho@email.com', 21222222222, 0, 'perfil_17.png', '', '', 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `avaliacao`
--
ALTER TABLE `avaliacao`
  ADD PRIMARY KEY (`idusuario`,`idservico`),
  ADD KEY `idservico` (`idservico`);

--
-- Índices para tabela `bairro`
--
ALTER TABLE `bairro`
  ADD PRIMARY KEY (`identificador`);

--
-- Índices para tabela `bairro_usuario`
--
ALTER TABLE `bairro_usuario`
  ADD PRIMARY KEY (`idbairro`,`idusuario`),
  ADD KEY `idusuario` (`idusuario`);

--
-- Índices para tabela `grupo_servico`
--
ALTER TABLE `grupo_servico`
  ADD PRIMARY KEY (`identificador`);

--
-- Índices para tabela `servico`
--
ALTER TABLE `servico`
  ADD PRIMARY KEY (`identificador`),
  ADD KEY `idusuario` (`idusuario`),
  ADD KEY `servico_ibfk_2` (`tipo_servico`);

--
-- Índices para tabela `tipo_servico`
--
ALTER TABLE `tipo_servico`
  ADD PRIMARY KEY (`identificador`),
  ADD KEY `grupo_servico` (`grupo_servico`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`identificador`),
  ADD UNIQUE KEY `cpf` (`cpf`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `bairro`
--
ALTER TABLE `bairro`
  MODIFY `identificador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `grupo_servico`
--
ALTER TABLE `grupo_servico`
  MODIFY `identificador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `servico`
--
ALTER TABLE `servico`
  MODIFY `identificador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de tabela `tipo_servico`
--
ALTER TABLE `tipo_servico`
  MODIFY `identificador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `identificador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `avaliacao`
--
ALTER TABLE `avaliacao`
  ADD CONSTRAINT `avaliacao_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`identificador`) ON DELETE CASCADE,
  ADD CONSTRAINT `avaliacao_ibfk_2` FOREIGN KEY (`idservico`) REFERENCES `servico` (`identificador`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `bairro_usuario`
--
ALTER TABLE `bairro_usuario`
  ADD CONSTRAINT `bairro_usuario_ibfk_1` FOREIGN KEY (`idbairro`) REFERENCES `bairro` (`identificador`) ON DELETE CASCADE,
  ADD CONSTRAINT `bairro_usuario_ibfk_2` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`identificador`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `servico`
--
ALTER TABLE `servico`
  ADD CONSTRAINT `servico_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`identificador`) ON DELETE CASCADE,
  ADD CONSTRAINT `servico_ibfk_2` FOREIGN KEY (`tipo_servico`) REFERENCES `tipo_servico` (`identificador`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `tipo_servico`
--
ALTER TABLE `tipo_servico`
  ADD CONSTRAINT `tipo_servico_ibfk_1` FOREIGN KEY (`grupo_servico`) REFERENCES `grupo_servico` (`identificador`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
