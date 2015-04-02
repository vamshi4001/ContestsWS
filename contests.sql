-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Apr 02, 2015 at 07:02 PM
-- Server version: 5.5.38
-- PHP Version: 5.6.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `contests`
--

-- --------------------------------------------------------

--
-- Table structure for table `advertiser`
--

CREATE TABLE `advertiser` (
`id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `shortdesc` varchar(300) NOT NULL,
  `longdesc` text NOT NULL,
  `categoryid` int(11) NOT NULL,
  `logo_small` varchar(200) NOT NULL,
  `logo_large` varchar(200) NOT NULL,
  `website` varchar(200) NOT NULL,
  `contactno` varchar(100) NOT NULL,
  `latitude` varchar(50) NOT NULL,
  `longitude` varchar(50) NOT NULL,
  `comments` text NOT NULL,
  `creation_date` datetime NOT NULL,
  `last_update_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
`id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `isactive` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `contests`
--

CREATE TABLE `contests` (
`id` int(11) NOT NULL,
  `taskid` int(11) NOT NULL,
  `ticketid` int(11) NOT NULL,
  `completedat` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updatedby` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contests`
--

INSERT INTO `contests` (`id`, `taskid`, `ticketid`, `completedat`, `createdby`, `updatedby`) VALUES
(1, 1, 3, '2015-04-01 22:08:03', 0, 0),
(2, 1, 7, '2015-04-01 22:08:03', 0, 0),
(3, 1, 2, '2015-04-01 22:08:03', 0, 0),
(4, 1, 6, '2015-04-01 22:10:45', 0, 0),
(5, 1, 3, '2015-04-01 22:10:45', 0, 0),
(6, 1, 8, '2015-04-01 22:10:45', 0, 0),
(7, 1, 2, '2015-04-01 22:11:16', 0, 0),
(8, 1, 10, '2015-04-01 22:11:16', 0, 0),
(9, 1, 3, '2015-04-01 22:11:16', 0, 0),
(10, 1, 1, '2015-04-01 22:11:41', 0, 0),
(11, 1, 2, '2015-04-01 22:11:41', 0, 0),
(12, 1, 5, '2015-04-01 22:11:41', 0, 0),
(13, 1, 6, '2015-04-01 22:12:08', 0, 0),
(14, 1, 7, '2015-04-01 22:12:08', 0, 0),
(15, 1, 8, '2015-04-01 22:12:08', 0, 0),
(16, 1, 8, '2015-04-01 22:13:44', 0, 0),
(17, 1, 1, '2015-04-01 22:13:44', 0, 0),
(18, 1, 4, '2015-04-01 22:13:44', 0, 0),
(19, 1, 4, '2015-04-01 22:19:07', 0, 0),
(20, 1, 2, '2015-04-01 22:19:07', 0, 0),
(21, 1, 5, '2015-04-01 22:19:07', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `referralcodes`
--

CREATE TABLE `referralcodes` (
`id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `referralcode` varchar(10) NOT NULL,
  `code1` varchar(20) NOT NULL,
  `code2` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `referred_by` int(11) NOT NULL,
  `creation_date` datetime NOT NULL,
  `last_update_date` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updatedby` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `referralcodes`
--

INSERT INTO `referralcodes` (`id`, `userid`, `referralcode`, `code1`, `code2`, `count`, `isActive`, `referred_by`, `creation_date`, `last_update_date`, `createdby`, `updatedby`) VALUES
(1, 1, 'N0WT4', '', 0, 0, 1, 0, '2015-03-17 18:00:15', '2015-03-17 23:30:15', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
`id` int(11) NOT NULL,
  `content_type` varchar(30) NOT NULL,
  `contentid` int(11) NOT NULL,
  `scheduledruntime` datetime NOT NULL,
  `advertiserid` int(11) NOT NULL,
  `cityid` int(11) NOT NULL,
  `isactive` tinyint(1) DEFAULT NULL,
  `Acronym` varchar(20) NOT NULL,
  `numofwinners` int(11) NOT NULL DEFAULT '1',
  `creation_date` datetime NOT NULL,
  `last_update_date` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updatedby` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `content_type`, `contentid`, `scheduledruntime`, `advertiserid`, `cityid`, `isactive`, `Acronym`, `numofwinners`, `creation_date`, `last_update_date`, `createdby`, `updatedby`) VALUES
