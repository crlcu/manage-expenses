-- phpMyAdmin SQL Dump
-- version 3.4.11.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 12, 2012 at 10:11 AM
-- Server version: 5.5.27
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `empori31_expenses`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `team_id` bigint(20) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL DEFAULT '',
  `parent_id` bigint(20) DEFAULT NULL,
  `order` float NOT NULL DEFAULT '0',
  `lastupdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `login_tokens`
--

CREATE TABLE IF NOT EXISTS `login_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `token` varchar(32) NOT NULL DEFAULT '',
  `duration` varchar(32) NOT NULL DEFAULT '',
  `used` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `expires` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE IF NOT EXISTS `payments` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `team_id` bigint(20) DEFAULT NULL,
  `category_id` bigint(20) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `value` float NOT NULL DEFAULT '0',
  `date` date NOT NULL DEFAULT '0000-00-00',
  `lastupdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `receivables`
--

CREATE TABLE IF NOT EXISTS `receivables` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `team_id` bigint(20) DEFAULT NULL,
  `category_id` bigint(20) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `value` float NOT NULL DEFAULT '0',
  `date` date NOT NULL DEFAULT '0000-00-00',
  `lastupdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE IF NOT EXISTS `routes` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `url` varchar(255) NOT NULL DEFAULT '',
  `plugin` varchar(255) NOT NULL DEFAULT '',
  `controller` varchar(255) NOT NULL DEFAULT '',
  `action` varchar(255) NOT NULL DEFAULT '',
  `lastupdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=63 ;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`id`, `user_id`, `url`, `plugin`, `controller`, `action`, `lastupdate`) VALUES
(1, 1, 'admin/routes', 'routes', 'routes', 'index', '2012-11-06 07:10:29'),
(2, 1, 'admin/routes/add', 'routes', 'routes', 'add', '2012-11-06 07:10:29'),
(3, 1, 'admin/routes/edit', 'routes', 'routes', 'edit', '2012-11-06 07:11:00'),
(4, 1, 'admin/routes/delete', 'routes', 'routes', 'delete', '2012-11-06 07:11:00'),
(5, 1, 'admin/settings', 'settings', 'settings', 'index', '2012-11-06 07:17:43'),
(6, 1, 'admin/settings/edit', 'settings', 'settings', 'edit', '2012-11-06 07:19:37'),
(7, 1, 'admin/permisssions', 'users', 'user_group_permissions', 'index', '2012-11-06 07:20:41'),
(8, 1, 'admin/permisssions/update', 'users', 'user_group_permissions', 'update', '2012-11-06 07:22:16'),
(9, 1, 'admin/groups', 'users', 'user_groups', 'index', '2012-11-06 07:23:53'),
(10, 1, 'admin/groups/edit', 'users', 'user_groups', 'edit', '2012-11-06 07:24:43'),
(11, 1, 'admin/users', 'users', 'users', 'index', '2012-11-06 07:25:28'),
(12, 1, 'login', 'users', 'users', 'login', '2012-11-06 07:32:48'),
(13, 1, 'logout', 'users', 'users', 'logout', '2012-11-06 07:33:17'),
(14, 1, 'register', 'users', 'users', 'register', '2012-11-06 07:33:47'),
(15, 1, 'action-denied', 'users', 'users', 'actionDenied', '2012-11-06 07:34:03'),
(16, 1, 'admin/users/edit', 'users', 'users', 'edit', '2012-11-06 07:36:11'),
(17, 1, '', 'presentations', 'presentations', 'index', '2012-11-28 08:10:09'),
(19, 1, 'categories/add', 'expenses', 'categories', 'add', '2012-11-09 06:53:31'),
(20, 1, 'categories/edit', 'expenses', 'categories', 'edit', '2012-11-09 06:53:37'),
(21, 1, 'categories/delete', 'expenses', 'categories', 'delete', '2012-11-09 06:53:45'),
(22, 1, 'payments', 'expenses', 'payments', 'index', '2012-11-09 06:53:50'),
(23, 1, 'payments/add', 'expenses', 'payments', 'add', '2012-11-09 06:53:55'),
(24, 1, 'payments/edit', 'expenses', 'payments', 'edit', '2012-11-09 06:54:13'),
(25, 1, 'payments/delete', 'expenses', 'payments', 'delete', '2012-11-09 06:53:59'),
(26, 1, 'receivables', 'expenses', 'receivables', 'index', '2012-11-09 17:27:00'),
(27, 1, 'receivables/add', 'expenses', 'receivables', 'add', '2012-11-09 17:26:51'),
(28, 1, 'receivables/edit', 'expenses', 'receivables', 'edit', '2012-11-09 17:26:44'),
(29, 1, 'receivables/delete', 'expenses', 'receivables', 'delete', '2012-11-09 17:26:30'),
(30, 1, 'payments/category', 'expenses', 'payments', 'category', '2012-11-09 06:54:38'),
(31, 1, 'payments/subcategory', 'expenses', 'payments', 'subcategory', '2012-11-09 06:54:50'),
(32, 1, 'receivables/category', 'expenses', 'receivables', 'category', '2012-11-09 17:26:22'),
(33, 1, 'receivables/subcategory', 'expenses', 'receivables', 'subcategory', '2012-11-09 17:26:13'),
(34, 1, 'reports', 'reports', 'reports', 'index', '2012-11-09 09:02:42'),
(35, 1, 'charts/demo', 'high_charts', 'high_charts_demo', 'index', '2012-11-09 09:16:11'),
(36, 1, 'charts/single-series/area', 'high_charts', 'single_series_demo', 'area', '2012-11-09 09:17:58'),
(37, 1, 'charts/single-series/areaspline', 'high_charts', 'single_series_demo', 'areaspline', '2012-11-09 09:30:54'),
(38, 1, 'charts/single-series/bar', 'high_charts', 'single_series_demo', 'bar', '2012-11-09 09:32:36'),
(39, 1, 'charts/single-series/column', 'high_charts', 'single_series_demo', 'column', '2012-11-09 09:33:46'),
(40, 1, 'charts/single-series/line', 'high_charts', 'single_series_demo', 'line', '2012-11-09 09:34:14'),
(41, 1, 'charts/single-series/pie', 'high_charts', 'single_series_demo', 'pie', '2012-11-09 09:34:26'),
(42, 1, 'charts/single-series/scatter', 'high_charts', 'single_series_demo', 'scatter', '2012-11-09 09:34:39'),
(43, 1, 'charts/single-series/spline', 'high_charts', 'single_series_demo', 'spline', '2012-11-09 09:34:48'),
(44, 1, 'charts/multi-series/area', 'high_charts', 'multi_series_demo', 'area', '2012-11-09 09:35:47'),
(45, 1, 'charts/multi-series/areaspline', 'high_charts', 'multi_series_demo', 'areaspline', '2012-11-09 09:36:12'),
(46, 1, 'charts/multi-series/bar', 'high_charts', 'multi_series_demo', 'bar', '2012-11-09 09:36:22'),
(47, 1, 'charts/multi-series/column', 'high_charts', 'multi_series_demo', 'column', '2012-11-09 09:36:32'),
(48, 1, 'charts/multi-series/line', 'high_charts', 'multi_series_demo', 'line', '2012-11-09 09:36:40'),
(49, 1, 'charts/multi-series/pie', 'high_charts', 'multi_series_demo', 'pie', '2012-11-09 09:36:48'),
(50, 1, 'charts/multi-series/scatter', 'high_charts', 'multi_series_demo', 'scatter', '2012-11-09 09:36:56'),
(51, 1, 'charts/multi-series/spline', 'high_charts', 'multi_series_demo', 'spline', '2012-11-09 09:37:04'),
(52, 1, 'charts', 'high_charts', 'charts', 'index', '2012-11-09 12:18:55'),
(53, 1, 'charts/pie', 'high_charts', 'charts', 'pie', '2012-11-09 12:57:46'),
(54, 1, 'charts/column', 'high_charts', 'charts', 'column', '2012-11-09 14:02:09'),
(55, 1, 'chart', 'high_charts', 'charts', 'chart', '2012-11-13 14:17:44'),
(56, 1, 'raluca/index', 'high_charts', 'charts_raluca', 'index', '2012-11-14 12:22:05'),
(57, 1, 'account', 'users', 'users', 'account', '2012-11-15 16:56:02'),
(58, 1, 'change-password', 'users', 'users', 'changePassword', '2012-11-15 17:47:19'),
(59, 1, 'admin/users/online', 'users', 'users', 'online', '2012-11-15 18:49:17'),
(60, 1, 'forgot-password', 'users', 'users', 'forgotPassword', '2012-11-15 18:58:16'),
(61, 1, 'categories/payments', 'expenses', 'categories', 'payments', '2012-11-19 07:58:03'),
(62, 1, 'categories/receivables', 'expenses', 'categories', 'receivables', '2012-11-19 07:58:15');

-- --------------------------------------------------------

--
-- Table structure for table `route_params`
--

CREATE TABLE IF NOT EXISTS `route_params` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `route_id` bigint(20) NOT NULL DEFAULT '0',
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `value` varchar(255) NOT NULL DEFAULT '',
  `type` varchar(20) NOT NULL DEFAULT '',
  `lastupdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `plugin` varchar(255) NOT NULL DEFAULT '',
  `controller` varchar(255) NOT NULL DEFAULT '',
  `action` varchar(255) NOT NULL DEFAULT '',
  `setting` varchar(255) NOT NULL DEFAULT '',
  `value` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `type` varchar(10) NOT NULL DEFAULT '',
  `lastupdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `user_id`, `plugin`, `controller`, `action`, `setting`, `value`, `description`, `type`, `lastupdate`) VALUES
(1, 1, '', '', '', 'DEFAULT_LANGUAGE', 'eng', 'Default website language', '', '2012-11-05 05:14:23'),
(2, 1, 'USERS', '', '', 'LOGIN_COOKIE_NAME', 'Users', 'Users plugin cookie name', '', '2012-11-05 05:14:43'),
(3, 1, 'USERS', '', '', 'NOT_AIMED_ACTIONS', 'users/login, users/logout', 'Actions that do not require tracking', '', '2012-11-05 05:16:16'),
(4, 1, 'users', '', '', 'SITE_REGISTRATION', '1', 'Allow users registration', '', '2012-11-05 05:18:43'),
(5, 1, 'users', '', '', 'ADMIN_GROUP_ID', '1', 'Admin group id', '', '2012-11-05 06:00:57'),
(6, 1, 'users', 'users', 'login', 'user_redirect_url', '/payments', 'Redirect url after login for user', '', '2012-11-09 04:44:37'),
(7, 1, 'users', '', '', 'permissions', '1', 'Check users permisssions', 'boolean', '2012-11-06 05:38:12'),
(8, 1, 'users', '', '', 'ADMIN_PERMISSIONS', '0', 'Check admin users permissions', 'boolean', '2012-11-06 05:31:25'),
(9, 1, 'users', '', '', 'GUEST_GROUP_ID', '3', 'Guest group id', '', '2012-11-06 05:31:45'),
(10, 1, 'users', '', '', 'user_group_id', '2', 'Users group id', '', '2012-11-05 06:10:01'),
(11, 1, 'users', '', 'logout', 'REDIRECT_URL', '/', 'logout redirect url', '', '2012-11-28 09:06:10'),
(12, 1, 'routes', 'routes', 'index', 'LIMIT', '12', 'Routes / page', '', '2012-11-08 15:25:12'),
(13, 1, '', '', '', 'ADMIN_PAGINATOR_COUNTER', 'Page {:page} of {:pages}, showing {:current} {:model} out of {:count} total, starting on record {:start}, ending on {:end}', '', '', '2012-11-05 06:15:43'),
(14, 1, 'settings', 'settings', 'index', 'limit', '10', 'Settings / page', '', '2012-11-06 05:18:31'),
(15, 1, 'users', 'user_groups', 'index', 'limit', '10', 'groups / page', '', '2012-11-06 05:23:31'),
(16, 1, 'users', 'users', 'index', 'limit', '10', 'users / page', '', '2012-11-06 05:26:56'),
(17, 0, 'users', 'users', 'online', 'limit', '10', 'online users / page', '', '2012-11-06 05:29:01'),
(18, 1, 'users', '', '', 'ONLINE_USER_TIME', '60 seconds', 'online user time', '', '2012-11-19 11:28:38'),
(19, 1, 'users', 'users', 'login', 'ADMIN_REDIRECT_URL', '/admin/users', 'Admin users redirect after login', '', '2012-11-06 05:40:24'),
(20, 1, 'users', 'users', 'register', 'SEND_VERIFICATION_MAIL', '0', 'send verification mail on register', '', '2012-11-14 09:43:00'),
(21, 1, 'users', 'users', 'register', 'SEND_REGISTRATION_MAIL', '1', 'send registration mail', '', '2012-11-14 09:43:00'),
(22, 1, '', '', '', 'FACEBOOK_APP_ID', '408122322590440', 'facebook app id', '', '2012-11-20 13:19:25'),
(23, 1, 'users', 'users', 'register', 'REGISTRATION_FROM_MAIL', 'users@expenses-manager.com', 'registration from mail', '', '2012-11-14 09:48:34'),
(24, 1, 'users', 'users', 'register', 'REGISTRATION_FROM_NAME', 'Expenses Manager - Users', 'registration from name', '', '2012-11-14 09:48:34'),
(25, 0, 'users', 'users', 'register', 'REGISTRATION_MAIL_SUBJECT', 'successful registration', 'REGISTRATION_MAIL_SUBJECT', '', '2012-11-14 09:50:42'),
(26, 0, 'users', 'users', 'register', 'REDIRECT_URL', '/categories', 'REDIRECT_URL', '', '2012-11-14 09:50:42'),
(27, 1, 'users', 'users', 'forgotPassword', 'FROM_MAIL', 'password-recover@expenses-manager.com', 'forgot password from email', '', '2012-11-15 17:15:49'),
(28, 1, 'users', 'users', 'forgotPassword', 'FROM_NAME', 'Password recover', 'forgot password from name', '', '2012-11-15 17:15:49'),
(29, 0, 'users', 'users', 'FORGOTPASSWORD', 'MAIL_SUBJECT', 'password recover', 'forgot password subject', '', '2012-11-15 17:30:57'),
(30, 1, '', '', '', 'FACEBOOK_SCOPE', 'publish_actions, user_birthday', 'facebook scope', '', '2012-11-22 14:27:09'),
(31, 0, '', '', '', 'FACEBOOK_SECRET', '0dc0c320a64762dfd209808fe5f3fcc3', 'facebook secret', '', '2012-11-20 13:22:19'),
(32, 0, 'users', '', 'login', 'redirect_url', '/payments', 'users default login redirect url', '', '2012-11-20 13:39:51'),
(33, 1, '', '', '', 'payments_limit', '9', 'payments / page', '', '2012-12-10 18:47:12'),
(34, 1, '', '', '', 'receivables_limit', '9', 'receivables / page', '', '2012-11-23 06:40:38'),
(35, 0, '', '', '', 'CATEGORIES_LIMIT', '3', 'categories / page', '', '2012-11-22 11:09:04'),
(36, 0, '', '', '', 'TWITTER_APP_ID', 'NSnXRWIDehtn4z32QAR88Q', 'twitter app id', '', '2012-11-26 13:44:43'),
(37, 0, '', '', '', 'TWITTER_SECRET', 'iew5sZ1l4jzW5vn1JbE9efYyCdNgUe4jc8q87KteAQ', 'twitter secret', '', '2012-11-26 13:44:43'),
(38, 1, '', '', '', 'LOGO_URL', '/payments', 'logo url', '', '2012-12-06 12:35:47');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE IF NOT EXISTS `teams` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `lastupdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `teams_users`
--

