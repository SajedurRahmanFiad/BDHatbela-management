-- Softaculous SQL Dump
-- http://www.softaculous.com
--
-- Host: localhost
-- Generation Time: December 23, 2025, 7:43 am
-- Server version: 11.4.9
-- PHP Version: 8.3.27

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bdhatbela_akau925`
--

-- --------------------------------------------------------

--
-- Table structure for table `aku9_accounts`
--

CREATE TABLE `aku9_accounts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `type` varchar(191) NOT NULL DEFAULT 'bank',
  `name` varchar(191) NOT NULL,
  `number` varchar(191) NOT NULL,
  `currency_code` varchar(191) NOT NULL,
  `opening_balance` double(15,4) NOT NULL DEFAULT 0.0000,
  `bank_name` varchar(191) DEFAULT NULL,
  `bank_phone` varchar(191) DEFAULT NULL,
  `bank_address` text DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `created_from` varchar(100) DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aku9_accounts_company_id_index` (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `aku9_accounts`
--

INSERT INTO `aku9_accounts` VALUES
(1, 1, 'bank', 'Cash', '1', 'BDT', 0.0000, 'Cash', NULL, NULL, 1, 'core::seed', NULL, '2025-12-22 09:28:37', '2025-12-23 02:47:44', NULL),
(2, 2, 'bank', 'Cash', '1', 'BDT', 0.0000, 'Cash', NULL, NULL, 1, 'core::seed', 1, '2025-12-22 22:11:13', '2025-12-22 22:12:23', '2025-12-22 22:12:23');

-- --------------------------------------------------------

--
-- Table structure for table `aku9_categories`
--

CREATE TABLE `aku9_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `type` varchar(191) NOT NULL,
  `color` varchar(191) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `created_from` varchar(100) DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aku9_categories_company_id_index` (`company_id`),
  KEY `aku9_categories_parent_id_foreign` (`parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `aku9_categories`
--

INSERT INTO `aku9_categories` VALUES
(1, 1, 'Transfer', 'other', '#3c3f72', 1, NULL, 'core::seed', NULL, '2025-12-22 09:28:37', '2025-12-22 09:28:37', NULL),
(2, 1, 'Deposit', 'income', '#efad32', 1, NULL, 'core::seed', NULL, '2025-12-22 09:28:37', '2025-12-22 09:28:37', NULL),
(3, 1, 'Sales', 'income', '#6da252', 1, NULL, 'core::seed', NULL, '2025-12-22 09:28:37', '2025-12-22 09:28:37', NULL),
(4, 1, 'Other', 'expense', '#e5e5e5', 1, NULL, 'core::seed', NULL, '2025-12-22 09:28:37', '2025-12-22 09:28:37', NULL),
(5, 1, 'General', 'item', '#328aef', 1, NULL, 'core::seed', NULL, '2025-12-22 09:28:37', '2025-12-22 09:28:37', NULL),
(6, 1, 'Shipping Charge', 'item', 'indigo-900', 1, NULL, 'core::ui', 1, '2025-12-23 03:51:03', '2025-12-23 03:51:03', NULL),
(7, 2, 'Transfer', 'other', '#3c3f72', 1, NULL, 'core::seed', 1, '2025-12-22 22:11:13', '2025-12-22 22:12:23', '2025-12-22 22:12:23'),
(8, 2, 'Deposit', 'income', '#efad32', 1, NULL, 'core::seed', 1, '2025-12-22 22:11:13', '2025-12-22 22:12:23', '2025-12-22 22:12:23'),
(9, 2, 'Sales', 'income', '#6da252', 1, NULL, 'core::seed', 1, '2025-12-22 22:11:13', '2025-12-22 22:12:23', '2025-12-22 22:12:23'),
(10, 2, 'Other', 'expense', '#e5e5e5', 1, NULL, 'core::seed', 1, '2025-12-22 22:11:13', '2025-12-22 22:12:23', '2025-12-22 22:12:23'),
(11, 2, 'General', 'item', '#328aef', 1, NULL, 'core::seed', 1, '2025-12-22 22:11:13', '2025-12-22 22:12:23', '2025-12-22 22:12:23');

-- --------------------------------------------------------

--
-- Table structure for table `aku9_companies`
--

