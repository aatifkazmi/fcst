-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 16, 2020 at 03:27 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `courses`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
CREATE TABLE IF NOT EXISTS `courses` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `cpd_units` int(10) NOT NULL,
  `approved_by_iirsm` int(1) NOT NULL,
  `duration` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `description`, `cpd_units`, `approved_by_iirsm`, `duration`) VALUES
(1, 'Ultimate Web Designer And Developer Course ', 'HTML is the building blocks of the web. It gives pages structure and applies meaning', 12, 1, '2'),
(2, ' Learn Angular Fundamentals From The Beginning ', 'Kick your Angular skills into action with this comprehensive dive into Angular and', 10, 1, '3');

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `courses_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_modules_courses1_idx` (`courses_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `courses_id`, `name`, `description`) VALUES
(1, 1, 'Module 1', 'Some desc'),
(2, 1, 'Module 2', 'ABC');

-- --------------------------------------------------------

--
-- Table structure for table `progress`
--

DROP TABLE IF EXISTS `progress`;
CREATE TABLE IF NOT EXISTS `progress` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `videos_id` int(10) NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`videos_id`,`user_id`,`status`),
  KEY `fk_progress_videos1_idx` (`videos_id`),
  KEY `fk_progress_users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `progress`
--

INSERT INTO `progress` (`user_id`, `videos_id`, `status`) VALUES
(1, 1, 'watched'),
(1, 2, 'watched'),
(1, 3, 'watched'),
(1, 4, 'watched'),
(1, 5, 'watching');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `quizzes_id` int(10) UNSIGNED NOT NULL,
  `question` text NOT NULL,
  `answers` text NOT NULL,
  `correct_answer_key` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_questions_quizzes1_idx` (`quizzes_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `quizzes_id`, `question`, `answers`, `correct_answer_key`) VALUES
(1, 1, 'What is main purpose of any thing', '{\"1\":\"Answer 1\",\"2\":\"Answer 2\",\"3\":\"Answer 3\",\"4\":\"Answer 4\"}', '2'),
(2, 1, 'Does this question make sense', '{\"1\":\"Answer 1\",\"2\":\"Answer 2\",\"3\":\"Answer 3\",\"4\":\"Answer 4\"}', '3'),
(3, 2, 'Will you pass this test', '{\"1\":\"Answer 1\",\"2\":\"Answer 2\",\"3\":\"Answer 3\",\"4\":\"Answer 4\"}', '2');

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

DROP TABLE IF EXISTS `quizzes`;
CREATE TABLE IF NOT EXISTS `quizzes` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `courses_id` int(10) UNSIGNED NOT NULL,
  `instructions` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_quizzes_courses1_idx` (`courses_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`id`, `courses_id`, `instructions`) VALUES
(1, 1, 'Some instruction'),
(2, 2, 'For modukle 2 instructions are here');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'Admin', 'admin@example.com', '$2y$10$WoTphXRAmz2DJ7DBMj9DFeJw4Ajku52dic2aloYdPwhmoHvAsQ7M2');

-- --------------------------------------------------------

--
-- Table structure for table `users_has_courses`
--

DROP TABLE IF EXISTS `users_has_courses`;
CREATE TABLE IF NOT EXISTS `users_has_courses` (
  `users_id` int(10) UNSIGNED NOT NULL,
  `courses_id` int(10) UNSIGNED NOT NULL,
  `status` varchar(45) NOT NULL DEFAULT 'in-progress',
  PRIMARY KEY (`users_id`,`courses_id`,`status`),
  KEY `fk_users_has_courses_courses1_idx` (`courses_id`),
  KEY `fk_users_has_courses_users1_idx` (`users_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_has_courses`
--

INSERT INTO `users_has_courses` (`users_id`, `courses_id`, `status`) VALUES
(1, 1, 'new'),
(1, 2, 'new');

-- --------------------------------------------------------

--
-- Table structure for table `user_answers`
--

DROP TABLE IF EXISTS `user_answers`;
CREATE TABLE IF NOT EXISTS `user_answers` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `users_id` int(10) UNSIGNED NOT NULL,
  `quiz_id` int(10) UNSIGNED NOT NULL,
  `questions_id` int(10) UNSIGNED NOT NULL,
  `user_answer_key` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_users_has_questions_questions1_idx` (`questions_id`),
  KEY `fk_users_has_questions_users_idx` (`users_id`),
  KEY `fk_users_has_questions_quizes_idx` (`quiz_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_answers`
--

INSERT INTO `user_answers` (`id`, `users_id`, `quiz_id`, `questions_id`, `user_answer_key`) VALUES
(1, 1, 1, 1, '4'),
(2, 1, 1, 2, '4');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

DROP TABLE IF EXISTS `videos`;
CREATE TABLE IF NOT EXISTS `videos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `modules_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(45) DEFAULT NULL,
  `file` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_videos_modules1_idx` (`modules_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`id`, `modules_id`, `title`, `file`) VALUES
(1, 1, 'Vid 1', 'sample-mp4-file.mp4'),
(2, 1, 'Vid 2', 'sample_3840x2160.mp4'),
(3, 2, 'Mod 2 Vid 1', 'COSTA RICA IN 4K 60fps HDR (ULTRA HD).mp4'),
(4, 2, 'Mod 2 Vid 2', 'file'),
(5, 2, 'Mod 2 Vid 3', 'file');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `modules`
--
ALTER TABLE `modules`
  ADD CONSTRAINT `fk_modules_courses1` FOREIGN KEY (`courses_id`) REFERENCES `courses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `progress`
--
ALTER TABLE `progress`
  ADD CONSTRAINT `fk_progress_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_progress_videos1` FOREIGN KEY (`videos_id`) REFERENCES `videos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `fk_questions_quizzes1` FOREIGN KEY (`quizzes_id`) REFERENCES `quizzes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `fk_quizzes_courses1` FOREIGN KEY (`courses_id`) REFERENCES `courses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users_has_courses`
--
ALTER TABLE `users_has_courses`
  ADD CONSTRAINT `fk_users_has_courses_courses1` FOREIGN KEY (`courses_id`) REFERENCES `courses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_has_courses_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_answers`
--
ALTER TABLE `user_answers`
  ADD CONSTRAINT `fk_users_has_questions_questions1` FOREIGN KEY (`questions_id`) REFERENCES `questions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_has_questions_quizes` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_has_questions_users` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `fk_videos_modules1` FOREIGN KEY (`modules_id`) REFERENCES `modules` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
