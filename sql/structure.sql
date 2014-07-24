-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Gostitelj: 127.0.0.1
-- Čas nastanka: 24. jul 2014 ob 22.46
-- Različica strežnika: 5.5.27
-- Različica PHP: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Zbirka podatkov: `nize01_cinovicomat`
--

-- --------------------------------------------------------

--
-- Struktura tabele `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Odloži podatke za tabelo `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('1eb5975ad6e7357be3501443d82d8aac', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', 1406228990, ''),
('57a41b3c9c8da0ce442dfded1ed1d4b2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', 1406229742, ''),
('730c1adea5e10d363a022c829c829f9e', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', 1406229486, ''),
('86e5d5b988f02db037d0f8e9b529267f', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', 1406233823, 'a:4:{s:9:"user_data";s:0:"";s:6:"userId";s:3:"793";s:4:"name";s:10:"Tilen Poje";s:6:"logged";b:1;}');

-- --------------------------------------------------------

--
-- Struktura tabele `vs_articles`
--

CREATE TABLE IF NOT EXISTS `vs_articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `state` tinyint(11) NOT NULL,
  `author_name` varchar(256) NOT NULL,
  `publish_up` date NOT NULL,
  `publish_down` date DEFAULT NULL,
  `frontpage` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabele `vs_bugs`
--

CREATE TABLE IF NOT EXISTS `vs_bugs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(20) NOT NULL DEFAULT 'not resolved',
  `priority` smallint(6) NOT NULL DEFAULT '0',
  `fixed` timestamp NULL DEFAULT NULL,
  `fixed_by` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabele `vs_content`
--

CREATE TABLE IF NOT EXISTS `vs_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(400) NOT NULL,
  `description` text,
  `ref_id` int(11) NOT NULL,
  `type` varchar(15) NOT NULL DEFAULT '1',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabele `vs_content_content`
--

CREATE TABLE IF NOT EXISTS `vs_content_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_id` int(11) NOT NULL,
  `ref_content_id` int(11) NOT NULL,
  `correlation` varchar(30) NOT NULL,
  `position` varchar(10) NOT NULL DEFAULT 'bottom',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabele `vs_content_users`
--

CREATE TABLE IF NOT EXISTS `vs_content_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `access_level` varchar(10) NOT NULL DEFAULT 'view',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabele `vs_events`
--

CREATE TABLE IF NOT EXISTS `vs_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `fee` varchar(20) NOT NULL,
  `type` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabele `vs_locations`
--

CREATE TABLE IF NOT EXISTS `vs_locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `building_name` varchar(250) DEFAULT NULL,
  `room_name` varchar(250) DEFAULT NULL,
  `street_village` varchar(256) NOT NULL,
  `house_number` varchar(8) NOT NULL,
  `post_number` varchar(8) NOT NULL,
  `city` varchar(256) NOT NULL,
  `region` varchar(250) DEFAULT NULL,
  `country` varchar(265) NOT NULL,
  `level` mediumint(9) NOT NULL DEFAULT '0',
  `parent` mediumint(9) NOT NULL DEFAULT '0',
  `geolat` varchar(15) DEFAULT NULL,
  `geolng` varchar(15) DEFAULT NULL,
  `gln` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabele `vs_media`
--

CREATE TABLE IF NOT EXISTS `vs_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `media` varchar(128) NOT NULL,
  `tag_id` int(11) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Odloži podatke za tabelo `vs_media`
--

INSERT INTO `vs_media` (`id`, `media`, `tag_id`, `created`) VALUES
(1, 'zelnik.net', 2, '2014-05-17 00:40:52'),
(2, 'dobrepolje.info', 112, '2014-07-08 21:56:44');

-- --------------------------------------------------------

--
-- Struktura tabele `vs_media_content`
--

CREATE TABLE IF NOT EXISTS `vs_media_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `media_id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabele `vs_multimedias`
--

CREATE TABLE IF NOT EXISTS `vs_multimedias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(400) NOT NULL,
  `format` varchar(10) NOT NULL,
  `category` varchar(20) NOT NULL DEFAULT 'new',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabele `vs_tags`
--

CREATE TABLE IF NOT EXISTS `vs_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `alias` varchar(256) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=170 ;

--
-- Odloži podatke za tabelo `vs_tags`
--

INSERT INTO `vs_tags` (`id`, `name`, `alias`, `created`) VALUES
(2, 'zelnik.net', 'zelnik.net', '2014-05-17 00:41:08'),
(3, 'novice', 'novice', '2014-05-17 00:42:31'),
(4, 'kultura', 'kultura', '2014-05-17 00:42:31'),
(5, 'šport', 'sport', '2014-05-17 00:42:49'),
(6, 'kino', 'kino', '2014-05-17 00:42:49'),
(7, 'hsdgsd', 'hsdgsd', '2014-05-17 02:47:11'),
(8, 'ne', 'ne', '2014-05-31 07:47:32'),
(9, 'nek', 'nek', '2014-05-31 07:47:33'),
(10, 'd', 'd', '2014-05-31 07:51:52'),
(11, 'n', 'n', '2014-05-31 07:51:54'),
(12, 'g', 'g', '2014-05-31 07:51:55'),
(13, 'h', 'h', '2014-05-31 07:51:55'),
(14, 'F', 'f', '2014-05-31 07:52:20'),
(15, 'Fo', 'fo', '2014-05-31 07:52:21'),
(16, 'Groovy', 'groovy', '2014-05-31 07:53:00'),
(17, 'Fortran', 'fortran', '2014-05-31 07:55:02'),
(18, 's', 's', '2014-05-31 07:56:36'),
(19, 'Ja', 'ja', '2014-05-31 07:56:47'),
(20, 'Geslo', 'geslo', '2014-05-31 07:57:28'),
(21, 'fdhfdfgdfg', 'fdhfdfgdfg', '2014-05-31 08:51:15'),
(22, 'sdf', 'sdf', '2014-05-31 08:51:20'),
(23, 'ddsfdsf', 'ddsfdsf', '2014-05-31 08:51:29'),
(24, 'dsfsdf', 'dsfsdf', '2014-05-31 08:51:32'),
(25, 'sfsdf', 'sfsdf', '2014-05-31 08:51:34'),
(26, 'fdghdf', 'fdghdf', '2014-05-31 08:52:32'),
(27, 'fdghddsf', 'fdghddsf', '2014-05-31 08:52:38'),
(28, 'sdfds', 'sdfds', '2014-05-31 08:52:39'),
(29, 'dsf', 'dsf', '2014-05-31 08:52:40'),
(30, 'ffddddfdf', 'ffddddfdf', '2014-05-31 08:52:44'),
(31, 'dfsdf', 'dfsdf', '2014-05-31 09:02:43'),
(32, 'fg', 'fg', '2014-05-31 09:03:04'),
(33, 'fgdfgdf', 'fgdfgdf', '2014-05-31 09:03:48'),
(34, 'ddfd', 'ddfd', '2014-05-31 09:03:53'),
(35, 'v', 'v', '2014-05-31 09:11:16'),
(36, 'gdfgfdgfd', 'gdfgfdgfd', '2014-05-31 09:13:34'),
(37, 'fgd', 'fgd', '2014-05-31 09:15:44'),
(38, 'gha', 'gha', '2014-05-31 09:17:53'),
(39, 'fdh', 'fdh', '2014-05-31 22:11:32'),
(40, 'fdhfdh', 'fdhfdh', '2014-05-31 22:11:32'),
(41, 'dfh', 'dfh', '2014-05-31 22:11:33'),
(42, 'k', 'k', '2014-05-31 22:26:11'),
(43, 'keke', 'keke', '2014-05-31 22:26:13'),
(44, 'kek', 'kek', '2014-05-31 22:26:15'),
(45, 'ap', 'ap', '2014-05-31 22:26:16'),
(46, 'apol', 'apol', '2014-05-31 22:26:17'),
(47, 'hah', 'hah', '2014-05-31 22:26:25'),
(48, 'haha', 'haha', '2014-05-31 22:26:26'),
(49, 'dka', 'dka', '2014-05-31 22:26:58'),
(50, 'dkar', 'dkar', '2014-05-31 22:26:59'),
(51, 'apolo', 'apolo', '2014-05-31 22:30:26'),
(52, 'neka', 'neka', '2014-05-31 22:32:05'),
(53, 'mo', 'mo', '2014-05-31 22:32:07'),
(54, 'mor', 'mor', '2014-05-31 22:32:07'),
(55, 'apo', 'apo', '2014-05-31 22:33:49'),
(56, 'he', 'he', '2014-05-31 22:36:48'),
(57, 'heh', 'heh', '2014-05-31 22:36:49'),
(58, 'kak', 'kak', '2014-05-31 22:37:17'),
(59, 'apoc', 'apoc', '2014-05-31 22:39:00'),
(60, 'c', 'c', '2014-05-31 22:39:01'),
(61, 'ch', 'ch', '2014-05-31 22:39:03'),
(62, 'Choice2', 'choice2', '2014-05-31 22:39:04'),
(63, 'ah', 'ah', '2014-05-31 22:41:41'),
(64, 'ahk', 'ahk', '2014-05-31 22:41:42'),
(65, 'ha', 'ha', '2014-05-31 22:42:05'),
(66, 'df', 'df', '2014-05-31 22:47:49'),
(67, 'ke', 'ke', '2014-05-31 22:49:27'),
(68, 'ho', 'ho', '2014-05-31 23:01:32'),
(69, 'hoh', 'hoh', '2014-05-31 23:01:33'),
(70, 'apolon', 'apolon', '2014-05-31 23:02:03'),
(71, 'ze', 'ze', '2014-05-31 23:02:31'),
(72, 'zel', 'zel', '2014-05-31 23:02:32'),
(73, 'm', 'm', '2014-05-31 23:05:52'),
(74, 'ka', 'ka', '2014-05-31 23:05:56'),
(75, 'zew', 'zew', '2014-05-31 23:06:14'),
(76, 'zelni', 'zelni', '2014-05-31 23:11:44'),
(77, 'zelnik', 'zelnik', '2014-05-31 23:14:47'),
(78, 't', 't', '2014-05-31 23:16:31'),
(79, 'te', 'te', '2014-05-31 23:17:32'),
(80, 'a', 'a', '2014-05-31 23:18:57'),
(81, '[object Object]', 'object-object', '2014-05-31 23:23:57'),
(82, 'z', 'z', '2014-05-31 23:24:36'),
(83, 'zr', 'zr', '2014-05-31 23:25:35'),
(84, 'zez', 'zez', '2014-05-31 23:26:12'),
(85, 'zezr', 'zezr', '2014-05-31 23:26:13'),
(86, 'zezrf', 'zezrf', '2014-05-31 23:26:24'),
(87, 'zezrfg', 'zezrfg', '2014-05-31 23:26:30'),
(88, 'zezrfgds', 'zezrfgds', '2014-05-31 23:27:14'),
(89, 'ma', 'ma', '2014-05-31 23:32:41'),
(90, 'lo', 'lo', '2014-05-31 23:32:45'),
(91, 'lol', 'lol', '2014-05-31 23:32:46'),
(92, 'l', 'l', '2014-05-31 23:32:47'),
(93, 'ri', 'ri', '2014-05-31 23:32:49'),
(94, 've', 've', '2014-05-31 23:32:51'),
(95, 'Array', 'array', '2014-06-01 03:11:36'),
(96, 'Arr', 'arr', '2014-06-01 03:11:56'),
(97, 'nekaj', 'nekaj', '2014-06-13 11:49:20'),
(98, 'funny', 'funny', '2014-06-27 14:19:53'),
(99, 'troll', 'troll', '2014-06-27 14:19:53'),
(100, 'ghkghk', 'ghkghk', '2014-06-28 02:59:06'),
(101, 'hgjhgj', 'hgjhgj', '2014-06-28 02:59:06'),
(102, 'sdgsdg', 'sdgsdg', '2014-07-04 01:46:04'),
(103, 'sdgsdgdsg', 'sdgsdgdsg', '2014-07-04 01:46:04'),
(104, 'dsgsdg', 'dsgsdg', '2014-07-04 02:13:57'),
(105, 'sdgsdgsdg', 'sdgsdgsdg', '2014-07-04 02:15:05'),
(106, 'sdgsdgsd', 'sdgsdgsd', '2014-07-04 02:16:27'),
(107, 'sdgfsdgsdg', 'sdgfsdgsdg', '2014-07-04 02:16:27'),
(108, 'blih', 'blih', '2014-07-04 02:34:34'),
(109, 'blah', 'blah', '2014-07-04 02:34:34'),
(110, 'bloop', 'bloop', '2014-07-04 02:34:34'),
(111, 'blooop', 'blooop', '2014-07-04 02:34:46'),
(112, 'dobrepolje.info', 'dobrepolje.info', '2014-07-08 21:56:10'),
(113, 'dgsdgsdg', 'dgsdgsdg', '2014-07-08 22:26:19'),
(114, '0', '0', '2014-07-08 22:27:27'),
(115, 'hehe', 'hehe', '2014-07-09 04:28:43'),
(116, 'neki', 'neki', '2014-07-10 21:21:08'),
(117, 'kaktus', 'kaktus', '2014-07-10 21:21:08'),
(118, 'zelnik.nett', 'zelnik-nett', '2014-07-11 01:31:48'),
(119, 'cat', 'cat', '2014-07-11 02:11:24'),
(120, 'meow', 'meow', '2014-07-11 02:11:24'),
(121, 'drugega', 'drugega', '2014-07-11 02:16:12'),
(122, 'sun', 'sun', '2014-07-11 02:17:35'),
(123, 'beach', 'beach', '2014-07-11 02:17:35'),
(124, 'boats', 'boats', '2014-07-11 02:17:35'),
(125, 'sea', 'sea', '2014-07-11 02:18:12'),
(126, 'pear', 'pear', '2014-07-11 02:18:12'),
(127, 'fun', 'fun', '2014-07-11 02:21:06'),
(128, 'System Shock 2', 'ystem-hock-2', '2014-07-11 03:03:14'),
(129, 'Video game', 'ideo-game', '2014-07-11 03:03:14'),
(130, 'Shodan', 'hodan', '2014-07-11 03:03:14'),
(131, 'zelnik.nettt', 'zelnik-nettt', '2014-07-11 03:20:43'),
(132, 'music', 'music', '2014-07-11 11:49:33'),
(133, 'bug', 'bug', '2014-07-11 14:41:02'),
(134, 'error', 'error', '2014-07-11 14:41:02'),
(135, 'report', 'report', '2014-07-11 14:41:02'),
(136, 'asfasf', 'asfasf', '2014-07-24 00:17:04'),
(137, 'futbal', 'futbal', '2014-07-24 00:35:23'),
(138, 'sdg', 'sdg', '2014-07-24 00:54:40'),
(139, 'fdhdfh', 'fdhdfh', '2014-07-24 00:54:40'),
(140, 'nsdgsdg', 'nsdgsdg', '2014-07-24 01:00:08'),
(141, 'adsgsdg', 'adsgsdg', '2014-07-24 01:00:08'),
(142, 'dgsdg', 'dgsdg', '2014-07-24 01:03:43'),
(143, 'php', 'php', '2014-07-24 01:09:27'),
(144, 'programming', 'programming', '2014-07-24 01:09:27'),
(145, 'awesome', 'awesome', '2014-07-24 01:09:27'),
(146, 'tilen', 'tilen', '2014-07-24 01:10:07'),
(147, 'test', 'test', '2014-07-24 01:10:07'),
(148, 'bored', 'bored', '2014-07-24 01:10:07'),
(149, 'fdhdfhfd', 'fdhdfhfd', '2014-07-24 01:11:03'),
(150, 'nature', 'nature', '2014-07-24 04:50:18'),
(151, 'village', 'village', '2014-07-24 04:50:18'),
(152, 'houses', 'houses', '2014-07-24 04:50:18'),
(153, 'green', 'green', '2014-07-24 04:50:18'),
(154, 'games', 'games', '2014-07-24 12:38:36'),
(155, 'virtual', 'virtual', '2014-07-24 12:38:36'),
(156, 'top', 'top', '2014-07-24 12:38:36'),
(157, 'video', 'video', '2014-07-24 13:01:39'),
(158, 'system shock', 'system-shock', '2014-07-24 13:01:47'),
(159, 'videogame', 'videogame', '2014-07-24 13:01:49'),
(160, 'insect', 'insect', '2014-07-24 13:03:49'),
(161, 'SystemShock2', 'ystemhock2', '2014-07-24 13:03:51'),
(162, 'sys', 'sys', '2014-07-24 13:29:54'),
(163, 'kekec', 'kekec', '2014-07-24 20:05:04'),
(164, 'zabava', 'zabava', '2014-07-24 20:05:04'),
(165, 'slovenija', 'slovenija', '2014-07-24 20:05:04'),
(166, 'članek', 'lanek', '2014-07-24 20:07:38'),
(167, 'super', 'super', '2014-07-24 20:07:42'),
(168, 'rozika', 'rozika', '2014-07-24 20:08:40'),
(169, 'rožica', 'roica', '2014-07-24 20:08:40');

-- --------------------------------------------------------

--
-- Struktura tabele `vs_tags_content`
--

CREATE TABLE IF NOT EXISTS `vs_tags_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabele `vs_tags_media`
--

CREATE TABLE IF NOT EXISTS `vs_tags_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Odloži podatke za tabelo `vs_tags_media`
--

INSERT INTO `vs_tags_media` (`id`, `tag_id`, `parent_id`) VALUES
(1, 2, 0),
(3, 3, 112),
(4, 4, 112),
(5, 6, 4),
(6, 5, 3),
(7, 112, 0);

-- --------------------------------------------------------

--
-- Struktura tabele `vs_token`
--

CREATE TABLE IF NOT EXISTS `vs_token` (
  `token_id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(50) NOT NULL,
  `token_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `used` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`token_id`),
  KEY `user_id` (`user_id`),
  KEY `user_id_2` (`user_id`),
  KEY `user_id_3` (`user_id`),
  KEY `user_id_4` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Odloži podatke za tabelo `vs_token`
--

INSERT INTO `vs_token` (`token_id`, `token`, `token_created`, `used`, `user_id`) VALUES
(20, 'd3b6c3275acca7515bbd05421d467c0d', '2014-06-04 01:56:27', 1, 794),
(21, 'b6c91aa1a02c2982e57c59076c2a3337', '2014-06-04 01:56:53', 0, 794),
(22, '9582e31d80238e81b3044472b94a5285', '2014-06-04 02:10:25', 0, 799);

-- --------------------------------------------------------

--
-- Struktura tabele `vs_users`
--

CREATE TABLE IF NOT EXISTS `vs_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(150) NOT NULL DEFAULT '',
  `password_SALT` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL DEFAULT '',
  `send_email` tinyint(4) DEFAULT '1',
  `block` tinyint(4) NOT NULL DEFAULT '0',
  `activation` tinyint(4) NOT NULL DEFAULT '0',
  `last_visited` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_2` (`username`),
  KEY `idx_name` (`name`),
  KEY `idx_block` (`block`),
  KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=801 ;

--
-- Odloži podatke za tabelo `vs_users`
--

INSERT INTO `vs_users` (`id`, `name`, `username`, `password_SALT`, `password`, `email`, `send_email`, `block`, `activation`, `last_visited`, `created`) VALUES
(499, 'Administrator', 'admin', '', 'b299d8df00332b8d5de5870a46c5da23', 'zelnik.net@gmail.com', 1, 0, 0, '2014-02-21 13:30:18', '2009-05-02 22:04:03'),
(500, 'Nastja', 'Nastja', '', '61c0d02090d71a5689a9717c69fa237d:gi2ZlqsnG8EVt72LWKS8xn028o1B3piE', 'nastja.pugelj@hotmail.com', 0, 0, 0, '2012-05-19 12:33:20', '2013-08-30 22:25:13'),
(501, 'kuby', 'kuby', '', 'f8eca92ae8f5c55f002969145df05218', 'bojana.meglen@gmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(502, 'Anton_Grm-SDB', 'Anton_Grm-SDB', '', 'dbd682c08afd89c56c935d782a025edc:aILyypdh4UHYZF7HXO6vePpUFDQ9vyHb', 'anton.grm@gmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(503, 'M4rk0_Skull', 'M4rk0_Skull', '', 'fdb47f124a6bd26ca0dffed676f216c5:dbM0kh8w7eUUKUHjWsW6kp5Gb0yAkaYA', 'markoskulj@gmail.com', 0, 0, 0, '2012-04-09 17:03:43', '0000-00-00 00:00:00'),
(504, 'cecil0mt', 'cecil0mt', '', '93c06db5d941f5544ebeeb4c46dc52ba', 'busybusy@o2.pl', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(505, 'mdd', 'mdd', '', 'bedefb930f9500d7fbc9ea4bcfbcd9c4', 'mdd@mdd.iconrate.net', 0, 0, 0, '2010-10-12 11:31:38', '0000-00-00 00:00:00'),
(506, 'Andrej', 'Andrej', '', 'cf772df8b3ae67b2d5d660fbd59362bc', 'andrej.znidarsic@gmail.com', 0, 0, 0, '2011-01-24 18:23:59', '0000-00-00 00:00:00'),
(507, 'Peter', 'Peter', '', '91870a5a8c414a46ccfb49a6fb033650', 'jakopic@volja.net', 0, 0, 0, '2011-01-19 07:47:07', '0000-00-00 00:00:00'),
(508, 'matic', 'matic', '', '018a9567ea15470312c40d3e5d6bbcd4', 'maticvodicar@email.si', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(509, 'Brozzy', 'Brozzy', '', '148b1f6789be5b478959feafaed7e5f6', 'ambroz.volek@gmail.com', 0, 0, 0, '2013-10-10 09:44:58', '0000-00-00 00:00:00'),
(510, 'Jonny', 'Jonny', '', '87f88c4d52e26f0911cc7989d13397f7', 'jonny.jakopic@email.si', 0, 0, 0, '2011-01-16 21:16:56', '0000-00-00 00:00:00'),
(511, 'Irena', 'Irena', '', 'cbc6e819b675b48ff92e42cb225bada7', 'carrissime89@gmail.com', 0, 0, 0, '2012-01-14 15:56:58', '0000-00-00 00:00:00'),
(512, 'bizgec', 'bizgec', '', '04de585742ffff8aa5db858be19b1f2b:V1Ta5mg2zfOeccNdyWf1UtT5SU5pRf7h', 'bizgec@afnegunca.com', 0, 0, 0, '2013-06-06 13:12:21', '0000-00-00 00:00:00'),
(513, 'big_foot', 'big_foot', '', 'cf8a02d0575e038e78cefcea178cbd67', 'glavicl@student.fmf.uni-lj.si', 0, 0, 0, '2011-10-05 19:31:10', '0000-00-00 00:00:00'),
(514, 'tina', 'tina', '', '87e553a987ea906f8b2575b83a389217', 'tina_borstnik_1991@hotmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(515, 'janchy', 'janchy', '', '8a89d20427db9621729ffd8acff83d9c', 'janasustar@email.si', 0, 0, 0, '2012-10-12 12:47:04', '0000-00-00 00:00:00'),
(516, 'alenka', 'alenka', '', '16c13f83a0ed091877b85386e5330a84', 'alenka_znidarsic@email.si', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(517, 'chipz', 'chipz', '', '51dc30ddc473d43a6011e9ebba6ca770', 'pznidarsic@email.si', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(518, 'naty', 'naty', '', 'fcea920f7412b5da7be0cf42b8c93759', 'natalija.fink@volja.net', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(519, 'LALA', 'LALA', '', 'ee63d6a66801f2ee9f1cf7a70ea6bd73', 'laura_sadar@hotmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(520, 'WildChild', 'WildChild', '', '124217c1c5772c4f2cf7f0eb85d08d4d', 'joze.prijatelj@gmail.com', 0, 0, 0, '2011-06-07 21:46:48', '0000-00-00 00:00:00'),
(521, 'anchy', 'anchy', '', 'b49d3b7c789f8fe0e3425c537dad748e', 'anjakralj@email.si', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(522, 'andreja', 'andreja', '', 'fa774183ab00517107b0a5bf61f91e97', 'andreja_sevsek@hotmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(523, 'Gremlin', 'Gremlin', '', '827cf04777d98252b2adb71d4b137319', 'miha.boh@gmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(524, 'SuperS', 'SuperS', '', '592db47d5ccc62700d6dfc9f16c1f862', 'sandiglac@hotmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(525, 'KoKiCa', 'KoKiCa', '', 'fdb66430b98428c92fc49e29489c09ce', 'katja.polzelnik@email.si', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(526, 'AndrejaN', 'AndrejaN', '', 'fc1ee889b4a803673ae344022ac843b2', 'tejc.novak@gmail.com', 0, 0, 0, '2012-03-17 10:26:54', '0000-00-00 00:00:00'),
(527, 'frucita', 'frucita', '', 'ae917007569251a7f90e0b15bc77450e', 'lumpek15@email.si', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(528, 'alien', 'alien', '', '41856fb92c2759eb89d993ffaef9724b', 'alien@afnegunca.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(529, 'scream', 'scream', '', '20076547310803443eb482ec21bc3c3a', 'tefanm@yahoo.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(530, 'mecurysmile', 'mecurysmile', '', '0bcfd981aa10782e1e58bbb31b05b9b9', 'vida_borstnik@hotmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(531, 'Exterminator', 'Exterminator', '', '4d332c841628f709302f7ff9b3076bb8:FfRnnkOZ71T3eDdA3RreZIvWSms2zHi8', 'klemen.tegel@siol.com', 0, 0, 0, '2013-04-18 22:45:18', '0000-00-00 00:00:00'),
(532, 'chatya', 'chatya', '', '0c4d309fb04589954c67ad9508eb2c33', 'katja_meglen@hotmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(533, 'Timy', 'Timy', '', '277542526c46b4de7c23bdc23511ebf1:MdJVwd5zDighZdajw2MPipOn3xONXRZs', 'timos.skavt@hotmail.com', 0, 0, 0, '2011-05-14 23:46:46', '0000-00-00 00:00:00'),
(534, 'rewanger', 'rewanger', '', 'f53d25dce191d689906c081e2f4a2222', 'rewanger@msn.com', 0, 0, 0, '2010-12-06 17:18:22', '0000-00-00 00:00:00'),
(535, 'Lukec', 'Lukec', '', '16775d86b977f99b3a7b5d5697e0c9de', 'mperhaj@siol.net', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(536, 'LucijaV', 'LucijaV', '', '7aa8758f5445be6ce2bcbc0af346b437', 'lucija.volek@email.si', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(537, 'hidrazin', 'hidrazin', '', 'bd7e5b29fd5d6066d158c97e391f90a7', 'neron543@hotmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(538, 'vilma', 'vilma', '', '8f91cec9a1609e68f34437507025c804', 'vilmasustar@hotmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(539, 'Domen', 'Domen', '', '9d55b4211f9645a5b6409ee72a2f60ce', 'dalenc007@hotmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(540, 'Gorgoroth', 'Gorgoroth', '', 'e10adc3949ba59abbe56e057f20f883e', 'suzana.kastelic@siol.net', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(541, 'anchy117', 'anchy117', '', '70d28c7f4f175f911c034e18b5358624', 'anchy117@hotmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(542, 'NAJ_M', 'NAJ_M', '', 'c25f3dbc7a8d5cb814b830f0a625776e', 'matejamarn@volja.net', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(543, 'Odpadnik', 'Odpadnik', '', 'a964e5550c7504a5ea8e57ef642963c0', 'matija_zakrajsek@hotmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(544, 'Mana', 'Mana', '', '86094b61cb9f63b77f982ceae03e95f0', 'mgirll@gmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(545, 'sonja', 'sonja', '', '51c0345366ffde9fd8c3b23cd8ba68c1', 'sonja.densa@email.si', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(546, 'HiShiWiko', 'HiShiWiko', '', '000905801d6dbe966ed5d6aea8c4d71a', 'man1ac.from.70s@hotmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(547, 'pirnat', 'pirnat', '', '5a105e8b9d40e1329780d62ea2265d8a', 'mufic@volja.net', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(548, 'GeorgeConstanza', 'GeorgeConstanza', '', '3548907c81df0f9873912e1836744966', 'gobanovec@yahoo.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(549, 'mrgica', 'mrgica', '', '79a964802962d5255f3627cfcd54837b', 'jana.zajec@gmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(550, 'Etna', 'Etna', '', '0c4d309fb04589954c67ad9508eb2c33', 'katja.meglen@gmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(551, 'teenager15', 'teenager15', '', '3189934774aa880fa7fbf8da8f9e446d', 'teenager1991@hotmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(552, 'janezk88', 'janezk88', '', '570134d5f31e504e5aff2ae61d0ba622', 'janez.kaplan@email.si', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(553, 'ScEry', 'ScEry', '', 'bdbc5b138045460c5b8416c38ffbeb3d', 'erika.erculj@hotmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(554, 'mato', 'mato', '', 'cd61465fe691cfb2cd3ba46f2ab1389c', 'matjaz.sustarsic@hotmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(555, 'griza', 'griza', '', 'b843f30e719da6b131f8127dcd695935', 'griza@email.si', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(556, 'schpella', 'schpella', '', 'e5732f9e6f7b5ffbf53208f49fdf835f', 'spela.nose@gmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(557, 'illidan', 'illidan', '', '73db5bd1e66f38ed6461d728d6e8d5a3', 'lenarcicm@gmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(558, 'the_one_and_only', 'the_one_and_only', '', 'c27b18f4917d9d68e8f47e4fae2d6573', 'eva.blabla@hotmail.com', 0, 0, 0, '2011-02-02 14:32:37', '0000-00-00 00:00:00'),
(559, 'miha', 'miha', '', '1bfa5721cf377eef156085e114b52c05', 'miha_jakic@hotmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(560, 'ditka', 'ditka', '', '49fe4ff7e8ff356b5a525b5e100ba3a6', 'joze.bostjancic@volja.net', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(561, 'Petrca', 'Petrca', '', 'a1eb3ef34d8529b75bdf9791d028ec15', 'petrca04@gmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(562, 'PoWerBARoWc', 'PoWerBARoWc', '', '750379b5926e9f728aa6c253d37e3792', 'DORON007@SIOL.NET', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(563, 'andrejak', 'andrejak', '', '6f68292d690fe51520ad9cf97602d475', 'andreja55@siol.net', 0, 0, 0, '2010-09-29 19:06:24', '0000-00-00 00:00:00'),
(564, 'klewen', 'klewen', '', '0e84d1bfcf1d76538320e8e1b05eb5b0', 'info@klub-gros.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(565, 'rencka14', 'rencka14', '', '13aef0865dcae54b2e4db0067e3fd5c6', 'renata_jersin@hotmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(566, 'happysun', 'happysun', '', 'a53aa07b23780ff41709edf69e83d90f', 'happysun@mail386.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(567, 'mitjap', 'mitjap', '', '22ae4b376cb2046afaae0d1ec28debf6', 'mitja.pavlic@mksmarjeta.org', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(568, 'Lordi7', 'Lordi7', '', 'edc5a121643efce84bc9f05b0e3bd68f', 'aljaz.vidmar@email.si', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(569, 'sasa', 'sasa', '', 'b39b373025e6ce82c61c03e345c57b13', 'metulj1992@hotmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(570, 'breza', 'breza', '', '9b2f08bea2ce325308b1d894736978b5', 'breza@mail386.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(571, 'jest', 'jest', '', '3e57ff16f01e337ff094cccb14c58e01', 'anja.jest@gmail.com', 0, 0, 0, '2010-03-19 21:20:25', '0000-00-00 00:00:00'),
(572, 'firbcna-soja', 'firbcna-soja', '', '73fc3664ddbbf12311363c7214efffad', 'firbcna.soja@planet.si', 0, 0, 0, '2010-03-02 16:14:39', '0000-00-00 00:00:00'),
(573, 'HiShiWik0', 'HiShiWik0', '', '98408db9a8744a44dbd4c7998f98c9d1', 'tadej_prijatelj@hotmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(574, 'jercy', 'jercy', '', '48b5201d069c8c3318977ff9883d2979', 'jernej33@hotmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(575, 'jessy', 'jessy', '', 'b5a6c99a5c8d42a965f6d0ba462119af', 'jasminnca@gmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(576, 'shadow', 'shadow', '', '663cb5b7c568fdb968d37b98d7eee01a:84vqL6Lui4snIux2H5OrhWAlMkHqoSMt', 'primoz_prijatelj@hotmail.com', 0, 0, 0, '2011-03-22 20:27:33', '0000-00-00 00:00:00'),
(577, 'justine777', 'justine777', '', '2c73bdccfcb396e58ede6691fb9ca773', 'justine@kskvue.info', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(578, 'justine123', 'justine123', '', '2c73bdccfcb396e58ede6691fb9ca773', 'justine123@kskvue.info', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(579, 'LUCY', 'LUCY', '', '22d694e8104cd75f79620b6164538418', 'lucija_prijatelj@hotmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(580, 'Tania', 'Tania', '', '8b81f09dc269208395ddc0699564e5ba', 'tanja.elshawish@gmail.com', 0, 0, 0, '2010-10-06 14:46:28', '0000-00-00 00:00:00'),
(581, 'tadeya15', 'tadeya15', '', 'b359cc0cb8b0b918762498a3d3f138d9', 'rockerka1991@hotmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(582, 'Rock_Hubbard', 'Rock_Hubbard', '', 'cddfde39f7ed6a5f9cdd2a88d791334b', 'dgwwgo@onporn.info', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(583, 'kleopatra20', 'kleopatra20', '', '277ccab0f30358ed6a620e5ec4e6e4d7', 'kleopatra20@email.si', 0, 0, 0, '2013-03-05 11:53:20', '0000-00-00 00:00:00'),
(584, 'Donna38', 'Donna38', '', 'c1be96404557fd031b8f8ad967b47166', 'Donna38@the.agism.org', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(585, 'zvezdica', 'zvezdica', '', 'fa87d33dd746e9bea5e7965b2628fe6c', 'sabina.volek@siol.net', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(586, 'janja', 'janja', '', '8df33d5c3c530ff3e39cb48ab4159884', 'janja.janjcy@gmail.com', 0, 0, 0, '2011-02-06 16:13:54', '0000-00-00 00:00:00'),
(587, 'fakir7', 'fakir7', '', '1b3a7d30d966636386a272f0f8002ca7', 'elhakim19@gmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(588, 'Laura', 'Laura', '', 'e0c15088837ed4dfd8e6dc2f963bc522', 'laura.sadar@gmail.com', 0, 0, 0, '2011-10-05 10:07:45', '0000-00-00 00:00:00'),
(589, 'lukesanfor', 'lukesanfor', '', 'd1bd7b86c1a6ebf37c631e6aedc28109', 'lukesanfor@gmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(590, 'green_lake', 'green_lake', '', 'b576d4782bb631a931145ba31e711fa2', 'mirjam.cimerman@gmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(591, 'LjuboM', 'LjuboM', '', '283132b0e2326a0816ba0b3a4aeabd8e', 'ljubo@psdsi.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(592, 'zupnik1', 'zupnik1', '', '827ccb0eea8a706c4c34a16891f84e7b', 'p@email.si', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(593, 'klemen777', 'klemen777', '', 'b47dc4ddde0453f516610604e9c57faa', 'klemen.turnsek@gmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(594, 'Mejdun', 'Mejdun', '', '98c9c8def3882a03ef8cf6994172156e', 'janezgac@gmail.com', 0, 0, 0, '2013-07-03 05:42:19', '0000-00-00 00:00:00'),
(595, 'Ninchy', 'Ninchy', '', '04246ef4da8c2508fbdf25b0efd84521', 'mateja.krojs@siol.net', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(596, 'bond79895', 'bond79895', '', '827ccb0eea8a706c4c34a16891f84e7b', 'bond79895@avertorto.org', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(597, 'Barbara', 'Barbara', '', '85240fc7bf89de0ee5e450c68f3290c5', 'barbara.francelj@guest.arnes.si', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(598, 'little_miss_sunshine', 'little_miss_sunshine', '', 'a678f8f96d3995ae50d7b48cc26016bb', 'dashapiano@hotmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(599, 'katkaritka', 'little_crazy_dolly', '', 'd98cee728785f1d86e8901b25b8d17f6:1kcaJzdvmjL9NTYw94f5CrjOYCT0m3Uq', 'katarina.volek@gmail.com', 0, 0, 0, '2010-02-19 18:27:07', '0000-00-00 00:00:00'),
(600, 'Glazuna', 'Glazuna', '', 'dcaf03ac2ebd8b5218d0dbd76682ef1b', 'blaz.cigale@siol.net', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(601, 'Dave1972x', 'Dave1972x', '', '9f64cc89593854255a7e9ec33fd1d6f7', 'davyjonones@gmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(602, 'TIANA', 'TIANA', '', 'b5a8b0043d1a3118dbf68aaaad63758d', 'tinagacnik@siol.net', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(603, 'orange_lily', 'orange_lily', '', '23b6c59e0f61c5d6e1090525ea0056fd', 'lucija.sinkovec@gmail.com', 0, 0, 0, '2012-04-24 14:21:07', '0000-00-00 00:00:00'),
(604, 'copatek', 'copatek', '', '23af62e327d923bff696c74737fab2ff', 'maka@mail386.com', 0, 0, 0, '2013-03-24 09:28:47', '0000-00-00 00:00:00'),
(605, 'JAZ', 'JAZ', '', '2196e1b0c89b3f335ae9cb2be96cd71a', 'rmeglen@gmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(606, 'knjigica', 'knjigica', '', '6e79cd1d129ad799761b8124327de527', 'soncnizahod@hotmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(607, 'bojana', 'bojana', '', '9a1e20680837cad299e7d2e5eb716323', 'bojana.mismas@gmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(608, 'zamorcek', 'zamorcek', '', '083fbb613be4955c1e5ef38e25e4efe2', 'pikainanja@gmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(609, 'primzi', 'primzi', '', 'b9a077290acb5a4e6c815119a94fcb61', 'primoz.rus@email.si', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(610, 'AlenkaJ', 'AlenkaJ', '', '42535cc5787eeaec36a6c5ecc09353e4:br1k909IhiBLGlkdpf5AG5XJoqrh0RHK', 'alenkajersin@gmail.com', 0, 0, 0, '2011-11-15 18:09:44', '0000-00-00 00:00:00'),
(611, 'CreezY-Lukka', 'CreezY-Lukka', '', 'c03bc2a7594f4c06de1601108cc9f96b', 'luka.mavric@hotmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(612, 'aztek', 'aztek', '', 'a9e4f9af405aef91305513ef1ddbb134', 'aztekink@gmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(613, 'FiNK', 'FiNK', '', '1ac145ca804efcd127f58573563371e6', 'fink_jan@hotmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(614, 'Genius', 'Genius', '', '87704e9efce14e0a30c7450fadf2c9b2', 'sacrum000@gmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(615, 'pinki', 'pinki', '', '9cc8b06558e571b58f37980e9451408d:keQF6currBFBSIlzVMVW56H2iiT2LXMG', 'slavko.pajntar@siol.net', 0, 0, 0, '2011-09-20 14:40:07', '0000-00-00 00:00:00'),
(616, 'Tommy', 'Tommy', '', '2444539b540f7bb92751a0d7c694ff1b', 'Thomas.Breznik@ijs.si', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(617, 'widolfia', 'widolfia', '', 'c5ebe9272da66a671949750c6b763941', 'vida.znidarsic@gmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(618, 'titania', 'titania', '', '7a5dfe541017bdf74fa3d191d7f807fd', 'tancy_medo@email.si', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(619, 'Helencek', 'Helencek', '', 'fda219751c8dff80ecd1da0fd4148b07', 'helena.ilc@gmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(620, 'Jolcy', 'Jolcy', '', '638143edf69ddece4b95839207f6a0cd', 'c.jolanda@gmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(621, 'Brane', 'Brane', '', '45fd6b735a81ca318cfbf687051099ee', 'bbrodnik@hotmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(622, 'Pertuka', 'Pertuka', '', '083259dd92ffa40a1aa8ee885caff6bd', 'strekelj@hotmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(624, 'Lucky', 'Lucky', '', 'acd88073ac8fd05503ebc1b10ad9c606', 'lukc.sinko@gmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(627, 'Pomlad', 'Pomlad', '', 'fbe46ae0ca687ab0267be5cca10a248b', 'vesna.glavic@volja.net', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(628, 'teeny', 'teeny', '', '7a5dfe541017bdf74fa3d191d7f807fd', 'tanja.teeeny@gmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(629, 'DeeDee', 'DeeDee', '', '5b572b5c10f258e0660baeb168f2602d', 'lil.gummy@gmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(630, 'kuodre', 'kuodre', '', '02bd9a65abc1bf29e1c5e6c8c772f422', 'gregor7194@hotmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(631, 'sasika', 'sasika', '', 'a0e6a29a3f1ba2ba3d3ed71e5093cd9c', 'sasastrnad0@gmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(632, 'sara96', 'sara96', '', 'b5e6f9b2a964e1cad89b5bc5b07a051b', 'sara.cvijanovic@gmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(633, 'Rusk', 'Rusk', '', 'a2cd5b142fd0bbbe04bf9f18f93dde3f', 'rus710@gmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(634, 'chenlouis', 'chenlouis', '', 'c1b2309c6953968ddc8a3eb49826f597', 'webmaster@chainlou.info', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(635, 'andro', 'andro', '', '539444e459b824f5abe130b99b8cb525', 'andre_skulj@hotmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(636, 'lah', 'lah', '', '9bdbf85cbf557cbf9c8025aee4a06661', 'matjazlahster@gmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(637, 'craigmathew', 'craigmathew', '', 'd7e0836a5a1f234d5c16fadc631b4730', 'craiigmathew@gmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(638, 'pjevacica', 'pjevacica', '', '18de398bbff617dd9df483d21ffe50fd', 'padar.tadeja@yahoo.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(639, 'sennioritta', 'sennioritta', '', '04eb5df2c9b8daa664bb3ed2e45d96c8', 'sennioritta@free250host.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(640, 'TrykIvona', 'TrykIvona', '', '4118789426a9a7bc679b230212fcfd1c', 'kubaprawda3@gmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(642, 'avdicija1', 'avdicija1', '', 'd56bad03c1619e1cd0029cdd0b529203', 'avdicija@hotmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(643, 'Emmie_Bridlebc0db', 'Emmie_Bridlebc0db', '', '461301c38ec7a35c1d7b4355386ea38d', 'rudolf.napierc26da@gmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(644, 'jestbeno', 'jestbeno', '', '9ea6c90cb9163655c92dc441cbe66747', 'jest_Beno@yahoo.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(645, 'Jean_Hendric83357', 'Jean_Hendric83357', '', 'f9b210832716c9a43503a927705ebb3c', 'flora_gomersall2a2db@o2.pl', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(647, 'sarchy', 'sarchy', '', 'a1b61e5ec334f4acc2cb17f46e4e7a24', 'sarazgajnar@gmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(648, 'HarDmaN', 'HarDmaN', '', '9146138a56fdff7b039e0c4275a111e9', 'saso_pajk@hotmail.com', 0, 0, 0, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(649, 'Anja', 'AnCk', '', 'df4ffcc0debd285a4932ff091acbd4d7:vImJvKFZa9GW09OfzaDUQI5XjJgQUY3h', 'anck.blatnik@gmail.com', 0, 0, 0, '2010-03-27 19:47:25', '2010-01-25 17:38:45'),
(650, 'Janez', 'Gllmour', '', '095165b956d3ecd22e98c24004fffc2e:LNbaMLvvrFrxrUqqus6StCsiN2DuYL1V', 'jerculj@aol.com', 0, 0, 0, '2010-12-05 22:47:18', '2010-01-28 13:12:23'),
(651, 'Avtor', 'avtor', '', 'bf96b470296ce6c59e6ded225f029583:G4iTPpoSUTC8EItpOD0vPDM50DgSvIpQ', 'avtor@gmail.com', 0, 0, 0, '2010-04-22 15:19:05', '2010-02-03 00:09:02'),
(652, 'Primož Žagar', 'zagarp', '', 'c47f90b05a26b3fc60ce88fe2a5b5584:eiyFy0gWk0d5mwft3lYYGf0JjljNUMxe', 'primozagar@gmail.com', 0, 0, 0, '2013-01-07 23:07:40', '2010-02-12 21:03:43'),
(653, 'mamager', 'manager', '', 'fd524c0db003429af147b843fe85e5f3:4Ibqp2g5uQvZCI6Qu4B2cR4ZVAwjrgKZ', 'tomaz@zelnik.net', 0, 1, 0, '2010-03-27 02:58:00', '2010-02-23 19:28:29'),
(654, 'marijanca', 'marijanca', '', '56062594a1d92e607c22c93c6032e783:aoY8tbmaZvgPvOYmXR0Zs2VvcyetLgTX', 'gangova@gmail.com', 0, 0, 0, '2010-02-26 01:44:30', '2010-02-26 00:43:35'),
(655, 'nastja', '-nastja-', '', '016fb0b5b6f96086abe7feb3dd734998:MmuHfTVgqadLJjaYF5P0KiIhPDdR2YXy', 'nastja.prelesnik@gmail.com', 0, 0, 0, '2012-03-03 18:53:41', '2010-03-05 17:47:38'),
(656, 'alenka', 'alenkap', '', '1d0478d878f27d9123a1eb6913913db1:OeCqa5bF7m24ayX8Gtb5FgVAbv4S7oML', 'alenka.peterc@gmail.com', 0, 0, 0, '2010-04-11 17:43:59', '2010-03-12 16:59:35'),
(657, 'Viktor', 'viktor', '', '3f0c177bda1f9f59c79143b1c93f58a9:iXBD1A8vGjufDRXKN2Tg0QE7NxFIg50P', 'fbcgrosuplje@gmail.com', 0, 0, 0, '2010-11-14 07:04:38', '2010-03-15 13:35:22'),
(658, 'Matija Oblak', 'moblak2', '', '333176d829e35e969d2694196d3a77f7:vwJeEgKdXZFDDz2IwxWGUbRgflQrhLha', 'matija.oblak@gmail.com', 0, 0, 0, '2010-06-01 06:41:19', '2010-03-21 21:14:26'),
(659, 'Xion', 'Xion', '', 'a2c0affe7fe79ec64271ee5296577431:7gl3N168HfPWUs2MwPF3YmD0n8BOqjLf', 'x@jst.sm', 0, 0, 0, '2011-01-28 20:16:57', '2010-03-26 18:00:15'),
(660, 'ZALKA', 'zalka', '', '47b51636239049b86bb4449e74f1a619:bd9n9o7KopRqQwsoXX7QvF3bLclUFPeX', 'ZALKA.JERSIN@GMAIL.COM', 0, 0, 0, '2010-03-26 19:03:20', '2010-03-26 18:01:39'),
(661, 'Kelso', 'Kelso', '', '2847d729f466b164c1900e98d873cfa4:pQLQCE3e85CzPsKjuBIxcCFurMp625Ls', 'tadej.prijatelj@gmail.com', 0, 0, 0, '2010-03-27 18:40:32', '2010-03-27 17:39:36'),
(662, 'bigband', 'bigband', '', '61b9dbbf4b76f74eef7ad133caf12ede:fwIxRO7UpX9fJSrVnJjJgYC8w7pMZf8z', 'andraz.jazz@gmail.com', 0, 0, 0, '2010-04-09 12:26:22', '2010-04-09 10:25:35'),
(663, 'Klavdija', 'Klavdija', '', 'd84b5f1b4cf5e1c40f034d23c0afdb4f:1S9wui69Zd4qP1xLo3L6FUFXnaeXyiMr', 'klavdija.hocevar@gmail.com', 0, 0, 0, '2010-12-05 20:43:27', '2010-04-16 18:32:50'),
(664, 'Tadej', 'tedy199', '', 'f5147e06ef2d7b5d26026436f4a16507:A8sIhpOK6GmZacsUc4DXL3JmlyVZT2Xd', 'cimerman.tadej@gmail.com', 0, 0, 0, '2010-06-22 06:22:21', '2010-04-27 17:27:25'),
(665, 'Ana Porenta', 'Ana', '', '4adf84292dc716a5c05dfb58997e7990:i9CEoS1AHRPWsIZoT4pWzuCX1WflsgI7', 'ana@zru.si', 0, 0, 0, '2010-05-11 04:39:23', '2010-05-10 18:31:45'),
(666, 'Janez Kranjski', 'janezek', '', 'fe2ea3b4fd9ed95ab8a031d2f2e3ec6c:BYQYOtCE6emqiM0FZPYRVhMMKRcYoD6k', 'janez@mojaposta.si', 0, 0, 0, '2010-09-12 13:12:55', '2010-05-13 09:48:14'),
(667, 'žiga', 'žiga', '', '0b8a31a382b3705b12a93844c99dd69e:71n5rl9ckIOT1qIvjb7X5V6JUSWyCgaR', 'drnovsek.ziga@gmail.com', 0, 0, 0, '2011-07-30 13:17:17', '2010-06-08 18:28:44'),
(668, 'Blaž', 'blapo', '', 'f09ab29a532af55e17aaa1f22f00c9fe:Z18WcULsdZGHUp6tu5rgcWJY9Mx9aLSr', 'blapo50@hotmail.com', 0, 0, 0, '2012-09-18 15:01:40', '2010-06-21 18:54:00'),
(669, 'SARA', 'SAJAMNIK', '', '376edec8b6b2aea021506fcd100cd108:wgyHmMKQy42W46HZjT4hzA5ytrxhJFoB', 'sajamnik@gmail.com', 0, 0, 0, '2010-07-06 19:34:26', '2010-07-06 17:32:21'),
(670, 'Mateja', 'sonce', '', '18062af484a52d63d13f4dd9006f9696:0f8jNbwWxtkYGA6kEtrJsjjdVhosKWjM', 'struge@gmail.com', 0, 0, 0, '2010-10-07 18:47:18', '2010-07-16 19:05:37'),
(671, 'Alen Kastelic', 'alen', '', '5ab054da85eee236c9a0c39b713fbe7b:I8kpg8Sq2bMT0lxUWCHGo8EwIQ3fUuAM', 'alen.kastelic@gmail.com', 0, 0, 0, '2010-07-21 11:49:47', '2010-07-20 05:12:05'),
(672, 'Ana', 'anagodec', '', 'f239987138924e53a9aedb873fa0d7f9:A5GzLLAXumw1Q27YngY0TC5cKxrfKbaF', 'anagodec@yahoo.com', 0, 0, 0, '2010-08-14 10:10:39', '2010-08-14 07:01:13'),
(673, 'judita', 'juditao', '', 'f0e2d617eb76bf13ab11d81413efe38a:4sVM3yRlvMlsNfoeVCQNpsSGuUcLQoR4', 'judita.oblak@iskra-tela.si', 0, 0, 0, '2011-02-10 08:05:41', '2010-09-07 16:39:28'),
(674, 'Andrej', 'arhit', '', '1ba96655de6099622a06bbd854cb9132:92dNjY1Kqj8HwKihjFMxFu9DQMzzRdMZ', 'jazzlifesi@yahoo.com', 0, 0, 0, '2010-09-15 07:58:07', '2010-09-15 05:54:43'),
(675, 'Marija Žnidaršič', 'micika', '', '299342cdc09d69bde549dfdb9aa4969c:gzHiqjo2j5k5Gv5OCBJYDVUV8jzglE4w', 'micika61@gmail.com', 0, 0, 0, '0000-00-00 00:00:00', '2010-09-19 13:17:57'),
(676, 'Polona', 'dolenka', '', 'b62eece3f717bd4a3e7926cfe0afb9be:IF9SswBxFtgrYDn1wptplLGyjfyxUYOa', 'dolenka87@gmail.com', 0, 0, 0, '2010-09-21 15:41:04', '2010-09-21 13:25:02'),
(677, 'Primož', 'Primzi1', '', '787bd6ce8321a8e5c083938313ed7e10:eoWAZVR2QUAh86C7CKW1hn8iLxGKt5N4', 'veselic.primoz@siol.net', 0, 0, 0, '2010-09-29 06:10:50', '2010-09-29 04:02:35'),
(678, 'jože', 'xxx', '', '64745656f514d411cc62fa5e15d5a343:YLIEeVYhLLtduOwvRaIuOebQjnss8itA', 'sampro@siol.net', 0, 0, 0, '2010-09-29 18:27:46', '2010-09-29 14:29:58'),
(679, 'Lola', 'Lola', '', '59ab82e673311350320211dcaff59fb0:AKEIYXD7zyMTCY8vqkm9gprnDYm3W2tM', 'lola.bergant@gmail.com', 0, 0, 0, '2010-10-09 18:14:27', '2010-10-07 14:22:17'),
(680, 'KORK Dobrepolje', 'korkdobrepolje', '', '12a062f2d378b94b5d569aeb7b77819a:EbjUL0RQKPbXSXMwUAaydRbva9SHrZz0', 'marija.tegel@gmail.com', 0, 0, 0, '2012-09-12 07:55:34', '2010-10-12 09:19:51'),
(681, 'boštjan', 'b.p', '', '561aa8d01f6e85bc7c39b88b552797a3:0MFHiLQChKcamLGlZSveG9WGYsIwfOym', 'bostjan5@hotmail.com', 0, 0, 0, '2010-10-17 11:55:31', '2010-10-17 09:52:47'),
(682, 'Karmen', 'Karmi', '', '0442f4b93178fde6b732ed30dafdd03b:rpHBHBHxbX46dYrAUFtV1XDOt3X5LLtd', 'karmen.razbornik@gmail.com', 0, 0, 0, '2010-12-24 20:52:42', '2010-10-31 22:20:34'),
(683, 'Bar Majolka', 'BarMajolka', '', '4e396d58ff3ecdfc66dd0d3d84dcfdae:VIzeI6xbXiA3C3CNsTIPcYkbxb5RQMkv', 'majolka2010@gmail.com', 0, 0, 0, '2012-06-08 10:06:01', '2010-11-03 10:23:16'),
(684, 'Miha Tekavec', 'mihct', '', 'c95f1a32980239f0b0f3521610dbe7e7:OagevijmpIIlX2TwOPkgR7UK8SwS3qol', 'miha.tekavec@gmail.com', 0, 0, 0, '2011-01-19 16:58:02', '2010-11-09 18:16:00'),
(685, 'Tomaž', 'Tomo V8', '', '1b0d8a6f0590186f21eca2fe1d051156:Rznl3WXOTQiuM0k7ylaOBGIJo1Hm9AiL', 'tomaz.indihar@gmail.com', 0, 0, 0, '2010-11-18 11:19:46', '2010-11-16 14:10:23'),
(686, 'ZKD Grosuplje', 'ZKD Grosuplje', '', 'bb84c1c1d205c88bb32081c880432836:BBlsAn2uhjUj5e85OhrQqjgp2sD2u5Ck', 'grosuplje@kultura.si', 0, 0, 0, '2012-01-27 10:31:13', '2010-11-23 08:36:09'),
(687, 'Tadej Bavdek', 'badzovsky', '', '7083485cf59fb39970db86707c095c30:cOABIbN6PoKtjcqXd3eK9T9kYnz4c8zP', 'tadej.bavdek@gmail.com', 0, 0, 0, '2012-03-03 18:53:05', '2010-11-30 16:04:43'),
(688, 'Nada', 'gruska', '', '84fa86671ba021bbb43f2a4cd1bfe9f6:9HWKGYJz7MutQm91KE2Ok8FI7hb6n0kS', 'nada.gruskovnjak@gmail.com', 0, 0, 0, '0000-00-00 00:00:00', '2010-12-03 19:23:22'),
(689, 'igor ahačevčič', 'jerkin', '', '81f1df725f3be1a37e7b72ad2909954e:QPUiBIVyZVKm9XqcZDpFyP5QGipieF3I', 'ahacevcic@volja.net', 0, 0, 0, '0000-00-00 00:00:00', '2010-12-09 17:17:40'),
(690, 'Erika', 'eerika', '', '30659356300492e7d27ded2063b13299:FraD6C1MMHw6h4opzsO8xl8vfghZzQQq', 'erika.erculj@gmail.com', 0, 0, 0, '2010-12-11 18:15:23', '2010-12-11 17:13:33'),
(691, 'anja babnik', 'anja', '', '962ab0c4a3511afe3e5fa0cd4581bf85:fvJNsVhFV4DMPIPKKhQO5UNaW4P0G6wP', 'anja-babnik@hotmail.com', 0, 0, 0, '0000-00-00 00:00:00', '2010-12-16 14:18:24'),
(692, 'ana šuštar', 'šušti', '', '7373f4395b52e08404da4c7d66ab2276:DfBBJPw6xM9VTw47wC5TjQ0SnnfeLz7o', 'ana.susti@gmail.com', 0, 0, 0, '2010-12-16 19:21:02', '2010-12-16 14:25:34'),
(693, 'Luka', 'Luka', '', '76b2142d750bab27c8fc1616df7cb543:E05z0hJxK5kbxECQJJxtXRhfCJQHDU4n', 'l.brodnik@hotmail.com', 0, 0, 0, '2010-12-20 20:40:02', '2010-12-20 19:37:26'),
(694, 'jože samec', 'samec', '', '34d99ce1d958fbbcad03dded884b9c00:2bpLHbNlSOiHg4g5ATYQfCGsHspUbzhj', 'samec.joze@gmail.com', 0, 0, 0, '2010-12-25 08:27:16', '2010-12-25 07:23:36'),
(695, 'simona', 'Simona', '', '2c2f30fc90e3887913dcad494e131726:hXDHzC7fkYBq8gGuvmBiBIIKdskPViYx', 'si.monnca@gmail.com', 0, 0, 0, '2011-02-17 20:57:48', '2011-01-03 17:00:45'),
(696, 'Zavod Parnas', 'parnas', '', '20542ccc84d61007b7154541980f19bc:C5sSUw7bYLoJJCpqaCq41Jyp3oYMcWu1', 'info@zavod-parnas.org', 0, 0, 0, '2012-03-03 18:54:54', '2011-01-12 07:08:56'),
(697, 'Matjaž Šuštaršič', 'Union4ever', '', '2ffb491beca139467828b7d2f65bac07:hFKW9ezUKNSdjr1bP0zPNdhAy58j5oGa', 'matjaz.sustarsic@gmail.com', 0, 0, 0, '2011-08-29 19:37:55', '2011-01-19 21:07:27'),
(698, 'Kud Iška vas', 'KUD Iška vas', '', '4e0d307d9a8bf5fc1f0d93c715b50c23:Dmwhs9vbougPmLaIrNLoXdo27CIaJUg5', 'kud.iska.vas@gmail.com', 0, 0, 0, '2011-01-21 16:02:37', '2011-01-21 15:00:09'),
(699, 'Rok', 'dingica', '', '1ed2e611a0412c9a733c0f694a3f4654:wbnZ9h6pCW9oKgAzpWJUIUCKOFIUlHld', 'dingica@gmail.com', 0, 0, 0, '2011-01-25 11:02:46', '2011-01-25 09:58:38'),
(700, 'sanja', 'sanja.k', '', '41ffe661e90973fad7b5446f39049ce5:OGbALWufVUInua2vAUkt8fOt9HeGGNIH', 'sanja.xs@gmail.com', 0, 0, 0, '2011-03-08 15:38:47', '2011-01-30 20:00:03'),
(701, 'Matija', 'Matija', '', 'd82ab2a18b727c045b4e4fd81ab0c9ee:sreeWykc4AqLYMmPZefWNWkxOidE9RE2', 'matija_klinc@hotmail.com', 0, 0, 0, '0000-00-00 00:00:00', '2011-02-03 15:01:57'),
(702, 'ursa', 'zursa', '', '2e1ab38666247fe307cd1a8af21776a6:jfZ4qbBHYAeW4IZL5TgQAF0oTQTJvm7k', 'u.zalar@gmail.com', 0, 0, 0, '2011-04-17 18:22:57', '2011-02-09 16:06:53'),
(703, 'Nejc Ilc', 'nejci', '', 'eac3b539ea5d2ca6fe8ce42e27b3271b:yDyEwR8htPgE1tamfIIrkqDSrojJAbUh', 'nejc.ilc@gmail.com', 0, 0, 0, '2011-03-07 20:45:55', '2011-02-26 13:13:08'),
(704, 'simona', 'simona93', '', '320e8099a6c6b883676edbac4bb6e2b2:JF8Hm1fjQLVQ8NYIQGAf7oQOvK2trnMN', 'simonapajk@windowslive.com', 0, 0, 0, '2011-03-20 18:52:40', '2011-03-15 20:19:13'),
(705, 'Ivo Frbežar', 'IvoFrbezar', '', '39eff16dfcd9f35d0b3ae16767c02144:BjA120JwnSvzaCrHyhlrvFjPGPWrAZtt', 'ivo.frbezar@gmail.com', 0, 0, 0, '0000-00-00 00:00:00', '2011-03-18 16:27:54'),
(706, 'Dani', 'Dani', '', 'f3b47e2d8348176c6afaeaff04bd516b:hzWRVmky8pG2WdnoOcNPJpotpOSoz8MJ', 'dani.kaljevic@gmail.com', 0, 0, 0, '2011-08-11 09:22:16', '2011-04-14 21:00:51'),
(707, 'Keli', 'keli', '', 'e9ff49d5d9f3badfadb008edc7cb65c7:bbtHZYNjXcppaa2Z9zF54CRQ7ANX6P5y', 'keli.jerman@gmail.com', 0, 0, 0, '2011-06-01 18:48:45', '2011-06-01 16:46:41'),
(708, 'Polonca', 'Rožica', '', 'b0c9b5e655ce3d780d3a8b5d56d6712b:7RVX5Yrf3C0FDbWhVQX9M3DoNxNu9DC8', 'dolencispolona@gmail.com', 0, 0, 0, '2011-09-06 13:28:42', '2011-07-04 08:14:08'),
(709, 'Rafael Samec', 'Rafael Samec', '', 'c533bab218af398d5d693fa063de5527:cRQjPNur1lwpiyY3DTkyhvopfCA9KjXk', 'rafael@samec.si', 0, 0, 0, '2011-09-16 20:43:25', '2011-09-16 17:58:40'),
(710, 'angelcai', 'angelcai', '', 'e33556fc6726d8f145f4db0370abba68:vV7MR6WgJhdQq59OXcbfsKwz1bNS1SiC', 'chenqinglin05@gmail.com', 0, 0, 0, '2011-10-25 08:07:32', '2011-10-25 06:06:43'),
(711, 'pregmelmMoge', 'pregmelmMoge', '', 'ec4793a60b3a02ba9e36f85a9e6b4d08:lGqLlM8l6hrSPF6iprawnKcIPg62UhmJ', 'mariewinter1@aol.com', 0, 0, 0, '2011-10-30 13:05:16', '2011-10-30 12:04:43'),
(712, 'NabsbricsAl', 'NabsbricsAl', '', '4ff9021e491a75ee71cc802618647f99:8AoADZ1vpNqnzOHlDi4apdzYWjsxzuMu', 'd.yncl.y.day@gmail.com', 0, 0, 0, '2012-01-27 02:55:06', '2012-01-27 01:52:52'),
(713, 'Sperrysycle', 'Sperrysycle', '', '903908c77dd56025af2085d757cac6b1:MPB0yUW3G01hFxeshM8G5wzD9pmcrLZn', 'v.e.ronikalikes@gmail.com', 0, 0, 0, '2012-02-22 20:03:27', '2012-02-04 02:50:46'),
(714, 'FooraNatesoda', 'FooraNatesoda', '', '9eb044f9108230b29da83eea5754ccbd:CUzNlGmUDPmqtax6NvJ4IaRa7eUYHNAR', 'uvarovanelli@gmail.com', 0, 0, 0, '2012-02-22 20:13:07', '2012-02-21 21:24:37'),
(715, 'eales', 'eales', '', '76b7b70bfda14469998d3c956acdc6c5:WH0FVcSCQsN46PUgyLlsqub05sQNTe4G', 'j.ales@siol.net', 0, 0, 0, '2012-03-03 19:00:53', '2012-03-03 17:53:21'),
(716, 'Maša Mazi', 'mmasa', '', '7f5a8f8b30d23e28fad3cf8a3f159a6c:YjLEJuIrUyziagBB0y8pEGOW3hDvRx9r', 'mis.mas@gmail.com', 0, 0, 0, '2012-03-03 18:57:46', '2012-03-03 17:53:58'),
(717, 'Marjanca', 'Mari', '', 'c6bf81028d2b78554e46bc8a8cfdedc9:7gYUPeK4WC9uSoCMDTMyCk6kne2sDoL5', 'marjanca.rigler@gmail.com', 0, 0, 0, '2012-11-04 20:55:37', '2012-03-03 17:55:21'),
(718, 'Branka', 'brankaznidarsic', '', '016b06eb909b7c2f42be9aac44f5c26d:wwJYmwMi8vz5pOxxQpoamJvpAnHncnMi', 'brankaznidarsic@gmail.com', 0, 0, 0, '2012-04-14 16:58:05', '2012-03-03 17:55:27'),
(719, 'Nina', 'nain', '', '22781946b2d430e7416dd347909e713f:DOBdubaWRbXZhGJbQZ80yqwtsNZhyPiq', 'nina_h27@hotmail.com', 0, 0, 0, '2012-03-03 19:02:04', '2012-03-03 17:55:27'),
(720, 'vlado', 'vlado', '', 'deb50cd06b71c61f7fbab6e6c1ca8c11:YhMDYBn9LKRzfSY850sLI1KlF4dGJtWc', 'vladimir.pecek@volja.net', 0, 0, 0, '0000-00-00 00:00:00', '2012-03-03 18:04:08'),
(721, 'Hersedged', 'Hersedged', '', 'cbb327e42bd4a3cb796cba49a210ce23:wrkQWFTDnuZ3LR5F5YasDs8b98f5Y184', 'best_wish@aol.com', 0, 0, 0, '2012-03-25 15:16:22', '2012-03-23 19:35:17'),
(722, 'Ideatzessoort', 'Ideatzessoort', '', '24b7c2981aec5f8fe28688a774af0f0c:oXWnV2WCzDJJ9sOqQGqc6ExkE6eu7gVj', 've.ro.nik.a.lik.es@gmail.com', 0, 0, 0, '2012-03-25 08:00:24', '2012-03-25 05:59:07'),
(723, 'judita', 'judita', '', '2b20ca57572b3e619dd33ae9dcdb5352:uSZi2s3WetTPkYgAKNrlgk63cP6YuIbR', 'judita.judy06@gmail.com', 0, 0, 0, '2013-05-17 08:16:39', '2012-03-25 17:12:43'),
(724, 'wewsCizip', 'wewsCizip', '', '14c56e0131283b0952cf8a6ce0ed145a:uovHsK7pWtjlezfJJneiz5MSOstBIG3p', 'vesrosniktatlkikn.es@gmail.com', 0, 0, 0, '2012-04-06 19:02:24', '2012-04-06 15:43:17'),
(725, 'Tjaša', 'Tjaša', '', 'af4b039195369486529186fe1aff12d5:gBTBuuT1dQPGV5EQdVRDGm7ad1F8WyrK', 'cetvrtideveti@hotmail.com', 0, 0, 0, '2012-04-09 12:54:45', '2012-04-09 10:54:15'),
(726, 'Salina', 'Salina', '', 'dca0ed7c38c70ecbbe78d0a21125854a:BYHmEHo4ax47wpzavH16npvJP6S2pF2p', 'ninovahleg@hotmail.com', 0, 0, 0, '2012-04-11 13:26:12', '2012-04-11 11:19:23'),
(727, 'simona', 'rihter', '', 'c510383d8e8805b5e0a176ab7f439e36:kfAoGjHzmOYWDFnjorZGLIInA3l7IcO7', 'simonar2001@gmail.com', 0, 0, 0, '2012-04-20 21:02:04', '2012-04-20 18:55:36'),
(728, 'magdi', 'magdi', '', 'b202cd5d29408f65a53b8fcee0f75536:AJhknyImv5m8DAenQ2JblZGw7ZU2CV5y', 'magdi.stritar@gmail.com', 0, 0, 0, '2012-06-01 10:53:55', '2012-06-01 08:50:22'),
(729, 'Jakob', 'jakob97', '', '1120ee605f9d3e5ae8e68907f6756b53:rlcd5ssv0YGs4qYM3kvU0cOpqvvOLpPp', 'zevnik.jakob@gmail.com', 0, 0, 0, '0000-00-00 00:00:00', '2012-06-02 07:07:16'),
(730, 'Barbara Novak Koritnik', 'Wahoo', '', '57928cc5d8a36456dae0cde85e0f958e:57eEsvI0J1sZMpYkogTgmveazjbWR3xo', 'barbara@tali.si', 0, 0, 0, '2012-10-08 18:45:35', '2012-07-22 12:23:52'),
(732, 'Robert', 'mRobert200 kranjski skavt', '', '00ee658e14a181ca2bdcfc41c9ff043c:7pE6JjTyfPc1h9OYE0rKBfP7QrsUNEBp', 'mrobert200@gmail.com', 0, 0, 0, '0000-00-00 00:00:00', '2012-08-31 13:26:22'),
(733, 'jernej', 'jerry123', '', '399679de7040c1affdf38ac853c08c06:ZndpwmtljWUOXTzLspMfCC8KdCr2linJ', 'jernej.oblak@hotmail.com', 0, 0, 0, '2012-08-31 17:41:58', '2012-08-31 15:39:08'),
(737, 'brane drnovšek', 'aba11', '', '6468bbb045e8037084b8458438bf2227:kyyqFidfPnC0vuFAJzmZXITaju8J3hUs', 'brane.drnovsek@siol.net', 0, 0, 0, '0000-00-00 00:00:00', '2012-11-02 09:44:59'),
(738, 'bazumhtyd', 'bazumhtyd', '', '9f2faddd4b9e74cf27f9f43c20ec4ef7:QKD0mKWmOc0NiFBt9Yfp2ANDwzhcCzJB', 'bazum@ukhost-uk.co.uk', 0, 0, 0, '2012-11-16 04:43:17', '2012-11-13 21:09:07'),
(759, 'prembatesyq', 'prembatesyq', '', '681db5b027739e3e94950b250cba2ce3:8rVPff94uoC58jBkW6xTdvNYVuuGvgSZ', 'prem@paydayfreak.co.uk', 0, 0, 0, '2013-03-19 16:05:35', '2013-03-14 01:47:28'),
(766, 'Luka', 'alpatino', '', '1d7fad56d1eed1a7dc83c8c9cb2c822a:lQuuyLZMO2dD0GVBtq8aODqhVXfEfo84', 'skulj.luka@gmail.com', 0, 0, 0, '0000-00-00 00:00:00', '2013-05-17 14:42:59'),
(773, 'Gavin', 'gavin', '', '1efb71321835b78ae2f23f136955925a:AIi22n7v9DPE7tpeATIiMmmILyC5OkZD', 'gavinsmith039@gmail.com', 0, 0, 0, '2013-07-05 16:24:20', '2013-07-05 14:23:24'),
(774, 'Groš', 'gros', '', '9ec9b712ff1da10aebd6acd6e8c89c62:VeLrXrSKGG3yOg7eNBR0WVI7BZHRkKwr', 'ambroz.volek@zelnik.net', 0, 0, 0, '2013-07-10 20:30:22', '2013-07-10 15:46:26'),
(777, 'Rado Lavrih', 'lavrihr', '', '02e45cf4bd8a2206b6e8da3e3c5796dc:NCFuEK9RS4RWWg9TG0Ca6bpAdb6CkzJu', 'rado.lavrih@siol.net', 0, 0, 0, '0000-00-00 00:00:00', '2013-08-10 17:38:55'),
(778, 'Testni uporabnik', 'uporabnik', '', '51ab1b3500984dd2362ee924c907d8e7:DDLJEkcuAz6VOrwJw3PvQwovTbDJxgGk', 'bizgec@gmail.com', 0, 0, 0, '2013-08-31 01:27:43', '2013-08-30 23:25:21'),
(779, 'Stane Hafnar', 'Staneh', '', 'cbe6c16b2d372c1071e050622e5d81e5:VVk7hHCM31tetQh2dVuwyxrf7B6FYZAA', 'stane@hafnar.si', 0, 0, 0, '2013-09-11 09:12:15', '2013-09-11 07:10:45'),
(780, 'ZAVOD NEFIKS', 'nefiks', '', 'c357e4f0378ecdbef67a6d42ae3998ae:ryREHhPXhyTdTpdtQThGPYWjwSdsItyc', 'nefiks@nefiks.si', 0, 0, 0, '2013-09-13 08:41:26', '2013-09-13 06:38:06'),
(781, 'Jana', 'Jana', '', '8338b28d2452511f40d1a581b9257257:P1jeDP19CuXTCPtpmEb5wU2rfqiQYZsR', 'janasustar@gmail.com', 0, 0, 0, '2013-09-17 11:26:19', '2013-09-17 09:25:42'),
(782, 'Videospotnice', 'videospotnice', '', '0cb56619a4aba03bdbb3d6e9da1abf4f:cOQ6FGv19SnxhgCmsojLyt0OTFri7vIr', 'videospotnice@gmail.com', 0, 0, 0, '0000-00-00 00:00:00', '2013-10-15 09:52:41'),
(784, 'ŠD Dobrepolje', 'sd-dobrepolje', '', '91989bd7f9345038478947775166b744:BlYk8Tc2Leln2A3AyXts24TippCRA9BK', 'miha.kuplenk@gmail.com', 0, 0, 0, '0000-00-00 00:00:00', '2013-12-07 21:23:24'),
(785, 'dydradyamogma', 'dydradyamogma', '', '40f7ae4abf0353d56802f0156d15e079:hvwMopVxWDx4eYCqf7x8FizdZ3FQiirA', 'merwire2013@hotmail.com', 0, 0, 0, '2013-12-25 11:54:42', '2013-12-25 10:42:02'),
(786, 'nekiua', 'mainaadmin', '', '71d0384d05efada7769c4e0642d92d1f:V99l1fEmtmEqF2AszkKDR33uYNJ0EYFO', 'ivan.kachelya@yandex.ru', 0, 0, 0, '0000-00-00 00:00:00', '2013-12-27 15:39:26'),
(787, 'GuestUser', 'guest100', '', '76d914be25d83a2f1a1ee14eda0d26fa:d2iQHAAsJPAxxZWW7h0sZl5LNzJGnT0r', 'mrwalkerzoio1000@gmail.com', 0, 0, 0, '0000-00-00 00:00:00', '2014-01-10 12:04:06'),
(788, 'zaokrozi', 'zaokrozi', '', '6f7932a78d9b5bca457f1275318c5483:FT6oSFiz5AXL1jqSMQ8huXCTtu2DVNAh', 'info@zaokrozi.si', 0, 0, 0, '0000-00-00 00:00:00', '2014-01-15 20:12:56'),
(789, 'nekiua', 'chernihoff', '', 'f2fa8b6915f2361c06c005d4bb025f00:bS1JKkmPMHu7gB2oA5I2iwHWRKpvmt0g', 'chernihoff.valera@yandex.ru', 0, 0, 0, '0000-00-00 00:00:00', '2014-01-17 00:20:43'),
(793, 'Tilen Poje', 'Apolon', '', 'b299d8df00332b8d5de5870a46c5da23', 'poje.tilen@gmail.com', 0, 0, 0, '0000-00-00 00:00:00', '2014-03-23 12:25:18'),
(794, 'Ziga Kastelic', 'def', 'b5870f2d0aeff7645e3e4c9274ceeccb', 'b0d6686668e4921e12020c5b12f6a8fb', 'def966@gmail.com', 1, 0, 0, '0000-00-00 00:00:00', '2014-06-01 15:08:23'),
(799, 'Francka Tratnik', 'francka', '0456e96dc24f7f8e0d523efe431d72a3', '704aec85f74382c2b8148c4c78bf660e', 'helpdesk.ziga.kastelic@gmail.com', 1, 0, 0, '0000-00-00 00:00:00', '2014-06-04 02:00:33'),
(800, 'dfhdfh', 'dfhdfh', 'c5c50f34b44dde421ea62cb0523ce18a', 'a2f7a57d35ff48fc7d095821f53d140f', 'dfhdfhdfh@gmail.com', 1, 0, 0, '0000-00-00 00:00:00', '2014-06-12 14:02:18');

-- --------------------------------------------------------

--
-- Struktura tabele `vs_users_level`
--

CREATE TABLE IF NOT EXISTS `vs_users_level` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  `level` tinyint(4) NOT NULL DEFAULT '2',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Odloži podatke za tabelo `vs_users_level`
--

INSERT INTO `vs_users_level` (`id`, `user_id`, `media_id`, `level`, `created`) VALUES
(1, 499, 16, 8, '0000-00-00 00:00:00'),
(2, 509, 16, 8, '0000-00-00 00:00:00'),
(3, 512, 16, 5, '0000-00-00 00:00:00'),
(4, 531, 16, 5, '0000-00-00 00:00:00'),
(5, 580, 16, 4, '0000-00-00 00:00:00'),
(6, 652, 16, 5, '0000-00-00 00:00:00'),
(7, 653, 16, 6, '0000-00-00 00:00:00'),
(8, 687, 16, 5, '0000-00-00 00:00:00'),
(9, 723, 16, 5, '0000-00-00 00:00:00'),
(10, 766, 16, 6, '0000-00-00 00:00:00'),
(11, 499, 1, 8, '0000-00-00 00:00:00'),
(12, 509, 1, 8, '0000-00-00 00:00:00'),
(13, 512, 1, 5, '0000-00-00 00:00:00'),
(14, 531, 1, 5, '0000-00-00 00:00:00'),
(15, 580, 1, 4, '0000-00-00 00:00:00'),
(16, 652, 1, 5, '0000-00-00 00:00:00'),
(17, 653, 1, 6, '0000-00-00 00:00:00'),
(18, 687, 1, 5, '0000-00-00 00:00:00'),
(19, 723, 1, 5, '0000-00-00 00:00:00'),
(20, 766, 1, 6, '0000-00-00 00:00:00'),
(21, 793, 1, 6, '2014-07-11 16:00:31');

--
-- Omejitve tabel za povzetek stanja
--

--
-- Omejitve za tabelo `vs_token`
--
ALTER TABLE `vs_token`
  ADD CONSTRAINT `vs_token_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `vs_users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
