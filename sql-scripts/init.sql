-- Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS legislation;
USE legislation;

-- Create `user` table
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('MP', 'Reviewer', 'Administrator') NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert sample users
INSERT INTO `user` (username, password_hash, role, email) VALUES
('admin_user', '123', 'Administrator', 'admin@example.com'),
('reviewer_user', '123', 'Reviewer', 'reviewer@example.com'),
('mp_user', '123', 'MP', 'mp@example.com');

-- Create `bill` table
CREATE TABLE IF NOT EXISTS `bill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `draft_content` text DEFAULT NULL,
  `status` enum('Draft', 'Under Review', 'Approved', 'Rejected') NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`),
  CONSTRAINT `bill_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert sample bills
INSERT INTO `bill` (title, description, author_id, draft_content, status) VALUES
('Bill A - Draft', 'Description for Bill A in draft status', 1, 'Draft content A', 'Draft'),
('Bill B - Under Review', 'Description for Bill B under review', 2, 'Draft content B', 'Under Review'),
('Bill C - Approved', 'Description for Bill C approved', 3, 'Draft content C', 'Approved'),
('Bill D - Rejected', 'Description for Bill D rejected', 1, 'Draft content D', 'Rejected');

-- Create `amendment` table
CREATE TABLE IF NOT EXISTS `amendment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` int(11) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `amendment_content` text NOT NULL,
  `comment` text DEFAULT NULL,
  `created_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `bill_id` (`bill_id`),
  KEY `author_id` (`author_id`),
  CONSTRAINT `amendment_ibfk_1` FOREIGN KEY (`bill_id`) REFERENCES `bill` (`id`),
  CONSTRAINT `amendment_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert sample amendments
INSERT INTO `amendment` (bill_id, author_id, amendment_content, comment) VALUES
(1, 1, 'Amendment content for Bill A', 'Comment on amendment for Bill A'),
(2, 2, 'Amendment content for Bill B', 'Comment on amendment for Bill B');

-- Create `vote` table
CREATE TABLE IF NOT EXISTS `vote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` int(11) DEFAULT NULL,
  `mp_id` int(11) DEFAULT NULL,
  `vote_value` enum('For', 'Against', 'Abstain') NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `bill_id` (`bill_id`),
  KEY `mp_id` (`mp_id`),
  CONSTRAINT `vote_ibfk_1` FOREIGN KEY (`bill_id`) REFERENCES `bill` (`id`),
  CONSTRAINT `vote_ibfk_2` FOREIGN KEY (`mp_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert sample votes
INSERT INTO `vote` (bill_id, mp_id, vote_value) VALUES
(2, 3, 'For'),
(3, 3, 'Against');
