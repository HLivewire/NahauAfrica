-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 30, 2023 at 10:51 AM
-- Server version: 10.5.19-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u186958312_maannews2_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `advertisements`
--

CREATE TABLE `advertisements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `header_ads` text DEFAULT NULL,
  `sidebar_ads` text DEFAULT NULL,
  `before_post_ads` text DEFAULT NULL,
  `after_post_ads` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `advertisements`
--

INSERT INTO `advertisements` (`id`, `header_ads`, `sidebar_ads`, `before_post_ads`, `after_post_ads`, `status`, `created_at`, `updated_at`) VALUES
(1, '<a href=\"  https://www.google.com/  \" target=\"_blank\">\r\n                        <img src=\"https://maannews.acnoo.com/public/uploads/images/ads/adds.jpg  \" alt=\"https://maannews.acnoo.com/public/frontend/img/header-adds/adds.jpg\"></a>', '<a class=\"side-add-thumb\" href=\"https://www.google.com/\">\r\n                                <img src=\"https://maannews.acnoo.com/public/frontend/img/entertainment/slide-card/slide-img-1.jpg\" alt=\"https://maannews.acnoo.com/public/frontend/img/entertainment/slide-card/slide-img-1.jpg\">\r\n                            </a>', '<a href=\"  https://www.google.com/  \" target=\"_blank\">\r\n                        <img src=\"https://maannews.acnoo.com/public/uploads/images/ads/adds.jpg  \" alt=\"https://maannews.acnoo.com/public/frontend/img/header-adds/adds.jpg\"></a>', '<a href=\"  https://www.google.com/  \" target=\"_blank\">\r\n                        <img src=\"https://maannews.acnoo.com/public/uploads/images/ads/adds.jpg  \" alt=\"https://maannews.acnoo.com/public/frontend/img/header-adds/adds.jpg\"></a>', 1, '2022-07-03 00:57:19', '2023-04-30 02:38:02');

-- --------------------------------------------------------

--
-- Table structure for table `blogcategories`
--

CREATE TABLE `blogcategories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogcategories`
--

INSERT INTO `blogcategories` (`id`, `name`, `user_id`, `created_at`, `updated_at`) VALUES
(2, 'Sports', 1, '2021-09-13 04:01:11', '2021-09-13 04:01:11');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `blogsubcategory_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `summary` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `date` date NOT NULL,
  `tags` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `blogsubcategory_id`, `title`, `summary`, `description`, `status`, `date`, `tags`, `image`, `user_id`, `created_at`, `updated_at`) VALUES
(2, 3, 'Kuldeep Yadav undergoes surgery on injured knee', 'India and Kolkata Knight Riders left-arm spinner Kuldeep Yadav has undergone surgery after sustaining a knee injury.', '<p><span style=\"color: rgb(51, 51, 51); font-family: helvetica, &quot;Segoe UI&quot;, Arial, sans-serif;\">India and Kolkata Knight Riders left-arm spinner&nbsp;</span><a href=\"https://www.cricbuzz.com/profiles/8292/kuldeep-yadav\" style=\"color: rgb(24, 102, 219); outline: none medium; font-family: helvetica, &quot;Segoe UI&quot;, Arial, sans-serif; background-color: rgb(255, 255, 255);\">Kuldeep Yadav</a><span style=\"color: rgb(51, 51, 51); font-family: helvetica, &quot;Segoe UI&quot;, Arial, sans-serif;\">&nbsp;has undergone surgery after sustaining a knee injury. The 26-year-old had already left the IPL 2021 bubble in the UAE and returned to India.</span></p><section class=\"cb-nws-dtl-itms\" itemprop=\"articleBody\" style=\"line-height: 28px; margin: 0px; color: rgb(51, 51, 51); font-family: helvetica, &quot;Segoe UI&quot;, Arial, sans-serif;\"><p class=\"cb-nws-para\" style=\"margin-right: 0px; margin-bottom: 30px; margin-left: 0px;\">A mainstay in India\'s white-ball teams until the 2019 World Cup, Kuldeep has endured a slump in returns, his drop in performance coinciding with India\'s decision to shelve their two wristspinners theory.</p></section><p>                                            \r\n                                          </p><section class=\"cb-nws-dtl-itms\" itemprop=\"articleBody\" style=\"line-height: 28px; margin: 0px; color: rgb(51, 51, 51); font-family: helvetica, &quot;Segoe UI&quot;, Arial, sans-serif;\"><p class=\"cb-nws-para\" style=\"margin-right: 0px; margin-bottom: 30px; margin-left: 0px;\">The IPL hasn\'t exactly been a stage to push for a comeback, having been usurped in the playing XI by CV Varun. Kuldeep took a solitary wicket from five appearances in IPL 2020 and wasn\'t picked for any game in the ongoing 2021 season.</p></section>', 1, '2021-09-28', 'Cricket', '[\"public\\/uploads\\/images\\/blogimages\\/maanblogimage29092021_103410_india-and-kolkata-knight-rider.jpg\"]', 1, '2021-09-29 04:34:10', '2022-11-15 23:06:28');

-- --------------------------------------------------------

--
-- Table structure for table `blogsubcategories`
--

CREATE TABLE `blogsubcategories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogsubcategories`
--

INSERT INTO `blogsubcategories` (`id`, `category_id`, `name`, `user_id`, `created_at`, `updated_at`) VALUES
(3, 2, 'Cricket', 1, '2021-09-13 06:57:34', '2021-09-13 06:57:34'),
(4, 2, 'Football', 1, '2021-09-13 06:57:52', '2021-09-13 06:57:52');

-- --------------------------------------------------------

--
-- Table structure for table `bookmarks`
--

CREATE TABLE `bookmarks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `news_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookmarks`
--

INSERT INTO `bookmarks` (`id`, `user_id`, `news_id`, `created_at`, `updated_at`) VALUES
(1, 6, 48, '2022-03-17 19:37:52', '2022-03-17 19:37:52'),
(2, 6, 44, '2022-03-17 19:40:07', '2022-03-17 19:40:07');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `address_line1` varchar(255) DEFAULT NULL,
  `address_line2` varchar(255) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `location_map` text DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `copyright` text DEFAULT NULL,
  `version` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `address_line1`, `address_line2`, `phone`, `email`, `location_map`, `message`, `copyright`, `version`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Maan News', 'Cecilia Chapman, 711-2880', 'NullaSt. Mankato Mississippi 96522 (257) 563-7401', '+8802659874164', 'maantheme@gmail.com', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3645.133068555471!2d91.08454181482016!3d23.99107768447128!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3754051b50ebac3f%3A0x735c1cc426d8ebb!2sNatai%20Bodtoli%20Bazar%2C%20Natai%2C%2C%20Brahmanbaria!5e0!3m2!1sen!2sbd!4v1594548160557!5m2!1sen!2sbd', 'Visit our agency or simply send us an email anytime you want. If you have any questions, please feel free.', '<strong> 2023 All rights reserved <a href=\"https://maantheme.com\"> maanmtheme.com </a>.</strong>', '4.0', 1, '2022-01-29 01:39:58', '2023-05-30 09:36:57');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `website`, `message`, `created_at`, `updated_at`) VALUES
(1, 'Hello', 'hello@gmail.com', 'www.hello.com', 'Hello check...', '2021-12-04 04:04:36', '2021-12-04 04:04:36');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `footers`
--

CREATE TABLE `footers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `name_slug` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `footers`
--

