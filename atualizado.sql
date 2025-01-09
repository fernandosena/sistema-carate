-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql:3306
-- Tempo de geração: 05/01/2025 às 19:12
-- Versão do servidor: 5.7.44
-- Versão do PHP: 8.2.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `u583192303_sistema`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `address`
--

CREATE TABLE `address` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `street` varchar(255) NOT NULL DEFAULT '',
  `number` varchar(255) NOT NULL DEFAULT '',
  `complement` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_categories`
--

CREATE TABLE `app_categories` (
  `id` int(11) UNSIGNED NOT NULL,
  `sub_of` int(11) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `type` varchar(15) NOT NULL DEFAULT '',
  `order_by` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_certificate`
--

CREATE TABLE `app_certificate` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `html` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_credit_cards`
--

CREATE TABLE `app_credit_cards` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `brand` varchar(20) NOT NULL DEFAULT '',
  `last_digits` varchar(11) NOT NULL DEFAULT '',
  `cvv` varchar(11) NOT NULL DEFAULT '',
  `hash` varchar(255) NOT NULL DEFAULT '',
  `status` varchar(255) DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_invoices`
--

CREATE TABLE `app_invoices` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `wallet_id` int(11) UNSIGNED NOT NULL,
  `category_id` int(11) UNSIGNED NOT NULL,
  `invoice_of` int(11) UNSIGNED DEFAULT NULL,
  `description` varchar(255) NOT NULL DEFAULT '',
  `type` varchar(15) NOT NULL DEFAULT '',
  `value` decimal(10,2) NOT NULL,
  `currency` varchar(5) NOT NULL DEFAULT 'BRL',
  `due_at` date NOT NULL,
  `repeat_when` varchar(10) NOT NULL DEFAULT '',
  `period` varchar(10) NOT NULL DEFAULT 'month',
  `enrollments` int(11) DEFAULT NULL,
  `enrollment_of` int(11) DEFAULT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'unpaid',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_orders`
--

CREATE TABLE `app_orders` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `card_id` int(11) UNSIGNED DEFAULT NULL,
  `subscription_id` int(11) UNSIGNED DEFAULT NULL,
  `transaction` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_payments`
--

