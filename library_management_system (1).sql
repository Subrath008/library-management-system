-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2026 at 02:47 PM
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
-- Database: `library_management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `body` text DEFAULT NULL,
  `published_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `branch_id`, `author_id`, `title`, `body`, `published_at`) VALUES
(1, 1, 2, 'Library Notice', 'The library will remain open during regular hours.', '2026-05-17 12:31:39'),
(2, NULL, 4, 'Platform Notice', 'Welcome to the Library Management System.', '2026-05-17 12:31:39');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `isbn` varchar(50) DEFAULT NULL,
  `genre_id` int(11) DEFAULT NULL,
  `publisher` varchar(255) DEFAULT NULL,
  `published_year` year(4) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `cover_image_path` varchar(255) DEFAULT NULL,
  `is_available` tinyint(4) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `isbn`, `genre_id`, `publisher`, `published_year`, `description`, `cover_image_path`, `is_available`, `created_at`) VALUES
(1, 'Clean Code', 'Robert C. Martin', '9780132350884', 1, 'Prentice Hall', '2008', 'A guide to writing clean and maintainable code.', 'assets/uploads/1779021619_clean_code.jpg', 1, '2026-05-17 12:31:39'),
(2, 'Database System Concepts', 'Abraham Silberschatz', '9780073523323', 2, 'McGraw Hill', '2019', 'A database systems textbook.', 'assets/uploads/1779021572_database_book.jpg', 1, '2026-05-17 12:31:39'),
(3, 'Computer Networks', 'Andrew S. Tanenbaum', '9780132126953', 3, 'Pearson', '2010', 'Introduction to computer networking.', 'assets/uploads/1779021531_Computer_network.jpg', 1, '2026-05-17 12:31:39'),
(4, 'Artificial Intelligence: A Modern Approach', 'Stuart Russell', '9780136042594', 4, 'Pearson', '2021', 'A foundational AI textbook.', 'assets/uploads/1779021517_artificial.jpg', 1, '2026-05-17 12:31:39'),
(5, 'Introduction to Sociology', 'Anthony Giddens', '9780393932320', 5, 'Polity Press', '2020', 'A basic sociology textbook.', 'assets/uploads/1779021431_antohony.jpg', 1, '2026-05-17 12:31:39');

-- --------------------------------------------------------

--
-- Table structure for table `book_reviews`
--