CREATE TABLE IF NOT EXISTS `teams_users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `team_id` bigint(20) NOT NULL DEFAULT '0',
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `lastupdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `tmp_emails`
--

CREATE TABLE IF NOT EXISTS `tmp_emails` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `email` text,
  `code` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fb_id` bigint(100) DEFAULT NULL,
  `fb_access_token` text,
  `twt_id` bigint(100) DEFAULT NULL,
  `twt_access_token` text,
  `twt_access_secret` text,
  `ldn_id` varchar(100) DEFAULT NULL,
  `user_group_id` text,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `salt` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `language` varchar(20) NOT NULL DEFAULT 'eng',
  `active` char(3) DEFAULT '0',
  `email_verified` int(1) NOT NULL DEFAULT '0',
  `last_login` datetime DEFAULT NULL,
  `by_admin` int(1) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
-- --------------------------------------------------------

--
-- Table structure for table `user_activities`
--

CREATE TABLE IF NOT EXISTS `user_activities` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `useragent` text,
  `user_id` int(10) DEFAULT NULL,
  `last_action` int(10) DEFAULT NULL,
  `last_url` text,
  `params` varchar(255) NOT NULL DEFAULT '',
  `logout_time` int(10) DEFAULT NULL,
  `user_browser` text,
  `ip_address` varchar(50) DEFAULT NULL,
  `logout` int(11) NOT NULL DEFAULT '0',
  `deleted` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE IF NOT EXISTS `user_details` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL DEFAULT '',
  `last_name` varchar(255) NOT NULL DEFAULT '',
  `gender` varchar(10) DEFAULT NULL,
  `photo` text,
  `birth_date` date DEFAULT '0000-00-00',
  `location` text,
  `phone` varchar(15) DEFAULT NULL,
  `language` varchar(10) NOT NULL DEFAULT 'eng',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE IF NOT EXISTS `user_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `alias_name` varchar(100) DEFAULT NULL,
  `allow_registration` int(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`id`, `name`, `alias_name`, `allow_registration`, `created`, `modified`) VALUES
