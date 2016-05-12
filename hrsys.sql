-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2016 at 05:32 AM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hrsys`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('99ccc36e338168838d019b025b9e4c8d', '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:45.0) Gecko/20100101 Firefox/45.0', 1461299502, 'a:2:{s:9:"user_data";s:0:"";s:12:"hrsys_userdt";a:3:{s:4:"user";a:8:{s:7:"user_id";s:23:"1453174328569dae389aaf1";s:8:"username";s:14:"rika@bgc.co.id";s:10:"active_non";s:1:"1";s:10:"last_login";s:19:"2016-04-08 16:18:10";s:10:"datecreate";s:19:"2016-01-19 10:32:08";s:10:"usercreate";s:23:"142199935954c1fcffd9501";s:10:"dateupdate";s:19:"2016-02-22 16:24:53";s:10:"userupdate";s:23:"1453174328569dae389aaf1";}s:5:"roles";a:5:{i:0;s:15:"hrsys_allclient";i:1;s:16:"hrsys_allinvoice";i:2;s:16:"hrsys_allmeeting";i:3;s:18:"hrsys_allvacancies";i:4;s:12:"hrsys_config";}s:8:"employee";a:10:{s:2:"id";s:23:"1453174328569dae389aaf1";s:13:"employee_code";s:2:"01";s:15:"consultant_code";s:6:"bgc_id";s:8:"fullname";s:12:"rika fadilah";s:5:"phone";s:0:"";s:9:"birthdate";N;s:3:"sex";N;s:7:"user_id";s:23:"1453174328569dae389aaf1";s:10:"active_non";s:1:"1";s:15:"consultant_name";s:13:"BGC Indonesia";}}}'),
('b780490bb5d2dbe5987add078d83edca', '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:45.0) Gecko/20100101 Firefox/45.0', 1461567036, 'a:2:{s:9:"user_data";s:0:"";s:12:"hrsys_userdt";a:3:{s:4:"user";a:8:{s:7:"user_id";s:23:"1453174328569dae389aaf1";s:8:"username";s:14:"rika@bgc.co.id";s:10:"active_non";s:1:"1";s:10:"last_login";s:19:"2016-04-22 10:43:01";s:10:"datecreate";s:19:"2016-01-19 10:32:08";s:10:"usercreate";s:23:"142199935954c1fcffd9501";s:10:"dateupdate";s:19:"2016-02-22 16:24:53";s:10:"userupdate";s:23:"1453174328569dae389aaf1";}s:5:"roles";a:5:{i:0;s:15:"hrsys_allclient";i:1;s:16:"hrsys_allinvoice";i:2;s:16:"hrsys_allmeeting";i:3;s:18:"hrsys_allvacancies";i:4;s:12:"hrsys_config";}s:8:"employee";a:10:{s:2:"id";s:23:"1453174328569dae389aaf1";s:13:"employee_code";s:2:"01";s:15:"consultant_code";s:6:"bgc_id";s:8:"fullname";s:12:"rika fadilah";s:5:"phone";s:0:"";s:9:"birthdate";N;s:3:"sex";N;s:7:"user_id";s:23:"1453174328569dae389aaf1";s:10:"active_non";s:1:"1";s:15:"consultant_name";s:13:"BGC Indonesia";}}}');

-- --------------------------------------------------------

--
-- Table structure for table `hrsys_applicantstat_nxt`
--

CREATE TABLE `hrsys_applicantstat_nxt` (
  `applicant_stat_id` int(11) NOT NULL,
  `consultant_code` varchar(10) NOT NULL,
  `applicant_stat_next` int(11) NOT NULL,
  `order_num` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hrsys_applicantstat_nxt`
--

INSERT INTO `hrsys_applicantstat_nxt` (`applicant_stat_id`, `consultant_code`, `applicant_stat_next`, `order_num`) VALUES
(1, 'bgc_id', 2, 1),
(1, 'bgc_id', 5, 2),
(1, 'bgc_id', 7, 3),
(2, 'bgc_id', 3, 1),
(2, 'bgc_id', 5, 2),
(2, 'bgc_id', 7, 3),
(3, 'bgc_id', 4, 1),
(3, 'bgc_id', 5, 2),
(3, 'bgc_id', 6, 3),
(3, 'bgc_id', 7, 4),
(4, 'bgc_id', 8, 1),
(4, 'bgc_id', 5, 2),
(4, 'bgc_id', 6, 3),
(4, 'bgc_id', 7, 4);

-- --------------------------------------------------------

--
-- Table structure for table `hrsys_candidate`
--

