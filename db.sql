-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 28, 2015 at 10:28 PM
-- Server version: 5.1.37
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `template`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('5cb5a4a83f0383346b7155bb6b020f01', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:35.0) Gecko/20100101 Firefox/35.0', 1422437479, 'a:2:{s:9:"user_data";s:0:"";s:12:"hrsys_userdt";a:2:{s:4:"user";a:8:{s:7:"user_id";s:23:"142199935954c1fcffd9501";s:8:"username";s:5:"admin";s:10:"active_non";s:1:"1";s:10:"last_login";N;s:10:"datecreate";s:19:"2015-01-23 14:48:55";s:10:"usercreate";N;s:10:"dateupdate";s:19:"2015-01-28 13:37:03";s:10:"userupdate";s:5:"admin";}s:5:"roles";a:4:{i:0;s:10:"adm_lookup";i:1;s:8:"adm_menu";i:2;s:8:"adm_role";i:3;s:8:"adm_user";}}}');

-- --------------------------------------------------------

--
-- Table structure for table `hrsys_cmpyclient`
--

CREATE TABLE IF NOT EXISTS `hrsys_cmpyclient` (
  `cmpyclient_id` varchar(30) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `website` varchar(100) NOT NULL,
  `cp_name` varchar(100) NOT NULL,
  `cp_phone` varchar(100) NOT NULL,
  `status` varchar(30) NOT NULL,
  `datecreate` datetime NOT NULL,
  `usercreate` varchar(30) NOT NULL,
  `dateupdate` datetime NOT NULL,
  `userupdate` varchar(30) NOT NULL,
  PRIMARY KEY (`cmpyclient_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hrsys_cmpyclient`
--


-- --------------------------------------------------------

--
-- Table structure for table `hrsys_cmpyclient_meet`
--

CREATE TABLE IF NOT EXISTS `hrsys_cmpyclient_meet` (
  `cmpyclient_meet` varchar(30) NOT NULL,
  `cmpyclient_id` varchar(30) NOT NULL,
  `state` varchar(20) NOT NULL,
  `place` varchar(255) NOT NULL,
  `attendance` text NOT NULL,
  `time` datetime NOT NULL,
  `note` text NOT NULL,
  PRIMARY KEY (`cmpyclient_meet`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hrsys_cmpyclient_meet`
--


-- --------------------------------------------------------

--
-- Table structure for table `hrsys_cmpyclient_trl`
--

CREATE TABLE IF NOT EXISTS `hrsys_cmpyclient_trl` (
  `cmpyclient_trl_id` varchar(30) NOT NULL,
  `cmpyclient_id` varchar(30) NOT NULL,
  `type` varchar(30) NOT NULL,
  `value` varchar(30) NOT NULL,
  `desc` text NOT NULL,
  `datecreate` datetime NOT NULL,
  `usercreate` varchar(30) NOT NULL,
  PRIMARY KEY (`cmpyclient_trl_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hrsys_cmpyclient_trl`
--


-- --------------------------------------------------------

--
-- Table structure for table `hrsys_employee`
--

CREATE TABLE IF NOT EXISTS `hrsys_employee` (
  `emp_id` varchar(25) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `sex` char(1) DEFAULT NULL,
  `user_id` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`emp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hrsys_employee`
--

INSERT INTO `hrsys_employee` (`emp_id`, `name`, `fullname`, `phone`, `birthdate`, `sex`, `user_id`) VALUES
('820547', 'Gunawan', 'Gunawan Prabhaswara', NULL, NULL, NULL, '142199935954c1fcffd9501');

-- --------------------------------------------------------

--
-- Table structure for table `tpl_lookup`
--

CREATE TABLE IF NOT EXISTS `tpl_lookup` (
  `lookup_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `value` varchar(50) DEFAULT NULL,
  `display_text` varchar(100) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `order_num` int(11) DEFAULT NULL,
  `datecreate` datetime DEFAULT NULL,
  `usercreate` varchar(30) DEFAULT NULL,
  `dateupdate` datetime DEFAULT NULL,
  `userupdate` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`lookup_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `tpl_lookup`
--

INSERT INTO `tpl_lookup` (`lookup_id`, `value`, `display_text`, `type`, `order_num`, `datecreate`, `usercreate`, `dateupdate`, `userupdate`) VALUES
(1, '1', 'Active', 'active_non', 1, '2014-12-30 10:07:40', NULL, NULL, NULL),
(2, '0', 'Non Active', 'active_non', 2, '2014-12-30 10:07:40', NULL, NULL, NULL),
(7, 'm', 'Male', 'sex', 1, '2015-01-27 10:42:19', 'admin', '2015-01-27 10:42:19', NULL),
(8, 'f', 'Female', 'sex', 2, '2015-01-27 10:42:42', 'admin', '2015-01-27 10:42:45', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tpl_menu`
--

CREATE TABLE IF NOT EXISTS `tpl_menu` (
  `menu_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `menu_title` varchar(100) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `attributes` varchar(250) DEFAULT NULL,
  `order_num` int(11) DEFAULT NULL,
  `active_non` tinyint(4) DEFAULT NULL,
  `role_id` varchar(100) DEFAULT NULL,
  `datecreate` datetime DEFAULT NULL,
  `usercreate` varchar(30) DEFAULT NULL,
  `dateupdate` datetime DEFAULT NULL,
  `userupdate` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `tpl_menu`
--

INSERT INTO `tpl_menu` (`menu_id`, `menu_title`, `url`, `parent_id`, `attributes`, `order_num`, `active_non`, `role_id`, `datecreate`, `usercreate`, `dateupdate`, `userupdate`) VALUES
(1, 'Admin', '', 0, '', 4, 1, '', NULL, NULL, '2015-01-27 10:46:06', 'admin'),
(2, 'User', '/admin/user', 1, '', 2, 1, 'adm_user', NULL, NULL, '2015-01-26 09:24:04', NULL),
(3, 'Lookup', '/admin/lookup', 1, '', 3, 1, 'adm_lookup', NULL, NULL, '2015-01-27 09:26:11', NULL),
(4, 'Menu', '/admin/menu', 1, '', 4, 1, 'adm_menu', NULL, NULL, '2015-01-26 09:23:53', NULL),
(8, 'Role', '/admin/role', 1, '', 1, 1, 'adm_role', '2015-01-12 16:43:50', NULL, '2015-01-26 09:20:43', NULL),
(9, 'Home', '/home/main_home', 0, '', 1, 1, '', '2015-01-26 09:27:06', NULL, '2015-01-27 09:36:19', NULL),
(10, 'Calendar', '/hrsys/calendar', 0, '', 2, 1, '', '2015-01-26 09:27:37', NULL, '2015-01-27 09:37:02', NULL),
(11, 'HR', '', 0, '', 3, 1, '', '2015-01-27 10:45:56', 'admin', '2015-01-27 10:48:37', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tpl_role`
--

CREATE TABLE IF NOT EXISTS `tpl_role` (
  `role_id` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `datecreate` datetime DEFAULT NULL,
  `usercreate` varchar(30) DEFAULT NULL,
  `dateupdate` datetime DEFAULT NULL,
  `userupdate` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tpl_role`
--

INSERT INTO `tpl_role` (`role_id`, `name`, `datecreate`, `usercreate`, `dateupdate`, `userupdate`) VALUES
('adm_lookup', 'Admin Lookup', '2015-01-12 16:58:15', NULL, '2015-01-12 16:58:15', NULL),
('adm_menu', 'Admin Menu', '2015-01-12 16:58:27', NULL, '2015-01-12 16:58:49', NULL),
('adm_role', 'Admin Role', '2015-01-12 16:58:37', NULL, '2015-01-12 17:03:58', NULL),
('adm_user', 'Admin User', '2015-01-12 16:58:03', NULL, '2015-01-12 16:58:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tpl_user`
--

CREATE TABLE IF NOT EXISTS `tpl_user` (
  `user_id` varchar(30) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(35) DEFAULT NULL,
  `active_non` tinyint(4) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `datecreate` datetime DEFAULT NULL,
  `usercreate` varchar(30) DEFAULT NULL,
  `dateupdate` datetime DEFAULT NULL,
  `userupdate` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tpl_user`
--

INSERT INTO `tpl_user` (`user_id`, `username`, `password`, `active_non`, `last_login`, `datecreate`, `usercreate`, `dateupdate`, `userupdate`) VALUES
('142199935954c1fcffd9501', 'admin', '21232f297a57a5a743894a0e4a801fc3', 1, NULL, '2015-01-23 14:48:55', NULL, '2015-01-28 13:37:03', 'admin'),
('142199957054c1fdd26eca3', 'gunawan', 'dc96b97c4ffbead46ca25ef5d4b77cbe', 1, NULL, '2015-01-23 14:52:26', NULL, '2015-01-27 09:26:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tpl_user_role`
--

CREATE TABLE IF NOT EXISTS `tpl_user_role` (
  `user_id` varchar(30) NOT NULL,
  `role_id` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tpl_user_role`
--

INSERT INTO `tpl_user_role` (`user_id`, `role_id`) VALUES
('142199935954c1fcffd9501', 'adm_lookup'),
('142199935954c1fcffd9501', 'adm_menu'),
('142199935954c1fcffd9501', 'adm_role'),
('142199935954c1fcffd9501', 'adm_user'),
('142199951854c1fd9eb3f49', 'adm_lookup'),
('142199951854c1fd9eb3f49', 'adm_menu'),
('142199961154c1fdfb402d4', 'adm_lookup'),
('142199961154c1fdfb402d4', 'adm_menu'),
('142199961154c1fdfb402d4', 'adm_role'),
('142200025654c200803ce9e', 'adm_lookup'),
('142200025654c200803ce9e', 'adm_menu'),
('142200060654c201de9f09d', 'adm_lookup'),
('142200060654c201de9f09d', 'adm_menu');
