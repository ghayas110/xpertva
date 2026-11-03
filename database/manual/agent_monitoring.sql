-- =====================================================================
-- XpertVA — Monitoring Agent schema changes
-- Apply this ONCE on the production database (SiteGround phpMyAdmin),
-- ONLY if you are NOT running `php artisan migrate` over SSH.
-- Safe to run on the existing live database; it only ADDS columns.
-- =====================================================================

-- 1) users: per-employee agent token + consent timestamp -------------
ALTER TABLE `users`
    ADD COLUMN `agent_token` VARCHAR(64) NULL AFTER `remember_token`,
    ADD COLUMN `monitoring_consent_at` TIMESTAMP NULL AFTER `agent_token`,
    ADD UNIQUE KEY `users_agent_token_unique` (`agent_token`);

-- Backfill a random 48-char token for every existing user
-- (new users get one automatically from the app).
UPDATE `users`
   SET `agent_token` = CONCAT(
        SUBSTRING(MD5(CONCAT(RAND(), id, NOW())), 1, 24),
        SUBSTRING(MD5(CONCAT(RAND(), id, 'x')), 1, 24)
   )
 WHERE `agent_token` IS NULL;

-- 2) employee_activities: source + browser/window details ------------
ALTER TABLE `employee_activities`
    ADD COLUMN `source` VARCHAR(20) NOT NULL DEFAULT 'extension' AFTER `user_id`,
    ADD COLUMN `app_name` VARCHAR(255) NULL AFTER `url`,
    ADD COLUMN `window_title` VARCHAR(512) NULL AFTER `app_name`,
    ADD COLUMN `captured_at` TIMESTAMP NULL AFTER `window_title`,
    ADD INDEX `employee_activities_user_id_created_at_index` (`user_id`, `created_at`);

-- 3) Tell Laravel these two migrations are already applied, so a later
--    `php artisan migrate` will NOT try to run them again.
--    (Adjust the batch number if you like; it just needs to be present.)
INSERT INTO `migrations` (`migration`, `batch`)
SELECT '2026_08_29_000001_add_agent_fields_to_users_table', COALESCE(MAX(batch),0)+1 FROM `migrations`;
INSERT INTO `migrations` (`migration`, `batch`)
SELECT '2026_08_29_000002_add_agent_fields_to_employee_activities_table', COALESCE(MAX(batch),0) FROM `migrations`;
