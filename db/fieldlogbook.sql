-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2024 at 07:58 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fieldlogbook`
--

-- --------------------------------------------------------

--
-- Table structure for table `coordinator`
--

CREATE TABLE `coordinator` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `visiting_supervisor` int(11) DEFAULT NULL,
  `report_supervisor` int(11) DEFAULT NULL,
  `student` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `coordinator`
--

INSERT INTO `coordinator` (`id`, `username`, `password`, `visiting_supervisor`, `report_supervisor`, `student`) VALUES
(2, 'coordinator', 'coordinator', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `days`
--

CREATE TABLE `days` (
  `id` int(11) NOT NULL,
  `day` int(11) NOT NULL DEFAULT 1,
  `title` varchar(100) NOT NULL,
  `comments` text NOT NULL,
  `student` int(11) NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp(),
  `weekno` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `days`
--

INSERT INTO `days` (`id`, `day`, `title`, `comments`, `student`, `time`, `weekno`) VALUES
(129, 1, 'd', 's', 3, '2024-06-29 12:44:55', 1),
(130, 2, 'df', 'dfd', 3, '2024-06-29 12:44:58', 1),
(131, 1, 'truncating test', 'tried to fix a length of the database comment side that it ain\'t be too long rather be truncated.', 2, '2024-06-29 12:45:38', 1),
(132, 2, 'bvcb', 'gfgfg', 2, '2024-06-29 12:48:42', 1),
(133, 3, 'c', 'a', 2, '2024-06-29 14:26:50', 1),
(134, 3, 'hgfh', 'hfgh', 3, '2024-06-30 02:28:26', 1),
(135, 4, 'gfhfdgh', 'fdhfdg', 3, '2024-06-30 02:28:52', 1);

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `student` int(11) NOT NULL,
  `file` varchar(100) NOT NULL,
  `comments` text NOT NULL,
  `upload_date` datetime NOT NULL DEFAULT current_timestamp(),
  `draft` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `student`, `file`, `comments`, `upload_date`, `draft`) VALUES
(3, 2, 'uploads/pexels-eberhardgross-640781.jpg', 'done commenting', '2024-06-19 04:47:39', 1),
(7, 2, 'uploads/GHARAMA ZA KUTENGENEZA MFUMO.docx', 'document doesn\'t match the expected needs', '2024-06-19 04:48:57', 1),
(8, 3, 'uploads/final-exam (1).pdf', '', '2024-06-30 03:39:06', 1),
(14, 2, 'uploads/pexels-eberhardgross-640781.jpg', '', '2024-07-02 23:12:58', 2);

-- --------------------------------------------------------

--
-- Table structure for table `field_selection`
--

CREATE TABLE `field_selection` (
  `id` int(11) NOT NULL,
  `student` int(11) NOT NULL,
  `organization` int(11) NOT NULL,
  `location` varchar(100) NOT NULL,
  `email` varchar(60) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `verification` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `field_selection`
--

INSERT INTO `field_selection` (`id`, `student`, `organization`, `location`, `email`, `status`, `verification`) VALUES
(1, 2, 25, 'Dar-es-salaam-temeke-center', 'nhif@website.com', 1, 0),
(2, 3, 17, 'Dar-es-salaam-msimbazi-12street', 'muhas@muhas.com', 1, 0),
(6, 3, 21, 'Dar-es-salaam-temeke-center', 'dozzer.ifm@gmail.com', 1, 0),
(7, 2, 21, 'Zanzibar- forodhani-police', 'dozzer@gmail.com', 1, 1),
(8, 2, 23, 'Dar-es-salaam-temeke-center', 'kuznet.ifm@gmail.com', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `host_supervisor`
--

CREATE TABLE `host_supervisor` (
  `id` int(11) NOT NULL,
  `supervisor_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(60) NOT NULL,
  `office_no` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `host_supervisor`
--

INSERT INTO `host_supervisor` (`id`, `supervisor_name`, `username`, `password`, `phone`, `email`, `office_no`) VALUES
(2, 'first supervisor', 'host', 'host', '0711223344', 'host@gmail.com', '121');

-- --------------------------------------------------------

--
-- Table structure for table `host_supervisor_comments`
--

