-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 09, 2015 at 08:28 PM
-- Server version: 5.1.37
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hrsys`
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('bb08a714fafede1aadfa734692c6ce55', '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:35.0) Gecko/20100101 Firefox/35.0', 1423488410, 'a:2:{s:9:"user_data";s:0:"";s:12:"hrsys_userdt";a:3:{s:4:"user";a:8:{s:7:"user_id";s:23:"142199935954c1fcffd9501";s:8:"username";s:5:"admin";s:10:"active_non";s:1:"1";s:10:"last_login";N;s:10:"datecreate";s:19:"2015-01-23 14:48:55";s:10:"usercreate";N;s:10:"dateupdate";s:19:"2015-01-28 13:37:03";s:10:"userupdate";s:5:"admin";}s:5:"roles";a:4:{i:0;s:10:"adm_lookup";i:1;s:8:"adm_menu";i:2;s:8:"adm_role";i:3;s:8:"adm_user";}s:8:"employee";a:0:{}}}');

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
  `pic` varchar(25) DEFAULT NULL,
  `datecreate` datetime NOT NULL,
  `usercreate` varchar(30) NOT NULL,
  `dateupdate` datetime NOT NULL,
  `userupdate` varchar(30) NOT NULL,
  PRIMARY KEY (`cmpyclient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hrsys_cmpyclient`
--

INSERT INTO `hrsys_cmpyclient` (`cmpyclient_id`, `name`, `address`, `website`, `cp_name`, `cp_phone`, `status`, `pic`, `datecreate`, `usercreate`, `dateupdate`, `userupdate`) VALUES
('142346926454d86ad0af277', 'Pertamina', 'Jl. Medan Merdeka Timur 1A', 'http://www.pertamina.com/', 'Branjangan', '', '0', '', '2015-02-09 15:07:20', '142199935954c1fcffd9501', '2015-02-09 15:07:20', '');

-- --------------------------------------------------------

--
-- Table structure for table `hrsys_cmpyclient_meet`
--

CREATE TABLE IF NOT EXISTS `hrsys_cmpyclient_meet` (
  `meet_id` varchar(30) NOT NULL,
  `cmpyclient_id` varchar(30) NOT NULL,
  `type` char(1) DEFAULT NULL,
  `person` varchar(255) DEFAULT NULL,
  `place` varchar(255) DEFAULT NULL,
  `meettime` datetime DEFAULT NULL,
  `description` text,
  `outcome` char(1) DEFAULT NULL,
  `outcome_desc` text,
  `datecreate` datetime DEFAULT NULL,
  `usercreate` varchar(30) DEFAULT NULL,
  `dateupdate` datetime DEFAULT NULL,
  `userupdate` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`meet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hrsys_cmpyclient_meet`
--

INSERT INTO `hrsys_cmpyclient_meet` (`meet_id`, `cmpyclient_id`, `type`, `person`, `place`, `meettime`, `description`, `outcome`, `outcome_desc`, `datecreate`, `usercreate`, `dateupdate`, `userupdate`) VALUES
('142348612754d8acaf416a8', '142346926454d86ad0af277', '1', 'Branjangan', 'pertamina ep', '2015-02-10 12:00:00', '[Pertamina] meet Branjangan in pertamina ep at 10-02-2015 12:00', NULL, NULL, '2015-02-09 19:48:23', '142199935954c1fcffd9501', '2015-02-09 19:48:23', '142199935954c1fcffd9501');

-- --------------------------------------------------------

--
-- Table structure for table `hrsys_cmpyclient_trl`
--

CREATE TABLE IF NOT EXISTS `hrsys_cmpyclient_trl` (
  `cmpyclient_trl_id` varchar(30) NOT NULL,
  `cmpyclient_id` varchar(30) NOT NULL,
  `type` varchar(30) NOT NULL,
  `value` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `datecreate` datetime NOT NULL,
  `usercreate` varchar(30) NOT NULL,
  PRIMARY KEY (`cmpyclient_trl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hrsys_cmpyclient_trl`
--

INSERT INTO `hrsys_cmpyclient_trl` (`cmpyclient_trl_id`, `cmpyclient_id`, `type`, `value`, `description`, `datecreate`, `usercreate`) VALUES
('142346926454d86ad0b63a8', '142346926454d86ad0af277', '', '', 'admin Created Pertamina', '2015-02-09 15:07:20', '142199935954c1fcffd9501'),
('142348612754d8acaf41ad2', '142346926454d86ad0af277', 'meeting', '142348612754d8acaf416a8', '[Pertamina] meet Branjangan in pertamina ep at 10-02-2015 12:00', '2015-02-09 19:48:23', '142199935954c1fcffd9501');

-- --------------------------------------------------------

--
-- Table structure for table `hrsys_employee`
--

CREATE TABLE IF NOT EXISTS `hrsys_employee` (
  `emp_id` varchar(30) NOT NULL,
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
('1001', 'Victor', 'Victor Siahaan', NULL, NULL, NULL, '142274812054cd69d85cf66'),
('1002', 'Budi', 'Budi Wicaksono', NULL, NULL, NULL, '142274810554cd69c9f0e29'),
('1003', 'Farah', 'Farah Alika', NULL, NULL, NULL, '142274831954cd6a9f6fab9'),
('1004', 'Kartika', 'Kartika Dewi', NULL, NULL, NULL, '142274833454cd6aaeed52b'),
('1005', 'Rika', 'Rika Fadilah', NULL, NULL, NULL, '142274855454cd6b8aeea54'),
('820547', 'Gunawan', 'Gunawan Prabhaswara', NULL, NULL, NULL, '142199957054c1fdd26eca3');

-- --------------------------------------------------------

--
-- Table structure for table `hrsys_schedule`
--

CREATE TABLE IF NOT EXISTS `hrsys_schedule` (
  `schedule_id` varchar(30) NOT NULL,
  `scheduletime` datetime DEFAULT NULL,
  `description` text,
  `type` varchar(30) DEFAULT NULL,
  `value` varchar(30) DEFAULT NULL,
  `datecreate` datetime DEFAULT NULL,
  `usercreate` varchar(30) DEFAULT NULL,
  `dateupdate` datetime DEFAULT NULL,
  `userupdate` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`schedule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hrsys_schedule`
--

INSERT INTO `hrsys_schedule` (`schedule_id`, `scheduletime`, `description`, `type`, `value`, `datecreate`, `usercreate`, `dateupdate`, `userupdate`) VALUES
('142348612754d8acaf418ef', '2015-02-10 12:00:00', '[Pertamina] meet Branjangan in pertamina ep at 10-02-2015 12:00', 'meeting', '142348612754d8acaf416a8', '2015-02-09 19:48:23', '142199935954c1fcffd9501', '2015-02-09 19:48:23', '142199935954c1fcffd9501');

-- --------------------------------------------------------

--
-- Table structure for table `hrsys_scheduleuser`
--

CREATE TABLE IF NOT EXISTS `hrsys_scheduleuser` (
  `schedule_id` varchar(30) NOT NULL,
  `user_id` varchar(30) NOT NULL,
  PRIMARY KEY (`schedule_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hrsys_scheduleuser`
--

INSERT INTO `hrsys_scheduleuser` (`schedule_id`, `user_id`) VALUES
('142348612754d8acaf418ef', '142199935954c1fcffd9501'),
('142348612754d8acaf418ef', '142274833454cd6aaeed52b'),
('142348612754d8acaf418ef', '142274855454cd6b8aeea54');

-- --------------------------------------------------------

--
-- Table structure for table `hrsys_vacancy`
--

CREATE TABLE IF NOT EXISTS `hrsys_vacancy` (
  `vacancy_id` varchar(30) NOT NULL,
  `cmpyclient_id` varchar(30) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`vacancy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hrsys_vacancy`
--


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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `tpl_lookup`
--

INSERT INTO `tpl_lookup` (`lookup_id`, `value`, `display_text`, `type`, `order_num`, `datecreate`, `usercreate`, `dateupdate`, `userupdate`) VALUES
(1, '1', 'Active', 'active_non', 1, '2014-12-30 10:07:40', NULL, NULL, NULL),
(2, '0', 'Non Active', 'active_non', 2, '2014-12-30 10:07:40', NULL, NULL, NULL),
(7, 'm', 'Male', 'sex', 1, '2015-01-27 10:42:19', 'admin', '2015-01-27 10:42:19', NULL),
(8, 'f', 'Female', 'sex', 2, '2015-01-27 10:42:42', 'admin', '2015-01-27 10:42:45', 'admin'),
(9, '0', 'Prospect', 'cmpyclient_stat', 1, '2015-01-31 10:53:38', 'admin', '2015-01-31 10:53:38', NULL),
(10, '1', 'Client', 'cmpyclient_stat', 1, '2015-01-31 10:54:06', 'admin', '2015-01-31 10:54:06', NULL),
(11, '1', 'Regular Meeting', 'meet_type', 1, '2015-02-06 14:33:43', 'admin', '2015-02-06 14:44:00', 'admin'),
(12, '2', 'Assign contract', 'meet_type', 2, '2015-02-06 14:34:50', 'admin', '2015-02-06 14:44:27', 'admin'),
(13, '1', 'Complited', 'meet_outcome', 1, '2015-02-06 14:39:13', 'admin', '2015-02-06 14:42:58', 'admin'),
(14, '2', 'Canceled', 'meet_outcome', 2, '2015-02-06 14:39:36', 'admin', '2015-02-06 14:43:02', 'admin'),
(15, '4', 'Reschedule', 'meet_outcome', 4, '2015-02-06 14:40:31', 'admin', '2015-02-06 14:43:25', 'admin'),
(16, '3', 'Assigned Contract', 'meet_outcome', 3, '2015-02-06 14:42:19', 'admin', '2015-02-06 14:43:17', 'admin'),
(17, 'meeting', 'Meeting', 'trail', 1, '2015-02-09 14:49:37', '142199935954c1fcffd9501', '2015-02-09 14:49:37', NULL),
(18, 'vacancy', 'Vacancy', 'trail', 2, '2015-02-09 14:51:21', '142199935954c1fcffd9501', '2015-02-09 14:51:21', NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

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
(12, 'Client', '', 0, '', 3, 1, '', '2015-01-31 10:57:52', 'admin', '2015-01-31 10:57:52', NULL),
(13, 'New Client', 'hrsys/client/addEditClient', 12, '', 1, 1, '', '2015-01-31 10:58:53', 'admin', '2015-02-09 09:58:14', '142199935954c1fcffd9501'),
(14, 'Prospect Client', 'hrsys/client/prospect', 12, '', 2, 1, '', '2015-01-31 11:01:54', 'admin', '2015-01-31 11:37:57', 'admin'),
(15, 'My Client', 'hrsys/client/myclient', 12, '', 3, 1, '', '2015-01-31 11:10:51', 'admin', '2015-01-31 11:38:06', 'admin'),
(16, 'All Client', 'hrsys/client/allclient', 12, '', 4, 1, '', '2015-01-31 11:12:40', 'admin', '2015-02-01 14:45:54', 'admin');

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
('142199957054c1fdd26eca3', 'gunawan', 'dc96b97c4ffbead46ca25ef5d4b77cbe', 1, NULL, '2015-01-23 14:52:26', NULL, '2015-01-27 09:26:39', NULL),
('142274810554cd69c9f0e29', 'budi', '00dfc53ee86af02e742515cdcf075ed3', 1, NULL, '2015-02-01 06:48:01', 'admin', '2015-02-01 06:48:01', NULL),
('142274812054cd69d85cf66', 'victor', 'ffc150a160d37e92012c196b6af4160d', 1, NULL, '2015-02-01 06:48:16', 'admin', '2015-02-01 06:48:16', NULL),
('142274831954cd6a9f6fab9', 'farah', '9b0f4d720720fd55436ac7f07ac8a840', 1, NULL, '2015-02-01 06:51:35', 'admin', '2015-02-01 06:51:35', NULL),
('142274833454cd6aaeed52b', 'kartika', '2aca90f14de1638d56273cf4ff6b537d', 1, NULL, '2015-02-01 06:51:50', 'admin', '2015-02-01 06:51:50', NULL),
('142274855454cd6b8aeea54', 'rika', 'e32994c67f9a773e841f9e97bd26f014', 1, NULL, '2015-02-01 06:55:30', 'admin', '2015-02-01 06:55:30', NULL);

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