CREATE TABLE `app_payments` (
  `id` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `instructor_id` int(11) DEFAULT NULL,
  `view` tinyint(1) NOT NULL DEFAULT '0',
  `status` enum('pending','activated') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_plans`
--

CREATE TABLE `app_plans` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `period` varchar(11) NOT NULL DEFAULT '',
  `period_str` varchar(11) NOT NULL DEFAULT '',
  `price` decimal(10,2) NOT NULL,
  `status` varchar(11) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_students`
--

CREATE TABLE `app_students` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `dojo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `datebirth` date NOT NULL,
  `mother_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activated',
  `zip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `neighborhood` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `complement` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `graduation` int(11) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `renewal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `renewal_data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_renewal_data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `next_graduation` date DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `app_students`
--

INSERT INTO `app_students` (`id`, `user_id`, `dojo`, `first_name`, `last_name`, `email`, `datebirth`, `mother_name`, `document`, `photo`, `status`, `zip`, `state`, `city`, `address`, `neighborhood`, `number`, `complement`, `phone`, `graduation`, `description`, `type`, `renewal`, `renewal_data`, `last_renewal_data`, `next_graduation`, `created_at`, `updated_at`) VALUES
(10, 18, 'Kominka dojo', 'Renzo ', 'Marinho Amaral', 'renzo@gmail.com', '2015-07-24', 'Renato do Amaral Pereira', '09061869781', NULL, 'activated', '29060670', 'ES', 'Vitória', 'Avenida Anísio Fernandes Coelho', 'Jardim da Penha', '325', '', '(27) 9 9850-3743', 3, '', 'kyus', NULL, '2024-11-26 21:17:17', '2024-11-26 21:17:17', NULL, '2024-11-26 21:17:17', '2024-11-28 17:06:45'),
(11, 18, 'Kominka dojo', 'João Victor', 'Simões Gonçalves', 'joaovitor@gmail.com', '1999-10-11', NULL, '16601749702', NULL, 'activated', '29104461', 'ES', 'Vila Velha', 'Rua Copo de Leite', 'Jardim Asteca', '414', '', '(27) 9 9725-6424', 16, '', 'kyus', NULL, '2024-11-26 21:19:36', '2024-11-26 21:19:36', NULL, '2024-11-26 21:19:36', '2024-11-26 21:45:39'),
(12, 18, 'Kominka dojo', 'Nathan ', 'Fantecelle Strey', 'nathan@gmail.com', '1990-05-25', NULL, '13052577743', NULL, 'activated', '29065420', 'ES', 'Vitória', 'Rua Genserico Encarnação', 'Mata da Praia', '185', 'ap 101 G', '(27) 9 9619-4287', 31, 'Aluno vindo do Kenyu Ryu (1ºdan)', 'black', NULL, '2024-11-26 21:22:13', '2024-11-26 21:22:13', NULL, '2024-11-26 21:22:13', '2024-11-26 21:45:32'),
(13, 18, 'Kominka dojo', 'Mateus Daum ', 'Machado Jacinto', 'mateus@gmail.com', '2003-07-22', NULL, '14753428702', NULL, 'activated', '29060770', 'ES', 'Vitória', 'Avenida Saturnino Rangel Mauro', 'Jardim da Penha', '770', 'ap 202', '(27) 9 9777-8950', 16, '', 'kyus', NULL, '2024-11-26 21:25:02', '2024-11-26 21:25:02', NULL, '2024-11-26 21:25:02', '2024-11-26 21:45:34'),
(14, 18, 'Kominka dojo', 'Miguel ', 'Zumax Duque', 'miguel@gmail.com', '2011-04-30', 'Pollyanna Zumax Poton', '05578055702', NULL, 'activated', '29060751', 'ES', 'Vitória', 'Rua Hélio Soares', 'Jardim da Penha', '60', '', '(27) 9 9833-1963', 16, '', 'kyus', NULL, '2024-11-26 21:27:04', '2024-11-26 21:27:04', NULL, '2024-11-26 21:27:04', '2024-11-26 21:45:33'),
(15, 18, 'Kominka dojo', 'Heitor Vieira', ' Barcelos Amorim', 'heitor@gmail.com', '2012-06-29', 'Marilene Vieira Barcelos', '11550670700', NULL, 'activated', '29060770', 'ES', 'Vitória', 'Avenida Saturnino Rangel Mauro', 'Jardim da Penha', '1115', '', '(27) 9 9977-2054', 2, '', 'kyus', NULL, '2024-11-26 21:29:39', '2024-11-26 21:29:39', NULL, '2024-11-26 21:29:39', '2024-11-26 21:45:45'),
(16, 18, 'Kominka dojo', 'Dhali ', 'Goulart Cavati', 'dhali@gmail.com', '2010-11-03', 'Maria Goulard Gomes Martins', '11067722700', NULL, 'activated', '29065420', 'ES', 'Vitória', 'Rua Genserico Encarnação', 'Mata da Praia', '185', 'ap 102 G', '(28) 9 9977-7271', 2, '', 'kyus', NULL, '2024-11-26 21:32:09', '2024-11-26 21:32:09', NULL, '2024-11-26 21:32:09', '2024-11-28 16:59:50'),
(17, 18, 'Kominka dojo', 'Maria Alice ', 'F. Sudbrack', 'alice sudbrack@gmail.com', '2012-03-30', 'Everton Dietrich Sudback', '80325653704', NULL, 'activated', '29060180', 'ES', 'Vitória', 'Rua Maria Eleonora Pereira', 'Jardim da Penha', '153', 'ap 101', '(27) 9 9959-1063', 2, '', 'kyus', NULL, '2024-11-26 21:38:35', '2024-11-26 21:38:35', NULL, '2024-11-26 21:38:35', '2024-11-26 21:45:36'),
(18, 18, 'Kominka dojo', 'Maria Clara ', 'F. Sudbrack', 'mariasudbrack@gmail.com', '2012-03-30', 'Everton Dietrich Sudbrack', '80325653704', NULL, 'activated', '29060180', 'ES', 'Vitória', 'Rua Maria Eleonora Pereira', 'Jardim da Penha', '153', 'ap 101', '(27) 9 9959-1063', 2, '', 'kyus', NULL, '2024-11-26 21:41:14', '2024-11-26 21:41:14', NULL, '2024-11-26 21:41:14', '2024-11-26 21:45:35'),
(19, 18, 'Kominka dojo', 'Iuri ', 'Monteiro Quirino', 'iuriquirino@gmail.com', '2014-09-17', 'Daniel Quirino de Oliveira', '34505726601', NULL, 'activated', '29060700', 'ES', 'Vitória', 'Rua Carijós', 'Jardim da Penha', '169', '', '(28) 9 9931-1682', 2, '', 'kyus', NULL, '2024-11-26 21:58:43', '2024-11-26 21:58:43', NULL, '2024-11-26 21:58:43', '2024-11-26 22:28:45'),
(20, 18, 'Kominka dojo', 'Vicenzo ', ' Peixoto Fioretti', 'Vicenzo Fioretti', '2012-06-24', 'Fabricio da Fonseca Fioretti', '00845360710', NULL, 'activated', '29060280', 'ES', 'Vitória', 'Rua Doutor Dido Fontes', 'Jardim da Penha', '45', '', '(27) 9 9274-4004', 2, '', 'kyus', NULL, '2024-11-26 22:02:41', '2024-11-26 22:02:41', NULL, '2024-11-26 22:02:41', '2024-11-26 22:29:18'),
(21, 18, 'Kominka dojo', 'Filipa', 'Araújo Faiçal', 'Filipa Faiçal', '2014-09-12', 'Tufi Faiçal', '11842224794', NULL, 'activated', '29060445', 'ES', 'Vitória', 'Rua Doutor Moacyr Gonçalves', 'Jardim da Penha', '70', '', '(27) 9 8828-2008', 1, '', 'kyus', NULL, '2024-11-26 22:07:06', '2024-11-26 22:07:06', NULL, '2024-11-26 22:07:06', '2024-11-26 22:28:42'),
(22, 18, 'Kominka dojo', 'Nathan', 'Pires Guimarães Alvarenga', 'nathanalvarenga@gmail.com', '2018-10-22', 'Allan Barbosa Alvarenga', '04204118798', NULL, 'activated', '29060770', 'ES', 'Vitória', 'Avenida Saturnino Rangel Mauro', 'Jardim da Penha', '401', '', '(27) 9 9973-7944', 1, '', 'kyus', NULL, '2024-11-26 22:10:07', '2024-11-26 22:10:07', NULL, '2024-11-26 22:10:07', '2024-11-26 22:29:12'),
(23, 18, 'Kominka dojo', 'Maria Alice ', 'Freitas Monteiro', 'mariaalicebebeu@gmail.com', '2011-08-11', 'Jose Mario Tavares Monteiro', '06119839747', NULL, 'activated', '29062190', 'ES', 'Vitória', 'Rua Thereza Zanoni Caser', 'Pontal de Camburi', '168', '', '(27) 9 9921-6299', 22, '', 'kyus', NULL, '2024-11-26 22:12:55', '2024-11-26 22:12:55', NULL, '2024-11-26 22:12:55', '2024-11-26 22:28:52'),
(24, 18, 'Kominka dojo', 'Sammy', ' Oliveira de Sousa', 'sammysousa@gmail.com', '2005-02-01', NULL, '17394896757', NULL, 'activated', '29104351', 'ES', 'Vila Velha', 'Rua das Acerolas', 'Ilha dos Bentos', '1', '', '(27) 9 2001-8457', 15, '', 'kyus', NULL, '2024-11-26 22:16:31', '2024-11-26 22:16:31', NULL, '2024-11-26 22:16:31', '2024-11-26 22:29:16'),
(25, 18, 'Kominka dojo', 'Daniela ', ' Brito Cesconetto', 'danielacesconetto@gmail.com', '2001-05-22', NULL, '12373019710', NULL, 'activated', '29062190', 'ES', 'Vitória', 'Rua Thereza Zanoni Caser', 'Pontal de Camburi', '1', '', '(27) 9 9921-6299', 15, '', 'kyus', NULL, '2024-11-26 22:21:36', '2024-11-26 22:21:36', NULL, '2024-11-26 22:21:36', '2024-11-26 22:28:31'),
(26, 18, 'Kominka dojo', 'Ayla', 'A. Ferreira', 'danieleferreira@gmail.com', '2017-07-04', 'Daniel Quintão Ferreira', '05504246792', NULL, 'activated', '29090100', 'ES', 'Vitória', 'Rua Gelu Vervloet dos Santos', 'Jardim Camburi', '280', '', '(27) 9 8825-3182', 1, '', 'kyus', NULL, '2024-11-26 22:25:24', '2024-11-26 22:25:24', NULL, '2024-11-26 22:25:24', '2024-11-26 22:28:25'),
(27, 18, 'Kominka dojo', 'Felipe', 'Assis Costa', 'felipecosta@gmail.com', '1999-05-15', NULL, '16952386726', NULL, 'activated', '29075040', 'ES', 'Vitória', 'Rua Ouro Preto', 'Goiabeiras', '41', '', '(27) 9 9501-1974', 15, '', 'kyus', NULL, '2024-11-26 22:27:32', '2024-11-26 22:27:32', NULL, '2024-11-26 22:27:32', '2024-11-26 22:28:39'),
(28, 17, 'Karate Goju SC', 'Naiélly', 'Alves de Lima Barros', 'naiellyalves333@gmail.com', '2007-06-12', 'Ellen Alves', '00000000000', NULL, 'activated', '88130808', 'SC', 'Palhoça', 'Rua Maria do Carmo Lopes', 'Ponte do Imaruim', '234', '', '(48) 9 9021-964', 15, '', 'kyus', NULL, '2024-11-29 23:20:55', '2024-11-29 23:20:55', NULL, '2024-11-29 23:20:55', '2024-12-03 02:36:55'),
(29, 13, 'Gakko Shigoto', 'IEDA MARIA BRAGA', 'TAVARES', 'SERAVAT.IEDA@YAHOO.COM.BR', '1964-06-13', NULL, '51198908653', NULL, 'pending', '32073210', 'MG', 'Contagem', 'Rua Tarumirim', 'Industrial São Luiz', '368', 'CASA', '(31) 9 9590-9991', 31, 'Aluna ha 37 anos, desde de 1987. Sempre treinou Karate no estilo GOJU-RYU. ', 'black', NULL, '2024-12-03 21:51:17', '2024-12-03 21:51:17', '2025-12-03', '2024-12-03 21:51:17', '2024-12-04 00:20:37'),
(30, 13, 'Gakko Shigoto', 'NIVALDO RODRIGUES ', 'RESENDE', 'NIVRESENDE@GMAIL.COM', '1973-10-07', NULL, '86468553687', NULL, 'pending', '32514450', 'MG', 'Igarapé', 'ESTRADA DEZESETE ', 'Condomínio Gran Ville Igarapé', '2107', 'CASA', '(31) 9 9737-5320', 31, 'Aluno de Karate ha 36 anos, desde de 1988, sempre treinou estilo GOJU-RYU.', 'black', NULL, '2024-12-03 22:08:57', '2024-12-03 22:08:57', '2025-12-03', '2024-12-03 22:08:57', '2024-12-04 00:35:01'),
(31, 13, 'Gakko Shigoto', 'HUGO RANGEL BAETA', 'VIEIRA', 'HUGORANGEL@PBH.GOV.BR', '1983-01-17', NULL, '05561734652', NULL, 'activated', '32340630', 'MG', 'Contagem', 'Rua Upinduara', 'Novo Eldorado', '170', 'APTO 202', '(31) 9 8889-3864', 31, 'Aluno treinou GOJU RYU comigo da infancia até adolecencia, parou por um perildo. Retornado a treinar, no estilo KENYU em 2000, e foi ate Fx Amarela. Em 2002 retornou comigo por 10 meses. Em 2004 iniciou SHOTOKAN que em 2018 sofreu uma lesão de Ligamento e parou. Retornou este ano 01/07/2024 comigo, na FX vermelha graduado no SHOTOKAN. Hoje GOJU RYU ja na IOGKF. ', 'kyus', NULL, '2024-12-03 23:36:25', '2024-12-03 23:36:25', NULL, '2024-12-03 23:36:25', '2024-12-04 00:34:33'),
(32, 13, 'Gakko Shigoto', 'HEITOR SOUZA BAETA ', 'VIEIRA', 'HSBAETA@GMAIL.COM', '2015-05-26', 'HUGO RANGEL BAETA VIEIRA', '05561734652', NULL, 'activated', '32340630', 'MG', 'Contagem', 'Rua Upinduara', 'Novo Eldorado', '170', 'APTO 202', '(31) 9 8482-7389', 31, 'Alu no iniciou Karate GOJU RYU em 01/07/2024. Fez exame para Amarela em 07/11/2024, com avaliação do Heyder Sensei, no DOJO dele, em um dia de treino normal.', 'kyus', NULL, '2024-12-03 23:58:11', '2024-12-03 23:58:11', NULL, '2024-12-03 23:58:11', '2024-12-04 00:34:29'),
(33, 11, 'CKGT Dojo', 'Rafael', 'Resende', 'rejaneam10@gmail.com', '2014-07-08', 'Rejane A. Resende', '88289575653', NULL, 'activated', '30494225', 'MG', 'Belo Horizonte', 'Rua Paulo Piedade Campos', 'Estoril', '15', 'ap 704 T2', '(31) 9 8255-5777', 2, '', 'kyus', NULL, '2024-12-04 09:21:29', '2024-12-04 09:21:29', NULL, '2024-12-04 09:21:29', '2024-12-04 12:03:51'),
(34, 11, 'CKGT Dojo', 'Adilson', 'Oliveira', 'adilcesar@yahoo.com.br', '1971-02-06', NULL, '89219686600', NULL, 'activated', '30411545', 'MG', 'Belo Horizonte', 'Rua Fausto Alvim', 'Calafate', '7', 'ap 203', '(31) 9 8319-8052', 16, '', 'kyus', NULL, '2024-12-04 09:24:34', '2024-12-04 09:24:34', NULL, '2024-12-04 09:24:34', '2024-12-04 12:03:06'),
(35, 11, 'CKGT Dojo', 'Isabela', 'Possas', 'isa.possas@gmail.com', '1988-11-25', NULL, '10034747648', NULL, 'activated', '31270080', 'MG', 'Belo Horizonte', 'Rua Barra Grande', 'Indaiá', '435', 'ap 409', '(31) 9 9877-8320', 20, 'Aluna ingressou por transferência da Fight Studio BH', 'kyus', NULL, '2024-12-04 09:31:22', '2024-12-04 09:31:22', NULL, '2024-12-04 09:31:22', '2024-12-04 12:03:32'),
(36, 11, 'CKGT Dojo', 'Guilherme ', 'Oliveira', 'adilcesar@yahoo.com.br', '2012-10-05', 'Adilson de Oliveira', '89219686600', NULL, 'activated', '30411545', 'MG', 'Belo Horizonte', 'Rua Fausto Alvim', 'Calafate', '7', 'ap 203', '(31) 9 8319-8052', 2, 'Filho do Aluno Adilson Oliveira', 'kyus', NULL, '2024-12-04 09:33:58', '2024-12-04 09:33:58', NULL, '2024-12-04 09:33:58', '2024-12-04 12:03:14'),
(37, 11, 'CKGT Dojo', 'Patrícia', 'Ribeiro', 'albernaz.ribeiro@gmail.com', '1988-08-22', NULL, '09361096613', NULL, 'activated', '30180060', 'MG', 'Belo Horizonte', 'Rua Juiz de Fora', 'Barro Preto', '673', 'ap 410', '(31) 9 9847-1535', 16, '', 'kyus', NULL, '2024-12-04 09:38:01', '2024-12-04 09:38:01', NULL, '2024-12-04 09:38:01', '2024-12-04 12:03:53'),
(38, 11, 'CKGT Dojo', 'Matheus', 'Botelho', 'teko1987@gmail.com', '1987-10-06', NULL, '07899326605', NULL, 'activated', '30421191', 'MG', 'Belo Horizonte', 'Rua Junquilhos', 'Nova Suíssa', '600', 'ap 304', '(31) 9 9231-4931', 21, 'Aluno deverá fazer homologação para 2° Kyu em 2025.', 'kyus', NULL, '2024-12-04 09:41:30', '2024-12-04 09:41:30', NULL, '2024-12-04 09:41:30', '2024-12-04 12:03:54'),
(39, 11, 'CKGT Dojo', 'Emanoel', 'Chaves', 'emanoel.chavesav@gmail.com', '1989-03-09', NULL, '01627894675', NULL, 'activated', '30421280', 'MG', 'Belo Horizonte', 'Rua das Flores', 'Nova Suíssa', '365', 'ap 302', '(31) 9 8612-7091', 15, '', 'kyus', NULL, '2024-12-04 09:46:18', '2024-12-04 09:46:18', NULL, '2024-12-04 09:46:18', '2024-12-04 12:03:13'),
(40, 11, 'CKGT Dojo', 'Gustavo', 'Pereira', 'aritavo15@gmail.com', '2002-08-02', NULL, '16045233603', NULL, 'activated', '30411365', 'MG', 'Belo Horizonte', 'Rua Tiros', 'Calafate', '79', '', '(31) 9 8226-5342', 17, '', 'kyus', NULL, '2024-12-04 09:49:09', '2024-12-04 09:49:09', NULL, '2024-12-04 09:49:09', '2024-12-04 12:03:16'),
(41, 11, 'CKGT Dojo', 'Igor', 'Cabral', 'igoulartcabral@gmail.com', '1996-10-08', NULL, '12810801606', NULL, 'activated', '30411470', 'MG', 'Belo Horizonte', 'Rua Campos Sales', 'Calafate', '188', 'ap 204', '(31) 9 8272-5404', 16, '', 'kyus', NULL, '2024-12-04 09:51:57', '2024-12-04 09:51:57', NULL, '2024-12-04 09:51:57', '2024-12-04 12:03:17'),
(42, 11, 'CKGT Dojo', 'Luiz', 'Moura', 'frandemoura1970@gmail.com', '2011-06-26', 'Francisca de Moura', '03284406638', NULL, 'activated', '30411520', 'MG', 'Belo Horizonte', 'Beco das Oliveiras', 'Calafate', '31', '', '(31) 9 9946-1398', 15, '', 'kyus', NULL, '2024-12-04 10:01:29', '2024-12-04 10:01:29', NULL, '2024-12-04 10:01:29', '2024-12-04 12:03:20'),
(43, 11, 'CKGT Dojo', 'Wellington', 'Silva', 'wmds.com@hotmail.com', '1997-09-29', NULL, '02306438684', NULL, 'pending', '30380002', 'MG', 'Belo Horizonte', 'Avenida Prudente de Morais', 'Cidade Jardim', '230', '', '(34) 9 9648-9523', 31, '', 'black', NULL, '2024-12-04 10:04:56', '2024-12-04 10:04:56', '2025-12-04', '2024-12-04 10:04:56', '2024-12-04 12:04:32'),
(44, 11, 'CKGT Dojo', 'Isadora', 'Megale', 'jaquelinedpadua@hotmail.com', '2004-09-26', NULL, '98809830687', NULL, 'activated', '30431320', 'MG', 'Belo Horizonte', 'Rua Conselheiro Joaquim Caetano', 'Nova Granada', '17', 'ap 1201', '(31) 9 8005-654', 16, '', 'kyus', NULL, '2024-12-04 10:08:46', '2024-12-04 10:08:46', NULL, '2024-12-04 10:08:46', '2024-12-04 12:03:33'),
(45, 11, 'CKGT Dojo', 'Luiz', 'Tálamo', 'luiztalamo@yahoo.com.br', '1979-09-23', NULL, '01269630610', NULL, 'activated', '30411241', 'MG', 'Belo Horizonte', 'Rua Sagres', 'Prado', '157', 'ap 102', '(31) 9 9113-7390', 17, 'Aluno originário Academia Bushi no te, Shotokan. Passou por exame para homologar grau na iogkf', 'kyus', NULL, '2024-12-04 10:12:55', '2024-12-04 10:12:55', NULL, '2024-12-04 10:12:55', '2024-12-04 12:04:01'),
(46, 11, 'CKGT Dojo', 'Leonardo ', 'Silva', 'leohenriqueds@gmail.com', '1984-08-11', NULL, '01613163648', NULL, 'activated', '30770330', 'MG', 'Belo Horizonte', 'Rua Expedicionário João Moreira', 'Caiçara-Adelaide', '14', '', '(31) 9 9194-8888', 15, '', 'kyus', NULL, '2024-12-04 10:14:51', '2024-12-04 10:14:51', NULL, '2024-12-04 10:14:51', '2024-12-04 12:03:23'),
(47, 11, 'CKGT Dojo', 'Douglas', 'Santos', 'douglasmarcsantos@gmail.com', '1976-12-23', NULL, '03646621664', NULL, 'activated', '30620680', 'MG', 'Belo Horizonte', 'Rua Calumbi', 'Milionários (Barreiro)', '15', '', '(31) 9 9601-5996', 31, 'Aluno ainda sem homologação de faixa iogkf', 'black', NULL, '2024-12-04 10:18:51', '2024-12-04 10:18:51', '2025-12-04', '2024-12-04 10:18:51', '2024-12-04 12:05:02'),
(48, 11, 'CKGT Dojo', 'Caio', 'Ferretti', 'julioffl04@gmail.com', '2015-09-18', 'Julio Ferretti Flores', '00936420677', NULL, 'activated', '30421232', 'MG', 'Belo Horizonte', 'Rua Açucenas', 'Nova Suíssa', '157', 'ap 201', '(31) 9 8675-1095', 1, '', 'kyus', NULL, '2024-12-04 10:21:33', '2024-12-04 10:21:33', NULL, '2024-12-04 10:21:33', '2024-12-04 12:03:09'),
(49, 11, 'CKGT Dojo', 'Inácio', 'Galdino', 'karategojubr@gmail.com', '2012-08-17', 'Conrado Galdino', '03815258642', NULL, 'activated', '31330330', 'MG', 'Belo Horizonte', 'Rua Castelo Évora', 'Castelo', '730', 'ap 101', '(31) 9 9686-2165', 1, '', 'kyus', NULL, '2024-12-04 10:24:40', '2024-12-04 10:24:40', NULL, '2024-12-04 10:24:40', '2024-12-04 12:03:31'),
(50, 11, 'CKGT Dojo', 'Ísis', 'Machado', 'aida.nasc.araujo@gmail.com', '2014-03-17', 'Aída Nascimento Araújo ', '05044954616', NULL, 'activated', '30421228', 'MG', 'Belo Horizonte', 'Rua Java', 'Nova Suíssa', '373', ' ap 202', '(31) 9 9246-8819', 1, '', 'kyus', NULL, '2024-12-04 10:26:33', '2024-12-04 10:26:33', NULL, '2024-12-04 10:26:33', '2024-12-04 12:04:16'),
(51, 11, 'CKGT Dojo', 'Júlio', 'Pontes', 'jcaapholcim@hotmail.com', '1969-12-26', NULL, '73201995649', NULL, 'activated', '30411505', 'MG', 'Belo Horizonte', 'Rua Marcilio Dias', 'Calafate', '49', '', '(31) 9 9183-271', 15, '', 'kyus', NULL, '2024-12-04 10:29:08', '2024-12-04 10:29:08', NULL, '2024-12-04 10:29:08', '2024-12-04 12:03:24'),
(52, 11, 'CKGT Dojo', 'Leonardo', 'Vivas', 'leopvjf@hotmail.com', '1986-11-18', NULL, '07270277605', NULL, 'activated', '31030140', 'MG', 'Belo Horizonte', 'Rua Campestre', 'Sagrada Família', '40', 'ap 704', '(31) 9 9697-6830', 15, '', 'kyus', NULL, '2024-12-04 10:31:17', '2024-12-04 10:31:17', NULL, '2024-12-04 10:31:17', '2024-12-04 12:03:21'),
(53, 11, 'CKGT Dojo', 'Mariana', 'Galdino', 'karategojubr@gmail.com', '2011-07-27', 'Conrado Galdino', '03815258642', NULL, 'activated', '31330330', 'MG', 'Belo Horizonte', 'Rua Castelo Évora', 'Castelo', '730', 'ap 101', '(31) 9 9686-2165', 15, '', 'kyus', NULL, '2024-12-04 10:32:24', '2024-12-04 10:32:24', NULL, '2024-12-04 10:32:24', '2024-12-04 12:03:59'),
(54, 11, 'CKGT Dojo', 'Ricardo', 'Ramos', 'riveneziani@gmail.com', '1990-08-13', NULL, '38334083831', NULL, 'activated', '30750180', 'MG', 'Belo Horizonte', 'Rua Aerolito', 'Caiçara-Adelaide', '100', 'ap 301', '(11) 9 4393-4975', 16, '', 'kyus', NULL, '2024-12-04 10:34:19', '2024-12-04 10:34:19', NULL, '2024-12-04 10:34:19', '2024-12-04 12:03:49'),
(55, 11, 'CKGT Dojo', 'Sophia ', 'Pinto', 'joaogabrielfilho77@gmail.com ', '2011-12-21', 'Joao Gabriel S Pinto Filho', '04767343631', NULL, 'activated', '31230530', 'MG', 'Belo Horizonte', 'Rua Confrade Machado', 'Nova Esperança', '240', '', '(31) 9 8823-0014', 1, '', 'kyus', NULL, '2024-12-04 10:36:34', '2024-12-04 10:36:34', NULL, '2024-12-04 10:36:34', '2024-12-04 12:03:48'),
(56, 11, 'CKGT Dojo', 'Paulo', 'Pinto', 'joaogabrielfilho77@gmail.com', '2014-02-25', 'Joao Gabriel S Pinto Filho', '04767343631', NULL, 'activated', '31230530', 'MG', 'Belo Horizonte', 'Rua Confrade Machado', 'Nova Esperança', '240', '', '(31) 9 8823-0014', 1, '', 'kyus', NULL, '2024-12-04 10:40:17', '2024-12-04 10:40:17', NULL, '2024-12-04 10:40:17', '2024-12-04 12:03:52'),
(57, 11, 'CKGT Dojo', 'João', 'Pinto', 'joaogabrielfilho77@gmail.com ', '2016-06-14', 'Joao Gabriel S Pinto Filho', '04767343631', NULL, 'activated', '31230530', 'MG', 'Belo Horizonte', 'Rua Confrade Machado', 'Nova Esperança', '240', '', '(31) 9 8823-0014', 1, '', 'kyus', NULL, '2024-12-04 10:44:25', '2024-12-04 10:44:25', NULL, '2024-12-04 10:44:25', '2024-12-04 12:03:26'),
(58, 11, 'CKGT Dojo', 'Marco', 'Soares', 'marcopmmg@gmail.com', '1978-12-27', NULL, '03820775633', NULL, 'activated', '30285280', 'MG', 'Belo Horizonte', 'Rua Astolfo Dutra', 'Pompéia', '1189', '', '(31) 9 8823-0014', 23, 'Aluno deverá fazer exame par ahomologação do grau na iogkf', 'kyus', NULL, '2024-12-04 10:48:56', '2024-12-04 10:48:56', NULL, '2024-12-04 10:48:56', '2024-12-04 12:04:00'),
(59, 11, 'CKGT Dojo', 'Gustavo', 'Franco', 'leoluiz.0502@gmail.com.br', '2017-10-27', 'Mariana Bocelli Falcone Nunes Soares', '06042123645', NULL, 'activated', '30421099', 'MG', 'Belo Horizonte', 'Rua Doutor Orestes Diniz', 'Nova Suíssa', '25', '', '(31) 9 7016-544', 1, '', 'kyus', NULL, '2024-12-04 10:51:03', '2024-12-04 10:51:03', NULL, '2024-12-04 10:51:03', '2024-12-04 12:03:15'),
(60, 11, 'CKGT Dojo', 'Alice ', 'Miranda', 'rafaelvictormiranda@gmail.com', '2018-12-23', 'Rafael Victor Miranda de Carvalho', '01601901699', NULL, 'activated', '30411115', 'MG', 'Belo Horizonte', 'Rua Chopin', 'Prado', '82', '492', '(31) 9 8832-5515', 1, '', 'kyus', NULL, '2024-12-04 10:53:04', '2024-12-04 10:53:04', NULL, '2024-12-04 10:53:04', '2024-12-04 12:03:07'),
(61, 11, 'CKGT Dojo', 'Itatiano', 'Miquini Filho', 'itaticontato@gmail.com', '2003-09-15', NULL, '17807210648', NULL, 'activated', '30421157', 'MG', 'Belo Horizonte', 'Rua Capitão José Carlos Vaz de Melo', 'Nova Suíssa', '401', 'ap 11', '(31) 9 8230-0840', 15, '', 'kyus', NULL, '2024-12-04 10:57:56', '2024-12-04 10:57:56', NULL, '2024-12-04 10:57:56', '2024-12-04 12:03:27'),
(62, 11, 'CKGT Dojo', 'Thiago', 'Silva', 'thiagorobertobh@gmail.com', '1980-12-24', NULL, '04609244608', NULL, 'activated', '30510080', 'MG', 'Belo Horizonte', 'Rua Dom Oscar Romero', 'Nova Gameleira', '325', '', '(31) 9 8989-6392', 15, '', 'kyus', NULL, '2024-12-04 11:00:14', '2024-12-04 11:00:14', NULL, '2024-12-04 11:00:14', '2024-12-04 12:03:47'),
(63, 11, 'CKGT Dojo', 'Leonardo', 'Silva', 'leon-hard@hotmail.com', '1984-03-08', NULL, '06383835602', NULL, 'activated', '30510180', 'MG', 'Belo Horizonte', 'Rua Gil Vieira de Carvalho', 'Nova Gameleira', '180', 'ap 102 bl-B10', '(31) 9 8741-5482', 15, '', 'kyus', NULL, '2024-12-04 11:03:15', '2024-12-04 11:03:15', NULL, '2024-12-04 11:03:15', '2024-12-04 12:03:22'),
(64, 11, 'CKGT Dojo', 'Abel', 'Lucas', 'abellucas898@gmail.com', '2006-04-30', NULL, '14879294632', NULL, 'activated', '31010470', 'MG', 'Belo Horizonte', 'Rua Capitão Bragança', 'Santa Tereza', '7', 'ap 202', '(31) 9 7248-8346', 15, '', 'kyus', NULL, '2024-12-04 11:04:47', '2024-12-04 11:04:47', NULL, '2024-12-04 11:04:47', '2024-12-04 12:03:04'),
(65, 13, 'Gakko Shigoto', 'CARLOS VICTOR DA', 'SILVA', 'CARLOS.VICTOR01@YAHOO.COM.BR', '1975-06-03', NULL, '02805361601', NULL, 'pending', '33105450', 'MG', 'Santa Luzia', 'Rua Geraldo Teixeira da Costa', 'São Benedito', '2150', 'CASA', '(31) 9 9875-4801', 31, 'Pratica Karate Goju Ryu desde Julho 1988. De 1994 a 1998, treinou Kenyu Ryu,com Sensei Sinval Salgado porque na cidade não tinha Goju. Em 2010 voltou a pratica Goju Ryu comigo onde está até a presente data.. ', 'black', NULL, '2024-12-06 20:52:35', '2024-12-06 20:52:35', NULL, '2024-12-06 20:52:35', NULL),
(66, 15, 'Fight Studio 1', 'Alberto', 'Magno Lourenço ', 'Betoml2@yahoo.com.br', '1977-06-14', NULL, '99419122620', NULL, 'pending', '31330140', 'MG', 'Belo Horizonte', 'Rua Castelo de São Jorge', 'Castelo', '55', '1106 B', '(31) 9 9252-0067', 31, 'Dojō anterior: Em Forma &#10;Alessandro Veicir Sensei', 'black', NULL, '2024-12-14 14:48:17', '2024-12-14 14:48:17', NULL, '2024-12-14 14:48:17', NULL),
(67, 25, 'teste2', 'Fernando1', 'Sena', 'aluno@gmail.com', '1999-02-25', NULL, '71717171717', NULL, 'activated', '05207130', 'SP', 'São Paulo', 'Rua Magalhães Lemos', 'Vila Caiúba', '11', '', '(11) 1 1111-1111', 24, '', 'black', NULL, '2024-12-14 14:48:17', '2024-12-14 14:48:17', '2026-01-03', '2024-12-14 14:48:17', '2025-01-03 16:31:52'),
(68, 25, 'teste2', 'Teste', 'tese', 'aba@gail.com', '1999-02-25', NULL, '32322343333', NULL, 'pending', '05207130', 'SP', 'São Paulo', 'Rua Magalhães Lemos', 'Vila Caiúba', '111', '', '(11) 1 1111-1111', 31, '', 'kyus', NULL, '2024-12-14 14:48:17', '2024-12-14 14:48:17', NULL, '2024-12-14 14:48:17', '2025-01-03 16:31:47'),
(69, 25, 'teste2', 'teste', '11', 'nnna@gmail.com', '2016-02-25', 'aasa', '88999899999', NULL, 'pending', '05207130', 'SP', 'São Paulo', 'Rua Magalhães Lemos', 'Vila Caiúba', '11', '', '(11) 1 1111-1111', 31, '', 'kyus', NULL, '2024-12-14 14:48:17', '2024-12-14 14:48:17', NULL, '2025-01-03 00:00:00', '2025-01-04 02:14:02');

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_subscriptions`
--

CREATE TABLE `app_subscriptions` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `plan_id` int(11) UNSIGNED DEFAULT NULL,
  `card_id` int(11) UNSIGNED DEFAULT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active' COMMENT 'active,inactive,past_due,canceled',
  `pay_status` varchar(10) NOT NULL DEFAULT 'active' COMMENT 'active,inactive,past_due,canceled',
  `started` date NOT NULL,
  `due_day` int(2) NOT NULL,
  `next_due` date NOT NULL,
  `last_charge` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_wallets`
--

CREATE TABLE `app_wallets` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `wallet` varchar(255) NOT NULL DEFAULT '',
  `free` int(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `app_wallets`
--

INSERT INTO `app_wallets` (`id`, `user_id`, `wallet`, `free`, `created_at`, `updated_at`) VALUES
(6, 18, 'Minha Carteira', 1, '2024-11-26 21:11:54', '2024-11-26 21:11:54'),
(7, 19, 'Minha Carteira', 1, '2024-11-26 23:19:20', '2024-11-26 23:19:20'),
(9, 11, 'Minha Carteira', 1, '2024-11-27 14:06:04', '2024-11-27 14:06:04'),
(10, 15, 'Minha Carteira', 1, '2024-11-27 15:00:01', '2024-11-27 15:00:01'),
(11, 17, 'Minha Carteira', 1, '2024-11-29 21:07:29', '2024-11-29 21:07:29'),
(12, 8, 'Minha Carteira', 1, '2024-11-29 21:10:28', '2024-11-29 21:10:28'),
(13, 13, 'Minha Carteira', 1, '2024-11-30 13:49:37', '2024-11-30 13:49:37'),
(14, 9, 'Minha Carteira', 1, '2024-12-18 10:31:54', '2024-12-18 10:31:54'),
(15, 25, 'Minha Carteira', 1, '2025-01-03 16:07:34', '2025-01-03 16:07:34');

-- --------------------------------------------------------

--
-- Estrutura para tabela `belts`
--

CREATE TABLE `belts` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `position` int(11) DEFAULT NULL,
  `years` int(11) DEFAULT NULL,
  `age_range` int(11) NOT NULL DEFAULT '1' COMMENT '1 - Menor que 13 anos\r\n2 - Maior que 13 anos',
  `graduation_time` int(11) DEFAULT NULL,
  `type_student` varchar(15) NOT NULL DEFAULT 'black',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `belts`
--

INSERT INTO `belts` (`id`, `title`, `position`, `years`, `age_range`, `graduation_time`, `type_student`, `created_at`, `updated_at`) VALUES
(1, '10 kyu (branco)', 1, NULL, 1, NULL, 'kyus', '2024-11-03 23:21:39', '2024-12-10 13:57:37'),
(2, '9 kyu (branco e amarelo)', 2, NULL, 1, NULL, 'kyus', '2024-11-03 23:22:01', '2024-12-10 13:57:41'),
(3, '8 kyu (amarelo)', 3, NULL, 1, NULL, 'kyus', '2024-11-03 23:22:28', '2024-12-10 13:57:47'),
(4, '8/7 kyu (amarelo/laranja)', 4, NULL, 1, NULL, 'kyus', '2024-11-03 23:22:51', '2024-12-10 13:57:44'),
(5, '7 kyu (laranja)', 5, NULL, 1, NULL, 'kyus', '2024-11-03 23:23:11', '2024-12-10 13:57:50'),
(6, '7/6 kyu (laranja/verde)', 6, NULL, 1, NULL, 'kyus', '2024-11-03 23:23:38', '2024-12-10 13:57:52'),
(7, '6 kyu (verde)', 7, NULL, 1, NULL, 'kyus', '2024-11-03 23:23:57', '2024-12-10 13:57:54'),
(8, '6/5 kyu (verde/azul)', 8, NULL, 1, NULL, 'kyus', '2024-11-03 23:24:16', '2024-12-10 13:57:56'),
(9, '5 kyu (azul)', 9, NULL, 1, NULL, 'kyus', '2024-11-03 23:24:57', '2024-12-10 13:57:59'),
(10, '5/4 kyu (azul/vermelho)', 10, NULL, 1, NULL, 'kyus', '2024-11-04 11:07:23', '2024-12-10 13:58:01'),
(11, '4 kyu (vermelho)', 11, NULL, 1, NULL, 'kyus', '2024-11-04 11:07:38', '2024-12-10 13:58:03'),
(12, '3 kyu (marrom)', 12, NULL, 1, NULL, 'kyus', '2024-11-04 11:07:52', '2024-12-10 13:58:07'),
(13, '2 kyu (marrom + 1 listra)', 13, NULL, 1, NULL, 'kyus', '2024-11-04 11:08:07', '2024-12-10 13:58:09'),
(14, '1 kyu (marrom + 2 listras)', 14, NULL, 1, NULL, 'kyus', '2024-11-04 11:08:25', '2024-12-10 13:58:11'),
(15, '9 kyu (branco)', 1, NULL, 2, NULL, 'kyus', '2024-11-04 11:12:42', '2024-12-10 13:58:13'),
(16, '8 kyu (amarelo)', 2, NULL, 2, NULL, 'kyus', '2024-11-04 11:13:28', '2024-12-10 13:58:15'),
(17, '7 kyu (laranja)', 3, NULL, 2, NULL, 'kyus', '2024-11-04 11:13:43', '2024-12-10 13:58:17'),
(18, '6 kyu (verde)', 4, NULL, 2, NULL, 'kyus', '2024-11-04 11:14:00', '2024-12-10 13:58:19'),
(19, '5 kyu (azul)', 5, NULL, 2, NULL, 'kyus', '2024-11-04 11:14:15', '2024-12-10 13:58:22'),
(20, '4 kyu (vermelho)', 6, NULL, 2, NULL, 'kyus', '2024-11-04 11:14:26', '2024-12-10 13:58:25'),
(21, '3 kyu (marrom)', 7, NULL, 2, NULL, 'kyus', '2024-11-04 11:14:38', '2024-12-10 13:58:26'),
(22, '2 kyu (marrom + 1 listra)', 8, NULL, 2, NULL, 'kyus', '2024-11-04 11:14:51', '2024-12-10 13:58:28'),
(23, '1 kyu (marrom + 2 listras)', 9, NULL, 2, NULL, 'kyus', '2024-11-04 11:15:04', '2024-12-10 13:58:30'),
(24, '1 dan (preto)', 10, NULL, 2, 1, 'black', '2024-11-04 11:15:17', '2024-12-03 14:51:21'),
(25, '2 dan (preto)', 11, NULL, 2, 3, 'black', '2024-11-04 11:15:32', '2024-12-03 15:09:23'),
(26, '3 dan (preto)', 12, NULL, 2, 4, 'black', '2024-11-04 11:15:44', '2024-12-03 15:09:33'),
(27, '4 dan (preto)', 13, NULL, 2, 5, 'black', '2024-11-04 11:16:08', '2024-12-03 15:09:39'),
(28, '5 dan (preto)', 14, NULL, 2, 6, 'black', '2024-11-04 11:16:37', '2024-12-03 15:09:46'),
(29, '6 dan (preto)', 15, NULL, 2, NULL, 'black', '2024-11-04 11:16:56', NULL),
(30, '7 dan (preto)', 17, NULL, 2, NULL, 'black', '2024-11-04 11:17:09', '2024-11-26 23:00:40'),
(31, 'Sem graduação IOGKF', NULL, NULL, 3, NULL, 'both', '2024-11-04 12:53:28', '2024-12-10 13:58:55'),
(32, '1 dan Jr (Preto com lista branca)', 20, NULL, 2, NULL, 'kyus', '2024-11-26 23:04:23', '2024-12-10 13:58:57');

-- --------------------------------------------------------

--
-- Estrutura para tabela `categories`
--

CREATE TABLE `categories` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `uri` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `type` varchar(50) NOT NULL DEFAULT 'post' COMMENT 'post, page, etc',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `conf`
--

CREATE TABLE `conf` (
  `id` int(11) NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `conf`
--

INSERT INTO `conf` (`id`, `logo`, `title`) VALUES
(1, 'images/2024/11/logo-1732642267.png', 'Sistema IOGKF Brasil');

-- --------------------------------------------------------

--
-- Estrutura para tabela `faq_channels`
--

CREATE TABLE `faq_channels` (
  `id` int(11) UNSIGNED NOT NULL,
  `channel` varchar(255) DEFAULT NULL,
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `faq_questions`
--

CREATE TABLE `faq_questions` (
  `id` int(11) UNSIGNED NOT NULL,
  `channel_id` int(11) UNSIGNED NOT NULL,
  `question` varchar(255) NOT NULL DEFAULT '',
  `response` text NOT NULL,
  `order_by` int(11) UNSIGNED DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `historic_belts`
--

CREATE TABLE `historic_belts` (
  `id` int(10) UNSIGNED NOT NULL,
  `instructor_id` int(11) DEFAULT NULL,
  `black_belt_id` int(10) UNSIGNED DEFAULT NULL,
  `kyus_id` int(11) DEFAULT NULL,
  `graduation_id` int(10) UNSIGNED NOT NULL,
  `graduation_data` datetime DEFAULT NULL,
  `description` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `historic_belts`
--

INSERT INTO `historic_belts` (`id`, `instructor_id`, `black_belt_id`, `kyus_id`, `graduation_id`, `graduation_data`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, NULL, NULL, 24, NULL, 'Definido ao cadastrar instrutor', 'pending', '2024-11-19 13:30:26', NULL),
(3, 5, NULL, NULL, 24, NULL, 'Definido ao cadastrar instrutor', 'pending', '2024-11-21 14:34:22', NULL),
(4, 6, NULL, NULL, 24, NULL, 'Definido ao cadastrar instrutor', 'pending', '2024-11-21 14:36:49', NULL),
(8, 7, NULL, NULL, 24, NULL, 'Definido ao cadastrar instrutor', 'pending', '2024-11-21 14:56:28', NULL),
(15, 8, NULL, NULL, 25, NULL, 'Definido ao cadastrar instrutor', 'pending', '2024-11-26 14:56:08', NULL),
(16, 9, NULL, NULL, 26, NULL, 'Definido ao cadastrar instrutor', 'pending', '2024-11-26 16:01:05', NULL),
(17, 10, NULL, NULL, 26, NULL, 'Definido ao cadastrar instrutor', 'pending', '2024-11-26 16:12:46', NULL),
(18, 11, NULL, NULL, 25, NULL, 'Definido ao cadastrar instrutor', 'pending', '2024-11-26 16:23:33', NULL),
(19, 12, NULL, NULL, 24, NULL, 'Definido ao cadastrar instrutor', 'pending', '2024-11-26 16:34:04', NULL),
(20, 13, NULL, NULL, 25, NULL, 'Definido ao cadastrar instrutor', 'pending', '2024-11-26 16:43:10', NULL),
(21, 14, NULL, NULL, 24, NULL, 'Definido ao cadastrar instrutor', 'pending', '2024-11-26 16:48:29', NULL),
(22, 15, NULL, NULL, 26, NULL, 'Definido ao cadastrar instrutor', 'pending', '2024-11-26 16:57:17', NULL),
(23, 16, NULL, NULL, 26, NULL, 'Definido ao cadastrar instrutor', 'pending', '2024-11-26 17:05:27', NULL),
(24, 17, NULL, NULL, 24, NULL, 'Definido ao cadastrar instrutor', 'pending', '2024-11-26 17:10:09', NULL),
(25, 18, NULL, NULL, 24, NULL, 'Definido ao cadastrar instrutor', 'pending', '2024-11-26 17:12:45', NULL),
(26, 19, NULL, NULL, 24, NULL, 'Definido ao cadastrar instrutor', 'pending', '2024-11-26 17:22:59', NULL),
(27, 20, NULL, NULL, 28, NULL, 'Definido ao cadastrar instrutor', 'pending', '2024-11-26 17:39:47', NULL),
(28, 21, NULL, NULL, 24, NULL, 'Definido ao cadastrar instrutor', 'pending', '2024-11-26 19:54:15', NULL),
(29, 22, NULL, NULL, 24, NULL, 'Definido ao cadastrar instrutor', 'pending', '2024-11-26 19:55:49', NULL),
(30, 23, NULL, NULL, 24, NULL, 'Definido ao cadastrar instrutor', 'pending', '2024-11-26 20:02:54', NULL),
(31, NULL, NULL, 10, 2, NULL, 'Cadastro inserido pelo Instrutor Rosimeire Freitas Teixeira Monteiro, na data de ', 'activated', '2024-11-26 21:17:17', NULL),
(32, NULL, NULL, 11, 16, NULL, 'Cadastro inserido pelo Instrutor Rosimeire Freitas Teixeira Monteiro, na data de ', 'activated', '2024-11-26 21:19:36', NULL),
(33, NULL, 12, NULL, 31, NULL, 'Cadastro inserido pelo Instrutor Rosimeire Freitas Teixeira Monteiro, na data de ', 'activated', '2024-11-26 21:22:13', NULL),
(34, NULL, NULL, 13, 16, NULL, 'Cadastro inserido pelo Instrutor Rosimeire Freitas Teixeira Monteiro, na data de ', 'activated', '2024-11-26 21:25:02', NULL),
(35, NULL, NULL, 14, 16, NULL, 'Cadastro inserido pelo Instrutor Rosimeire Freitas Teixeira Monteiro, na data de ', 'activated', '2024-11-26 21:27:04', NULL),
(36, NULL, NULL, 15, 2, NULL, 'Cadastro inserido pelo Instrutor Rosimeire Freitas Teixeira Monteiro, na data de ', 'activated', '2024-11-26 21:29:39', NULL),
(37, NULL, NULL, 16, 15, NULL, 'Cadastro inserido pelo Instrutor Rosimeire Freitas Teixeira Monteiro, na data de ', 'activated', '2024-11-26 21:32:09', NULL),
(38, NULL, NULL, 17, 2, NULL, 'Cadastro inserido pelo Instrutor Rosimeire Freitas Teixeira Monteiro, na data de ', 'activated', '2024-11-26 21:38:35', NULL),
(39, NULL, NULL, 18, 2, NULL, 'Cadastro inserido pelo Instrutor Rosimeire Freitas Teixeira Monteiro, na data de ', 'activated', '2024-11-26 21:41:14', NULL),
(40, NULL, NULL, 19, 2, NULL, 'Cadastro inserido pelo Instrutor Rosimeire Freitas Teixeira Monteiro, na data de ', 'activated', '2024-11-26 21:58:43', NULL),
(41, NULL, NULL, 20, 2, NULL, 'Cadastro inserido pelo Instrutor Rosimeire Freitas Teixeira Monteiro, na data de ', 'activated', '2024-11-26 22:02:41', NULL),
(42, NULL, NULL, 21, 1, NULL, 'Cadastro inserido pelo Instrutor Rosimeire Freitas Teixeira Monteiro, na data de ', 'activated', '2024-11-26 22:07:06', NULL),
(43, NULL, NULL, 22, 1, NULL, 'Cadastro inserido pelo Instrutor Rosimeire Freitas Teixeira Monteiro, na data de ', 'activated', '2024-11-26 22:10:07', NULL),
(44, NULL, NULL, 23, 22, NULL, 'Cadastro inserido pelo Instrutor Rosimeire Freitas Teixeira Monteiro, na data de ', 'activated', '2024-11-26 22:12:55', NULL),
(45, NULL, NULL, 24, 15, NULL, 'Cadastro inserido pelo Instrutor Rosimeire Freitas Teixeira Monteiro, na data de ', 'activated', '2024-11-26 22:16:31', NULL),
(46, NULL, NULL, 25, 15, NULL, 'Cadastro inserido pelo Instrutor Rosimeire Freitas Teixeira Monteiro, na data de ', 'activated', '2024-11-26 22:21:36', NULL),
(47, NULL, NULL, 26, 1, NULL, 'Cadastro inserido pelo Instrutor Rosimeire Freitas Teixeira Monteiro, na data de ', 'activated', '2024-11-26 22:25:24', NULL),
(48, NULL, NULL, 27, 15, NULL, 'Cadastro inserido pelo Instrutor Rosimeire Freitas Teixeira Monteiro, na data de ', 'activated', '2024-11-26 22:27:32', NULL),
(49, 24, NULL, NULL, 31, NULL, 'Definido ao cadastrar instrutor', 'pending', '2024-11-27 13:06:27', NULL),
(50, NULL, NULL, 16, 2, NULL, 'Alteração de graduação realizada pelo administrador', 'approved', '2024-11-28 16:59:27', '2024-11-28 16:59:50'),
(51, NULL, NULL, 10, 3, NULL, 'Graduação realizada pelo usuário: rosimeire_ftm@hotmail.com', 'disapprove', '2024-11-28 17:05:55', '2024-11-28 17:06:45'),
(52, NULL, NULL, 28, 15, NULL, 'Cadastro inserido pelo Instrutor Rodrigo Santos da Silva, na data de ', 'activated', '2024-11-29 23:20:55', NULL),
(53, NULL, 29, NULL, 24, NULL, 'Cadastro inserido pelo Instrutor Flávio Antônio Batista, na data de ', 'activated', '2024-12-03 21:51:17', NULL),
(54, NULL, 30, NULL, 24, NULL, 'Cadastro inserido pelo Instrutor Flávio Antônio Batista, na data de ', 'activated', '2024-12-03 22:08:57', NULL),
(55, NULL, NULL, 31, 31, NULL, 'Cadastro inserido pelo Instrutor Flávio Antônio Batista, na data de ', 'activated', '2024-12-03 23:36:25', NULL),
(56, NULL, NULL, 32, 31, NULL, 'Cadastro inserido pelo Instrutor Flávio Antônio Batista, na data de ', 'activated', '2024-12-03 23:58:11', NULL),
(57, NULL, 29, NULL, 31, NULL, 'Alteração de graduação realizada pelo administrador', 'pending', '2024-12-04 00:20:37', NULL),
(58, NULL, 30, NULL, 31, NULL, 'Alteração de graduação realizada pelo administrador', 'pending', '2024-12-04 00:35:01', NULL),
(59, NULL, NULL, 33, 2, NULL, 'Cadastro inserido pelo Instrutor Conrado A. B. Galdino, na data de ', 'activated', '2024-12-04 09:21:29', NULL),
(60, NULL, NULL, 34, 16, NULL, 'Cadastro inserido pelo Instrutor Conrado A. B. Galdino, na data de ', 'activated', '2024-12-04 09:24:34', NULL),
(61, NULL, NULL, 35, 20, NULL, 'Cadastro inserido pelo Instrutor Conrado A. B. Galdino, na data de ', 'activated', '2024-12-04 09:31:22', NULL),
(62, NULL, NULL, 36, 2, NULL, 'Cadastro inserido pelo Instrutor Conrado A. B. Galdino, na data de ', 'activated', '2024-12-04 09:33:58', NULL),
(63, NULL, NULL, 37, 16, NULL, 'Cadastro inserido pelo Instrutor Conrado A. B. Galdino, na data de ', 'activated', '2024-12-04 09:38:01', NULL),
(64, NULL, NULL, 38, 21, NULL, 'Cadastro inserido pelo Instrutor Conrado A. B. Galdino, na data de ', 'activated', '2024-12-04 09:41:30', NULL),
(65, NULL, NULL, 39, 15, NULL, 'Cadastro inserido pelo Instrutor Conrado A. B. Galdino, na data de ', 'activated', '2024-12-04 09:46:18', NULL),
(66, NULL, NULL, 40, 17, NULL, 'Cadastro inserido pelo Instrutor Conrado A. B. Galdino, na data de ', 'activated', '2024-12-04 09:49:09', NULL),
(67, NULL, NULL, 41, 16, NULL, 'Cadastro inserido pelo Instrutor Conrado A. B. Galdino, na data de ', 'activated', '2024-12-04 09:51:57', NULL),
(68, NULL, NULL, 42, 15, NULL, 'Cadastro inserido pelo Instrutor Conrado A. B. Galdino, na data de ', 'activated', '2024-12-04 10:01:29', NULL),
(69, NULL, 43, NULL, 24, NULL, 'Cadastro inserido pelo Instrutor Conrado A. B. Galdino, na data de ', 'activated', '2024-12-04 10:04:56', NULL),
(70, NULL, NULL, 44, 16, NULL, 'Cadastro inserido pelo Instrutor Conrado A. B. Galdino, na data de ', 'activated', '2024-12-04 10:08:46', NULL),
(71, NULL, NULL, 45, 17, NULL, 'Cadastro inserido pelo Instrutor Conrado A. B. Galdino, na data de ', 'activated', '2024-12-04 10:12:55', NULL),
(72, NULL, NULL, 46, 15, NULL, 'Cadastro inserido pelo Instrutor Conrado A. B. Galdino, na data de ', 'activated', '2024-12-04 10:14:51', NULL),
(73, NULL, 47, NULL, 24, NULL, 'Cadastro inserido pelo Instrutor Conrado A. B. Galdino, na data de ', 'activated', '2024-12-04 10:18:51', NULL),
(74, NULL, NULL, 48, 1, NULL, 'Cadastro inserido pelo Instrutor Conrado A. B. Galdino, na data de ', 'activated', '2024-12-04 10:21:33', NULL),
(75, NULL, NULL, 49, 1, NULL, 'Cadastro inserido pelo Instrutor Conrado A. B. Galdino, na data de ', 'activated', '2024-12-04 10:24:40', NULL),
(76, NULL, NULL, 50, 1, NULL, 'Cadastro inserido pelo Instrutor Conrado A. B. Galdino, na data de ', 'activated', '2024-12-04 10:26:33', NULL),
(77, NULL, NULL, 51, 15, NULL, 'Cadastro inserido pelo Instrutor Conrado A. B. Galdino, na data de ', 'activated', '2024-12-04 10:29:08', NULL),
(78, NULL, NULL, 52, 15, NULL, 'Cadastro inserido pelo Instrutor Conrado A. B. Galdino, na data de ', 'activated', '2024-12-04 10:31:17', NULL),
(79, NULL, NULL, 53, 15, NULL, 'Cadastro inserido pelo Instrutor Conrado A. B. Galdino, na data de ', 'activated', '2024-12-04 10:32:24', NULL),
(80, NULL, NULL, 54, 16, NULL, 'Cadastro inserido pelo Instrutor Conrado A. B. Galdino, na data de ', 'activated', '2024-12-04 10:34:19', NULL),
(81, NULL, NULL, 55, 1, NULL, 'Cadastro inserido pelo Instrutor Conrado A. B. Galdino, na data de ', 'activated', '2024-12-04 10:36:34', NULL),
(82, NULL, NULL, 56, 1, NULL, 'Cadastro inserido pelo Instrutor Conrado A. B. Galdino, na data de ', 'activated', '2024-12-04 10:40:17', NULL),
(83, NULL, NULL, 57, 1, NULL, 'Cadastro inserido pelo Instrutor Conrado A. B. Galdino, na data de ', 'activated', '2024-12-04 10:44:25', NULL),
(84, NULL, NULL, 58, 23, NULL, 'Cadastro inserido pelo Instrutor Conrado A. B. Galdino, na data de ', 'activated', '2024-12-04 10:48:56', NULL),
(85, NULL, NULL, 59, 1, NULL, 'Cadastro inserido pelo Instrutor Conrado A. B. Galdino, na data de ', 'activated', '2024-12-04 10:51:03', NULL),
(86, NULL, NULL, 60, 1, NULL, 'Cadastro inserido pelo Instrutor Conrado A. B. Galdino, na data de ', 'activated', '2024-12-04 10:53:04', NULL),
(87, NULL, NULL, 61, 15, NULL, 'Cadastro inserido pelo Instrutor Conrado A. B. Galdino, na data de ', 'activated', '2024-12-04 10:57:56', NULL),
(88, NULL, NULL, 62, 15, NULL, 'Cadastro inserido pelo Instrutor Conrado A. B. Galdino, na data de ', 'activated', '2024-12-04 11:00:14', NULL),
(89, NULL, NULL, 63, 15, NULL, 'Cadastro inserido pelo Instrutor Conrado A. B. Galdino, na data de ', 'activated', '2024-12-04 11:03:15', NULL),
(90, NULL, NULL, 64, 15, NULL, 'Cadastro inserido pelo Instrutor Conrado A. B. Galdino, na data de ', 'activated', '2024-12-04 11:04:47', NULL),
(91, NULL, 43, NULL, 31, NULL, 'Alteração de graduação realizada pelo administrador', 'pending', '2024-12-04 12:04:32', NULL),
(92, NULL, 47, NULL, 31, NULL, 'Alteração de graduação realizada pelo administrador', 'pending', '2024-12-04 12:05:02', NULL),
(93, NULL, 65, NULL, 31, NULL, 'Cadastro inserido pelo Instrutor Flávio Antônio Batista, na data de ', 'activated', '2024-12-06 20:52:35', NULL),
(94, NULL, NULL, 10, 4, NULL, 'Graduação realizada pelo usuário: rosimeire_ftm@hotmail.com', 'pending', '2024-12-11 13:09:28', NULL),
(95, NULL, NULL, 11, 17, NULL, 'Graduação realizada pelo usuário: rosimeire_ftm@hotmail.com', 'pending', '2024-12-11 13:09:31', NULL),
(96, NULL, NULL, 13, 17, NULL, 'Graduação realizada pelo usuário: rosimeire_ftm@hotmail.com', 'pending', '2024-12-11 13:09:33', NULL),
(97, NULL, NULL, 18, 3, NULL, 'Graduação realizada pelo usuário: rosimeire_ftm@hotmail.com', 'pending', '2024-12-11 13:09:46', NULL),
(98, NULL, NULL, 20, 3, NULL, 'Graduação realizada pelo usuário: rosimeire_ftm@hotmail.com', 'pending', '2024-12-11 13:09:51', NULL),
(99, NULL, NULL, 21, 2, NULL, 'Graduação realizada pelo usuário: rosimeire_ftm@hotmail.com', 'pending', '2024-12-11 13:09:54', NULL),
(100, NULL, NULL, 22, 2, NULL, 'Graduação realizada pelo usuário: rosimeire_ftm@hotmail.com', 'pending', '2024-12-11 13:09:57', NULL),
(101, NULL, NULL, 28, 16, NULL, 'Graduação realizada pelo usuário: karategoju.sc@gmail.com', 'pending', '2024-12-14 14:08:59', NULL),
(102, NULL, 66, NULL, 31, NULL, 'Cadastro inserido pelo Instrutor Kilder Giovanni de Araujo, na data de ', 'activated', '2024-12-14 14:48:17', NULL),
(103, NULL, NULL, 34, 17, NULL, 'Graduação realizada pelo usuário: karategojubr@gmail.com', 'pending', '2024-12-14 21:20:40', NULL),
(104, 25, NULL, NULL, 24, NULL, 'Definido ao cadastrar instrutor', 'approved', '2025-01-03 16:07:16', NULL),
(105, NULL, 67, NULL, 24, NULL, 'Cadastro inserido pelo Instrutor Fernando Sena, na data de ', 'approved', '2025-01-03 16:08:17', NULL),
(106, NULL, NULL, 68, 31, NULL, 'Cadastro inserido pelo Instrutor Fernando Sena, na data de ', 'approved', '2025-01-03 16:20:31', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `mail_queue`
--

CREATE TABLE `mail_queue` (
  `id` int(11) UNSIGNED NOT NULL,
  `subject` varchar(255) NOT NULL DEFAULT '',
  `body` text NOT NULL,
  `from_email` varchar(255) NOT NULL DEFAULT '',
  `from_name` varchar(255) NOT NULL DEFAULT '',
  `recipient_email` varchar(255) NOT NULL DEFAULT '',
  `recipient_name` varchar(255) NOT NULL DEFAULT '',
  `sent_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `link` varchar(255) NOT NULL DEFAULT '',
  `view` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `posts`
--

CREATE TABLE `posts` (
  `id` int(11) UNSIGNED NOT NULL,
  `author` int(11) UNSIGNED DEFAULT NULL,
  `category` int(11) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `uri` varchar(255) NOT NULL,
  `subtitle` text NOT NULL,
  `content` text NOT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `video` varchar(50) DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  `status` varchar(20) NOT NULL DEFAULT 'draft' COMMENT 'post, draft, trash ',
  `post_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `report_access`
--

CREATE TABLE `report_access` (
  `id` int(11) UNSIGNED NOT NULL,
  `users` int(11) NOT NULL DEFAULT '1',
  `views` int(11) NOT NULL DEFAULT '1',
  `pages` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `report_access`
--

INSERT INTO `report_access` (`id`, `users`, `views`, `pages`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 5, '2024-11-02 16:50:42', '2024-11-02 18:25:30'),
(2, 1, 1, 3, '2024-11-03 23:16:01', '2024-11-03 23:16:42'),
(3, 1, 2, 188, '2024-11-04 11:02:18', '2024-11-04 17:37:53'),
(4, 3, 3, 232, '2024-11-11 13:00:13', '2024-11-11 17:54:51'),
(5, 7, 11, 278, '2024-11-12 12:19:17', '2024-11-12 22:04:47'),
(6, 1, 1, 6, '2025-01-11 15:28:30', '2025-01-11 15:37:08'),
(7, 1, 1, 5, '2025-02-11 15:37:11', '2025-02-11 15:37:14'),
(8, 1, 1, 2, '2025-03-11 15:37:04', '2025-03-11 15:37:05'),
(9, 1, 1, 1, '2026-02-11 15:37:07', '2026-02-11 15:37:07'),
(10, 2, 2, 2, '2024-11-13 21:48:18', '2024-11-13 21:48:18'),
(11, 8, 8, 8, '2024-11-14 00:20:22', '2024-11-14 17:37:07'),
(12, 29, 29, 31, '2024-11-15 04:38:41', '2024-11-15 23:58:43'),
(13, 14, 14, 14, '2024-11-16 06:42:59', '2024-11-16 20:55:12'),
(14, 20, 20, 20, '2024-11-17 04:23:58', '2024-11-17 22:56:10'),
(15, 14, 14, 14, '2024-11-18 02:28:56', '2024-11-18 20:54:48'),
(16, 5, 5, 64, '2024-11-19 00:02:31', '2024-11-19 17:46:10'),
(17, 13, 13, 13, '2024-11-20 00:49:43', '2024-11-20 17:54:07'),
(18, 15, 14, 200, '2024-11-21 00:02:32', '2024-11-21 17:12:24'),
(19, 9, 9, 9, '2024-11-22 00:07:09', '2024-11-22 17:34:30'),
(20, 6, 6, 6, '2024-11-23 03:52:03', '2024-11-23 23:13:59'),
(21, 7, 7, 7, '2024-11-24 11:18:56', '2024-11-24 20:36:20'),
(22, 13, 15, 69, '2024-11-25 08:29:07', '2024-11-25 19:22:34'),
(23, 19, 21, 519, '2024-11-26 10:24:13', '2024-11-26 23:26:18'),
(24, 22, 28, 250, '2024-11-27 12:03:19', '2024-11-27 23:48:11'),
(25, 10, 14, 121, '2024-11-28 01:01:02', '2024-11-28 22:44:29'),
(26, 20, 22, 157, '2024-11-29 00:40:02', '2024-11-29 23:21:05'),
(27, 14, 16, 89, '2024-11-30 00:32:56', '2024-11-30 23:55:14'),
(28, 17, 16, 23, '2024-12-01 02:55:10', '2024-12-01 23:29:57'),
(29, 19, 20, 43, '2024-12-02 09:21:58', '2024-12-02 23:59:13'),
(30, 21, 24, 180, '2024-12-03 01:22:41', '2024-12-03 23:58:12'),
(31, 10, 11, 311, '2024-12-04 00:11:17', '2024-12-04 17:35:58'),
(32, 1, 1, 1, '2024-12-05 14:11:55', '2024-12-05 14:11:55'),
(33, 5, 5, 16, '2024-12-06 06:01:56', '2024-12-06 20:55:21'),
(34, 12, 13, 13, '2024-12-07 05:15:56', '2024-12-07 21:42:19'),
(35, 6, 7, 19, '2024-12-08 14:45:38', '2024-12-08 22:28:11'),
(36, 9, 10, 10, '2024-12-09 05:23:42', '2024-12-09 22:58:34'),
(37, 19, 19, 77, '2024-12-10 08:07:46', '2024-12-10 21:24:40'),
(38, 16, 19, 114, '2024-12-11 00:36:06', '2024-12-11 22:10:11'),
(39, 9, 9, 23, '2024-12-12 00:03:59', '2024-12-12 22:07:21'),
(40, 17, 16, 27, '2024-12-13 00:05:09', '2024-12-13 20:02:06'),
(41, 17, 15, 33, '2024-12-14 04:08:06', '2024-12-14 23:05:18'),
(42, 9, 9, 9, '2024-12-15 00:06:53', '2024-12-15 18:51:15'),
(43, 4, 4, 4, '2024-12-16 10:43:39', '2024-12-16 22:48:04'),
(44, 7, 7, 8, '2024-12-17 00:00:11', '2024-12-17 23:03:13'),
(45, 14, 14, 27, '2024-12-18 06:56:34', '2024-12-18 22:59:19'),
(46, 13, 12, 13, '2024-12-19 01:09:21', '2024-12-19 22:40:25'),
(47, 14, 14, 15, '2024-12-20 00:00:59', '2024-12-20 18:49:22'),
(48, 9, 9, 9, '2024-12-21 01:44:33', '2024-12-21 21:55:32'),
(49, 10, 10, 10, '2024-12-22 02:05:10', '2024-12-22 17:42:00'),
(50, 9, 9, 9, '2024-12-23 02:53:11', '2024-12-23 21:50:18'),
(51, 4, 4, 4, '2024-12-24 11:11:59', '2024-12-24 13:03:22'),
(52, 4, 4, 4, '2024-12-25 08:39:31', '2024-12-25 21:46:28'),
(53, 6, 6, 6, '2024-12-26 01:04:19', '2024-12-26 20:48:18'),
(54, 12, 12, 12, '2024-12-27 01:56:19', '2024-12-27 23:23:53'),
(55, 4, 4, 35, '2024-12-28 11:39:44', '2024-12-28 19:30:48'),
(56, 13, 13, 67, '2024-12-29 12:10:01', '2024-12-29 23:28:11'),
(57, 20, 20, 25, '2024-12-30 00:29:41', '2024-12-30 21:39:58'),
(58, 7, 7, 7, '2024-12-31 02:50:27', '2024-12-31 19:13:25'),
(59, 4, 4, 17, '2025-01-01 00:47:59', '2025-01-01 09:22:00'),
(60, 1, 1, 122, '2025-01-03 16:05:20', '2025-01-03 23:12:40'),
(61, 1, 3, 13, '2025-01-04 01:09:26', '2025-01-04 11:19:52'),
(62, 1, 1, 7, '2025-01-05 02:22:11', '2025-01-05 14:50:13');

-- --------------------------------------------------------

--
-- Estrutura para tabela `report_online`
--

CREATE TABLE `report_online` (
  `id` int(11) UNSIGNED NOT NULL,
  `user` int(11) UNSIGNED DEFAULT NULL,
  `ip` varchar(50) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `agent` varchar(255) NOT NULL DEFAULT '',
  `pages` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL DEFAULT '',
  `last_name` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `level` int(11) NOT NULL DEFAULT '1',
  `forget` varchar(255) DEFAULT NULL,
  `datebirth` date NOT NULL,
  `document` varchar(11) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `zip` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `neighborhood` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `complement` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `graduation` int(11) NOT NULL,
  `dojo` varchar(255) NOT NULL,
  `renewal` varchar(255) DEFAULT NULL,
  `renewal_data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_renewal_data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `next_graduation` date DEFAULT NULL,
  `account_status` varchar(255) NOT NULL DEFAULT 'registered' COMMENT 'registered, confirmed',
  `status` varchar(255) NOT NULL DEFAULT 'activated' COMMENT 'activated, deactivated, pending',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `level`, `forget`, `datebirth`, `document`, `photo`, `zip`, `state`, `city`, `address`, `neighborhood`, `number`, `complement`, `phone`, `graduation`, `dojo`, `renewal`, `renewal_data`, `last_renewal_data`, `next_graduation`, `account_status`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Zé ', 'Mário', 'admin@sistema.com.br', '$2y$10$5JveWItTSNzzD1s1yPv4F...v2PAuMAWxaViYsPg6rzmR/U73RxAK', 5, NULL, '1968-07-27', '11111111111', 'images/2024/11/admin-iogkf.jpg', '29062190', 'ES', 'Vitória', 'Rua Thereza Zanoni Caser', 'Pontal de Camburi', '168', '', '(27) 9 9921-6299', 28, 'Kominka dojo', '111111', '2024-11-02 16:57:40', '2024-11-02 16:57:40', NULL, 'registered', 'activated', '2024-11-02 16:57:40', '2024-12-03 02:36:06'),
(8, 'André de Almeida ', 'Schaeffer', 'andre_schaeffer@hotmail.com', '$2y$10$8kFFGKY1Lu2jbfhx45UdHORNUipE7U33nXXDOxLkk5isA.oJbTJby', 1, NULL, '1985-11-05', '11823646751', 'images/2024/11/andre-de-almeida-schaeffer.jpg', '29945450', 'ES', 'São Mateus', 'Avenida Esbertalina Barbosa Damiani', 'Guriri Sul', '1505', 'Karate', '(27) 9 9852-2398', 25, 'Dojo Guriri', NULL, '2024-11-26 14:56:08', '2024-11-26 14:56:08', '2027-11-26', 'registered', 'activated', '2024-11-26 14:56:08', '2024-12-03 15:10:22'),
(9, 'Ângelo Magno Tarrayar ', 'Cavalcante Lima', 'angelusvulture@hotmail.com', '$2y$10$Q5OdrVmI6BGp5ps/fvlCeeH88NycsmLlsBaqegYKT66poVLlgOBZy', 1, NULL, '1979-05-09', '04534937695', 'images/2024/11/angelo-magno-tarrayar-cavalcante-lima.jpg', '37150000', 'MG', 'Carmo do Rio Claro', 'Rua Três', 'Jardim Primavera', '51', '', '(35) 9 9897-1107', 26, 'CT Carmo Fight', NULL, '2024-11-26 16:01:05', '2024-11-26 16:01:05', '2028-11-26', 'registered', 'activated', '2024-11-26 16:01:05', '2024-12-18 10:31:41'),
(10, 'Maria Carolina de Souza', 'Torres', 'carolinatorresrj@gmail.com', '$2y$10$qwQl5CUbrL3Kgd6bPLHGI.88bzZESZ0TdVpuP6BlYt38cPzmlVv4m', 1, NULL, '1983-03-29', '10379933730', 'images/2024/11/maria-carolina-de-souza-torres.jpg', '20961210', 'RJ', 'Rio de Janeiro', 'Rua Baronesa do Engenho Novo', 'Engenho Novo', '414 ', 'bloco 2 apt 1607', '(21) 9 9260-1663', 26, 'CT Dojo', NULL, '2024-11-26 16:12:46', '2024-11-26 16:12:46', '2028-11-26', 'registered', 'activated', '2024-11-26 16:12:46', '2024-12-03 15:10:22'),
(11, 'Conrado A. B.', 'Galdino', 'karategojubr@gmail.com', '$2y$10$LIn4knSLYKU/oCItfM9XHO5uGWMAnThL0mT6KYWwiiuOwIgFE8ZG2', 1, NULL, '1977-04-04', '03815258642', 'images/2024/11/conrado-a-b-galdino.jpg', '31330330', 'MG', 'Belo Horizonte', 'Rua Castelo Évora', 'Castelo', '730', 'AP 101', '(31) 9 9318-2736', 25, 'CKGT Dojo', NULL, '2024-11-26 16:23:33', '2024-11-26 16:23:33', '2027-11-26', 'registered', 'activated', '2024-11-26 16:23:33', '2024-12-03 15:10:22'),
(12, 'Eyder Barbosa de Senna', 'Jeronymo', 'eyderdoutorado@gmail.com', '$2y$10$/78lZgaA2pc5qWnKgXIPkePPR.Hl1tAOBQZ25RHeimpx2phEiajRO', 1, NULL, '1962-04-19', '27975134104', 'images/2024/11/eyder-barbosa-de-senna-jeronymo.jpg', '30110032', 'MG', 'Belo Horizonte', 'Avenida do Contorno', 'Funcionários', '5048', '302', '(31) 9 9198-837', 24, 'Igayim dojo', NULL, '2024-11-26 16:34:04', '2024-11-26 16:34:04', '2025-11-26', 'registered', 'activated', '2024-11-26 16:34:04', '2024-12-03 15:10:22'),
(13, 'Flávio Antônio', 'Batista', 'flavioshihan@gmail.com', '$2y$10$fqeaJ.iODE5kReqn4iFpKejLGTLBuDofTzgyvYuiI1rJM5/dX3FSO', 1, NULL, '1956-06-13', '19520239634', 'images/2024/11/flavio-antonio-batista.jpg', '32073210', 'MG', 'Contagem', 'Rua Tarumirim', 'Industrial São Luiz', '368', '', '(31) 9 9736-6197', 25, 'Gakko Shigoto', NULL, '2024-11-26 16:43:10', '2024-11-26 16:43:10', '2027-11-26', 'registered', 'activated', '2024-11-26 16:43:10', '2024-12-03 15:10:22'),
(14, 'Jamil Gomes de Abreu', 'Junior', 'iogkgbrasil.lavras@gmail.com', '$2y$10$e3ZYGPUwoPUELJZ2NQPKSe7/wlgBxQFd3b/aP1cj38TY/mUNZd2s.', 1, NULL, '1981-03-18', '03054978710', 'images/2024/11/jamil-gomes-de-abreu-junior.jpg', '37209106', 'MG', 'Lavras', 'Rua Juca Fidelis', 'São Vicente', '82', '', '(22) 9 9936-0532', 24, 'IOGKF Brasil Lavras dojo', NULL, '2024-11-26 16:48:29', '2024-11-26 16:48:29', '2025-11-26', 'registered', 'activated', '2024-11-26 16:48:29', '2024-12-03 15:10:22'),
(15, 'Kilder Giovanni de', 'Araujo', 'kildergiovanni.budo@gmail.com', '$2y$10$UatcdY1QhRauVG4AIOx13OOEWNSzFv7nRd2n2NJzrpjp/Dm3Jk0pa', 1, NULL, '1976-08-26', '02986472656', 'images/2024/11/kilder-giovanni-de-araujo.jpg', '30310760', 'MG', 'Belo Horizonte', 'Rua Passa Tempo', 'Carmo', '489', 'ap 301', '(31) 9 8793-0927', 26, 'Fight Studio 1', NULL, '2024-11-26 16:57:17', '2024-11-26 16:57:17', '2028-11-26', 'registered', 'activated', '2024-11-26 16:57:17', '2024-12-14 14:44:26'),
(16, 'Paulo Henrique Nahas de', 'Souza', 'phoriginal@gmail.com', '$2y$10$oXKzEGemoALh37MD/969ruNUVjOlhSIUaG/1F8fV9dgMzlYSU.Ioa', 1, NULL, '1986-09-18', '32132132121', 'images/2024/11/paulo-henrique-nahas-de-souza.jpg', '30710560', 'MG', 'Belo Horizonte', 'Rua Três Pontas', 'Carlos Prates', '1197', '', '(31) 9 8732-0210', 26, 'Fight Studio', NULL, '2024-11-26 17:05:27', '2024-11-26 17:05:27', '2028-11-26', 'registered', 'activated', '2024-11-26 17:05:27', '2024-12-03 15:10:22'),
(17, 'Rodrigo', 'Santos da Silva', 'karategoju.sc@gmail.com', '$2y$10$VtNln7fdLGHIlbGOJZ3yqucld7JyOrNIQTO/Jd4SeQ29PHU9Kqe3S', 1, NULL, '1991-06-09', '01213715229', 'images/2024/11/rodrigo-santos-da-silva.jpg', '88130808', 'SC', 'Palhoça', 'Rua Maria do Carmo Lopes', 'Ponte do Imaruim', '183', '', '(48) 9 1014-732', 24, 'Karate Goju SC', NULL, '2024-11-26 17:10:09', '2024-11-26 17:10:09', '2025-11-26', 'registered', 'activated', '2024-11-26 17:10:09', '2024-12-11 20:54:26'),
(18, 'Rosimeire Freitas', 'Teixeira Monteiro', 'rosimeire_ftm@hotmail.com', '$2y$10$LdpFghqGLYaKHqtRFn3VjeAtKaHYRlDiss4pfeflYVafIgmcyTXpy', 1, NULL, '1979-04-23', '08006730776', 'images/2024/11/rosimeire-freitas-teixeira-monteiro.jpg', '29062190', 'ES', 'Vitória', 'Rua Thereza Zanoni Caser', 'Pontal de Camburi', '168', '', '(27) 9 9979-8718', 24, 'Kominka dojo', NULL, '2024-11-26 17:12:45', '2024-11-26 17:12:45', '2025-11-26', 'registered', 'activated', '2024-11-26 17:12:45', '2024-12-29 23:15:26'),
(19, 'Neweton António de Lima', 'Adas', 'neveton2000@yahoo.com.br', '$2y$10$uPWpFc03MCc8oKaHLW1gielLcQqtNdGXTLKA.zRtWhaDJH6jXYSYi', 1, 'a4dbfcb2377f2d8ad2dfc66c82b30577', '1972-06-28', '76460770620', 'images/2024/11/neweton-antonio-de-lima-adas.jpg', '38411066', 'MG', 'Uberlândia', 'Rua Tenente Rafael de Freitas', 'Patrimônio', '341', '', '(34) 9 2723-303', 31, 'Adas e Nahas Uberlândia', NULL, '2024-11-26 17:22:59', '2024-11-26 17:22:59', NULL, 'registered', 'activated', '2024-11-26 17:22:59', '2024-12-02 13:11:22'),
(25, 'Fernando', 'Sena', 'fernandocarvalho.sena@gmail.com', '$2y$10$0Yd5smgvUD6Ynt7Z0176U.hdgv5TMUNZIkwNR/4kbgq7HXGQUwLei', 1, NULL, '1999-02-25', '12687939498', NULL, '05207130', 'SP', 'São Paulo', 'Rua Magalhães Lemos', 'Vila Caiúba', '11', '', '(11) 1 1111-1111', 24, 'teste2', NULL, '2025-01-03 16:07:15', '2025-01-03 16:07:15', '2026-01-03', 'registered', 'activated', '2025-01-03 16:07:15', NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addr_user` (`user_id`);

--
-- Índices de tabela `app_categories`
--
ALTER TABLE `app_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_of` (`sub_of`);

--
-- Índices de tabela `app_certificate`
--
ALTER TABLE `app_certificate`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `app_credit_cards`
--
ALTER TABLE `app_credit_cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `credit_cards_user` (`user_id`);

--
-- Índices de tabela `app_invoices`
--
ALTER TABLE `app_invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `app_user` (`user_id`),
  ADD KEY `app_wallet` (`wallet_id`),
  ADD KEY `app_category` (`category_id`),
  ADD KEY `app_invoice` (`invoice_of`);

--
-- Índices de tabela `app_orders`
--
ALTER TABLE `app_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user` (`user_id`),
  ADD KEY `orders_credit_card` (`card_id`),
  ADD KEY `orders_subscription` (`subscription_id`);

--
-- Índices de tabela `app_payments`
--
ALTER TABLE `app_payments`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `app_plans`
--
ALTER TABLE `app_plans`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `app_students`
--
ALTER TABLE `app_students`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `app_students` ADD FULLTEXT KEY `full_text` (`first_name`,`last_name`,`email`);

--
-- Índices de tabela `app_subscriptions`
--
ALTER TABLE `app_subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscription_user` (`user_id`),
  ADD KEY `subscription_card` (`card_id`),
  ADD KEY `subscription_plan` (`plan_id`);

--
-- Índices de tabela `app_wallets`
--
ALTER TABLE `app_wallets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wallet_user` (`user_id`);

--
-- Índices de tabela `belts`
--
ALTER TABLE `belts`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `conf`
--
ALTER TABLE `conf`
  ADD UNIQUE KEY `id` (`id`);

--
-- Índices de tabela `faq_channels`
--
ALTER TABLE `faq_channels`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `faq_questions`
--
ALTER TABLE `faq_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `channel_id` (`channel_id`);

--
-- Índices de tabela `historic_belts`
--
ALTER TABLE `historic_belts`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `mail_queue`
--
ALTER TABLE `mail_queue`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category`),
  ADD KEY `user_id` (`author`);
ALTER TABLE `posts` ADD FULLTEXT KEY `full_text` (`title`,`subtitle`);

--
-- Índices de tabela `report_access`
--
ALTER TABLE `report_access`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `report_online`
--
ALTER TABLE `report_online`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);
ALTER TABLE `users` ADD FULLTEXT KEY `full_text` (`first_name`,`last_name`,`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `app_categories`
--
ALTER TABLE `app_categories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `app_certificate`
--
ALTER TABLE `app_certificate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `app_credit_cards`
--
ALTER TABLE `app_credit_cards`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `app_invoices`
--
ALTER TABLE `app_invoices`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `app_orders`
--
ALTER TABLE `app_orders`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `app_payments`
--
ALTER TABLE `app_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `app_plans`
--
ALTER TABLE `app_plans`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `app_students`
--
ALTER TABLE `app_students`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT de tabela `app_subscriptions`
--
ALTER TABLE `app_subscriptions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `app_wallets`
--
ALTER TABLE `app_wallets`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `belts`
--
ALTER TABLE `belts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de tabela `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `conf`
--
ALTER TABLE `conf`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `faq_channels`
--
ALTER TABLE `faq_channels`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `faq_questions`
--
ALTER TABLE `faq_questions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `historic_belts`
--
ALTER TABLE `historic_belts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT de tabela `mail_queue`
--
ALTER TABLE `mail_queue`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `report_access`
--
ALTER TABLE `report_access`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de tabela `report_online`
--
ALTER TABLE `report_online`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para tabelas `app_categories`
--
ALTER TABLE `app_categories`
  ADD CONSTRAINT `sub_of` FOREIGN KEY (`sub_of`) REFERENCES `app_categories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para tabelas `app_credit_cards`
--
ALTER TABLE `app_credit_cards`
  ADD CONSTRAINT `credit_cards_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para tabelas `app_invoices`
--
ALTER TABLE `app_invoices`
  ADD CONSTRAINT `app_category` FOREIGN KEY (`category_id`) REFERENCES `app_categories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `app_invoice` FOREIGN KEY (`invoice_of`) REFERENCES `app_invoices` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `app_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `app_wallet` FOREIGN KEY (`wallet_id`) REFERENCES `app_wallets` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para tabelas `app_orders`
--
ALTER TABLE `app_orders`
  ADD CONSTRAINT `orders_credit_card` FOREIGN KEY (`card_id`) REFERENCES `app_credit_cards` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `orders_subscription` FOREIGN KEY (`subscription_id`) REFERENCES `app_subscriptions` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para tabelas `app_subscriptions`
--
ALTER TABLE `app_subscriptions`
  ADD CONSTRAINT `subscription_card` FOREIGN KEY (`card_id`) REFERENCES `app_credit_cards` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `subscription_plan` FOREIGN KEY (`plan_id`) REFERENCES `app_plans` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `subscription_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para tabelas `app_wallets`
--
ALTER TABLE `app_wallets`
  ADD CONSTRAINT `wallet_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para tabelas `faq_questions`
--
ALTER TABLE `faq_questions`
  ADD CONSTRAINT `channel_id` FOREIGN KEY (`channel_id`) REFERENCES `faq_channels` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para tabelas `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `category_id` FOREIGN KEY (`category`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_id` FOREIGN KEY (`author`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