CREATE TABLE `book_reviews` (
  `id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `review_text` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book_reviews`
--

INSERT INTO `book_reviews` (`id`, `book_id`, `member_id`, `rating`, `review_text`, `created_at`) VALUES
(1, 1, 1, 5, 'Very useful book.', '2026-05-17 12:31:39'),
(2, 2, 1, 4, 'Good database textbook.', '2026-05-17 12:31:39');

-- --------------------------------------------------------

--
-- Table structure for table `borrow_records`
--

CREATE TABLE `borrow_records` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `librarian_id` int(11) DEFAULT NULL,
  `status` enum('pending','active','returned','rejected') DEFAULT 'pending',
  `rejection_reason` text DEFAULT NULL,
  `borrow_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `renewals_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrow_records`
--

INSERT INTO `borrow_records` (`id`, `member_id`, `book_id`, `branch_id`, `librarian_id`, `status`, `rejection_reason`, `borrow_date`, `due_date`, `return_date`, `renewals_count`) VALUES
(1, 1, 1, 1, 2, 'pending', NULL, NULL, NULL, NULL, 0),
(2, 1, 2, 1, 2, 'active', NULL, '2026-05-17', '2026-05-31', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `manager_id` int(11) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `name`, `address`, `city`, `phone`, `manager_id`, `is_active`, `created_at`) VALUES
(1, 'Main Branch', '123 Library Road', 'Denton', '9401111111', 3, 1, '2026-05-17 12:31:39'),
(2, 'North Branch', '456 North Street', 'Denton', '9402222222', NULL, 1, '2026-05-17 12:31:39');

-- --------------------------------------------------------

--
-- Table structure for table `branch_inventory`
--

CREATE TABLE `branch_inventory` (
  `id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `total_copies` int(11) DEFAULT 0,
  `available_copies` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branch_inventory`
--

INSERT INTO `branch_inventory` (`id`, `book_id`, `branch_id`, `total_copies`, `available_copies`) VALUES
(1, 1, 1, 5, 5),
(2, 2, 1, 4, 4),
(3, 3, 1, 3, 3),
(4, 4, 1, 2, 2),
(5, 5, 1, 6, 6);

-- --------------------------------------------------------

--
-- Table structure for table `branch_policies`
--

CREATE TABLE `branch_policies` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `max_borrow_days` int(11) DEFAULT 14,
  `max_books_per_member` int(11) DEFAULT 5,
  `fine_rate_per_day` decimal(10,2) DEFAULT 5.00,
  `max_renewals` int(11) DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branch_policies`
--

INSERT INTO `branch_policies` (`id`, `branch_id`, `max_borrow_days`, `max_books_per_member`, `fine_rate_per_day`, `max_renewals`) VALUES
(1, 1, 14, 5, 5.00, 2),
(2, 2, 10, 3, 3.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `fines`
--

CREATE TABLE `fines` (
  `id` int(11) NOT NULL,
  `borrow_record_id` int(11) DEFAULT NULL,
  `member_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `is_paid` tinyint(4) DEFAULT 0,
  `paid_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fines`
--

INSERT INTO `fines` (`id`, `borrow_record_id`, `member_id`, `branch_id`, `amount`, `reason`, `is_paid`, `paid_at`) VALUES
(1, 2, 1, 1, 25.00, 'Sample overdue fine', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`id`, `name`) VALUES
(1, 'Programming'),
(2, 'Database'),
(3, 'Networking'),
(4, 'Artificial Intelligence'),
(5, 'Sociology'),
(6, 'Web Development');

-- --------------------------------------------------------

--
-- Table structure for table `inter_branch_requests`
--

CREATE TABLE `inter_branch_requests` (
  `id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `from_branch_id` int(11) NOT NULL,
  `to_branch_id` int(11) NOT NULL,
  `requested_by` int(11) NOT NULL,
  `status` enum('pending','approved','rejected','completed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inter_branch_requests`
--

INSERT INTO `inter_branch_requests` (`id`, `book_id`, `from_branch_id`, `to_branch_id`, `requested_by`, `status`, `created_at`) VALUES
(1, 1, 1, 2, 3, 'pending', '2026-05-17 12:31:39');

-- --------------------------------------------------------

--
-- Table structure for table `reading_lists`
--

CREATE TABLE `reading_lists` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reading_lists`
--

INSERT INTO `reading_lists` (`id`, `member_id`, `book_id`, `added_at`) VALUES
(1, 1, 4, '2026-05-17 12:31:39'),
(2, 1, 5, '2026-05-17 12:31:39');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `reserved_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('waiting','fulfilled','cancelled') DEFAULT 'waiting'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `member_id`, `book_id`, `branch_id`, `reserved_at`, `status`) VALUES
(1, 1, 3, 1, '2026-05-17 12:31:39', 'waiting');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('member','librarian','branch_manager','admin') NOT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `phone`, `role`, `profile_pic`, `branch_id`, `is_active`, `created_at`) VALUES
(1, 'Student Member', 'member@gmail.com', '123456', '01711111111', 'member', NULL, 1, 1, '2026-05-17 12:31:39'),
(2, 'Admin Librarian', 'librarianst@gmail.com', '123456', '01722222222', 'librarian', NULL, 1, 1, '2026-05-17 12:31:39'),
(3, 'Branch Manager', 'manager@gmail.com', '123456', '01733333333', 'branch_manager', NULL, 1, 1, '2026-05-17 12:31:39'),
(4, 'Platform Admin', 'admin@gmail.com', '123456', '01744444444', 'admin', NULL, NULL, 1, '2026-05-17 12:31:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `book_reviews`
--
ALTER TABLE `book_reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `borrow_records`
--
ALTER TABLE `borrow_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branch_inventory`
--
ALTER TABLE `branch_inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branch_policies`
--
ALTER TABLE `branch_policies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fines`
--
ALTER TABLE `fines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inter_branch_requests`
--
ALTER TABLE `inter_branch_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reading_lists`
--
ALTER TABLE `reading_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `book_reviews`
--
ALTER TABLE `book_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `borrow_records`
--
ALTER TABLE `borrow_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `branch_inventory`
--
ALTER TABLE `branch_inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `branch_policies`
--
ALTER TABLE `branch_policies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `fines`
--
ALTER TABLE `fines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `inter_branch_requests`
--
ALTER TABLE `inter_branch_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reading_lists`
--
ALTER TABLE `reading_lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
