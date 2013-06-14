
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `kibtis_djshaun`
--

-- --------------------------------------------------------

--
-- Table structure for table `configuration`
--

CREATE TABLE IF NOT EXISTS `configuration` (
  `config_key` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `config_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `date_modified` datetime NOT NULL,
  `config_group_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `config_key` (`config_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `configuration`
--

INSERT INTO `configuration` (`config_key`, `config_value`, `title`, `description`, `date_modified`, `config_group_id`) VALUES
('_TAKEDOWN', 'FALSE', 'Under Construction', 'Take the site offline', '2012-05-17 17:39:29', 0),
('TEMP_CUSTOM', 'temp.php', 'Custom Offline Page', 'Display''s a maintenance page if TEMP is set to TRUE.  You can define a custom one otherwise uses framework default.', '2012-06-14 14:28:00', 0),
('TEMP_MESSAGE', 'Site is under construction right now.', 'Offline Message', 'The message you want to display if the site is in maintenance mode.', '2012-06-14 14:32:00', 0),
('CLIENT_NAME', 'Widget Company', 'Client / Company Name', 'Display on site of client''s name.', '2012-06-14 14:30:00', 1),
('CLIENT_ADDRESS', '', 'Client''s Address', '', '2012-06-14 14:35:00', 1),
('CLIENT_CITY', '', 'City of client''s address to be displayed on site.', '', '2012-06-14 14:30:00', 1),
('CLIENT_STATE', '', 'Client''s State to be displayed on the site.', '', '2012-06-14 14:34:00', 1),
('CLIENT_ZIP', '', 'Client''s Zip to be displayed on the site.', '', '2012-06-14 14:33:00', 1),
('CLIENT_EMAIL', 'customer@domain.com', 'Client''s email to be displayed on the site.', '', '2012-06-14 14:34:00', 1),
('CLIENT_PHONE', '(555) 555-5555', 'Client''s phone number to be displayed on the site.', '', '2012-06-14 14:31:00', 1),
('COMMENTS_NOTIFY', '', 'Email address to be notified of new comments.', 'If left blank you won''t recieve notifications of new comments.  You can check them via your admin.', '2012-06-14 14:33:00', 1),
('SITE_NAME', 'Widget Company', '', '', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE IF NOT EXISTS `content` (
  `id_content` int(4) NOT NULL AUTO_INCREMENT,
  `page` varchar(140) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `robots` enum('index follow all','noindex nofollow noarchive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'index follow all',
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `keywords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `html` text COLLATE utf8_unicode_ci,
  `header` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `h1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `body` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `footer` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `includes` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `css` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Pipe delimited',
  `js` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Pipe delimited',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `date_created` datetime NOT NULL,
  `date_edited` datetime NOT NULL,
  PRIMARY KEY (`id_content`),
  UNIQUE KEY `page` (`page`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id_content`, `page`, `title`, `robots`, `description`, `keywords`, `html`, `header`, `h1`, `body`, `footer`, `includes`, `css`, `js`, `active`, `date_created`, `date_edited`) VALUES
(1, '/', 'Home', 'index follow all', '', '', 'Welcome to our widget site!', '', '', 'home.php', '', '', '', '', 1, '2012-09-01 14:00:00', '2012-09-03 07:00:00'),
(2, 'about-us/', 'About Widget Company', 'index follow all', '', '', 'We are a great company!', NULL, 'About Widgets', NULL, NULL, NULL, NULL, NULL, 1, '2012-09-01 09:12:00', '2013-06-10 22:57:18'),


-- --------------------------------------------------------

--
-- Table structure for table `error`
--

CREATE TABLE IF NOT EXISTS `error` (
  `id_content` int(4) NOT NULL AUTO_INCREMENT,
  `page` varchar(140) COLLATE utf8_unicode_ci NOT NULL,
  `error_code` int(3) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `robots` enum('index follow all','noindex nofollow noarchive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'noindex nofollow noarchive',
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `keywords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `html` text COLLATE utf8_unicode_ci,
  `header` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `h1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `body` varchar(50) COLLATE utf8_unicode_ci DEFAULT 'error.php',
  `footer` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `includes` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `css` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Pipe delimited',
  `js` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Pipe delimited',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_content`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `error`
--

INSERT INTO `error` (`id_content`, `page`, `error_code`, `title`, `robots`, `description`, `keywords`, `html`, `header`, `h1`, `body`, `footer`, `includes`, `css`, `js`, `active`) VALUES
(1, '401/', 401, 'Username / Password wrong or you don''t belong in here.', 'noindex nofollow noarchive', NULL, NULL, 'Username / Password wrong or you don\\''t belong in here.', NULL, '', 'error.php', NULL, NULL, NULL, NULL, 0),
(2, '403/', 403, 'The server has refused to fulfill your request.', 'noindex nofollow noarchive', NULL, NULL, 'The server has refused to fulfill your request.', NULL, '', 'error.php', NULL, NULL, NULL, NULL, 0),
(3, '404/', 404, 'The document/file requested was not found on this server.', 'noindex nofollow noarchive', NULL, NULL, 'The document/file requested was not found on this server.', NULL, '', 'error.php', NULL, NULL, NULL, NULL, 0),
(4, '405/', 405, 'The method specified in the Request-Line is not allowed for the specified resource.', 'noindex nofollow noarchive', NULL, NULL, 'The method specified in the Request-Line is not allowed for the specified resource.', NULL, '', 'error.php', NULL, NULL, NULL, NULL, 0),
(5, '408/', 408, 'Your browser failed to send a request in the time allowed by the server.', 'noindex nofollow noarchive', NULL, NULL, 'Your browser failed to send a request in the time allowed by the server.', NULL, '', 'error.php', NULL, NULL, NULL, NULL, 0),
(6, '500/', 500, 'The request was unsuccessful due to an unexpected condition encountered by the server.', 'noindex nofollow noarchive', NULL, NULL, 'The request was unsuccessful due to an unexpected condition encountered by the server.', NULL, '', 'error.php', NULL, NULL, NULL, NULL, 0),
(7, '502/', 502, 'The server received an invalid response from the upstream server while trying to fulfill the request.', 'noindex nofollow noarchive', NULL, NULL, 'The server received an invalid response from the upstream server while trying to fulfill the request.', NULL, '', 'error.php', NULL, NULL, NULL, NULL, 0),
(8, '504/', 504, 'The upstream server failed to send a request in the time allowed by the server.', 'noindex nofollow noarchive', NULL, NULL, 'The upstream server failed to send a request in the time allowed by the server.', NULL, '', 'error.php', NULL, NULL, NULL, NULL, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
