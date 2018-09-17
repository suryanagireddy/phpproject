-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 16, 2018 at 06:07 AM
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
(7, 'Surya'),
(9, 'Mangoo'),
(10, 'php'),
(11, 'Flowers');

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
(13, 1, 'fcfg', 'rtcftcf@vghvh.coo', 'gvhvh ', 'Approved', '2018-09-09'),
(14, 9, 'jfdbvgjdn', 'dvs@gmail.com', 'jdnjdsnfvjs', 'Approved', '2018-09-15'),
(15, 9, 'ihifhis', 'shhh@gmail.com', 'fuhseudhf', 'Approved', '2018-09-15'),
(16, 5, 'the', 'dsnjsdn@gmmail.com', 'dmkdsmfkerm', 'Unapproved', '2018-09-15'),
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

INSERT INTO `posts` (`post_id`, `post_category_id`, `post_title`, `post_author`, `post_date`, `post_image`, `post_content`, `post_tags`, `post_comment_count`, `post_status`, `post_views_count`) VALUES
(1, 7, 'First post', 'surya', '2018-09-14', '1 (8).jpg', '<p>learning phpppp ,,,, 55%</p>', 'surya, kanna', 3, 'published', 0),
(5, 10, 'rvgbhnj', 'surya', '2018-09-15', '0TLWlV548575-02.jpg', '<p>xcfvgbhnj jgbhbm</p>', 'ecrvtgbhnj', 2, 'published', 0),
(6, 11, 'jbsjf', 'kanna', '2018-09-15', '1 (7).jpg', '<p>awkfmksmf</p>', 'sefnjsdnf', 1, 'published', 0),
(9, 9, 'heyyyy', 'kanna', '2018-09-15', '1 (37).jpg', '<p>dsngsdfjs</p>', 'jsdfn', 2, 'published', 0),
(22, 9, 'heyyyy', 'kanna', '2018-09-15', '1 (37).jpg', '<p>dsngsdfjs</p>', 'jsdfn', 0, 'published', 0),
(23, 11, 'jbsjf', 'kanna', '2018-09-15', '1 (7).jpg', '<p>awkfmksmf</p>', 'sefnjsdnf', 0, 'published', 0),
(24, 10, 'rvgbhnj', 'surya', '2018-09-15', '0TLWlV548575-02.jpg', '<p>xcfvgbhnj jgbhbm</p>', 'ecrvtgbhnj', 0, 'published', 0),
(25, 7, 'First post', 'surya', '2018-09-15', '1 (8).jpg', '<p>learning phpppp ,,,, 55%</p>', 'surya, kanna', 0, 'published', 1);

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
(1, 'surya', '$1$sP4.FT/.$kC6gU3YPYCijQg4LVN2yb0', 'Surya Rao', 'Nagireddy', 'surya@gmail.com', '1 (27).jpg', 'Admin', '2018-09-15', ''),
(3, 'kanna', '$1$q6..rI/.$gyGjPQrZOHPeQNa/IGVM10', 'kanna', 'sdjfnsjdfn', 'dfjbnsjdfnjsnd@gmail.com', '1 (9).jpg', 'Subscriber', '2018-09-15', ''),
(5, 'nagireddy', '$1$Ye5.B.4.$EFjeQCjmaDYfIF194yDZH/', 'nagireddy', 'n', 'nagireddy@gmail.com', '1 (2).jpg', 'Editor', '2018-09-15', ''),
(9, 'jdbjsd', 'dfhbdhsb', '', '', 'dhgv@jnfhb.com', '', 'Subscriber', '2018-09-15', '$2y$10$iusesomecrazystrings22'),
(10, 'demooo', '$1$5f4.oX2.$fNgsUDf6pjkhf4aCxhEpt0', '', '', 'demo@gmail.com', '', 'Subscriber', '2018-09-15', '$2y$10$iusesomecrazystrings22'),
(11, 'demo', '$1$Ge2.Xl4.$k23fO9ckqr3vtbTHhOQ4j1', '', '', 'demooo@gmail.com', '', 'Subscriber', '2018-09-15', '$2y$10$iusesomecrazystrings22');

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
(2, 'ri9bej6tqkthibf12i7s3b59o6', 1537022329);

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
  MODIFY `post_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users_online`
--
ALTER TABLE `users_online`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
