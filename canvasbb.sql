-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2013 at 03:32 AM
-- Server version: 5.5.27-log
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `canvasbb`
--
CREATE DATABASE `canvasbb` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `canvasbb`;

-- --------------------------------------------------------

--
-- Table structure for table `autologin`
--

CREATE TABLE IF NOT EXISTS `autologin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(6) NOT NULL,
  `userkey` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'First Category'),
(2, 'Second Category');

-- --------------------------------------------------------

--
-- Table structure for table `forums`
--

CREATE TABLE IF NOT EXISTS `forums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fid` int(6) NOT NULL,
  `cid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fid` (`fid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `forums`
--

INSERT INTO `forums` (`id`, `fid`, `cid`, `name`, `description`) VALUES
(1, 978477, 1, 'First Forum', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque rutrum dignissim nisi ut feugiat. Fusce id laoreet dolor.'),
(2, 233054, 1, 'Second Forum', 'So what do you guys think of this so far?'),
(3, 121872, 2, 'Another Forum', 'Hello World!');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(6) NOT NULL,
  `pid` int(6) NOT NULL,
  `author` int(6) NOT NULL,
  `contents` text NOT NULL,
  `postDate` datetime NOT NULL,
  `editedBy` int(6) NOT NULL,
  `editedOn` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `tid`, `pid`, `author`, `contents`, `postDate`, `editedBy`, `editedOn`) VALUES
(3, 537887, 707873, 426942, 'Day 7? I think I kinda lost track.\r\n\r\nAnyway...this works :O', '2013-03-21 12:05:42', 0, '0000-00-00 00:00:00'),
(4, 733993, 427172, 426942, 'Hello World!', '2013-03-21 12:08:16', 0, '0000-00-00 00:00:00'),
(5, 888406, 973797, 426942, '# Hello World\r\n\r\n> This is a blockquote.\r\n\r\n*   List Item 1\r\n*   List Item 2\r\n*   List Item 3\r\n\r\n[Links are fun. Click here to go back to the index page.](../)\r\n\r\n**Bold Text**  \r\n*Italic Text*\r\n\r\n![Alternate Text!](http://cache.desktopnexus.com/thumbnails/585234-bigthumbnail.jpg)\r\n', '2013-03-21 01:08:19', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE IF NOT EXISTS `topics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(6) NOT NULL,
  `fid` int(6) NOT NULL,
  `name` varchar(255) NOT NULL,
  `author` int(6) NOT NULL,
  `startDate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `tid`, `fid`, `name`, `author`, `startDate`) VALUES
(1, 864430, 233054, 'My First Topic!', 426942, '2013-03-18 00:00:00'),
(2, 864431, 233054, 'More Topics', 426942, '2013-03-19 00:00:00'),
(3, 864432, 233054, 'More Topics', 426942, '2013-03-19 00:00:00'),
(4, 854431, 233054, 'More Topics', 426942, '2013-03-19 00:00:00'),
(5, 864438, 233054, 'More Topics', 426942, '2013-03-19 00:00:00'),
(31, 537887, 978477, 'Wow A Topic!', 426942, '2013-03-21 12:05:42'),
(32, 733993, 978477, 'Just another test.', 426942, '2013-03-21 12:08:16'),
(33, 888406, 978477, 'Testing Markdown!', 426942, '2013-03-21 01:08:19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(6) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(128) NOT NULL,
  `salt` varchar(128) NOT NULL,
  `regDate` datetime NOT NULL,
  `lastLoginDate` datetime NOT NULL,
  `ip` int(11) NOT NULL,
  `groupId` int(11) NOT NULL DEFAULT '4',
  `posts` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
