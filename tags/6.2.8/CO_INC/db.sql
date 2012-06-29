-- phpMyAdmin SQL Dump
-- version 2.11.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 29, 2012 at 01:40 PM
-- Server version: 5.0.77
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

CREATE TABLE `co_active_guests` (
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

CREATE TABLE `co_active_users` (
  `uid` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `timestamp` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_active_users`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_banned_users`
--

CREATE TABLE `co_banned_users` (
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

CREATE TABLE `co_brainstorms` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_brainstorms`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_brainstorms_access`
--

CREATE TABLE `co_brainstorms_access` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_brainstorms_access`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_brainstorms_desktop`
--

CREATE TABLE `co_brainstorms_desktop` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_brainstorms_desktop`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_brainstorms_desktop_settings`
--

CREATE TABLE `co_brainstorms_desktop_settings` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `co_brainstorms_desktop_settings`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_brainstorms_documents`
--

CREATE TABLE `co_brainstorms_documents` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_brainstorms_documents`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_brainstorms_documents_folders`
--

CREATE TABLE `co_brainstorms_documents_folders` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_brainstorms_documents_folders`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_brainstorms_folders`
--

CREATE TABLE `co_brainstorms_folders` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_brainstorms_folders`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_brainstorms_grids`
--

CREATE TABLE `co_brainstorms_grids` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_brainstorms_grids`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_brainstorms_grids_columns`
--

CREATE TABLE `co_brainstorms_grids_columns` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_brainstorms_grids_columns`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_brainstorms_grids_log`
--

CREATE TABLE `co_brainstorms_grids_log` (
  `id` int(11) NOT NULL auto_increment,
  `rid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `fid` int(11) NOT NULL,
  `created_user` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `rid` (`rid`,`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_brainstorms_grids_log`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_brainstorms_grids_notes`
--

CREATE TABLE `co_brainstorms_grids_notes` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_brainstorms_grids_notes`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_brainstorms_meetings`
--

CREATE TABLE `co_brainstorms_meetings` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_brainstorms_meetings`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_brainstorms_meetings_tasks`
--

CREATE TABLE `co_brainstorms_meetings_tasks` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_brainstorms_meetings_tasks`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_brainstorms_notes`
--

CREATE TABLE `co_brainstorms_notes` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_brainstorms_notes`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_brainstorms_rosters`
--

CREATE TABLE `co_brainstorms_rosters` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_brainstorms_rosters`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_brainstorms_rosters_columns`
--

CREATE TABLE `co_brainstorms_rosters_columns` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_brainstorms_rosters_columns`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_brainstorms_rosters_log`
--

CREATE TABLE `co_brainstorms_rosters_log` (
  `id` int(11) NOT NULL auto_increment,
  `rid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `fid` int(11) NOT NULL,
  `created_user` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `rid` (`rid`,`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `co_brainstorms_rosters_log`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_brainstorms_rosters_notes`
--

CREATE TABLE `co_brainstorms_rosters_notes` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_brainstorms_rosters_notes`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_brainstorms_vdocs`
--

CREATE TABLE `co_brainstorms_vdocs` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_brainstorms_vdocs`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_clients`
--

CREATE TABLE `co_clients` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_clients`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_clients_access`
--

CREATE TABLE `co_clients_access` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_clients_access`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_clients_documents`
--

CREATE TABLE `co_clients_documents` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_clients_documents`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_clients_documents_folders`
--

CREATE TABLE `co_clients_documents_folders` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_clients_documents_folders`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_clients_folders`
--

CREATE TABLE `co_clients_folders` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_clients_folders`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_clients_meetings`
--

CREATE TABLE `co_clients_meetings` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_clients_meetings`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_clients_meetings_tasks`
--

CREATE TABLE `co_clients_meetings_tasks` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_clients_meetings_tasks`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_clients_orders`
--

CREATE TABLE `co_clients_orders` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_clients_orders`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_clients_orders_access`
--

CREATE TABLE `co_clients_orders_access` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_clients_orders_access`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_clients_phonecalls`
--

CREATE TABLE `co_clients_phonecalls` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_clients_phonecalls`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_config`
--

CREATE TABLE `co_config` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_config`
--

INSERT INTO `co_config` (`id`, `name`, `value`) VALUES
(1, 'applications', '{"desktop":0,"projects":0,"productions":0,"brainstorms":0,"forums":0,"clients":0,"publishers":0,"contacts":0,"bin":0}'),
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
(15, 'forums', '{"documents":0,"vdocs":0,"access":0}');

-- --------------------------------------------------------

--
-- Table structure for table `co_contacts_groups`
--

CREATE TABLE `co_contacts_groups` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_contacts_groups`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_desktop_postits`
--

CREATE TABLE `co_desktop_postits` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_desktop_postits`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_forums`
--

CREATE TABLE `co_forums` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_forums`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_forums_access`
--

CREATE TABLE `co_forums_access` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_forums_access`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_forums_desktop`
--

CREATE TABLE `co_forums_desktop` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_forums_desktop`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_forums_desktop_settings`
--

CREATE TABLE `co_forums_desktop_settings` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `co_forums_desktop_settings`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_forums_documents`
--

CREATE TABLE `co_forums_documents` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_forums_documents`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_forums_documents_folders`
--

CREATE TABLE `co_forums_documents_folders` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_forums_documents_folders`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_forums_folders`
--

CREATE TABLE `co_forums_folders` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_forums_folders`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_forums_posts`
--

CREATE TABLE `co_forums_posts` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_forums_posts`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_forums_vdocs`
--

CREATE TABLE `co_forums_vdocs` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_forums_vdocs`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_log`
--

CREATE TABLE `co_log` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `app` varchar(20) NOT NULL,
  `module` varchar(20) NOT NULL,
  `record` int(11) NOT NULL,
  `action` varchar(20) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `co_log`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_log_sendto`
--

CREATE TABLE `co_log_sendto` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_log_sendto`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_productions`
--

CREATE TABLE `co_productions` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_productions`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_productions_access`
--

CREATE TABLE `co_productions_access` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_productions_access`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_productions_desktop`
--

CREATE TABLE `co_productions_desktop` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_productions_desktop`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_productions_desktop_settings`
--

CREATE TABLE `co_productions_desktop_settings` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `co_productions_desktop_settings`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_productions_documents`
--

CREATE TABLE `co_productions_documents` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_productions_documents`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_productions_documents_folders`
--

CREATE TABLE `co_productions_documents_folders` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_productions_documents_folders`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_productions_folders`
--

CREATE TABLE `co_productions_folders` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_productions_folders`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_productions_meetings`
--

CREATE TABLE `co_productions_meetings` (
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
  KEY `bin` (`bin`),
  KEY `access` (`access`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_productions_meetings`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_productions_meetings_tasks`
--

CREATE TABLE `co_productions_meetings_tasks` (
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
  KEY `bin` (`bin`),
  KEY `sort` (`sort`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_productions_meetings_tasks`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_productions_phases`
--

CREATE TABLE `co_productions_phases` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_productions_phases`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_productions_phases_tasks`
--

CREATE TABLE `co_productions_phases_tasks` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_productions_phases_tasks`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_productions_phonecalls`
--

CREATE TABLE `co_productions_phonecalls` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_productions_phonecalls`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_productions_statistics`
--

CREATE TABLE `co_productions_statistics` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) NOT NULL,
  `result` tinyint(3) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `co_productions_statistics`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_productions_vdocs`
--

CREATE TABLE `co_productions_vdocs` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_productions_vdocs`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_projects`
--

CREATE TABLE `co_projects` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_projects`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_projects_access`
--

CREATE TABLE `co_projects_access` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_projects_access`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_projects_desktop`
--

CREATE TABLE `co_projects_desktop` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_projects_desktop`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_projects_desktop_settings`
--

CREATE TABLE `co_projects_desktop_settings` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `co_projects_desktop_settings`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_projects_documents`
--

CREATE TABLE `co_projects_documents` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_projects_documents`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_projects_documents_folders`
--

CREATE TABLE `co_projects_documents_folders` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_projects_documents_folders`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_projects_folders`
--

CREATE TABLE `co_projects_folders` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_projects_folders`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_projects_meetings`
--

CREATE TABLE `co_projects_meetings` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_projects_meetings`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_projects_meetings_tasks`
--

CREATE TABLE `co_projects_meetings_tasks` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_projects_meetings_tasks`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_projects_phases`
--

CREATE TABLE `co_projects_phases` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_projects_phases`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_projects_phases_tasks`
--

CREATE TABLE `co_projects_phases_tasks` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_projects_phases_tasks`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_projects_phonecalls`
--

CREATE TABLE `co_projects_phonecalls` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_projects_phonecalls`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_projects_statistics`
--

CREATE TABLE `co_projects_statistics` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) NOT NULL,
  `result` tinyint(3) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `co_projects_statistics`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_projects_vdocs`
--

CREATE TABLE `co_projects_vdocs` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_projects_vdocs`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_publishers_access`
--

CREATE TABLE `co_publishers_access` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_publishers_access`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_publishers_folders`
--

CREATE TABLE `co_publishers_folders` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_publishers_folders`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_publishers_menues`
--

CREATE TABLE `co_publishers_menues` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_publishers_menues`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_users`
--

CREATE TABLE `co_users` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `pwd_pick` tinyint(1) NOT NULL default '0',
  `userid` varchar(32) default NULL,
  `userlevel` tinyint(1) unsigned NOT NULL,
  `invisible` tinyint(1) NOT NULL default '0',
  `email` varchar(200) default NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `title` varchar(30) NOT NULL,
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_users`
--

INSERT INTO `co_users` (`id`, `username`, `password`, `pwd_pick`, `userid`, `userlevel`, `invisible`, `email`, `firstname`, `lastname`, `title`, `company`, `position`, `phone1`, `phone2`, `fax`, `address_line1`, `address_line2`, `address_town`, `address_postcode`, `address_country`, `address`, `lang`, `offset`, `timezone`, `timestamp`, `created_user`, `created_date`, `edited_user`, `edited_date`, `access_status`, `access_user`, `access_date`, `sysadmin_status`, `sysadmin_user`, `sysadmin_date`, `bin`, `bintime`, `binuser`) VALUES
(1, 'sysadmin', '22d8bfd7a79da271ff2d0d39baf4d91b', 1, 'cac00876d0857a9b61ce5027fa67ae81', 1, 1, 'internet@communautic.com', 'Admin', 'System', 'Herr', '', 'Bereichsleiter Internet', '123456', '23423', '3424', '', '', '', '', '', 'Max 31\nA-6020 Innsbruck', 'de', '0', 'Europe/Vienna', 1330364246, 6, '0000-00-00 00:00:00', 6, '0000-00-00 00:00:00', 0, 0, '0000-00-00 00:00:00', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `co_users_avatars`
--

CREATE TABLE `co_users_avatars` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `avatar` varchar(30) NOT NULL,
  `bin` tinyint(1) NOT NULL default '0',
  `bintime` datetime NOT NULL,
  `binuser` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `uid` (`uid`),
  KEY `bin` (`bin`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `co_users_avatars`
--


-- --------------------------------------------------------

--
-- Table structure for table `co_users_settings`
--

CREATE TABLE `co_users_settings` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `object` varchar(100) NOT NULL,
  `item` int(11) NOT NULL default '0',
  `value` tinytext NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `uid` (`uid`),
  KEY `object` (`object`),
  KEY `item` (`item`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `co_users_settings`
--

