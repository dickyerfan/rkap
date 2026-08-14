-- ==========================================
-- Tabel untuk Monitoring User Login
-- Mencatat siapa saja yang login & logout
-- ==========================================

CREATE TABLE IF NOT EXISTS `user_login_log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `level` varchar(50) NOT NULL,
  `tipe` varchar(50) NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `login_time` datetime NOT NULL,
  `logout_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_username` (`username`),
  KEY `idx_login_time` (`login_time`),
  KEY `idx_logout_time` (`logout_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
