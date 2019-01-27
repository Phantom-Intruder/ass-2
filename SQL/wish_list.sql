-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2019 at 03:58 PM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `wish_list`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('04ed5f61osm94r4q0rhu22n6u4ankaav', '::1', 1548579978, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534383537393630343b776973684c69737449647c693a323b66697273744e616d657c733a373a22536f6d656f6e65223b),
('5993cdoeknm8atujtrv1qaf8aclsn3ea', '::1', 1548575206, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534383537353038373b776973684c69737449647c693a323b66697273744e616d657c733a373a22536f6d656f6e65223b),
('68eju99cgu53n5rhgd32hfe1kr30mbho', '::1', 1548583102, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534383538323836343b),
('7c1vcg5bhndqr0q7906dnqd7se9lq3lj', '::1', 1548579217, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534383537383936393b776973684c69737449647c693a323b66697273744e616d657c733a373a22536f6d656f6e65223b),
('9diu04lotg10gb3ihcqt1l59uhenc7o1', '::1', 1548580394, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534383538303130313b776973684c69737449647c693a323b66697273744e616d657c733a373a22536f6d656f6e65223b),
('e4t32nii8hjnti3k4ifsvm7m271c4844', '::1', 1548583355, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534383538333232393b),
('ege6a1ag7r0thfi426dibh7gr9316abg', '::1', 1548581999, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534383538313830383b776973684c69737449647c693a323b66697273744e616d657c733a373a22536f6d656f6e65223b),
('gp9soevci6aeitq7kq8adtsrg4tj72q8', '::1', 1548581782, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534383538313439373b776973684c69737449647c693a323b66697273744e616d657c733a373a22536f6d656f6e65223b),
('hhmpaqrlj9h4j6o3385v2rqo1oesqtdl', '::1', 1548580925, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534383538303931323b776973684c69737449647c693a323b66697273744e616d657c733a373a22536f6d656f6e65223b),
('ivp61e9rqditnb7cvjg60ugitcftf5hk', '::1', 1548582440, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534383538323139313b776973684c69737449647c693a323b66697273744e616d657c733a373a22536f6d656f6e65223b),
('jtvgm84f0vp3bku5of3r13h8ravf8cfv', '::1', 1548576025, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534383537353735363b776973684c69737449647c693a323b66697273744e616d657c733a373a22536f6d656f6e65223b),
('nvgc42vnd1sl77nlo0llpoljcborvh5q', '::1', 1548579502, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534383537393330323b776973684c69737449647c693a323b66697273744e616d657c733a373a22536f6d656f6e65223b),
('q04ui5b77ah9nkfuuk6htcmoualiiip0', '::1', 1548578606, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534383537383431313b776973684c69737449647c693a323b66697273744e616d657c733a373a22536f6d656f6e65223b),
('qdeevq6km1phv9okp5sglj99e5sk0a5h', '::1', 1548576311, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534383537363038363b776973684c69737449647c693a323b66697273744e616d657c733a373a22536f6d656f6e65223b),
('vi5aon32qbcb9ahktnm6on9qf729f21g', '::1', 1548582808, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534383538323536323b);

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE IF NOT EXISTS `item` (
`id` int(11) NOT NULL,
  `listId` int(11) NOT NULL,
  `title` varchar(500) NOT NULL,
  `url` varchar(500) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `priority` int(11) NOT NULL,
  `itemCreated` date NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `listId`, `title`, `url`, `price`, `priority`, `itemCreated`) VALUES
(19, 1, 'Tutorial 2 - 2015045', 'https://www.youtube.com/watch?v=51b7tZGKrGo', '3.00', 2, '2019-01-27'),
(20, 1, 'Tutorial 2 - 2015045', 'https://www.youtube.com/watch?v=51b7tZGKrGo', '2.00', 3, '2019-01-27'),
(22, 1, 'edited', 'dd', '99.99', 1, '2019-01-27'),
(23, 1, 'lec 3 short note 2015045', 'https://www.youtube.com/watch?v=51b7tZGKrGo', '18000.00', 1, '2019-01-27'),
(26, 2, 'lec 3 short note 2015045', 'https://www.youtube.com/watch?v=51b7tZGKrGo', '2.00', 2, '2019-01-27'),
(27, 2, 'shortnote - 2015045', 'https://www.youtube.com/watch?v=51b7tZGKrGo', '4.00', 3, '2019-01-27');

-- --------------------------------------------------------

--
-- Table structure for table `priority`
--

CREATE TABLE IF NOT EXISTS `priority` (
`id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `priorityNumber` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`id` int(11) NOT NULL,
  `firstName` varchar(500) NOT NULL,
  `username` varchar(500) NOT NULL,
  `password` varchar(500) NOT NULL,
  `dateCreated` date NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstName`, `username`, `password`, `dateCreated`) VALUES
(1, 'Unknown', 'admin', '$2y$10$1hg.9WZ2yeLJngwLdmSoUuWNlv3KaylmG9/ZqwFpg50eHD7OUJ6z.', '2019-01-26'),
(2, 'Someone', 'testUsr', '$2y$10$sa/K7iTVg3cPOjK.9zYPAe2JNHjxnaoyfY2nbD.t9OoFFkskF30mC', '2019-01-27');

-- --------------------------------------------------------

--
-- Table structure for table `user_list`
--

CREATE TABLE IF NOT EXISTS `user_list` (
`id` int(11) NOT NULL,
  `ownerId` int(11) NOT NULL,
  `listName` varchar(500) NOT NULL,
  `description` varchar(500) NOT NULL,
  `listCreated` date NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user_list`
--

INSERT INTO `user_list` (`id`, `ownerId`, `listName`, `description`, `listCreated`) VALUES
(1, 1, 'new List ', 'This is a new list ', '2019-01-26'),
(2, 2, 'Christmas list', 'List for christmas', '2019-01-27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
 ADD PRIMARY KEY (`id`), ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `priority`
--
ALTER TABLE `priority`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_list`
--
ALTER TABLE `user_list`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `priority`
--
ALTER TABLE `priority`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user_list`
--
ALTER TABLE `user_list`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
