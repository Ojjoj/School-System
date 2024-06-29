-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 29, 2024 at 01:53 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `username` varchar(50) NOT NULL,
  `passwrd` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `first_name`, `last_name`, `username`, `passwrd`) VALUES
(23, 'Joe', 'Dornt', 'johndeo@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$ckpGZkdZV3RGZktXZzBiZA$0iWhDP8c3lVKxEpX3cHt+w9shUEcwyMw3ZfqihgXdE4'),
(25, 'Noro', 'Bar', 'foobar@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$cnE4NnlJbDU0aS5qZEJicw$dmKnW6AAVxYUirE3+jIMwzV3h1gQCwacrFs7KL0kZu8'),
(26, 'Nourman', 'Saadie', 'razansaadie@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$WEdKTGpEaGlzai82NWhrQg$qaI/IpF+uTzDbV12AuQK7aFJmmhhdChplI7rOdf0INg'),
(27, 'Karam', 'Kassem', 'karamkassem11@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$S21TSHc3VFh4Z1NPWHhkNw$ejC6qI3IA/NYxRMwWij3+9vvIPjX8jM+RxSp3/jDg0o'),
(28, 'Jolie', 'Dabouk', 'joliedabouk@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$L3E0bVFBUnoyRHYyL2xYcQ$YKBtM/tB1tlRaRnhkVaPIUtkzouUcaJoBLkH30PetaI');

-- --------------------------------------------------------

--
-- Table structure for table `assistant`
--

CREATE TABLE `assistant` (
  `assistant_id` int(42) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assistant`
--

INSERT INTO `assistant` (`assistant_id`, `first_name`, `last_name`, `email`) VALUES
(3, 'karam', 'karam', 'karamkassem133@gmail.com'),
(7, 'Ahmad', 'Jaber', 'karamkassem233@gmail.com'),
(8, 'Alan', 'One', 'alanone11@gmail.com'),
(9, 'Alan', 'One', 'alanone@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `bus`
--

CREATE TABLE `bus` (
  `bus_id` int(11) NOT NULL,
  `bus_name` varchar(50) NOT NULL,
  `driver_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `bus`
--

INSERT INTO `bus` (`bus_id`, `bus_name`, `driver_name`) VALUES
(24, 'Bus 1', 'Bo ali'),
(31, 'Bus 6', 'Ahmad');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` int(42) NOT NULL,
  `course_name` varchar(30) NOT NULL,
  `teacher_id` int(30) DEFAULT NULL,
  `image_path` varchar(255) NOT NULL,
  `start_date` varchar(50) NOT NULL,
  `end_date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `course_name`, `teacher_id`, `image_path`, `start_date`, `end_date`) VALUES
