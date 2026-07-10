-- Tabel untuk menyimpan nilai efisiensi per tahun
CREATE TABLE IF NOT EXISTS `rkap_efisiensi` (
  `id_efisiensi` INT NOT NULL AUTO_INCREMENT,
  `tahun` YEAR NOT NULL,
  `efisiensi` DECIMAL(5,2) NOT NULL DEFAULT 80.00,
  `keterangan` VARCHAR(255) NULL DEFAULT NULL,
  `tgl_upload` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `tgl_update` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ptgs_upload` VARCHAR(100) NULL DEFAULT NULL,
  `ptgs_update` VARCHAR(100) NULL DEFAULT NULL,
  PRIMARY KEY (`id_efisiensi`),
  UNIQUE KEY `tahun_unique` (`tahun`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data default
INSERT IGNORE INTO `rkap_efisiensi` (`tahun`, `efisiensi`, `keterangan`) VALUES
(2026, 80.00, 'Default'),
(2027, 75.00, 'Default');