CREATE TABLE `hrsys_candidate` (
  `candidate_id` varchar(30) NOT NULL,
  `consultant_code` varchar(10) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `expectedsalary` bigint(20) UNSIGNED DEFAULT NULL,
  `expectedsalary_ccy` varchar(5) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `sex` char(1) DEFAULT NULL,
  `skill` varchar(200) DEFAULT NULL,
  `candidate_manager` varchar(30) DEFAULT NULL,
  `datecreate` datetime DEFAULT NULL,
  `usercreate` varchar(30) DEFAULT NULL,
  `dateupdate` datetime DEFAULT NULL,
  `userupdate` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hrsys_candidate`
--

INSERT INTO `hrsys_candidate` (`candidate_id`, `consultant_code`, `photo`, `status`, `name`, `phone`, `email`, `expectedsalary`, `expectedsalary_ccy`, `birthdate`, `sex`, `skill`, `candidate_manager`, `datecreate`, `usercreate`, `dateupdate`, `userupdate`) VALUES
('145380243656a743c4207ed', 'bgc_id', 'photo.jpg', 1, 'guntur', '', 'guntur@gmail.com', 15000000, 'IDR', NULL, 'm', 'J2EE,Java,WebLogic', '145336425756a09421c5c89', '2016-01-26 17:00:36', '1453174328569dae389aaf1', '2016-03-22 16:12:09', '1453174328569dae389aaf1'),
('145466365656b467e86e60b', 'bgc_id', 'photo.jpg', 1, 'gun', '', '', NULL, 'IDR', '1986-06-14', '', '.Net', NULL, '2016-02-05 16:14:16', '1453174328569dae389aaf1', '2016-02-22 14:16:20', '1453174328569dae389aaf1'),
('145638630456ceb1008c92b', 'bgc_id', '', 1, 'saipul', '', '', NULL, 'IDR', '1980-01-01', 'm', NULL, '145336425756a09421c5c89', '2016-02-25 14:45:04', '1453174328569dae389aaf1', '2016-03-22 15:03:28', '1453174328569dae389aaf1'),
('145638632856ceb1180c3d6', 'bgc_id', '', 1, 'eka heriawan', '', '', 0, 'IDR', NULL, '', 'Python', NULL, '2016-02-25 14:45:28', '1453174328569dae389aaf1', '2016-02-25 14:46:31', '1453174328569dae389aaf1');

-- --------------------------------------------------------

--
-- Table structure for table `hrsys_candidate_doc`
--

CREATE TABLE `hrsys_candidate_doc` (
  `candidate_doc_id` varchar(30) NOT NULL,
  `candidate_id` varchar(30) DEFAULT NULL,
  `doc_url` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hrsys_candidate_skill`
--

CREATE TABLE `hrsys_candidate_skill` (
  `candidate_id` varchar(30) DEFAULT NULL,
  `skill` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hrsys_candidate_skill`
--

INSERT INTO `hrsys_candidate_skill` (`candidate_id`, `skill`) VALUES
('145466365656b467e86e60b', '.Net'),
('145638632856ceb1180c3d6', 'Python'),
('145380243656a743c4207ed', 'J2EE'),
('145380243656a743c4207ed', 'Java'),
('145380243656a743c4207ed', 'WebLogic');

-- --------------------------------------------------------

--
-- Table structure for table `hrsys_candidate_trl`
--

CREATE TABLE `hrsys_candidate_trl` (
  `candidate_trl_id` varchar(30) NOT NULL,
  `candidate_id` varchar(30) NOT NULL,
  `vacancy_id` varchar(30) DEFAULT NULL,
  `applicant_stat` int(11) DEFAULT NULL,
  `type` varchar(30) DEFAULT NULL,
  `value` varchar(30) DEFAULT NULL,
  `description` text,
  `datecreate` datetime DEFAULT NULL,
  `usercreate` varchar(30) DEFAULT NULL,
  `dateupdate` datetime NOT NULL,
  `userupdate` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hrsys_candidate_trl`
--

INSERT INTO `hrsys_candidate_trl` (`candidate_trl_id`, `candidate_id`, `vacancy_id`, `applicant_stat`, `type`, `value`, `description`, `datecreate`, `usercreate`, `dateupdate`, `userupdate`) VALUES
('145610684456ca6d5c8650f', '145380243656a743c4207ed', '145610645956ca6bdb9b700', 1, 'vacancy_trl_id', '145610684456ca6d5c85d3f', 'Add to Shortlist : Vacancy=we,Client=Bhineka', '2016-02-22 09:07:24', '1453174328569dae389aaf1', '2016-02-22 09:07:24', '1453174328569dae389aaf1'),
('145610684956ca6d61c85ce', '145380243656a743c4207ed', '145610645956ca6bdb9b700', 2, 'vacancy_trl_id', '145610684956ca6d61c7a16', 'Processs Of Interview: Vacancy=we,Client=Bhineka', '2016-02-22 09:07:29', '1453174328569dae389aaf1', '2016-02-22 09:07:29', '1453174328569dae389aaf1'),
('145610685456ca6d66e21f5', '145380243656a743c4207ed', '145610645956ca6bdb9b700', 3, 'vacancy_trl_id', '145610685456ca6d66e1254', 'Processs To Client: Vacancy=we,Client=Bhineka', '2016-02-22 09:07:34', '1453174328569dae389aaf1', '2016-02-22 09:07:34', '1453174328569dae389aaf1'),
('145610685956ca6d6b388cb', '145380243656a743c4207ed', '145610645956ca6bdb9b700', 4, 'vacancy_trl_id', '145610685956ca6d6b361ba', 'Offering Salary: Vacancy=we,Client=Bhineka', '2016-02-22 09:07:39', '1453174328569dae389aaf1', '2016-02-22 09:07:39', '1453174328569dae389aaf1'),
('145610689756ca6d9103845', '145380243656a743c4207ed', '145610645956ca6bdb9b700', 8, 'vacancy_trl_id', '145610689756ca6d9101cec', 'Placemented : Vacancy=we,Client=Bhineka', '2016-02-22 09:08:17', '1453174328569dae389aaf1', '2016-02-22 09:08:17', '1453174328569dae389aaf1'),
('145638636256ceb13a17532', '145638632856ceb1180c3d6', '145638626756ceb0dbe0a3a', 1, 'vacancy_trl_id', '145638636256ceb13a1714a', 'Add to Shortlist : Vacancy=Phyton dev,Client=Bhineka', '2016-02-25 14:46:02', '1453174328569dae389aaf1', '2016-02-25 14:46:02', '1453174328569dae389aaf1'),
('145638637056ceb1422fefc', '145638632856ceb1180c3d6', '145638626756ceb0dbe0a3a', 2, 'vacancy_trl_id', '145638637056ceb1422d7eb', 'Processs Of Interview: Vacancy=Phyton dev,Client=Bhineka', '2016-02-25 14:46:10', '1453174328569dae389aaf1', '2016-02-25 14:46:10', '1453174328569dae389aaf1'),
('145638638056ceb14caafef', '145638632856ceb1180c3d6', '145638626756ceb0dbe0a3a', 3, 'vacancy_trl_id', '145638638056ceb14caa436', 'Processs To Client: Vacancy=Phyton dev,Client=Bhineka', '2016-02-25 14:46:20', '1453174328569dae389aaf1', '2016-02-25 14:46:20', '1453174328569dae389aaf1'),
('145638638756ceb15306997', '145638632856ceb1180c3d6', '145638626756ceb0dbe0a3a', 4, 'vacancy_trl_id', '145638638756ceb15305ddf', 'Offering Salary: Vacancy=Phyton dev,Client=Bhineka', '2016-02-25 14:46:27', '1453174328569dae389aaf1', '2016-02-25 14:46:27', '1453174328569dae389aaf1'),
('145638639156ceb1574b103', '145638632856ceb1180c3d6', '145638626756ceb0dbe0a3a', 8, 'vacancy_trl_id', '145638639156ceb1574a54b', 'Placemented : Vacancy=Phyton dev,Client=Bhineka', '2016-02-25 14:46:31', '1453174328569dae389aaf1', '2016-02-25 14:46:31', '1453174328569dae389aaf1'),
('145855475756efc7854f322', '145380243656a743c4207ed', '145638626756ceb0dbe0a3a', 1, 'vacancy_trl_id', '145855475756efc7854ef3a', 'Add to Shortlist : Vacancy=Phyton dev,Client=Bhineka', '2016-03-21 17:05:57', '1453174328569dae389aaf1', '2016-03-21 17:05:57', '1453174328569dae389aaf1'),
('145855541056efca1245c52', '145638630456ceb1008c92b', '145638626756ceb0dbe0a3a', 1, 'vacancy_trl_id', '145855541056efca124586a', 'Add to Shortlist : Vacancy=Phyton dev,Client=Bhineka', '2016-03-21 17:16:50', '1453174328569dae389aaf1', '2016-03-21 17:16:50', '1453174328569dae389aaf1'),
('145863792956f10c694983e', '145380243656a743c4207ed', NULL, NULL, NULL, NULL, 'rika fadilah change candidate manager from rika fadilah to gun', '2016-03-22 16:12:09', '1453174328569dae389aaf1', '2016-03-22 16:12:09', '1453174328569dae389aaf1');

-- --------------------------------------------------------

--
-- Table structure for table `hrsys_cmpyclient`
--

CREATE TABLE `hrsys_cmpyclient` (
  `cmpyclient_id` varchar(30) NOT NULL,
  `consultant_code` varchar(10) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `address` text,
  `website` varchar(100) DEFAULT NULL,
  `cp_name` varchar(100) DEFAULT NULL,
  `cp_phone` varchar(100) DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `account_manager` varchar(30) DEFAULT NULL,
  `active_non` int(11) NOT NULL,
  `datecreate` datetime DEFAULT NULL,
  `usercreate` varchar(30) DEFAULT NULL,
  `dateupdate` datetime DEFAULT NULL,
  `userupdate` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hrsys_cmpyclient`
--

INSERT INTO `hrsys_cmpyclient` (`cmpyclient_id`, `consultant_code`, `name`, `address`, `website`, `cp_name`, `cp_phone`, `status`, `account_manager`, `active_non`, `datecreate`, `usercreate`, `dateupdate`, `userupdate`) VALUES
('145380317856a746aa410ac', 'bgc_id', 'Bhineka', 'Jl. Gunung Sahari Raya 73C #5-6 \r\nJakarta 10610 ', '', '', '', '1', '1453174328569dae389aaf1', 1, '2016-01-26 17:12:58', '1453174328569dae389aaf1', '2016-04-22 10:57:09', '1453174328569dae389aaf1'),
('145708130056d94bd460460', 'bgc_id', 'DGC', '', '', '', '', '1', '01', 1, '2016-03-04 15:48:20', '1453174328569dae389aaf1', '2016-03-04 15:48:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hrsys_cmpyclient_ctrk`
--

CREATE TABLE `hrsys_cmpyclient_ctrk` (
  `cmpyclient_ctrk_id` varchar(30) NOT NULL,
  `cmpyclient_id` varchar(30) DEFAULT NULL,
  `contract_num` varchar(100) DEFAULT NULL,
  `doc_url` varchar(500) DEFAULT NULL,
  `fee` decimal(10,0) DEFAULT NULL,
  `active_non` tinyint(1) DEFAULT NULL,
  `contractdate_1` date DEFAULT NULL,
  `contractdate_2` date DEFAULT NULL,
  `datecreate` date DEFAULT NULL,
  `usercreate` varchar(30) DEFAULT NULL,
  `dateupdate` date DEFAULT NULL,
  `userupdate` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hrsys_cmpyclient_ctrk`
--

INSERT INTO `hrsys_cmpyclient_ctrk` (`cmpyclient_ctrk_id`, `cmpyclient_id`, `contract_num`, `doc_url`, `fee`, `active_non`, `contractdate_1`, `contractdate_2`, `datecreate`, `usercreate`, `dateupdate`, `userupdate`) VALUES
('145612609556cab88fc32d7', '145380317856a746aa410ac', '1', 'Chrysanthemum.jpg', '0', 0, '2016-02-01', '2016-02-02', '2016-02-22', '1453174328569dae389aaf1', NULL, NULL),
('145612610856cab89c628d1', '145380317856a746aa410ac', '2', 'Tulips.jpg', '1', 0, '2016-02-03', '2016-02-06', '2016-02-22', '1453174328569dae389aaf1', NULL, NULL),
('145612645656cab9f8bab86', '145380317856a746aa410ac', '3', 'Jellyfish.jpg', '2', 1, '2016-02-05', '2016-02-13', '2016-02-22', '1453174328569dae389aaf1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hrsys_cmpyclient_meet`
--

CREATE TABLE `hrsys_cmpyclient_meet` (
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
  `userupdate` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hrsys_cmpyclient_meet`
--

INSERT INTO `hrsys_cmpyclient_meet` (`meet_id`, `cmpyclient_id`, `type`, `person`, `place`, `meettime`, `description`, `outcome`, `outcome_desc`, `datecreate`, `usercreate`, `dateupdate`, `userupdate`) VALUES
('145576688956c53d690b029', '145380317856a746aa410ac', '1', 'Jones', '', '2016-02-22 03:00:00', 'meeting with jones at 22-02-2016', NULL, NULL, '2016-02-18 10:41:29', '1453174328569dae389aaf1', '2016-02-18 15:18:45', '1453174328569dae389aaf1');

-- --------------------------------------------------------

--
-- Table structure for table `hrsys_cmpyclient_note`
--

CREATE TABLE `hrsys_cmpyclient_note` (
  `note_id` varchar(30) NOT NULL,
  `cmpyclient_id` varchar(30) DEFAULT NULL,
  `description` text,
  `datecreate` datetime DEFAULT NULL,
  `usercreate` varchar(30) DEFAULT NULL,
  `dateupdate` datetime DEFAULT NULL,
  `userupdate` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hrsys_cmpyclient_trl`
--

CREATE TABLE `hrsys_cmpyclient_trl` (
  `cmpyclient_trl_id` varchar(30) NOT NULL,
  `cmpyclient_id` varchar(30) NOT NULL,
  `type` varchar(30) NOT NULL,
  `value` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `datecreate` datetime NOT NULL,
  `usercreate` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hrsys_cmpyclient_trl`
--

INSERT INTO `hrsys_cmpyclient_trl` (`cmpyclient_trl_id`, `cmpyclient_id`, `type`, `value`, `description`, `datecreate`, `usercreate`) VALUES
('145380317856a746aa4fefb', '145380317856a746aa410ac', '', '', 'Created Bhineka', '2016-01-26 17:12:58', '1453174328569dae389aaf1'),
('145387644956a864e162a71', '145380317856a746aa410ac', '', '', 'Change status from prospect to client AM is rika fadilah', '2016-01-27 13:34:09', '1453174328569dae389aaf1'),
('145387645956a864ebb85ac', '145380317856a746aa410ac', 'vacancy', '145387645956a864ebb3f5a', 'rika fadilah Create Vacancy programmer', '2016-01-27 13:34:19', '1453174328569dae389aaf1'),
('145576688956c53d690b7f9', '145380317856a746aa410ac', 'meeting', '145576688956c53d690b029', 'meeting with jones at 22-02-2016', '2016-02-18 10:41:29', '1453174328569dae389aaf1'),
('145576841856c5436218aef', '145380317856a746aa410ac', '', '', 'Change AM from rika fadilah to rika fadilah', '2016-02-18 11:06:58', '1453174328569dae389aaf1'),
('145576843756c543751e4c7', '145380317856a746aa410ac', '', '', 'Change AM from rika fadilah to gun', '2016-02-18 11:07:17', '1453174328569dae389aaf1'),
('145576844556c5437d68c2f', '145380317856a746aa410ac', '', '', 'Change AM from gun to rika fadilah', '2016-02-18 11:07:25', '1453174328569dae389aaf1'),
('145584939856c67fb69bcab', '145380317856a746aa410ac', '', '', 'Change AM from rika fadilah to gun', '2016-02-19 09:36:38', '1453174328569dae389aaf1'),
('145584951356c68029716dc', '145380317856a746aa410ac', '', '', 'Change AM from gun to rika fadilah', '2016-02-19 09:38:33', '1453174328569dae389aaf1'),
('145610645956ca6bdba3403', '145380317856a746aa410ac', 'vacancy', '145610645956ca6bdb9b700', 'rika fadilah Create Vacancy we', '2016-02-22 09:00:59', '1453174328569dae389aaf1'),
('145612609556cab88fccb24', '145380317856a746aa410ac', 'contract', '145612609556cab88fc32d7', 'Created Contract 1', '2016-02-22 14:28:15', '1453174328569dae389aaf1'),
('145612610856cab89c68a71', '145380317856a746aa410ac', 'contract', '145612610856cab89c628d1', 'Created Contract 2', '2016-02-22 14:28:28', '1453174328569dae389aaf1'),
('145612645656cab9f8bbb25', '145380317856a746aa410ac', 'contract', '145612645656cab9f8bab86', 'Created Contract 3', '2016-02-22 14:34:16', '1453174328569dae389aaf1'),
('145638626756ceb0dbeba06', '145380317856a746aa410ac', 'vacancy', '145638626756ceb0dbe0a3a', 'rika fadilah Create Vacancy Phyton dev', '2016-02-25 14:44:27', '1453174328569dae389aaf1'),
('145708130056d94bd468944', '145708130056d94bd460460', '', '', 'Created DGC', '2016-03-04 15:48:20', '1453174328569dae389aaf1');

-- --------------------------------------------------------

--
-- Table structure for table `hrsys_consultant`
--

CREATE TABLE `hrsys_consultant` (
  `consultant_code` varchar(10) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `datecreate` datetime NOT NULL,
  `usercreate` varchar(100) NOT NULL,
  `dateupdate` datetime NOT NULL,
  `userupdate` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hrsys_consultant`
--

INSERT INTO `hrsys_consultant` (`consultant_code`, `name`, `datecreate`, `usercreate`, `dateupdate`, `userupdate`) VALUES
('bgc_id', 'BGC Indonesia', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
('bgc_sg', 'BGC Singapore', '2016-01-21 14:53:02', '142199935954c1fcffd9501', '2016-01-21 14:53:02', '');

-- --------------------------------------------------------

--
-- Table structure for table `hrsys_employee`
--

CREATE TABLE `hrsys_employee` (
  `id` varchar(30) NOT NULL,
  `employee_code` varchar(30) NOT NULL,
  `consultant_code` varchar(10) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `sex` char(1) DEFAULT NULL,
  `user_id` varchar(30) DEFAULT NULL,
  `active_non` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hrsys_employee`
--

INSERT INTO `hrsys_employee` (`id`, `employee_code`, `consultant_code`, `fullname`, `phone`, `birthdate`, `sex`, `user_id`, `active_non`) VALUES
('1453174328569dae389aaf1', '01', 'bgc_id', 'rika fadilah', '', NULL, NULL, '1453174328569dae389aaf1', 1),
('145336289156a08ecb92c76', '01', 'bgc_sg', 'rika sg', NULL, NULL, NULL, '145336289156a08ecb92c76', 1),
('145336425756a09421c5c89', '02', 'bgc_id', 'gun', '', NULL, NULL, '145336425756a09421c5c89', 1);

-- --------------------------------------------------------

--
-- Table structure for table `hrsys_formula`
--

CREATE TABLE `hrsys_formula` (
  `id` int(10) UNSIGNED NOT NULL,
  `consultant_code` varchar(10) NOT NULL,
  `name` varchar(200) NOT NULL,
  `value` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hrsys_formula`
--

INSERT INTO `hrsys_formula` (`id`, `consultant_code`, `name`, `value`) VALUES
(1, 'bgc_id', 'invoice', '[fee]/100*[salary]*13');

-- --------------------------------------------------------

--
-- Table structure for table `hrsys_invoice`
--

CREATE TABLE `hrsys_invoice` (
  `invoice_id` varchar(30) NOT NULL,
  `invoice_num` varchar(100) NOT NULL,
  `invoice_date` date NOT NULL,
  `due_date` date NOT NULL,
  `consultant_code` varchar(10) NOT NULL,
  `cmpyclient_id` varchar(30) NOT NULL,
  `total_bill` decimal(10,0) DEFAULT NULL,
  `paid_date` date DEFAULT NULL,
  `datecreate` datetime NOT NULL,
  `usercreate` varchar(100) NOT NULL,
  `dateupdate` datetime NOT NULL,
  `userupdate` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hrsys_invoice`
--

INSERT INTO `hrsys_invoice` (`invoice_id`, `invoice_num`, `invoice_date`, `due_date`, `consultant_code`, `cmpyclient_id`, `total_bill`, `paid_date`, `datecreate`, `usercreate`, `dateupdate`, `userupdate`) VALUES
('145932983156fb9b275c4f6', 'bb', '2016-03-01', '2016-03-03', 'bgc_id', '145380317856a746aa410ac', '48750000', '2016-04-01', '2016-03-30 16:23:51', '1453174328569dae389aaf1', '2016-04-01 14:16:52', '1453174328569dae389aaf1');

-- --------------------------------------------------------

--
-- Table structure for table `hrsys_invoice_item`
--

CREATE TABLE `hrsys_invoice_item` (
  `invoice_id` varchar(30) NOT NULL,
  `vacancycandidate_id` varchar(30) NOT NULL,
  `vacancy_name` varchar(100) NOT NULL,
  `candidate_name` varchar(100) NOT NULL,
  `join_date` date NOT NULL,
  `approvedsalary` bigint(20) NOT NULL,
  `fee` decimal(10,0) NOT NULL,
  `bill` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hrsys_invoice_item`
--

INSERT INTO `hrsys_invoice_item` (`invoice_id`, `vacancycandidate_id`, `vacancy_name`, `candidate_name`, `join_date`, `approvedsalary`, `fee`, `bill`) VALUES
('145932983156fb9b275c4f6', '145932983156fb9b275c4f6', 'Programmer', 'guntur', '2016-05-15', 15000000, '25', 48750000);

-- --------------------------------------------------------

--
-- Table structure for table `hrsys_schedule`
--

CREATE TABLE `hrsys_schedule` (
  `schedule_id` varchar(30) NOT NULL,
  `scheduletime` datetime DEFAULT NULL,
  `description` text,
  `type` varchar(30) DEFAULT NULL,
  `value` varchar(30) DEFAULT NULL,
  `datecreate` datetime DEFAULT NULL,
  `usercreate` varchar(30) DEFAULT NULL,
  `dateupdate` datetime DEFAULT NULL,
  `userupdate` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hrsys_schedule`
--

INSERT INTO `hrsys_schedule` (`schedule_id`, `scheduletime`, `description`, `type`, `value`, `datecreate`, `usercreate`, `dateupdate`, `userupdate`) VALUES
('145576688956c53d690b411', '2016-02-22 03:00:00', 'meeting with jones at 22-02-2016', 'meeting', '145576688956c53d690b029', '2016-02-18 10:41:29', '1453174328569dae389aaf1', '2016-02-18 15:18:45', '1453174328569dae389aaf1');

-- --------------------------------------------------------

--
-- Table structure for table `hrsys_scheduleuser`
--

CREATE TABLE `hrsys_scheduleuser` (
  `schedule_id` varchar(30) NOT NULL,
  `user_id` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hrsys_scheduleuser`
--

INSERT INTO `hrsys_scheduleuser` (`schedule_id`, `user_id`) VALUES
('145576688956c53d690b411', '1453174328569dae389aaf1'),
('145585351356c68fc94b667', '1453174328569dae389aaf1');

-- --------------------------------------------------------

--
-- Table structure for table `hrsys_skill`
--

CREATE TABLE `hrsys_skill` (
  `skill` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hrsys_skill`
--

INSERT INTO `hrsys_skill` (`skill`) VALUES
('PHP'),
('Magento'),
('Microsoft Dynamics AX'),
('Rubby'),
('HTML 5'),
('Codeigniter'),
('Drupal'),
('Yii'),
('SAP'),
('Cisco'),
('Oracle'),
('Java'),
('Mysql'),
('.Net'),
('#C'),
('SQL Server'),
('Oracle Form'),
('J2ME'),
('Spring'),
('WebLogic'),
('J2EE'),
('Python');

-- --------------------------------------------------------

--
-- Table structure for table `hrsys_vacancy`
--

CREATE TABLE `hrsys_vacancy` (
  `vacancy_id` varchar(30) NOT NULL,
  `cmpyclient_id` varchar(30) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `opendate` date DEFAULT NULL,
  `description` text,
  `num_position` int(11) DEFAULT NULL,
  `fee` decimal(10,0) DEFAULT NULL,
  `salary_1` bigint(20) UNSIGNED DEFAULT NULL,
  `salary_2` bigint(20) UNSIGNED DEFAULT NULL,
  `salary_ccy` varchar(5) DEFAULT NULL,
  `age_1` int(11) DEFAULT NULL,
  `age_2` int(11) DEFAULT NULL,
  `sex` char(1) DEFAULT NULL,
  `account_manager` varchar(30) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `datecreate` datetime DEFAULT NULL,
  `usercreate` varchar(30) DEFAULT NULL,
  `dateupdate` datetime DEFAULT NULL,
  `userupdate` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hrsys_vacancy`
--

INSERT INTO `hrsys_vacancy` (`vacancy_id`, `cmpyclient_id`, `name`, `opendate`, `description`, `num_position`, `fee`, `salary_1`, `salary_2`, `salary_ccy`, `age_1`, `age_2`, `sex`, `account_manager`, `status`, `datecreate`, `usercreate`, `dateupdate`, `userupdate`) VALUES
('145610645956ca6bdb9b700', '145380317856a746aa410ac', 'Programmer', '2016-02-22', '', 1, '25', 0, 0, 'IDR', 0, 0, '', '1453174328569dae389aaf1', 1, '2016-02-22 09:00:59', '1453174328569dae389aaf1', '2016-02-25 14:49:43', '1453174328569dae389aaf1'),
('145638626756ceb0dbe0a3a', '145380317856a746aa410ac', 'Phyton dev', '2016-02-25', '', 1, '20', 0, 0, 'IDR', 0, 0, '', '1453174328569dae389aaf1', 1, '2016-02-25 14:44:27', '1453174328569dae389aaf1', '2016-02-25 14:49:29', '1453174328569dae389aaf1');

-- --------------------------------------------------------

--
-- Table structure for table `hrsys_vacancycandidate`
--

CREATE TABLE `hrsys_vacancycandidate` (
  `vacancycandidate_id` varchar(30) NOT NULL,
  `vacancy_id` varchar(30) NOT NULL,
  `candidate_id` varchar(30) NOT NULL,
  `applicant_stat` int(11) DEFAULT NULL,
  `expectedsalary` bigint(20) UNSIGNED DEFAULT NULL,
  `expectedsalary_ccy` varchar(5) DEFAULT NULL,
  `approvedsalary` bigint(20) UNSIGNED DEFAULT NULL,
  `approvedsalary_ccy` varchar(5) DEFAULT NULL,
  `date_join` date DEFAULT NULL,
  `closed` tinyint(4) DEFAULT NULL,
  `datecreate` datetime DEFAULT NULL,
  `usercreate` varchar(30) DEFAULT NULL,
  `dateupdate` datetime DEFAULT NULL,
  `userupdate` varchar(30) DEFAULT NULL,
  `candidate_manager` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hrsys_vacancycandidate`
--

INSERT INTO `hrsys_vacancycandidate` (`vacancycandidate_id`, `vacancy_id`, `candidate_id`, `applicant_stat`, `expectedsalary`, `expectedsalary_ccy`, `approvedsalary`, `approvedsalary_ccy`, `date_join`, `closed`, `datecreate`, `usercreate`, `dateupdate`, `userupdate`, `candidate_manager`) VALUES
('145610684456ca6d5c816ed', '145610645956ca6bdb9b700', '145380243656a743c4207ed', 8, 15000000, 'IDR', 15000000, 'IDR', '2016-05-15', 1, '2016-02-22 09:07:24', '1453174328569dae389aaf1', '2016-02-22 09:09:19', '1453174328569dae389aaf1', '1453174328569dae389aaf1'),
('145638636256ceb13a0f05f', '145638626756ceb0dbe0a3a', '145638632856ceb1180c3d6', 8, 0, 'IDR', 10000000, 'IDR', '2016-02-26', 1, '2016-02-25 14:46:02', '1453174328569dae389aaf1', '2016-02-25 14:46:45', '1453174328569dae389aaf1', '1453174328569dae389aaf1'),
('145855475756efc7854eb52', '145638626756ceb0dbe0a3a', '145380243656a743c4207ed', 1, NULL, NULL, NULL, NULL, NULL, NULL, '2016-03-21 17:05:57', '1453174328569dae389aaf1', '2016-03-21 17:05:57', '1453174328569dae389aaf1', '1453174328569dae389aaf1'),
('145855541056efca1243d12', '145638626756ceb0dbe0a3a', '145638630456ceb1008c92b', 1, NULL, NULL, NULL, NULL, NULL, NULL, '2016-03-21 17:16:50', '1453174328569dae389aaf1', '2016-03-21 17:16:50', '1453174328569dae389aaf1', '145336425756a09421c5c89');

-- --------------------------------------------------------

--
-- Table structure for table `hrsys_vacancyuser`
--

CREATE TABLE `hrsys_vacancyuser` (
  `vacancy_id` varchar(30) NOT NULL,
  `user_id` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hrsys_vacancyuser`
--

INSERT INTO `hrsys_vacancyuser` (`vacancy_id`, `user_id`) VALUES
('145610645956ca6bdb9b700', '1453174328569dae389aaf1'),
('145638626756ceb0dbe0a3a', '1453174328569dae389aaf1');

-- --------------------------------------------------------

--
-- Table structure for table `hrsys_vacancy_skill`
--

CREATE TABLE `hrsys_vacancy_skill` (
  `vacancy_id` varchar(30) DEFAULT NULL,
  `skill` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hrsys_vacancy_trl`
--

CREATE TABLE `hrsys_vacancy_trl` (
  `trl_id` varchar(30) NOT NULL,
  `vacancycandidate_id` varchar(30) DEFAULT NULL,
  `applicant_stat_id` int(11) DEFAULT NULL,
  `applicant_stat_next` int(11) DEFAULT NULL,
  `description` text,
  `order_num` int(11) DEFAULT NULL,
  `active_non` tinyint(4) DEFAULT NULL,
  `datecreate` datetime DEFAULT NULL,
  `usercreate` varchar(30) DEFAULT NULL,
  `dateupdate` datetime DEFAULT NULL,
  `userupdate` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hrsys_vacancy_trl`
--

INSERT INTO `hrsys_vacancy_trl` (`trl_id`, `vacancycandidate_id`, `applicant_stat_id`, `applicant_stat_next`, `description`, `order_num`, `active_non`, `datecreate`, `usercreate`, `dateupdate`, `userupdate`) VALUES
('145610684456ca6d5c85d3f', '145610684456ca6d5c816ed', 1, 2, '', 1, 0, '2016-02-22 09:07:24', '1453174328569dae389aaf1', '2016-02-22 09:07:29', '1453174328569dae389aaf1'),
('145610684956ca6d61c7a16', '145610684456ca6d5c816ed', 2, 3, '', 2, 0, '2016-02-22 09:07:29', '1453174328569dae389aaf1', '2016-02-22 09:07:34', '1453174328569dae389aaf1'),
('145610685456ca6d66e1254', '145610684456ca6d5c816ed', 3, 4, '', 3, 0, '2016-02-22 09:07:34', '1453174328569dae389aaf1', '2016-02-22 09:07:39', '1453174328569dae389aaf1'),
('145610685956ca6d6b361ba', '145610684456ca6d5c816ed', 4, 8, '', 4, 0, '2016-02-22 09:07:39', '1453174328569dae389aaf1', '2016-02-22 09:08:16', '1453174328569dae389aaf1'),
('145610689756ca6d9101cec', '145610684456ca6d5c816ed', 8, NULL, '', 5, 1, '2016-02-22 09:08:17', '1453174328569dae389aaf1', '2016-02-22 09:09:19', '1453174328569dae389aaf1'),
('145638636256ceb13a1714a', '145638636256ceb13a0f05f', 1, 2, '', 1, 0, '2016-02-25 14:46:02', '1453174328569dae389aaf1', '2016-02-25 14:46:10', '1453174328569dae389aaf1'),
('145638637056ceb1422d7eb', '145638636256ceb13a0f05f', 2, 3, '', 2, 0, '2016-02-25 14:46:10', '1453174328569dae389aaf1', '2016-02-25 14:46:20', '1453174328569dae389aaf1'),
('145638638056ceb14caa436', '145638636256ceb13a0f05f', 3, 4, '', 3, 0, '2016-02-25 14:46:20', '1453174328569dae389aaf1', '2016-02-25 14:46:27', '1453174328569dae389aaf1'),
('145638638756ceb15305ddf', '145638636256ceb13a0f05f', 4, 8, '', 4, 0, '2016-02-25 14:46:27', '1453174328569dae389aaf1', '2016-02-25 14:46:31', '1453174328569dae389aaf1'),
('145638639156ceb1574a54b', '145638636256ceb13a0f05f', 8, NULL, '', 5, 1, '2016-02-25 14:46:31', '1453174328569dae389aaf1', '2016-02-25 14:46:45', '1453174328569dae389aaf1'),
('145855475756efc7854ef3a', '145855475756efc7854eb52', 1, NULL, NULL, 1, 1, '2016-03-21 17:05:57', '1453174328569dae389aaf1', '2016-03-21 17:05:57', '1453174328569dae389aaf1'),
('145855541056efca124586a', '145855541056efca1243d12', 1, NULL, NULL, 1, 1, '2016-03-21 17:16:50', '1453174328569dae389aaf1', '2016-03-21 17:16:50', '1453174328569dae389aaf1');

-- --------------------------------------------------------

--
-- Table structure for table `hrsys_vac_interview`
--

CREATE TABLE `hrsys_vac_interview` (
  `vacancy_trl_id` varchar(30) NOT NULL,
  `type` int(11) NOT NULL,
  `schedule` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hrsys_vac_interview`
--

INSERT INTO `hrsys_vac_interview` (`vacancy_trl_id`, `type`, `schedule`) VALUES
('145610666356ca6ca7aba64', 1, '2016-02-22 00:00:00'),
('145610684956ca6d61c7a16', 1, '0000-00-00 00:00:00'),
('145638637056ceb1422d7eb', 1, '2016-02-10 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `hrsys_vac_offeringsallary`
--

CREATE TABLE `hrsys_vac_offeringsallary` (
  `vacancy_trl_id` varchar(30) NOT NULL,
  `current_salary` bigint(20) DEFAULT NULL,
  `current_ccy` varchar(5) DEFAULT NULL,
  `expected_salary` bigint(20) DEFAULT NULL,
  `expected_ccy` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hrsys_vac_offeringsallary`
--

INSERT INTO `hrsys_vac_offeringsallary` (`vacancy_trl_id`, `current_salary`, `current_ccy`, `expected_salary`, `expected_ccy`) VALUES
('145610685956ca6d6b361ba', 10000000, 'IDR', 15000000, 'IDR'),
('145638638756ceb15305ddf', 0, 'IDR', 0, 'IDR');

-- --------------------------------------------------------

--
-- Table structure for table `hrsys_vac_placemented`
--

CREATE TABLE `hrsys_vac_placemented` (
  `vacancy_trl_id` varchar(30) NOT NULL,
  `date_join` date NOT NULL,
  `salary` bigint(20) NOT NULL,
  `salary_ccy` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hrsys_vac_placemented`
--

INSERT INTO `hrsys_vac_placemented` (`vacancy_trl_id`, `date_join`, `salary`, `salary_ccy`) VALUES
('145610689756ca6d9101cec', '2016-05-15', 15000000, 'IDR'),
('145638639156ceb1574a54b', '2016-02-26', 10000000, 'IDR');

-- --------------------------------------------------------

--
-- Table structure for table `tpl_lookup`
--

CREATE TABLE `tpl_lookup` (
  `lookup_id` bigint(20) UNSIGNED NOT NULL,
  `value` varchar(50) DEFAULT NULL,
  `display_text` varchar(100) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `order_num` int(11) DEFAULT NULL,
  `datecreate` datetime DEFAULT NULL,
  `usercreate` varchar(30) DEFAULT NULL,
  `dateupdate` datetime DEFAULT NULL,
  `userupdate` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tpl_lookup`
--

INSERT INTO `tpl_lookup` (`lookup_id`, `value`, `display_text`, `type`, `order_num`, `datecreate`, `usercreate`, `dateupdate`, `userupdate`) VALUES
(1, '1', 'Active', 'active_non', 1, '2014-12-30 10:07:40', NULL, '2016-01-07 09:59:59', '142274855454cd6b8aeea54'),
(2, '0', 'Non Active', 'active_non', 2, '2014-12-30 10:07:40', NULL, NULL, NULL),
(7, 'm', 'Male', 'sex', 1, '2015-01-27 10:42:19', 'admin', '2015-01-27 10:42:19', NULL),
(8, 'f', 'Female', 'sex', 2, '2015-01-27 10:42:42', 'admin', '2015-01-27 10:42:45', 'admin'),
(9, '0', 'Prospect', 'cmpyclient_stat', 1, '2015-01-31 10:53:38', 'admin', '2015-01-31 10:53:38', NULL),
(10, '1', 'Client', 'cmpyclient_stat', 2, '2015-01-31 10:54:06', 'admin', '2015-12-15 09:01:36', '142274855454cd6b8aeea54'),
(11, '1', 'Regular Meeting', 'meet_type', 1, '2015-02-06 14:33:43', 'admin', '2015-02-06 14:44:00', 'admin'),
(12, '2', 'Assign contract', 'meet_type', 2, '2015-02-06 14:34:50', 'admin', '2015-02-06 14:44:27', 'admin'),
(13, '1', 'Complited', 'meet_outcome', 1, '2015-02-06 14:39:13', 'admin', '2015-02-06 14:42:58', 'admin'),
(14, '2', 'Canceled', 'meet_outcome', 2, '2015-02-06 14:39:36', 'admin', '2015-02-06 14:43:02', 'admin'),
(15, '4', 'Reschedule', 'meet_outcome', 4, '2015-02-06 14:40:31', 'admin', '2015-02-06 14:43:25', 'admin'),
(16, '3', 'Assigned Contract', 'meet_outcome', 3, '2015-02-06 14:42:19', 'admin', '2015-02-06 14:43:17', 'admin'),
(17, 'meeting', 'Meeting', 'trail', 1, '2015-02-09 14:49:37', '142199935954c1fcffd9501', '2015-02-09 14:49:37', NULL),
(18, 'vacancy', 'Vacancy', 'trail', 2, '2015-02-09 14:51:21', '142199935954c1fcffd9501', '2015-02-09 14:51:21', NULL),
(19, '1', 'Open Vacancy', 'vacancy_stat', 1, '2015-02-22 06:49:28', '142199957054c1fdd26eca3', '2015-02-22 06:49:28', NULL),
(20, '0', 'Close Vacancy', 'vacancy_stat', 2, '2015-02-22 06:49:50', '142199957054c1fdd26eca3', '2015-02-22 06:49:50', NULL),
(21, '1', 'Open', 'candidate_stat', 1, '2015-02-25 13:46:23', '142199957054c1fdd26eca3', '2015-02-25 13:46:23', NULL),
(22, '0', 'Close', 'candidate_stat', 2, '2015-02-25 13:46:47', '142199957054c1fdd26eca3', '2015-02-25 13:46:47', NULL),
(23, '1', 'Short List', 'applicant_stat', 1, '2015-02-25 13:55:46', '142199957054c1fdd26eca3', '2015-02-25 13:55:46', NULL),
(24, '2', 'Process of Interview', 'applicant_stat', 2, '2015-02-25 13:58:04', '142199957054c1fdd26eca3', '2015-02-25 14:23:37', '142199957054c1fdd26eca3'),
(25, '4', 'Offering Salary', 'applicant_stat', 4, '2015-02-25 14:08:46', '142199957054c1fdd26eca3', '2015-12-16 12:45:06', '142274855454cd6b8aeea54'),
(26, '5', 'Rejected From Candidate', 'applicant_stat', 5, '2015-02-25 14:10:00', '142199957054c1fdd26eca3', '2015-04-02 14:07:54', '142274855454cd6b8aeea54'),
(27, '6', 'Rejected From Client', 'applicant_stat', 6, '2015-02-25 14:16:46', '142199957054c1fdd26eca3', '2015-04-02 14:08:00', '142274855454cd6b8aeea54'),
(28, '7', 'Not Qualified', 'applicant_stat', 7, '2015-02-25 14:27:42', '142199957054c1fdd26eca3', '2015-04-02 14:08:06', '142274855454cd6b8aeea54'),
(29, '8', 'Placemented', 'applicant_stat', 8, '2015-02-25 14:36:05', '142199957054c1fdd26eca3', '2015-04-02 14:08:11', '142274855454cd6b8aeea54'),
(30, '3', 'Process To Client', 'applicant_stat', 3, '2015-04-02 14:07:19', '142274855454cd6b8aeea54', '2015-04-02 14:07:30', '142274855454cd6b8aeea54'),
(31, '1', 'By Phone', 'interview_type', 1, '2015-12-28 15:08:48', '142274855454cd6b8aeea54', '2015-12-28 15:08:48', NULL),
(32, '2', 'On Site', 'interview_type', 2, '2015-12-28 15:08:59', '142274855454cd6b8aeea54', '2015-12-28 15:08:59', NULL),
(33, 'IDR', 'IDR', 'ccy', 1, '2016-01-04 15:14:47', '142274855454cd6b8aeea54', '2016-01-04 15:15:11', '142274855454cd6b8aeea54'),
(34, 'USD', 'USD', 'ccy', 2, '2016-01-04 15:15:04', '142274855454cd6b8aeea54', '2016-01-04 15:15:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tpl_menu`
--

CREATE TABLE `tpl_menu` (
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `menu_title` varchar(100) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `attributes` varchar(250) DEFAULT NULL,
  `order_num` int(11) DEFAULT NULL,
  `active_non` tinyint(4) DEFAULT NULL,
  `role_id` varchar(100) DEFAULT NULL,
  `datecreate` datetime DEFAULT NULL,
  `usercreate` varchar(30) DEFAULT NULL,
  `dateupdate` datetime DEFAULT NULL,
  `userupdate` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tpl_menu`
--

INSERT INTO `tpl_menu` (`menu_id`, `menu_title`, `url`, `parent_id`, `attributes`, `order_num`, `active_non`, `role_id`, `datecreate`, `usercreate`, `dateupdate`, `userupdate`) VALUES
(1, 'Administrator Menu', '', 0, '', 8, 1, '', NULL, NULL, '2016-02-22 11:53:34', '142199935954c1fcffd9501'),
(2, 'User', '/admin/user', 1, '', 2, 1, 'adm_user', NULL, NULL, '2015-01-26 09:24:04', NULL),
(3, 'Lookup', '/admin/lookup', 1, '', 3, 1, 'adm_lookup', NULL, NULL, '2015-01-27 09:26:11', NULL),
(4, 'Menu', '/admin/menu', 1, '', 4, 1, 'adm_menu', NULL, NULL, '2015-01-26 09:23:53', NULL),
(8, 'Role', '/admin/role', 1, '', 1, 1, 'adm_role', '2015-01-12 16:43:50', NULL, '2015-01-26 09:20:43', NULL),
(9, 'Home', '/home/main_home', 0, '', 1, 1, '', '2015-01-26 09:27:06', NULL, '2015-01-27 09:36:19', NULL),
(10, 'Calendar', '/hrsys/calendar', 0, '', 2, 1, '', '2015-01-26 09:27:37', NULL, '2015-02-25 22:03:47', '142199957054c1fdd26eca3'),
(12, 'Client', '', 0, '', 5, 1, '', '2015-01-31 10:57:52', 'admin', '2015-02-25 21:54:55', '142199957054c1fdd26eca3'),
(13, 'New Client', 'hrsys/client/addEditClient', 12, '', 1, 1, '', '2015-01-31 10:58:53', 'admin', '2016-01-20 11:17:17', '142199935954c1fcffd9501'),
(14, 'Prospect Client', 'hrsys/client/prospect', 12, '', 2, 1, '', '2015-01-31 11:01:54', 'admin', '2015-01-31 11:37:57', 'admin'),
(15, 'My Client', 'hrsys/client/myclient', 12, '', 3, 1, '', '2015-01-31 11:10:51', 'admin', '2015-01-31 11:38:06', 'admin'),
(16, 'All Client', 'hrsys/client/allclient', 12, '', 4, 1, '', '2015-01-31 11:12:40', 'admin', '2015-02-01 14:45:54', 'admin'),
(17, 'My Dashboard', '/hrsys/dashboard/myDasboard', 0, '', 3, 0, '', '2015-02-24 17:25:32', '142199957054c1fdd26eca3', '2016-02-10 11:36:25', '142199935954c1fcffd9501'),
(18, 'Candidates', '', 0, '', 6, 1, '', '2015-02-24 21:34:54', '142199957054c1fdd26eca3', '2015-02-25 21:55:01', '142199957054c1fdd26eca3'),
(19, 'New Candidate', 'hrsys/candidate/addEditCandidate', 18, '', 1, 1, '', '2015-02-24 21:36:54', '142199957054c1fdd26eca3', '2015-02-24 22:28:16', '142199957054c1fdd26eca3'),
(20, 'Search Candidate', 'hrsys/candidate/listCandidate', 18, '', 2, 1, '', '2015-02-24 21:39:17', '142199957054c1fdd26eca3', '2015-02-24 22:27:33', '142199957054c1fdd26eca3'),
(21, 'Executive Dashboard', '/', 0, '', 4, 0, '', '2015-02-25 21:54:29', '142199957054c1fdd26eca3', '2016-02-10 11:36:39', '142199935954c1fcffd9501'),
(22, 'Inactive Client', 'hrsys/client/inactive', 12, '', 5, 1, '', '2015-12-15 09:40:06', '142274855454cd6b8aeea54', '2015-12-15 09:41:24', '142274855454cd6b8aeea54'),
(23, 'Consultant', '/admin/consultant', 1, '', 5, 1, 'adm_consultant', '2016-01-18 10:01:32', '142199935954c1fcffd9501', '2016-01-19 17:20:14', '142199935954c1fcffd9501'),
(24, 'Config', '', 0, '', 9, 1, 'hrsys_config', '2016-01-20 11:15:27', '142199935954c1fcffd9501', '2016-02-22 11:53:38', '142199935954c1fcffd9501'),
(25, 'User Management', 'hrsys/user/index', 24, '', 1, 1, 'hrsys_config', '2016-01-20 11:16:01', '142199935954c1fcffd9501', '2016-01-20 14:53:10', '142199935954c1fcffd9501'),
(26, 'Invoice', '', 0, '', 7, 1, '', '2016-02-22 11:53:27', '142199935954c1fcffd9501', '2016-02-22 12:07:34', '142199935954c1fcffd9501'),
(29, 'Create Invoice', 'hrsys/invoice/create_invoice', 26, '', 1, 1, '', '2016-02-22 12:06:54', '142199935954c1fcffd9501', '2016-02-22 14:49:15', '142199935954c1fcffd9501'),
(30, 'Search Invoice', 'hrsys/invoice/list_invoice', 26, '', 2, 1, '', '2016-02-22 12:07:05', '142199935954c1fcffd9501', '2016-02-22 14:49:07', '142199935954c1fcffd9501');

-- --------------------------------------------------------

--
-- Table structure for table `tpl_role`
--

CREATE TABLE `tpl_role` (
  `role_id` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `datecreate` datetime DEFAULT NULL,
  `usercreate` varchar(30) DEFAULT NULL,
  `dateupdate` datetime DEFAULT NULL,
  `userupdate` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tpl_role`
--

INSERT INTO `tpl_role` (`role_id`, `name`, `datecreate`, `usercreate`, `dateupdate`, `userupdate`) VALUES
('adm_consultant', 'Admin Consultant', '2016-01-18 10:07:21', '142199935954c1fcffd9501', '2016-01-18 10:07:21', NULL),
('adm_lookup', 'Admin Lookup', '2015-01-12 16:58:15', NULL, '2015-01-12 16:58:15', NULL),
('adm_menu', 'Admin Menu', '2015-01-12 16:58:27', NULL, '2015-01-12 16:58:49', NULL),
('adm_role', 'Admin Role', '2015-01-12 16:58:37', NULL, '2015-01-12 17:03:58', NULL),
('adm_user', 'Admin User', '2015-01-12 16:58:03', NULL, '2015-01-12 16:58:03', NULL),
('hrsys_allclient', 'Full Access Client', '2015-02-26 14:17:26', '142274855454cd6b8aeea54', '2015-02-26 14:17:26', NULL),
('hrsys_allinvoice', 'Full Access Invoice', '2016-02-22 16:24:30', '142199935954c1fcffd9501', '2016-02-22 16:24:30', NULL),
('hrsys_allmeeting', 'Full Access Meeting', '2015-02-11 10:19:51', '142199935954c1fcffd9501', '2015-02-11 10:19:51', NULL),
('hrsys_allvacancies', 'Full Access Vacancies', '2015-02-26 13:29:32', '142274855454cd6b8aeea54', '2015-02-26 13:29:32', NULL),
('hrsys_config', 'Config System', '2016-01-19 10:34:49', '142199935954c1fcffd9501', '2016-01-19 10:34:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tpl_user`
--

CREATE TABLE `tpl_user` (
  `user_id` varchar(30) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(35) DEFAULT NULL,
  `active_non` tinyint(4) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `datecreate` datetime DEFAULT NULL,
  `usercreate` varchar(30) DEFAULT NULL,
  `dateupdate` datetime DEFAULT NULL,
  `userupdate` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tpl_user`
--

INSERT INTO `tpl_user` (`user_id`, `username`, `password`, `active_non`, `last_login`, `datecreate`, `usercreate`, `dateupdate`, `userupdate`) VALUES
('142199935954c1fcffd9501', 'admin', '21232f297a57a5a743894a0e4a801fc3', 1, '2016-03-23 14:45:06', '2015-01-23 14:48:55', NULL, '2016-01-19 17:18:55', '142199935954c1fcffd9501'),
('1453174328569dae389aaf1', 'rika@bgc.co.id', 'e32994c67f9a773e841f9e97bd26f014', 1, '2016-04-25 13:50:40', '2016-01-19 10:32:08', '142199935954c1fcffd9501', '2016-02-22 16:24:53', '1453174328569dae389aaf1'),
('145336289156a08ecb92c76', 'rika@bgc.sg', 'e32994c67f9a773e841f9e97bd26f014', 1, '2016-01-26 17:15:18', '2016-01-21 14:54:51', '142199935954c1fcffd9501', '2016-01-26 17:15:07', '142199935954c1fcffd9501'),
('145336425756a09421c5c89', 'gun@bgc.co.id', 'c4ca4238a0b923820dcc509a6f75849b', 1, '2016-01-26 17:13:31', '2016-01-21 15:17:37', '1453174328569dae389aaf1', '2016-01-25 10:12:19', '1453174328569dae389aaf1');

-- --------------------------------------------------------

--
-- Table structure for table `tpl_user_role`
--

CREATE TABLE `tpl_user_role` (
  `user_id` varchar(30) NOT NULL,
  `role_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tpl_user_role`
--

INSERT INTO `tpl_user_role` (`user_id`, `role_id`) VALUES
('142199935954c1fcffd9501', 'adm_consultant'),
('142199935954c1fcffd9501', 'adm_lookup'),
('142199935954c1fcffd9501', 'adm_menu'),
('142199935954c1fcffd9501', 'adm_role'),
('142199935954c1fcffd9501', 'adm_user'),
('142199935954c1fcffd9501', 'hrsys_config'),
('142199951854c1fd9eb3f49', 'adm_lookup'),
('142199951854c1fd9eb3f49', 'adm_menu'),
('142199961154c1fdfb402d4', 'adm_lookup'),
('142199961154c1fdfb402d4', 'adm_menu'),
('142199961154c1fdfb402d4', 'adm_role'),
('142200025654c200803ce9e', 'adm_lookup'),
('142200025654c200803ce9e', 'adm_menu'),
('142200060654c201de9f09d', 'adm_lookup'),
('142200060654c201de9f09d', 'adm_menu'),
('1453174328569dae389aaf1', 'hrsys_allclient'),
('1453174328569dae389aaf1', 'hrsys_allinvoice'),
('1453174328569dae389aaf1', 'hrsys_allmeeting'),
('1453174328569dae389aaf1', 'hrsys_allvacancies'),
('1453174328569dae389aaf1', 'hrsys_config'),
('145336289156a08ecb92c76', 'hrsys_config');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `last_activity_idx` (`last_activity`);

--
-- Indexes for table `hrsys_candidate`
--
ALTER TABLE `hrsys_candidate`
  ADD PRIMARY KEY (`candidate_id`);

--
-- Indexes for table `hrsys_candidate_doc`
--
ALTER TABLE `hrsys_candidate_doc`
  ADD PRIMARY KEY (`candidate_doc_id`);

--
-- Indexes for table `hrsys_candidate_trl`
--
ALTER TABLE `hrsys_candidate_trl`
  ADD PRIMARY KEY (`candidate_trl_id`);

--
-- Indexes for table `hrsys_cmpyclient`
--
ALTER TABLE `hrsys_cmpyclient`
  ADD PRIMARY KEY (`cmpyclient_id`);

--
-- Indexes for table `hrsys_cmpyclient_ctrk`
--
ALTER TABLE `hrsys_cmpyclient_ctrk`
  ADD PRIMARY KEY (`cmpyclient_ctrk_id`);

--
-- Indexes for table `hrsys_cmpyclient_meet`
--
ALTER TABLE `hrsys_cmpyclient_meet`
  ADD PRIMARY KEY (`meet_id`);

--
-- Indexes for table `hrsys_cmpyclient_note`
--
ALTER TABLE `hrsys_cmpyclient_note`
  ADD PRIMARY KEY (`note_id`);

--
-- Indexes for table `hrsys_cmpyclient_trl`
--
ALTER TABLE `hrsys_cmpyclient_trl`
  ADD PRIMARY KEY (`cmpyclient_trl_id`);

--
-- Indexes for table `hrsys_consultant`
--
ALTER TABLE `hrsys_consultant`
  ADD PRIMARY KEY (`consultant_code`);

--
-- Indexes for table `hrsys_employee`
--
ALTER TABLE `hrsys_employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrsys_formula`
--
ALTER TABLE `hrsys_formula`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrsys_invoice`
--
ALTER TABLE `hrsys_invoice`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `hrsys_schedule`
--
ALTER TABLE `hrsys_schedule`
  ADD PRIMARY KEY (`schedule_id`);

--
-- Indexes for table `hrsys_scheduleuser`
--
ALTER TABLE `hrsys_scheduleuser`
  ADD PRIMARY KEY (`schedule_id`,`user_id`);

--
-- Indexes for table `hrsys_vacancy`
--
ALTER TABLE `hrsys_vacancy`
  ADD PRIMARY KEY (`vacancy_id`);

--
-- Indexes for table `hrsys_vacancycandidate`
--
ALTER TABLE `hrsys_vacancycandidate`
  ADD PRIMARY KEY (`vacancycandidate_id`);

--
-- Indexes for table `hrsys_vacancyuser`
--
ALTER TABLE `hrsys_vacancyuser`
  ADD PRIMARY KEY (`vacancy_id`,`user_id`);

--
-- Indexes for table `hrsys_vacancy_trl`
--
ALTER TABLE `hrsys_vacancy_trl`
  ADD PRIMARY KEY (`trl_id`);

--
-- Indexes for table `hrsys_vac_interview`
--
ALTER TABLE `hrsys_vac_interview`
  ADD PRIMARY KEY (`vacancy_trl_id`);

--
-- Indexes for table `hrsys_vac_offeringsallary`
--
ALTER TABLE `hrsys_vac_offeringsallary`
  ADD PRIMARY KEY (`vacancy_trl_id`);

--
-- Indexes for table `hrsys_vac_placemented`
--
ALTER TABLE `hrsys_vac_placemented`
  ADD PRIMARY KEY (`vacancy_trl_id`);

--
-- Indexes for table `tpl_lookup`
--
ALTER TABLE `tpl_lookup`
  ADD PRIMARY KEY (`lookup_id`);

--
-- Indexes for table `tpl_menu`
--
ALTER TABLE `tpl_menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `tpl_role`
--
ALTER TABLE `tpl_role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `tpl_user`
--
ALTER TABLE `tpl_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tpl_user_role`
--
ALTER TABLE `tpl_user_role`
  ADD PRIMARY KEY (`user_id`,`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hrsys_formula`
--
ALTER TABLE `hrsys_formula`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tpl_lookup`
--
ALTER TABLE `tpl_lookup`
  MODIFY `lookup_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `tpl_menu`
--
ALTER TABLE `tpl_menu`
  MODIFY `menu_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
