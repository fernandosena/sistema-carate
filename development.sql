-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql:3306
-- Tempo de geração: 30/08/2024 às 18:24
-- Versão do servidor: 5.7.44
-- Versão do PHP: 8.2.22

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
(1, 1, 'Minha Carteira', 1, '2024-08-30 00:21:46', '2024-08-30 00:21:46'),
(2, 2, 'Minha Carteira', 1, '2024-08-30 01:24:46', '2024-08-30 01:24:46');

-- --------------------------------------------------------

--
-- Estrutura para tabela `belts`
--

CREATE TABLE `belts` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `belts`
--

INSERT INTO `belts` (`id`, `title`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Preta', 'faixa preta', '2024-08-30 13:03:19', NULL);

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
(1, 1, 3, 399, '2024-08-30 00:20:43', '2024-08-30 17:44:25');

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
-- Estrutura para tabela `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `document` varchar(255) NOT NULL,
  `belts` int(11) UNSIGNED NOT NULL,
  `description` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'activated',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `student`
--

INSERT INTO `student` (`id`, `user_id`, `photo`, `first_name`, `last_name`, `email`, `phone`, `document`, `belts`, `description`, `status`, `created_at`, `updated_at`) VALUES
(3, 2, NULL, 'FERNANDO', 'DE SENA', 'fernandocarvalho.sena@gmail.com', '(11) 9 4363-2003', '126.879.394-98', 1, '', 'activated', '2024-08-30 17:43:11', NULL);

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
  `genre` varchar(10) DEFAULT NULL,
  `datebirth` date DEFAULT NULL,
  `document` varchar(11) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'registered' COMMENT 'registered, confirmed',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `level`, `forget`, `genre`, `datebirth`, `document`, `photo`, `status`, `created_at`, `updated_at`) VALUES
(1, 'usuario1', 'sistema', 'usuario1@sistema.com.br', '$2y$10$3UKvu5LgLUohd3nR9PSm4.geSKFhvJtUvIGjM.8Bv9ebmoTGhW8au', 1, NULL, NULL, NULL, NULL, NULL, 'registered', '2024-08-30 00:21:13', NULL),
(2, 'admin', 'sistema', 'admin@sistema.com.br', '$2y$10$g8RNrTLIA6oqwFRJmmWRAeG7jwL5i3LBK0DA2/SXYqHYC3rOGv5vm', 5, NULL, NULL, NULL, NULL, NULL, 'registered', '2024-08-30 01:20:36', NULL);

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
-- Índices de tabela `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `document` (`document`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `belts` (`belts`);

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
-- AUTO_INCREMENT de tabela `app_subscriptions`
--
ALTER TABLE `app_subscriptions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `app_wallets`
--
ALTER TABLE `app_wallets`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `belts`
--
ALTER TABLE `belts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `report_online`
--
ALTER TABLE `report_online`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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

--
-- Restrições para tabelas `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `student_ibfk_2` FOREIGN KEY (`belts`) REFERENCES `belts` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
