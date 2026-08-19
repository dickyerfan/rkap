-- Tabel untuk menyimpan pengaturan persentase distribusi penerimaan air per tahun
-- Dipakai oleh halaman Penerimaan Air (tahun anggaran >= 2027), supaya user
-- bisa mengubah persentase lewat form tanpa mengubah kode.
-- Kolom menyimpan PECAHAN (bukan persen): 0.95 = 95%.
--   - dist_tagihan_p1/p2 : tagihan bulan B -> p1 diterima bulan B+1, p2 bulan B+2.
--   - dist_thl_p1/p2     : sisa piutang Th Lalu -> p1 di Januari, p2 di Februari.
--   - terkunci (1=YA)    : tahun terkunci TIDAK bisa diedit/dihapus (nilai tetap).
-- ---------------------------------------------------------------------------
-- PENTING untuk tabel yang SUDAH dibuat sebelumnya (belum ada kolom terkunci):
--   jalankan perintah ini SEKALI di phpMyAdmin:
--   ALTER TABLE `rkap_setting_distribusi` ADD COLUMN `terkunci` TINYINT(1) NOT NULL DEFAULT 0 AFTER `dist_thl_p2`;
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `rkap_setting_distribusi` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `tahun` YEAR NOT NULL,
  `dist_tagihan_p1` DECIMAL(5,2) NOT NULL DEFAULT 1.00,
  `dist_tagihan_p2` DECIMAL(5,2) NOT NULL DEFAULT 0.00,
  `dist_thl_p1` DECIMAL(5,2) NOT NULL DEFAULT 0.90,
  `dist_thl_p2` DECIMAL(5,2) NOT NULL DEFAULT 0.10,
  `terkunci` TINYINT(1) NOT NULL DEFAULT 0,
  `tgl_upload` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `tgl_update` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ptgs_upload` VARCHAR(100) NULL DEFAULT NULL,
  `ptgs_update` VARCHAR(100) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tahun_unique` (`tahun`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data awal (nilai yang sedang berlaku)
INSERT IGNORE INTO `rkap_setting_distribusi`
(`tahun`, `dist_tagihan_p1`, `dist_tagihan_p2`, `dist_thl_p1`, `dist_thl_p2`, `ptgs_upload`) VALUES
(2027, 0.95, 0.05, 0.97, 0.03, 'Admin'),
(2028, 1.00, 0.00, 0.90, 0.10, 'Admin');