(3, 'Data Structure', 3, '../../media/course_image/Night Background.jpg\r\n', '2024-02-14', '2025-09-22'),
(4, 'Machine Learning', 6, '../../media/course_image/default_course_image.jpg', '', ''),
(26, 'Artificial Intelligence ', 7, '../../media/course_image/default_course_image.jpg', '', ''),
(27, 'Operating System', 9, '../../media/course_image/default_course_image.jpg', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `course_assistants`
--

CREATE TABLE `course_assistants` (
  `course_id` int(42) NOT NULL,
  `assistant_id` int(42) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_students`
--

CREATE TABLE `course_students` (
  `course_id` int(42) NOT NULL,
  `student_id` int(42) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `event_id` int(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(200) NOT NULL,
  `start_datetime` varchar(30) NOT NULL,
  `end_datetime` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`event_id`, `title`, `description`, `start_datetime`, `end_datetime`) VALUES
(1, 'Ramadan', 'some descriptions', '2024-03-10 10:30:00', '2024-03-10 11:30:00'),
(2, 'Ramadanaa', 'some descriptions', '2024-03-11T10:30', '2024-03-13T17:30'),
(4, 'ksd', 'dcds', '2024-03-10T15:30', '2024-03-10T17:30'),
(5, 'ksdfghj', 'dcds', '2024-03-10T15:30', '2024-03-10T17:30'),
(6, 'dcfvg', 'dcvfgb', '2024-03-25T13:33', '2024-03-10T16:34'),
(7, 'dfgh', 'dfghj', '2024-03-18T14:21', '2024-03-18T18:21'),
(8, 'dfghjk', 'fghjkl', '2024-03-17T14:24', '2024-03-17T19:24'),
(9, 'sdfgh', 'rthth', '2024-03-05T14:27', '2024-03-06T14:27'),
(15, 'Meeting', '123', '2024-03-15T22:15', '2024-03-15T23:15'),
(25, 'ltanen', 'ww', '2024-04-01T15:25', '2024-04-01T21:29'),
(26, 'ww', 'ww', '2024-04-12T15:25', '2024-04-12T16:25'),
(28, 'dd', 'dfg', '2024-04-27T13:40', '2024-04-27T14:40'),
(31, 'dfgh', 'dfghj', '2024-04-19T12:42', '2024-04-20T12:42'),
(33, 'ras', 'sd', '2024-04-26T17:00', '2024-04-26T19:00'),
(36, 'raznadfg', 'dga', '2024-04-21T18:30', '2024-04-21T19:30'),
(39, 'd', 'd', '2024-04-14T19:46', '2024-04-14T23:46'),
(40, 'x', 'sd', '2024-04-12T20:05', '2024-04-12T20:05'),
(42, 'Session', 'meeting with Elena', '2024-05-24T17:36', '2024-05-24T18:36'),
(43, 'Session', 'with jolie', '2024-06-28T18:59', '2024-06-28T19:15');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(42) NOT NULL,
  `real_id` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  `country` varchar(50) NOT NULL,
  `date_of_admission` text DEFAULT NULL,
  `father_name` varchar(50) DEFAULT NULL,
  `father_phone` varchar(50) DEFAULT NULL,
  `father_email` varchar(50) DEFAULT NULL,
  `mother_name` varchar(50) DEFAULT NULL,
  `mother_phone` varchar(50) DEFAULT NULL,
  `mother_email` varchar(50) DEFAULT NULL,
  `diagnosis` text NOT NULL,
  `medication` text DEFAULT NULL,
  `transportation` varchar(20) NOT NULL,
  `bus_id` int(11) DEFAULT NULL,
  `other` text DEFAULT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `real_id`, `first_name`, `last_name`, `gender`, `date_of_birth`, `country`, `date_of_admission`, `father_name`, `father_phone`, `father_email`, `mother_name`, `mother_phone`, `mother_email`, `diagnosis`, `medication`, `transportation`, `bus_id`, `other`, `status`) VALUES
(1, 'RS292138', 'razan', 'saadie', 'female', '2002-09-22', 'Syria', 'asdfasd', 'Ahmad', 'no number', '', 'Manal', 'no number', '', 'no diagnosis', 'asdfasdf', 'school_bus', 24, '', 'Active'),
(2, 'KK021237', 'karam', 'kassemooo', 'male', '2000-12-31', 'Belgium', '1', '', '', '', '', '', '', 'hjk', '', 'school_bus', NULL, '', 'Active'),
(3, 'KS022208', 'karamooo', 'saadie', 'female', '2000-02-12', 'Belarus', '655', '', '', '', '', '', '', 'jgy', '', 'own_transportation', NULL, '', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `teacher_id` int(30) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `job_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`teacher_id`, `first_name`, `last_name`, `email`, `job_description`) VALUES
(3, 'karam', 'Kassem', 'karamkassem133@gmail.com', 'no job'),
(6, 'Razan', 'saadie', 'razan@gmail.com', 'ye job'),
(7, 'Rona', 'One', 'ronaone@gmail.com', 'blabla'),
(8, 'Rami', 'Won', 'ramiwon@gmail.com', 'blabla'),
(9, 'Farah', 'Dohn', 'farahdohn@gmail.com', 'blabla');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assistant`
--
ALTER TABLE `assistant`
  ADD PRIMARY KEY (`assistant_id`);

--
-- Indexes for table `bus`
--
ALTER TABLE `bus`
  ADD PRIMARY KEY (`bus_id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `course_assistants`
--
ALTER TABLE `course_assistants`
  ADD PRIMARY KEY (`course_id`,`assistant_id`),
  ADD KEY `assistant_id` (`assistant_id`);

--
-- Indexes for table `course_students`
--
ALTER TABLE `course_students`
  ADD PRIMARY KEY (`course_id`,`student_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`teacher_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `assistant`
--
ALTER TABLE `assistant`
  MODIFY `assistant_id` int(42) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `bus`
--
ALTER TABLE `bus`
  MODIFY `bus_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course_id` int(42) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `event_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(42) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `teacher_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course_assistants`
--
ALTER TABLE `course_assistants`
  ADD CONSTRAINT `course_assistants_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_assistants_ibfk_2` FOREIGN KEY (`assistant_id`) REFERENCES `assistant` (`assistant_id`) ON DELETE CASCADE;

--
-- Constraints for table `course_students`
--
ALTER TABLE `course_students`
  ADD CONSTRAINT `course_students_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_students_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