CREATE TABLE `host_supervisor_comments` (
  `id` int(11) NOT NULL,
  `student` int(11) NOT NULL,
  `weekno` int(11) NOT NULL,
  `comments` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `host_supervisor_comments`
--

INSERT INTO `host_supervisor_comments` (`id`, `student`, `weekno`, `comments`) VALUES
(1, 2, 1, 'Week went well, student keep delaying in attendance, he has to be more punctual that\'s it.'),
(4, 2, 2, 'oky week 2'),
(5, 3, 1, 'not bad');

-- --------------------------------------------------------

--
-- Table structure for table `logbook`
--

CREATE TABLE `logbook` (
  `id` int(11) NOT NULL,
  `weeks` int(11) NOT NULL,
  `comments` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

CREATE TABLE `organization` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `visitation` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `organization`
--

INSERT INTO `organization` (`id`, `name`, `visitation`) VALUES
(17, 'Bugando_Mwanza', NULL),
(19, 'TRC dodoma', NULL),
(21, 'zanzibar utalihi', NULL),
(22, 'muhimbili B', NULL),
(23, 'TRC dodoma', NULL),
(25, 'NHIF', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `report_supervisor`
--

CREATE TABLE `report_supervisor` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(60) NOT NULL,
  `office_no` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `report_supervisor`
--

INSERT INTO `report_supervisor` (`id`, `full_name`, `phone`, `email`, `office_no`, `username`, `password`) VALUES
(1, 'first reporter\'s name', '0788776655', 'reporter@gmail.com', 310, 'reporter', 'reporter'),
(2, 'second reporter\'s name', '0766558877', 'reporter1@gmail.com', 407, 'reporter1', 'reporter1'),
(3, 'third reporter\'s name', '070085656', 'reporter2@gmail.com', 413, 'reporter2', 'reporter2');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `index_no` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `course` varchar(15) NOT NULL DEFAULT 'BIT',
  `year` int(11) NOT NULL DEFAULT 1,
  `password` varchar(100) NOT NULL,
  `logbook` int(11) DEFAULT 0,
  `visitation` int(11) DEFAULT 0,
  `report_supervisor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `index_no`, `name`, `contact`, `course`, `year`, `password`, `logbook`, `visitation`, `report_supervisor`) VALUES
(2, 'IMC/BIT/11223344', 'lorem ipsum', '0711223344', 'BIT', 1, '11223344', 1, 0, 2),
(3, 'IMC/BIT/55667788', 'oldores ibsan', '0755667788', 'BEF', 2, '55667788', 1, 1, 2),
(5, 'IMC/BIT/00000', 'IMC/BIT/00000', '', 'BIT', 1, 'dozzer', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `visiting_organization`
--

CREATE TABLE `visiting_organization` (
  `id` int(11) NOT NULL,
  `visitor` int(11) NOT NULL,
  `organization` int(11) NOT NULL,
  `visitation` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `visiting_organization`
--

INSERT INTO `visiting_organization` (`id`, `visitor`, `organization`, `visitation`) VALUES
(1, 2, 19, ''),
(2, 1, 25, '2024-07-10'),
(5, 2, 23, ''),
(6, 2, 21, '2024-07-17'),
(8, 2, 17, '2024-06-12');

-- --------------------------------------------------------

--
-- Table structure for table `visiting_supervisor`
--

CREATE TABLE `visiting_supervisor` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(60) NOT NULL,
  `office_no` int(5) NOT NULL,
  `password` varchar(100) NOT NULL,
  `organization` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `visiting_supervisor`
--

INSERT INTO `visiting_supervisor` (`id`, `full_name`, `username`, `phone`, `email`, `office_no`, `password`, `organization`) VALUES
(1, 'first visitor', 'visitor', '0711223344', 'teacher@ifm.co.tz', 432, 'visitor', 17),
(2, 'second visitor', 'visitor1', '0755667788', 'teacher1@ifm.co.tz', 603, 'visitor1', 22);

-- --------------------------------------------------------

--
-- Table structure for table `visiting_supervisor_comments`
--

CREATE TABLE `visiting_supervisor_comments` (
  `id` int(11) NOT NULL,
  `visitor` int(11) NOT NULL,
  `student` int(11) NOT NULL,
  `comments` text NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `visiting_supervisor_comments`
--

INSERT INTO `visiting_supervisor_comments` (`id`, `visitor`, `student`, `comments`, `date`) VALUES
(1, 2, 2, 'reviewed this student properly', '2024-06-29'),
(2, 2, 3, 'visitation on this student is successful', '2024-06-29'),
(3, 2, 2, 'done', '2024-06-29'),
(4, 2, 2, 'done', '2024-06-29'),
(5, 2, 3, 'oik', '2024-06-29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `coordinator`
--
ALTER TABLE `coordinator`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student` (`student`),
  ADD KEY `report_supervisor` (`report_supervisor`),
  ADD KEY `visiting_supervisor` (`visiting_supervisor`);

--
-- Indexes for table `days`
--
ALTER TABLE `days`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `field_selection`
--
ALTER TABLE `field_selection`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `host_supervisor`
--
ALTER TABLE `host_supervisor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `host_supervisor_comments`
--
ALTER TABLE `host_supervisor_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `weekno` (`weekno`);

--
-- Indexes for table `logbook`
--
ALTER TABLE `logbook`
  ADD PRIMARY KEY (`id`),
  ADD KEY `weeks` (`weeks`);

--
-- Indexes for table `organization`
--
ALTER TABLE `organization`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department` (`visitation`);

--
-- Indexes for table `report_supervisor`
--
ALTER TABLE `report_supervisor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `logbook` (`logbook`);

--
-- Indexes for table `visiting_organization`
--
ALTER TABLE `visiting_organization`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visiting_supervisor`
--
ALTER TABLE `visiting_supervisor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `visiting_supervisor_ibfk_2` (`organization`);

--
-- Indexes for table `visiting_supervisor_comments`
--
ALTER TABLE `visiting_supervisor_comments`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `coordinator`
--
ALTER TABLE `coordinator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `days`
--
ALTER TABLE `days`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `field_selection`
--
ALTER TABLE `field_selection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `host_supervisor`
--
ALTER TABLE `host_supervisor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `host_supervisor_comments`
--
ALTER TABLE `host_supervisor_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `logbook`
--
ALTER TABLE `logbook`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `organization`
--
ALTER TABLE `organization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `report_supervisor`
--
ALTER TABLE `report_supervisor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `visiting_organization`
--
ALTER TABLE `visiting_organization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `visiting_supervisor`
--
ALTER TABLE `visiting_supervisor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `visiting_supervisor_comments`
--
ALTER TABLE `visiting_supervisor_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
