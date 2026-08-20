-- ==========================================
-- MIGRASI TABEL user_login_log (untuk tabel yang sudah ada)
-- Tambah kolom deteksi online realtime:
--   - session_id   : mengikat record login ke session tertentu
--   - last_activity: heartbeat terakhir; user dianggap online bila
--                    logout_time IS NULL DAN last_activity < 10 menit
-- Jalankan query di bawah ini di phpMyAdmin / karya Admin sesuai databasenya.
-- ==========================================

ALTER TABLE `user_login_log`
  ADD COLUMN `session_id` varchar(64) DEFAULT NULL AFTER `logout_time`,
  ADD COLUMN `last_activity` datetime DEFAULT NULL AFTER `session_id`;

-- Isi backfill: untuk record lama yang belum pernah ada last_activity,
-- anggap login_time sebagai aktivitas terakhirnya.
UPDATE `user_login_log` SET `last_activity` = `login_time` WHERE `last_activity` IS NULL;

-- Index untuk mempercepat pencarian
ALTER TABLE `user_login_log`
  ADD INDEX `idx_session_id` (`session_id`),
  ADD INDEX `idx_last_activity` (`last_activity`);