(1, 'admin', 'Admin', 0, '2012-10-08 11:21:46', '2012-10-08 11:21:46'),
(2, 'user', 'User', 1, '2012-10-08 11:21:46', '2012-10-08 11:21:46'),
(3, 'guest', 'Guest', 0, '2012-10-08 11:21:46', '2012-10-08 11:21:46');

-- --------------------------------------------------------

--
-- Table structure for table `user_group_permissions`
--

CREATE TABLE IF NOT EXISTS `user_group_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_group_id` int(10) unsigned NOT NULL DEFAULT '0',
  `controller` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `action` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `allowed` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=54 ;

--
-- Dumping data for table `user_group_permissions`
--

INSERT INTO `user_group_permissions` (`id`, `user_group_id`, `controller`, `action`, `allowed`) VALUES
(1, 3, 'Users', 'login', 1),
(2, 2, 'Users', 'logout', 1),
(3, 3, 'Users', 'register', 1),
(4, 2, 'Users', 'accessDenied', 1),
(5, 3, 'Users', 'accessDenied', 1),
(6, 2, 'Payments', 'index', 1),
(7, 2, 'Categories', 'index', 1),
(8, 2, 'Categories', 'add', 1),
(9, 2, 'Categories', 'edit', 1),
(10, 2, 'Categories', 'delete', 1),
(11, 2, 'Payments', 'add', 1),
(12, 2, 'Payments', 'edit', 1),
(13, 2, 'Payments', 'delete', 1),
(14, 2, 'Payments', 'subcategory', 1),
(15, 2, 'Payments', 'category', 1),
(16, 2, 'Receivables', 'index', 1),
(17, 2, 'Receivables', 'category', 1),
(18, 2, 'Receivables', 'subcategory', 1),
(19, 2, 'Receivables', 'add', 1),
(20, 2, 'Receivables', 'edit', 1),
(21, 2, 'Receivables', 'delete', 1),
(22, 2, 'Receivables', 'index', 1),
(23, 2, 'HighChartsDemo', 'index', 1),
(24, 2, 'SingleSeriesDemo', 'area', 1),
(25, 2, 'SingleSeriesDemo', 'areaspline', 1),
(26, 2, 'SingleSeriesDemo', 'bar', 1),
(27, 2, 'SingleSeriesDemo', 'column', 1),
(28, 2, 'SingleSeriesDemo', 'line', 1),
(29, 2, 'SingleSeriesDemo', 'pie', 1),
(30, 2, 'SingleSeriesDemo', 'scatter', 1),
(31, 2, 'SingleSeriesDemo', 'spline', 1),
(32, 2, 'MultiSeriesDemo', 'area', 1),
(33, 2, 'MultiSeriesDemo', 'areaspline', 1),
(34, 2, 'MultiSeriesDemo', 'bar', 1),
(35, 2, 'MultiSeriesDemo', 'column', 1),
(36, 2, 'MultiSeriesDemo', 'line', 1),
(37, 2, 'MultiSeriesDemo', 'pie', 1),
(38, 2, 'MultiSeriesDemo', 'scatter', 1),
(39, 2, 'MultiSeriesDemo', 'spline', 1),
(40, 2, 'Charts', 'index', 1),
(41, 2, 'Charts', 'pie', 1),
(42, 2, 'Charts', 'column', 1),
(43, 2, 'Reports', 'index', 1),
(44, 2, 'Charts', 'chart', 1),
(45, 3, 'ChartsRaluca', 'index', 0),
(46, 2, 'ChartsRaluca', 'index', 1),
(47, 1, 'ChartsRaluca', 'index', 1),
(48, 2, 'Users', 'account', 1),
(49, 2, 'Users', 'changePassword', 1),
(50, 2, 'Categories', 'payments', 1),
(51, 2, 'Categories', 'receivables', 1),
(52, 3, 'Presentations', 'index', 1),
(53, 2, 'Presentations', 'index', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