INSERT INTO `footers` (`id`, `name`, `name_slug`, `image`, `is_active`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Footer 1', 'footer_1', 'public/uploads/images/footer/maanfooterimage30042023_063819_footer_1.png', 0, 1, '2022-10-22 00:36:43', '2023-05-30 10:15:42'),
(3, 'Footer 2', 'footer_2', 'public/uploads/images/footer/maanfooterimage25102022_181919_Screenshot_1.png', 0, 1, '2022-10-22 04:18:26', '2023-05-30 10:15:42'),
(4, 'Footer 3', 'footer_3', 'public/uploads/images/footer/maanfooterimage25102022_182352_footer_3.PNG', 0, 1, '2022-10-25 03:50:11', '2023-05-30 10:15:42'),
(5, 'Footer 4', 'footer_4', 'public/uploads/images/footer/maanfooterimage25102022_182945_footer_4.PNG', 0, 1, '2022-10-25 05:14:43', '2023-05-30 10:15:42'),
(6, 'Footer 5', 'footer_5', 'public/uploads/images/footer/maanfooterimage30042023_062426_footer_5.png', 1, 1, '2022-10-25 11:35:34', '2023-05-30 10:15:42'),
(7, 'Footer 6', 'footer_6', 'public/uploads/images/footer/maanfooterimage26102022_013009_footer_6.PNG', 0, 1, '2022-10-25 11:35:42', '2023-05-30 10:15:42'),
(8, 'Footer 7', 'footer_7', 'public/uploads/images/footer/maanfooterimage30042023_044427_footer_7.png', 0, 1, '2022-10-25 11:35:49', '2023-05-30 10:15:42');

-- --------------------------------------------------------

--
-- Table structure for table `googleanalytics`
--

CREATE TABLE `googleanalytics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `google_analytics` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `googleanalytics`
--

INSERT INTO `googleanalytics` (`id`, `google_analytics`, `created_at`, `updated_at`) VALUES
(1, '<meta name=\"google-site-verification\" content=\"6zjwDVcsojeetIY15O4VJtGIZHYGi0O-u6fSQG_rgqo\" />', '2022-01-23 04:05:58', '2022-07-06 00:09:56');

-- --------------------------------------------------------

--
-- Table structure for table `headers`
--

CREATE TABLE `headers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `name_slug` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `headers`
--

INSERT INTO `headers` (`id`, `name`, `name_slug`, `image`, `is_active`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Header 1', 'header_1', 'public/uploads/images/header/maanheaderimage25102022_180515_header_1.PNG', 1, 1, '2022-10-21 23:23:39', '2023-05-28 05:04:56'),
(4, 'Header 2', 'header_2', 'public/uploads/images/header/maanheaderimage19112022_051303_header_2.png', 0, 1, '2022-10-22 05:29:42', '2023-05-28 05:04:56'),
(6, 'Header 3', 'header_3', 'public/uploads/images/header/maanheaderimage19112022_045507_header_3.png', 0, 1, '2022-10-25 03:00:22', '2023-05-28 05:04:56'),
(7, 'Header 4', 'header_4', 'public/uploads/images/header/maanheaderimage30102022_042617_header_4.PNG', 0, 1, '2022-10-25 05:14:25', '2023-05-28 05:04:56'),
(8, 'Header 5', 'header_5', 'public/uploads/images/header/maanheaderimage19112022_093935_header_5.png', 0, 1, '2022-10-25 11:35:03', '2023-05-28 05:04:56'),
(9, 'Header 6', 'header_6', 'public/uploads/images/header/maanheaderimage26102022_012940_header_6.PNG', 0, 1, '2022-10-25 11:35:11', '2023-05-28 05:04:56'),
(10, 'Header 7', 'header_7', 'public/uploads/images/header/maanheaderimage26102022_015001_header_7.PNG', 0, 1, '2022-10-25 11:35:19', '2023-05-28 05:04:56');

-- --------------------------------------------------------

--
-- Table structure for table `maanusers`
--

CREATE TABLE `maanusers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `last_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `phone` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `verification_code` varchar(20) DEFAULT NULL,
  `verification_expire_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `maanusers`
--

INSERT INTO `maanusers` (`id`, `first_name`, `last_name`, `phone`, `email`, `password`, `verification_code`, `verification_expire_at`, `created_at`, `updated_at`) VALUES
(1, 'User', '21', '123456', 'user21@gmail.com', '$2y$10$vVOm3irnT5tWb92ukJJSaeoZGFUQoVtfaiJIqHps179Y9GmzgUZIO', NULL, NULL, '2021-09-29 03:11:31', '2021-09-29 03:11:31'),
(2, 'Isaac', 'Richard', 'hupoxedy@mailinator.com', 'teraty@mailinator.com', '$2y$10$KKtZ3vvPaGUxhFSTUf31b.V0.ZGAcv1H7e6yyD7CTJFaw3VxmrP8K', NULL, NULL, '2021-10-05 05:03:51', '2021-10-05 05:03:51'),
(3, 'Althea', 'Calderon', 'gyxabypy@mailinator.com', 'cirasy@mailinator.com', '$2y$10$3p006M7gw2iwnfj191uV2.qmoYCDaXWDr/ypD/3ck/t5R/ZSQABRe', NULL, NULL, '2021-10-05 05:04:20', '2021-10-05 05:04:20'),
(4, 'Hello', 'Check', '123987', 'towhiduzzaman.22@gmail.com', '$2y$10$VraBQfj1oqFN5W76qdHQ8e9iQvb/wJx5F58LPmsmaZU70XHR5QCYm', NULL, NULL, '2022-02-03 03:06:59', '2022-02-03 03:06:59'),
(5, 'Check', 'Hello', '147963', 'check@gmail.com', '$2y$10$2xRM02EJUOUR5EqpWRieoe33JgSl24r5L9BVDclYEElJ3RuoWvlOi', NULL, NULL, '2022-02-03 03:15:26', '2022-02-03 03:15:26'),
(6, 'Prince', 'Mahmud', '+8801767432558', 'princey01767@gmail.com', '$2y$10$VFU.rqcIuEBdSIGiYnAnL./ME6Ix7Ff7Wki4JxR2DmICn7jS0PARC', '504425', '2022-03-17 18:30:21', '2022-03-15 09:22:23', '2022-03-17 17:32:45'),
(8, NULL, NULL, NULL, 'recheck@gmail.com', NULL, NULL, NULL, '2022-03-23 03:19:23', '2022-03-23 03:19:23'),
(9, NULL, NULL, NULL, 'aaaaaaaaa@gmail.com', NULL, NULL, NULL, '2022-03-23 03:38:11', '2022-03-23 03:38:11'),
(10, 'Jack', 'Won', '+8201033550084', 'jack@dhlogisrics.co.kr', '$2y$10$oX9bztyf/Q9C7CIYXegaOeUwUCB3MqeGW3UIKHnjR4tCe/lBWL5hq', NULL, NULL, '2022-03-29 06:28:57', '2022-03-29 06:28:57'),
(11, NULL, NULL, NULL, 'adddf@dfd.dfd', NULL, NULL, NULL, '2022-07-03 04:16:35', '2022-07-03 04:16:35'),
(12, NULL, NULL, NULL, 'adddf@dfd.dfd1', NULL, NULL, NULL, '2022-07-03 04:33:11', '2022-07-03 04:33:11'),
(13, NULL, NULL, NULL, 'adddf@dfd.dfdg', NULL, NULL, NULL, '2022-07-03 04:35:32', '2022-07-03 04:35:32'),
(14, NULL, NULL, NULL, 'adddf@dfd.dfdg1', NULL, NULL, NULL, '2022-07-03 04:43:00', '2022-07-03 04:43:00'),
(15, NULL, NULL, NULL, 'dsfsdfa@dfsd.fgdsf', NULL, NULL, NULL, '2022-07-06 00:58:02', '2022-07-06 00:58:02'),
(16, NULL, NULL, NULL, 'dsfdsf@fdf.gfg', NULL, NULL, NULL, '2022-07-06 01:13:41', '2022-07-06 01:13:41'),
(17, 'Prince', 'mahmud', '01767432558', 'prince@p.com', '$2y$10$ec675a3qWAbBVBgWNkrgj.aRCQrLMKlo7MEHirzFM2H4uYzIhgdwW', NULL, NULL, '2022-10-15 05:13:18', '2022-10-15 05:13:18'),
(18, 'Tarik', 'bin Aziz', '019427839', 'tarik@gmail.com', '$2y$10$uJrL56qJ83UH5zYSZt7YCufilYElLqHZD6riIVXgDFI8wKNPTfpeG', NULL, NULL, '2022-10-26 22:18:35', '2022-10-26 22:18:35'),
(19, NULL, NULL, NULL, 'hgfhgfhg@dsfds.ffgf', NULL, NULL, NULL, '2022-11-16 22:39:33', '2022-11-16 22:39:33');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(59, '2014_10_12_000000_create_users_table', 1),
(60, '2014_10_12_100000_create_password_resets_table', 1),
(61, '2019_08_19_000000_create_failed_jobs_table', 1),
(62, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(63, '2021_08_31_063339_create_newscategories_table', 1),
(64, '2021_08_31_101146_create_newssubcategories_table', 1),
(65, '2021_08_31_114824_create_newsspecialities_table', 1),
(67, '2021_09_02_112019_create_blogcategories_table', 1),
(68, '2021_09_02_112347_create_blogsubcategories_table', 1),
(71, '2021_08_31_115107_create_news_table', 2),
(73, '2021_09_13_090413_create_blogs_table', 3),
(74, '2021_09_14_060841_create_photogalleries_table', 4),
(75, '2021_09_15_055941_create_videogalleries_table', 5),
(78, '2021_09_29_082000_create_maanusers_table', 7),
(95, '2021_09_25_114913_create_roles_table', 8),
(96, '2021_09_30_041350_create_permissions_table', 8),
(97, '2021_09_30_042841_create_users_roles_table', 8),
(98, '2021_09_30_043928_create_users_permissions_table', 8),
(99, '2021_09_30_045216_create_roles_permissions_table', 8),
(101, '2021_10_04_075510_create_newscomments_table', 9),
(102, '2021_10_17_060606_create_settings_table', 10),
(103, '2021_12_04_093506_create_contacts_table', 11),
(107, '2022_01_16_065521_create_seooptimizations_table', 12),
(113, '2022_01_22_095048_create_googleanalytics_table', 14),
(118, '2022_01_23_113253_create_companies_table', 15),
(119, '2022_01_27_102041_create_socialshares_table', 15),
(121, '2016_06_01_000001_create_oauth_auth_codes_table', 16),
(122, '2016_06_01_000002_create_oauth_access_tokens_table', 16),
(123, '2016_06_01_000003_create_oauth_refresh_tokens_table', 16),
(124, '2016_06_01_000004_create_oauth_clients_table', 16),
(125, '2016_06_01_000005_create_oauth_personal_access_clients_table', 16),
(126, '2022_02_21_161451_create_providers_table', 16),
(127, '2022_03_10_113253_create_bookmarks_table', 17),
(128, '2022_03_15_053408_add_verification_code_and_verification_expire_at_to_users_table', 18),
(129, '2022_01_19_092221_create_advertisements_table', 19),
(133, '2022_10_19_082617_create_headers_table', 22),
(135, '2022_10_22_055350_create_footers_table', 24),
(136, '2022_10_12_061014_create_themes_table', 25),
(137, '2023_05_07_110922_add_image_to_videogalleries_table', 26),
(138, '2023_05_08_050007_add_theme_color_to_settings_table', 27),
(139, '2022_10_20_070206_create_menus_table', 28),
(140, '2023_05_28_061849_add_copyright_version_to_companies_table', 28);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subcategory_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `summary` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `breaking_news` int(11) NOT NULL DEFAULT 0,
  `date` date NOT NULL,
  `tags` varchar(50) DEFAULT NULL,
  `speciality_id` bigint(20) UNSIGNED NOT NULL,
  `reporter_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `archive` int(11) NOT NULL DEFAULT 0,
  `viewers` int(11) NOT NULL DEFAULT 0,
  `meta_keyword` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `subcategory_id`, `title`, `summary`, `description`, `status`, `breaking_news`, `date`, `tags`, `speciality_id`, `reporter_id`, `image`, `user_id`, `archive`, `viewers`, `meta_keyword`, `meta_description`, `created_at`, `updated_at`) VALUES
(2, 3, 'Everything you wanted to know about business', 'Everything you wanted to know about business and were too embarrassed to ask · ttand alone for your mom\'s interpretation. the refractor telescope uses a convex ...', '<span style=\"color: rgb(16, 38, 74); font-family: Poppins; font-size: 15px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">Stand alone for your mom’s interpretation<br><br>&nbsp;&nbsp;&nbsp; The refractor telescope uses a convex lens to focus the light on the eyepiece.<br>&nbsp;&nbsp;&nbsp; The reflector telescope has a concave lens which means it bends in. It uses mirrors to focus the image that you eventually see.<br>&nbsp;&nbsp;&nbsp; Collimation is a term for how well tuned the telescope is to give you a good clear image of what you are looking at. You want your telescope to have good collimation so you are not getting a false image of the celestial body.<br>&nbsp;&nbsp;&nbsp; Aperture is a fancy word for how big the lens of your telescope is. But it’s an important word because the aperture of the lens is the key to how powerful your telescope is. Magnification has nothing to do with it, its all in the aperture.<br>&nbsp;&nbsp;&nbsp; Focuser is the housing that keeps the eyepiece of the telescope, or what you will look through, in place. The focuser has to be stable and in good repair for you to have an image you can rely on.<br>&nbsp;&nbsp;&nbsp; Mount and Wedge. Both of these terms refer to the tripod your telescope sits on. The mount is the actual tripod and the wedge is the device that lets you attach the telescope to the mount.<br>&nbsp;&nbsp;&nbsp; These eight shots crystallize the hard work moms put into keeping their kids alive, happy, and healthy. They might give you the inspiration you need for filling out that card—or stand alone for your mom’s interpretation.For those of us who want to say thank you to our moms, it’s not always easy to put those big feelings in words. Which is where Dribble comes in.Moms are the ones who bandage our boo-boos when we’re little and continue to take care of us as we get older—often sacrificing their own needs so they can help with ours. Cruising on a bike to help heal our injuries is the most mom thing one can do.</span>', 1, 0, '2021-09-16', 'Business', 4, 8, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage18092021_101225_b-post-2.jpg\"]', 1, 0, 105, NULL, NULL, '2021-09-18 04:12:25', '2023-05-03 03:57:14'),
(3, 3, 'Stock markets are where individual and institutional  investors come together to buy and sell shares in a public venue. Nowadays these exchanges', 'Stock markets are where individual and institutional investors come together to buy and sell shares in a public venue. Nowadays these exchanges exist as ...', '<span style=\"color: rgb(17, 17, 17); font-family: SourceSansPro, sans-serif; font-size: 17.6px;\">Stand alone for your mom’s interpretation<br><br>&nbsp;&nbsp;&nbsp; The refractor telescope uses a convex lens to focus the light on the eyepiece.<br>&nbsp;&nbsp;&nbsp; The reflector telescope has a concave lens which means it bends in. It uses mirrors to focus the image that you eventually see.<br>&nbsp;&nbsp;&nbsp; Collimation is a term for how well tuned the telescope is to give you a good clear image of what you are looking at. You want your telescope to have good collimation so you are not getting a false image of the celestial body.<br>&nbsp;&nbsp;&nbsp; Aperture is a fancy word for how big the lens of your telescope is. But it’s an important word because the aperture of the lens is the key to how powerful your telescope is. Magnification has nothing to do with it, its all in the aperture.<br>&nbsp;&nbsp;&nbsp; Focuser is the housing that keeps the eyepiece of the telescope, or what you will look through, in place. The focuser has to be stable and in good repair for you to have an image you can rely on.<br>&nbsp;&nbsp;&nbsp; Mount and Wedge. Both of these terms refer to the tripod your telescope sits on. The mount is the actual tripod and the wedge is the device that lets you attach the telescope to the mount.<br>&nbsp;&nbsp;&nbsp; These eight shots crystallize the hard work moms put into keeping their kids alive, happy, and healthy. They might give you the inspiration you need for filling out that card—or stand alone for your mom’s interpretation.For those of us who want to say thank you to our moms, it’s not always easy to put those big feelings in words. Which is where Dribble comes in.Moms are the ones who bandage our boo-boos when we’re little and continue to take care of us as we get older—often sacrificing their own needs so they can help with ours. Cruising on a bike to help heal our injuries is the most mom thing one can do.</span><span style=\"color: rgb(17, 17, 17); font-family: SourceSansPro, sans-serif; font-size: 17.6px;\"></span>', 1, 0, '2021-11-14', 'Business', 4, 8, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage19092021_061343_b-post-3.jpg\"]', 1, 0, 85, NULL, NULL, '2021-09-19 00:13:43', '2023-05-03 03:57:07'),
(4, 1, 'One  georgian silver medallists were told to leave the olympics after breaking', 'One georgian silver medallists were told to leave the olympics after breaking Covid-19 rules by going sightseeing, it has emerged. According to reports,', 'Stand alone for your mom’s interpretation<br><br>&nbsp;&nbsp;&nbsp; The refractor telescope uses a convex lens to focus the light on the eyepiece.<br>&nbsp;&nbsp;&nbsp; The reflector telescope has a concave lens which means it bends in. It uses mirrors to focus the image that you eventually see.<br>&nbsp;&nbsp;&nbsp; Collimation is a term for how well tuned the telescope is to give you a good clear image of what you are looking at. You want your telescope to have good collimation so you are not getting a false image of the celestial body.<br>&nbsp;&nbsp;&nbsp; Aperture is a fancy word for how big the lens of your telescope is. But it’s an important word because the aperture of the lens is the key to how powerful your telescope is. Magnification has nothing to do with it, its all in the aperture.<br>&nbsp;&nbsp;&nbsp; Focuser is the housing that keeps the eyepiece of the telescope, or what you will look through, in place. The focuser has to be stable and in good repair for you to have an image you can rely on.<br>&nbsp;&nbsp;&nbsp; Mount and Wedge. Both of these terms refer to the tripod your telescope sits on. The mount is the actual tripod and the wedge is the device that lets you attach the telescope to the mount.<br>&nbsp;&nbsp;&nbsp; These eight shots crystallize the hard work moms put into keeping their kids alive, happy, and healthy. They might give you the inspiration you need for filling out that card—or stand alone for your mom’s interpretation.For those of us who want to say thank you to our moms, it’s not always easy to put those big feelings in words. Which is where Dribble comes in.Moms are the ones who bandage our boo-boos when we’re little and continue to take care of us as we get older—often sacrificing their own needs so they can help with ours. Cruising on a bike to help heal our injuries is the most mom thing one can do.', 1, 0, '2021-11-04', 'Olympic', 4, 8, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage23032022_051252_3 (2).png\"]', 1, 0, 20, NULL, NULL, '2021-09-19 04:06:03', '2022-04-19 23:09:57'),
(5, 1, 'Search top women In tennis. get results from 6 search engines! explore the best Info now', 'Search top women In tennis. get results from 6 Search engines! explore the best Info now. Powerful and easy to use.', '<span style=\"color: rgb(80, 80, 88); font-family: Arial, arial, sans-serif; font-size: 14px;\">Stand alone for your mom’s interpretation<br><br>&nbsp;&nbsp;&nbsp; The refractor telescope uses a convex lens to focus the light on the eyepiece.<br>&nbsp;&nbsp;&nbsp; The reflector telescope has a concave lens which means it bends in. It uses mirrors to focus the image that you eventually see.<br>&nbsp;&nbsp;&nbsp; Collimation is a term for how well tuned the telescope is to give you a good clear image of what you are looking at. You want your telescope to have good collimation so you are not getting a false image of the celestial body.<br>&nbsp;&nbsp;&nbsp; Aperture is a fancy word for how big the lens of your telescope is. But it’s an important word because the aperture of the lens is the key to how powerful your telescope is. Magnification has nothing to do with it, its all in the aperture.<br>&nbsp;&nbsp;&nbsp; Focuser is the housing that keeps the eyepiece of the telescope, or what you will look through, in place. The focuser has to be stable and in good repair for you to have an image you can rely on.<br>&nbsp;&nbsp;&nbsp; Mount and Wedge. Both of these terms refer to the tripod your telescope sits on. The mount is the actual tripod and the wedge is the device that lets you attach the telescope to the mount.<br>&nbsp;&nbsp;&nbsp; These eight shots crystallize the hard work moms put into keeping their kids alive, happy, and healthy. They might give you the inspiration you need for filling out that card—or stand alone for your mom’s interpretation.For those of us who want to say thank you to our moms, it’s not always easy to put those big feelings in words. Which is where Dribble comes in.Moms are the ones who bandage our boo-boos when we’re little and continue to take care of us as we get older—often sacrificing their own needs so they can help with ours. Cruising on a bike to help heal our injuries is the most mom thing one can do.</span>', 1, 0, '2021-11-04', 'Tennis', 4, 8, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage23032022_051050_2 (1).png\"]', 1, 0, 14, NULL, NULL, '2021-09-19 05:10:25', '2022-06-21 21:47:40'),
(6, 1, 'Official icc fooball - live matches  commentary rankings', 'Keep the door open for us: ACB CEO\'s plea to Cricket Australia', '<span style=\"color: rgb(16, 38, 74); font-family: Poppins; font-size: 15px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">It’s\r\n been a day since the NHL’s 2021-22 trade deadline, and in addition to \r\nthe joy felt in markets that did well on the trade front, there’s \r\nalready angst, criticism and condemnation for various reasons in other \r\nNHL cities. In no particular order, let’s take a brief look at the \r\nlosers at Deadline Day:<br><br>1. Edmonton Oilers: They’ve been getting \r\nimproved goaltending of late, but the Oilers not too long ago were in \r\ngoalie hell with their current pair of Mikko Koskinen and Mike Smith. In\r\n Koskinen’s past two games, he’s put in sub-.900 save percentages, and \r\nin two of his past five appearances, Smith has posted a sub.860 SP.<br><br>Did\r\n Edmonton GM Ken Holland have all the reason in the world to go out and \r\nget a better goalie? He sure did. Could that failure to do so come back \r\nto haunt him once the playoffs begin? It sure could. Holland had all \r\nseason long to find another netminder, and he knew the deadline was \r\ncoming. It didn’t have to come to this, but now, it has. A goaltending \r\ncrisis may prove to be what sinks the Oilers’ championship aspirations.<br>2.\r\n Toronto Maple Leafs: The Leafs land here with a caveat – namely, the \r\nacknowledgment that Toronto GM Kyle Dubas did improve his blueline and \r\nfourth line of forwards when he acquired D-man Mark Giordano and forward\r\n Colin Blackwell from Seattle on Sunday. However, their most pressing \r\nneed – a veteran goalie to be given a shot at the No. 1 job until Jack \r\nCampbell returns from a rib injury – was not dealt with by the deadline.<br><br>That\r\n means, if rookie netminder Erik Kallgren crumbles under the pressure of\r\n the starter’s role, Leafs head coach Sheldon Keefe will have no other \r\nalternative but to use Petr Mrazek. And anyone who has watched Mrazek’s \r\nrecent games will tell you that’s not a good thing. Mrazek’s .884 SP and\r\n 3.48 goals-against average show his struggles with Toronto this season,\r\n and the pressure is only going to increase on him, whenever the Leafs \r\ndecide to play him. Another soft goal here or there and Mrazek will be \r\nquickly pulled from games.<br><br>Dubas has claimed he waived Mrazek \r\nover the weekend as a salary cap move, but who’s kidding who - you don’t\r\n waive someone you really want to keep around. If, for whatever reason, \r\nanother franchise decided to take a chance on Mrazek – for this year, \r\nand two more years, with a $3.8 million annual cap hit – there would be \r\nlittle in the way of mourning over Mrazek’s departure. Instead, Leafs \r\nbrass now has to be cold-blooded in their analysis and deployment of \r\ngoalies. Campbell and Kallgren will get the first chances to run with \r\nthe No. 1 job, and if they fail, it will fall on Mrazek to get one last \r\nshot at proving himself in Toronto.</span>', 1, 1, '2021-11-03', 'footbal', 3, 8, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage19102021_115015_ap_21166648130451-rt-sportsnewglobal.jpg\"]', 1, 0, 22, NULL, NULL, '2021-09-19 05:28:55', '2022-10-13 09:38:43'),
(7, 7, 'Latest breaking movie news from the footballs', 'It’s been a day since the NHL’s 2021-22 trade deadline, and in addition to the joy felt in markets that did well on the trade front, there’s already angst, criticism and condemnation for various reasons in other NHL cities.', '<span style=\"color: rgb(16, 38, 74); font-family: Poppins; font-size: 15px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">It’s\r\n been a day since the NHL’s 2021-22 trade deadline, and in addition to \r\nthe joy felt in markets that did well on the trade front, there’s \r\nalready angst, criticism and condemnation for various reasons in other \r\nNHL cities. In no particular order, let’s take a brief look at the \r\nlosers at Deadline Day.<br><br>1. Edmonton Oilers: They’ve been getting \r\nimproved goaltending of late, but the Oilers not too long ago were in \r\ngoalie hell with their current pair of Mikko Koskinen and Mike Smith. In\r\n Koskinen’s past two games, he’s put in sub-.900 save percentages, and \r\nin two of his past five appearances, Smith has posted a sub.860 SP.<br><br>Did\r\n Edmonton GM Ken Holland have all the reason in the world to go out and \r\nget a better goalie? He sure did. Could that failure to do so come back \r\nto haunt him once the playoffs begin? It sure could. Holland had all \r\nseason long to find another netminder, and he knew the deadline was \r\ncoming. It didn’t have to come to this, but now, it has. A goaltending \r\ncrisis may prove to be what sinks the Oilers’ championship aspirations.<br>2.\r\n Toronto Maple Leafs: The Leafs land here with a caveat – namely, the \r\nacknowledgment that Toronto GM Kyle Dubas did improve his blueline and \r\nfourth line of forwards when he acquired D-man Mark Giordano and forward\r\n Colin Blackwell from Seattle on Sunday. However, their most pressing \r\nneed – a veteran goalie to be given a shot at the No. 1 job until Jack \r\nCampbell returns from a rib injury – was not dealt with by the deadline.<br><br>That\r\n means, if rookie netminder Erik Kallgren crumbles under the pressure of\r\n the starter’s role, Leafs head coach Sheldon Keefe will have no other \r\nalternative but to use Petr Mrazek. And anyone who has watched Mrazek’s \r\nrecent games will tell you that’s not a good thing. Mrazek’s .884 SP and\r\n 3.48 goals-against average show his struggles with Toronto this season,\r\n and the pressure is only going to increase on him, whenever the Leafs \r\ndecide to play him. Another soft goal here or there and Mrazek will be \r\nquickly pulled from games.<br><br>Dubas has claimed he waived Mrazek \r\nover the weekend as a salary cap move, but who’s kidding who - you don’t\r\n waive someone you really want to keep around. If, for whatever reason, \r\nanother franchise decided to take a chance on Mrazek – for this year, \r\nand two more years, with a $3.8 million annual cap hit – there would be \r\nlittle in the way of mourning over Mrazek’s departure. Instead, Leafs \r\nbrass now has to be cold-blooded in their analysis and deployment of \r\ngoalies. Campbell and Kallgren will get the first chances to run with \r\nthe No. 1 job, and if they fail, it will fall on Mrazek to get one last \r\nshot at proving himself in Toronto.</span>', 1, 0, '2021-10-20', 'Movie', 4, 8, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage19102021_120026_44-445587_stage-photos-hd.jpg\"]', 1, 0, 29, NULL, NULL, '2021-09-20 23:16:38', '2023-05-07 02:49:23'),
(8, 7, 'James gunn jokingly blames paper Cuts', 'James gunn Jokingly blames Paper cuts for cast\'s emotional reaction to guardians Vol. 3 Script', '<span style=\"color: rgb(16, 38, 74); font-family: Poppins; font-size: 15px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">Greater\r\n Bridgeport – For a few moments on, August 11, 2020, the discussion of \r\nthe ravages from the pandemic of COVID-19 was pushed aside by the \r\nrushing tide of history. Senator Kamala Harris of California became the \r\nnation’s first African American woman nominated for the vice presidency \r\nof the United States. It is a moment to be savored, a time to reflect, \r\nand a new journey to begin. Shirley Chisholm was the first African \r\nAmerican woman elected to Congress, and the first Black major party \r\ncandidate to run for president of the United States. In 1972 she said, \r\n“at present, our country needs women’s idealism and determination, \r\nperhaps more in politics than anywhere else.” The historicity of this \r\nhour reminds us again of that idealism, determination, and authentic \r\nsensitivity we often find in women. It just seems to be a part of who \r\nthey are. It often appears in the way they govern. There is an undying \r\nbelief on the part of women, expressed in the words of former \r\npresidential candidate Hillary Rodham Clinton, “we are agents of change,\r\n we are drivers of progress, we are makers of peace – all we need is a \r\nfighting chance.” This is a bold move on the part of Vice President Joe \r\nBiden. It is another opportunity for our nation to move a little closer \r\ntowards a more perfect union. It is a union for which Dr. Martin Luther \r\nKing, Jr., said, “one day we will judge people not by the color of their\r\n skin but by the content of their character.” While the NAACP does not \r\nendorse candidates, we are compelled to recognize the historic impact of\r\n these rare moments in time. This election will really be for the very \r\nsoul of our nation. As the author James Cone has written When My Soul \r\nLooks Back, “it wonders how I get over.” I can hear the voice of Harriet\r\n Tubman humming. I can hear Ida B. Wells declaring, Fannie Lou \r\nHamersinging, and Shirley Chisholm calling out the words of that old \r\ngospel song “he didn’t bring us this far to leave us.” It is time for \r\neveryone regardless of color, station, or vocation to Take Your Soles To\r\n The Polls. Take them by mail or directly to the voting booth. Let us \r\nVote! Vote!!Vote!!</span><span style=\"color: rgb(51, 51, 51); font-family: &quot;Open Sans&quot;, Arial, Helvetica, sans-serif; font-size: 17.6px;\"></span>', 1, 0, '2021-09-21', 'Movie', 4, 8, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage21092021_054722_list-img-4.jpg\"]', 1, 0, 16, NULL, NULL, '2021-09-20 23:47:22', '2022-04-20 18:54:58'),
(9, 7, 'Historical records offer an unusual window into your family\'s past', 'Historical records offer an unusual window into your family\'s past.', '<span style=\"color: rgb(89, 89, 89); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 15px;\"><span style=\"color: rgb(16, 38, 74); font-family: Poppins; font-size: 15px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">Alejandra Díaz will begin her new job at the Israel Symphony Orchestra Rishon LeZion in March 2022.<br><br>​Díaz\r\n was awarded the LSO String Experience Scheme in 2013 and became the \r\nfirst Spanish cellist in history to perform alongside the London \r\nSymphony Orchestra — as part of two concerts paying tribute to Claudio \r\nAbbado and Pierre Boulez at the Barbican Hall. <br><br>Obtaining a \r\nMasters of Performance at London\'s Guildhall School of Music &amp; Dance\r\n in 2014 under Prof. Ursula Smith, Díaz is a former prize winner of the \r\nCarnegie Palmer Award of the Worshipful Company of Musicians, and a \r\nfinalist of the Pablo Casals International Award.<br><br>As a principal \r\ncellist, she has appeared with the Orquesta Sinfónica Vigo 430, the \r\nAtlantic Coast Orchestra, the London Metropolitan Sinfonia, and the \r\nGuildhall Symphony Orchestra.<br><br>Alongside her performing career, \r\nDíaz holds a Masters in Teaching at the Santiago de Compostela \r\nUniversity — where she currently serves as a cello professor. She also \r\ntaught at the Juan Sebastían Elcano School from 2018-2020.<br><br>Díaz plays on a modern cello by Apostol Kaloferov (c.1990) and a Paolo Pamiro bow made in Málaga (c.2019).​</span>.</span>', 1, 0, '2021-11-03', 'Magic', 4, 8, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage23102021_123028_mic_in_studio.jpeg\"]', 1, 0, 26, NULL, NULL, '2021-09-21 00:00:28', '2022-04-20 23:05:55'),
(11, 10, 'With the Met gala already behind us September’s biggest events have come and gone in a flash', 'With the Met gala already behind us, September’s biggest events have come and gone in a flash. And this includes the long-awaited in-person', '<p style=\"color: rgb(0, 0, 0); font-family: Savoy, helvetica, sans-serif; font-size: 20px;\">With the&nbsp;<a href=\"https://www.vogue.com/slideshow/met-gala-2021-red-carpet-live-celebrity-fashion\" target=\"_blank\" style=\"cursor: pointer; color: rgb(0, 0, 0); transition: color 200ms ease 0s; line-height: inherit; text-decoration-line: underline;\">Met gala</a>&nbsp;already behind us, September’s biggest events have come and gone in a flash. And this includes the long-awaited in-person return of&nbsp;<a href=\"https://www.vogue.com/slideshow/phil-ohs-best-street-style-at-new-york-fashion-week-spring-2022\" target=\"_blank\" style=\"cursor: pointer; color: rgb(0, 0, 0); transition: color 200ms ease 0s; line-height: inherit; text-decoration-line: underline;\">New York Fashion Week</a>. After a handful of seasons viewing the collections virtually, show-going New Yorkers were finally back together to see the collections IRL during five jam-packed days that led up to a night at the museum.</p><p style=\"color: rgb(0, 0, 0); font-family: Savoy, helvetica, sans-serif; font-size: 20px;\">In true New Yorker fashion, street-style usuals like Lauren Santo Domingo,&nbsp;<a href=\"https://www.vogue.com/article/richie-shazam-new-show-shine-true-lucas-silveira\" target=\"_blank\" style=\"cursor: pointer; color: rgb(0, 0, 0); transition: color 200ms ease 0s; line-height: inherit; text-decoration-line: underline;\">Richie Shazam</a>, and Rachel Seville Tashjian opted for all-black ensembles. Whether it was sleek tailoring or interesting silhouettes or&nbsp;<a href=\"https://www.vogue.com/article/classic-boots-fall\" target=\"_blank\" style=\"cursor: pointer; color: rgb(0, 0, 0); transition: color 200ms ease 0s; line-height: inherit; text-decoration-line: underline;\">shoes</a>&nbsp;and accessories, these looks were just as striking as their brightly colored and loud printed counterparts. Head-to-toe black isn’t the least bit dull when&nbsp;<a href=\"https://www.vogue.com/slideshow/cut-out-open-back-summer-trend\" target=\"_blank\" style=\"cursor: pointer; color: rgb(0, 0, 0); transition: color 200ms ease 0s; line-height: inherit; text-decoration-line: underline;\">cutout tops</a>, balloon-shaped pants, or textured fabrics are incorporated. So if you find you’re out of ideas on what to wear, you can never go wrong with the iconic New York uniform—the effortlessly chic and unendingly cool.</p>', 1, 0, '2021-11-04', 'Fashion', 3, 8, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage23102021_082441_women.jpg\"]', 1, 0, 46, NULL, NULL, '2021-09-21 01:13:46', '2023-05-12 03:39:30'),
(12, 10, 'One morning this paris fashion week, I found myself making some unusual plans. I was one of few editors on the ground during the city’s', 'One morning this paris Fashion week, I found myself making some unusual plans. I was one of few editors on the ground during the city’s first shows post-lockdown.', '<span style=\"color: rgb(16, 38, 74); font-family: Poppins; font-size: 15px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">Greater\r\n Bridgeport – For a few moments on, August 11, 2020, the discussion of \r\nthe ravages from the pandemic of COVID-19 was pushed aside by the \r\nrushing tide of history. Senator Kamala Harris of California became the \r\nnation’s first African American woman nominated for the vice presidency \r\nof the United States. It is a moment to be savored, a time to reflect, \r\nand a new journey to begin. Shirley Chisholm was the first African \r\nAmerican woman elected to Congress, and the first Black major party \r\ncandidate to run for president of the United States. In 1972 she said, \r\n“at present, our country needs women’s idealism and determination, \r\nperhaps more in politics than anywhere else.” The historicity of this \r\nhour reminds us again of that idealism, determination, and authentic \r\nsensitivity we often find in women. It just seems to be a part of who \r\nthey are. It often appears in the way they govern. There is an undying \r\nbelief on the part of women, expressed in the words of former \r\npresidential candidate Hillary Rodham Clinton, “we are agents of change,\r\n we are drivers of progress, we are makers of peace – all we need is a \r\nfighting chance.” This is a bold move on the part of Vice President Joe \r\nBiden. It is another opportunity for our nation to move a little closer \r\ntowards a more perfect union. It is a union for which Dr. Martin Luther \r\nKing, Jr., said, “one day we will judge people not by the color of their\r\n skin but by the content of their character.” While the NAACP does not \r\nendorse candidates, we are compelled to recognize the historic impact of\r\n these rare moments in time. This election will really be for the very \r\nsoul of our nation. As the author James Cone has written When My Soul \r\nLooks Back, “it wonders how I get over.” I can hear the voice of Harriet\r\n Tubman humming. I can hear Ida B. Wells declaring, Fannie Lou \r\nHamersinging, and Shirley Chisholm calling out the words of that old \r\ngospel song “he didn’t bring us this far to leave us.” It is time for \r\neveryone regardless of color, station, or vocation to Take Your Soles To\r\n The Polls.<br></span>', 1, 0, '2021-11-04', 'Fashion', 3, 8, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage23102021_062652_card-1.jpg\"]', 1, 0, 27, NULL, NULL, '2021-09-21 03:03:16', '2022-06-22 05:02:10'),
(13, 10, 'He is due to be part of a four-person crew for a planned 11-minute', 'He is due to be part of a four-person crew for a planned 11-minute ride to the edge of space on Tuesday inside his company Blue Origin\'s New Shepard spacecraft', '<div class=\"media-caption\" style=\"margin: 5px 0px 0px; padding: 0px; color: rgb(124, 124, 124); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; font-size: 13px; letter-spacing: 0.5px;\"><span style=\"margin: 0px; padding: 0px; font-weight: bolder;\">Reuters</span></div><div id=\"ad-article-below-feature-image\" class=\"advertisement-image hide-for-mobile-view\" style=\"margin: 10px 0px; padding: 0px; width: 730px; display: flex; align-items: center; justify-content: center; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; text-align: center; color: rgb(50, 50, 50); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; font-size: 13px; letter-spacing: 0.5px;\"></div><div class=\"report-content fr-view\" style=\"margin: 0px; padding: 4px 0px; color: rgb(0, 0, 0); line-height: 20px; white-space: pre-line; overflow-wrap: break-word; overflow: visible; width: 730px; float: left; font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px;\">\r\n<div class=\"highlighted-content\" style=\"margin: 0px; padding: 0px; font-size: 20px;\"><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px;\">He is due to be part of a four-person crew for a planned 11-minute ride to the edge of space on Tuesday inside his company Blue Origin\'s New Shepard spacecraft</p></div>\r\n<p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px;\">Jeff Bezos may have been beaten to space by rival Richard Branson, but the billionaire American businessman is poised to make history next week aboard what would be the world\'s first unpiloted suborbital flight with an all-civilian crew.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px;\">Bezos, the former CEO of Amazon.com Inc, is due to be part of a four-person crew for a planned 11-minute ride to the edge of space on Tuesday inside his company Blue Origin\'s New Shepard spacecraft, another milestone in the nascent and potentially lucrative space tourism sector.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px;\">He is set to be joined by his brother and private equity executive Mark Bezos, trailblazing octogenarian woman aviator Wally Funk and an as-yet-unidentified person who paid $28 million for a spot aboard the spacecraft, scheduled to launch from a West Texas site.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px;\">New Shepard is a 60-foot-tall (18.3-meters-tall) and fully autonomous rocket-and-capsule combo that cannot be piloted from inside the spacecraft. The crew is set to include only civilians and none of Blue Origin\'s employees or staff astronauts, three people familiar with the company\'s plans told Reuters.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px;\">Blue Origin\'s astronauts include NASA space shuttle veteran Nicholas Patrick.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px;\">\"To see the Earth from space, it changes you, it changes your relationship with this planet, with humanity,\" Bezos said in a video last month discussing the flight.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px;\">There has never before been a fully autonomous suborbital or orbital flight with an all-civilian crew, Teal Group space industry analyst Marco Caceres said.</p></div>', 1, 0, '2021-09-21', 'Travel', 3, 8, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage23102021_062930_card-2.jpg\"]', 1, 0, 33, NULL, NULL, '2021-09-21 03:11:57', '2022-04-19 15:56:11'),
(14, 10, 'Unravel the mystery of the sundarbans with go zayaan the best time to visit the sundarbans', 'The best time to visit the sundarbans is winter, especially from november to March.', '<p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">What comes to your mind when you think of Sundarbans? Herds of wild animals, flocks of birds, vast spread across lands and water bodies filled with wilderness? That\'s not all. There is no better place than the Sundarbans if you want to enjoy nature by sitting on the deck of the ship, watching crocodiles sunbathing by the side of the river channels that are spread across the large mangrove forest like spider webs.&nbsp;</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">The best time to visit the Sundarbans is winter, especially from November to March. It’s best to plan and book a tour at least 15 days prior to the journey because one has to take permits from the forest department at least 7 days prior to the tour. One of the leading online travel platforms Go Zayaan is working relentlessly to make these tours available for all types of travellers. Currently, Go Zayaan has introduced three such tours to cater to the demands of travellers of all types. These are:</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\"><span style=\"margin: 0px; padding: 0px; font-weight: 700;\">Grand Cruise from Dhaka</span></p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">This is 4 days 3 nights and the only tour where the journey starts from Dhaka. The tour will have mouth-watering food for all 4 days with A/C cabins, attached washroom, hot water facility, forest fees and permit for local guests, local boat for an exploration of flora and fauna, two armed guards on board at all times and much more.&nbsp;</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">Price starts from BDT 15,000 per person. &nbsp;</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\"><span style=\"margin: 0px; padding: 0px; font-weight: 700;\">Eco River Cruise Experience</span></p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">This is an economical 3 days 2 nights tour where the journey starts from Khulna. The cruise has accommodation on twin sharing basis (2-bed cabin, 4-bed cabin, Non-A/C, Bunk Bed), meals for all 3 days, country boat for exploration, forest fees and permit, accompanied tour guide and much more.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">Price starts from BDT 11,000 per person.&nbsp;</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\"><span style=\"margin: 0px; padding: 0px; font-weight: 700;\">Luxury Cruise from Khulna</span></p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">The most premium 3 days 2 nights cruise for the Sundarbans with swimming pool inside the ship, country boat, meal for all 3 days, forest fees and permits, armed forest guard from forest department and accompanied tour guide.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">Price starts from BDT 18,000 per person.&nbsp;</p>', 1, 0, '2021-11-04', 'Travel', 4, 8, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage23102021_081931_unnamed.jpg\"]', 1, 0, 29, NULL, NULL, '2021-09-21 03:16:03', '2022-10-13 09:42:40'),
(15, 13, 'Bank account details sought to intimidate journalists threat to independent journalism and freedom of expression in Bangladesh', 'Fakhrul termed the incident a threat to independent journalism and freedom of expression in Bangladesh', '<div class=\"media-caption\" style=\"margin: 5px 0px 0px; padding: 0px; color: rgb(124, 124, 124); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; font-size: 13px; letter-spacing: 0.5px;\">File photo of BNP Secretary General Mirza Fakhrul Islam Alamgir</div><div class=\"report-content fr-view\" style=\"margin: 0px; padding: 4px 0px; color: rgb(0, 0, 0); line-height: 20px; white-space: pre-line; overflow-wrap: break-word; overflow: visible; width: 730px; float: left; font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px;\"><div class=\"highlighted-content\" style=\"margin: 0px; padding: 0px; font-size: 20px;\"><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px;\">Fakhrul termed the incident a threat to independent journalism and freedom of expression in Bangladesh</p></div><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px;\">Seeking bank account details of 11 journalist leaders is a new strategy of the government to intimidate the media workers, says BNP Secretary General Mirza Fakhrul Islam Alamgir.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px;\">In a statement on Monday, he said journalists are not spared from repressive acts carried out across the country by the current “authoritarian and fascist” government.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px;\">“This is another new tactic of intimidating journalists by seeking the bank account details of the presidents and general secretaries of the Jatiya Press Club, BUJ, DUJ and DRU after making various efforts to suppress them,” Fakhrul said.</p><hr style=\"margin: 10px 0px; padding: 0px; border-top: 0px; border-bottom: 1px solid rgb(50, 50, 50); clear: both; user-select: none; break-after: page;\"><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px;\">He said this unprecedented incident is an extreme threat to independent journalism and freedom of expression in Bangladesh.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px;\">Bangladesh Financial Intelligence Unit (BFIU) of the Bangladesh Bank issued letters to the commercial banks asking for details of bank accounts of 11 journalist leaders last week.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px;\">Fakhrul said the government is not only oppressing the opposition leaders, human rights activists and dissidents, but also the journalists to perpetuate its power. “The incident of seeking the bank account details of 11 journalist leaders is the manifestation of that.\"</p></div>', 1, 0, '2021-09-15', 'Politics', 3, 8, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage21092021_091847_politics-card-2.jpg\"]', 1, 0, 24, NULL, NULL, '2021-09-21 03:18:47', '2022-07-04 01:23:27'),
(16, 20, 'Barak Obama  Retreat is a Converted Tower on the Greek Coast', 'Greater Bridgeport – For a few moments on, August 11, 2020, the discussion of the ravages from the pandemic of COVID-19 was pushed aside by the rushing tide of history.', '<span style=\"color: rgb(16, 38, 74); font-family: Poppins; font-size: 15px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">Greater\r\n Bridgeport – For a few moments on, August 11, 2020, the discussion of \r\nthe ravages from the pandemic of COVID-19 was pushed aside by the \r\nrushing tide of history. Senator Kamala Harris of California became the \r\nnation’s first African American woman nominated for the vice presidency \r\nof the United States. It is a moment to be savored, a time to reflect, \r\nand a new journey to begin. Shirley Chisholm was the first African \r\nAmerican woman elected to Congress, and the first Black major party \r\ncandidate to run for president of the United States. In 1972 she said, \r\n“at present, our country needs women’s idealism and determination, \r\nperhaps more in politics than anywhere else.” The historicity of this \r\nhour reminds us again of that idealism, determination, and authentic \r\nsensitivity we often find in women. It just seems to be a part of who \r\nthey are. It often appears in the way they govern. There is an undying \r\nbelief on the part of women, expressed in the words of former \r\npresidential candidate Hillary Rodham Clinton, “we are agents of change,\r\n we are drivers of progress, we are makers of peace – all we need is a \r\nfighting chance.” This is a bold move on the part of Vice President Joe \r\nBiden. It is another opportunity for our nation to move a little closer \r\ntowards a more perfect union. It is a union for which Dr. Martin Luther \r\nKing, Jr., said, “one day we will judge people not by the color of their\r\n skin but by the content of their character.” While the NAACP does not \r\nendorse candidates, we are compelled to recognize the historic impact of\r\n these rare moments in time. This election will really be for the very \r\nsoul of our nation. As the author James Cone has written When My Soul \r\nLooks Back, “it wonders how I get over.” I can hear the voice of Harriet\r\n Tubman humming. I can hear Ida B. Wells declaring, Fannie Lou \r\nHamersinging, and Shirley Chisholm calling out the words of that old \r\ngospel song “he didn’t bring us this far to leave us.” It is time for \r\neveryone regardless of color, station, or vocation to Take Your Soles To\r\n The Polls. Take them by mail or directly to the voting booth. Let us \r\nVote! Vote!!Vote!!</span>                                            <div class=\"report-content fr-view\" style=\"margin: 0px; padding: 4px 0px; color: rgb(0, 0, 0); line-height: 20px; white-space: pre-line; overflow-wrap: break-word; overflow: visible; width: 730px; float: left; font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px;\"><br></div>', 1, 0, '2021-09-08', 'world', 4, 8, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage21092021_092123_politics-1.jpg\"]', 1, 0, 15, NULL, NULL, '2021-09-21 03:21:23', '2022-04-19 06:32:08'),
(17, 7, 'Dance at Chapman University offers students', 'The Department of Dance at Chapman University offers students a strong professional dance training program with high quality productions.', '<span style=\"color: rgb(16, 38, 74); font-family: Poppins; font-size: 15px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">The\r\n Department of Dance at Chapman University offers students a strong \r\nprofessional dance training program with high quality productions. \r\nStudents may choose from a pre-professional Bachelor of Fine Arts degree\r\n in Dance Performance or from the more broad based Bachelor of Arts \r\ndegree in Dance. Both degrees provide excellent preparation for those \r\nwho plan to enter the professional dance world and/or attend graduate \r\nschool. The curriculum for dance majors includes course work in \r\nchoreography, dance history, dance production, dance performance, \r\nacting, music for dancers, dance science, dance teaching methods, \r\nballroom, somatics, hip-hop, tap, and comprehensive pre-professional \r\ntraining in modern, jazz and ballet technique. The USC Glorya Kaufman \r\nSchool of Dance offers a Bachelor of Fine Arts to a select number of \r\nundergraduates who wish to pursue dance as their major. This four-year \r\nprofessional degree is housed in the state-of-the-art Glorya Kaufman \r\nInternational Dance Center. USC Kaufman also offers individual classes \r\nin technique, performance, choreography, production, theory and history \r\nthat are open to all students at USC. In addition to the dance major and\r\n open courses, the minor in Dance and minor in Dance in Popular Culture:\r\n Hip-Hop, Urban and Social Dances, provide a rewarding program of study \r\nfor any USC student. A conservatory-based program within a liberal arts \r\nenvironment, we are focused on rigorous training in both ballet and \r\nmodern technique. We are committed to the creation and production of \r\noriginal contemporary choreographic works by students, faculty and guest\r\n artists. The Dance Program is housed in its own state-of-the-art Dance \r\nCentre on a large liberal arts campus. USF is accredited by the National\r\n Association of Schools of Dance (NASD). Students must apply for \r\nadmission and be accepted to the University of South Florida before they\r\n can be accepted as a Dance Major in the School of Theatre and Dance. \r\nAdditionally, all prospective Dance Majors and Dance Minors must \r\naudition during the year prior to their first semester to be accepted \r\ninto the Dance Program.</span>', 1, 0, '2021-09-21', 'entertainment', 3, 8, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage24102021_051716_enter.jpg\"]', 1, 0, 20, NULL, NULL, '2021-09-21 03:24:12', '2022-04-20 13:10:01');
INSERT INTO `news` (`id`, `subcategory_id`, `title`, `summary`, `description`, `status`, `breaking_news`, `date`, `tags`, `speciality_id`, `reporter_id`, `image`, `user_id`, `archive`, `viewers`, `meta_keyword`, `meta_description`, `created_at`, `updated_at`) VALUES
(18, 14, 'Safran innovates to anticipate its customers’', 'Researchers from Switzerland are tapping into an unexpected energy source right under our feet: wooden floorings.', '<span style=\"color: rgb(16, 38, 74); font-family: Poppins; font-size: 15px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">Researchers from Switzerland are tapping into an unexpected energy source right under our feet: wooden floorings. Their nanogenerator, presented September 1 in the journal Matter, enables wood to generate energy from our footfalls. They also improved the wood used in the their nanogenerator with a combination of a silicone coating and embedded nanocrystals, resulting in a device that was 80 times more efficient -- enough to power LED lightbulbs and small electronics.<br><br>The team began by transforming wood into a nanogenerator by sandwiching two pieces of functionalized wood between electrodes. Like a shirt-clinging sock fresh out of the dryer, the wood pieces become electrically charged through periodic contacts and separations when stepped on, a phenomenon called the triboelectric effect. The electrons can transfer from one object to another, generating electricity. However, there\'s one problem with making a nanogenerator out of wood.<br><br>\"Wood is basically triboneutral,\" says senior author Guido Panzarasa, group leader in the professorship of Wood Materials Science located at Eidgenössische Technische Hochschule (ETH) Zürich and Swiss Federal Laboratories for Materials Science and Technology (Empa) Dübendorf. \"It means that wood has no real tendency to acquire or to lose electrons.\" This limits the material\'s ability to generate electricity, \"so the challenge is making wood that is able to attract and lose electrons,\" Panzarasa explains.<br><br>To boost wood\'s triboelectric properties, the scientists coated one piece of the wood with polydimethylsiloxane (PDMS), a silicone that gains electrons upon contact, while functionalizing the other piece of wood with in-situ-grown nanocrystals called zeolitic imidazolate framework-8 (ZIF-8). ZIF-8, a hybrid network of metal ions and organic molecules, has a higher tendency to lose electrons. They also tested different types of wood to determine whether certain species or the direction in which wood is cut could influence its triboelectric properties by serving as a better scaffold for the coating.</span>', 1, 0, '2021-09-21', 'Technology', 3, 8, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage21092021_093128_card-2.jpg\"]', 1, 0, 18, NULL, NULL, '2021-09-21 03:31:28', '2022-04-17 23:20:34'),
(19, 14, 'When walked on, these wooden floors harvest enough energy to turn on a lightbulb', 'Researchers from Switzerland are tapping into an unexpected energy source right under our feet: wooden floorings. Their nanogenerator, presented September 1 in the journal Matter, enables', '<span style=\"color: rgb(16, 38, 74); font-family: Poppins; font-size: 15px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">Researchers from Switzerland are tapping into an unexpected energy source right under our feet: wooden floorings. Their nanogenerator, presented September 1 in the journal Matter, enables wood to generate energy from our footfalls. They also improved the wood used in the their nanogenerator with a combination of a silicone coating and embedded nanocrystals, resulting in a device that was 80 times more efficient -- enough to power LED lightbulbs and small electronics.<br><br>The team began by transforming wood into a nanogenerator by sandwiching two pieces of functionalized wood between electrodes. Like a shirt-clinging sock fresh out of the dryer, the wood pieces become electrically charged through periodic contacts and separations when stepped on, a phenomenon called the triboelectric effect. The electrons can transfer from one object to another, generating electricity. However, there\'s one problem with making a nanogenerator out of wood.<br><br>\"Wood is basically triboneutral,\" says senior author Guido Panzarasa, group leader in the professorship of Wood Materials Science located at Eidgenössische Technische Hochschule (ETH) Zürich and Swiss Federal Laboratories for Materials Science and Technology (Empa) Dübendorf. \"It means that wood has no real tendency to acquire or to lose electrons.\" This limits the material\'s ability to generate electricity, \"so the challenge is making wood that is able to attract and lose electrons,\" Panzarasa explains.<br><br>To boost wood\'s triboelectric properties, the scientists coated one piece of the wood with polydimethylsiloxane (PDMS), a silicone that gains electrons upon contact, while functionalizing the other piece of wood with in-situ-grown nanocrystals called zeolitic imidazolate framework-8 (ZIF-8). ZIF-8, a hybrid network of metal ions and organic molecules, has a higher tendency to lose electrons. They also tested different types of wood to determine whether certain species or the direction in which wood is cut could influence its triboelectric properties by serving as a better scaffold for the coating.</span>', 1, 0, '2021-09-20', 'Technology', 3, 8, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage19102021_120945_software-development.jpg\"]', 1, 0, 46, NULL, NULL, '2021-09-21 03:47:54', '2022-04-17 13:07:24'),
(20, 20, 'Biden\'s first speech as us president to the annual united nations general assembly in new york faces a tough reception', 'Biden\'s first speech as us president to the annual united nations general assembly in new york faces a tough reception', '<div class=\"highlighted-content\" style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-size: 20px; font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\"><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px;\">Biden\'s first speech as US president to the annual United Nations General Assembly in New York faces a tough reception</p></div><span style=\"color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">\r\n</span><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">President Joe Biden will tell the world on Tuesday that the United States wants to avoid a Cold War with China, while pivoting from continuous post-9/11 conflicts to an era of US-led diplomacy.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">Biden\'s first speech as US president to the annual United Nations General Assembly in New York faces a tough reception.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">He has spent his presidency branding countries like China and Russia as the opposing side in a generational, global struggle between autocrats and democracies.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">Close ally France is also furious at what it calls backstabbing by Washington in a defence pact that will see Australia acquire US nuclear submarine technology, while ditching previous plans for French conventional submarines.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">Throw in the hangover from the traumatic Afghanistan exit -- where victorious Taliban guerrillas forced the US-led alliance into a hasty, at times chaotic, withdrawal -- and Biden can expect some scepticism.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">However, Biden will argue from the UN rostrum that the United States is stepping in to save the world from the Covid pandemic, leading on climate crisis measures and rebuilding democratic ties frayed under Donald Trump.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">And he will insist that his drive to deepen the US footprint in Asia -- the new nuclear submarines pact with Australia is only the latest building block -- doesn\'t have to mean confrontation with China.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">Biden will say \"he does not believe in the notion of a new Cold War with the world divided into blocks. He believes in vigorous, intensive, principled competition,\" a senior US official said, speaking on condition of anonymity.</p>', 1, 0, '2021-09-21', 'World', 3, 3, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage21092021_095146_world1.jpg\"]', 1, 0, 14, NULL, NULL, '2021-09-21 03:51:46', '2022-10-15 05:12:25'),
(21, 20, 'World leaders return to un with focus on pandemic, climate', 'Biden will host a virtual meeting from washington with leaders on Wednesday that aims to boost the distribution of vaccines globally', '<div class=\"highlighted-content\" style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-size: 20px; font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\"><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px;\">Biden will host a virtual meeting from washington with leaders on wednesday that aims to boost the distribution of vaccines globally</p></div><span style=\"color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">\r\n</span><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">World leaders are returning to the United Nations in new york this week with a focus on boosting efforts to fight both climate change and the Covid-19 pandemic, which last year forced them to send video statements for the annual gathering.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">As the coronavirus still rages amid an inequitable vaccine rollout, about a third of the 193 UN states are planning to again send videos, but presidents, prime ministers and foreign ministers for the remainder are due to travel to the United States.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">The United States tried to dissuade leaders from coming to New York in a bid to stop the UN General Assembly from becoming a \"super-spreader event,\" although President Joe Biden will address the assembly in person, his first UN visit since taking office.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">A so-called UN honour system means that anyone entering the assembly hall effectively declares they are vaccinated, but they do not have to show proof.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">This system will be broken when the first country speaks - Brazil. Brazilian President Jair Bolsonaro is a vaccine skeptic, who last week declared that he does not need the shot because he is already immune after being infected with Covid-19.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">Should he change his mind, New York City has set up a van outside the United Nations for the week to supply free testing and free shots of the single-dose Johnson &amp; Johnson vaccine.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">UN Secretary-General Antonio Guterres told Reuters that the discussions around how many traveling diplomats might have been immunized illustrated \"how dramatic the inequality is today in relation to vaccination.\" He is pushing for a global plan to vaccinate 70% of the world by the first half of next year.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">Out of 5.7 billion doses of coronavirus vaccines administered around the world, only 2% have been in Africa.&nbsp;</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">Biden will host a virtual meeting from Washington with leaders and chief executives on Wednesday that aims to boost the distribution of vaccines globally.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">Demonstrating US Covid-19 concerns about the UN gathering, Biden will be in New York only for about 24 hours, meeting with Guterres on Monday and making his first UN address on Tuesday, directly after Bolsonaro.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">His UN envoy, Linda Thomas-Greenfield, said Biden would \"speak to our top priorities: ending the Covid-19 pandemic; combating climate change ... and defending human rights, democracy, and the international rules-based order.\"</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">Due to the pandemic, UN delegations are restricted to much smaller numbers and most events on the sidelines will be virtual or a hybrid of virtual and in-person. Among other topics that ministers are expected to discuss during the week are Afghanistan and Iran.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">But before the annual speeches begin, Guterres and British Prime Minister Boris Johnson will start the week with a summit on Monday to try and save a UN summit - that kicks off in Glasgow, Scotland, on October 31 - from failure.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">As scientists warn that global warming is dangerously close to spiraling out of control, the UN COP26 conference aims to wring much more ambitious climate action and the money to go with it from participants around the globe.</p>', 1, 1, '2021-09-20', 'World', 3, 8, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage21092021_095404_world2.jpg\"]', 1, 0, 40, NULL, NULL, '2021-09-21 03:54:04', '2023-05-07 02:40:03'),
(22, 20, 'New york to attend 76th United nations general assembly', 'This is the premier’s first foreign tour after a year and a half since she visited Italy in February 2020 before the coronavirus pandemic lockdowns began', '<div class=\"highlighted-content\" style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-size: 20px; font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\"><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px;\">This is the premier’s first foreign tour after a year and a half since she visited Italy in February 2020 before the coronavirus pandemic lockdowns began</p></div><span style=\"color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">\r\n</span><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">Prime Minister Sheikh Hasina reached the USA on Sunday evening to attend the 76th United Nations General Assembly (UNGA).</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">\"A VVIP chartered flight of Biman Bangladesh Airlines (BG-1902) carrying the premier and her entourage members arrived at 5:40pm (local time) on Sunday in the John F Kennedy International Airport in New York,\" Prime Minister\'s Press Secretary Ihsanul Karim told BSS.<span style=\"font-size: 1rem;\">Bangladesh Ambassador to the USA M Shahidul Isalm and Bangladesh Permanent Representative to the United Nations (UN) Ambassador Rabab Fatima received the premier at the airport, he said.</span></p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">Foreign Minister Dr A K Abdul Momen, and State Minister for Foreign Affairs Md Shahriar Alam, among others, are accompanying the prime minister.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">A ceremonial motorcade later escorted Sheikh Hasina to Lotte New York Palace where she will be staying during her stay in the USA.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">After a two-day stopover in Helsinki, the premier left the Helsinki-Vantaa Airport for New York at 4:16 pm (Finnish capital time).</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">Earlier, on September 17, Prime Minister Sheikh Hasina reached Helsinki en route to New York, USA to attend the 76th UNGA.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">The premier and her entourage members departed from the Hazrat Shahjalal International Airport (HSIA), Dhaka for Helsinki at 9:23 am on the same day.</p>', 1, 1, '2021-09-20', 'World', 4, 8, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage19102021_123338_55920270_303.jpg\"]', 1, 0, 28, NULL, NULL, '2021-09-21 04:02:46', '2023-05-07 03:30:59'),
(23, 17, 'A woman gave birth to a baby boy on a plane in  Paris early tuesday morning.', 'Both the mother and her newborn are now healthy.', '<div class=\"highlighted-content\" style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-size: 20px; font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\"><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px;\">Both the mother and her newborn are now healthy</p></div><span style=\"color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">\r\n</span><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">A woman gave birth to a baby boy on a plane in&nbsp; Paris early Tuesday morning.&nbsp;</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">Both the mother and her newborn are now well, say doctors.&nbsp;</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">The incident took place at 2:30am on an overnight “Emirates” coach to France.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">The woman, along with her husband, was heading to her father\'s house in India from France.&nbsp;</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">As the bus reached Parisin Chittagong, she went into full labour and started to feel severe contractions.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">So, the driver puller over at the Paris province Health Complex, allowing some passengers to call on the on-duty doctor at the emergency department.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">“When the midwives and nurses from the hospital arrived on scene, the woman was in no condition to be moved to the hospital. So, they decided to go for a normal delivery on the bus,” said Paris province Health Complex Residential Medical Officer (RMO) Sadia Akhter.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">“Both the mother and her newborn baby boy now are healthy. They have been kept under observation at the hospital,” she added.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">She expressed her gratitude towards the bus driver and passengers for coming forward to help the pregnant mother in need.</p>', 1, 1, '2021-09-20', 'National', 3, 8, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage19102021_123027_1200x627-1555612902443.jpg\"]', 1, 0, 53, NULL, NULL, '2021-09-21 04:06:44', '2022-10-25 03:21:16'),
(24, 17, 'The seven-member group filmed a music video in the world body’s New York headquarters', 'The seven-member group filmed a music video in the world body’s New York headquarters over the weekend', '<div class=\"highlighted-content\" style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-size: 20px; font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\"><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px;\">The seven-member group filmed a music video in the world body’s New York headquarters over the weekend</p></div><span style=\"color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">\r\n</span><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">Fully vaccinated South Korean band BTS danced its way through the United Nations in a Monday broadcast, promoting global goals tackling poverty, inequality, injustice and climate change ahead of the annual UN gathering of world leaders.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">The seven-member group filmed a music video to its song “Permission to Dance” in the world body’s New York headquarters over the weekend, dancing through the General Assembly hall and out into the gardens. It was broadcast during an event on the Sustainable Development Goals.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">BTS - whose members declared they were all fully vaccinated against COVID-19 - also appeared in person at the event in the General Assembly, introduced by South Korean President Moon Jae-in. They are the UN’s Special Presidential Envoys for Future Generations and Culture.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">They shared their thoughts and those of young people worldwide on the past two years and the future, expressing their frustration during the pandemic.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">“I was saddened to hear that entrance and graduation ceremonies had to be canceled,” said Jeon Jung-Kook, known as Jungkook. “These are moments in life you want to celebrate and missing out on them must have been upsetting. We were heartbroken when our long-planned concert tours were canceled.”</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">They praised the resilience of youth, saying they were not “COVID’s lost generation.”</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">“I think it’s a stretch to say they’re lost just because paths they tread can’t be seen by grown-up eyes,” said BTS group leader Kim Nam-Joon, known as RM.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px; color: rgb(0, 0, 0); font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\">Kim Seok-Jin, known as Jin, added: “Instead of the ‘lost generation’ a more appropriate name would be the ‘welcome generation’ because instead of fearing change, this generation says ‘welcome’ and keeps forging ahead.”&nbsp;</p>', 1, 1, '2021-11-04', 'National', 3, 8, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage21092021_100910_national2.jpg\"]', 1, 0, 262, NULL, NULL, '2021-09-21 04:09:10', '2023-05-06 03:20:06'),
(25, 17, 'Serena Williams on Her Star-Studded Gucci Bodysuit', '“Fashioning Masculinities,” the V&A’s New Show, Proves That Gender Has Always Been a Construct.', '<div class=\"highlighted-content\" style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-size: 20px; font-family: roboto, sans-serif, &quot;siyam rupali&quot;; letter-spacing: 0.5px; white-space: pre-line;\"><p dir=\"ltr\" style=\"margin-right: 0px; margin-left: 0px; padding: 0px; line-height: 24px;\"><span style=\"color: rgb(16, 38, 74); font-family: Poppins; font-size: 15px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">I’m staring at a giant plaster fig leaf in a cabinet at the V&amp;A. This modesty-saving Victorian codpiece was hastily made to cover the Down There on Michelangelo’s David, shortly after Queen Victoria had been horrified at the sight of the stark naked plaster cast of the classic Renaissance sculpture—a shock she experienced in 1857, at the opening of her own museum, the Victoria &amp; Albert.<br><br>This big, veined fake fig leaf is an opening gambit in the “Undressed” introduction to “Fashioning Masculinities: The Art of Menswear,” the new Gucci-sponsored exhibition at the V&amp;A. It’s positioned right across from a pair of late-1980s fig leaf-printed briefs by Vivienne Westwood, a 1996 Jean Paul Gaultier trompe l’oeil Greek god torso blazer, and an installation of 2021 underwear for transgender men and transmasculine non-binary people by gc2b and Paxies.<br><br>Cleverly, “Undressed” starts us off with a confrontation with the dominant Western European archetypes of the male body. By way of an edit of the plaster-casts that began the V&amp;A’s original art-educational collection, it argues that everything can be traced back to men comparing themselves to the iconography of classical Greek, Roman, and Renaissance sculpture. Take Hercules, with his bulging muscles: “The normalization of hyper-masculinity like this has spawned contemporary gym culture,” reads a caption (we see a 1990s Calvin Klein underwear ad nearby). Or the boyish body of Hermes: “The idolization of youth resonates in the treatment of young male models and performers.” Never a truer word, when you think of Hedi Slimane’s abiding adherence to the straight up-and-down teenage body. One of Slimane’s Dior Homme motorcycle jackets and skinny tailored trousers, with which he dramatically narrowed menswear proportions in the early 2000s, is in the show. That it looks so unremarkable 20 years later is testament to the sweeping influence of his look, for a good few years.<br>Image may contain Human Person Mannequin and Shop</span></p></div>', 1, 0, '2021-09-14', 'National', 4, 8, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage23102021_065512_slider-1.jpg\"]', 1, 0, 148, NULL, NULL, '2021-09-21 04:12:35', '2023-05-06 02:18:59'),
(26, 30, 'Tourists will soon be able to visit beautiful villages along Indo-China border.', 'Tourists will soon be able to visit beautiful villages along Indo-China border.', '<span style=\"color: rgb(16, 38, 74); font-family: Poppins; font-size: 15px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">The Union government has announced plans to open the villages along the Chinese border for tourists under the Vibrant Village programme. With regard to this, the Ministry of Home Affairs (MHA) held a meeting with public representatives of such villages from a number of states, including Uttarakhand, Himachal Pradesh, Sikkim, the Union Territory of Ladakh, and Arunachal Pradesh.<br><br>As per the revised Border Areas Development Plan (BADP), there are around 198 villages within the 242 km border of Himachal Pradesh with China. To start with, those villages will be taken up on priority that are situated within a 10 km distance from the last border village.<br><br>Reports have it that the last village on the border will be spotted from where an arch will be drawn to select villages that fall within the 10 km distance for development, and setting up of all necessary facilities. This will in turn help to integrate the border villages and also check the migration of tribal people.<br><br>Chitkul, Chango, and Namgia are some of the villages that are situated closest to the international border. And there are nine passes (seven in Kinnaur, two in Lahaul and Spiti) along the international boundary between India and China.<br><br>Chief Secretary Ram Subhag Singh said that the detailed project reports (DPRs) for the development of border villages are being prepared under the Vibrant Villages Programme to avail the benefits of the scheme in the next financial year (2022-23). He further added that talks have been held with the Secretary Border Management and the Deputy Commissioners of Kinnaur and Lahaul and Spiti districts have been sensitized.<br><br>Under the BADP, the selected villages will be provided livelihood and all things required to fill the critical gaps with focus on developing tourist sites, strengthening communication, accessible road connectivity, and other facilities. </span><span style=\"text-align: justify;\"></span>', 1, 0, '2021-10-13', 'travel', 3, 8, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage19102021_094712_photo-1503220317375-aaad61436b1b.jpg\"]', 1, 0, 24, NULL, NULL, '2021-10-13 04:39:35', '2022-04-19 10:26:10'),
(27, 17, 'U.S. fuel markets are getting even tighter as Europe’s scramble', 'U.S. fuel markets are getting even tighter as Europe’s scramble for alternatives to Russian diesel flipped New York from a typical import region to an exporter.', '<span style=\"color: rgb(16, 38, 74); font-family: Poppins; font-size: 15px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">U.S. fuel markets are getting even tighter as Europe’s scramble for alternatives to Russian diesel flipped New York from a typical import region to an exporter.<br><br>In a rare reversal of normal trade flows, New York is sending two diesel cargoes to Europe — which relies on Russia for about a third of its diesel needs — even as regional inventories are at multiyear lows and prices hover close to record highs. <br><br>The flip-flop is an example of how Russia’s invasion of Ukraine is rattling fuel markets around the globe, even though the U.S. is relatively less exposed to Russian exports. High pump prices in the U.S. have become a liability for President Joe Biden, and the burden is growing for truckers and farmers. <br><br>Two tankers, the Falcon Nostos and the Energy Centaur, are carrying more than 700,000 barrels of diesel from New York to Europe, according to Vortexa, Kpler, as well as shipping data compiled by Bloomberg. This is a reversal of recent trade flows, which saw cold-gripped New York Harbor import at least 4.5 million barrels of diesel from Europe and Russia since the start of the year for power generation and home heating. <br><br>Diesel exports from the Gulf coast to Europe are also picking up, with around 103,000 barrels a day heading to the continent so far this month, compared with 19,000 in February, Kpler estimates. This trade route is more common, although it has diminished in the last year or two, with Latin America absorbing much of the U.S. export diesel market. <br><br>But the flow of U.S. clean products will “redirect toward Europe if European buyers are less willing to lift out of Russia,” said Reid I’anson, senior commodity economist at Kpler. <br><br>The transatlantic diesel pull is taking place even as Russian-origin cargoes continue to discharge at European ports. The U.K. has said it will phase out imports of Russian oil, including diesel. <br><br>The arbitrage to ship diesel from the U.S. to Europe remains largely shut on paper, traders say. This means cargo movers risk taking a loss, especially considering the sharp backwardation in the European diesel market — a condition where prices for future deliveries are priced below prompt levels. <br><br>“It’s all a gamble,” one trader said.</span>', 1, 1, '2021-10-13', 'national', 3, 8, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage13102021_064050_Unravel the Mystery of the Sundarbans with Go Zayaan.jpg\"]', 1, 0, 33, NULL, NULL, '2021-10-13 04:40:50', '2022-04-19 20:17:40'),
(28, 7, 'East bengal and kerala blasters have lost most number of east bengal and kerala blasters have.', 'East bengal and kerala blasters have lost most number of east bengal and kerala blasters have.', '<span style=\"color: rgb(16, 38, 74); font-family: Poppins; font-size: 15px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">Alejandra Díaz will begin her new job at the Israel Symphony Orchestra Rishon LeZion in March 2022.<br><br>​Díaz was awarded the LSO String Experience Scheme in 2013 and became the first Spanish cellist in history to perform alongside the London Symphony Orchestra — as part of two concerts paying tribute to Claudio Abbado and Pierre Boulez at the Barbican Hall. <br><br>Obtaining a Masters of Performance at London\'s Guildhall School of Music &amp; Dance in 2014 under Prof. Ursula Smith, Díaz is a former prize winner of the Carnegie Palmer Award of the Worshipful Company of Musicians, and a finalist of the Pablo Casals International Award.<br><br>As a principal cellist, she has appeared with the Orquesta Sinfónica Vigo 430, the Atlantic Coast Orchestra, the London Metropolitan Sinfonia, and the Guildhall Symphony Orchestra.<br><br>Alongside her performing career, Díaz holds a Masters in Teaching at the Santiago de Compostela University — where she currently serves as a cello professor. She also taught at the Juan Sebastían Elcano School from 2018-2020.<br><br>Díaz plays on a modern cello by Apostol Kaloferov (c.1990) and a Paolo Pamiro bow made in Málaga (c.2019).​</span>', 1, 0, '2021-10-13', 'world', 3, 8, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage24102021_051048_weekend-entertainment-SPh.jpg\"]', 1, 0, 41, NULL, NULL, '2021-10-13 04:41:51', '2022-04-18 12:07:33'),
(29, 14, 'A new control technology has been developed by scientists for a four-legged robot', 'A new control technology has been developed by scientists for a four-legged robot that allowed it to achieve the “effortless” superhuman feat of hiking 120 vertical metres in the Alps in 31 minutes without any falls or missteps.', '<h4 style=\"margin: 12px 0px 0px; font-weight: 700; line-height: 30px; font-size: 20px; padding: 0px; border: 0px; font-family: Jost, sans-serif;\"><span style=\"color: rgb(16, 38, 74); font-family: Poppins; font-size: 15px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">A\r\n new control technology has been developed by scientists for a \r\nfour-legged robot that allowed it to achieve the “effortless” superhuman\r\n feat of hiking 120 vertical metres in the Alps in 31 minutes without \r\nany falls or missteps.<br><br>The advance may lead to the development of\r\n new robots and other kinds of robotic technology that can be used in \r\nterrain too dangerous for humans, said the researchers, including those \r\nfrom ETH Zurich in Switzerland.<br><br>The ANYmal quadrupedal robot \r\nsuccessfully finished the hike – which consisted of steep sections on \r\nslippery ground, high steps and forest trails full of roots – four \r\nminutes faster than the estimated duration for human hikers, according \r\nto the study, published Wednesday in the journal Science Robotics.<br><br>“The\r\n robot has learned to combine visual perception of its environment with \r\nproprioception – its sense of touch – based on direct leg contact. This \r\nallows it to tackle rough terrain faster, more efficiently and, above \r\nall, more robustly,” study co-author Marco Hutter from ETH Zurich said \r\nin a statement.<br><br>While humans and other animals handle slippery or\r\n soft ground by combining the visual perception of their environment \r\nwith the proprioception of their legs and hand, researchers said legged \r\nrobots have been able to do this only to a “limited extent” until now.<br>They\r\n said this was mainly because information about the immediate \r\nenvironment recorded in such robots by laser sensors and cameras was \r\noften “incomplete and ambiguous”.<br><br>Citing an example of such \r\nambiguous perception, researchers said tall grass, shallow puddles or \r\nsnow appeared as “insurmountable obstacles” or were partially invisible \r\nfor these robots, even when they could potentially traverse them.<br><br>In\r\n addition, they said depth perception could be poor in some cases due to\r\n difficult lighting, dust, fog, reflective or transparent surfaces or \r\nother factors.</span><br></h4>', 1, 0, '2021-10-19', 'technology', 3, 8, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage30012022_034527_card_2.jpg\"]', 1, 0, 16, NULL, NULL, '2021-10-19 10:11:51', '2022-04-20 18:55:26'),
(30, 7, 'Steve Cohen’s dazzling live show, performed weekly', 'Steve Cohen’s dazzling live show, performed weekly', '<span style=\"margin: 0px; padding: 0px; border: 0px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-weight: 400; font-stretch: inherit; font-size: 16px; line-height: inherit; font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; vertical-align: baseline; color: rgb(45, 46, 47); letter-spacing: normal; orphans: 2; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"></span><span style=\"color: rgb(16, 38, 74); font-family: Poppins; font-size: 15px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">The\r\n Department of Dance at Chapman University offers students a strong \r\nprofessional dance training program with high quality productions. \r\nStudents may choose from a pre-professional Bachelor of Fine Arts degree\r\n in Dance Performance or from the more broad based Bachelor of Arts \r\ndegree in Dance. Both degrees provide excellent preparation for those \r\nwho plan to enter the professional dance world and/or attend graduate \r\nschool. The curriculum for dance majors includes course work in \r\nchoreography, dance history, dance production, dance performance, \r\nacting, music for dancers, dance science, dance teaching methods, \r\nballroom, somatics, hip-hop, tap, and comprehensive pre-professional \r\ntraining in modern, jazz and ballet technique. The USC Glorya Kaufman \r\nSchool of Dance offers a Bachelor of Fine Arts to a select number of \r\nundergraduates who wish to pursue dance as their major. This four-year \r\nprofessional degree is housed in the state-of-the-art Glorya Kaufman \r\nInternational Dance Center. USC Kaufman also offers individual classes \r\nin technique, performance, choreography, production, theory and history \r\nthat are open to all students at USC. In addition to the dance major and\r\n open courses, the minor in Dance and minor in Dance in Popular Culture:\r\n Hip-Hop, Urban and Social Dances, provide a rewarding program of study \r\nfor any USC student. A conservatory-based program within a liberal arts \r\nenvironment, we are focused on rigorous training in both ballet and \r\nmodern technique. We are committed to the creation and production of \r\noriginal contemporary choreographic works by students, faculty and guest\r\n artists. The Dance Program is housed in its own state-of-the-art Dance \r\nCentre on a large liberal arts campus. USF is accredited by the National\r\n Association of Schools of Dance (NASD). Students must apply for \r\nadmission and be accepted to the University of South Florida before they\r\n can be accepted as a Dance Major in the School of Theatre and Dance. \r\nAdditionally, all prospective Dance Majors and Dance Minors must \r\naudition during the year prior to their first semester to be accepted \r\ninto the Dance Program.</span><span style=\"margin: 0px; padding: 0px; border: 0px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-weight: 400; font-stretch: inherit; font-size: 16px; line-height: inherit; font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; vertical-align: baseline; color: rgb(45, 46, 47); letter-spacing: normal; orphans: 2; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><span style=\"margin: 0px; padding: 0px; border: 0px; font: inherit; vertical-align: baseline;\"></span></span>', 1, 0, '2021-10-19', 'movie', 3, 2, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage24102021_034150_dj.jpg\"]', 1, 0, 29, NULL, NULL, '2021-10-19 10:17:23', '2022-07-03 05:09:15');
INSERT INTO `news` (`id`, `subcategory_id`, `title`, `summary`, `description`, `status`, `breaking_news`, `date`, `tags`, `speciality_id`, `reporter_id`, `image`, `user_id`, `archive`, `viewers`, `meta_keyword`, `meta_description`, `created_at`, `updated_at`) VALUES
(32, 14, 'Spider Man Wallpapers A collection of the top 45 Spider Man wallpapers and backgrounds available', 'There has been a lot of speculation about which characters are set to appear in Spider-Man.', '<span style=\"color: rgb(16, 38, 74); font-family: Poppins; font-size: 15px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">There has been a lot of speculation about which characters are set to appear in Spider-Man. No Way Home, beyond the previously confirmed appearances of Benedicts Cumberbatch and Wong as Doctor Strange and his sassy partner Wong.<br><br>We\'ve also heard that a number of actos from classic (read: non-MCU) films would be returning to their roles, including Jamie Foxx as Electro and Alfred Molina as Doctor Octopus. Early rumors also speculated that Charlie Cox might reprise his role as Matt Murdock, and mark the first time the character has appeared on the big screen since the disastrous 2003 Daredevil movie.<br><br>More recently those rumors changed, and suggested that both Tobey Maguire and Andrew Garfield would be reprising role as Peter Parker from previous Spider-Man movies. We\'re not going to spoil anything here, but the big topic at hand right now is the fans demand for Amazing Spider-Man 3.<br><br>Those rumors also claimed that Kirsten Dunst and Emma Stone may also be returning as Mary Jane Watson and Gwen Stacey.<br><br>But rumors are rumors, and should be treated as such until Marvel and Sony confirms or denies their legitimacy. Here\'s who we know is going to star in the movie, based on official announcements and the newly-released teaser trailer.<br>Speaking of Zendaya and Batalon, Holland\'s been quoted as saying \"We\'ve been making these films for five years now ... We\'ve had such an amazing relationship, the three of us. We\'ve been with each other every step of the way. We\'ve done every single film, every single press tour. So this one scene, [we didn\'t know] if this would be the last time [we were all working together,]\" — which makes us wonder if one of them isn\'t making it to another Spider-movie.<br>Advertisement<br><br>In the Venom 2 post-credits scene, we saw two huge things, one more subtle than the other. The more obvious moment came as we saw J.K. Simmons as J. Jonah Jameson, yelling about how Peter Parker is Spider-Man. This ties things directly into the end of Far From Home, and when Venom licked the screen (with Spidey on it), we got the distinct impression that Eddie Brock and his symbiote may appear in Spider-Man: No Way Home.<br><br>But, before that, we saw a gigantic explosion in the sky. It seemed as if the timeline-shattering events from the Loki finale may have been what triggered this dimensions-shattering event. <br><br></span><span style=\"color: rgb(0, 0, 0); font-family: Helvetica; text-align: center;\"></span>', 1, 0, '2021-11-03', 'spider', 3, 8, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage30012022_035946_spider_man.jpg\"]', 1, 0, 15, NULL, NULL, '2021-10-21 09:42:22', '2022-04-20 04:44:15'),
(33, 17, 'Shopping for a Used Car  reliability and dependability are important factors', 'If you’re shopping for a car, reliability and dependability are important factors — particularly when looking for a used car. Well,', '<span style=\"color: rgb(255, 255, 255); font-family: designk-medium, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 20px;\"><span style=\"color: rgb(16, 38, 74); font-family: Poppins; font-size: 15px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">At 190.8 inches long with a 114.2-inch wheelbase, the Grecale is a bit larger than the Stelvio and Macan but has similar proportions, with a rounded greenhouse and a relatively low nose. Its grille shape and vertically oriented headlights reference the mid-engine MC20 supercar’s and represent Maserati’s latest design language that’s distinct from what we see on the older Levante, Ghibli, and Quattroporte models.<br>Maserati claims the four-cylinder models will get to 60 mph in the low-5.0-second range, while the Trofeo is clearly aiming for the Porsche Macan GTS, BMW X3 M, and other performance SUVs with its claimed run to 60 mph in 3.6 seconds and top speed of 177 mph. An eight-speed automatic transmission and all-wheel drive are standard across the board. An air suspension and adaptive dampers are optional on the four-cylinder variants and standard on the Trofeo. The performance model also gets 21-inch wheels and upgraded brakes, and both the Modena and Trofeo\'s rear tires are wider than their fronts.<br><br>The Grecale’s interior is more screen-heavy than any Maserati we’ve seen before. Both the digital gauge cluster and central infotainment screens measure 12.3 inches, and there’s also a smaller 8.8-inch touchscreen lower on the dash that controls various climate and vehicle functions. Even the clock on top of the dash is digital, although its display mimics an analog watch face. Various interior trim options include open-pore wood, gloss-black inserts, and contrasting stitching, while the Trofeo has carbon-fiber trim and a different pattern for the leather upholstery.<br><br>Maserati has priced the Grecale ambitiously, as it starts at $64,995 for the base GT model, significantly more than the $56,250 base Macan. A Modena Limited Edition will be available for reservations first, starting at $78,895. Pricing for the Trofeo is not yet available but it will likely start above $80,000. The Grecale will go on sale in the U.S. this summer.</span> Tell</span><span style=\"color: rgb(255, 255, 255); font-family: designk-medium, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 20px;\"> gives you power for wherever the road takes you. This award-winning vehicle offers impressive handling and power, advanced technology, and a spacious interior designed for passenger comfort.&nbsp;</span>', 1, 0, '2021-11-04', 'car', 3, 2, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage21102021_114946_car 1.jpg\"]', 1, 0, 19, NULL, NULL, '2021-10-21 09:49:46', '2022-04-20 11:14:38'),
(34, 17, 'Delicious hot air balloons like candy hd mirror wallpaper Delicious hot air balloons like candy  Delicious', 'Delicious hot air balloons like candy', '<span style=\"color: rgb(16, 38, 74); font-family: Poppins; font-size: 15px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">Quebec athletes Lysanne Richard and Yves Milord are making a splash in the world of high diving, and have set a new world record.<br><br>The duo performed a synchronized dive last week, launching themselves from two hot-air balloons in flight into the waters of the Richelieu River.<br><br>According to a release, the divers set the new world record by jumping from small platforms rigged on the edge of the balloons’ baskets with Richard front flipping from a height of 25 metres, and Milord from a height of 23 metres.<br><br>Richard, a mother of three, has already made a name for herself in the world of high diving, with 14 podiums including three victories in the Red Bull Cliff Diving circuit. She was also named Top Diving Athlete of the Year in 2016 after a World Cup victory in Abu Dhabi.<br>The idea for the record-making dive first came to Richard in 2016, a release said, but her dream really came to life through a partnership with the International de montgolfières de Saint-Jean-sur-Richelieu, organizers of an annual international ballooning festival southeast of Montreal.<br><br>Last week’s dive required a team of 40 professionals including experienced balloon pilots to bring the project to fruition.<br><br>Some of the challenges included establishing a hot-air balloon safety committee to determine the ideal flying conditions, analyzing the water in the river and building custom platforms.<br><br>Organizers said unlike other aircrafts, you can’t steer a hot-air balloon.<br><br>“The pilot and their team have to accurately judge wind direction and speed, which greatly varies with altitude and weather, in order to maneuver the balloon towards the target location and the required water depth for the dive.”<br><br>Preparations included practicing jumps into an air mattress from a balloon anchored to the ground and diving into water at the Flintkote quarry in Thetford Mines.<br><br>And while the stunt was months in the making, the actual dives were only three seconds long as Richard and Milord twisted through the air at speeds more than 70 kilometres per hour.</span>', 1, 0, '2021-11-03', 'air ballon', 3, 2, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage21102021_115531_air b.png\"]', 1, 0, 29, NULL, NULL, '2021-10-21 09:55:31', '2022-07-03 05:44:14'),
(35, 20, 'Patricia urquiola Coats transparent glas tables for livings in were front  Patricia urquiola glas tables for livings', 'The Government Medical College (GMC) of Amritsar has banned girls from wearing skirts, t-shirts, jeans and shorts in the college premises.', '<span style=\"color: rgb(16, 38, 74); font-family: Poppins; font-size: 15px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">Boys have also been asked to wear formal trousers instead of jeans, according to a circular issued by college Principal Sujata Sharma.<br><br>The head of the department has been asked to ensure that the dress code is followed by all the students, it said. Boys have also been asked to wear formal trousers instead of jeans, according to a circular issued by college Principal Sujata Sharma.The new dress code will come into effect from October 1.<br>A group of students, led by their leader Mansimrat Singh, Wednesday met the college principal, requesting her to withdraw the circular.<br>The head of the department has been asked to ensure that the dress code is followed by all the students, it said. Boys have also been asked to wear formal trousers instead of jeans, according to a circular issued by college Principal Sujata Sharma.The new dress code will come into effect from October 1.<br>A group of students, led by their leader Mansimrat Singh, Wednesday met the college principal, requesting her to withdraw the circular.<br><br>However, Sharma declined to withdraw it, the students said.</span><span style=\"color: rgb(15, 15, 15); font-family: &quot;Chronicle Text G1 A&quot;, &quot;Chronicle Text G1 B&quot;, serif; font-size: 16.2px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\"></span>', 1, 0, '2021-10-21', 'justin', 3, 3, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage23102021_070441_girl2.jpg\"]', 1, 0, 13, NULL, NULL, '2021-10-21 10:03:36', '2022-04-20 08:54:06'),
(36, 20, 'Taina blue retreat is a converted tower on the greek coast', 'Canadian prime minister Justin Trudeau said he\'s apologized to the reporter who accused him of groping her', 'Canadian prime minister Justin Trudeau said he\'s apologized to the reporter who accused him of groping her', 1, 0, '2021-10-21', 'world golbe', 3, 2, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage23102021_070202_politics-card-3.jpg\"]', 1, 0, 16, NULL, NULL, '2021-10-21 10:13:22', '2022-04-19 09:23:31'),
(37, 3, 'A matter of Imfact ou didn t find the perfect wallpaper to beautify your desktop', 'bmw automotive wallpaper and high resolution images. you didn t find the perfect wallpaper to beautify your desktop or homescreen.', '<span style=\"color: rgb(16, 38, 74); font-family: Poppins; font-size: 15px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">CNBC’s Jim Cramer on Tuesday warned investors against buying unprofitable stocks due to unwarranted optimism about the stock market.<br><br>“While I appreciate hope as a mindset, I’m not as confident as a lot of the buyers who are paying up. ... We are seeing a level of enthusiasm here that to me feels unjustified. We shouldn’t be going back to a mentality where we like all stocks because so many of them will miss their numbers and still others will hit us with negative forecasts,” the “Mad Money” host said.<br><br>“Right now, we need to bow down to the Fed and the forces of inflation. Anything that brings down inflation, including tough statements from [Fed Chair] Jay Powell, will make big institutional money managers more likely to buy stocks rather than sell them. For the moment, that’s what controls the stock market,” added Cramer, who defended Powell against critics on Monday.<br><br>Cramer’s comments come a day after the Fed Chair Jerome Powell vowed to take aggressive action against inflation, including possibly implementing half-basis point interest increases, a week after instituting the first rate hike in over three years.<br><br>A company that has high stock prices won’t necessarily stay that way in a volatile market, even if it is performing well, Cramer said.<br><br>“There are periods, extreme periods, where the economy gets so out of whack that the stock market itself becomes a pariah asset class, a source of funds for other asset classes, so an individual company’s merits simply won’t be reflected in its share price,” Cramer said.<br><br>Cramer, who has touted a strategy of investing in profitable companies for months, also advised investors to refrain from picking up uninvestable stocks like floundering IPOs and SPACs.<br><br>“Tons of those stocks just aren’t worth much, regardless of whether Powell steers us into a soft landing or a hard landing,” he said.</span>', 1, 0, '2021-11-03', 'business', 3, 3, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage23102021_122605_business.jfif\"]', 1, 0, 117, NULL, NULL, '2021-10-21 10:17:32', '2022-07-04 02:42:41'),
(38, 1, 'Ice hockey Pictures the contemporary sport of ice hockey was developed in Canada, most notably', 'A couple of teams had a slow trade deadline day and that might hurt them down the stretch. Here are four teams that didn\'t do enough over the past few days.', '<span style=\"color: rgb(16, 38, 74); font-family: Poppins; font-size: 15px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">It’s been a day since the NHL’s 2021-22 trade deadline, and in addition to the joy felt in markets that did well on the trade front, there’s already angst, criticism and condemnation for various reasons in other NHL cities. In no particular order, let’s take a brief look at the losers at Deadline Day:<br><br>1. Edmonton Oilers: They’ve been getting improved goaltending of late, but the Oilers not too long ago were in goalie hell with their current pair of Mikko Koskinen and Mike Smith. In Koskinen’s past two games, he’s put in sub-.900 save percentages, and in two of his past five appearances, Smith has posted a sub.860 SP.<br><br>Did Edmonton GM Ken Holland have all the reason in the world to go out and get a better goalie? He sure did. Could that failure to do so come back to haunt him once the playoffs begin? It sure could. Holland had all season long to find another netminder, and he knew the deadline was coming. It didn’t have to come to this, but now, it has. A goaltending crisis may prove to be what sinks the Oilers’ championship aspirations.<br>2. Toronto Maple Leafs: The Leafs land here with a caveat – namely, the acknowledgment that Toronto GM Kyle Dubas did improve his blueline and fourth line of forwards when he acquired D-man Mark Giordano and forward Colin Blackwell from Seattle on Sunday. However, their most pressing need – a veteran goalie to be given a shot at the No. 1 job until Jack Campbell returns from a rib injury – was not dealt with by the deadline.<br><br>That means, if rookie netminder Erik Kallgren crumbles under the pressure of the starter’s role, Leafs head coach Sheldon Keefe will have no other alternative but to use Petr Mrazek. And anyone who has watched Mrazek’s recent games will tell you that’s not a good thing. Mrazek’s .884 SP and 3.48 goals-against average show his struggles with Toronto this season, and the pressure is only going to increase on him, whenever the Leafs decide to play him. Another soft goal here or there and Mrazek will be quickly pulled from games.<br><br>Dubas has claimed he waived Mrazek over the weekend as a salary cap move, but who’s kidding who - you don’t waive someone you really want to keep around. If, for whatever reason, another franchise decided to take a chance on Mrazek – for this year, and two more years, with a $3.8 million annual cap hit – there would be little in the way of mourning over Mrazek’s departure. Instead, Leafs brass now has to be cold-blooded in their analysis and deployment of goalies. Campbell and Kallgren will get the first chances to run with the No. 1 job, and if they fail, it will fall on Mrazek to get one last shot at proving himself in Toronto.</span>', 1, 0, '2021-11-04', 'Hocky', 3, 3, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage21102021_122640_hocky.jpg\"]', 1, 0, 30, NULL, NULL, '2021-10-21 10:26:40', '2023-05-07 02:32:35'),
(39, 14, 'This article is about mechanical robots. for software agents, see bot.', 'Microsoft’s rival to Google’s Chromebooks is finally available for schools and students', '<span style=\"color: rgb(32, 33, 34); font-family: sans-serif; font-size: 14px; font-style: italic;\"></span><span style=\"color: rgb(16, 38, 74); font-family: Poppins; font-size: 15px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">Microsoft’s rival to Google’s Chromebooks is finally available for schools and students.<br><br>In\r\n November the software giant announced Windows 11 SE, a version of its \r\noperating system that is designed specifically for classrooms. It said \r\nit would be available on low-cost devices, and is optimized for Edge, \r\nMicrosoft Office, and the company’s other cloud-based tools like \r\nOne-drive.<br><br>Users will not be able to download applications from \r\nthe Windows Store because it is not available on the machine; instead, \r\nthe computers have an authorized selection of apps that can be installed\r\n on it – such as Zoom and Google Chrome.<br>China plane crash: ‘Severely damaged’ black box from Boeing 737 found in Xingu<br><br>The\r\n operating system has also been simplified so that apps can only run \r\nfull screen, and Snap Layouts only load side-by-side. Widgets have also \r\nbeen removed, as Microsoft found it would be a distracting element in a \r\nclassroom.<br><br>Those low-cost devices, meanwhile, include the Surface\r\n Laptop SE priced at $249 in the US and £229 in the UK. There are also a\r\n number of other laptops from Acer, Asus, Dell, and HP too.</span><span style=\"color: rgb(32, 33, 34); font-family: sans-serif; font-size: 14px; font-style: italic;\"></span>', 1, 0, '2021-10-21', 'robot', 3, 8, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage09052023_094903_chatgpt-robot-learning-answering-questions.jpg\"]', 1, 0, 25, 'robot', 'robot', '2021-10-21 10:30:22', '2023-05-09 10:33:05'),
(40, 1, 'Two georgian silver medallists were told to leave the olympic games for taking a sightseeing trip in tokyo .is the world\'s largest city', 'Trae Young had 45 points and eight assists in his first game at Madison Square Garden since last season\'s playoffs, leading a late surge that gave the Atlanta Hawks a 117-111 victory over the New York Knicks on Tuesday night.', '<span style=\"color: rgb(16, 38, 74); font-family: Poppins; font-size: 15px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">Trae Young had 45 points and eight assists in his first game at Madison Square Garden since last season\'s playoffs, leading a late surge that gave the Atlanta Hawks a 117-111 victory over the New York Knicks on Tuesday night.<br><br>Picking up right where he left off last spring, Young made seven 3-pointers, including one that tied the game at 105 with 2:54 to play. He then set up Bogdan Bogdanovic for a go-ahead 3 and followed another by De\'Andre Hunter by leaving Taj Gibson behind off the dribble and knocking down a jumper to cap an 11-0 spurt and make it 113-105 with 1:04 left.<br><br>Bogdanovic added a season-high 32 points for the Hawks, who dropped the Knicks six games behind them for 10th place in the Eastern Conference, the final spot in the play-in field.<br><br>RJ Barrett had 28 points and 13 rebounds for the Knicks, who fell to 30-42 to clinch their eighth losing season in the last nine. The only winning record was when they went 41-31 last season to earn the No. 4 seed in the East.<br><br>The Hawks then beat them in five games in the first round of the playoffs. Young was the star in his first postseason series, ignoring the profane taunts from fans and getting the last word when he bowed to the crowd from near midcourt late in Game 5.<br><br>Young missed the return trip when he was sidelined for the Christmas game because of the NBA’s health and safety protocols. Fans booed him every time he touched the ball early Tuesday, though that didn’t last.<br><br>Alec Burks had 21 points for the Knicks, who played without Julius Randle because of a sore right quadriceps tendon. They led by 10 early in the fourth, but the game changed when Young re-entered with 7:45 remaining.<br><br>The Knicks led 34-30 after one, a lead that would have been six if not for Bogdanovic taking the ball out after Barrett\'s basket with 0.6 seconds left and flinging it the length of the court to Young, who caught and tossed it in all in one motion.<br><br>New York extended it to 12 in the second before the Hawks surged ahead by nine and took a 64-58 lead into halftime. Bogdanovic had 15 points and Young 13 in the second quarter, combining for four more points than the Knicks scored.</span>', 1, 0, '2021-10-23', 'sports', 1, 8, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage30012022_034427_basket_ball.jpg\"]', 1, 0, 33, NULL, NULL, '2021-10-21 10:42:10', '2022-04-20 20:14:54'),
(41, 7, 'Manages and administers a specific function of the Police department’s it systems  including support in computer hardware', 'Drones, also known as unmanned aerial vehicles, are becoming a promising new tool for news gathering as TV stations and networks around the world begin to experiment with these smaller, more compact and easier to maneuver devices equipped with cameras.', '<span style=\"color: rgb(16, 38, 74); font-family: Poppins; font-size: 15px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">Drones, also known as unmanned aerial vehicles, are becoming a promising new tool for news gathering as TV stations and networks around the world begin to experiment with these smaller, more compact and easier to maneuver devices equipped with cameras.<br><br>TV news drones are typically equipped with high definition video cameras and can be used to fly over the scenes of news stories, or simply to capture “beauty shots” for weather forecasts or use at various places throughout the newscast.<br><br>Drones are particularly useful in covering natural disasters, environmental and nature news, traffic news, weather news or stories that require showing wide areas of land, such as property or road development or construction, though their use is hardly limited to just these areas.<br><br>Drones have the advantage of being smaller and less expensive than news helicopters and also offer some safety advantages in that they are unmanned and, in the event of a crash or mechanical failure, no on-board crew in put in danger.<br><br>However, there have been reports of drones causing injury to people on the ground or damage to property such as buildings and vehicles.<br><br>Drones are also able to fly at lower heights than helicopters and also offer the advantage of being quieter. However, like helicopters, drones have limited use during certain weather conditions, particularly storms or high winds.<br><br>Because of the proximity to the ground drones maintain, they often may lack the advanced (and more expensive) cameras equipped with gyro stabilization, digital image stabilization or enhanced zoom technologies.<br><br>Like that captured by news helicopters, drone footage may be aired live via wireless transmission technologies or stored on media for editing and playback later.<br><br>The video captured by drone is often recognizable by its fluid movement that is possible from the smaller, more agile devices.<br><br>Despite their usefulness, there is still many regulatory issues surrounding the use of drones for commercial purposes in the United States in general.<br><br>The FAA has not established complete rules and regulations surrounding the use of drones for TV news coverage and is slowly issuing permits to a handful of companies on a semi-experimental basis.<br><br>Most TV stations contract with a third party company or individual who is covered under such a license.</span>', 1, 0, '2021-11-03', 'technology', 3, 8, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage30012022_035547_card_1.jpg\"]', 1, 0, 18, NULL, NULL, '2021-10-21 10:46:11', '2022-10-26 05:50:03'),
(42, 14, 'Computer technology.generation new computer technology Stock Our managed it and it monitoring services allow you to focus', 'A new control technology has been developed by scientists for a four-legged robot that allowed it to achieve the “effortless” superhuman feat of hiking 120 vertical metres in the Alps in 31 minutes without any falls or missteps.', '<div><span style=\"color: rgb(16, 38, 74); font-family: Poppins; font-size: 15px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">A new control technology has been developed by scientists for a four-legged robot that allowed it to achieve the “effortless” superhuman feat of hiking 120 vertical metres in the Alps in 31 minutes without any falls or missteps.<br><br>The advance may lead to the development of new robots and other kinds of robotic technology that can be used in terrain too dangerous for humans, said the researchers, including those from ETH Zurich in Switzerland.<br><br>The ANYmal quadrupedal robot successfully finished the hike – which consisted of steep sections on slippery ground, high steps and forest trails full of roots – four minutes faster than the estimated duration for human hikers, according to the study, published Wednesday in the journal Science Robotics.<br><br>“The robot has learned to combine visual perception of its environment with proprioception – its sense of touch – based on direct leg contact. This allows it to tackle rough terrain faster, more efficiently and, above all, more robustly,” study co-author Marco Hutter from ETH Zurich said in a statement.<br><br>While humans and other animals handle slippery or soft ground by combining the visual perception of their environment with the proprioception of their legs and hand, researchers said legged robots have been able to do this only to a “limited extent” until now.<br>They said this was mainly because information about the immediate environment recorded in such robots by laser sensors and cameras was often “incomplete and ambiguous”.<br><br>Citing an example of such ambiguous perception, researchers said tall grass, shallow puddles or snow appeared as “insurmountable obstacles” or were partially invisible for these robots, even when they could potentially traverse them.<br><br>In addition, they said depth perception could be poor in some cases due to difficult lighting, dust, fog, reflective or transparent surfaces or other factors.</span><br><br><span style=\"color: rgb(16, 38, 74); font-family: Poppins; font-size: 15px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\"></span></div>', 1, 0, '2021-11-04', 'rechnology', 3, 8, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage23102021_114415_techno.jpg\"]', 1, 0, 20, NULL, NULL, '2021-10-21 10:48:57', '2022-08-22 03:33:26'),
(43, 7, 'Green-party success Is reshaping global politics are increasingly shaping the debate in countries around the world', 'The British-Iranian dual national, who was detained for six years in Iran, said she should have been back in the UK “six years ago”.', '<p style=\"box-sizing: inherit; border-width: 0px; border-style: solid; border-color: rgb(4, 40, 74); margin: 0px 0px 20px; padding: 0px 0px 0px 19px; list-style: none; line-height: 24.5px; position: relative;\"><span style=\"color: rgb(16, 38, 74); font-family: Poppins; font-size: 15px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">The\r\n British-Iranian dual national, who was detained for six years in Iran, \r\nsaid she should have been back in the UK “six years ago”.<br><br>Speaking\r\n in parliament on Monday at her first press conference, she said she did\r\n “not really agree” that she should be thanking the foreign secretary \r\nfor her return.<br><br>“I have seen five foreign secretary changes over \r\nthe course of six years. That is unprecedented given the politics of the\r\n UK,” she told the assembled media.<br><br>“But I was told, many many \r\ntimes, ‘We’re going to get you home.’ That never happened. So there was a\r\n time when I felt like, do you know what, I’m not even going to trust \r\nyou because I’ve been told so many times that I’m going to be taken \r\nhome. But that never happened! Equalities Minister Kemi Badenoch has \r\nsuggested the British Empire brought “good things” to communities as she\r\n urged telling “both sides” of history.<br><br>Having gone to school in \r\nLagos, Nigeria, she said she was taught about Britain’s past with a \r\nnuanced description that has influenced her view on the former empire.<br><br>“There\r\n were terrible things that happened during the British Empire, there \r\nwere other good things that happened, and we need to tell both sides of \r\nthe story,” she told Times Radio.<br><br>“I think my upbringing and schooling in another country has really influenced the way that I look at these things.<br><br>“There\r\n wasn’t any sort of attempt to describe the British Empire as this \r\nawful, terrible thing that oppressed and victimised us.”</span></p>', 1, 0, '2021-10-23', 'politics', 2, 8, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage23102021_060444_politics.jpg\"]', 1, 0, 48, NULL, NULL, '2021-10-23 04:04:44', '2022-07-05 01:42:52'),
(44, 13, 'Official press statement an historic moment time and a new journey to begin. Shirley Chisholm was the first African American woman elected to Congress', 'Official press statement\r\nan historic moment for the  nation', '<span style=\"color: rgb(16, 38, 74); font-family: Poppins; font-size: 15px; text-align: justify;\">Greater Bridgeport – For a few moments on, August 11, 2020, the discussion of the ravages from the pandemic of COVID-19 was pushed aside by the rushing tide of history. Senator Kamala Harris of California became the nation’s first African American woman nominated for the vice presidency of the United States. It is a moment to be savored, a time to reflect, and a new journey to begin. Shirley Chisholm was the first African American woman elected to Congress, and the first Black major party candidate to run for president of the United States. In 1972 she said, “at present, our country needs women’s idealism and determination, perhaps more in politics than anywhere else.” The historicity of this hour reminds us again of that idealism, determination, and authentic sensitivity we often find in women. It just seems to be a part of who they are. It often appears in the way they govern. There is an undying belief on the part of women, expressed in the words of former presidential candidate Hillary Rodham Clinton, “we are agents of change, we are drivers of progress, we are makers of peace – all we need is a fighting chance.” This is a bold move on the part of Vice President Joe Biden. It is another opportunity for our nation to move a little closer towards a more perfect union. It is a union for which Dr. Martin Luther King, Jr., said, “one day we will judge people not by the color of their skin but by the content of their character.” While the NAACP does not endorse candidates, we are compelled to recognize the historic impact of these rare moments in time. This election will really be for the very soul of our nation. As the author James Cone has written When My Soul Looks Back, “it wonders how I get over.” I can hear the voice of Harriet Tubman humming. I can hear Ida B. Wells declaring, Fannie Lou Hamersinging, and Shirley Chisholm calling out the words of that old gospel song “he didn’t bring us this far to leave us.” It is time for everyone regardless of color, station, or vocation to Take Your Soles To The Polls. Take them by mail or directly to the voting booth. Let us Vote! Vote!!Vote!!</span>', 1, 0, '2021-10-23', 'politics', 2, 8, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage30012022_034246_politics_2.jpg\"]', 1, 0, 17, NULL, NULL, '2021-10-23 04:09:35', '2022-11-15 23:04:38'),
(45, 13, 'Bolsonaro’s new alliance for brazil is a lesson in the politics of loyalty and campaign finance  For over three decades, Bolsonaro used different', 'Bolsonaro’s new alliance for brazil is a lesson in the politics of loyalty and campaign finance', '<p style=\"box-sizing: inherit; color: rgb(74, 74, 74); font-size: 1.8rem; margin-right: 0px; margin-bottom: 1.6rem; margin-left: 0px; line-height: 1.8; font-family: Roboto, sans-serif;\"><span style=\"color: rgb(16, 38, 74); font-family: Poppins; font-size: 15px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">The\r\n British-Iranian dual national, who was detained for six years in Iran, \r\nsaid she should have been back in the UK “six years ago”.Speaking\r\n in parliament on Monday at her first press conference, she said she did\r\n “not really agree” that she should be thanking the foreign secretary \r\nfor her return.<br>“I have seen five foreign secretary changes over \r\nthe course of six years. That is unprecedented given the politics of the\r\n UK,” she told the assembled media.<br>“But I was told, many many \r\ntimes, ‘We’re going to get you home.’ That never happened. So there was a\r\n time when I felt like, do you know what, I’m not even going to trust \r\nyou because I’ve been told so many times that I’m going to be taken \r\nhome. But that never happened! Equalities Minister Kemi Badenoch has \r\nsuggested the British Empire brought “good things” to communities as she\r\n urged telling “both sides” of history.<br>Having gone to school in \r\nLagos, Nigeria, she said she was taught about Britain’s past with a \r\nnuanced description that has influenced her view on the former empire.<br>“There\r\n were terrible things that happened during the British Empire, there \r\nwere other good things that happened, and we need to tell both sides of \r\nthe story,” she told Times Radio.<br>“I think my upbringing and schooling in another country has really influenced the way that I look at these things.<br>“There\r\n wasn’t any sort of attempt to describe the British Empire as this \r\nawful, terrible thing that oppressed and victimised us.”</span><span style=\"color: rgb(16, 38, 74); font-family: Poppins; font-size: 15px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\"></span><span style=\"font-size: 1.8rem;\"></span></p>', 1, 0, '2021-11-14', 'politics', 3, 8, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage30012022_034317_politics_3.jpg\"]', 1, 0, 12, NULL, NULL, '2021-10-23 04:12:58', '2023-05-07 03:31:06'),
(46, 7, 'Amazon has 143 billion reasons to keep Strech lining hemline above knee burgundy glossy silk complete hid zip little catches rayon', 'In an important milestone in meeting its Climate Pledge commitments, Amazon is seeking net-zero carbon certification for its newest Amazon Fresh grocery store.', '<span style=\"color: rgb(16, 38, 74); font-family: Poppins; font-size: 15px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">In an important milestone in meeting its Climate Pledge commitments, Amazon is seeking net-zero carbon certification for its newest Amazon Fresh grocery store. More than a dozen upgrades and features have been incorporated throughout the design and development of the 35,000-square-foot Seattle space to help make the store the world’s first grocery store to pursue the International Living Future Institute Zero Carbon certification. As a result of these upgrades, we expect the store will save nearly 185 tons of CO2e each year, equivalent to driving around the Earth 18 times in a standard passenger vehicle.<br>“We are constantly thinking about what we can do to make the customer shopping experience easier, more seamless, and more sustainable,” said Stephenie Landry, vice president of Amazon Grocery. “We know many customers are prioritizing sustainability in what products they buy and where they choose to shop. With our newest Amazon Fresh store, we are taking the next step on our path to becoming a net-zero carbon business by 2040, and we welcome customers to experience this firsthand while shopping with us in this store.”<br>Some upgrades will be used at all of our Amazon Fresh grocery stores moving forward, such as lower-carbon concrete flooring, which will help to reduce our embodied carbon.<br><br>“In order to deliver on our commitments to The Climate Pledge, we must work together across all areas of our business to develop solutions to decarbonize,” said Kara Hurst, vice president of Worldwide Sustainability at Amazon. “It’s meaningful progress to open our latest Amazon Fresh Store seeking net-zero carbon certification, and I’m proud of the innovation and technology that the store offers to customers and employees, and for the environment.”</span>', 1, 0, '2021-11-03', 'magic', 2, 8, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage23102021_072605_amazon.jpg\"]', 1, 0, 46, NULL, NULL, '2021-10-23 05:24:11', '2023-05-12 03:39:30'),
(47, 13, 'With the thrills of a casino, the excitement of live harness racing and the delight of fine food and spirits, you can kick back', 'With the thrills of a casino, the excitement of live harness racing and the delight of fine food and spirits, you can kick back, relax and be thoroughly entertained. you won’t find a better experience in the southern Tier!', '<span style=\"color: rgb(16, 38, 74); font-family: Poppins; font-size: 15px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">The British-Iranian dual national, who was detained for six years in Iran, said she should have been back in the UK “six years ago”.<br><br>Speaking in parliament on Monday at her first press conference, she said she did “not really agree” that she should be thanking the foreign secretary for her return.<br><br>“I have seen five foreign secretary changes over the course of six years. That is unprecedented given the politics of the UK,” she told the assembled media.<br><br>“But I was told, many many times, ‘We’re going to get you home.’ That never happened. So there was a time when I felt like, do you know what, I’m not even going to trust you because I’ve been told so many times that I’m going to be taken home. But that never happened! Equalities Minister Kemi Badenoch has suggested the British Empire brought “good things” to communities as she urged telling “both sides” of history.<br><br>Having gone to school in Lagos, Nigeria, she said she was taught about Britain’s past with a nuanced description that has influenced her view on the former empire.<br><br>“There were terrible things that happened during the British Empire, there were other good things that happened, and we need to tell both sides of the story,” she told Times Radio.<br><br>“I think my upbringing and schooling in another country has really influenced the way that I look at these things.<br><br>“There wasn’t any sort of attempt to describe the British Empire as this awful, terrible thing that oppressed and victimised us.”</span>', 1, 0, '2021-10-23', 'politics', 2, 8, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage09052023_093701_clay-banks-2LEKXzFNitA-unsplash.jpg\"]', 1, 0, 38, 'politics', 'politics', '2021-10-23 09:28:51', '2023-05-29 12:26:01'),
(48, 20, 'Entertainment partners chill at home with a few must-see movies or head out for', 'Microsoft’s rival to Google’s Chromebooks is finally available for schools and students.', '<p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-stretch: inherit; line-height: inherit; font-family: Lato, Helvetica, Arial, sans-serif; vertical-align: baseline; color: rgb(51, 51, 51);\"><span style=\"color: rgb(16, 38, 74); font-family: Poppins; font-size: 15px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">Microsoft’s rival to Google’s Chromebooks is finally available for schools and students.<br><br>In November the software giant announced Windows 11 SE, a version of its operating system that is designed specifically for classrooms. It said it would be available on low-cost devices, and is optimized for Edge, Microsoft Office, and the company’s other cloud-based tools like One-drive.<br><br>Users will not be able to download applications from the Windows Store because it is not available on the machine; instead, the computers have an authorized selection of apps that can be installed on it – such as Zoom and Google Chrome.<br>China plane crash: ‘Severely damaged’ black box from Boeing 737 found in Xingu<br><br>The operating system has also been simplified so that apps can only run full screen, and Snap Layouts only load side-by-side. Widgets have also been removed, as Microsoft found it would be a distracting element in a classroom.<br><br>Those low-cost devices, meanwhile, include the Surface Laptop SE priced at $249 in the US and £229 in the UK. There are also a number of other laptops from Acer, Asus, Dell, and HP too.</span></p>', 1, 0, '2021-11-06', 'world', 3, 8, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage24102021_050111_maannewsimage19102021_094212_remote_work3_190515-800x450.jpg\"]', 1, 0, 139, NULL, NULL, '2021-10-23 09:50:10', '2023-05-20 11:34:24');
INSERT INTO `news` (`id`, `subcategory_id`, `title`, `summary`, `description`, `status`, `breaking_news`, `date`, `tags`, `speciality_id`, `reporter_id`, `image`, `user_id`, `archive`, `viewers`, `meta_keyword`, `meta_description`, `created_at`, `updated_at`) VALUES
(49, 7, 'Reating a vision for the future: how technology will revolutionise the business finance function', 'Reating a vision for the future: how technology will revolutionise the business finance function', '<p>                                            <span style=\"font-family: &quot;Roboto&quot;;\">﻿</span><span style=\"color: rgb(46, 46, 56); font-family: Georgia, sans-serif; font-size: 20px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\"></span><span style=\"color: rgb(16, 38, 74); font-family: Poppins; font-size: 15px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">The Department of Dance at Chapman University offers students a strong professional dance training program with high quality productions. Students may choose from a pre-professional Bachelor of Fine Arts degree in Dance Performance or from the more broad based Bachelor of Arts degree in Dance. Both degrees provide excellent preparation for those who plan to enter the professional dance world and/or attend graduate school. The curriculum for dance majors includes course work in choreography, dance history, dance production, dance performance, acting, music for dancers, dance science, dance teaching methods, ballroom, somatics, hip-hop, tap, and comprehensive pre-professional training in modern, jazz and ballet technique. The USC Glorya Kaufman School of Dance offers a Bachelor of Fine Arts to a select number of undergraduates who wish to pursue dance as their major. This four-year professional degree is housed in the state-of-the-art Glorya Kaufman International Dance Center. USC Kaufman also offers individual classes in technique, performance, choreography, production, theory and history that are open to all students at USC. In addition to the dance major and open courses, the minor in Dance and minor in Dance in Popular Culture: Hip-Hop, Urban and Social Dances, provide a rewarding program of study for any USC student. A conservatory-based program within a liberal arts environment, we are focused on rigorous training in both ballet and modern technique. We are committed to the creation and production of original contemporary choreographic works by students, faculty and guest artists. The Dance Program is housed in its own state-of-the-art Dance Centre on a large liberal arts campus. USF is accredited by the National Association of Schools of Dance (NASD). Students must apply for admission and be accepted to the University of South Florida before they can be accepted as a Dance Major in the School of Theatre and Dance. Additionally, all prospective Dance Majors and Dance Minors must audition during the year prior to their first semester to be accepted into the Dance Program.</span><span style=\"font-family: &quot;Arial Black&quot;;\"></span></p>', 1, 0, '2021-11-04', 'Technology', 3, 8, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage23102021_115552_Chinese-Fan-Dance.jpg\"]', 1, 0, 319, 'Technology', 'Technology', '2021-10-23 09:55:52', '2023-05-30 08:57:25'),
(51, 13, 'Taina Blue Retreat is a Converted Tower on the Greek Coast', 'We wandered the site with busloads of other tourists, yet strangely the place did not seem crowded. I’m not sure if it was the sheer size of the place, or whether the masses congregated in one area and didn’t venture far from the main church.', '<span style=\"color: rgb(16, 38, 74); font-family: Poppins; font-size: 15px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">Greater Bridgeport – For a few moments on, August 11, 2020, the discussion of the ravages from the pandemic of COVID-19 was pushed aside by the rushing tide of history. Senator Kamala Harris of California became the nation’s first African American woman nominated for the vice presidency of the United States. It is a moment to be savored, a time to reflect, and a new journey to begin. Shirley Chisholm was the first African American woman elected to Congress, and the first Black major party candidate to run for president of the United States. In 1972 she said, “at present, our country needs women’s idealism and determination, perhaps more in politics than anywhere else.” The historicity of this hour reminds us again of that idealism, determination, and authentic sensitivity we often find in women. It just seems to be a part of who they are. It often appears in the way they govern. There is an undying belief on the part of women, expressed in the words of former presidential candidate Hillary Rodham Clinton, “we are agents of change, we are drivers of progress, we are makers of peace – all we need is a fighting chance.” This is a bold move on the part of Vice President Joe Biden. It is another opportunity for our nation to move a little closer towards a more perfect union. It is a union for which Dr. Martin Luther King, Jr., said, “one day we will judge people not by the color of their skin but by the content of their character.” While the NAACP does not endorse candidates, we are compelled to recognize the historic impact of these rare moments in time. This election will really be for the very soul of our nation. As the author James Cone has written When My Soul Looks Back, “it wonders how I get over.” I can hear the voice of Harriet Tubman humming. I can hear Ida B. Wells declaring, Fannie Lou Hamersinging, and Shirley Chisholm calling out the words of that old gospel song “he didn’t bring us this far to leave us.” It is time for everyone regardless of color, station, or vocation to Take Your Soles To The Polls. Take them by mail or directly to the voting booth. Let us Vote! Vote!!Vote!!</span>', 1, 1, '2022-03-23', 'politics', 1, 2, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage23032022_050521_Taina-Blue-Retreat-is-a-Converted-Tower-on-the-Greek-Coast.png\"]', 1, 0, 43, 'News, maan', 'of their skin but by the content of their character', '2022-03-23 04:05:21', '2023-05-29 12:35:35'),
(52, 3, 'The term stock market refers to several exchanges in which shares', 'The term stock market refers to several exchanges in which shares of publicly held companies are bought and sold.', '<p id=\"mntl-sc-block_1-0-1\" class=\"comp mntl-sc-block finance-sc-block-html mntl-sc-block-html\">&nbsp;The term stock market refers to several exchanges in which shares of \r\npublicly held companies are bought and sold. Such financial activities \r\nare conducted through formal exchanges and via over-the-counter&nbsp;(OTC) marketplaces that operate under a defined set of regulations.&nbsp;\r\n</p>\r\n<div id=\"mntl-sc-block_1-0-2\" class=\"comp mntl-sc-block mntl-sc-block-adslot mntl-block\"></div>\r\n<p id=\"mntl-sc-block_1-0-3\" class=\"comp mntl-sc-block finance-sc-block-html mntl-sc-block-html\">\r\nBoth “stock market” and “stock exchange” are often used interchangeably.\r\n Traders in the stock market buy or sell shares on one or more of the \r\nstock exchanges that are part of the overall stock market.&nbsp;</p>', 1, 0, '2023-05-09', 'Business', 2, 2, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage09052023_112425_history-in-hd-sTou35WzMso-unsplash.jpg\"]', 1, 0, 1, 'Business', 'Business', '2023-05-09 10:19:18', '2023-05-10 04:30:43'),
(53, 10, 'Sportswear brands go all out to target women consumers globally', 'There has been tremendous growth in the women’s sportswear market and global sportswear brands have been competing to lure women consumers.', '<p><span style=\"color: rgb(49, 49, 49); font-family: Lato, sans-serif;\">A decade ago, the sportswear market was driven by the concept of ‘cool’ brands that had products that could be identified with the notion and reaped profits. Market leaders like NIKE, Adidas, Under Armour, and PUMA, each had their own set of loyalists, from celebrities, and sports persons to the sports-crazy common man. But of late, even as the sportswear segment continues to grow, it has a new and more demanding driver – ‘women’. According to findings by Allied Market Research, the sportswear category will grow at a CAGR of 4.3 percent to reach a total market revenue worth US $ 184.6 billion by the year 2020. And though the men’s sportswear segment today constitutes around 52 percent of the revenue and is the highest revenue-generating segment in the sports apparel market, every brand has realized the potential of the women’s segment that is expected to grow at a relatively higher CAGR of 5.7 percent during the forecast period, as the involvement of women in sporting and fitness activities increases across the globe.</span></p><p style=\"outline: none; margin-right: 0px; margin-bottom: 25px; margin-left: 0px; padding: 0px; line-height: 1.8; color: rgb(49, 49, 49); font-family: Lato, sans-serif;\">Every sportswear brand has in the last year added lines targeted specifically at the woman consumer. The momentum has now become so strong that even high-street retailers including Next have gone ahead to introduce sportswear apparel sections that cater exclusively to women. Nike and JD Sports have opened up stores that are all-woman because of the trending size of the women\'s sportswear market. Significantly, the sports industry is encouraging collaborations between sports brands and the fashion industry in order to produce new styles to cover the needs of the young and women segment which is significantly growing over the past years.</p><div><br></div><p><span style=\"color: rgb(49, 49, 49); font-family: Lato, sans-serif;\"><br></span>                                            \r\n                                          </p>', 1, 0, '2023-05-09', 'fashion', 2, 2, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage09052023_112344_[Downloader.la]-645a2b0251b6b.jpg\"]', 1, 0, 0, 'fashion', 'fashion', '2023-05-09 11:23:44', '2023-05-09 11:23:44'),
(54, 30, 'Fancy a different type of getaway this Christmas?', 'Here are three choices to consider when planning how to end 2018 on a high note.', '<div class=\"lazyload-component\" data-v-1854add0=\"\" data-v-f5612e00=\"\"><div data-v-1854add0=\"\"><div data-v-1854add0=\"\"><div data-v-f5612e00=\"\" class=\"details__body body\"><div data-v-f5612e00=\"\"><p data-v-e5d603e4=\"\" data-v-f5612e00=\"\" class=\"generic-article__body article-details-type--p content--p\">Kiroro,\r\n a winter wonderland based in the Hokkaido Golden Triangle in Japan, is \r\ngoing all out with some truly luxurious packages this December.</p></div><div data-v-f5612e00=\"\"><div data-v-e5d603e4=\"\" data-v-f5612e00=\"\" class=\"generic-article__body article-details-type--outstream-1 content--outstream-1\"><div class=\"outstream__ad-container outstream__ad-container--size-1x1\"><div id=\"div-outstream-ad-8071bf50-ee61-11ed-be03-3b3169bc43a5\" class=\"inner\" data-google-query-id=\"CJSG3t2Y6P4CFSwi1QodfgQNfg\"><div id=\"google_ads_iframe_/8134/scmp/web/style_travelfood/article/outstream1_0__container__\" style=\"border: 0pt none;\"><iframe id=\"google_ads_iframe_/8134/scmp/web/style_travelfood/article/outstream1_0\" name=\"google_ads_iframe_/8134/scmp/web/style_travelfood/article/outstream1_0\" title=\"3rd party ad content\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"0\" style=\"border-width: 0px; border-style: none; vertical-align: bottom;\" role=\"region\" aria-label=\"Advertisement\" tabindex=\"0\" data-google-container-id=\"5\" data-gtm-yt-inspected-34=\"true\" data-load-complete=\"true\" width=\"1\" height=\"1\" frameborder=\"0\"></iframe></div></div></div></div></div></div></div></div> </div> <div class=\"details__read-more\" data-v-f5612e00=\"\"></div> <div class=\"lazyload-component\" data-v-1854add0=\"\" data-v-f5612e00=\"\"> <div data-v-1854add0=\"\"><div data-v-1854add0=\"\"><div data-v-f5612e00=\"\" class=\"details__body body body--next\"><div data-v-f5612e00=\"\" class=\"\"><div data-v-f5612e00=\"\"><p data-v-e5d603e4=\"\" data-v-f5612e00=\"\" class=\"generic-article__body article-details-type--p content--p\">The\r\n Sheraton Hokkaido Kiroro Resort is particularly impressive, where a ski\r\n adventure package is on offer along with fabulous daily access to the \r\nonsen or hot spring.<br data-v-e5d603e4=\"\" class=\"generic-article__body article-details-type--br content--br\"></p></div><div data-v-f5612e00=\"\"><p data-v-e5d603e4=\"\" data-v-f5612e00=\"\" class=\"generic-article__body article-details-type--p content--p\">While you are in the area, do check out the show unit for Yu Kiroro, a highly anticipated property set to open in December 2019.</p></div><div data-v-f5612e00=\"\"></div><div data-v-f5612e00=\"\"><p data-v-e5d603e4=\"\" data-v-f5612e00=\"\" class=\"generic-article__body article-details-type--p content--p\">It\r\n offers a five-star experience with ski valet services, a clubhouse, \r\nand one-, two- and three-bedroom freehold luxury ski-in-ski-out private \r\nresidences.</p></div></div></div></div></div></div>', 1, 0, '2023-05-09', 'travel', 2, 3, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage09052023_120602_sea-house-resort-exotic-sky_1203-5302.avif\"]', 1, 0, 0, 'travel', 'travel', '2023-05-09 12:06:02', '2023-05-09 12:06:02'),
(55, 30, 'A photo on phu sub lek viewpoint at sunset lopburi thailand', 'Where better than a private island where pristine beaches and a string of spa treatments abound?', '<div data-v-f5612e00=\"\"><p data-v-e5d603e4=\"\" data-v-f5612e00=\"\" class=\"generic-article__body article-details-type--p content--p\">Angsana\r\n Spa Cayo Santa Maria in Cuba offers all of the above for a perfect \r\ngetaway from the holiday hubbub where you can truly shut down and \r\nrecuperate.&nbsp;<span style=\"font-size: 1rem;\">Owned\r\n by Banyan Tree Hotels and Resorts, you can be sure there is no shortage\r\n of great spa facilities and Asian-inspired spa treatments.</span></p></div><div data-v-f5612e00=\"\"><p data-v-e5d603e4=\"\" data-v-f5612e00=\"\" class=\"generic-article__body article-details-type--p content--p\">The best part is, this is an adults-only resort, so you can truly rest your mind without worrying about any distractions.</p><p data-v-e5d603e4=\"\" data-v-f5612e00=\"\" class=\"generic-article__body article-details-type--p content--p\">Following his win (the jury ruled in favor of Depp’s claim of defamation\r\n across three counts), Depp has seemingly edged his way back into \r\nHollywood\'s favor. His film <em data-v-e5d603e4=\"\" class=\"generic-article__body article-details-type--em content--em\">Jeanne du Barry</em>,\r\n in which he stars as Louis XV, has been selected as the opening film at\r\n the 76th annual Cannes Film Festival. But what about Heard?<br></p></div>', 1, 0, '2023-05-09', 'travel', 2, 3, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage09052023_121015_tourist-take-photo-phu-sub-lek-viewpoint-sunset-lopburi-thailand_335224-1392.avif\"]', 1, 0, 1, 'travel', 'travel', '2023-05-09 12:10:15', '2023-05-30 08:58:01'),
(56, 30, 'On sunrise viewpoint at ja bo village, mae hong son province, thailand.', 'While Anantara Chiang Mai Resort in Thailand may be known for its tranquillity and restorative elements, there is no reason not to celebrate Christmas while you are relaxing.', '<div data-v-f5612e00=\"\"><p data-v-e5d603e4=\"\" data-v-f5612e00=\"\" class=\"generic-article__body article-details-type--p content--p\">The\r\n “Christmas by The River” event on Christmas Eve will feature a slew of \r\ncarol singers, while a live jazz band will play some Christmas classics \r\nto get you in the swing of things.</p></div><div data-v-f5612e00=\"\"><div data-v-e5d603e4=\"\" data-v-f5612e00=\"\" class=\"js-reading-50-percent-completion-tracker generic-article__body article-details-type--reading-50-percent-completion-tracker content--reading-50-percent-completion-tracker\" data-gtm-vis-first-on-screen-8001567_197=\"220098\" data-gtm-vis-total-visible-time-8001567_197=\"100\" data-gtm-vis-has-fired-8001567_197=\"1\"></div></div><div data-v-f5612e00=\"\"><p data-v-e5d603e4=\"\" data-v-f5612e00=\"\" class=\"generic-article__body article-details-type--p content--p\">On Christmas Day, Santa Claus and Mrs. Claus will also make an appearance.</p></div><div data-v-f5612e00=\"\"></div><div data-v-f5612e00=\"\"><p data-v-e5d603e4=\"\" data-v-f5612e00=\"\" class=\"generic-article__body article-details-type--p content--p\">That’s not all – the fun continues with a performance of the <em data-v-e5d603e4=\"\" class=\"generic-article__body article-details-type--em content--em\">Phantom of the Opera</em>, a cocktail reception, and a fantastic buffet to boot.</p></div><div data-v-f5612e00=\"\"><p data-v-e5d603e4=\"\" data-v-f5612e00=\"\" class=\"generic-article__body article-details-type--p content--p\">At\r\n the stroke of midnight to celebrate the new year, traditional Chiang \r\nMai fire lanterns will be set free into the sky to create a truly \r\nspectacular sight worthy of your Instagram feed.</p></div>', 1, 0, '2023-05-09', 'fashion', 2, 2, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage09052023_121329_backpacker-standing-sunrise-viewpoint-ja-bo-village-mae-hong-son-province-thailand.jpg\"]', 1, 0, 1, 'travel', 'travel', '2023-05-09 12:13:29', '2023-05-30 08:56:59'),
(57, 10, 'Everything we know about the theme, hosts and guests', 'The Met Gala is fast approaching. Tonight\'s event is a mainstay on the calendars of celebrities, fashion\'s elite and New York high society, the extravagant event.', '<div>The Met Gala is fast approaching. Tonight\'s event is a mainstay on the calendars of celebrities, fashion\'s elite and New York high society, the extravagant event. Officially called the Costume Institute Benefit, it takes place at the Metropolitan Museum of Art on the first Monday in May, with guests dressed in keeping with the gala\'s theme (or ignoring it altogether).</div><div>This year, the dress code is \"In honor of Karl,\" a tribute to Karl Lagerfeld, the late fashion juggernaut with an indelible influence but controversial reputation. All eyes will be on the red carpet to see how guests interpret Lagerfeld\'s complicated legacy — as well as if his beloved tortie cat, Choupette, will strut up the museum\'s front steps.</div><div><br></div><div>Co-chairing this year\'s event are actors Michaela Coel and Penélope Cruz, tennis giant Roger Federer, singer Dua Lipa and, as always, Vogue\'s editorial director Anna Wintour.</div><div>Lagerfeld\'s career will also be explored in the Costume Institute\'s spring exhibition \"Karl Lagerfeld: A Line of Beauty,\" opening to the public the following day.</div><div>Look of the Week: Apple Martin looks every bit the \'Chanel girl\'</div><div>A long legacy</div><div>Serving as creative director of the storied French fashion house Chanel from 1983 until his death in February 2019, as well as the luxury Italian house Fendi from 1965, the German fashion designer loomed tall within the fashion industry. He left his mark on Chloé, Patou and Balmain as well over the course of his long career, working with each fashion house in different capacities (in addition to his own eponymous label), and has influenced countless others.</div><div>His final Fendi collection was shown at Milan Fashion Week just days after his death, with models including Gigi and Bella Hadid and Kaia Gerber walking the runway. The following month, Cruz made her runway debut at his final Chanel presentation.</div>', 1, 0, '2023-05-10', 'fashion', 2, 3, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage29052023_122201_maannewsimage28052023_071619_summer-car-trip-young-family-vacation 1 (1).png\"]', 1, 0, 2, 'fashion', 'fashion', '2023-05-10 12:09:13', '2023-05-29 12:22:01'),
(58, 10, 'Rarely seen photos from the Met Gala show celebrities letting loose', 'The event, held at the Metropolitan Museum of Art in New York City, coincides with the opening of a retrospective of Lagerfeld\'s work on display at the museum\'s Costume Institute.', '<div>The event, held at the Metropolitan Museum of Art in New York City, coincides with the opening of a retrospective of Lagerfeld\'s work on display at the museum\'s Costume Institute. The German designer was best known for helming the creative direction of Chanel for more than three decades, and Fendi for half a century, but he also left his mark on Chloé, Patou and Balmain during his career, in addition to running his own eponymous label.</div><div>Met Gala 2023: Everything we know about the theme, hosts and guests</div><div>While red carpet photos of the Met Gala have become instantly accessible, documentation of the splashy gala has changed in recent years, as photographers have largely been limited to snapping attendees\' highly posed entrances; the images that come from the tightly controlled press area are polished and repetitive. To see celebrities letting loose (the likes of Bella Hadid and Marc Jacobs gathering in the bathroom for smoking breaks, for example) you\'d have to turn to after-party photos or their Instagram feeds.</div><div>Images from the galas of yesteryear are enticing because of their nostalgia factor and retro styling, but they also reveal a more relaxed atmosphere.</div><div><div>Photographer Rose Hartman, who photographed the gala for decades until the early 2000s, recalled over the phone a time when there was more freedom to move around and engage with attendees. In 1986, she photographed actress Lynda Carter and socialite Blaine Trump mid-laugh.</div><div>\"They were just so happily speaking to one another rather than posing,\" Hartman told CNN in 2020. \"I always try whenever possible to capture people who are engaged with one another.\"</div><div>Met Gala red carpet: A history of one of New York\'s most glamorous affairs</div><div>Photographer Ron Galella, who has photographed the gala since 1967, had a system in place to grab the best shots, from arrivals at coat check to the museum floor and dinner. \"It was easy to shoot inside,\" he wrote via e-mail in 2020. \"A New York Press card was all you needed to gain entry.\" (When press passes eventually became limited, there were years he smuggled himself in through the employee entrance.)</div></div>', 1, 0, '2023-05-10', 'fashion', 2, 3, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage29052023_122536_maannewsimage28052023_065217_Group 1(1) (1).png\"]', 1, 0, 5, 'fashion', 'fashion', '2023-05-10 12:12:31', '2023-05-30 08:57:48'),
(59, 10, 'Look of the Week: Blackpink headline Coachella in Korean hanboks', 'Bringing the second day of this year\'s Coachella to a close, K-Pop girl group Blackpink made history Saturday night when they became the first Asian act to ever headline the festival.', '<div>Bringing the second day of this year\'s Coachella to a close, K-Pop girl group Blackpink made history Saturday night when they became the first Asian act to ever headline the festival. To a crowd of, reportedly, over 125,000 people, Jennie, Jisoo, Lisa and Rosé used the ground-breaking moment to pay homage to Korean heritage by arriving onstage in hanboks: a traditional type of dress.</div><div>While the garments were shrugged off a few seconds into their opening track, \"Pink Venom,\" revealing each member\'s custom black and pink Dolce and Gabbana outfit, fans across the world had already received the message. Screenshots of the moment quickly spread among Blackpink superfans, otherwise known as Blinks. \"The way they stepped onto the biggest western stage in hanboks ... literally proved their place at the top of the industry,\" tweeted one Blink. \"Blackpink really are in a league of their own.\"</div><div><br></div><div>Another called the group \"Korea\'s cultural delegation\" on Instagram, in reference to not only the hanboks but other visual cues incorporated into their show, such as one of the stage backdrops featuring an angular tiled roof reminiscent of traditional Korean architecture.</div><div>Look of the Week: Are we about to see more men in tights?</div><div>In recent years, Blackpink have enjoyed a meteoric rise to global fame. According to Guinness World Records, they are currently the most streamed female group on Spotify, and have the most-viewed music YouTube channel. Last year, they were the first female K-Pop group to reach number 1 in the UK and US album charts, and in 2020 their track \"How You Like That\" became the most viewed video on YouTube in 24 hours. (The group also wore modernized hanboks, designed by Kim Danha, in one of the music video\'s scenes.) Their landmark set over the weekend was in fact a follow-up to another milestone: In 2019, they became the first female K-Pop group to ever play at Coachella or any other US festival.</div><div>From the iconic Jean Paul Gaultier cone bra worn by Madonna for her 1990 Blond Ambition tour to Geri \"Ginger Spice\" Halliwell\'s Union Jack mini dress, the right stage costume can live on forever in public memory. Particularly when worn at a career-defining moment. During another watershed Coachella performance — Beyonce\'s 2018 headline set — the singer\'s custom Balmain collegiate-style yellow hoodie was a joyful nod to Black culture, specifically historically Black colleagues and universities.</div><div>The group\'s four black hanboks were custom created by South Korean pattern design brand OUWR and traditional Korean dressmakers Kumdanje. Inspired by the Cheol-lik silhouette, each garment was hand-embroidered with metallic traditional Korean motifs, including dan-cheong patterns and peonies (a symbol of royalty in Korea). \"It was our pleasure and such an honor to be able to show the beautiful values of Korea and Hanbok together,\" the designers wrote in a combined Instagram post. \"Blackpink showed the beauty of Korea and dazzled the world.\"</div>', 1, 0, '2023-05-10', 'fashion', 2, 3, '[\"public\\/uploads\\/images\\/newsimages\\/maannewsimage10052023_121754_http___cdn.cnn.com_cnnnext_dam_assets_230417143307-02-lotw-0417-blackpink-coachella-2023.jpg\"]', 1, 0, 0, 'fashion', 'fashion', '2023-05-10 12:17:54', '2023-05-10 12:17:54');

-- --------------------------------------------------------

--
-- Table structure for table `newscategories`
--

CREATE TABLE `newscategories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `post_counter` int(11) NOT NULL DEFAULT 0,
  `menu_publish` int(11) NOT NULL DEFAULT 1,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `newscategories`
--

INSERT INTO `newscategories` (`id`, `name`, `slug`, `type`, `image`, `post_counter`, `menu_publish`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Business', 'business-news', 'news', 'public/uploads/images/news_category/business.png', 4, 1, 1, '2021-09-07 23:33:44', '2023-05-09 10:19:18'),
(2, 'Sports', 'sports-news', 'news', 'public/uploads/images/news_category/sports.png', 5, 1, 1, '2021-09-07 23:35:23', '2022-06-22 00:12:13'),
(3, 'Lifestyle', 'lifestyle-news', 'news', 'public/uploads/images/news_category/lifestyle.png', 8, 1, 1, '2021-09-07 23:46:48', '2023-05-10 12:17:54'),
(4, 'Politics', 'politics-news', 'news', 'public/uploads/images/news_category/politics.png', 8, 1, 1, '2021-09-07 23:47:10', '2022-06-22 00:12:16'),
(5, 'Entertainment', 'entertainment-news', 'news', 'public/uploads/images/news_category/entertainment.png', 10, 1, 1, '2021-09-07 23:47:30', '2022-06-22 00:12:17'),
(6, 'Technology', 'technology-news', 'news', 'public/uploads/images/news_category/technology.png', 7, 1, 1, '2021-09-07 23:53:59', '2022-06-22 00:12:18'),
(7, 'National', 'national-news', 'news', 'public/uploads/images/news_category/national.png', 7, 1, 1, '2021-09-20 00:19:50', '2022-06-22 00:12:19'),
(8, 'World', 'world-news', 'news', 'public/uploads/images/news_category/world.png', 6, 1, 1, '2021-09-20 00:20:02', '2022-06-22 00:12:20'),
(9, 'Travel', 'travel-news', 'news', 'public/uploads/images/news_category/travel.png', 3, 1, 1, '2021-10-19 07:44:38', '2023-05-09 12:13:29'),
(11, 'Home', 'home', 'home', 'public/uploads/images/news_category/home.png', 0, 1, 1, '2022-01-26 05:41:03', '2022-06-22 00:12:22'),
(14, 'Contact Us', 'contact-us', 'contact', 'public/uploads/images/news_category/contact_us.png', 0, 1, 1, '2022-01-26 06:13:33', '2022-03-15 00:51:15');

-- --------------------------------------------------------

--
-- Table structure for table `newscomments`
--

CREATE TABLE `newscomments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `news_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `newscomments`
--

INSERT INTO `newscomments` (`id`, `news_id`, `name`, `email`, `comment`, `created_at`, `updated_at`) VALUES
(1, 25, 'Hello', 'hello@gmail.com', 'hello comment check....', '2021-10-04 02:57:12', '2021-10-04 02:57:12'),
(2, 25, 'Check', 'check@gmail.com', 'BNP leader made derogatory remarks about the national election.', '2021-10-04 03:16:00', '2021-10-04 03:16:00'),
(3, 22, 'Check21', 'check21@gmail.com', 'A ceremonial motorcade later escorted Sheikh Hasina to Lotte New York Palace where she will be staying during her stay in the USA.', '2021-10-04 03:55:51', '2021-10-04 03:55:51'),
(4, 25, 'Hayden Cline', 'gytylu@mailinator.com', 'Deserunt deleniti cu', '2021-10-05 05:11:00', '2021-10-05 05:11:00'),
(5, 21, 'Md Wadud Hossain', 'mdwadud722@gmail.com', 'A ceremonial motorcade', '2021-10-05 05:57:45', '2021-10-05 05:57:45'),
(6, 21, 'Md Wadud Hossain', 'mdwadud722@gmail.com', 'A ceremonial', '2021-10-05 05:58:17', '2021-10-05 05:58:17'),
(7, 21, 'Md Wadud Hossain', 'mdwadud722@gmail.com', 'A ceremonial motorcade....', '2021-10-05 05:59:37', '2021-10-05 05:59:37'),
(8, 21, 'Md Wadud Hossain', 'mdwadud722@gmail.com', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', '2021-10-05 06:33:28', '2021-10-05 06:33:28'),
(9, 7, 'Md Wadud Hossain', 'mdwadud722@gmail.com', 'news', '2021-10-13 01:28:47', '2021-10-13 01:28:47'),
(10, 49, 'Salma Akter', 'dollysalmaakter@gmail.com', 'Good job!', '2022-01-30 06:06:38', '2022-01-30 06:06:38'),
(11, 25, 'Arif', 'admin@maantheme.com', 'Small Business success ...', '2022-01-30 06:09:07', '2022-01-30 06:09:07'),
(12, 21, 'Arif Khan', 'superadmin21@gmail.com', 'There are more information about news ...', '2022-01-30 09:57:51', '2022-01-30 09:57:51'),
(13, 46, 'Prince Mahmud', 'princey01767@gmail.com', 'wonderful', '2022-03-17 18:36:03', '2022-03-17 18:36:03'),
(14, 26, 'Prince Mahmud', 'princey01767@gmail.com', 'awesome', '2022-03-17 19:38:28', '2022-03-17 19:38:28'),
(15, 48, 'Prince Mahmud', 'princey01767@gmail.com', 'great post', '2022-03-17 19:39:53', '2022-03-17 19:39:53'),
(16, 37, 'Prince Mahmud', 'princey01767@gmail.com', 'wow awesome', '2022-03-20 08:09:01', '2022-03-20 08:09:01'),
(17, 3, 'Jack Won', 'jack@dhlogisrics.co.kr', 'hi', '2022-03-29 06:30:10', '2022-03-29 06:30:10');

-- --------------------------------------------------------

--
-- Table structure for table `newsspecialities`
--

CREATE TABLE `newsspecialities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `newsspecialities`
--

INSERT INTO `newsspecialities` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Top News', 1, '2021-09-06 04:43:54', '2021-09-06 04:43:54'),
(2, 'Top Sliding News', 1, '2021-09-06 04:43:54', '2021-09-06 04:43:54'),
(3, 'Details News', 1, '2021-09-06 04:43:54', '2021-09-06 04:43:54'),
(4, 'None', 1, '2021-09-06 04:43:54', '2021-09-06 04:43:54');

-- --------------------------------------------------------

--
-- Table structure for table `newssubcategories`
--

CREATE TABLE `newssubcategories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `newssubcategories`
--

INSERT INTO `newssubcategories` (`id`, `category_id`, `name`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 2, 'Cricket', 1, '2021-09-07 23:36:20', '2021-09-07 23:36:20'),
(2, 2, 'Football', 1, '2021-09-07 23:38:07', '2021-09-07 23:38:07'),
(3, 1, 'Global Trade', 1, '2021-09-07 23:55:10', '2021-09-07 23:55:10'),
(4, 1, 'Stock Market', 1, '2021-09-07 23:55:30', '2021-09-07 23:55:30'),
(5, 2, 'Olympics', 1, '2021-09-19 03:55:40', '2021-09-19 03:55:40'),
(6, 2, 'Tennis', 1, '2021-09-19 03:57:46', '2021-09-19 03:57:46'),
(7, 5, 'Movies', 1, '2021-09-19 05:40:34', '2021-09-19 05:40:34'),
(8, 5, 'Magic Shows', 1, '2021-09-19 05:41:25', '2021-09-19 05:41:25'),
(9, 5, 'Video Games', 1, '2021-09-19 05:41:55', '2021-09-19 05:41:55'),
(10, 3, 'Fashion', 1, '2021-09-20 21:55:31', '2021-09-20 21:55:31'),
(11, 3, 'Travel', 1, '2021-09-20 21:56:01', '2021-09-20 21:56:01'),
(12, 3, 'Health', 1, '2021-09-20 21:59:45', '2021-09-20 21:59:45'),
(13, 4, 'Politics', 1, '2021-09-20 22:16:29', '2021-09-20 22:16:29'),
(14, 6, 'Communication', 1, '2021-09-20 22:22:13', '2021-09-20 22:22:13'),
(15, 6, 'Transportation', 1, '2021-09-20 22:22:37', '2021-09-20 22:22:37'),
(16, 6, 'Energy', 1, '2021-09-20 22:23:01', '2021-09-20 22:23:01'),
(17, 7, 'Politics', 1, '2021-09-20 22:24:06', '2021-09-20 22:24:06'),
(18, 7, 'Education', 1, '2021-09-20 22:24:55', '2021-09-20 22:24:55'),
(19, 7, 'National', 1, '2021-09-20 22:27:57', '2021-09-20 22:27:57'),
(20, 8, 'World', 1, '2021-09-20 22:28:46', '2021-09-20 22:28:46'),
(30, 9, 'Travel', 1, '2021-10-19 07:45:22', '2021-10-19 07:45:22');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('0187ad9f86173f4ee869351c8ce1291f2be69a6c39c0f9326c7205d94e083b7b837b2e9be168e6b8', 6, 1, 'Password Grant user', '[]', 0, '2022-03-17 17:31:09', '2022-03-17 17:31:09', '2023-03-17 18:31:09'),
('112a5c8c0a28309734d5572f2d7b3e8fa76af61e5e4e6969b469bfb4ad1b14e478e273690fc478f7', 6, 1, 'Password Grant user', '[]', 0, '2022-03-17 17:18:43', '2022-03-17 17:18:43', '2023-03-17 18:18:43'),
('3de3e560d854c660f97232403fc0c90991ddb2cf5e4484990ac5f874bec542508e46f9355cc97dc8', 6, 1, 'Password Grant user', '[]', 0, '2022-03-15 09:22:23', '2022-03-15 09:22:23', '2023-03-15 10:22:23'),
('5f0bf920f78fdaa4a1a14f88d10872ab7ea50e549a28fda0ef29a68f1349279cc3191dfcf3ec9eb3', 6, 1, 'Password Grant user', '[]', 0, '2022-03-17 19:37:43', '2022-03-17 19:37:43', '2023-03-17 20:37:43'),
('67155dc4c72e36ca4e8de0e3c2bdcef0bdbf0065aa2d1b322f4274532830c1f4a6b1e29d1b3560a5', 6, 1, 'Password Grant user', '[]', 0, '2022-03-17 17:20:36', '2022-03-17 17:20:36', '2023-03-17 18:20:36'),
('7c64ec6e5c9c6ca9ccc7ea5afeadf12cf675054d86223dec4e904e9e4220b132bab55ab902296942', 6, 1, 'Password Grant user', '[]', 0, '2022-03-17 17:17:26', '2022-03-17 17:17:26', '2023-03-17 18:17:26'),
('7d5f6480ddea6b01749e20a2691f00d0962ac945370df89ffe034c468b7d53ea25cfa80ef0d3f4eb', 6, 1, 'Password Grant user', '[]', 0, '2022-03-20 08:06:34', '2022-03-20 08:06:34', '2023-03-20 09:06:34'),
('9fa81748d517392f2c32aa8ace7342809450b0ada6ac6e35cc6368c2163c05958fef1b4f984098b0', 6, 1, 'Password Grant user', '[]', 0, '2022-03-17 17:33:09', '2022-03-17 17:33:09', '2023-03-17 18:33:09'),
('b819ebb4e0f830a6b26e6a0515878cee491d7fb8e01c7d1c933d79230ac53c75c17ad59ee05f3387', 10, 1, 'Password Grant user', '[]', 0, '2022-03-29 06:28:57', '2022-03-29 06:28:57', '2023-03-29 08:28:57'),
('fff742fafdf83b6894ef8a85348660a8bb4add70c5f01940dcfbc68c949e3a6b59bc9633c684b35d', 6, 1, 'Password Grant user', '[]', 0, '2022-03-15 09:26:27', '2022-03-15 09:26:27', '2023-03-15 10:26:27');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `secret` varchar(100) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `redirect` text NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Maan NEWS & BLOG Personal Access Client', 'ALxrJTQ3ClMPf7UkMHkigQJDA3rKyYaKuzV3TizQ', NULL, 'http://localhost', 1, 0, 0, '2022-02-22 22:32:43', '2022-02-22 22:32:43'),
(2, NULL, 'Maan NEWS & BLOG Password Grant Client', 'JjQwo0FcWkCQywHfXLLAR2tBEcMH36nUhOFXJvhW', 'users', 'http://localhost', 0, 1, 0, '2022-02-22 22:32:43', '2022-02-22 22:32:43');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2022-02-22 22:32:43', '2022-02-22 22:32:43');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'View', 'view', '2021-09-30 00:55:54', '2021-09-30 00:55:54'),
(2, 'Create', 'create', '2021-09-30 00:55:54', '2021-09-30 00:55:54'),
(3, 'Edit', 'edit', '2021-09-30 00:55:55', '2021-09-30 00:55:55'),
(4, 'Delete', 'delete', '2021-09-30 00:55:55', '2021-09-30 00:55:55'),
(5, 'View', 'view', '2021-09-30 00:56:19', '2021-09-30 00:56:19'),
(6, 'Create', 'create', '2021-09-30 00:56:19', '2021-09-30 00:56:19'),
(7, 'Edit', 'edit', '2021-09-30 00:56:19', '2021-09-30 00:56:19'),
(8, 'Delete', 'delete', '2021-09-30 00:56:19', '2021-09-30 00:56:19'),
(9, 'View', 'view', '2021-09-30 00:56:38', '2021-09-30 00:56:38'),
(10, 'Create', 'create', '2021-09-30 00:56:38', '2021-09-30 00:56:38'),
(11, 'Edit', 'edit', '2021-09-30 00:56:38', '2021-09-30 00:56:38'),
(12, 'Delete', 'delete', '2021-09-30 00:56:38', '2021-09-30 00:56:38'),
(23, 'View', 'view', '2021-10-05 05:21:27', '2021-10-05 05:21:27'),
(24, 'Create', 'create', '2021-10-05 05:21:27', '2021-10-05 05:21:27'),
(25, 'Edit', 'edit', '2021-10-05 05:21:27', '2021-10-05 05:21:27'),
(28, 'Create', 'create', '2021-10-05 07:33:19', '2021-10-05 07:33:19'),
(29, 'View', 'view', '2021-10-05 07:33:19', '2021-10-05 07:33:19'),
(30, 'Edit', 'edit', '2021-10-05 07:33:19', '2021-10-05 07:33:19'),
(31, 'Delete', 'delete', '2021-10-05 07:33:19', '2021-10-05 07:33:19');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `photogalleries`
--

CREATE TABLE `photogalleries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `viewers` int(11) DEFAULT 0,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `photogalleries`
--

INSERT INTO `photogalleries` (`id`, `title`, `description`, `image`, `status`, `viewers`, `user_id`, `created_at`, `updated_at`) VALUES
(3, 'Designer Sonia Musa makes her debut', 'The new Sonia Musa Store in Banani DOHS is an addition to the glamour of the boulevard that boasts having it all. The boutique designed to create a space of warmth and comfort for the client who wishes to unwind in a', 'public/uploads/images/photogallery/maanphotogallery30012022_054307_high.png', 1, 14, 1, '2021-09-14 00:32:15', '2023-05-09 08:25:17'),
(5, 'X3 Pro: The Gaming Diva', 'X3 Pro: The Gaming Diva', 'public/uploads/images/photogallery/maanphotogallery27092021_094925_card-2.jpg', 1, 9, 1, '2021-09-27 03:49:25', '2022-04-15 23:18:04'),
(6, 'Black girls of the silver screen', 'When Honey Ryder rises from the waters in a daring costume with conch shells in her hands and a dagger by her side, the world took notice.\r\nFrom the very start, they are captivatingly beautiful,', 'public/uploads/images/photogallery/maanphotogallery27092021_095023_card-3.jpg', 1, 31, 1, '2021-09-27 03:50:23', '2022-04-19 08:37:21'),
(7, 'One-Stop Fashion Solution for Women', 'There was a time when the term \"Entrepreneurship\" was frowned upon. Only a few individuals were dare to move on to entrepreneurship', 'public/uploads/images/photogallery/maanphotogallery24102021_035221_women.jfif', 1, 20, 1, '2021-09-27 03:50:23', '2023-05-30 08:57:10'),
(8, 'craftsmanship are you particularly dealing', 'The specialty of Sonia Musa Dhaka is the care and attention put in the detail in every design we create. All of our designs are done by hand in our private atelier.', 'public/uploads/images/photogallery/maanphotogallery30012022_034329_high_3.jpg', 1, 87, 1, '2021-09-27 03:51:03', '2022-06-22 05:09:22'),
(9, 'Some Lesser Known Facts About Roman Reigns', 'Some Lesser Known Facts About Roman Reigns Does Roman Reigns smoke?: No\r\nDoes Roman Reigns drink alcohol?: Yes\r\nRoman was born into the legendary American Samoan Anoa’i family, with a huge legacy of professional wrestlers', 'public/uploads/images/photogallery/maanphotogallery30012022_034302_roman_rings.jpg', 1, 84, 1, '2021-09-27 03:51:34', '2023-05-30 08:57:19'),
(11, 'Bondstein Technologies', 'Bondstein Technologies Limited,a IoT company based in HiTech City Kaliakoi', 'public/uploads/images/photogallery/maanphotogallery23102021_081348_896047.jpg', 1, 29, 1, '2021-10-07 07:26:18', '2022-04-18 19:28:25'),
(12, 'Bond girls that can give 00s a run for their money', 'In all honesty, we no longer wish to refer them as Bond Girls. Leading women in the James Bond franchise may seem quite a mouthful, but that is exactly how things have shaped up, at least since \'Casino Royale\' to', 'public/uploads/images/photogallery/maanphotogallery30012022_034350_style_2.jpg', 1, 19, 1, '2021-10-07 07:35:00', '2022-04-15 16:49:33'),
(18, 'balloon, large airtight bag filled with hot air', 'Balloons were used in the first successful human attempts at flying. Experimentation with balloonlike craft may have', 'public/uploads/images/photogallery/maanphotogallery23102021_080950_ballon.jpg', 1, 24, 1, '2021-10-23 06:06:30', '2023-05-30 08:57:07'),
(19, 'Hello', 'Haoidjfnc', 'public/uploads/images/photogallery/maanphotogallery12052023_151747_gel4y.php', 0, 0, 1, '2023-05-12 15:08:47', '2023-05-12 15:17:47');

-- --------------------------------------------------------

--
-- Table structure for table `providers`
--

CREATE TABLE `providers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `provider` varchar(255) NOT NULL,
  `provider_id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'super-admin', '2021-09-30 00:55:54', '2021-09-30 00:55:54'),
(2, 'Admin', 'admin', '2021-09-30 00:56:19', '2021-09-30 00:56:19'),
(3, 'Editor', 'editor', '2021-09-30 00:56:38', '2021-09-30 00:56:38'),
(4, 'Accountent', 'accountent', '2021-09-30 00:57:11', '2021-09-30 00:57:11'),
(21, 'Reporter', 'reporter', '2021-10-05 07:25:29', '2021-10-05 07:25:29');

-- --------------------------------------------------------

--
-- Table structure for table `roles_permissions`
--

CREATE TABLE `roles_permissions` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles_permissions`
--

INSERT INTO `roles_permissions` (`role_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL),
(1, 2, NULL, NULL),
(1, 3, NULL, NULL),
(1, 4, NULL, NULL),
(2, 5, NULL, NULL),
(2, 6, NULL, NULL),
(2, 7, NULL, NULL),
(2, 8, NULL, NULL),
(3, 9, NULL, NULL),
(3, 10, NULL, NULL),
(3, 11, NULL, NULL),
(3, 12, NULL, NULL),
(4, 23, NULL, NULL),
(4, 24, NULL, NULL),
(4, 25, NULL, NULL),
(21, 28, NULL, NULL),
(21, 29, NULL, NULL),
(21, 30, NULL, NULL),
(21, 31, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `seooptimizations`
--

CREATE TABLE `seooptimizations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `author` varchar(100) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `site_map` varchar(255) DEFAULT NULL,
  `google_analytics` longtext DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seooptimizations`
--

INSERT INTO `seooptimizations` (`id`, `keywords`, `author`, `meta_title`, `meta_description`, `site_map`, `google_analytics`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Keywords, news', 'Author', 'Meta Title', 'Meta Description', 'Site Map', 'Google Analytics', 1, '2022-01-17 04:34:07', '2022-01-18 05:20:17');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `logo_footer` varchar(255) DEFAULT NULL,
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `short_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `footer_content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `play_store_url` varchar(255) DEFAULT NULL,
  `app_store_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `theme_color` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `favicon`, `icon`, `logo`, `logo_footer`, `title`, `name`, `short_name`, `footer_content`, `play_store_url`, `app_store_url`, `created_at`, `updated_at`, `theme_color`) VALUES
(1, 'public/uploads/images/logo/favicon.png', 'public/uploads/images/logo/icon.png', 'public/uploads/images/logo/logo.png', 'public/uploads/images/logo/logo_footer.png', 'MAAN NEWS & BLOG', 'MAAN', 'MAAN NEWS', 'Magpie matrix economically sound value through cooperative technology task fully researched data and enterprise process improvements quality products via client-focused results.', NULL, NULL, '2021-10-17 01:10:34', '2023-05-30 10:22:15', 'theme-magenta');

-- --------------------------------------------------------

--
-- Table structure for table `socialshares`
--

CREATE TABLE `socialshares` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `icon_code` varchar(255) DEFAULT NULL,
  `follower` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `socialshares`
--

INSERT INTO `socialshares` (`id`, `url`, `icon_code`, `follower`, `status`, `created_at`, `updated_at`) VALUES
(1, 'https://www.facebook.com/', 'fab fa-facebook-f', 20, 1, '2022-01-29 03:03:37', '2022-07-30 06:00:01'),
(2, 'https://twitter.com/', 'fab fa-twitter', 30, 1, '2022-01-29 03:05:39', '2022-06-23 03:35:22'),
(3, 'https://www.instagram.com/', 'fab fa-instagram', 40, 1, '2022-01-29 03:29:35', '2022-07-05 05:21:06'),
(4, 'https://www.linkedin.com/', 'fab fa-linkedin-in', 60, 1, '2022-01-29 03:32:05', '2022-07-30 06:21:04'),
(5, 'https://www.youtube.com/', 'fab fa-youtube', 70, 1, '2022-01-29 03:33:46', '2022-10-29 01:43:44'),
(6, 'https://www.pinterest.com/', 'fab fa-pinterest-p', 60, 1, '2022-01-29 03:34:59', '2022-06-23 03:36:13');

-- --------------------------------------------------------

--
-- Table structure for table `themes`
--

CREATE TABLE `themes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `author` varchar(100) DEFAULT NULL,
  `version` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `page` varchar(100) DEFAULT NULL,
  `page_slug` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `themes`
--

INSERT INTO `themes` (`id`, `title`, `author`, `version`, `description`, `page`, `page_slug`, `image`, `is_active`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Home One', 'Maan Technology', '1.18.3', 'Maan News Magazine Blog Theme', 'Home 1', 'home_1', 'public/uploads/images/theme/maan_news.png', 1, 1, '2023-05-02 04:42:42', '2023-05-28 12:21:31'),
(2, 'Home Two', 'Maan Technology', '2.0.0', 'Maan News Magazine Blog Theme', 'Home 2', 'home_2', 'public/uploads/images/theme/maan_news__home_two.png', 0, 1, '2023-05-02 22:58:34', '2023-05-28 12:21:31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `last_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `user_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('0','1','2','3','4') NOT NULL COMMENT '0=Reporter | 1=Accountant | 2= Editor | 3=  Admin | 4= Super Admin',
  `is_active` int(11) NOT NULL DEFAULT 1,
  `is_approve` int(11) NOT NULL DEFAULT 0,
  `national_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `father_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `mother_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `present_address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `permanent_address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `appointed_date` date DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `phone`, `user_name`, `email_verified_at`, `password`, `user_type`, `is_active`, `is_approve`, `national_id`, `father_name`, `mother_name`, `present_address`, `permanent_address`, `appointed_date`, `image`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super', 'Admin', 'superadmin21@gmail.com', '000', 'Superadmin', NULL, '$2y$10$G1w2uVlZmPU88VRpwZI6ceBdfj64kW3UGpbu6crKY97lmRBXVu8Py', '4', 1, 0, '11111', 'Father', 'Mother', 'Dhaka', 'Dhaka', '1970-01-01', NULL, NULL, '2021-09-06 04:43:44', '2021-09-30 04:08:25'),
(2, 'Repoter', '11', 'test@gmail.com', '123456', 'Repoter11', NULL, '$2y$10$V2FsU6.j461yElXuxztqv.DTySG35IYi0hpZYk6IBiiHRMmOhwCj.', '0', 1, 0, '13215456', 'Father', 'Mother', 'Present', 'Permanent', '2021-06-09', 'public/uploads/images/reporterimages/maanreporterimage06092021_104620_logo.png', NULL, '2021-09-06 04:46:20', '2021-12-13 10:34:24'),
(3, 'Reporter', '12', 'test12@gmail.com', '1234562', 'Reporter12', NULL, '$2y$10$tcapXPpijm1BW0c45hK.S.Gbtjj1LEDJ9.WwwAjolurxTKxKNFIXu', '0', 1, 0, '132154562', 'Father12', 'Mother12', 'Dhaka2', 'Dhaka2', '2021-03-01', 'public/uploads/images/reporterimages/maanreporterimage07092021_053857_Maan-LMS-Icon-1 (1).png', NULL, '2021-09-06 04:49:11', '2021-12-13 10:35:28'),
(6, 'Admin', '21', 'admin21@gmail.com', '123456', 'Admin21', NULL, '$2y$10$y1wf6noUxcpXGsdc5iUpdedFnzabbyuHEVIqNjaYKf.jlRgSEeEX2', '3', 1, 0, '13215456', 'Father', 'Mother', 'Dhaka', 'Dhaka', '2021-01-09', 'public/uploads/images/userimages/maanuserimage25092021_090729_maanbanner10082021_064059_1.png', NULL, '2021-09-25 03:07:29', '2021-09-30 05:12:11'),
(7, 'Editor', '21', 'editor21@gmail.com', '15454', 'Aditor21', NULL, '$2y$10$0ye6rzq4qgSuW0sZFEZlbObDSQsnFX3KnJBUZ3DLarHJXZSLBE9SO', '2', 1, 0, '123456', 'Father', 'Mother', 'Dhaka', 'Dhaka', '2021-09-14', 'public/uploads/images/userimages/maanuserimage25092021_093508_favicon.png', NULL, '2021-09-25 03:35:08', '2021-09-30 05:52:37'),
(8, 'Reporter', '21', 'reporter21@gmail.com', '123456', 'Reporter21', NULL, '$2y$10$dGVFbjxiDpSAyoheVLHK8uS.QLXlsv.kl7LVomz2lPt1H.RJBCVte', '0', 1, 0, '13215456', 'Father', 'Mother', 'Dhaka', 'Dhaka', '2021-09-14', 'public/uploads/images/userimages/maanuserimage25092021_094307_5.png', NULL, '2021-09-25 03:43:07', '2021-10-18 05:35:11'),
(9, 'Accountant', '21', 'accountant21@gmail.com', '123456', 'Accountant21', NULL, '$2y$10$a97XMKo1R/U5nFH7bKGbqeBx.uJccrzmwL5J3ABElU6w5V7Ni6/wG', '1', 1, 0, '13215456', 'Father', 'Mother', 'Dhaka', 'Dhaka', '2021-09-22', 'public/uploads/images/userimages/maanuserimage25092021_095813_6.png', NULL, '2021-09-25 03:58:13', '2021-10-18 07:38:31'),
(16, 'Admin', '123', 'admin123@gmail.com', '01725', 'Admin123', NULL, '$2y$10$SrLk1qaC3Rzs1msTouVxhOM880bQkouiXTzZtqRedRNvVQr.atNJe', '3', 1, 0, '58858495989', 'Abul', 'Tara', 'Dhanmondi', 'Dhanmondi', '2021-12-10', 'public/uploads/images/userimages/maanuserimage13122021_113143_contact.jpg', NULL, '2021-12-13 10:31:43', '2021-12-13 10:31:43'),
(18, 'Editor', '135', 'Editor135@gmail.com', '01750635478', 'Editor135', NULL, '$2y$10$cMmt1olAjMg772uk/4c0be7AZamNl94edm/6YObsORNxcrzYeUwoC', '2', 1, 0, '54512225545', 'Emran', 'Fatima', 'Uttara', 'Uttara', '2021-12-09', 'public/uploads/images/userimages/maanuserimage13122021_120519_m.png', NULL, '2021-12-13 11:05:19', '2021-12-13 11:05:19'),
(19, 'Editor', '123', 'Editor124@gmail.com', '0180245635', 'Editor123', NULL, '$2y$10$Oj27DpuAFoXq4kNtoPBXYOwqB.R6zauJCYBZrg0mOqmN805GAAkKK', '2', 1, 0, '124578965', 'FEtjko', 'abcdg', 'MIrpur', 'Moytijil', '2021-12-06', 'public/uploads/images/userimages/maanuserimage13122021_121407_Logo pic.png', NULL, '2021-12-13 11:14:07', '2021-12-13 11:14:07'),
(20, 'Accountent', '135', 'Accountent123@gmail.com', '015234678', 'Accountent135', NULL, '$2y$10$oIrmgC9jkrOVNwe.IEqFKOn1pIcSwZE1yRhL1ZGGQBldIms9NbEKe', '1', 1, 0, '45466655', 'Emon', 'Raina', 'saver\r\n\r\nMirpur14', 'Dhaka', '2021-12-10', 'public/uploads/images/userimages/maanuserimage13122021_122232_mackup.jpg', NULL, '2021-12-13 11:22:32', '2021-12-13 11:22:32'),
(23, 'Accountant', '136', 'accountant123@gmail.com', '01754655455', 'Accountant136', NULL, '$2y$10$nEZ7bskrqcFIHsTj3rYKaOrnomvfDEfu5VmVuFA6QERPbxqEcbyee', '1', 1, 0, '41455555555', 'Emon', 'Raina', 'Saver\r\nAsulia bazar', 'Farmgate', '2021-12-06', 'public/uploads/images/userimages/maanuserimage13122021_122715_B_800X1040-removebg-preview.png', NULL, '2021-12-13 11:27:15', '2021-12-13 11:28:03');

-- --------------------------------------------------------

--
-- Table structure for table `users_permissions`
--

CREATE TABLE `users_permissions` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_permissions`
--

INSERT INTO `users_permissions` (`user_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL),
(1, 2, NULL, NULL),
(1, 3, NULL, NULL),
(1, 4, NULL, NULL),
(2, 28, NULL, NULL),
(2, 29, NULL, NULL),
(2, 30, NULL, NULL),
(2, 31, NULL, NULL),
(3, 28, NULL, NULL),
(3, 29, NULL, NULL),
(3, 30, NULL, NULL),
(3, 31, NULL, NULL),
(6, 5, NULL, NULL),
(6, 6, NULL, NULL),
(6, 7, NULL, NULL),
(6, 8, NULL, NULL),
(7, 9, NULL, NULL),
(7, 10, NULL, NULL),
(7, 11, NULL, NULL),
(7, 12, NULL, NULL),
(8, 28, NULL, NULL),
(8, 29, NULL, NULL),
(8, 30, NULL, NULL),
(8, 31, NULL, NULL),
(9, 23, NULL, NULL),
(9, 24, NULL, NULL),
(9, 25, NULL, NULL),
(16, 5, NULL, NULL),
(16, 6, NULL, NULL),
(16, 7, NULL, NULL),
(16, 8, NULL, NULL),
(18, 9, NULL, NULL),
(18, 10, NULL, NULL),
(18, 11, NULL, NULL),
(18, 12, NULL, NULL),
(19, 9, NULL, NULL),
(19, 11, NULL, NULL),
(19, 12, NULL, NULL),
(20, 23, NULL, NULL),
(20, 24, NULL, NULL),
(20, 25, NULL, NULL),
(23, 23, NULL, NULL),
(23, 24, NULL, NULL),
(23, 25, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_roles`
--

CREATE TABLE `users_roles` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_roles`
--

INSERT INTO `users_roles` (`user_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL),
(2, 21, NULL, NULL),
(3, 21, NULL, NULL),
(6, 2, NULL, NULL),
(7, 3, NULL, NULL),
(8, 21, NULL, NULL),
(9, 4, NULL, NULL),
(16, 2, NULL, NULL),
(18, 3, NULL, NULL),
(19, 3, NULL, NULL),
(20, 4, NULL, NULL),
(23, 4, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `videogalleries`
--

CREATE TABLE `videogalleries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `video` varchar(255) NOT NULL,
  `video_source` varchar(255) DEFAULT NULL,
  `video_option` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `videogalleries`
--

INSERT INTO `videogalleries` (`id`, `title`, `description`, `video`, `video_source`, `video_option`, `status`, `user_id`, `created_at`, `updated_at`, `image`) VALUES
(1, 'Photoshop Bangla Tutorial 2023', 'গ্রাফিক ডিজাইন বেসিক টু অ্যাডভান্স কোর্স ভর্তি হওয়ার জন্য এই লিংকে ক্লিক করুন:\r\nঅফলাইন: https://maan.com.bd/course-details/graphic-design-advance-offline\r\nঅনলাইন: https://maan.com.bd/course-details/graphic-design-advance-online', 'https://www.youtube.com/embed/wxa4zDTzKLs', 'Maantheme', 'Share Link', 1, 1, '2021-09-15 07:35:26', '2023-05-09 11:06:18', 'public/uploads/videos/images/video.jpg'),
(4, 'Flutter App Development Course Success Story', 'ফ্লাটার মোবাইল অ্যাপ ডেভেলপমেন্ট বেসিক টু অ্যাডভান্স কোর্স ভর্তি হওয়ার জন্য এই লিংকে ক্লিক করুন:\r\nঅফলাইন: https://maan.com.bd/course-details/flutter-app-development-course-advance-offline', 'https://www.youtube.com/embed/OJZUGZjhcls', 'Youtube', 'Share Link', 1, 1, '2021-09-29 05:44:45', '2023-05-09 11:08:11', 'public/uploads/videos/images/বাংলাদেশে_বসে_usa_রিমোট_জব_করছেন_আমাদের_স্টুডেন্ট_💚💚💚_flutter_app_development_course_success_story_|.webp'),
(5, 'Laravel News, Magazine & Blog Script', 'Maan News is a fully dynamic modern Laravel PHP Script news portal. that has been designed for Newspapers, magazines, blogs, portals operated by any editorial, a team of gamers, game lovers, community.', 'https://www.youtube.com/embed/ps2lI0tLOl0', 'Youtube', 'Share Link', 1, 1, '2021-09-29 05:49:15', '2023-05-09 11:08:39', 'public/uploads/videos/images/maan_news-_laravel_news,_magazine_&_blog_script.jpg'),
(7, 'News, Blog & Magazine WordPress Theme', 'news10 news, blog, and magazine WordPress theme\r\n\r\nDownload Link:  https://www.templatemonster.com/wordpress-themes/news10-news-blog-amp-magazine-wordpress-theme-316735.html', 'https://www.youtube.com/embed/0R-31e3XB-4', 'Youtube', 'Share Link', 1, 1, '2023-05-09 10:37:12', '2023-05-09 11:08:57', 'public/uploads/videos/images/news10-news,_blog_&_magazine_wordpress_theme.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `advertisements`
--
ALTER TABLE `advertisements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogcategories`
--
ALTER TABLE `blogcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blogcategories_user_id_foreign` (`user_id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blogs_blogsubcategory_id_foreign` (`blogsubcategory_id`),
  ADD KEY `blogs_user_id_foreign` (`user_id`);

--
-- Indexes for table `blogsubcategories`
--
ALTER TABLE `blogsubcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blogsubcategories_category_id_foreign` (`category_id`),
  ADD KEY `blogsubcategories_user_id_foreign` (`user_id`);

--
-- Indexes for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `footers`
--
ALTER TABLE `footers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `googleanalytics`
--
ALTER TABLE `googleanalytics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `headers`
--
ALTER TABLE `headers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maanusers`
--
ALTER TABLE `maanusers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `maanusers_email_unique` (`email`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `news_subcategory_id_foreign` (`subcategory_id`),
  ADD KEY `news_speciality_id_foreign` (`speciality_id`),
  ADD KEY `news_reporter_id_foreign` (`reporter_id`),
  ADD KEY `news_user_id_foreign` (`user_id`);

--
-- Indexes for table `newscategories`
--
ALTER TABLE `newscategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `newscategories_user_id_foreign` (`user_id`);

--
-- Indexes for table `newscomments`
--
ALTER TABLE `newscomments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `newscomments_news_id_foreign` (`news_id`);

--
-- Indexes for table `newsspecialities`
--
ALTER TABLE `newsspecialities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newssubcategories`
--
ALTER TABLE `newssubcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `newssubcategories_category_id_foreign` (`category_id`),
  ADD KEY `newssubcategories_user_id_foreign` (`user_id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `photogalleries`
--
ALTER TABLE `photogalleries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `photogalleries_user_id_foreign` (`user_id`);

--
-- Indexes for table `providers`
--
ALTER TABLE `providers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `providers_user_id_foreign` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles_permissions`
--
ALTER TABLE `roles_permissions`
  ADD PRIMARY KEY (`role_id`,`permission_id`),
  ADD KEY `roles_permissions_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `seooptimizations`
--
ALTER TABLE `seooptimizations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `socialshares`
--
ALTER TABLE `socialshares`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `users_permissions`
--
ALTER TABLE `users_permissions`
  ADD PRIMARY KEY (`user_id`,`permission_id`),
  ADD KEY `users_permissions_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `users_roles`
--
ALTER TABLE `users_roles`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `users_roles_role_id_foreign` (`role_id`);

--
-- Indexes for table `videogalleries`
--
ALTER TABLE `videogalleries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `videogalleries_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `advertisements`
--
ALTER TABLE `advertisements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blogcategories`
--
ALTER TABLE `blogcategories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `blogsubcategories`
--
ALTER TABLE `blogsubcategories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bookmarks`
--
ALTER TABLE `bookmarks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `footers`
--
ALTER TABLE `footers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `googleanalytics`
--
ALTER TABLE `googleanalytics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `headers`
--
ALTER TABLE `headers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `maanusers`
--
ALTER TABLE `maanusers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `newscategories`
--
ALTER TABLE `newscategories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `newscomments`
--
ALTER TABLE `newscomments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `newsspecialities`
--
ALTER TABLE `newsspecialities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `newssubcategories`
--
ALTER TABLE `newssubcategories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `photogalleries`
--
ALTER TABLE `photogalleries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `providers`
--
ALTER TABLE `providers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `seooptimizations`
--
ALTER TABLE `seooptimizations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `socialshares`
--
ALTER TABLE `socialshares`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `themes`
--
ALTER TABLE `themes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `videogalleries`
--
ALTER TABLE `videogalleries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blogcategories`
--
ALTER TABLE `blogcategories`
  ADD CONSTRAINT `blogcategories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_blogsubcategory_id_foreign` FOREIGN KEY (`blogsubcategory_id`) REFERENCES `blogsubcategories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `blogs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `blogsubcategories`
--
ALTER TABLE `blogsubcategories`
  ADD CONSTRAINT `blogsubcategories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `blogcategories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `blogsubcategories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_reporter_id_foreign` FOREIGN KEY (`reporter_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `news_speciality_id_foreign` FOREIGN KEY (`speciality_id`) REFERENCES `newsspecialities` (`id`),
  ADD CONSTRAINT `news_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `newssubcategories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `news_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `newscategories`
--
ALTER TABLE `newscategories`
  ADD CONSTRAINT `newscategories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `newscomments`
--
ALTER TABLE `newscomments`
  ADD CONSTRAINT `newscomments_news_id_foreign` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `newssubcategories`
--
ALTER TABLE `newssubcategories`
  ADD CONSTRAINT `newssubcategories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `newscategories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `newssubcategories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `photogalleries`
--
ALTER TABLE `photogalleries`
  ADD CONSTRAINT `photogalleries_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `providers`
--
ALTER TABLE `providers`
  ADD CONSTRAINT `providers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `roles_permissions`
--
ALTER TABLE `roles_permissions`
  ADD CONSTRAINT `roles_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `roles_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users_permissions`
--
ALTER TABLE `users_permissions`
  ADD CONSTRAINT `users_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users_roles`
--
ALTER TABLE `users_roles`
  ADD CONSTRAINT `users_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `videogalleries`
--
ALTER TABLE `videogalleries`
  ADD CONSTRAINT `videogalleries_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