(1, 'QUESTION', 1, '2015-04-01 06:06:17', 1, 0, 0, 'TEST', 3, '2015-03-29 00:00:00', '2015-04-01 22:19:07', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `task_questions`
--

CREATE TABLE `task_questions` (
`id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `options` varchar(500) NOT NULL,
  `correctAnswer` smallint(1) NOT NULL,
  `creation_date` datetime NOT NULL,
  `last_update_date` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updatedby` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `task_questions`
--

INSERT INTO `task_questions` (`id`, `question_text`, `options`, `correctAnswer`, `creation_date`, `last_update_date`, `createdby`, `updatedby`) VALUES
(1, 'What is the best porn site', 'youporn, weporn, theyporn, elephanttube', 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `task_videos`
--

CREATE TABLE `task_videos` (
`id` int(11) NOT NULL,
  `videoURL` text NOT NULL,
  `videotitle` varchar(500) NOT NULL,
  `videotype` varchar(50) NOT NULL,
  `videodescription` varchar(500) NOT NULL,
  `creation_date` datetime NOT NULL,
  `last_update_date` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updatedby` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
`id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `ticketnumber` varchar(50) NOT NULL,
  `taskid` int(11) NOT NULL,
  `validity` int(11) DEFAULT NULL,
  `ticket_type` varchar(30) NOT NULL,
  `isactive` tinyint(1) NOT NULL,
  `creation_date` datetime NOT NULL,
  `last_update_date` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updatedby` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `userid`, `ticketnumber`, `taskid`, `validity`, `ticket_type`, `isactive`, `creation_date`, `last_update_date`, `createdby`, `updatedby`) VALUES
(1, 1, 'TEST3529868', 1, 13, 'general', 1, '2015-04-01 21:22:09', '2015-04-01 22:19:07', 0, 0),
(2, 1, 'TEST3530376', 1, 13, 'general', 1, '2015-04-01 21:22:10', '2015-04-01 22:19:07', 0, 0),
(3, 1, 'TEST3530498', 1, 13, 'general', 1, '2015-04-01 21:22:10', '2015-04-01 22:19:07', 0, 0),
(4, 1, 'TEST3531253', 1, 13, 'general', 1, '2015-04-01 21:22:11', '2015-04-01 22:19:07', 0, 0),
(5, 1, 'TEST3532179', 1, 13, 'general', 1, '2015-04-01 21:22:12', '2015-04-01 22:19:07', 0, 0),
(6, 1, 'TEST3533759', 1, 13, 'general', 1, '2015-04-01 21:22:13', '2015-04-01 22:19:07', 0, 0),
(7, 1, 'TEST3534590', 1, 13, 'general', 1, '2015-04-01 21:22:14', '2015-04-01 22:19:07', 0, 0),
(8, 1, 'TEST3534960', 1, 13, 'general', 1, '2015-04-01 21:22:14', '2015-04-01 22:19:07', 0, 0),
(9, 1, 'TEST3535294', 1, 13, 'general', 1, '2015-04-01 21:22:15', '2015-04-01 22:19:07', 0, 0),
(10, 1, 'TEST3536195', 1, 13, 'general', 1, '2015-04-01 21:22:16', '2015-04-01 22:19:07', 0, 0);

--
-- Triggers `tickets`
--
DELIMITER //
CREATE TRIGGER `invalidate_ticket` BEFORE UPDATE ON `tickets`
 FOR EACH ROW BEGIN
IF NEW.validity = 0 THEN
    SET NEW.isactive=0;
END IF;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
`id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(500) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `emailid` varchar(50) NOT NULL,
  `age` int(11) NOT NULL,
  `city` varchar(50) NOT NULL,
  `mobilenumber` varchar(10) NOT NULL,
  `address` text NOT NULL,
  `interests` text NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `FB_Token` text NOT NULL,
  `GPlus_Token` text NOT NULL,
  `referredby` tinyint(1) NOT NULL,
  `creation_date` datetime NOT NULL,
  `last_update_date` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updatedby` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `fullname`, `emailid`, `age`, `city`, `mobilenumber`, `address`, `interests`, `isActive`, `FB_Token`, `GPlus_Token`, `referredby`, `creation_date`, `last_update_date`, `createdby`, `updatedby`) VALUES
(1, 'vamshi4001', 'adcc4d304f0a30cc4ffa9aa750345150', 'Vamshi Krishna', 'vamshi4001@gmail.com', 26, 'Bangalore', '7204448897', '', '', 1, '', '', 0, '2015-03-17 18:00:15', '2015-03-17 23:30:15', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `winners`
--

CREATE TABLE `winners` (
`id` int(11) NOT NULL,
  `contestid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `taskid` int(11) NOT NULL,
  `creation_date` datetime NOT NULL,
  `last_update_date` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updatedby` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `advertiser`
--
ALTER TABLE `advertiser`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contests`
--
ALTER TABLE `contests`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `referralcodes`
--
ALTER TABLE `referralcodes`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_questions`
--
ALTER TABLE `task_questions`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_videos`
--
ALTER TABLE `task_videos`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `winners`
--
ALTER TABLE `winners`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `advertiser`
--
ALTER TABLE `advertiser`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `contests`
--
ALTER TABLE `contests`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `referralcodes`
--
ALTER TABLE `referralcodes`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `task_questions`
--
ALTER TABLE `task_questions`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `task_videos`
--
ALTER TABLE `task_videos`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `winners`
--
ALTER TABLE `winners`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;