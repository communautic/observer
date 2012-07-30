-- phpMyAdmin SQL Dump
-- version 2.11.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 30, 2012 at 08:07 PM
-- Server version: 5.0.95
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `co_active_guests`
--

CREATE TABLE IF NOT EXISTS `co_active_guests` (
  `ip` varchar(15) NOT NULL,
  `timestamp` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_active_guests`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_active_users`
--

CREATE TABLE IF NOT EXISTS `co_active_users` (
  `uid` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `timestamp` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_active_users`
--

INSERT INTO `co_active_users` (`uid`, `username`, `timestamp`) VALUES
(2, 'grandolf', 1343678801);

-- --------------------------------------------------------

--
-- Table structure for table `co_banned_users`
--

CREATE TABLE IF NOT EXISTS `co_banned_users` (
  `username` varchar(30) NOT NULL,
  `timestamp` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_banned_users`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_brainstorms`
--

CREATE TABLE IF NOT EXISTS `co_brainstorms` (
  `id` int(11) NOT NULL auto_increment,
  `folder` int(11) default NULL,
  `title` text NOT NULL,
  `created_date` datetime default NULL,
  `created_user` int(11) default NULL,
  `edited_date` datetime default NULL,
  `edited_user` int(11) default NULL,
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `folder` (`folder`),
  KEY `bin` (`bin`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `co_brainstorms`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_brainstorms_access`
--

CREATE TABLE IF NOT EXISTS `co_brainstorms_access` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) NOT NULL default '0',
  `admins` varchar(200) NOT NULL,
  `guests` varchar(200) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_user` int(11) NOT NULL,
  `edited_date` datetime NOT NULL,
  `edited_user` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
  KEY `admins` (`admins`),
  KEY `guests` (`guests`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `co_brainstorms_access`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_brainstorms_desktop`
--

CREATE TABLE IF NOT EXISTS `co_brainstorms_desktop` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `perm` tinyint(1) NOT NULL default '0',
  `status` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `uid` (`uid`),
  KEY `pid` (`pid`),
  KEY `status` (`status`),
  KEY `perm` (`perm`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `co_brainstorms_desktop`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_brainstorms_desktop_settings`
--

CREATE TABLE IF NOT EXISTS `co_brainstorms_desktop_settings` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `co_brainstorms_desktop_settings`
--

INSERT INTO `co_brainstorms_desktop_settings` (`id`, `uid`, `value`) VALUES
(1, 2, '');

-- --------------------------------------------------------

--
-- Table structure for table `co_brainstorms_documents`
--

CREATE TABLE IF NOT EXISTS `co_brainstorms_documents` (
  `id` int(11) NOT NULL auto_increment,
  `did` int(11) default NULL,
  `filename` varchar(100) default NULL,
  `tempname` varchar(50) default NULL,
  `filesize` int(11) default NULL,
  `emailed_to` varchar(200) NOT NULL,
  `access` tinyint(1) default '0',
  `access_date` datetime NOT NULL,
  `access_user` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_user` int(11) NOT NULL,
  `edited_date` datetime NOT NULL,
  `edited_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `bin` (`bin`),
  KEY `did` (`did`),
  KEY `access` (`access`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `co_brainstorms_documents`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_brainstorms_documents_folders`
--

CREATE TABLE IF NOT EXISTS `co_brainstorms_documents_folders` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) default NULL,
  `title` varchar(250) default NULL,
  `emailed_to` varchar(200) NOT NULL,
  `access` tinyint(1) default '0',
  `access_date` datetime NOT NULL,
  `access_user` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_user` int(11) NOT NULL,
  `edited_date` datetime NOT NULL,
  `edited_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
  KEY `bin` (`bin`),
  KEY `access` (`access`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `co_brainstorms_documents_folders`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_brainstorms_folders`
--

CREATE TABLE IF NOT EXISTS `co_brainstorms_folders` (
  `id` int(11) NOT NULL auto_increment,
  `title` text NOT NULL,
  `status` tinyint(4) default '0',
  `created_date` datetime default NULL,
  `created_user` int(11) NOT NULL,
  `edited_date` datetime default NULL,
  `edited_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `status` (`status`),
  KEY `bin` (`bin`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `co_brainstorms_folders`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_brainstorms_grids`
--

CREATE TABLE IF NOT EXISTS `co_brainstorms_grids` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) default NULL,
  `title` text,
  `owner` varchar(250) NOT NULL,
  `owner_ct` varchar(250) NOT NULL,
  `management` varchar(250) NOT NULL,
  `management_ct` varchar(250) NOT NULL,
  `team` varchar(250) NOT NULL,
  `team_ct` varchar(250) NOT NULL,
  `access` tinyint(1) NOT NULL default '0',
  `access_date` datetime NOT NULL,
  `access_user` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_user` int(11) NOT NULL,
  `edited_date` datetime NOT NULL,
  `edited_user` int(11) NOT NULL,
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
  KEY `access` (`access`),
  KEY `bin` (`bin`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `co_brainstorms_grids`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_brainstorms_grids_columns`
--

CREATE TABLE IF NOT EXISTS `co_brainstorms_grids_columns` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) default NULL,
  `sort` tinyint(3) NOT NULL,
  `days` tinyint(3) NOT NULL default '0',
  `created_date` datetime NOT NULL,
  `created_user` int(11) NOT NULL,
  `edited_date` datetime NOT NULL,
  `edited_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
  KEY `bin` (`bin`),
  KEY `sort` (`sort`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `co_brainstorms_grids_columns`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_brainstorms_grids_log`
--

CREATE TABLE IF NOT EXISTS `co_brainstorms_grids_log` (
  `id` int(11) NOT NULL auto_increment,
  `rid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `fid` int(11) NOT NULL,
  `created_user` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `rid` (`rid`,`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `co_brainstorms_grids_log`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_brainstorms_grids_notes`
--

CREATE TABLE IF NOT EXISTS `co_brainstorms_grids_notes` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `sort` tinyint(3) NOT NULL default '0',
  `istitle` tinyint(1) NOT NULL default '0',
  `isstagegate` tinyint(1) NOT NULL default '0',
  `title` text NOT NULL,
  `text` text,
  `status` tinyint(1) NOT NULL default '0',
  `created_date` datetime default NULL,
  `created_user` int(11) default NULL,
  `edited_user` int(11) default NULL,
  `edited_date` datetime default NULL,
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `bin` (`bin`),
  KEY `cid` (`cid`),
  KEY `pid` (`pid`),
  KEY `sort` (`sort`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `co_brainstorms_grids_notes`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_brainstorms_meetings`
--

CREATE TABLE IF NOT EXISTS `co_brainstorms_meetings` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) default NULL,
  `title` text,
  `item_date` datetime default NULL,
  `start` datetime default NULL,
  `end` datetime default NULL,
  `location` varchar(100) default NULL,
  `location_ct` varchar(100) NOT NULL,
  `length` varchar(5) default NULL,
  `management` varchar(100) default NULL,
  `management_ct` varchar(100) NOT NULL,
  `participants` varchar(100) default NULL,
  `participants_ct` varchar(100) NOT NULL,
  `protocol` text,
  `status` tinyint(1) default '0',
  `status_date` datetime default NULL,
  `relates_to` int(11) default NULL,
  `documents` varchar(100) NOT NULL,
  `emailed_to` varchar(200) NOT NULL,
  `access` tinyint(1) default '0',
  `access_date` datetime default NULL,
  `access_user` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_user` int(11) NOT NULL,
  `edited_date` datetime NOT NULL,
  `edited_user` int(11) NOT NULL,
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
  KEY `status` (`status`),
  KEY `access` (`access`),
  KEY `bin` (`bin`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `co_brainstorms_meetings`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_brainstorms_meetings_tasks`
--

CREATE TABLE IF NOT EXISTS `co_brainstorms_meetings_tasks` (
  `id` int(11) NOT NULL auto_increment,
  `mid` int(11) NOT NULL,
  `status` int(1) default NULL,
  `title` varchar(200) default NULL,
  `text` text NOT NULL,
  `sort` tinyint(2) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` tinyint(4) default NULL,
  PRIMARY KEY  (`id`),
  KEY `mid` (`mid`),
  KEY `status` (`status`),
  KEY `sort` (`sort`),
  KEY `bin` (`bin`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `co_brainstorms_meetings_tasks`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_brainstorms_notes`
--

CREATE TABLE IF NOT EXISTS `co_brainstorms_notes` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) default '0',
  `title` text NOT NULL,
  `text` text,
  `xyz` varchar(20) NOT NULL,
  `wh` varchar(20) NOT NULL,
  `toggle` tinyint(1) NOT NULL default '0',
  `created_date` datetime default NULL,
  `created_user` int(11) default NULL,
  `edited_user` int(11) default NULL,
  `edited_date` datetime default NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
  KEY `bin` (`bin`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `co_brainstorms_notes`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_brainstorms_rosters`
--

CREATE TABLE IF NOT EXISTS `co_brainstorms_rosters` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) default NULL,
  `title` text,
  `access` tinyint(1) NOT NULL default '0',
  `access_date` datetime NOT NULL,
  `access_user` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_user` int(11) NOT NULL,
  `edited_date` datetime NOT NULL,
  `edited_user` int(11) NOT NULL,
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
  KEY `access` (`access`),
  KEY `bin` (`bin`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `co_brainstorms_rosters`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_brainstorms_rosters_columns`
--

CREATE TABLE IF NOT EXISTS `co_brainstorms_rosters_columns` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) default NULL,
  `sort` tinyint(3) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_user` int(11) NOT NULL,
  `edited_date` datetime NOT NULL,
  `edited_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
  KEY `sort` (`sort`),
  KEY `bin` (`bin`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `co_brainstorms_rosters_columns`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_brainstorms_rosters_log`
--

CREATE TABLE IF NOT EXISTS `co_brainstorms_rosters_log` (
  `id` int(11) NOT NULL auto_increment,
  `rid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `fid` int(11) NOT NULL,
  `created_user` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `rid` (`rid`,`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `co_brainstorms_rosters_log`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_brainstorms_rosters_notes`
--

CREATE TABLE IF NOT EXISTS `co_brainstorms_rosters_notes` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `sort` tinyint(3) NOT NULL default '0',
  `title` text NOT NULL,
  `text` text,
  `ms` tinyint(1) NOT NULL default '0',
  `created_date` datetime default NULL,
  `created_user` int(11) default NULL,
  `edited_user` int(11) default NULL,
  `edited_date` datetime default NULL,
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `bin` (`bin`),
  KEY `cid` (`cid`),
  KEY `pid` (`pid`),
  KEY `sort` (`sort`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `co_brainstorms_rosters_notes`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_brainstorms_vdocs`
--

CREATE TABLE IF NOT EXISTS `co_brainstorms_vdocs` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) default NULL,
  `title` text,
  `content` longtext NOT NULL,
  `relates_to` int(11) default NULL,
  `access` tinyint(1) default '0',
  `access_date` datetime default NULL,
  `access_user` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_user` int(11) NOT NULL,
  `edited_date` datetime NOT NULL,
  `edited_user` int(11) NOT NULL,
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
  KEY `bin` (`bin`),
  KEY `access` (`access`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `co_brainstorms_vdocs`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_clients`
--

CREATE TABLE IF NOT EXISTS `co_clients` (
  `id` int(11) NOT NULL auto_increment,
  `folder` int(11) default NULL,
  `title` text NOT NULL,
  `management` varchar(100) default NULL,
  `management_ct` varchar(100) NOT NULL,
  `team` varchar(100) NOT NULL,
  `team_ct` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `address_ct` varchar(100) NOT NULL,
  `billingaddress` varchar(100) NOT NULL,
  `billingaddress_ct` varchar(100) NOT NULL,
  `protocol` text,
  `contract` tinyint(1) NOT NULL,
  `status` tinyint(1) default '0',
  `planned_date` date default NULL,
  `inprogress_date` date default NULL,
  `finished_date` date default NULL,
  `stopped_date` date default NULL,
  `days` varchar(5) default NULL,
  `emailed_to` varchar(100) NOT NULL,
  `created_date` datetime default NULL,
  `created_user` int(11) default NULL,
  `edited_date` datetime default NULL,
  `edited_user` int(11) default NULL,
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `bin` (`bin`),
  KEY `folder` (`folder`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `co_clients`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_clients_access`
--

CREATE TABLE IF NOT EXISTS `co_clients_access` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) NOT NULL default '0',
  `admins` varchar(200) NOT NULL,
  `guests` varchar(200) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_user` int(11) NOT NULL,
  `edited_date` datetime NOT NULL,
  `edited_user` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
  KEY `admins` (`admins`),
  KEY `guests` (`guests`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `co_clients_access`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_clients_documents`
--

CREATE TABLE IF NOT EXISTS `co_clients_documents` (
  `id` int(11) NOT NULL auto_increment,
  `did` int(11) default NULL,
  `filename` varchar(100) default NULL,
  `tempname` varchar(50) default NULL,
  `filesize` int(11) default NULL,
  `emailed_to` varchar(200) NOT NULL,
  `access` tinyint(1) default '0',
  `access_date` datetime NOT NULL,
  `access_user` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_user` int(11) NOT NULL,
  `edited_date` datetime NOT NULL,
  `edited_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `bin` (`bin`),
  KEY `did` (`did`),
  KEY `access` (`access`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `co_clients_documents`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_clients_documents_folders`
--

CREATE TABLE IF NOT EXISTS `co_clients_documents_folders` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) default NULL,
  `title` varchar(250) default NULL,
  `emailed_to` varchar(200) NOT NULL,
  `access` tinyint(1) default '0',
  `access_date` datetime NOT NULL,
  `access_user` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_user` int(11) NOT NULL,
  `edited_date` datetime NOT NULL,
  `edited_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
  KEY `bin` (`bin`),
  KEY `access` (`access`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `co_clients_documents_folders`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_clients_folders`
--

CREATE TABLE IF NOT EXISTS `co_clients_folders` (
  `id` int(11) NOT NULL auto_increment,
  `title` text NOT NULL,
  `status` tinyint(4) default '0',
  `created_date` datetime default NULL,
  `created_user` int(11) NOT NULL,
  `edited_date` datetime default NULL,
  `edited_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `status` (`status`),
  KEY `bin` (`bin`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `co_clients_folders`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_clients_meetings`
--

CREATE TABLE IF NOT EXISTS `co_clients_meetings` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) default NULL,
  `title` text,
  `item_date` datetime default NULL,
  `start` datetime default NULL,
  `end` datetime default NULL,
  `location` varchar(100) default NULL,
  `location_ct` varchar(100) NOT NULL,
  `length` varchar(5) default NULL,
  `management` varchar(100) default NULL,
  `management_ct` varchar(100) NOT NULL,
  `participants` varchar(100) default NULL,
  `participants_ct` varchar(100) NOT NULL,
  `protocol` text,
  `status` tinyint(1) default '0',
  `status_date` datetime default NULL,
  `relates_to` int(11) default NULL,
  `documents` varchar(100) NOT NULL,
  `emailed_to` varchar(200) NOT NULL,
  `access` tinyint(1) default '0',
  `access_date` datetime default NULL,
  `access_user` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_user` int(11) NOT NULL,
  `edited_date` datetime NOT NULL,
  `edited_user` int(11) NOT NULL,
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
  KEY `status` (`status`),
  KEY `access` (`access`),
  KEY `bin` (`bin`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `co_clients_meetings`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_clients_meetings_tasks`
--

CREATE TABLE IF NOT EXISTS `co_clients_meetings_tasks` (
  `id` int(11) NOT NULL auto_increment,
  `mid` int(11) NOT NULL,
  `status` int(1) default NULL,
  `title` varchar(200) default NULL,
  `text` text NOT NULL,
  `sort` tinyint(2) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` tinyint(4) default NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`mid`),
  KEY `status` (`status`),
  KEY `sort` (`sort`),
  KEY `bin` (`bin`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `co_clients_meetings_tasks`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_clients_orders`
--

CREATE TABLE IF NOT EXISTS `co_clients_orders` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) default NULL,
  `oid` int(11) NOT NULL,
  `title` text,
  `mon` smallint(6) NOT NULL default '0',
  `mon_2` smallint(6) NOT NULL default '0',
  `mon_3` smallint(6) NOT NULL default '0',
  `mon_note` varchar(100) NOT NULL,
  `tue` smallint(6) NOT NULL default '0',
  `tue_2` smallint(6) NOT NULL default '0',
  `tue_3` smallint(6) NOT NULL default '0',
  `tue_note` varchar(100) NOT NULL,
  `wed` smallint(6) NOT NULL default '0',
  `wed_2` smallint(6) NOT NULL default '0',
  `wed_3` smallint(6) NOT NULL default '0',
  `wed_note` varchar(100) NOT NULL,
  `thu` smallint(6) NOT NULL default '0',
  `thu_2` smallint(6) NOT NULL default '0',
  `thu_3` smallint(6) NOT NULL default '0',
  `thu_note` varchar(100) NOT NULL,
  `fri` smallint(6) NOT NULL default '0',
  `fri_2` smallint(6) NOT NULL default '0',
  `fri_3` smallint(6) NOT NULL default '0',
  `fri_note` varchar(100) NOT NULL,
  `item_date` datetime default NULL,
  `start` datetime default NULL,
  `end` datetime default NULL,
  `length` varchar(5) default NULL,
  `management` varchar(100) default NULL,
  `management_ct` varchar(100) NOT NULL,
  `protocol` text,
  `status` tinyint(1) default '0',
  `status_date` datetime default NULL,
  `documents` varchar(100) NOT NULL,
  `access` tinyint(1) default '0',
  `access_date` datetime default NULL,
  `access_user` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_user` int(11) NOT NULL,
  `edited_date` datetime NOT NULL,
  `edited_user` int(11) NOT NULL,
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
  KEY `oid` (`oid`),
  KEY `bin` (`bin`),
  KEY `access` (`access`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `co_clients_orders`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_clients_orders_access`
--

CREATE TABLE IF NOT EXISTS `co_clients_orders_access` (
  `id` tinyint(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `pwd_pick` tinyint(1) NOT NULL default '0',
  `userid` varchar(32) default NULL,
  `timestamp` int(11) unsigned NOT NULL,
  `created_user` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `edited_user` int(11) NOT NULL,
  `edited_date` datetime NOT NULL,
  `access_status` tinyint(1) NOT NULL,
  `access_user` int(11) NOT NULL,
  `access_date` datetime NOT NULL,
  `sysadmin_status` tinyint(1) NOT NULL default '0',
  `sysadmin_user` int(11) NOT NULL,
  `sysadmin_date` datetime NOT NULL,
  `bin` tinyint(1) NOT NULL,
  `bintime` datetime NOT NULL,
  `binuser` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `username` (`username`),
  KEY `uid` (`uid`),
  KEY `cid` (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `co_clients_orders_access`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_clients_phonecalls`
--

CREATE TABLE IF NOT EXISTS `co_clients_phonecalls` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) default NULL,
  `title` text,
  `item_date` datetime default NULL,
  `start` datetime default NULL,
  `end` datetime default NULL,
  `length` varchar(5) default NULL,
  `management` varchar(100) default NULL,
  `management_ct` varchar(100) NOT NULL,
  `protocol` text,
  `status` tinyint(1) default '0',
  `status_date` datetime default NULL,
  `documents` varchar(100) NOT NULL,
  `access` tinyint(1) default '0',
  `access_date` datetime default NULL,
  `access_user` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_user` int(11) NOT NULL,
  `edited_date` datetime NOT NULL,
  `edited_user` int(11) NOT NULL,
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
  KEY `status` (`status`),
  KEY `access` (`access`),
  KEY `bin` (`bin`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `co_clients_phonecalls`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_complaints`
--

CREATE TABLE IF NOT EXISTS `co_complaints` (
  `id` int(11) NOT NULL auto_increment,
  `folder` int(11) default NULL,
  `title` text NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `management` varchar(100) default NULL,
  `management_ct` varchar(100) NOT NULL,
  `team` varchar(100) NOT NULL,
  `team_ct` varchar(100) NOT NULL,
  `complaint` varchar(100) NOT NULL,
  `complaint_more` varchar(100) NOT NULL,
  `complaint_cat` varchar(100) NOT NULL,
  `complaint_cat_more` varchar(100) NOT NULL,
  `product` varchar(100) NOT NULL,
  `product_desc` varchar(100) NOT NULL,
  `charge` varchar(100) NOT NULL,
  `number` varchar(100) NOT NULL,
  `protocol` text,
  `ordered_on` date NOT NULL,
  `ordered_by` varchar(100) NOT NULL,
  `ordered_by_ct` varchar(100) NOT NULL,
  `status` tinyint(1) default '0',
  `planned_date` date default NULL,
  `inprogress_date` date default NULL,
  `finished_date` date default NULL,
  `stopped_date` date default NULL,
  `days` varchar(5) default NULL,
  `emailed_to` varchar(100) NOT NULL,
  `created_date` datetime default NULL,
  `created_user` int(11) default NULL,
  `edited_date` datetime default NULL,
  `edited_user` int(11) default NULL,
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `bin` (`bin`),
  KEY `folder` (`folder`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `co_complaints`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_complaints_access`
--

CREATE TABLE IF NOT EXISTS `co_complaints_access` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) NOT NULL default '0',
  `admins` varchar(200) NOT NULL,
  `guests` varchar(200) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_user` int(11) NOT NULL,
  `edited_date` datetime NOT NULL,
  `edited_user` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
  KEY `admins` (`admins`),
  KEY `guests` (`guests`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `co_complaints_access`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_complaints_dialog_cats`
--

CREATE TABLE IF NOT EXISTS `co_complaints_dialog_cats` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `co_complaints_dialog_cats`
--

INSERT INTO `co_complaints_dialog_cats` (`id`, `name`) VALUES
(15, 'Schädlinge'),
(16, 'Fremdkörper Metall'),
(17, 'Fremdkörper sonstige'),
(18, 'Vermischungen'),
(19, 'andere Mängel');

-- --------------------------------------------------------

--
-- Table structure for table `co_complaints_dialog_cats_more`
--

CREATE TABLE IF NOT EXISTS `co_complaints_dialog_cats_more` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `co_complaints_dialog_cats_more`
--

INSERT INTO `co_complaints_dialog_cats_more` (`id`, `name`) VALUES
(1, 'Ja'),
(2, 'Nein');

-- --------------------------------------------------------

--
-- Table structure for table `co_complaints_dialog_complaints`
--

CREATE TABLE IF NOT EXISTS `co_complaints_dialog_complaints` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `co_complaints_dialog_complaints`
--

INSERT INTO `co_complaints_dialog_complaints` (`id`, `name`) VALUES
(3, 'Intern'),
(4, 'Extern');

-- --------------------------------------------------------

--
-- Table structure for table `co_complaints_dialog_complaints_more`
--

CREATE TABLE IF NOT EXISTS `co_complaints_dialog_complaints_more` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `co_complaints_dialog_complaints_more`
--

INSERT INTO `co_complaints_dialog_complaints_more` (`id`, `name`) VALUES
(1, 'Endkonsument'),
(2, 'Gastro'),
(3, 'Industrie'),
(4, 'Zukauf'),
(5, 'Werk'),
(6, 'System');

-- --------------------------------------------------------

--
-- Table structure for table `co_complaints_documents`
--

CREATE TABLE IF NOT EXISTS `co_complaints_documents` (
  `id` int(11) NOT NULL auto_increment,
  `did` int(11) default NULL,
  `filename` varchar(100) default NULL,
  `tempname` varchar(50) default NULL,
  `filesize` int(11) default NULL,
  `emailed_to` varchar(200) NOT NULL,
  `access` tinyint(1) default '0',
  `access_date` datetime NOT NULL,
  `access_user` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_user` int(11) NOT NULL,
  `edited_date` datetime NOT NULL,
  `edited_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `bin` (`bin`),
  KEY `did` (`did`),
  KEY `access` (`access`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `co_complaints_documents`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_complaints_documents_folders`
--

CREATE TABLE IF NOT EXISTS `co_complaints_documents_folders` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) default NULL,
  `title` varchar(250) default NULL,
  `emailed_to` varchar(200) NOT NULL,
  `access` tinyint(1) default '0',
  `access_date` datetime NOT NULL,
  `access_user` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_user` int(11) NOT NULL,
  `edited_date` datetime NOT NULL,
  `edited_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
  KEY `bin` (`bin`),
  KEY `access` (`access`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `co_complaints_documents_folders`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_complaints_folders`
--

CREATE TABLE IF NOT EXISTS `co_complaints_folders` (
  `id` int(11) NOT NULL auto_increment,
  `title` text NOT NULL,
  `status` tinyint(4) default '0',
  `created_date` datetime default NULL,
  `created_user` int(11) NOT NULL,
  `edited_date` datetime default NULL,
  `edited_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `status` (`status`),
  KEY `bin` (`bin`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `co_complaints_folders`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_complaints_forums`
--

CREATE TABLE IF NOT EXISTS `co_complaints_forums` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) default '0',
  `title` text NOT NULL,
  `protocol` text,
  `status` tinyint(1) default '0',
  `planned_date` date default NULL,
  `inprogress_date` date default NULL,
  `finished_date` date default NULL,
  `stopped_date` date NOT NULL,
  `documents` varchar(100) NOT NULL,
  `access` tinyint(1) default '0',
  `access_user` int(11) NOT NULL,
  `access_date` datetime default NULL,
  `created_date` datetime default NULL,
  `created_user` int(11) default NULL,
  `edited_user` int(11) default NULL,
  `edited_date` datetime default NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `bin` (`bin`),
  KEY `folder` (`pid`),
  KEY `status` (`status`),
  KEY `access` (`access`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `co_complaints_forums`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_complaints_forums_posts`
--

CREATE TABLE IF NOT EXISTS `co_complaints_forums_posts` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) NOT NULL,
  `replyid` int(11) default '0',
  `user` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `text` text,
  `status` tinyint(1) NOT NULL default '0',
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
  KEY `bin` (`bin`),
  KEY `replyid` (`replyid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `co_complaints_forums_posts`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_complaints_grids`
--

CREATE TABLE IF NOT EXISTS `co_complaints_grids` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) default NULL,
  `title` text,
  `owner` varchar(250) NOT NULL,
  `owner_ct` varchar(250) NOT NULL,
  `management` varchar(250) NOT NULL,
  `management_ct` varchar(250) NOT NULL,
  `team` varchar(250) NOT NULL,
  `team_ct` varchar(250) NOT NULL,
  `access` tinyint(1) NOT NULL default '0',
  `access_date` datetime NOT NULL,
  `access_user` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_user` int(11) NOT NULL,
  `edited_date` datetime NOT NULL,
  `edited_user` int(11) NOT NULL,
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
  KEY `access` (`access`),
  KEY `bin` (`bin`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `co_complaints_grids`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_complaints_grids_columns`
--

CREATE TABLE IF NOT EXISTS `co_complaints_grids_columns` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) default NULL,
  `sort` tinyint(3) NOT NULL,
  `days` tinyint(3) NOT NULL default '0',
  `created_date` datetime NOT NULL,
  `created_user` int(11) NOT NULL,
  `edited_date` datetime NOT NULL,
  `edited_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
  KEY `bin` (`bin`),
  KEY `sort` (`sort`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `co_complaints_grids_columns`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_complaints_grids_log`
--

CREATE TABLE IF NOT EXISTS `co_complaints_grids_log` (
  `id` int(11) NOT NULL auto_increment,
  `rid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `fid` int(11) NOT NULL,
  `created_user` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `rid` (`rid`,`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `co_complaints_grids_log`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_complaints_grids_notes`
--

CREATE TABLE IF NOT EXISTS `co_complaints_grids_notes` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `sort` tinyint(3) NOT NULL default '0',
  `istitle` tinyint(1) NOT NULL default '0',
  `isstagegate` tinyint(1) NOT NULL default '0',
  `title` text NOT NULL,
  `text` text,
  `status` tinyint(1) NOT NULL default '0',
  `created_date` datetime default NULL,
  `created_user` int(11) default NULL,
  `edited_user` int(11) default NULL,
  `edited_date` datetime default NULL,
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `bin` (`bin`),
  KEY `cid` (`cid`),
  KEY `pid` (`pid`),
  KEY `sort` (`sort`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `co_complaints_grids_notes`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_complaints_meetings`
--

CREATE TABLE IF NOT EXISTS `co_complaints_meetings` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) default NULL,
  `title` text,
  `item_date` datetime default NULL,
  `start` datetime default NULL,
  `end` datetime default NULL,
  `location` varchar(100) default NULL,
  `location_ct` varchar(100) NOT NULL,
  `length` varchar(5) default NULL,
  `management` varchar(100) default NULL,
  `management_ct` varchar(100) NOT NULL,
  `participants` varchar(100) default NULL,
  `participants_ct` varchar(100) NOT NULL,
  `protocol` text,
  `status` tinyint(1) default '0',
  `status_date` datetime default NULL,
  `relates_to` int(11) default NULL,
  `documents` varchar(100) NOT NULL,
  `emailed_to` varchar(200) NOT NULL,
  `access` tinyint(1) default '0',
  `access_date` datetime default NULL,
  `access_user` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_user` int(11) NOT NULL,
  `edited_date` datetime NOT NULL,
  `edited_user` int(11) NOT NULL,
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
  KEY `status` (`status`),
  KEY `access` (`access`),
  KEY `bin` (`bin`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `co_complaints_meetings`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_complaints_meetings_tasks`
--

CREATE TABLE IF NOT EXISTS `co_complaints_meetings_tasks` (
  `id` int(11) NOT NULL auto_increment,
  `mid` int(11) NOT NULL,
  `status` int(1) default NULL,
  `title` varchar(200) default NULL,
  `text` text NOT NULL,
  `sort` tinyint(2) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` tinyint(4) default NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`mid`),
  KEY `status` (`status`),
  KEY `sort` (`sort`),
  KEY `bin` (`bin`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `co_complaints_meetings_tasks`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_complaints_phonecalls`
--

CREATE TABLE IF NOT EXISTS `co_complaints_phonecalls` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) default NULL,
  `title` text,
  `item_date` datetime default NULL,
  `start` datetime default NULL,
  `end` datetime default NULL,
  `length` varchar(5) default NULL,
  `management` varchar(100) default NULL,
  `management_ct` varchar(100) NOT NULL,
  `protocol` text,
  `status` tinyint(1) default '0',
  `status_date` datetime default NULL,
  `documents` varchar(100) NOT NULL,
  `access` tinyint(1) default '0',
  `access_date` datetime default NULL,
  `access_user` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_user` int(11) NOT NULL,
  `edited_date` datetime NOT NULL,
  `edited_user` int(11) NOT NULL,
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
  KEY `status` (`status`),
  KEY `access` (`access`),
  KEY `bin` (`bin`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `co_complaints_phonecalls`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_complaints_vdocs`
--

CREATE TABLE IF NOT EXISTS `co_complaints_vdocs` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) default NULL,
  `title` text,
  `content` longtext NOT NULL,
  `relates_to` int(11) default NULL,
  `access` tinyint(1) default '0',
  `access_date` datetime default NULL,
  `access_user` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_user` int(11) NOT NULL,
  `edited_date` datetime NOT NULL,
  `edited_user` int(11) NOT NULL,
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
  KEY `bin` (`bin`),
  KEY `access` (`access`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `co_complaints_vdocs`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_config`
--

CREATE TABLE IF NOT EXISTS `co_config` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `co_config`
--

INSERT INTO `co_config` (`id`, `name`, `value`) VALUES
(1, 'applications', '{"desktop":0,"projects":0,"brainstorms":0,"forums":0,"complaints":0,"clients":0,"publishers":0,"contacts":0,"bin":0}'),
(2, 'projects', '{"phases":0,"meetings":0,"phonecalls":0,"documents":0,"vdocs":0,"controlling":0,"timelines":0,"access":0}'),
(3, 'contacts', '{}'),
(4, 'language', '{"de":1,"en":0}'),
(5, 'home', '{}'),
(6, 'email', '{}'),
(7, 'bin', '{}'),
(8, 'printheader', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />\r\n<title>Print</title>\r\n<link href="CO_FILES/css/print.css" rel="stylesheet" type="text/css" />\r\n</head>\r\n<body>'),
(10, 'printpdfheader', '<script type="text/php">\r\nif ( isset($pdf) ) {\r\n	$font = Font_Metrics::get_font("arial", "bold");\r\n\r\n	$header = $pdf->open_object();\r\n	$w = $pdf->get_width();\r\n	$h = $pdf->get_height();\r\n\r\n	$img_w = 2 * 72; // 2 inches, in points\r\n	$img_h = 36; // 1 inch, in points -- change these as required\r\n	$pdf->image(CO_PATH_BASE . "/data/logo_print.jpg", "jpg", 72, 10, $img_w, $img_h);\r\n\r\n	// Close the object (stop capture)\r\n	$pdf->close_object();\r\n	$pdf->add_object($header, "all");\r\n\r\n	$footer = $pdf->open_object();\r\n	$pdf->page_text(72, $h-40, $lang["GLOBAL_PAGE"] . " Seite: {PAGE_NUM} von {PAGE_COUNT}", $font, 10, array(0,0,0));\r\n	$pdf->close_object();\r\n	$pdf->add_object($footer, "all");\r\n}\r\n</script>'),
(9, 'printfooter', '</body>\r\n</html>'),
(11, 'brainstorms', '{"grids":0,"meetings":0,"documents":0,"vdocs":0,"access":0}'),
(12, 'productions', '{"phases":0,"meetings":0,"phonecalls":0,"documents":0,"vdocs":0,"controlling":0,"timelines":0,"access":0}'),
(13, 'clients', '{"orders":0,"meetings":0,"phonecalls":0,"documents":0,"access":0}'),
(14, 'publishers', '{"menues":0,"access":0}'),
(15, 'forums', '{"documents":0,"vdocs":0,"access":0}'),
(16, 'complaints', '{"grids":0,"forums":0,"meetings":0,"phonecalls":0,"documents":0,"vdocs":0,"access":0}');

-- --------------------------------------------------------

--
-- Table structure for table `co_contacts_groups`
--

CREATE TABLE IF NOT EXISTS `co_contacts_groups` (
  `id` int(4) NOT NULL auto_increment,
  `title` varchar(256) NOT NULL,
  `members` tinytext NOT NULL,
  `created_user` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `edited_user` int(11) NOT NULL,
  `edited_date` datetime NOT NULL,
  `bin` tinyint(1) NOT NULL default '0',
  `bintime` datetime NOT NULL,
  `binuser` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=111 ;

--
-- Dumping data for table `co_contacts_groups`
--

INSERT INTO `co_contacts_groups` (`id`, `title`, `members`, `created_user`, `created_date`, `edited_user`, `edited_date`, `bin`, `bintime`, `binuser`) VALUES
(110, 'Neue Gruppe', '7', 2, '2012-07-25 07:49:19', 2, '2012-07-25 07:49:24', 0, '0000-00-00 00:00:00', 0),
(109, 'comm', '2,7', 2, '2012-05-02 12:40:52', 2, '2012-05-14 15:02:30', 0, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `co_desktop_postits`
--

CREATE TABLE IF NOT EXISTS `co_desktop_postits` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(11) default '0',
  `text` text,
  `xyz` varchar(20) NOT NULL,
  `wh` varchar(20) NOT NULL,
  `sendto` varchar(100) NOT NULL,
  `sendfrom` varchar(100) NOT NULL,
  `created_date` datetime default NULL,
  `created_user` int(11) default NULL,
  `edited_user` int(11) default NULL,
  `edited_date` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`uid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `co_desktop_postits`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_desktop_settings`
--

CREATE TABLE IF NOT EXISTS `co_desktop_settings` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `value` text character set latin1 NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `co_desktop_settings`
--

INSERT INTO `co_desktop_settings` (`id`, `uid`, `value`) VALUES
(1, 2, '');

-- --------------------------------------------------------

--
-- Table structure for table `co_forums`
--

CREATE TABLE IF NOT EXISTS `co_forums` (
  `id` int(11) NOT NULL auto_increment,
  `folder` int(11) default '0',
  `title` text NOT NULL,
  `protocol` text,
  `status` tinyint(1) default '0',
  `planned_date` date default NULL,
  `inprogress_date` date default NULL,
  `finished_date` date default NULL,
  `stopped_date` date NOT NULL,
  `documents` varchar(100) NOT NULL,
  `access` tinyint(1) default '0',
  `access_user` int(11) NOT NULL,
  `access_date` datetime default NULL,
  `created_date` datetime default NULL,
  `created_user` int(11) default NULL,
  `edited_user` int(11) default NULL,
  `edited_date` datetime default NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `bin` (`bin`),
  KEY `folder` (`folder`),
  KEY `status` (`status`),
  KEY `access` (`access`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `co_forums`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_forums_access`
--

CREATE TABLE IF NOT EXISTS `co_forums_access` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) NOT NULL default '0',
  `admins` varchar(200) NOT NULL,
  `guests` varchar(200) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_user` int(11) NOT NULL,
  `edited_date` datetime NOT NULL,
  `edited_user` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
  KEY `admins` (`admins`),
  KEY `guests` (`guests`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=53 ;

--
-- Dumping data for table `co_forums_access`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_forums_desktop`
--

CREATE TABLE IF NOT EXISTS `co_forums_desktop` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `newpost` tinyint(1) NOT NULL default '0',
  `perm` tinyint(1) NOT NULL default '0',
  `status` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `uid` (`uid`),
  KEY `pid` (`pid`),
  KEY `status` (`status`),
  KEY `perm` (`perm`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `co_forums_desktop`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_forums_desktop_settings`
--

CREATE TABLE IF NOT EXISTS `co_forums_desktop_settings` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `co_forums_desktop_settings`
--

INSERT INTO `co_forums_desktop_settings` (`id`, `uid`, `value`) VALUES
(1, 2, '');

-- --------------------------------------------------------

--
-- Table structure for table `co_forums_documents`
--

CREATE TABLE IF NOT EXISTS `co_forums_documents` (
  `id` int(11) NOT NULL auto_increment,
  `did` int(11) default NULL,
  `filename` varchar(100) default NULL,
  `tempname` varchar(50) default NULL,
  `filesize` int(11) default NULL,
  `emailed_to` varchar(200) NOT NULL,
  `access` tinyint(1) default '0',
  `access_date` datetime NOT NULL,
  `access_user` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_user` int(11) NOT NULL,
  `edited_date` datetime NOT NULL,
  `edited_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `bin` (`bin`),
  KEY `did` (`did`),
  KEY `access` (`access`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `co_forums_documents`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_forums_documents_folders`
--

CREATE TABLE IF NOT EXISTS `co_forums_documents_folders` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) default NULL,
  `title` varchar(250) default NULL,
  `emailed_to` varchar(200) NOT NULL,
  `access` tinyint(1) default '0',
  `access_date` datetime NOT NULL,
  `access_user` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_user` int(11) NOT NULL,
  `edited_date` datetime NOT NULL,
  `edited_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
  KEY `bin` (`bin`),
  KEY `access` (`access`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `co_forums_documents_folders`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_forums_folders`
--

CREATE TABLE IF NOT EXISTS `co_forums_folders` (
  `id` int(11) NOT NULL auto_increment,
  `title` text NOT NULL,
  `status` tinyint(4) default '0',
  `created_date` datetime default NULL,
  `created_user` int(11) NOT NULL,
  `edited_date` datetime default NULL,
  `edited_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `status` (`status`),
  KEY `bin` (`bin`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `co_forums_folders`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_forums_posts`
--

CREATE TABLE IF NOT EXISTS `co_forums_posts` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) NOT NULL,
  `replyid` int(11) default '0',
  `user` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `text` text,
  `status` tinyint(1) NOT NULL default '0',
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
  KEY `bin` (`bin`),
  KEY `replyid` (`replyid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `co_forums_posts`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_forums_vdocs`
--

CREATE TABLE IF NOT EXISTS `co_forums_vdocs` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) default NULL,
  `title` text,
  `content` longtext NOT NULL,
  `relates_to` int(11) default NULL,
  `access` tinyint(1) default '0',
  `access_date` datetime default NULL,
  `access_user` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_user` int(11) NOT NULL,
  `edited_date` datetime NOT NULL,
  `edited_user` int(11) NOT NULL,
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
  KEY `bin` (`bin`),
  KEY `access` (`access`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `co_forums_vdocs`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_log`
--

CREATE TABLE IF NOT EXISTS `co_log` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `app` varchar(20) NOT NULL,
  `module` varchar(20) NOT NULL,
  `record` int(11) NOT NULL,
  `action` varchar(20) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `co_log`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_log_sendto`
--

CREATE TABLE IF NOT EXISTS `co_log_sendto` (
  `id` int(11) NOT NULL auto_increment,
  `date` datetime NOT NULL,
  `what` varchar(30) NOT NULL,
  `whatid` int(11) NOT NULL,
  `who` varchar(200) NOT NULL,
  `sender` int(11) NOT NULL,
  `subject` text NOT NULL,
  `body` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `what` (`what`),
  KEY `whatid` (`whatid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `co_log_sendto`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_projects`
--

CREATE TABLE IF NOT EXISTS `co_projects` (
  `id` int(11) NOT NULL auto_increment,
  `folder` int(11) default NULL,
  `title` text NOT NULL,
  `startdate` date default NULL,
  `enddate` date default NULL,
  `management` varchar(100) default NULL,
  `management_ct` varchar(100) NOT NULL,
  `team` varchar(100) NOT NULL,
  `team_ct` varchar(100) NOT NULL,
  `protocol` text,
  `ordered_on` date default NULL,
  `ordered_by` varchar(100) default NULL,
  `ordered_by_ct` varchar(100) NOT NULL,
  `status` tinyint(1) default '0',
  `planned_date` date default NULL,
  `inprogress_date` date default NULL,
  `finished_date` date default NULL,
  `stopped_date` date default NULL,
  `days` varchar(5) default NULL,
  `emailed_to` varchar(100) NOT NULL,
  `created_date` datetime default NULL,
  `created_user` int(11) default NULL,
  `edited_date` datetime default NULL,
  `edited_user` int(11) default NULL,
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `bin` (`bin`),
  KEY `folder` (`folder`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=125 ;

--
-- Dumping data for table `co_projects`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_projects_access`
--

CREATE TABLE IF NOT EXISTS `co_projects_access` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) NOT NULL default '0',
  `admins` varchar(200) NOT NULL,
  `guests` varchar(200) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_user` int(11) NOT NULL,
  `edited_date` datetime NOT NULL,
  `edited_user` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
  KEY `admins` (`admins`),
  KEY `guests` (`guests`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=60 ;

--
-- Dumping data for table `co_projects_access`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_projects_desktop`
--

CREATE TABLE IF NOT EXISTS `co_projects_desktop` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `perm` tinyint(1) NOT NULL default '0',
  `status` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `uid` (`uid`),
  KEY `pid` (`pid`),
  KEY `status` (`status`),
  KEY `perm` (`perm`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `co_projects_desktop`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_projects_desktop_settings`
--

CREATE TABLE IF NOT EXISTS `co_projects_desktop_settings` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `co_projects_desktop_settings`
--

INSERT INTO `co_projects_desktop_settings` (`id`, `uid`, `value`) VALUES
(1, 2, '');

-- --------------------------------------------------------

--
-- Table structure for table `co_projects_documents`
--

CREATE TABLE IF NOT EXISTS `co_projects_documents` (
  `id` int(11) NOT NULL auto_increment,
  `did` int(11) default NULL,
  `filename` varchar(100) default NULL,
  `tempname` varchar(50) default NULL,
  `filesize` int(11) default NULL,
  `emailed_to` varchar(200) NOT NULL,
  `access` tinyint(1) default '0',
  `access_date` datetime NOT NULL,
  `access_user` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_user` int(11) NOT NULL,
  `edited_date` datetime NOT NULL,
  `edited_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `bin` (`bin`),
  KEY `did` (`did`),
  KEY `access` (`access`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `co_projects_documents`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_projects_documents_folders`
--

CREATE TABLE IF NOT EXISTS `co_projects_documents_folders` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) default NULL,
  `title` varchar(250) default NULL,
  `emailed_to` varchar(200) NOT NULL,
  `access` tinyint(1) default '0',
  `access_date` datetime NOT NULL,
  `access_user` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_user` int(11) NOT NULL,
  `edited_date` datetime NOT NULL,
  `edited_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
  KEY `bin` (`bin`),
  KEY `access` (`access`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=82 ;

--
-- Dumping data for table `co_projects_documents_folders`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_projects_folders`
--

CREATE TABLE IF NOT EXISTS `co_projects_folders` (
  `id` int(11) NOT NULL auto_increment,
  `title` text NOT NULL,
  `status` tinyint(4) default '0',
  `created_date` datetime default NULL,
  `created_user` int(11) NOT NULL,
  `edited_date` datetime default NULL,
  `edited_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `status` (`status`),
  KEY `bin` (`bin`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=132 ;

--
-- Dumping data for table `co_projects_folders`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_projects_meetings`
--

CREATE TABLE IF NOT EXISTS `co_projects_meetings` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) default NULL,
  `title` text,
  `item_date` datetime default NULL,
  `start` datetime default NULL,
  `end` datetime default NULL,
  `location` varchar(100) default NULL,
  `location_ct` varchar(100) NOT NULL,
  `length` varchar(5) default NULL,
  `management` varchar(100) default NULL,
  `management_ct` varchar(100) NOT NULL,
  `participants` varchar(100) default NULL,
  `participants_ct` varchar(100) NOT NULL,
  `protocol` text,
  `status` tinyint(1) default '0',
  `status_date` datetime default NULL,
  `relates_to` int(11) default NULL,
  `documents` varchar(100) NOT NULL,
  `emailed_to` varchar(200) NOT NULL,
  `access` tinyint(1) default '0',
  `access_date` datetime default NULL,
  `access_user` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_user` int(11) NOT NULL,
  `edited_date` datetime NOT NULL,
  `edited_user` int(11) NOT NULL,
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
  KEY `status` (`status`),
  KEY `access` (`access`),
  KEY `bin` (`bin`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=196 ;

--
-- Dumping data for table `co_projects_meetings`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_projects_meetings_tasks`
--

CREATE TABLE IF NOT EXISTS `co_projects_meetings_tasks` (
  `id` int(11) NOT NULL auto_increment,
  `mid` int(11) NOT NULL,
  `status` int(1) default NULL,
  `title` varchar(200) default NULL,
  `text` text NOT NULL,
  `sort` tinyint(2) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` tinyint(4) default NULL,
  PRIMARY KEY  (`id`),
  KEY `mid` (`mid`),
  KEY `status` (`status`),
  KEY `sort` (`sort`),
  KEY `bin` (`bin`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=271 ;

--
-- Dumping data for table `co_projects_meetings_tasks`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_projects_phases`
--

CREATE TABLE IF NOT EXISTS `co_projects_phases` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) default '0',
  `title` text NOT NULL,
  `management` varchar(100) default NULL,
  `management_ct` varchar(100) NOT NULL,
  `team` varchar(100) NOT NULL,
  `team_ct` varchar(100) NOT NULL,
  `documents` varchar(100) NOT NULL,
  `verzug` tinyint(4) NOT NULL default '0',
  `protocol` text,
  `status` tinyint(1) default '0',
  `planned_date` date default NULL,
  `inprogress_date` date default NULL,
  `finished_date` date default NULL,
  `days` varchar(5) default NULL,
  `dependency` int(11) default NULL,
  `dependency_startdate` date default NULL,
  `dependency_enddate` date default NULL,
  `emailed_to` varchar(100) NOT NULL,
  `access` tinyint(1) default '0',
  `access_user` int(11) NOT NULL,
  `access_date` datetime default NULL,
  `created_date` datetime default NULL,
  `created_user` int(11) default NULL,
  `edited_user` int(11) default NULL,
  `edited_date` datetime default NULL,
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
  KEY `bin` (`bin`),
  KEY `status` (`status`),
  KEY `access` (`access`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=129 ;

--
-- Dumping data for table `co_projects_phases`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_projects_phases_tasks`
--

CREATE TABLE IF NOT EXISTS `co_projects_phases_tasks` (
  `id` int(11) NOT NULL auto_increment,
  `cat` tinyint(1) NOT NULL default '0',
  `pid` int(11) NOT NULL,
  `phaseid` int(11) default NULL,
  `dependent` int(11) NOT NULL,
  `status` tinyint(1) default '0',
  `donedate` date NOT NULL,
  `text` text,
  `protocol` text NOT NULL,
  `startdate` date default NULL,
  `enddate` date default NULL,
  `team` varchar(100) NOT NULL,
  `team_ct` varchar(100) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `phaseid` (`phaseid`),
  KEY `pid` (`pid`),
  KEY `bin` (`bin`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `co_projects_phases_tasks`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_projects_phonecalls`
--

CREATE TABLE IF NOT EXISTS `co_projects_phonecalls` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) default NULL,
  `title` text,
  `item_date` datetime default NULL,
  `start` datetime default NULL,
  `end` datetime default NULL,
  `length` varchar(5) default NULL,
  `management` varchar(100) default NULL,
  `management_ct` varchar(100) NOT NULL,
  `protocol` text,
  `status` tinyint(1) default '0',
  `status_date` datetime default NULL,
  `documents` varchar(100) NOT NULL,
  `access` tinyint(1) default '0',
  `access_date` datetime default NULL,
  `access_user` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_user` int(11) NOT NULL,
  `edited_date` datetime NOT NULL,
  `edited_user` int(11) NOT NULL,
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
  KEY `status` (`status`),
  KEY `access` (`access`),
  KEY `bin` (`bin`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `co_projects_phonecalls`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_projects_statistics`
--

CREATE TABLE IF NOT EXISTS `co_projects_statistics` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) NOT NULL,
  `result` tinyint(3) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `co_projects_statistics`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_projects_vdocs`
--

CREATE TABLE IF NOT EXISTS `co_projects_vdocs` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) default NULL,
  `title` text,
  `content` longtext NOT NULL,
  `relates_to` int(11) default NULL,
  `access` tinyint(1) default '0',
  `access_date` datetime default NULL,
  `access_user` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_user` int(11) NOT NULL,
  `edited_date` datetime NOT NULL,
  `edited_user` int(11) NOT NULL,
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
  KEY `bin` (`bin`),
  KEY `access` (`access`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `co_projects_vdocs`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_publishers_access`
--

CREATE TABLE IF NOT EXISTS `co_publishers_access` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) NOT NULL default '0',
  `admins` varchar(200) NOT NULL,
  `guests` varchar(200) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_user` int(11) NOT NULL,
  `edited_date` datetime NOT NULL,
  `edited_user` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
  KEY `admins` (`admins`),
  KEY `guests` (`guests`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `co_publishers_access`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_publishers_folders`
--

CREATE TABLE IF NOT EXISTS `co_publishers_folders` (
  `id` int(11) NOT NULL auto_increment,
  `title` text NOT NULL,
  `status` tinyint(4) default '0',
  `created_date` datetime default NULL,
  `created_user` int(11) NOT NULL,
  `edited_date` datetime default NULL,
  `edited_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `status` (`status`),
  KEY `bin` (`bin`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `co_publishers_folders`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_publishers_menues`
--

CREATE TABLE IF NOT EXISTS `co_publishers_menues` (
  `id` int(11) NOT NULL auto_increment,
  `title` text,
  `item_date_from` datetime default NULL,
  `item_date_to` datetime NOT NULL,
  `management` varchar(100) default NULL,
  `management_ct` varchar(100) NOT NULL,
  `protocol` text,
  `status` tinyint(1) default '0',
  `status_date` datetime default NULL,
  `mon_1` tinytext NOT NULL,
  `mon_2` tinytext NOT NULL,
  `mon_3` tinytext NOT NULL,
  `mon_4` tinytext NOT NULL,
  `mon_5` tinytext NOT NULL,
  `mon_6` tinytext NOT NULL,
  `tue_1` tinytext NOT NULL,
  `tue_2` tinytext NOT NULL,
  `tue_3` tinytext NOT NULL,
  `tue_4` tinytext NOT NULL,
  `tue_5` tinytext NOT NULL,
  `tue_6` tinytext NOT NULL,
  `wed_1` tinytext NOT NULL,
  `wed_2` tinytext NOT NULL,
  `wed_3` tinytext NOT NULL,
  `wed_4` tinytext NOT NULL,
  `wed_5` tinytext NOT NULL,
  `wed_6` tinytext NOT NULL,
  `thu_1` tinytext NOT NULL,
  `thu_2` tinytext NOT NULL,
  `thu_3` tinytext NOT NULL,
  `thu_4` tinytext NOT NULL,
  `thu_5` tinytext NOT NULL,
  `thu_6` tinytext NOT NULL,
  `fri_1` tinytext NOT NULL,
  `fri_2` tinytext NOT NULL,
  `fri_3` tinytext NOT NULL,
  `fri_4` tinytext NOT NULL,
  `fri_5` tinytext NOT NULL,
  `fri_6` tinytext NOT NULL,
  `access` tinyint(1) default '0',
  `access_date` datetime default NULL,
  `access_user` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_user` int(11) NOT NULL,
  `edited_date` datetime NOT NULL,
  `edited_user` int(11) NOT NULL,
  `bin` tinyint(1) default '0',
  `bintime` datetime default NULL,
  `binuser` int(9) default NULL,
  PRIMARY KEY  (`id`),
  KEY `status` (`status`),
  KEY `access` (`access`),
  KEY `bin` (`bin`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `co_publishers_menues`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_users`
--

CREATE TABLE IF NOT EXISTS `co_users` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `pwd_pick` tinyint(1) NOT NULL default '0',
  `userid` varchar(32) default NULL,
  `userlevel` tinyint(1) unsigned NOT NULL,
  `invisible` tinyint(1) NOT NULL default '0',
  `email` varchar(200) default NULL,
  `email_alt` varchar(200) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `title` varchar(30) NOT NULL,
  `title2` varchar(30) NOT NULL,
  `company` varchar(200) NOT NULL,
  `position` tinytext NOT NULL,
  `phone1` varchar(30) NOT NULL,
  `phone2` varchar(30) NOT NULL,
  `fax` varchar(30) NOT NULL,
  `address_line1` varchar(50) NOT NULL,
  `address_line2` varchar(50) NOT NULL,
  `address_town` varchar(50) NOT NULL,
  `address_postcode` varchar(15) NOT NULL,
  `address_country` varchar(50) NOT NULL,
  `address` tinytext,
  `lang` varchar(2) NOT NULL,
  `offset` varchar(2) NOT NULL default '0',
  `timezone` varchar(30) NOT NULL,
  `timestamp` int(11) unsigned NOT NULL,
  `created_user` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `edited_user` int(11) NOT NULL,
  `edited_date` datetime NOT NULL,
  `access_status` tinyint(1) NOT NULL,
  `access_user` int(11) NOT NULL,
  `access_date` datetime NOT NULL,
  `sysadmin_status` tinyint(1) NOT NULL default '0',
  `sysadmin_user` int(11) NOT NULL,
  `sysadmin_date` datetime NOT NULL,
  `bin` tinyint(1) NOT NULL,
  `bintime` datetime NOT NULL,
  `binuser` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `co_users`
--

INSERT INTO `co_users` (`id`, `username`, `password`, `pwd_pick`, `userid`, `userlevel`, `invisible`, `email`, `email_alt`, `firstname`, `lastname`, `title`, `title2`, `company`, `position`, `phone1`, `phone2`, `fax`, `address_line1`, `address_line2`, `address_town`, `address_postcode`, `address_country`, `address`, `lang`, `offset`, `timezone`, `timestamp`, `created_user`, `created_date`, `edited_user`, `edited_date`, `access_status`, `access_user`, `access_date`, `sysadmin_status`, `sysadmin_user`, `sysadmin_date`, `bin`, `bintime`, `binuser`) VALUES
(1, 'sysadmin', '22d8bfd7a79da271ff2d0d39baf4d91b', 1, '58941c7405c7822b300b7fef9d4022bd', 1, 1, 'internet@communautic.com', '', 'Admin', 'System', 'Herr', '', '', 'Bereichsleiter Internet', '123456', '23423', '3424', '', '', '', '', '', 'Max 31\nA-6020 Innsbruck', 'de', '0', 'Europe/Vienna', 1343578414, 6, '0000-00-00 00:00:00', 6, '0000-00-00 00:00:00', 0, 0, '0000-00-00 00:00:00', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(2, 'grandolf', 'e10adc3949ba59abbe56e057f20f883e', 1, '509296038a87c8b528d1784de8a3dd0f', 1, 0, 'internet@communautic.com', 'guni@planc.at', 'Gunharth', 'Randolf', 'Herr', 'MA', 'communautic Ebenbichler KG communautic LTD', 'Bereichsleitung Internet & CEO communautic ltd', '+43 676 5700 509', '123456', '000', 'Maximilianstrasse/Mühlenweg 31', '', 'Innsbruck/Hall in Tirol', '6020', 'Österreich', NULL, 'de', '0', 'Europe/Vienna', 1343678801, 1, '2012-02-29 13:41:28', 2, '2012-07-30 15:40:53', 0, 1, '2012-02-29 13:41:58', 0, 1, '2012-02-29 13:45:56', 0, '0000-00-00 00:00:00', 0),
(3, '', '', 0, NULL, 0, 0, 'office@communautic.com', '', 'Otto Walter', 'Ebenbichler', '', '', '', '', 'jhgjgh', '', '', 'Mühlenweg 9', '', 'Innsbruck', '6020', 'Österreich', NULL, 'de', '0', 'Europe/Vienna', 0, 2, '2012-02-29 14:01:21', 2, '2012-07-04 16:46:52', 0, 0, '0000-00-00 00:00:00', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(4, 'archeffekt', '238b0667d66ae10841ff30cf4709a3a8', 1, '97abc5ebafbf8905306eebe11e2b8be7', 1, 0, 'michael.ebenbichler@communautic.com', '', 'Michael', 'Ebenbichler', '', '', 'communautic KG', 'Bereichsleiter Artwork', '0676 1234 1234', '', '', 'Mühlenweg 9', '', 'Mils', '6063', 'AT', NULL, 'de', '0', 'Europe/Vienna', 1343316473, 2, '2012-02-29 14:01:52', 2, '2012-05-26 09:47:05', 0, 2, '2012-07-26 14:51:27', 1, 1, '2012-07-26 14:57:03', 0, '0000-00-00 00:00:00', 0),
(5, '', '', 0, NULL, 0, 0, 'gunnar.frei@communautic.com', '', 'Gunnar', 'Frei', '', '', '', '', '', '', '', '', '', '', '', '', NULL, 'de', '0', 'Europe/Vienna', 0, 2, '2012-02-29 14:02:20', 2, '2012-02-29 14:02:40', 0, 0, '0000-00-00 00:00:00', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(6, '', '', 0, NULL, 0, 0, '', '', '', 'Neuer Kontakt', '', '', '', '', '', '', '', '', '', '', '', '', NULL, 'de', '0', 'Europe/Vienna', 0, 2, '2012-03-02 08:33:40', 2, '2012-03-02 08:35:04', 0, 0, '0000-00-00 00:00:00', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(7, 'ipaduser', 'e10adc3949ba59abbe56e057f20f883e', 1, '45842cf13a1711ad7c9a4dd79e186aed', 0, 0, 'gunharth.randolf@communautic.com', 'guni@planc.at', 'User', 'iPad', 'Herr', 'Mag', 'Firma', 'Master', '123', '234', '345', 'max31', '', 'ibk', '6020', 'at', NULL, 'de', '0', 'Europe/Vienna', 1343380628, 2, '2012-03-02 16:05:16', 2, '2012-07-26 13:21:01', 0, 2, '2012-07-27 08:30:39', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(8, 'gunharth', 'e10adc3949ba59abbe56e057f20f883e', 1, 'ede5139673a75d7ad42b4a9df5697ce6', 0, 0, 'internet@communautic.com', '', '', 'Neuer Kontakt 1', '', '', '', '', '', '', '', '', '', '', '', '', NULL, 'de', '0', 'Europe/Vienna', 1343336946, 2, '2012-05-15 06:50:58', 2, '2012-07-26 20:27:58', 0, 2, '2012-07-26 20:56:48', 1, 2, '2012-07-26 20:58:37', 0, '0000-00-00 00:00:00', 0),
(9, '', '', 0, NULL, 0, 0, '', '', '', 'Neuer Kontakt 2', '', '', '', '', '', '', '', '', '', '', '', '', NULL, 'de', '0', 'Europe/Vienna', 0, 2, '2012-05-15 06:51:06', 2, '2012-05-15 06:51:11', 0, 0, '0000-00-00 00:00:00', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(10, '', '', 0, NULL, 0, 0, '', '', 'Ohne Email', 'Kontakt', 'Herr', '', '', '', '', '', '', '', '', '', '', '', NULL, 'de', '0', 'Europe/Vienna', 0, 2, '2012-05-15 06:51:12', 2, '2012-07-16 19:22:44', 0, 0, '0000-00-00 00:00:00', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(11, 'KGDQ', 'ed383ec94720d62a939bfb6bdd98f50c', 0, '31aab7945fc69fae74709d3cb0466e73', 0, 0, 'internet@communautic.com', '', 'Nur', 'Beobachter', '', '', '', '', '', '', '', '', '', '', '', '', NULL, 'de', '0', 'Europe/Vienna', 1343309709, 2, '2012-07-16 19:30:43', 2, '2012-07-24 15:56:41', 0, 7, '2012-07-26 19:20:06', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `co_users_avatars`
--

CREATE TABLE IF NOT EXISTS `co_users_avatars` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `avatar` varchar(30) NOT NULL,
  `bin` tinyint(1) NOT NULL default '0',
  `bintime` datetime NOT NULL,
  `binuser` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `uid` (`uid`),
  KEY `bin` (`bin`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=98 ;

--
-- Dumping data for table `co_users_avatars`
--

INSERT INTO `co_users_avatars` (`id`, `uid`, `avatar`, `bin`, `bintime`, `binuser`) VALUES
(96, 2, '1330523488_2.JPG', 0, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `co_users_checkpoints`
--

CREATE TABLE IF NOT EXISTS `co_users_checkpoints` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `date` date NOT NULL,
  `app` varchar(100) NOT NULL,
  `module` varchar(100) NOT NULL,
  `app_id` int(11) NOT NULL,
  `note` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `uid` (`uid`),
  KEY `date` (`date`),
  KEY `app` (`app`),
  KEY `module` (`module`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `co_users_checkpoints`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_users_sessions`
--

CREATE TABLE IF NOT EXISTS `co_users_sessions` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(30) NOT NULL,
  `userid` varchar(32) default NULL,
  `date` date NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `username` (`username`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `co_users_sessions`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_users_settings`
--

CREATE TABLE IF NOT EXISTS `co_users_settings` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `object` varchar(100) NOT NULL,
  `item` int(11) NOT NULL default '0',
  `value` tinytext NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `uid` (`uid`),
  KEY `object` (`object`),
  KEY `item` (`item`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `co_users_settings`
--

INSERT INTO `co_users_settings` (`id`, `uid`, `object`, `item`, `value`) VALUES
(1, 2, 'brainstorms-folder-sort-status', 0, '1'),
(2, 2, 'forums-folder-sort-status', 0, '1'),
(3, 2, 'complaints-folder-sort-status', 0, '1'),
(4, 2, 'clients-folder-sort-status', 0, '1'),
(5, 2, 'projects-folder-sort-status', 0, '1'),
(6, 2, 'contacts-contact-sort-status', 0, '1'),
(7, 2, 'publishers-menues-sort-status', 0, '1');
