-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2018 at 03:59 AM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.0.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(4) NOT NULL,
  `cat_title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_title`) VALUES
(7, 'Technology'),
(9, 'Sports'),
(10, 'Food'),
(11, 'News');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(5) NOT NULL,
  `comment_post_id` int(5) NOT NULL,
  `comment_author` varchar(255) NOT NULL,
  `comment_email` varchar(255) NOT NULL,
  `comment_content` text NOT NULL,
  `comment_status` varchar(255) NOT NULL,
  `comment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `comment_post_id`, `comment_author`, `comment_email`, `comment_content`, `comment_status`, `comment_date`) VALUES
(2, 1, 'ioshgisjnd', 'sdfnsjdgn', 'jnsdgjsdng', 'Approved', '2018-09-08'),
(5, 1, 'xcvybuihnun', 'erxcvy2vv@vvyh.gc', 'rtxctgvtest', 'Approved', '2018-09-08'),
(14, 9, 'jfdbvgjdn', 'dvs@gmail.com', 'jdnjdsnfvjs', 'Approved', '2018-09-15'),
(15, 9, 'ihifhis', 'shhh@gmail.com', 'fuhseudhf', 'Approved', '2018-09-15'),
(16, 5, 'the', 'dsnjsdn@gmmail.com', 'dmkdsmfkerm', 'Approved', '2018-09-15'),
(17, 6, 'jbsdjb', 'jzbxdh@jndj.coo', 'sajfgbsdbjhdbs', 'Unapproved', '2018-09-15'),
(18, 5, 'jbchbs', 'hbas@gmail.com', 'dbsdbchjsbc', 'Unapproved', '2018-09-15');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(10) NOT NULL,
  `post_category_id` int(10) NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_author` varchar(255) NOT NULL,
  `post_user` varchar(255) NOT NULL,
  `post_date` date NOT NULL,
  `post_image` text NOT NULL,
  `post_content` text NOT NULL,
  `post_tags` varchar(255) NOT NULL,
  `post_comment_count` int(10) NOT NULL,
  `post_status` varchar(255) NOT NULL DEFAULT 'draft',
  `post_views_count` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `post_category_id`, `post_title`, `post_author`, `post_user`, `post_date`, `post_image`, `post_content`, `post_tags`, `post_comment_count`, `post_status`, `post_views_count`) VALUES
(1, 7, 'First post', 'surya', '', '2018-09-14', '1 (8).jpg', '<p>learning phpppp ,,,, 55%</p>', 'surya, kanna', 3, 'published', 14),
(5, 10, 'rvgbhnj', 'surya', '', '2018-09-15', '0TLWlV548575-02.jpg', '<p>xcfvgbhnj jgbhbm</p>', 'ecrvtgbhnj', 2, 'published', 0),
(6, 11, 'jbsjf', 'kanna', '', '2018-09-15', '1 (7).jpg', '<p>awkfmksmf</p>', 'sefnjsdnf', 1, 'published', 0),
(9, 9, 'heyyyy', 'kanna', '', '2018-09-15', '1 (37).jpg', '<p>dsngsdfjs</p>', 'jsdfn', 2, 'published', 0),
(22, 9, 'heyyyy', 'kanna', '', '2018-09-15', '1 (37).jpg', '<p>dsngsdfjs</p>', 'jsdfn', 0, 'published', 0),
(23, 11, 'jbsjf', 'shilpa', '', '2018-09-16', '1 (7).jpg', '<p>awkfmksmf</p>', 'sefnjsdnf', 0, 'published', 0),
(24, 10, 'rvgbhnj', 'surya', '', '2018-09-15', '0TLWlV548575-02.jpg', '<p>xcfvgbhnj jgbhbm</p>', 'ecrvtgbhnj', 0, 'published', 0),
(25, 7, 'First post', 'nagireddy', '', '2018-09-16', '1 (8).jpg', '<p>learning phpppp ,,,, 55%</p>', 'surya, kanna', 0, 'published', 1),
(26, 10, 'sjshdfjsdbj', 'kanna', '', '2018-09-16', '(Fren)..jpg', '<p>sdknksnf</p>', 'sjdbjasbn', 0, 'published', 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(5) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_firstname` varchar(255) NOT NULL,
  `user_lastname` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_image` text NOT NULL,
  `user_role` varchar(255) NOT NULL,
  `user_date` date NOT NULL,
  `randSalt` varchar(255) NOT NULL DEFAULT '$2y$10$iusesomecrazystrings22'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_password`, `user_firstname`, `user_lastname`, `user_email`, `user_image`, `user_role`, `user_date`, `randSalt`) VALUES
(1, 'surya', '$2y$12$T4/hxqOybcRdZgm6m8iKQOJT.AJGqsLX74lSor7sosMAaY1/ZbCpa', 'Surya Rao', 'Nagireddy', 'surya@gmail.com', '1 (27).jpg', 'Admin', '2018-09-16', ''),
(3, 'kanna', '$2y$12$Zl.pjCW4Gc/9eU6no4TVUu8aOECBYNrnhLx/RicgI.4mXWpNIJckK', 'kanna', 'S', 'kanna@gmail.com', '1 (9).jpg', 'Admin', '2018-09-16', ''),
(5, 'nagireddy', '$2y$12$Qhkkxw/qNODqOzqi/6z5/uL2URqChym6OQc9eW6tA5cdkIBWEzzBC', 'Chinna', 'Nagireddy', 'nagireddy@gmail.com', '1 (2).jpg', 'Editor', '2018-09-16', ''),
(14, 'vish', '$2y$12$NugkCJ95sLdW5WnK5BvGLuxOgSOu3iFf0w60WOi9M2Z1R5O1.9qk2', 'Vish', 'Awate', 'vish@gmail.com', 'asterix_10.jpg', 'Editor', '2018-09-16', '$2y$10$iusesomecrazystrings22'),
(15, 'kalyani', '$2y$10$ZO.LpaSRbr3izrZj8Dq3delY7S91TkBsdIXJekb2VlpvL.Uae3lJK', 'Kalyani', 'Nagireddy', 'kalyani@gmail.com', '1 (35).jpg', 'Editor', '2018-09-16', '$2y$10$iusesomecrazystrings22');

-- --------------------------------------------------------

--
-- Table structure for table `users_online`
--

CREATE TABLE `users_online` (
  `id` int(10) NOT NULL,
  `session` varchar(255) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_online`
--

INSERT INTO `users_online` (`id`, `session`, `time`) VALUES
(1, '9drntuuesqku7s0ackcpv3sef0', 1537062635),
(2, 'ri9bej6tqkthibf12i7s3b59o6', 1537022329),
(3, '55p3g5o2ujroa7amo1mb0g3b91', 1537083427),
(4, 'cvef9krrldh608aik5l52a4jq4', 1537104233),
(5, 'vh8mvijd1teobqingnn5v44tv4', 1537192568);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `users_online`
--
ALTER TABLE `users_online`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users_online`
--
ALTER TABLE `users_online`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
