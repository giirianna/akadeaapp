-- ============================================
-- VERIFICATION SCRIPT
-- Run this in phpMyAdmin SQL tab to check if migration succeeded
-- ============================================

-- 1. Check if migrations table exists and has records
SELECT 'Step 1: Checking migrations table...' as Status;
SELECT COUNT(*) as migration_count FROM migrations;

-- 2. Show all migration records
SELECT 'Step 2: List all migrations...' as Status;
SELECT migration, batch FROM migrations ORDER BY batch, migration;

-- 3. Count total tables in database
SELECT 'Step 3: Counting tables...' as Status;
SELECT COUNT(*) as total_tables 
FROM INFORMATION_SCHEMA.TABLES 
WHERE TABLE_SCHEMA = DATABASE();

-- 4. List all tables
SELECT 'Step 4: Listing all tables...' as Status;
SHOW TABLES;

-- 5. Check if new tables exist
SELECT 'Step 5: Checking new tables...' as Status;
SELECT 
  'teacher_subject' as table_name,
  IF(COUNT(*) > 0, '✅ EXISTS', '❌ MISSING') as status
FROM INFORMATION_SCHEMA.TABLES 
WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'teacher_subject'
UNION ALL
SELECT 
  'exams',
  IF(COUNT(*) > 0, '✅ EXISTS', '❌ MISSING')
FROM INFORMATION_SCHEMA.TABLES 
WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'exams'
UNION ALL
SELECT 
  'questions',
  IF(COUNT(*) > 0, '✅ EXISTS', '❌ MISSING')
FROM INFORMATION_SCHEMA.TABLES 
WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'questions'
UNION ALL
SELECT 
  'exam_submissions',
  IF(COUNT(*) > 0, '✅ EXISTS', '❌ MISSING')
FROM INFORMATION_SCHEMA.TABLES 
WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'exam_submissions';

-- 6. Check students table columns
SELECT 'Step 6: Checking students table columns...' as Status;
SELECT COLUMN_NAME, COLUMN_TYPE, IS_NULLABLE
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_SCHEMA = DATABASE() 
  AND TABLE_NAME = 'students'
ORDER BY ORDINAL_POSITION;

-- 7. Final summary
SELECT 'Step 7: Migration Summary' as Status;
SELECT 
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = DATABASE()) as total_tables,
  (SELECT COUNT(*) FROM migrations) as total_migrations,
  IF((SELECT COUNT(*) FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'exams') > 0, 
     '✅ Migration appears successful!', 
     '❌ Migration incomplete - exams table missing') as result;
