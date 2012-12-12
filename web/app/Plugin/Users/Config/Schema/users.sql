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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;