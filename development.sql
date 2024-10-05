-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql:3306
-- Tempo de geração: 05/10/2024 às 13:39
-- Versão do servidor: 5.7.44
-- Versão do PHP: 8.2.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `development`
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
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `datebirth` date NOT NULL,
  `mother_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
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
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- --------------------------------------------------------

--
-- Estrutura para tabela `belts`
--

CREATE TABLE `belts` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `age_range` int(11) NOT NULL DEFAULT '1' COMMENT '1 - Menor que 13 anos\r\n2 - Maior que 13 anos',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `belts`
--

INSERT INTO `belts` (`id`, `title`, `description`, `age_range`, `created_at`, `updated_at`) VALUES
(1, '10 kyu', '(branco)', 2, '2024-09-07 01:10:44', '2024-09-07 19:08:03'),
(2, '9 kyu', '(branco e amarelo)', 2, '2024-09-07 01:17:29', '2024-09-07 19:08:13'),
(3, '8 kyu', '(amarelo)', 2, '2024-09-07 01:17:47', '2024-09-07 19:08:25'),
(4, '8/7 kyu', '(amarelo/laranja)', 2, '2024-09-07 01:18:07', '2024-09-07 19:08:39'),
(5, '7 kyu', '(laranja)', 2, '2024-09-07 01:18:20', '2024-09-07 19:08:45'),
(6, '7/6 kyu', '(laranja/verde)', 2, '2024-09-07 01:18:32', '2024-09-07 19:08:49'),
(7, '6 kyu', '(verde)', 2, '2024-09-07 01:18:41', '2024-09-07 19:08:53'),
(8, '6/5 kyu', '(verde/azul)', 2, '2024-09-07 01:18:52', '2024-09-07 19:08:58'),
(9, '5 kyu', '(azul)', 2, '2024-09-07 01:19:03', '2024-09-07 19:09:03'),
(10, '5/4 kyu', '(azul/vermelho)', 2, '2024-09-07 01:19:14', '2024-09-07 19:09:09'),
(11, '4 kyu', '(vermelho)', 2, '2024-09-07 01:19:24', '2024-09-07 19:09:13'),
(12, '3 kyu', '(marrom)', 2, '2024-09-07 01:19:41', '2024-09-07 19:09:19'),
(13, '2 kyu', '(marrom + 1 listra)', 2, '2024-09-07 01:20:01', '2024-09-07 19:09:24'),
(14, '1 kyu', '(marrom + 2 listras)', 2, '2024-09-07 01:20:17', '2024-09-07 19:09:29'),
(23, '1 kyu', '(marrom + 2 listras)', 1, '2024-09-07 01:22:28', '2024-09-07 19:10:08'),
(24, '1 dan', '2 anos', 1, '2024-09-07 01:22:40', '2024-09-07 19:10:35'),
(25, '2 dan', '3 anos', 1, '2024-09-07 01:22:49', '2024-09-07 19:10:40'),
(26, '3 dan', '4 anos', 1, '2024-09-07 01:22:58', '2024-09-07 19:10:46'),
(27, '4 dan', '5 anos', 1, '2024-09-07 01:23:07', '2024-09-07 19:10:51'),
(28, '5 dan', '6 anos', 1, '2024-09-07 01:23:21', '2024-09-07 19:11:03'),
(29, '6 dan', '7 anos', 1, '2024-09-07 01:23:31', '2024-09-07 19:11:20'),
(30, '7 dan', '', 1, '2024-09-07 01:28:52', '2024-09-07 19:11:52');

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
  `black_belt_id` int(10) UNSIGNED DEFAULT NULL,
  `kyus_id` int(11) DEFAULT NULL,
  `graduation_id` int(10) UNSIGNED NOT NULL,
  `description` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `account_status` varchar(255) NOT NULL DEFAULT 'registered' COMMENT 'registered, confirmed',
  `status` varchar(255) NOT NULL DEFAULT 'activated' COMMENT 'activated, deactivated, pending',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `level`, `forget`, `datebirth`, `document`, `photo`, `zip`, `state`, `city`, `address`, `neighborhood`, `number`, `complement`, `phone`, `graduation`, `dojo`, `renewal`, `renewal_data`, `last_renewal_data`, `account_status`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'Sistema', 'admin@sistema.com.br', '$2y$10$Q1x9MpYo/Ug6TH4DwD.Tcur4pzfnpGpBIU.7AT5zouZ4dO/jFqqXm', 5, NULL, '2024-10-05', '11111111111', NULL, '000000', '000000', '000000', '000000', '000000', '000000', NULL, '000000', 1, '000000', NULL, '2024-10-05 13:39:46', '2024-10-05 13:39:46', 'confirmed', 'activated', '2024-10-05 13:39:46', NULL);

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
-- Índices de tabela `app_plans`
--
ALTER TABLE `app_plans`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `app_students`
--
ALTER TABLE `app_students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);
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
-- AUTO_INCREMENT de tabela `app_plans`
--
ALTER TABLE `app_plans`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `app_students`
--
ALTER TABLE `app_students`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `app_subscriptions`
--
ALTER TABLE `app_subscriptions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `app_wallets`
--
ALTER TABLE `app_wallets`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `belts`
--
ALTER TABLE `belts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de tabela `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `report_online`
--
ALTER TABLE `report_online`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
