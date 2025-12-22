-- ============================================
-- AkadeaApp - Manual Migration SQL Script
-- For hosting without terminal access
-- ============================================
-- Generated: 2025-12-18
-- Database: MySQL/MariaDB
-- 
-- INSTRUCTIONS:
-- 1. Backup your current database first!
-- 2. Run this script via phpMyAdmin or your hosting's database manager
-- 3. This will ADD missing tables and columns to your existing database
-- ============================================

SET FOREIGN_KEY_CHECKS=0;

-- ============================================
-- CREATE MIGRATIONS TABLE FIRST (Required by Laravel)
-- ============================================

CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- MISSING TABLES (Not in your current host DB)
-- ============================================

-- Table: teacher_subject (Many-to-many relationship)
CREATE TABLE IF NOT EXISTS `teacher_subject` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `teacher_subject_teacher_id_subject_id_unique` (`teacher_id`,`subject_id`),
  KEY `teacher_subject_subject_id_foreign` (`subject_id`),
  CONSTRAINT `teacher_subject_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `teacher_subject_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: exams
CREATE TABLE IF NOT EXISTS `exams` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `class` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `duration_minutes` int(11) NOT NULL,
  `start_time` timestamp NOT NULL,
  `end_time` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: questions
CREATE TABLE IF NOT EXISTS `questions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `exam_id` bigint(20) UNSIGNED NOT NULL,
  `question_text` text NOT NULL,
  `description` text DEFAULT NULL,
  `type` enum('multiple_choice','checkbox','dropdown','essay') NOT NULL,
  `options` json DEFAULT NULL,
  `correct_answer` json DEFAULT NULL,
  `required` tinyint(1) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `scale_min` int(11) DEFAULT NULL,
  `scale_max` int(11) DEFAULT NULL,
  `rows` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `questions_exam_id_foreign` (`exam_id`),
  CONSTRAINT `questions_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: exam_submissions
CREATE TABLE IF NOT EXISTS `exam_submissions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `exam_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `answers` json DEFAULT NULL,
  `score` decimal(8,2) DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `exam_submissions_exam_id_foreign` (`exam_id`),
  CONSTRAINT `exam_submissions_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- COLUMN ADDITIONS TO EXISTING TABLES
-- ============================================

-- Add enrollment_date to students table (if not exists)
SET @dbname = DATABASE();
SET @tablename = 'students';
SET @columnname = 'enrollment_date';
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      TABLE_SCHEMA = @dbname
      AND TABLE_NAME = @tablename
      AND COLUMN_NAME = @columnname
  ) > 0,
  'SELECT 1',
  CONCAT('ALTER TABLE ', @tablename, ' ADD ', @columnname, ' DATE NOT NULL AFTER birth_date')
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- Add user_id to students table (if not exists)
SET @columnname = 'user_id';
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      TABLE_SCHEMA = @dbname
      AND TABLE_NAME = @tablename
      AND COLUMN_NAME = @columnname
  ) > 0,
  'SELECT 1',
  CONCAT('ALTER TABLE ', @tablename, ' ADD ', @columnname, ' BIGINT(20) UNSIGNED NULL AFTER id, ADD CONSTRAINT students_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE')
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- Modify subjects.teacher_id to be nullable (if not already)
ALTER TABLE `subjects` MODIFY `teacher_id` bigint(20) UNSIGNED NULL;

-- Add class and subject columns to exams table (if not exists)
SET @tablename = 'exams';
SET @columnname = 'class';
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      TABLE_SCHEMA = @dbname
      AND TABLE_NAME = @tablename
      AND COLUMN_NAME = @columnname
  ) > 0,
  'SELECT 1',
  CONCAT('ALTER TABLE ', @tablename, ' ADD ', @columnname, ' VARCHAR(255) NULL AFTER description')
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

SET @columnname = 'subject';
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      TABLE_SCHEMA = @dbname
      AND TABLE_NAME = @tablename
      AND COLUMN_NAME = @columnname
  ) > 0,
  'SELECT 1',
  CONCAT('ALTER TABLE ', @tablename, ' ADD ', @columnname, ' VARCHAR(255) NULL AFTER class')
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- ============================================
-- UPDATE MIGRATIONS TABLE
-- ============================================
-- Add migration records so Laravel knows these migrations have run

INSERT IGNORE INTO `migrations` (`migration`, `batch`) VALUES
('0001_01_01_000000_create_users_table', 1),
('0001_01_01_000001_create_cache_table', 1),
('0001_01_01_000002_create_jobs_table', 1),
('2025_11_24_075415_create_students_table', 2),
('2025_11_24_075441_create_spp_payments_table', 2),
('2025_11_26_033137_create_teachers_table', 2),
('2025_11_28_071332_create_permission_tables', 3),
('2025_11_26_063354_create_subjects_table', 4),
('2025_12_10_111500_modify_subjects_teacher_nullable', 5),
('2025_12_10_133400_create_teacher_subject_table', 5),
('2025_12_10_065223_add_enrollment_date_to_students_table', 6),
('2025_12_11_034438_create_exams_table', 6),
('2025_12_11_034554_create_questions_table', 6),
('2025_12_11_034633_create_exam_submissions_table', 6),
('2025_12_11_041646_add_question_enhancements', 7),
('2025_12_14_121457_add_class_and_subject_to_exams_table', 7),
('2025_12_16_032812_add_user_id_to_students_table', 8);

SET FOREIGN_KEY_CHECKS=1;

-- ============================================
-- MIGRATION COMPLETED
-- ============================================
-- To verify the migration was successful, run these queries separately in phpMyAdmin SQL tab:
--
-- 1. Check table count:
--    SELECT COUNT(*) FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = DATABASE();
--
-- 2. Check migrations table:
--    SELECT COUNT(*) FROM migrations;
--
-- 3. List all tables:
--    SHOW TABLES;
--
-- ============================================