CREATE TABLE `aku9_companies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `domain` varchar(191) DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `created_from` varchar(100) DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `aku9_companies`
--

INSERT INTO `aku9_companies` VALUES
(1, '', 1, 'core::ui', NULL, '2025-12-22 09:28:37', '2025-12-22 09:28:37', NULL),
(2, NULL, 1, 'core::ui', 1, '2025-12-23 04:11:12', '2025-12-22 22:12:23', '2025-12-22 22:12:23');

-- --------------------------------------------------------

--
-- Table structure for table `aku9_contacts`
--

CREATE TABLE `aku9_contacts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `type` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `tax_number` varchar(191) DEFAULT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(191) DEFAULT NULL,
  `zip_code` varchar(191) DEFAULT NULL,
  `state` varchar(191) DEFAULT NULL,
  `country` varchar(191) DEFAULT NULL,
  `website` varchar(191) DEFAULT NULL,
  `currency_code` varchar(191) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `reference` varchar(191) DEFAULT NULL,
  `created_from` varchar(100) DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `aku9_contacts_company_id_type_email_deleted_at_unique` (`company_id`,`type`,`email`,`deleted_at`),
  KEY `aku9_contacts_company_id_type_index` (`company_id`,`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `aku9_contacts`
--

INSERT INTO `aku9_contacts` VALUES
(1, 1, 'customer', 'Md Sajedur Rahman Fiad', NULL, NULL, NULL, '01404020000', 'House# 20, Road# 13, Sector# 14, Uttara', 'Dhaka', '1230', 'Dhaka', 'BD', NULL, 'BDT', 1, NULL, 'core::ui', 1, '2025-12-22 20:35:08', '2025-12-22 20:35:08', NULL),
(2, 1, 'employee', 'Test', 'scientistfiad@gmail.com', 5, NULL, '01404020000', 'House# 20, Road# 13, Sector# 14, Uttara', 'Dhaka', '1230', NULL, 'BD', NULL, 'BDT', 1, NULL, 'employees::ui', 1, '2025-12-23 14:45:29', '2025-12-23 14:45:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `aku9_contact_persons`
--

CREATE TABLE `aku9_contact_persons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL,
  `type` varchar(191) NOT NULL,
  `contact_id` int(10) unsigned NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `created_from` varchar(100) DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aku9_contact_persons_company_id_index` (`company_id`),
  KEY `aku9_contact_persons_type_index` (`type`),
  KEY `aku9_contact_persons_contact_id_index` (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `aku9_currencies`
--

CREATE TABLE `aku9_currencies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `code` varchar(191) NOT NULL,
  `rate` double(15,8) NOT NULL,
  `precision` varchar(191) DEFAULT NULL,
  `symbol` varchar(191) DEFAULT NULL,
  `symbol_first` int(11) NOT NULL DEFAULT 1,
  `decimal_mark` varchar(191) DEFAULT NULL,
  `thousands_separator` varchar(191) DEFAULT NULL,
  `enabled` tinyint(4) NOT NULL DEFAULT 1,
  `created_from` varchar(100) DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `aku9_currencies_company_id_code_deleted_at_unique` (`company_id`,`code`,`deleted_at`),
  KEY `aku9_currencies_company_id_index` (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `aku9_currencies`
--

INSERT INTO `aku9_currencies` VALUES
(1, 1, 'US Dollar', 'USD', 1.00000000, '2', '$', 1, '.', ',', 1, 'core::seed', NULL, '2025-12-22 09:28:37', '2025-12-23 02:47:55', '2025-12-23 02:47:55'),
(2, 1, 'Bangladeshi Taka', 'BDT', 1.00000000, NULL, NULL, 1, NULL, NULL, 1, 'core::ui', 1, '2025-12-22 19:31:03', '2025-12-22 19:31:03', NULL),
(3, 2, 'US Dollar', 'USD', 1.00000000, '2', '$', 1, '.', ',', 1, 'core::seed', 1, '2025-12-22 22:11:13', '2025-12-22 22:12:23', '2025-12-22 22:12:23'),
(4, 2, 'Bangladeshi Taka', 'BDT', 1.00000000, '2', '৳', 1, '.', ',', 1, 'core::ui', 1, '2025-12-22 22:11:13', '2025-12-22 22:12:23', '2025-12-22 22:12:23');

-- --------------------------------------------------------

--
-- Table structure for table `aku9_dashboards`
--

CREATE TABLE `aku9_dashboards` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `created_from` varchar(100) DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aku9_dashboards_company_id_index` (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `aku9_dashboards`
--

INSERT INTO `aku9_dashboards` VALUES
(1, 1, 'Dashboard', 1, 'core::seed', NULL, '2025-12-22 09:28:37', '2025-12-23 14:41:15', '2025-12-23 14:41:15'),
(2, 1, 'HR', 1, 'employees::seed', NULL, '2025-12-22 19:37:44', '2025-12-23 13:24:08', '2025-12-23 13:24:08'),
(3, 1, 'Sales Metrics', 1, 'core::console', NULL, '2025-12-22 19:39:01', '2025-12-23 14:01:56', '2025-12-23 14:01:56'),
(4, 1, 'Admin Dashboard', 1, 'core::ui', 1, '2025-12-23 03:01:37', '2025-12-23 03:02:04', '2025-12-23 03:02:04'),
(5, 2, 'Dashboard', 1, 'core::seed', 1, '2025-12-22 22:11:13', '2025-12-22 22:12:23', '2025-12-22 22:12:23'),
(6, 1, 'Dashboard', 1, 'core::seed', 1, '2025-12-23 13:35:10', '2025-12-23 13:35:10', NULL),
(7, 1, 'Sales Metrics', 1, 'core::console', NULL, '2025-12-23 13:56:07', '2025-12-23 14:02:02', '2025-12-23 14:02:02'),
(8, 1, 'HR', 1, 'employees::seed', NULL, '2025-12-23 13:56:42', '2025-12-23 14:02:07', '2025-12-23 14:02:07'),
(9, 1, 'Dashboard', 1, 'core::ui', 1, '2025-12-23 14:02:17', '2025-12-23 14:02:17', NULL),
(10, 1, 'Dashboard', 1, 'core::seed', 1, '2025-12-23 14:11:39', '2025-12-23 14:11:39', NULL),
(11, 1, 'Dashboard', 1, 'core::seed', 1, '2025-12-23 14:40:38', '2025-12-23 14:40:38', NULL),
(12, 1, 'Dashboard', 1, 'core::seed', 1, '2025-12-23 14:45:28', '2025-12-23 14:45:28', NULL),
(13, 1, 'HR', 1, 'core::ui', 1, '2025-12-23 14:45:29', '2025-12-23 14:45:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `aku9_documents`
--

CREATE TABLE `aku9_documents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL,
  `type` varchar(191) NOT NULL,
  `document_number` varchar(191) NOT NULL,
  `order_number` varchar(191) DEFAULT NULL,
  `status` varchar(191) NOT NULL,
  `issued_at` datetime NOT NULL,
  `due_at` datetime NOT NULL,
  `amount` double(15,4) NOT NULL,
  `currency_code` varchar(191) NOT NULL,
  `currency_rate` double(15,8) NOT NULL,
  `discount_type` varchar(191) DEFAULT NULL,
  `discount_rate` double(15,4) DEFAULT NULL,
  `category_id` int(10) unsigned NOT NULL DEFAULT 1,
  `contact_id` int(10) unsigned NOT NULL,
  `contact_name` varchar(191) NOT NULL,
  `contact_email` varchar(191) DEFAULT NULL,
  `contact_tax_number` varchar(191) DEFAULT NULL,
  `contact_phone` varchar(191) DEFAULT NULL,
  `contact_address` text DEFAULT NULL,
  `contact_city` varchar(191) DEFAULT NULL,
  `contact_zip_code` varchar(191) DEFAULT NULL,
  `contact_state` varchar(191) DEFAULT NULL,
  `contact_country` varchar(191) DEFAULT NULL,
  `title` varchar(191) DEFAULT NULL,
  `subheading` varchar(191) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `footer` text DEFAULT NULL,
  `template` varchar(191) DEFAULT NULL,
  `color` varchar(191) DEFAULT NULL,
  `parent_id` int(10) unsigned NOT NULL DEFAULT 0,
  `created_from` varchar(100) DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `aku9_documents_document_number_deleted_at_company_id_type_unique` (`document_number`,`deleted_at`,`company_id`,`type`),
  KEY `aku9_documents_company_id_index` (`company_id`),
  KEY `aku9_documents_type_index` (`type`),
  KEY `aku9_documents_contact_id_index` (`contact_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `aku9_documents`
--

INSERT INTO `aku9_documents` VALUES
(1, 1, 'invoice', 'INV-00001', NULL, 'sent', '2025-12-22 20:37:17', '2025-12-22 20:37:17', 500.0000, 'BDT', 1.00000000, 'percentage', NULL, 2, 1, 'Md Sajedur Rahman Fiad', NULL, NULL, '01404020000', 'House# 20, Road# 13, Sector# 14, Uttara', 'Dhaka', '1230', 'Dhaka', 'BD', 'Invoice', NULL, NULL, NULL, 'default', '#55588b', 0, 'core::ui', 1, '2025-12-22 20:37:17', '2025-12-23 02:55:46', '2025-12-23 02:55:46'),
(2, 1, 'invoice', 'BDH-00002', NULL, 'paid', '2025-12-23 17:42:58', '2025-12-23 17:42:58', 560.0000, 'BDT', 1.00000000, 'percentage', NULL, 2, 1, 'Md Sajedur Rahman Fiad', NULL, NULL, '01404020000', 'House# 20, Road# 13, Sector# 14, Uttara', 'Dhaka', '1230', 'Dhaka', 'BD', 'Invoice', NULL, NULL, NULL, 'default', '#004264', 0, 'core::ui', 1, '2025-12-23 17:42:58', '2025-12-23 17:43:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `aku9_document_histories`
--

CREATE TABLE `aku9_document_histories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `type` varchar(191) NOT NULL,
  `document_id` int(10) unsigned NOT NULL,
  `status` varchar(191) NOT NULL,
  `notify` tinyint(1) NOT NULL,
  `description` text DEFAULT NULL,
  `created_from` varchar(100) DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aku9_document_histories_company_id_index` (`company_id`),
  KEY `aku9_document_histories_type_index` (`type`),
  KEY `aku9_document_histories_document_id_index` (`document_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `aku9_document_histories`
--

INSERT INTO `aku9_document_histories` VALUES
(1, 1, 'invoice', 1, 'draft', 0, 'INV-00001 added!', 'core::ui', 1, '2025-12-22 20:37:17', '2025-12-23 02:55:46', '2025-12-23 02:55:46'),
(2, 1, 'invoice', 1, 'paid', 0, '$500.00 Payment', 'core::ui', 1, '2025-12-22 20:38:21', '2025-12-23 02:55:46', '2025-12-23 02:55:46'),
(3, 1, 'invoice', 1, 'sent', 0, '$500.00 Payment deleted!', 'core::ui', 1, '2025-12-23 02:47:29', '2025-12-23 02:55:46', '2025-12-23 02:55:46'),
(4, 1, 'invoice', 2, 'draft', 0, 'BDH-00002 added!', 'core::ui', 1, '2025-12-23 17:42:58', '2025-12-23 17:42:58', NULL),
(5, 1, 'invoice', 2, 'sent', 0, 'Invoice marked as sent!', 'core::ui', 1, '2025-12-23 17:43:12', '2025-12-23 17:43:12', NULL),
(6, 1, 'invoice', 2, 'paid', 0, '৳560.00 Payment', 'core::ui', 1, '2025-12-23 17:43:41', '2025-12-23 17:43:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `aku9_document_items`
--

CREATE TABLE `aku9_document_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL,
  `type` varchar(191) NOT NULL,
  `document_id` int(10) unsigned NOT NULL,
  `item_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `sku` varchar(191) DEFAULT NULL,
  `quantity` double(7,2) NOT NULL,
  `price` double(15,4) NOT NULL,
  `tax` double(15,4) NOT NULL DEFAULT 0.0000,
  `discount_type` varchar(191) NOT NULL DEFAULT 'normal',
  `discount_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `total` double(15,4) NOT NULL,
  `created_from` varchar(100) DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aku9_document_items_company_id_index` (`company_id`),
  KEY `aku9_document_items_type_index` (`type`),
  KEY `aku9_document_items_document_id_index` (`document_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `aku9_document_items`
--

INSERT INTO `aku9_document_items` VALUES
(1, 1, 'invoice', 1, 1, 'Test', '', NULL, 1.00, 500.0000, 0.0000, 'undefined', 0.0000, 500.0000, 'core::ui', 1, '2025-12-22 20:37:17', '2025-12-23 02:55:46', '2025-12-23 02:55:46'),
(2, 1, 'invoice', 2, 1, 'Test', '', NULL, 1.00, 500.0000, 0.0000, 'undefined', 0.0000, 500.0000, 'core::ui', 1, '2025-12-23 17:42:58', '2025-12-23 17:42:58', NULL),
(3, 1, 'invoice', 2, 2, 'Shipping - Inside Dhaka', '', NULL, 1.00, 60.0000, 0.0000, 'undefined', 0.0000, 60.0000, 'core::ui', 1, '2025-12-23 17:42:58', '2025-12-23 17:42:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `aku9_document_item_taxes`
--

CREATE TABLE `aku9_document_item_taxes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL,
  `type` varchar(191) NOT NULL,
  `document_id` int(10) unsigned NOT NULL,
  `document_item_id` int(10) unsigned NOT NULL,
  `tax_id` int(10) unsigned NOT NULL,
  `name` varchar(191) NOT NULL,
  `amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `created_from` varchar(100) DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aku9_document_item_taxes_company_id_index` (`company_id`),
  KEY `aku9_document_item_taxes_type_index` (`type`),
  KEY `aku9_document_item_taxes_document_id_index` (`document_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `aku9_document_totals`
--

CREATE TABLE `aku9_document_totals` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL,
  `type` varchar(191) NOT NULL,
  `document_id` int(10) unsigned NOT NULL,
  `code` varchar(191) DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `amount` double(15,4) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `created_from` varchar(100) DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aku9_document_totals_company_id_index` (`company_id`),
  KEY `aku9_document_totals_type_index` (`type`),
  KEY `aku9_document_totals_document_id_index` (`document_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `aku9_document_totals`
--

INSERT INTO `aku9_document_totals` VALUES
(1, 1, 'invoice', 1, 'sub_total', 'invoices.sub_total', 500.0000, 1, 'core::ui', 1, '2025-12-22 20:37:17', '2025-12-23 02:55:46', '2025-12-23 02:55:46'),
(2, 1, 'invoice', 1, 'total', 'invoices.total', 500.0000, 2, 'core::ui', 1, '2025-12-22 20:37:17', '2025-12-23 02:55:46', '2025-12-23 02:55:46'),
(3, 1, 'invoice', 2, 'sub_total', 'invoices.sub_total', 560.0000, 1, 'core::ui', 1, '2025-12-23 17:42:58', '2025-12-23 17:42:58', NULL),
(4, 1, 'invoice', 2, 'total', 'invoices.total', 560.0000, 2, 'core::ui', 1, '2025-12-23 17:42:58', '2025-12-23 17:42:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `aku9_email_templates`
--

CREATE TABLE `aku9_email_templates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `alias` varchar(191) NOT NULL,
  `class` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `subject` varchar(191) NOT NULL,
  `body` text NOT NULL,
  `params` text DEFAULT NULL,
  `created_from` varchar(100) DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `aku9_email_templates_company_id_alias_deleted_at_unique` (`company_id`,`alias`,`deleted_at`),
  KEY `aku9_email_templates_company_id_index` (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `aku9_email_templates`
--

INSERT INTO `aku9_email_templates` VALUES
(1, 1, 'invoice_new_customer', 'App\\Notifications\\Sale\\Invoice', 'settings.email.templates.invoice_new_customer', '{invoice_number} invoice created', 'Dear {customer_name},<br /><br />We have prepared the following invoice for you: <strong>{invoice_number}</strong>.<br /><br />You can see the invoice details and proceed with the payment from the following link: <a href="{invoice_guest_link}">{invoice_number}</a>.<br /><br />Feel free to contact us with any questions.<br /><br />Best Regards,<br />{company_name}', NULL, 'core::seed', NULL, '2025-12-22 09:28:37', '2025-12-22 09:28:37', NULL),
(2, 1, 'invoice_remind_customer', 'App\\Notifications\\Sale\\Invoice', 'settings.email.templates.invoice_remind_customer', '{invoice_number} invoice overdue notice', 'Dear {customer_name},<br /><br />This is an overdue notice for <strong>{invoice_number}</strong> invoice.<br /><br />The invoice total is {invoice_total} and was due <strong>{invoice_due_date}</strong>.<br /><br />You can see the invoice details and proceed with the payment from the following link: <a href="{invoice_guest_link}">{invoice_number}</a>.<br /><br />Best Regards,<br />{company_name}', NULL, 'core::seed', NULL, '2025-12-22 09:28:37', '2025-12-22 09:28:37', NULL),
(3, 1, 'invoice_remind_admin', 'App\\Notifications\\Sale\\Invoice', 'settings.email.templates.invoice_remind_admin', '{invoice_number} invoice overdue notice', 'Hello,<br /><br />{customer_name} has received an overdue notice for <strong>{invoice_number}</strong> invoice.<br /><br />The invoice total is {invoice_total} and was due <strong>{invoice_due_date}</strong>.<br /><br />You can see the invoice details from the following link: <a href="{invoice_admin_link}">{invoice_number}</a>.<br /><br />Best Regards,<br />{company_name}', NULL, 'core::seed', NULL, '2025-12-22 09:28:37', '2025-12-22 09:28:37', NULL),
(4, 1, 'invoice_recur_customer', 'App\\Notifications\\Sale\\Invoice', 'settings.email.templates.invoice_recur_customer', '{invoice_number} recurring invoice created', 'Dear {customer_name},<br /><br />Based on your recurring circle, we have prepared the following invoice for you: <strong>{invoice_number}</strong>.<br /><br />You can see the invoice details and proceed with the payment from the following link: <a href="{invoice_guest_link}">{invoice_number}</a>.<br /><br />Feel free to contact us for any question.<br /><br />Best Regards,<br />{company_name}', NULL, 'core::seed', NULL, '2025-12-22 09:28:37', '2025-12-22 09:28:37', NULL),
(5, 1, 'invoice_recur_admin', 'App\\Notifications\\Sale\\Invoice', 'settings.email.templates.invoice_recur_admin', '{invoice_number} recurring invoice created', 'Hello,<br /><br />Based on {customer_name} recurring circle, <strong>{invoice_number}</strong> invoice has been automatically created.<br /><br />You can see the invoice details from the following link: <a href="{invoice_admin_link}">{invoice_number}</a>.<br /><br />Best Regards,<br />{company_name}', NULL, 'core::seed', NULL, '2025-12-22 09:28:37', '2025-12-22 09:28:37', NULL),
(6, 1, 'invoice_view_admin', 'App\\Notifications\\Sale\\Invoice', 'settings.email.templates.invoice_view_admin', '{invoice_number} invoice viewed', 'Hello,<br /><br />{customer_name} has viewed the <strong>{invoice_number}</strong> invoice.<br /><br />You can see the invoice details from the following link: <a href="{invoice_admin_link}">{invoice_number}</a>.<br /><br />Best Regards,<br />{company_name}', NULL, 'core::seed', NULL, '2025-12-22 09:28:37', '2025-12-22 09:28:37', NULL),
(7, 1, 'invoice_payment_customer', 'App\\Notifications\\Portal\\PaymentReceived', 'settings.email.templates.invoice_payment_customer', 'Payment received for {invoice_number} invoice', 'Dear {customer_name},<br /><br />Thank you for the payment. Find the payment details below:<br /><br />-------------------------------------------------<br />Amount: <strong>{transaction_total}</strong><br />Date: <strong>{transaction_paid_date}</strong><br />Invoice Number: <strong>{invoice_number}</strong><br />-------------------------------------------------<br /><br />You can always see the invoice details from the following link: <a href="{invoice_guest_link}">{invoice_number}</a>.<br /><br />Feel free to contact us for any question.<br /><br />Best Regards,<br />{company_name}', NULL, 'core::seed', NULL, '2025-12-22 09:28:37', '2025-12-22 09:28:37', NULL),
(8, 1, 'invoice_payment_admin', 'App\\Notifications\\Portal\\PaymentReceived', 'settings.email.templates.invoice_payment_admin', 'Payment received for {invoice_number} invoice', 'Hello,<br /><br />{customer_name} recorded a payment for <strong>{invoice_number}</strong> invoice.<br /><br />You can see the invoice details from the following link: <a href="{invoice_admin_link}">{invoice_number}</a>.<br /><br />Best Regards,<br />{company_name}', NULL, 'core::seed', NULL, '2025-12-22 09:28:37', '2025-12-22 09:28:37', NULL),
(9, 1, 'bill_remind_admin', 'App\\Notifications\\Purchase\\Bill', 'settings.email.templates.bill_remind_admin', '{bill_number} bill reminding notice', 'Hello,<br /><br />This is a reminding notice for <strong>{bill_number}</strong> bill to {vendor_name}.<br /><br />The bill total is {bill_total} and is due <strong>{bill_due_date}</strong>.<br /><br />You can see the bill details from the following link: <a href="{bill_admin_link}">{bill_number}</a>.<br /><br />Best Regards,<br />{company_name}', NULL, 'core::seed', NULL, '2025-12-22 09:28:37', '2025-12-22 09:28:37', NULL),
(10, 1, 'bill_recur_admin', 'App\\Notifications\\Purchase\\Bill', 'settings.email.templates.bill_recur_admin', '{bill_number} recurring bill created', 'Hello,<br /><br />Based on {vendor_name} recurring circle, <strong>{bill_number}</strong> invoice has been automatically created.<br /><br />You can see the bill details from the following link: <a href="{bill_admin_link}">{bill_number}</a>.<br /><br />Best Regards,<br />{company_name}', NULL, 'core::seed', NULL, '2025-12-22 09:28:37', '2025-12-22 09:28:37', NULL),
(11, 1, 'payment_received_customer', 'App\\Notifications\\Banking\\Transaction', 'settings.email.templates.payment_received_customer', 'Your receipt from {company_name}', 'Dear {contact_name},<br /><br />Thank you for the payment. <br /><br />You can see the payment details from the following link: <a href="{payment_guest_link}">{payment_date}</a>.<br /><br />Feel free to contact us with any questions.<br /><br />Best Regards,<br />{company_name}', NULL, 'core::seed', NULL, '2025-12-22 09:28:37', '2025-12-22 09:28:37', NULL),
(12, 1, 'payment_made_vendor', 'App\\Notifications\\Banking\\Transaction', 'settings.email.templates.payment_made_vendor', 'Payment made by {company_name}', 'Dear {contact_name},<br /><br />We have made the following payment. <br /><br />You can see the payment details from the following link: <a href="{payment_guest_link}">{payment_date}</a>.<br /><br />Feel free to contact us with any questions.<br /><br />Best Regards,<br />{company_name}', NULL, 'core::seed', NULL, '2025-12-22 09:28:37', '2025-12-22 09:28:37', NULL),
(13, 2, 'invoice_new_customer', 'App\\Notifications\\Sale\\Invoice', 'settings.email.templates.invoice_new_customer', '{invoice_number} invoice created', 'Dear {customer_name},<br /><br />We have prepared the following invoice for you: <strong>{invoice_number}</strong>.<br /><br />You can see the invoice details and proceed with the payment from the following link: <a href="{invoice_guest_link}">{invoice_number}</a>.<br /><br />Feel free to contact us with any questions.<br /><br />Best Regards,<br />{company_name}', NULL, 'core::seed', 1, '2025-12-22 22:11:13', '2025-12-22 22:12:23', '2025-12-22 22:12:23'),
(14, 2, 'invoice_remind_customer', 'App\\Notifications\\Sale\\Invoice', 'settings.email.templates.invoice_remind_customer', '{invoice_number} invoice overdue notice', 'Dear {customer_name},<br /><br />This is an overdue notice for <strong>{invoice_number}</strong> invoice.<br /><br />The invoice total is {invoice_total} and was due <strong>{invoice_due_date}</strong>.<br /><br />You can see the invoice details and proceed with the payment from the following link: <a href="{invoice_guest_link}">{invoice_number}</a>.<br /><br />Best Regards,<br />{company_name}', NULL, 'core::seed', 1, '2025-12-22 22:11:13', '2025-12-22 22:12:23', '2025-12-22 22:12:23'),
(15, 2, 'invoice_remind_admin', 'App\\Notifications\\Sale\\Invoice', 'settings.email.templates.invoice_remind_admin', '{invoice_number} invoice overdue notice', 'Hello,<br /><br />{customer_name} has received an overdue notice for <strong>{invoice_number}</strong> invoice.<br /><br />The invoice total is {invoice_total} and was due <strong>{invoice_due_date}</strong>.<br /><br />You can see the invoice details from the following link: <a href="{invoice_admin_link}">{invoice_number}</a>.<br /><br />Best Regards,<br />{company_name}', NULL, 'core::seed', 1, '2025-12-22 22:11:13', '2025-12-22 22:12:23', '2025-12-22 22:12:23'),
(16, 2, 'invoice_recur_customer', 'App\\Notifications\\Sale\\Invoice', 'settings.email.templates.invoice_recur_customer', '{invoice_number} recurring invoice created', 'Dear {customer_name},<br /><br />Based on your recurring circle, we have prepared the following invoice for you: <strong>{invoice_number}</strong>.<br /><br />You can see the invoice details and proceed with the payment from the following link: <a href="{invoice_guest_link}">{invoice_number}</a>.<br /><br />Feel free to contact us for any question.<br /><br />Best Regards,<br />{company_name}', NULL, 'core::seed', 1, '2025-12-22 22:11:13', '2025-12-22 22:12:23', '2025-12-22 22:12:23'),
(17, 2, 'invoice_recur_admin', 'App\\Notifications\\Sale\\Invoice', 'settings.email.templates.invoice_recur_admin', '{invoice_number} recurring invoice created', 'Hello,<br /><br />Based on {customer_name} recurring circle, <strong>{invoice_number}</strong> invoice has been automatically created.<br /><br />You can see the invoice details from the following link: <a href="{invoice_admin_link}">{invoice_number}</a>.<br /><br />Best Regards,<br />{company_name}', NULL, 'core::seed', 1, '2025-12-22 22:11:13', '2025-12-22 22:12:23', '2025-12-22 22:12:23'),
(18, 2, 'invoice_view_admin', 'App\\Notifications\\Sale\\Invoice', 'settings.email.templates.invoice_view_admin', '{invoice_number} invoice viewed', 'Hello,<br /><br />{customer_name} has viewed the <strong>{invoice_number}</strong> invoice.<br /><br />You can see the invoice details from the following link: <a href="{invoice_admin_link}">{invoice_number}</a>.<br /><br />Best Regards,<br />{company_name}', NULL, 'core::seed', 1, '2025-12-22 22:11:13', '2025-12-22 22:12:23', '2025-12-22 22:12:23'),
(19, 2, 'invoice_payment_customer', 'App\\Notifications\\Portal\\PaymentReceived', 'settings.email.templates.invoice_payment_customer', 'Payment received for {invoice_number} invoice', 'Dear {customer_name},<br /><br />Thank you for the payment. Find the payment details below:<br /><br />-------------------------------------------------<br />Amount: <strong>{transaction_total}</strong><br />Date: <strong>{transaction_paid_date}</strong><br />Invoice Number: <strong>{invoice_number}</strong><br />-------------------------------------------------<br /><br />You can always see the invoice details from the following link: <a href="{invoice_guest_link}">{invoice_number}</a>.<br /><br />Feel free to contact us for any question.<br /><br />Best Regards,<br />{company_name}', NULL, 'core::seed', 1, '2025-12-22 22:11:13', '2025-12-22 22:12:23', '2025-12-22 22:12:23'),
(20, 2, 'invoice_payment_admin', 'App\\Notifications\\Portal\\PaymentReceived', 'settings.email.templates.invoice_payment_admin', 'Payment received for {invoice_number} invoice', 'Hello,<br /><br />{customer_name} recorded a payment for <strong>{invoice_number}</strong> invoice.<br /><br />You can see the invoice details from the following link: <a href="{invoice_admin_link}">{invoice_number}</a>.<br /><br />Best Regards,<br />{company_name}', NULL, 'core::seed', 1, '2025-12-22 22:11:13', '2025-12-22 22:12:23', '2025-12-22 22:12:23'),
(21, 2, 'bill_remind_admin', 'App\\Notifications\\Purchase\\Bill', 'settings.email.templates.bill_remind_admin', '{bill_number} bill reminding notice', 'Hello,<br /><br />This is a reminding notice for <strong>{bill_number}</strong> bill to {vendor_name}.<br /><br />The bill total is {bill_total} and is due <strong>{bill_due_date}</strong>.<br /><br />You can see the bill details from the following link: <a href="{bill_admin_link}">{bill_number}</a>.<br /><br />Best Regards,<br />{company_name}', NULL, 'core::seed', 1, '2025-12-22 22:11:13', '2025-12-22 22:12:23', '2025-12-22 22:12:23'),
(22, 2, 'bill_recur_admin', 'App\\Notifications\\Purchase\\Bill', 'settings.email.templates.bill_recur_admin', '{bill_number} recurring bill created', 'Hello,<br /><br />Based on {vendor_name} recurring circle, <strong>{bill_number}</strong> invoice has been automatically created.<br /><br />You can see the bill details from the following link: <a href="{bill_admin_link}">{bill_number}</a>.<br /><br />Best Regards,<br />{company_name}', NULL, 'core::seed', 1, '2025-12-22 22:11:13', '2025-12-22 22:12:23', '2025-12-22 22:12:23'),
(23, 2, 'payment_received_customer', 'App\\Notifications\\Banking\\Transaction', 'settings.email.templates.payment_received_customer', 'Your receipt from {company_name}', 'Dear {contact_name},<br /><br />Thank you for the payment. <br /><br />You can see the payment details from the following link: <a href="{payment_guest_link}">{payment_date}</a>.<br /><br />Feel free to contact us with any questions.<br /><br />Best Regards,<br />{company_name}', NULL, 'core::seed', 1, '2025-12-22 22:11:13', '2025-12-22 22:12:23', '2025-12-22 22:12:23'),
(24, 2, 'payment_made_vendor', 'App\\Notifications\\Banking\\Transaction', 'settings.email.templates.payment_made_vendor', 'Payment made by {company_name}', 'Dear {contact_name},<br /><br />We have made the following payment. <br /><br />You can see the payment details from the following link: <a href="{payment_guest_link}">{payment_date}</a>.<br /><br />Feel free to contact us with any questions.<br /><br />Best Regards,<br />{company_name}', NULL, 'core::seed', 1, '2025-12-22 22:11:13', '2025-12-22 22:12:23', '2025-12-22 22:12:23');

-- --------------------------------------------------------

--
-- Table structure for table `aku9_employees_departments`
--

CREATE TABLE `aku9_employees_departments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `manager_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `aku9_employees_positions_company_id_name_deleted_at_unique` (`company_id`,`name`,`deleted_at`),
  KEY `aku9_employees_positions_company_id_index` (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `aku9_employees_departments`
--

INSERT INTO `aku9_employees_departments` VALUES
(1, 1, 'Sales', 4, NULL, NULL, 1, '2025-12-23 14:45:09', '2025-12-23 14:45:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `aku9_employees_dismissals`
--

CREATE TABLE `aku9_employees_dismissals` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `type` varchar(191) NOT NULL,
  `dismissal_date` date NOT NULL,
  `reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `aku9_employees_dismissals_company_id_deleted_at_unique` (`company_id`,`deleted_at`),
  KEY `aku9_employees_dismissals_company_id_index` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `aku9_employees_employees`
--

CREATE TABLE `aku9_employees_employees` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `birth_day` date NOT NULL,
  `gender` varchar(191) NOT NULL,
  `department_id` int(11) NOT NULL DEFAULT 1,
  `amount` double(15,4) NOT NULL,
  `salary_type` varchar(191) DEFAULT NULL,
  `hired_at` date NOT NULL,
  `bank_account_number` varchar(191) DEFAULT NULL,
  `dismissed` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `aku9_employees_employees_company_id_contact_id_deleted_at_unique` (`company_id`,`contact_id`,`deleted_at`),
  KEY `aku9_employees_employees_company_id_contact_id_index` (`company_id`,`contact_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `aku9_employees_employees`
--

INSERT INTO `aku9_employees_employees` VALUES
(1, 1, 2, '2025-12-23', 'male', 1, 5000.0000, 'monthly', '2025-12-23', NULL, 0, '2025-12-23 14:45:29', '2025-12-23 14:45:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `aku9_failed_jobs`
--

CREATE TABLE `aku9_failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) DEFAULT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `aku9_failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `aku9_firewall_ips`
--

CREATE TABLE `aku9_firewall_ips` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(191) NOT NULL,
  `log_id` int(11) DEFAULT NULL,
  `blocked` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `aku9_firewall_ips_ip_deleted_at_unique` (`ip`,`deleted_at`),
  KEY `aku9_firewall_ips_ip_index` (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `aku9_firewall_logs`
--

CREATE TABLE `aku9_firewall_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(191) NOT NULL,
  `level` varchar(191) NOT NULL DEFAULT 'medium',
  `middleware` varchar(191) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `url` varchar(191) DEFAULT NULL,
  `referrer` varchar(191) DEFAULT NULL,
  `request` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aku9_firewall_logs_ip_index` (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `aku9_items`
--

CREATE TABLE `aku9_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `type` varchar(191) NOT NULL DEFAULT 'product',
  `name` varchar(191) NOT NULL,
  `sku` varchar(191) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `sale_price` double DEFAULT NULL,
  `purchase_price` double DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `created_from` varchar(100) DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aku9_items_company_id_index` (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `aku9_items`
--

INSERT INTO `aku9_items` VALUES
(1, 1, 'product', 'Test', NULL, NULL, 500, 300, 5, 1, 'core::ui', 1, '2025-12-22 20:35:42', '2025-12-22 20:35:42', NULL),
(2, 1, 'service', 'Shipping - Inside Dhaka', NULL, NULL, 60, 60, 6, 1, 'core::ui', 1, '2025-12-23 03:51:29', '2025-12-23 17:44:44', NULL),
(3, 1, 'service', 'Shipping - Outside Dhaka', NULL, NULL, 110, 110, 6, 1, 'core::ui', 1, '2025-12-23 03:51:48', '2025-12-23 17:44:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `aku9_item_taxes`
--

CREATE TABLE `aku9_item_taxes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `created_from` varchar(100) DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aku9_item_taxes_company_id_item_id_index` (`company_id`,`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `aku9_jobs`
--

CREATE TABLE `aku9_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `aku9_jobs_queue_reserved_at_index` (`queue`,`reserved_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `aku9_media`
--

CREATE TABLE `aku9_media` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL DEFAULT 0,
  `disk` varchar(32) NOT NULL,
  `directory` varchar(191) NOT NULL,
  `filename` varchar(191) NOT NULL,
  `extension` varchar(32) NOT NULL,
  `mime_type` varchar(128) NOT NULL,
  `aggregate_type` varchar(32) NOT NULL,
  `size` int(10) unsigned NOT NULL,
  `variant_name` varchar(255) DEFAULT NULL,
  `original_media_id` int(10) unsigned DEFAULT NULL,
  `created_from` varchar(100) DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `aku9_media_disk_directory_filename_extension_unique` (`disk`,`directory`,`filename`,`extension`),
  UNIQUE KEY `aku9_media_disk_directory_filename_extension_deleted_at_unique` (`disk`,`directory`,`filename`,`extension`,`deleted_at`),
  KEY `aku9_media_aggregate_type_index` (`aggregate_type`),
  KEY `aku9_media_disk_directory_index` (`disk`,`directory`),
  KEY `aku9_media_company_id_index` (`company_id`),
  KEY `original_media_id` (`original_media_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `aku9_media`
--

INSERT INTO `aku9_media` VALUES
(1, 1, 'uploads', '2025/12/23/1/settings', 'icon', 'png', 'image/png', 'image', 262752, NULL, NULL, '::ui', 1, '2025-12-23 02:40:23', '2025-12-23 02:40:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `aku9_mediables`
--

CREATE TABLE `aku9_mediables` (
  `media_id` int(10) unsigned NOT NULL,
  `company_id` int(10) unsigned NOT NULL DEFAULT 0,
  `mediable_type` varchar(191) NOT NULL,
  `mediable_id` int(10) unsigned NOT NULL,
  `tag` varchar(191) NOT NULL,
  `order` int(10) unsigned NOT NULL,
  `created_from` varchar(100) DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`media_id`,`mediable_type`,`mediable_id`,`tag`),
  KEY `aku9_mediables_mediable_id_mediable_type_index` (`mediable_id`,`mediable_type`),
  KEY `aku9_mediables_tag_index` (`tag`),
  KEY `aku9_mediables_order_index` (`order`),
  KEY `aku9_mediables_company_id_index` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `aku9_mediables`
--

INSERT INTO `aku9_mediables` VALUES
(1, 1, 'App\\Models\\Common\\Company', 1, 'company.logo', 1, '::ui', 1);

-- --------------------------------------------------------

--
-- Table structure for table `aku9_migrations`
--

CREATE TABLE `aku9_migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `aku9_migrations`
--

INSERT INTO `aku9_migrations` VALUES
(1, '2016_06_27_000000_create_mediable_tables', 1),
(2, '2017_09_14_000000_core_v1', 1),
(3, '2019_11_16_000000_core_v2', 1),
(4, '2020_10_12_000000_add_variants_to_media', 1),
(5, '2022_05_10_000000_core_v300', 1),
(6, '2022_06_28_000000_core_v304', 1),
(7, '2022_07_21_000000_core_v305', 1),
(8, '2022_08_29_000000_core_v3015', 1),
(9, '2022_08_29_000000_core_v307', 1),
(10, '2023_06_22_000000_core_v3016', 1),
(11, '2023_08_14_000000_core_v3017', 1),
(12, '2023_10_03_000000_core_v310', 1),
(13, '2024_09_26_000000_core_v3112', 1),
(14, '2024_12_29_000000_core_v3115', 1),
(15, '2020_12_23_081739_employees_v1', 2),
(16, '2022_07_01_081739_employees_v2', 2),
(17, '2022_12_21_081739_employees_v2010', 2),
(18, '2024_11_15_081739_employees_v2023', 2),
(19, '2024_11_20_081739_employees_v2024', 2);

-- --------------------------------------------------------

--
-- Table structure for table `aku9_modules`
--

CREATE TABLE `aku9_modules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `alias` varchar(191) NOT NULL,
  `enabled` int(11) NOT NULL,
  `created_from` varchar(100) DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `aku9_modules_company_id_alias_deleted_at_unique` (`company_id`,`alias`,`deleted_at`),
  KEY `aku9_modules_company_id_index` (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `aku9_modules`
--

INSERT INTO `aku9_modules` VALUES
(1, 1, 'offline-payments', 1, '::ui', NULL, '2025-12-22 09:28:37', '2025-12-22 09:28:37', NULL),
(2, 1, 'paypal-standard', 1, '::ui', NULL, '2025-12-22 09:28:37', '2025-12-22 09:28:37', NULL),
(3, 1, 'employees', 1, '::console', NULL, '2025-12-22 19:37:41', '2025-12-23 13:24:08', '2025-12-23 13:24:08'),
(4, 1, 'sales-metrics', 1, '::console', NULL, '2025-12-22 19:39:01', '2025-12-23 13:24:09', '2025-12-23 13:24:09'),
(5, 2, 'offline-payments', 1, '::ui', 1, '2025-12-22 22:11:13', '2025-12-22 22:12:23', '2025-12-22 22:12:23'),
(6, 2, 'paypal-standard', 1, '::ui', 1, '2025-12-22 22:11:13', '2025-12-22 22:12:23', '2025-12-22 22:12:23'),
(7, 1, 'sales-metrics', 1, '::console', NULL, '2025-12-23 13:56:07', '2025-12-23 13:56:07', NULL),
(8, 1, 'employees', 1, '::console', NULL, '2025-12-23 13:56:42', '2025-12-23 13:56:42', NULL),
(9, 1, 'receivables-payables', 1, '::console', NULL, '2025-12-23 13:58:00', '2025-12-23 13:58:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `aku9_module_histories`
--

CREATE TABLE `aku9_module_histories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `version` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `created_from` varchar(100) DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aku9_module_histories_company_id_module_id_index` (`company_id`,`module_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `aku9_module_histories`
--

INSERT INTO `aku9_module_histories` VALUES
(1, 1, 1, '3.0.4', 'offline-payments installed', '::ui', NULL, '2025-12-22 09:28:37', '2025-12-22 09:28:37', NULL),
(2, 1, 2, '3.0.1', 'paypal-standard installed', '::ui', NULL, '2025-12-22 09:28:37', '2025-12-22 09:28:37', NULL),
(3, 1, 3, '2.0.29', 'employees installed', '::console', NULL, '2025-12-22 19:37:41', '2025-12-22 19:37:41', NULL),
(4, 1, 4, '3.0.2', 'sales-metrics installed', '::console', NULL, '2025-12-22 19:39:01', '2025-12-22 19:39:01', NULL),
(5, 2, 5, '3.0.4', 'offline-payments installed', '::ui', 1, '2025-12-22 22:11:13', '2025-12-22 22:12:23', '2025-12-22 22:12:23'),
(6, 2, 6, '3.0.1', 'paypal-standard installed', '::ui', 1, '2025-12-22 22:11:13', '2025-12-22 22:12:23', '2025-12-22 22:12:23'),
(7, 1, 3, '2.0.29', 'employees uninstalled', '::console', NULL, '2025-12-23 13:24:08', '2025-12-23 13:24:08', NULL),
(8, 1, 4, '3.0.2', 'sales-metrics uninstalled', '::console', NULL, '2025-12-23 13:24:09', '2025-12-23 13:24:09', NULL),
(9, 1, 7, '3.0.2', 'sales-metrics installed', '::console', NULL, '2025-12-23 13:56:07', '2025-12-23 13:56:07', NULL),
(10, 1, 8, '2.0.29', 'employees installed', '::console', NULL, '2025-12-23 13:56:42', '2025-12-23 13:56:42', NULL),
(11, 1, 9, '2.0.4', 'receivables-payables installed', '::console', NULL, '2025-12-23 13:58:00', '2025-12-23 13:58:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `aku9_notifications`
--

CREATE TABLE `aku9_notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(191) NOT NULL,
  `notifiable_type` varchar(191) NOT NULL,
  `notifiable_id` bigint(20) unsigned NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aku9_notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `aku9_password_resets`
--

CREATE TABLE `aku9_password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `aku9_password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `aku9_permissions`
--

CREATE TABLE `aku9_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `display_name` varchar(191) NOT NULL,
  `description` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `aku9_permissions_name_unique` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `aku9_permissions`
--

INSERT INTO `aku9_permissions` VALUES
(1, 'read-admin-panel', 'Read Admin Panel', 'Read Admin Panel', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(2, 'read-api', 'Read Api', 'Read Api', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(3, 'read-auth-profile', 'Read Auth Profile', 'Read Auth Profile', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(4, 'update-auth-profile', 'Update Auth Profile', 'Update Auth Profile', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(5, 'create-auth-users', 'Create Auth Users', 'Create Auth Users', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(6, 'read-auth-users', 'Read Auth Users', 'Read Auth Users', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(7, 'update-auth-users', 'Update Auth Users', 'Update Auth Users', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(8, 'delete-auth-users', 'Delete Auth Users', 'Delete Auth Users', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(9, 'create-banking-accounts', 'Create Banking Accounts', 'Create Banking Accounts', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(10, 'read-banking-accounts', 'Read Banking Accounts', 'Read Banking Accounts', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(11, 'update-banking-accounts', 'Update Banking Accounts', 'Update Banking Accounts', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(12, 'delete-banking-accounts', 'Delete Banking Accounts', 'Delete Banking Accounts', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(13, 'create-banking-reconciliations', 'Create Banking Reconciliations', 'Create Banking Reconciliations', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(14, 'read-banking-reconciliations', 'Read Banking Reconciliations', 'Read Banking Reconciliations', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(15, 'update-banking-reconciliations', 'Update Banking Reconciliations', 'Update Banking Reconciliations', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(16, 'delete-banking-reconciliations', 'Delete Banking Reconciliations', 'Delete Banking Reconciliations', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(17, 'create-banking-transactions', 'Create Banking Transactions', 'Create Banking Transactions', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(18, 'read-banking-transactions', 'Read Banking Transactions', 'Read Banking Transactions', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(19, 'update-banking-transactions', 'Update Banking Transactions', 'Update Banking Transactions', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(20, 'delete-banking-transactions', 'Delete Banking Transactions', 'Delete Banking Transactions', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(21, 'create-banking-transfers', 'Create Banking Transfers', 'Create Banking Transfers', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(22, 'read-banking-transfers', 'Read Banking Transfers', 'Read Banking Transfers', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(23, 'update-banking-transfers', 'Update Banking Transfers', 'Update Banking Transfers', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(24, 'delete-banking-transfers', 'Delete Banking Transfers', 'Delete Banking Transfers', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(25, 'create-common-companies', 'Create Common Companies', 'Create Common Companies', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(26, 'read-common-companies', 'Read Common Companies', 'Read Common Companies', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(27, 'update-common-companies', 'Update Common Companies', 'Update Common Companies', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(28, 'delete-common-companies', 'Delete Common Companies', 'Delete Common Companies', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(29, 'create-common-dashboards', 'Create Common Dashboards', 'Create Common Dashboards', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(30, 'read-common-dashboards', 'Read Common Dashboards', 'Read Common Dashboards', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(31, 'update-common-dashboards', 'Update Common Dashboards', 'Update Common Dashboards', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(32, 'delete-common-dashboards', 'Delete Common Dashboards', 'Delete Common Dashboards', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(33, 'create-common-import', 'Create Common Import', 'Create Common Import', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(34, 'create-common-items', 'Create Common Items', 'Create Common Items', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(35, 'read-common-items', 'Read Common Items', 'Read Common Items', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(36, 'update-common-items', 'Update Common Items', 'Update Common Items', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(37, 'delete-common-items', 'Delete Common Items', 'Delete Common Items', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(38, 'create-common-reports', 'Create Common Reports', 'Create Common Reports', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(39, 'read-common-reports', 'Read Common Reports', 'Read Common Reports', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(40, 'update-common-reports', 'Update Common Reports', 'Update Common Reports', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(41, 'delete-common-reports', 'Delete Common Reports', 'Delete Common Reports', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(42, 'read-common-search', 'Read Common Search', 'Read Common Search', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(43, 'read-common-uploads', 'Read Common Uploads', 'Read Common Uploads', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(44, 'delete-common-uploads', 'Delete Common Uploads', 'Delete Common Uploads', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(45, 'create-common-widgets', 'Create Common Widgets', 'Create Common Widgets', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(46, 'read-common-widgets', 'Read Common Widgets', 'Read Common Widgets', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(47, 'update-common-widgets', 'Update Common Widgets', 'Update Common Widgets', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(48, 'delete-common-widgets', 'Delete Common Widgets', 'Delete Common Widgets', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(49, 'create-purchases-bills', 'Create Purchases Bills', 'Create Purchases Bills', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(50, 'read-purchases-bills', 'Read Purchases Bills', 'Read Purchases Bills', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(51, 'update-purchases-bills', 'Update Purchases Bills', 'Update Purchases Bills', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(52, 'delete-purchases-bills', 'Delete Purchases Bills', 'Delete Purchases Bills', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(53, 'create-purchases-vendors', 'Create Purchases Vendors', 'Create Purchases Vendors', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(54, 'read-purchases-vendors', 'Read Purchases Vendors', 'Read Purchases Vendors', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(55, 'update-purchases-vendors', 'Update Purchases Vendors', 'Update Purchases Vendors', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(56, 'delete-purchases-vendors', 'Delete Purchases Vendors', 'Delete Purchases Vendors', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(57, 'create-sales-customers', 'Create Sales Customers', 'Create Sales Customers', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(58, 'read-sales-customers', 'Read Sales Customers', 'Read Sales Customers', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(59, 'update-sales-customers', 'Update Sales Customers', 'Update Sales Customers', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(60, 'delete-sales-customers', 'Delete Sales Customers', 'Delete Sales Customers', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(61, 'create-sales-invoices', 'Create Sales Invoices', 'Create Sales Invoices', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(62, 'read-sales-invoices', 'Read Sales Invoices', 'Read Sales Invoices', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(63, 'update-sales-invoices', 'Update Sales Invoices', 'Update Sales Invoices', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(64, 'delete-sales-invoices', 'Delete Sales Invoices', 'Delete Sales Invoices', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(65, 'read-install-updates', 'Read Install Updates', 'Read Install Updates', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(66, 'update-install-updates', 'Update Install Updates', 'Update Install Updates', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(67, 'create-modules-api-key', 'Create Modules Api Key', 'Create Modules Api Key', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(68, 'update-modules-api-key', 'Update Modules Api Key', 'Update Modules Api Key', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(69, 'read-modules-home', 'Read Modules Home', 'Read Modules Home', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(70, 'create-modules-item', 'Create Modules Item', 'Create Modules Item', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(71, 'read-modules-item', 'Read Modules Item', 'Read Modules Item', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(72, 'update-modules-item', 'Update Modules Item', 'Update Modules Item', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(73, 'delete-modules-item', 'Delete Modules Item', 'Delete Modules Item', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(74, 'read-modules-my', 'Read Modules My', 'Read Modules My', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(75, 'read-modules-tiles', 'Read Modules Tiles', 'Read Modules Tiles', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(76, 'read-notifications', 'Read Notifications', 'Read Notifications', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(77, 'update-notifications', 'Update Notifications', 'Update Notifications', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(78, 'read-reports-expense-summary', 'Read Reports Expense Summary', 'Read Reports Expense Summary', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(79, 'read-reports-income-summary', 'Read Reports Income Summary', 'Read Reports Income Summary', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(80, 'read-reports-income-expense-summary', 'Read Reports Income Expense Summary', 'Read Reports Income Expense Summary', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(81, 'read-reports-profit-loss', 'Read Reports Profit Loss', 'Read Reports Profit Loss', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(82, 'read-reports-tax-summary', 'Read Reports Tax Summary', 'Read Reports Tax Summary', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(83, 'read-reports-discount-summary', 'Read Reports Discount Summary', 'Read Reports Discount Summary', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(84, 'create-settings-categories', 'Create Settings Categories', 'Create Settings Categories', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(85, 'read-settings-categories', 'Read Settings Categories', 'Read Settings Categories', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(86, 'update-settings-categories', 'Update Settings Categories', 'Update Settings Categories', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(87, 'delete-settings-categories', 'Delete Settings Categories', 'Delete Settings Categories', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(88, 'read-settings-company', 'Read Settings Company', 'Read Settings Company', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(89, 'update-settings-company', 'Update Settings Company', 'Update Settings Company', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(90, 'create-settings-currencies', 'Create Settings Currencies', 'Create Settings Currencies', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(91, 'read-settings-currencies', 'Read Settings Currencies', 'Read Settings Currencies', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(92, 'update-settings-currencies', 'Update Settings Currencies', 'Update Settings Currencies', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(93, 'delete-settings-currencies', 'Delete Settings Currencies', 'Delete Settings Currencies', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(94, 'read-settings-defaults', 'Read Settings Defaults', 'Read Settings Defaults', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(95, 'update-settings-defaults', 'Update Settings Defaults', 'Update Settings Defaults', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(96, 'read-settings-email', 'Read Settings Email', 'Read Settings Email', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(97, 'update-settings-email', 'Update Settings Email', 'Update Settings Email', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(98, 'read-settings-email-templates', 'Read Settings Email Templates', 'Read Settings Email Templates', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(99, 'update-settings-email-templates', 'Update Settings Email Templates', 'Update Settings Email Templates', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(100, 'read-settings-invoice', 'Read Settings Invoice', 'Read Settings Invoice', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(101, 'update-settings-invoice', 'Update Settings Invoice', 'Update Settings Invoice', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(102, 'read-settings-localisation', 'Read Settings Localisation', 'Read Settings Localisation', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(103, 'update-settings-localisation', 'Update Settings Localisation', 'Update Settings Localisation', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(104, 'read-settings-modules', 'Read Settings Modules', 'Read Settings Modules', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(105, 'update-settings-modules', 'Update Settings Modules', 'Update Settings Modules', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(106, 'read-settings-schedule', 'Read Settings Schedule', 'Read Settings Schedule', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(107, 'update-settings-schedule', 'Update Settings Schedule', 'Update Settings Schedule', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(108, 'create-settings-taxes', 'Create Settings Taxes', 'Create Settings Taxes', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(109, 'read-settings-taxes', 'Read Settings Taxes', 'Read Settings Taxes', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(110, 'update-settings-taxes', 'Update Settings Taxes', 'Update Settings Taxes', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(111, 'delete-settings-taxes', 'Delete Settings Taxes', 'Delete Settings Taxes', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(112, 'read-widgets-account-balance', 'Read Widgets Account Balance', 'Read Widgets Account Balance', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(113, 'read-widgets-bank-feeds', 'Read Widgets Bank Feeds', 'Read Widgets Bank Feeds', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(114, 'read-widgets-cash-flow', 'Read Widgets Cash Flow', 'Read Widgets Cash Flow', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(115, 'read-widgets-currencies', 'Read Widgets Currencies', 'Read Widgets Currencies', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(116, 'read-widgets-expenses-by-category', 'Read Widgets Expenses By Category', 'Read Widgets Expenses By Category', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(117, 'read-widgets-payables', 'Read Widgets Payables', 'Read Widgets Payables', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(118, 'read-widgets-profit-loss', 'Read Widgets Profit Loss', 'Read Widgets Profit Loss', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(119, 'read-widgets-receivables', 'Read Widgets Receivables', 'Read Widgets Receivables', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(120, 'read-client-portal', 'Read Client Portal', 'Read Client Portal', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(121, 'read-portal-invoices', 'Read Portal Invoices', 'Read Portal Invoices', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(122, 'update-portal-invoices', 'Update Portal Invoices', 'Update Portal Invoices', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(123, 'read-portal-payments', 'Read Portal Payments', 'Read Portal Payments', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(124, 'update-portal-payments', 'Update Portal Payments', 'Update Portal Payments', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(125, 'read-portal-profile', 'Read Portal Profile', 'Read Portal Profile', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(126, 'update-portal-profile', 'Update Portal Profile', 'Update Portal Profile', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(127, 'read-offline-payments-settings', 'Read Offline Payments Settings', 'Read Offline Payments Settings', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(128, 'update-offline-payments-settings', 'Update Offline Payments Settings', 'Update Offline Payments Settings', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(129, 'delete-offline-payments-settings', 'Delete Offline Payments Settings', 'Delete Offline Payments Settings', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(130, 'read-paypal-standard-settings', 'Read PayPal Standard Settings', 'Read PayPal Standard Settings', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(131, 'update-paypal-standard-settings', 'Update PayPal Standard Settings', 'Update PayPal Standard Settings', '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(132, 'read-employees-widgets-number-of-employees', 'Read Employees Widgets Number of Employees', 'Read Employees Widgets Number of Employees', '2025-12-22 19:37:42', '2025-12-22 19:37:42'),
(133, 'read-employees-widgets-employee-age', 'Read Employees Widgets Employee Age', 'Read Employees Widgets Employee Age', '2025-12-22 19:37:42', '2025-12-22 19:37:42'),
(134, 'read-employees-widgets-employee-gender', 'Read Employees Widgets Employee Gender', 'Read Employees Widgets Employee Gender', '2025-12-22 19:37:42', '2025-12-22 19:37:42'),
(135, 'read-employees-widgets-employee-profile', 'Read Employees Widgets Employee Profile', 'Read Employees Widgets Employee Profile', '2025-12-22 19:37:42', '2025-12-22 19:37:42'),
(136, 'create-employees-employees', 'Create Employees Employees', 'Create Employees Employees', '2025-12-22 19:37:42', '2025-12-22 19:37:42'),
(137, 'read-employees-employees', 'Read Employees Employees', 'Read Employees Employees', '2025-12-22 19:37:42', '2025-12-22 19:37:42'),
(138, 'update-employees-employees', 'Update Employees Employees', 'Update Employees Employees', '2025-12-22 19:37:43', '2025-12-22 19:37:43'),
(139, 'delete-employees-employees', 'Delete Employees Employees', 'Delete Employees Employees', '2025-12-22 19:37:43', '2025-12-22 19:37:43'),
(140, 'create-employees-departments', 'Create Employees Departments', 'Create Employees Departments', '2025-12-22 19:37:43', '2025-12-22 19:37:43'),
(141, 'read-employees-departments', 'Read Employees Departments', 'Read Employees Departments', '2025-12-22 19:37:43', '2025-12-22 19:37:43'),
(142, 'update-employees-departments', 'Update Employees Departments', 'Update Employees Departments', '2025-12-22 19:37:43', '2025-12-22 19:37:43'),
(143, 'delete-employees-departments', 'Delete Employees Departments', 'Delete Employees Departments', '2025-12-22 19:37:43', '2025-12-22 19:37:43'),
(144, 'create-employees-dismissals', 'Create Employees Dismissals', 'Create Employees Dismissals', '2025-12-22 19:37:43', '2025-12-22 19:37:43'),
(145, 'read-employees-dismissals', 'Read Employees Dismissals', 'Read Employees Dismissals', '2025-12-22 19:37:43', '2025-12-22 19:37:43'),
(146, 'update-employees-dismissals', 'Update Employees Dismissals', 'Update Employees Dismissals', '2025-12-22 19:37:43', '2025-12-22 19:37:43'),
(147, 'delete-employees-dismissals', 'Delete Employees Dismissals', 'Delete Employees Dismissals', '2025-12-22 19:37:43', '2025-12-22 19:37:43'),
(148, 'create-employees-settings', 'Create Employees Settings', 'Create Employees Settings', '2025-12-22 19:37:43', '2025-12-22 19:37:43'),
(149, 'read-employees-settings', 'Read Employees Settings', 'Read Employees Settings', '2025-12-22 19:37:43', '2025-12-22 19:37:43'),
(150, 'update-employees-settings', 'Update Employees Settings', 'Update Employees Settings', '2025-12-22 19:37:43', '2025-12-22 19:37:43'),
(151, 'delete-employees-settings', 'Delete Employees Settings', 'Delete Employees Settings', '2025-12-22 19:37:43', '2025-12-22 19:37:43'),
(152, 'read-sales-metrics-widgets-top-customers-revenue-based', 'Read Sales Metrics Widgets Top 5 Customers Revenue Based', 'Read Sales Metrics Widgets Top 5 Customers Revenue Based', '2025-12-22 19:39:01', '2025-12-22 19:39:01'),
(153, 'read-sales-metrics-widgets-top-customers-profit-based', 'Read Sales Metrics Widgets Top 5 Customers Profit Based', 'Read Sales Metrics Widgets Top 5 Customers Profit Based', '2025-12-22 19:39:01', '2025-12-22 19:39:01'),
(154, 'read-sales-metrics-widgets-top-items-revenue-based', 'Read Sales Metrics Widgets Top 5 Items Revenue Based', 'Read Sales Metrics Widgets Top 5 Items Revenue Based', '2025-12-22 19:39:01', '2025-12-22 19:39:01'),
(155, 'read-sales-metrics-widgets-top-items-profit-based', 'Read Sales Metrics Widgets Top 5 Items Profit Based', 'Read Sales Metrics Widgets Top 5 Items Profit Based', '2025-12-22 19:39:01', '2025-12-22 19:39:01'),
(156, 'read-sales-metrics-widgets-top-items-profit-margin-based', 'Read Sales Metrics Widgets Top 5 Items Profit Margin Based', 'Read Sales Metrics Widgets Top 5 Items Profit Margin Based', '2025-12-22 19:39:01', '2025-12-22 19:39:01'),
(157, 'read-receivables-payables-widgets-closest-receivables', 'Read Receivables & Payables Widgets Closest Receivables', 'Read Receivables & Payables Widgets Closest Receivables', '2025-12-23 13:58:00', '2025-12-23 13:58:00'),
(158, 'read-receivables-payables-widgets-closest-payables', 'Read Receivables & Payables Widgets Closest Payables', 'Read Receivables & Payables Widgets Closest Payables', '2025-12-23 13:58:00', '2025-12-23 13:58:00');

-- --------------------------------------------------------

--
-- Table structure for table `aku9_personal_access_tokens`
--

CREATE TABLE `aku9_personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `aku9_personal_access_tokens_token_unique` (`token`),
  KEY `aku9_personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `aku9_reconciliations`
--

CREATE TABLE `aku9_reconciliations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `started_at` datetime NOT NULL,
  `ended_at` datetime NOT NULL,
  `closing_balance` double(15,4) NOT NULL DEFAULT 0.0000,
  `transactions` text DEFAULT NULL,
  `reconciled` tinyint(1) NOT NULL,
  `created_from` varchar(100) DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aku9_reconciliations_company_id_index` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `aku9_recurring`
--

CREATE TABLE `aku9_recurring` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `recurable_type` varchar(191) NOT NULL,
  `recurable_id` bigint(20) unsigned NOT NULL,
  `frequency` varchar(191) NOT NULL,
  `interval` int(11) NOT NULL DEFAULT 1,
  `started_at` datetime NOT NULL,
  `status` varchar(191) NOT NULL DEFAULT 'active',
  `limit_by` varchar(191) NOT NULL DEFAULT 'count',
  `limit_count` int(11) NOT NULL DEFAULT 0,
  `limit_date` datetime DEFAULT NULL,
  `auto_send` tinyint(1) NOT NULL DEFAULT 1,
  `created_from` varchar(100) DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aku9_recurring_recurable_type_recurable_id_index` (`recurable_type`,`recurable_id`),
  KEY `aku9_recurring_company_id_index` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `aku9_reports`
--

CREATE TABLE `aku9_reports` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `class` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` text NOT NULL,
  `settings` text DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_from` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aku9_reports_company_id_index` (`company_id`),
  KEY `aku9_reports_class_index` (`class`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `aku9_reports`
--

INSERT INTO `aku9_reports` VALUES
(1, 1, 'App\\Reports\\IncomeSummary', 'Income Summary', 'Monthly income summary by category.', '{"group":"category","period":"monthly","basis":"accrual"}', NULL, 'core::seed', '2025-12-22 09:28:37', '2025-12-22 09:28:37', NULL),
(2, 1, 'App\\Reports\\ExpenseSummary', 'Expense Summary', 'Monthly expense summary by category.', '{"group":"category","period":"monthly","basis":"accrual"}', NULL, 'core::seed', '2025-12-22 09:28:37', '2025-12-22 09:28:37', NULL),
(3, 1, 'App\\Reports\\IncomeExpenseSummary', 'Income vs Expense', 'Monthly income vs expense by category.', '{"group":"category","period":"monthly","basis":"accrual"}', NULL, 'core::seed', '2025-12-22 09:28:37', '2025-12-22 09:28:37', NULL),
(4, 1, 'App\\Reports\\ProfitLoss', 'Profit & Loss', 'Quarterly profit & loss by category.', '{"group":"category","period":"quarterly","basis":"accrual"}', NULL, 'core::seed', '2025-12-22 09:28:37', '2025-12-22 09:28:37', NULL),
(5, 1, 'App\\Reports\\TaxSummary', 'Tax Summary', 'Quarterly tax summary.', '{"period":"quarterly","basis":"accrual"}', NULL, 'core::seed', '2025-12-22 09:28:37', '2025-12-22 09:28:37', NULL),
(6, 2, 'App\\Reports\\IncomeSummary', 'Income Summary', 'Monthly income summary by category.', '{"group":"category","period":"monthly","basis":"accrual"}', 1, 'core::seed', '2025-12-22 22:11:13', '2025-12-22 22:12:23', '2025-12-22 22:12:23'),
(7, 2, 'App\\Reports\\ExpenseSummary', 'Expense Summary', 'Monthly expense summary by category.', '{"group":"category","period":"monthly","basis":"accrual"}', 1, 'core::seed', '2025-12-22 22:11:13', '2025-12-22 22:12:23', '2025-12-22 22:12:23'),
(8, 2, 'App\\Reports\\IncomeExpenseSummary', 'Income vs Expense', 'Monthly income vs expense by category.', '{"group":"category","period":"monthly","basis":"accrual"}', 1, 'core::seed', '2025-12-22 22:11:13', '2025-12-22 22:12:23', '2025-12-22 22:12:23'),
(9, 2, 'App\\Reports\\ProfitLoss', 'Profit & Loss', 'Quarterly profit & loss by category.', '{"group":"category","period":"quarterly","basis":"accrual"}', 1, 'core::seed', '2025-12-22 22:11:13', '2025-12-22 22:12:23', '2025-12-22 22:12:23'),
(10, 2, 'App\\Reports\\TaxSummary', 'Tax Summary', 'Quarterly tax summary.', '{"period":"quarterly","basis":"accrual"}', 1, 'core::seed', '2025-12-22 22:11:13', '2025-12-22 22:12:23', '2025-12-22 22:12:23');

-- --------------------------------------------------------

--
-- Table structure for table `aku9_roles`
--

CREATE TABLE `aku9_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `display_name` varchar(191) NOT NULL,
  `description` varchar(191) DEFAULT NULL,
  `created_from` varchar(100) DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `aku9_roles_name_unique` (`name`),
  KEY `aku9_roles_name_index` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `aku9_roles`
--

INSERT INTO `aku9_roles` VALUES
(1, 'admin', 'Admin', 'They get full access to your Akaunting including customers, invoices, reports, settings, and apps.', NULL, NULL, '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(2, 'manager', 'Manager', 'They get full access to your Akaunting, but can''t manage users and apps.', NULL, NULL, '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(3, 'customer', 'Customer', 'They can access the Client Portal and pay their invoices online through the payment methods you set up.', NULL, NULL, '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(4, 'accountant', 'Accountant', 'They can access invoices, transactions, reports, and create journal entries.', NULL, NULL, '2025-12-22 09:28:37', '2025-12-22 09:28:37'),
(5, 'employee', 'Employee', 'They can create expense claims and track time for assigned projects, but can only see their own information.', NULL, NULL, '2025-12-22 19:37:42', '2025-12-22 19:37:42');

-- --------------------------------------------------------

--
-- Table structure for table `aku9_role_permissions`
--

CREATE TABLE `aku9_role_permissions` (
  `role_id` int(10) unsigned NOT NULL,
  `permission_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`permission_id`),
  KEY `aku9_role_permissions_permission_id_foreign` (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `aku9_role_permissions`
--

INSERT INTO `aku9_role_permissions` VALUES
(1, 1),
(2, 1),
(4, 1),
(5, 1),
(1, 2),
(4, 2),
(1, 3),
(2, 3),
(4, 3),
(1, 4),
(2, 4),
(4, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(2, 9),
(1, 10),
(2, 10),
(4, 10),
(1, 11),
(2, 11),
(1, 12),
(2, 12),
(1, 13),
(2, 13),
(1, 14),
(2, 14),
(4, 14),
(1, 15),
(2, 15),
(1, 16),
(2, 16),
(1, 17),
(2, 17),
(1, 18),
(2, 18),
(4, 18),
(1, 19),
(2, 19),
(1, 20),
(2, 20),
(1, 21),
(2, 21),
(1, 22),
(2, 22),
(4, 22),
(1, 23),
(2, 23),
(1, 24),
(2, 24),
(1, 25),
(2, 25),
(1, 26),
(2, 26),
(1, 27),
(2, 27),
(1, 28),
(2, 28),
(1, 29),
(2, 29),
(5, 29),
(1, 30),
(2, 30),
(4, 30),
(5, 30),
(1, 31),
(2, 31),
(5, 31),
(1, 32),
(2, 32),
(5, 32),
(1, 33),
(2, 33),
(1, 34),
(2, 34),
(5, 34),
(1, 35),
(2, 35),
(4, 35),
(5, 35),
(1, 36),
(2, 36),
(1, 37),
(2, 37),
(1, 38),
(2, 38),
(1, 39),
(2, 39),
(4, 39),
(1, 40),
(2, 40),
(1, 41),
(2, 41),
(1, 42),
(2, 42),
(5, 42),
(1, 43),
(2, 43),
(1, 44),
(1, 45),
(2, 45),
(5, 45),
(1, 46),
(2, 46),
(5, 46),
(1, 47),
(2, 47),
(5, 47),
(1, 48),
(2, 48),
(5, 48),
(1, 49),
(2, 49),
(1, 50),
(2, 50),
(4, 50),
(1, 51),
(2, 51),
(1, 52),
(2, 52),
(1, 53),
(2, 53),
(5, 53),
(1, 54),
(2, 54),
(4, 54),
(5, 54),
(1, 55),
(2, 55),
(1, 56),
(2, 56),
(1, 57),
(2, 57),
(1, 58),
(2, 58),
(4, 58),
(1, 59),
(2, 59),
(1, 60),
(2, 60),
(1, 61),
(2, 61),
(1, 62),
(2, 62),
(4, 62),
(1, 63),
(2, 63),
(1, 64),
(2, 64),
(1, 65),
(2, 65),
(1, 66),
(2, 66),
(1, 67),
(1, 68),
(1, 69),
(4, 69),
(1, 70),
(1, 71),
(4, 71),
(1, 72),
(1, 73),
(1, 74),
(4, 74),
(1, 75),
(4, 75),
(1, 76),
(2, 76),
(1, 77),
(2, 77),
(1, 78),
(2, 78),
(4, 78),
(1, 79),
(2, 79),
(4, 79),
(1, 80),
(2, 80),
(4, 80),
(1, 81),
(2, 81),
(4, 81),
(1, 82),
(2, 82),
(4, 82),
(1, 83),
(2, 83),
(4, 83),
(1, 84),
(2, 84),
(1, 85),
(2, 85),
(1, 86),
(2, 86),
(1, 87),
(2, 87),
(1, 88),
(2, 88),
(1, 89),
(2, 89),
(1, 90),
(2, 90),
(1, 91),
(2, 91),
(1, 92),
(2, 92),
(1, 93),
(2, 93),
(1, 94),
(2, 94),
(1, 95),
(2, 95),
(1, 96),
(2, 96),
(1, 97),
(2, 97),
(1, 98),
(2, 98),
(1, 99),
(2, 99),
(1, 100),
(2, 100),
(1, 101),
(2, 101),
(1, 102),
(2, 102),
(1, 103),
(2, 103),
(1, 104),
(2, 104),
(1, 105),
(2, 105),
(1, 106),
(2, 106),
(1, 107),
(2, 107),
(1, 108),
(2, 108),
(5, 108),
(1, 109),
(2, 109),
(5, 109),
(1, 110),
(2, 110),
(1, 111),
(2, 111),
(1, 112),
(2, 112),
(4, 112),
(1, 113),
(2, 113),
(4, 113),
(1, 114),
(2, 114),
(4, 114),
(1, 115),
(2, 115),
(4, 115),
(1, 116),
(2, 116),
(4, 116),
(1, 117),
(2, 117),
(4, 117),
(1, 118),
(2, 118),
(4, 118),
(1, 119),
(2, 119),
(4, 119),
(3, 120),
(3, 121),
(3, 122),
(3, 123),
(3, 124),
(3, 125),
(3, 126),
(1, 127),
(2, 127),
(1, 128),
(2, 128),
(1, 129),
(2, 129),
(1, 130),
(2, 130),
(1, 131),
(2, 131),
(1, 132),
(2, 132),
(1, 133),
(2, 133),
(1, 134),
(2, 134),
(5, 135),
(1, 136),
(2, 136),
(1, 137),
(2, 137),
(1, 138),
(2, 138),
(1, 139),
(2, 139),
(1, 140),
(2, 140),
(1, 141),
(2, 141),
(1, 142),
(2, 142),
(1, 143),
(2, 143),
(1, 144),
(2, 144),
(1, 145),
(2, 145),
(1, 146),
(2, 146),
(1, 147),
(2, 147),
(1, 148),
(2, 148),
(1, 149),
(2, 149),
(1, 150),
(2, 150),
(1, 151),
(2, 151),
(1, 152),
(2, 152),
(1, 153),
(2, 153),
(1, 154),
(2, 154),
(1, 155),
(2, 155),
(1, 156),
(2, 156),
(1, 157),
(2, 157),
(1, 158),
(2, 158);

-- --------------------------------------------------------

--
-- Table structure for table `aku9_sessions`
--

CREATE TABLE `aku9_sessions` (
  `id` varchar(191) NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` text NOT NULL,
  `last_activity` int(11) NOT NULL,
  UNIQUE KEY `aku9_sessions_id_unique` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `aku9_settings`
--

CREATE TABLE `aku9_settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `key` varchar(191) NOT NULL,
  `value` text DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `aku9_settings_company_id_key_deleted_at_unique` (`company_id`,`key`,`deleted_at`),
  KEY `aku9_settings_company_id_index` (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `aku9_settings`
--

INSERT INTO `aku9_settings` VALUES
(1, 1, 'invoice.title', 'Invoice', NULL),
(2, 1, 'default.locale', 'en-US', NULL),
(3, 1, 'default.account', '1', NULL),
(4, 1, 'default.income_category', '2', NULL),
(5, 1, 'default.expense_category', '4', NULL),
(6, 1, 'wizard.completed', '1', NULL),
(7, 1, 'offline-payments.methods', '[{"code":"offline-payments.cash.1","name":"Cash","customer":"0","order":"1","description":null},{"code":"offline-payments.bank_transfer.2","name":"Bank Transfer","customer":"0","order":"2","description":null}]', NULL),
(8, 1, 'company.name', 'BD Hatbela', NULL),
(9, 1, 'company.email', 'bdhatbela@gmail.com', NULL),
(10, 1, 'company.country', 'BD', NULL),
(11, 1, 'apps.api_key', '4e39c8cf-d064-440a-a9dc-2d99e0892878', NULL),
(12, 1, 'default.currency', 'BDT', NULL),
(13, 1, 'employees.default_role_id', '5', NULL),
(14, 1, 'notifications.1.e-invoice-be', '1', NULL),
(15, 1, 'invoice.number_next', '3', NULL),
(16, 1, 'transaction.number_next', '3', NULL),
(17, 1, 'localisation.timezone', 'Asia/Dhaka', NULL),
(18, 1, 'company.phone', '+8801932194823', NULL),
(19, 1, 'company.city', 'Dhaka', NULL),
(20, 1, 'company.zip_code', '1230', NULL),
(21, 1, 'company.address', 'House# 21, Road# 02, Sector# 09, Uttara', NULL),
(22, 1, 'company.logo', '1', NULL),
(23, 1, 'invoice.hide_item_description', '1', NULL),
(24, 1, 'invoice.hide_amount', '0', NULL),
(25, 1, 'invoice.color', 'blue-800', NULL),
(26, 1, 'invoice._template', 'default', NULL),
(27, 1, 'invoice.message_name_or_description_required', 'Your invoice must show at least one of the <b>Name</b> or <b>Description</b>.', NULL),
(28, 1, 'invoice.temp_payment_term', '0', NULL),
(29, 1, 'invoice.number_prefix', 'BDH-', NULL),
(30, 1, 'default.address_format', '{city} - {zip_code} \r\n{country}', NULL),
(31, 1, 'invoice.item_name', 'settings.invoice.product', NULL),
(32, 2, 'invoice.title', 'Invoice', '2025-12-22 22:12:23'),
(33, 2, 'default.currency', 'BDT', '2025-12-22 22:12:23'),
(34, 2, 'default.account', '2', '2025-12-22 22:12:23'),
(35, 2, 'default.income_category', '8', '2025-12-22 22:12:23'),
(36, 2, 'default.expense_category', '10', '2025-12-22 22:12:23'),
(37, 2, 'wizard.completed', '1', '2025-12-22 22:12:23'),
(38, 2, 'offline-payments.methods', '[{"code":"offline-payments.cash.1","name":"Cash","customer":"0","order":"1","description":null},{"code":"offline-payments.bank_transfer.2","name":"Bank Transfer","customer":"0","order":"2","description":null}]', '2025-12-22 22:12:23'),
(39, 2, 'company.name', 'CROSS International', '2025-12-22 22:12:23'),
(40, 2, 'company.email', 'crossintbd@gmail.com', '2025-12-22 22:12:23'),
(41, 2, 'company.country', 'BD', '2025-12-22 22:12:23');

-- --------------------------------------------------------

--
-- Table structure for table `aku9_taxes`
--

CREATE TABLE `aku9_taxes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `rate` double(15,4) NOT NULL,
  `type` varchar(191) NOT NULL DEFAULT 'normal',
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `created_from` varchar(100) DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aku9_taxes_company_id_index` (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `aku9_taxes`
--

INSERT INTO `aku9_taxes` VALUES
(1, 1, 'Shipping - Inside Dhaka', 60.0000, 'normal', 1, 'core::ui', 1, '2025-12-22 20:36:46', '2025-12-23 02:44:13', '2025-12-23 02:44:13');

-- --------------------------------------------------------

--
-- Table structure for table `aku9_transactions`
--

CREATE TABLE `aku9_transactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `type` varchar(191) NOT NULL,
  `number` varchar(191) NOT NULL,
  `paid_at` datetime NOT NULL,
  `amount` double(15,4) NOT NULL,
  `currency_code` varchar(191) NOT NULL,
  `currency_rate` double(15,8) NOT NULL,
  `account_id` int(11) NOT NULL,
  `document_id` int(11) DEFAULT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `category_id` int(11) NOT NULL DEFAULT 1,
  `description` text DEFAULT NULL,
  `payment_method` varchar(191) NOT NULL,
  `reference` varchar(191) DEFAULT NULL,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `split_id` int(10) unsigned DEFAULT NULL,
  `reconciled` tinyint(1) NOT NULL DEFAULT 0,
  `created_from` varchar(100) DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aku9_transactions_company_id_type_index` (`company_id`,`type`),
  KEY `aku9_transactions_account_id_index` (`account_id`),
  KEY `aku9_transactions_category_id_index` (`category_id`),
  KEY `aku9_transactions_contact_id_index` (`contact_id`),
  KEY `aku9_transactions_document_id_index` (`document_id`),
  KEY `aku9_transactions_split_id_foreign` (`split_id`),
  KEY `aku9_transactions_number_index` (`number`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `aku9_transactions`
--

INSERT INTO `aku9_transactions` VALUES
(1, 1, 'income', 'TRA-00001', '2025-12-22 20:38:21', 500.0000, 'USD', 1.00000000, 1, 1, 1, 2, NULL, 'offline-payments.cash.1', NULL, 0, NULL, 0, 'core::ui', 1, '2025-12-22 20:38:21', '2025-12-23 02:47:29', '2025-12-23 02:47:29'),
(2, 1, 'income', 'TRA-00002', '2025-12-23 17:43:41', 560.0000, 'BDT', 1.00000000, 1, 2, 1, 2, NULL, 'offline-payments.cash.1', NULL, 0, NULL, 0, 'core::ui', 1, '2025-12-23 17:43:41', '2025-12-23 17:43:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `aku9_transaction_taxes`
--

CREATE TABLE `aku9_transaction_taxes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL,
  `type` varchar(191) NOT NULL,
  `transaction_id` int(10) unsigned NOT NULL,
  `tax_id` int(10) unsigned NOT NULL,
  `name` varchar(191) NOT NULL,
  `amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `created_from` varchar(100) DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aku9_transaction_taxes_company_id_index` (`company_id`),
  KEY `aku9_transaction_taxes_type_index` (`type`),
  KEY `aku9_transaction_taxes_transaction_id_index` (`transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `aku9_transfers`
--

CREATE TABLE `aku9_transfers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `expense_transaction_id` int(11) NOT NULL,
  `income_transaction_id` int(11) NOT NULL,
  `created_from` varchar(100) DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aku9_transfers_company_id_index` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `aku9_users`
--

CREATE TABLE `aku9_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `last_logged_in_at` timestamp NULL DEFAULT NULL,
  `locale` varchar(191) NOT NULL DEFAULT 'en-US',
  `landing_page` varchar(70) DEFAULT 'dashboard',
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `created_from` varchar(100) DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `aku9_users_email_deleted_at_unique` (`email`,`deleted_at`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `aku9_users`
--

INSERT INTO `aku9_users` VALUES
(1, 'Fiad', 'sajedurrahmanfiad@gmail.com', '$2y$10$vdTF4qK2C25uW6CU0oH7becmlhFFu0oIleF/ADi6E94Sxc/.l/Ldq', 'MZdPHCDa9DTWflPBapfY5VtQ7peIm9oCOuSgp4OoxHVzgATxEEN7RnR7T9no', '2025-12-23 11:41:48', 'en-US', 'dashboard', 1, 'core::ui', NULL, '2025-12-22 09:28:37', '2025-12-23 11:41:48', NULL),
(2, 'Test', 'scientistfiad@gmail.com', '$2y$10$hqoEX45nU3M2Y8FC7eruPOtHDwweeMxK4eo1K50I.E9LAHWiotoz2', 'EPFpLDY1n9jazpLQDRw6UJ7Jir8SSwxtKt2wIbyzllY3WPggyyJEy9WtVD8a', '2025-12-23 07:37:13', 'en-US', 'dashboard', 1, 'core::ui', 1, '2025-12-23 13:35:10', '2025-12-23 14:35:37', '2025-12-23 14:35:37'),
(3, 'Shamim Ahmed', 'shamimback1194@gmail.com', '$2y$10$tG2.ZL.xI3j7MPRP3GGiZu1O6TgTpIsbMJsMZFgEr6zNY6E2f64Zu', NULL, NULL, 'en-US', 'dashboard', 1, 'core::ui', 1, '2025-12-23 14:11:38', '2025-12-23 14:40:16', '2025-12-23 14:40:16'),
(4, 'Shamim Ahmed', 'shamimback1194@gmail.com', '$2y$10$E.9B7vpFCN9HA8z054ZVreDUwoH8hl.Fpg5CPi5O6f5MVXNfX.jgu', 'LXTcjXMRdmn4AA8UrBQqvpEYlTxknPIgcSrEZVqrDXFdCeRDgBge1pM9Iemd', '2025-12-23 11:47:00', 'en-US', 'dashboard', 1, 'core::ui', 1, '2025-12-23 14:40:38', '2025-12-23 11:47:00', NULL),
(5, 'Test', 'scientistfiad@gmail.com', '$2y$10$shkQ/VwJj90ct4imJu3LTee40vKpw4tEzmV3PYI/aJl7IBpM8E5a2', 'JpZjCwo9Hmyz164Hh6baLW6pPc0KoJMlaE12ECCqq6ZGHtFhpJv629sR9avH', '2025-12-23 11:46:52', 'en-US', 'dashboard', 1, 'employees::ui', 1, '2025-12-23 14:45:28', '2025-12-23 11:46:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `aku9_user_companies`
--

CREATE TABLE `aku9_user_companies` (
  `user_id` int(10) unsigned NOT NULL,
  `company_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`company_id`),
  KEY `aku9_user_companies_user_id_index` (`user_id`),
  KEY `aku9_user_companies_company_id_index` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `aku9_user_companies`
--

INSERT INTO `aku9_user_companies` VALUES
(1, 1),
(1, 2),
(2, 1),
(3, 1),
(4, 1),
(5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `aku9_user_dashboards`
--

CREATE TABLE `aku9_user_dashboards` (
  `user_id` int(10) unsigned NOT NULL,
  `dashboard_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`dashboard_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `aku9_user_dashboards`
--

INSERT INTO `aku9_user_dashboards` VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 7),
(1, 8),
(1, 9),
(2, 1),
(2, 6),
(2, 7),
(2, 8),
(3, 10),
(4, 9),
(4, 11),
(5, 12),
(5, 13);

-- --------------------------------------------------------

--
-- Table structure for table `aku9_user_invitations`
--

CREATE TABLE `aku9_user_invitations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_from` varchar(100) DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `aku9_user_invitations`
--

INSERT INTO `aku9_user_invitations` VALUES
(1, 2, 'cf661c85-8f72-4c6f-aabf-7ab42debe5b6', 'core::ui', 1, '2025-12-23 13:35:10', '2025-12-23 07:37:13', '2025-12-23 07:37:13'),
(2, 3, '7e999820-d1af-42b9-8d37-4084a10b8364', 'core::ui', 1, '2025-12-23 14:11:39', '2025-12-23 14:40:16', '2025-12-23 14:40:16'),
(3, 4, '1781da31-226b-42b4-8e84-baf4e3de4330', 'core::ui', 1, '2025-12-23 14:40:39', '2025-12-23 08:41:36', '2025-12-23 08:41:36'),
(4, 5, 'b049f48f-9e20-4f72-bdb8-13c31f576f35', 'core::ui', 1, '2025-12-23 14:45:29', '2025-12-23 08:46:05', '2025-12-23 08:46:05');

-- --------------------------------------------------------

--
-- Table structure for table `aku9_user_permissions`
--

CREATE TABLE `aku9_user_permissions` (
  `user_id` int(10) unsigned NOT NULL,
  `permission_id` int(10) unsigned NOT NULL,
  `user_type` varchar(191) NOT NULL,
  PRIMARY KEY (`user_id`,`permission_id`,`user_type`),
  KEY `aku9_user_permissions_permission_id_foreign` (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `aku9_user_roles`
--

CREATE TABLE `aku9_user_roles` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  KEY `aku9_user_roles_user_id_index` (`user_id`),
  KEY `aku9_user_roles_role_id_index` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `aku9_user_roles`
--

INSERT INTO `aku9_user_roles` VALUES
(1, 1),
(2, 2),
(3, 1),
(4, 1),
(5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `aku9_widgets`
--

CREATE TABLE `aku9_widgets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `dashboard_id` int(11) NOT NULL,
  `class` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT 0,
  `settings` text DEFAULT NULL,
  `created_from` varchar(100) DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aku9_widgets_company_id_dashboard_id_index` (`company_id`,`dashboard_id`),
  KEY `aku9_widgets_class_index` (`class`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `aku9_widgets`
--

INSERT INTO `aku9_widgets` VALUES
(1, 1, 1, 'App\\Widgets\\Receivables', 'Receivables', 1, '{"width":"50"}', 'core::seed', NULL, '2025-12-22 09:28:37', '2025-12-23 14:41:15', '2025-12-23 14:41:15'),
(2, 1, 1, 'Modules\\Employees\\Widgets\\NumberOfEmployees', 'Payables', 4, '{"width":"25"}', 'core::seed', NULL, '2025-12-22 09:28:37', '2025-12-23 14:41:15', '2025-12-23 14:41:15'),
(3, 1, 1, 'App\\Widgets\\CashFlow', 'Cash Flow', 3, '{"width":"100"}', 'core::seed', NULL, '2025-12-22 09:28:37', '2025-12-23 14:41:15', '2025-12-23 14:41:15'),
(4, 1, 1, 'App\\Widgets\\ProfitLoss', 'Profit & Loss', 4, '{"width":"50"}', 'core::seed', NULL, '2025-12-22 09:28:37', '2025-12-23 14:41:15', '2025-12-23 14:41:15'),
(5, 1, 1, 'App\\Widgets\\ExpensesByCategory', 'Expenses By Category', 5, '{"width":"50"}', 'core::seed', NULL, '2025-12-22 09:28:37', '2025-12-23 14:41:15', '2025-12-23 14:41:15'),
(6, 1, 1, 'App\\Widgets\\AccountBalance', 'Account Balance', 6, '{"width":"50"}', 'core::seed', NULL, '2025-12-22 09:28:37', '2025-12-23 14:41:15', '2025-12-23 14:41:15'),
(7, 1, 1, 'App\\Widgets\\BankFeeds', 'Connect Bank Accounts', 7, '{"width":"50"}', 'core::seed', NULL, '2025-12-22 09:28:37', '2025-12-23 14:41:15', '2025-12-23 14:41:15'),
(8, 1, 1, 'App\\Widgets\\CashFlow', 'Cash Flow', 0, '{"width":"100"}', 'core::ui', 1, '2025-12-23 02:58:08', '2025-12-23 02:58:18', '2025-12-23 02:58:18'),
(9, 1, 1, 'App\\Widgets\\Currencies', 'Currencies', 0, '{"width":"100"}', 'core::ui', 1, '2025-12-23 02:59:11', '2025-12-23 02:59:21', '2025-12-23 02:59:21'),
(10, 2, 5, 'App\\Widgets\\Receivables', 'Receivables', 1, '{"width":"50"}', 'core::seed', 1, '2025-12-22 22:11:13', '2025-12-22 22:12:23', '2025-12-22 22:12:23'),
(11, 2, 5, 'App\\Widgets\\Payables', 'Payables', 2, '{"width":"50"}', 'core::seed', 1, '2025-12-22 22:11:13', '2025-12-22 22:12:23', '2025-12-22 22:12:23'),
(12, 2, 5, 'App\\Widgets\\CashFlow', 'Cash Flow', 3, '{"width":"100"}', 'core::seed', 1, '2025-12-22 22:11:13', '2025-12-22 22:12:23', '2025-12-22 22:12:23'),
(13, 2, 5, 'App\\Widgets\\ProfitLoss', 'Profit & Loss', 4, '{"width":"50"}', 'core::seed', 1, '2025-12-22 22:11:13', '2025-12-22 22:12:23', '2025-12-22 22:12:23'),
(14, 2, 5, 'App\\Widgets\\ExpensesByCategory', 'Expenses By Category', 5, '{"width":"50"}', 'core::seed', 1, '2025-12-22 22:11:13', '2025-12-22 22:12:23', '2025-12-22 22:12:23'),
(15, 2, 5, 'App\\Widgets\\AccountBalance', 'Account Balance', 6, '{"width":"50"}', 'core::seed', 1, '2025-12-22 22:11:13', '2025-12-22 22:12:23', '2025-12-22 22:12:23'),
(16, 2, 5, 'App\\Widgets\\BankFeeds', 'Connect Bank Accounts', 7, '{"width":"50"}', 'core::seed', 1, '2025-12-22 22:11:13', '2025-12-22 22:12:23', '2025-12-22 22:12:23'),
(17, 1, 6, 'App\\Widgets\\Receivables', 'Receivables', 1, '{"width":"50"}', 'core::seed', 1, '2025-12-23 13:35:10', '2025-12-23 13:35:10', NULL),
(18, 1, 6, 'App\\Widgets\\Payables', 'Payables', 2, '{"width":"50"}', 'core::seed', 1, '2025-12-23 13:35:10', '2025-12-23 13:35:10', NULL),
(19, 1, 6, 'App\\Widgets\\CashFlow', 'Cash Flow', 3, '{"width":"100"}', 'core::seed', 1, '2025-12-23 13:35:10', '2025-12-23 13:35:10', NULL),
(20, 1, 6, 'App\\Widgets\\ProfitLoss', 'Profit & Loss', 4, '{"width":"50"}', 'core::seed', 1, '2025-12-23 13:35:10', '2025-12-23 13:35:10', NULL),
(21, 1, 6, 'App\\Widgets\\ExpensesByCategory', 'Expenses By Category', 5, '{"width":"50"}', 'core::seed', 1, '2025-12-23 13:35:10', '2025-12-23 13:35:10', NULL),
(22, 1, 6, 'App\\Widgets\\AccountBalance', 'Account Balance', 6, '{"width":"50"}', 'core::seed', 1, '2025-12-23 13:35:10', '2025-12-23 13:35:10', NULL),
(23, 1, 6, 'App\\Widgets\\BankFeeds', 'Connect Bank Accounts', 7, '{"width":"50"}', 'core::seed', 1, '2025-12-23 13:35:10', '2025-12-23 13:35:10', NULL),
(24, 1, 1, 'Modules\\SalesMetrics\\Widgets\\TopCustomersRevenueBased', 'Top Customers', 3, '{"width":"50"}', 'core::ui', 1, '2025-12-23 13:58:56', '2025-12-23 14:41:15', '2025-12-23 14:41:15'),
(25, 1, 1, 'Modules\\SalesMetrics\\Widgets\\TopItemsRevenueBased', 'Top Products', 3, '{"width":"50"}', 'core::ui', 1, '2025-12-23 13:59:51', '2025-12-23 14:41:15', '2025-12-23 14:41:15'),
(26, 1, 9, 'App\\Widgets\\Receivables', 'Receivables', 0, '{"width":"50"}', 'core::ui', 1, '2025-12-23 14:03:19', '2025-12-23 14:03:19', NULL),
(27, 1, 9, 'App\\Widgets\\Payables', 'Payables', 0, '{"width":"50"}', 'core::ui', 1, '2025-12-23 14:03:33', '2025-12-23 14:03:33', NULL),
(28, 1, 9, 'App\\Widgets\\CashFlow', 'Cash Flow', 1, '{"width":"100"}', 'core::ui', 1, '2025-12-23 14:03:50', '2025-12-23 14:04:00', NULL),
(29, 1, 9, 'App\\Widgets\\ProfitLoss', 'Profit & Loss', 3, '{"width":"50"}', 'core::ui', 1, '2025-12-23 14:04:30', '2025-12-23 14:04:53', '2025-12-23 14:04:53'),
(30, 1, 9, 'Modules\\SalesMetrics\\Widgets\\TopCustomersRevenueBased', 'Top Customers', 2, '{"width":"50"}', 'core::ui', 1, '2025-12-23 14:05:28', '2025-12-23 14:05:28', NULL),
(31, 1, 9, 'Modules\\SalesMetrics\\Widgets\\TopItemsRevenueBased', 'Top Products', 2, '{"width":"50"}', 'core::ui', 1, '2025-12-23 14:05:50', '2025-12-23 14:05:50', NULL),
(32, 1, 9, 'App\\Widgets\\ProfitLoss', 'Profit & Loss', 3, '{"width":"50"}', 'core::ui', 1, '2025-12-23 14:06:27', '2025-12-23 14:06:27', NULL),
(33, 1, 9, 'App\\Widgets\\ExpensesByCategory', 'Expense by category', 3, '{"width":"50"}', 'core::ui', 1, '2025-12-23 14:06:45', '2025-12-23 14:06:45', NULL),
(34, 1, 9, 'App\\Widgets\\AccountBalance', 'Account Balance', 4, '{"width":"50"}', 'core::ui', 1, '2025-12-23 14:07:04', '2025-12-23 14:07:04', NULL),
(35, 1, 9, 'App\\Widgets\\Currencies', 'Currencies', 4, '{"width":"50"}', 'core::ui', 1, '2025-12-23 14:07:31', '2025-12-23 14:07:39', '2025-12-23 14:07:39'),
(36, 1, 9, 'Modules\\SalesMetrics\\Widgets\\TopItemsProfitBased', 'Top products based on profit', 4, '{"width":"50"}', 'core::ui', 1, '2025-12-23 14:08:10', '2025-12-23 14:08:10', NULL),
(37, 1, 10, 'App\\Widgets\\Receivables', 'Receivables', 1, '{"width":"50"}', 'core::seed', 1, '2025-12-23 14:11:39', '2025-12-23 14:11:39', NULL),
(38, 1, 10, 'App\\Widgets\\Payables', 'Payables', 2, '{"width":"50"}', 'core::seed', 1, '2025-12-23 14:11:39', '2025-12-23 14:11:39', NULL),
(39, 1, 10, 'App\\Widgets\\CashFlow', 'Cash Flow', 3, '{"width":"100"}', 'core::seed', 1, '2025-12-23 14:11:39', '2025-12-23 14:11:39', NULL),
(40, 1, 10, 'App\\Widgets\\ProfitLoss', 'Profit & Loss', 4, '{"width":"50"}', 'core::seed', 1, '2025-12-23 14:11:39', '2025-12-23 14:11:39', NULL),
(41, 1, 10, 'App\\Widgets\\ExpensesByCategory', 'Expenses By Category', 5, '{"width":"50"}', 'core::seed', 1, '2025-12-23 14:11:39', '2025-12-23 14:11:39', NULL),
(42, 1, 10, 'App\\Widgets\\AccountBalance', 'Account Balance', 6, '{"width":"50"}', 'core::seed', 1, '2025-12-23 14:11:39', '2025-12-23 14:11:39', NULL),
(43, 1, 10, 'App\\Widgets\\BankFeeds', 'Connect Bank Accounts', 7, '{"width":"50"}', 'core::seed', 1, '2025-12-23 14:11:39', '2025-12-23 14:11:39', NULL),
(44, 1, 11, 'App\\Widgets\\Receivables', 'Receivables', 1, '{"width":"50"}', 'core::seed', 1, '2025-12-23 14:40:38', '2025-12-23 14:40:38', NULL),
(45, 1, 11, 'App\\Widgets\\Payables', 'Payables', 2, '{"width":"50"}', 'core::seed', 1, '2025-12-23 14:40:38', '2025-12-23 14:40:38', NULL),
(46, 1, 11, 'App\\Widgets\\CashFlow', 'Cash Flow', 3, '{"width":"100"}', 'core::seed', 1, '2025-12-23 14:40:38', '2025-12-23 14:40:38', NULL),
(47, 1, 11, 'App\\Widgets\\ProfitLoss', 'Profit & Loss', 4, '{"width":"50"}', 'core::seed', 1, '2025-12-23 14:40:38', '2025-12-23 14:40:38', NULL),
(48, 1, 11, 'App\\Widgets\\ExpensesByCategory', 'Expenses By Category', 5, '{"width":"50"}', 'core::seed', 1, '2025-12-23 14:40:38', '2025-12-23 14:40:38', NULL),
(49, 1, 11, 'App\\Widgets\\AccountBalance', 'Account Balance', 6, '{"width":"50"}', 'core::seed', 1, '2025-12-23 14:40:38', '2025-12-23 14:40:38', NULL),
(50, 1, 11, 'App\\Widgets\\BankFeeds', 'Connect Bank Accounts', 7, '{"width":"50"}', 'core::seed', 1, '2025-12-23 14:40:38', '2025-12-23 14:40:38', NULL),
(51, 1, 12, 'App\\Widgets\\Receivables', 'Receivables', 1, '{"width":"50"}', 'core::seed', 1, '2025-12-23 14:45:28', '2025-12-23 14:45:28', NULL),
(52, 1, 12, 'App\\Widgets\\Payables', 'Payables', 2, '{"width":"50"}', 'core::seed', 1, '2025-12-23 14:45:29', '2025-12-23 14:45:29', NULL),
(53, 1, 12, 'App\\Widgets\\CashFlow', 'Cash Flow', 3, '{"width":"100"}', 'core::seed', 1, '2025-12-23 14:45:29', '2025-12-23 14:45:29', NULL),
(54, 1, 12, 'App\\Widgets\\ProfitLoss', 'Profit & Loss', 4, '{"width":"50"}', 'core::seed', 1, '2025-12-23 14:45:29', '2025-12-23 14:45:29', NULL),
(55, 1, 12, 'App\\Widgets\\ExpensesByCategory', 'Expenses By Category', 5, '{"width":"50"}', 'core::seed', 1, '2025-12-23 14:45:29', '2025-12-23 14:45:29', NULL),
(56, 1, 12, 'App\\Widgets\\AccountBalance', 'Account Balance', 6, '{"width":"50"}', 'core::seed', 1, '2025-12-23 14:45:29', '2025-12-23 14:45:29', NULL),
(57, 1, 12, 'App\\Widgets\\BankFeeds', 'Connect Bank Accounts', 7, '{"width":"50"}', 'core::seed', 1, '2025-12-23 14:45:29', '2025-12-23 14:45:29', NULL);

-- --------------------------------------------------------

--
-- Constraints for table `aku9_categories`
--
ALTER TABLE `aku9_categories`
  ADD CONSTRAINT `aku9_categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `aku9_categories` (`id`);

--
-- Constraints for table `aku9_media`
--
ALTER TABLE `aku9_media`
  ADD CONSTRAINT `original_media_id` FOREIGN KEY (`original_media_id`) REFERENCES `aku9_media` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `aku9_mediables`
--
ALTER TABLE `aku9_mediables`
  ADD CONSTRAINT `aku9_mediables_media_id_foreign` FOREIGN KEY (`media_id`) REFERENCES `aku9_media` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `aku9_role_permissions`
--
ALTER TABLE `aku9_role_permissions`
  ADD CONSTRAINT `aku9_role_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `aku9_permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `aku9_role_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `aku9_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `aku9_transactions`
--
ALTER TABLE `aku9_transactions`
  ADD CONSTRAINT `aku9_transactions_split_id_foreign` FOREIGN KEY (`split_id`) REFERENCES `aku9_transactions` (`id`);

--
-- Constraints for table `aku9_user_permissions`
--
ALTER TABLE `aku9_user_permissions`
  ADD CONSTRAINT `aku9_user_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `aku9_permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `aku9_user_roles`
--
ALTER TABLE `aku9_user_roles`
  ADD CONSTRAINT `aku9_user_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `aku9_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
