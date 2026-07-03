ALTER TABLE `rkap_master_barang`
    ADD COLUMN `tahun` YEAR NULL AFTER `id`;

UPDATE `rkap_master_barang`
SET `tahun` = YEAR(`created_at`)
WHERE `tahun` IS NULL;

ALTER TABLE `rkap_master_barang`
    MODIFY COLUMN `tahun` YEAR NOT NULL,
    ADD KEY `idx_master_barang_tahun` (`tahun`),
    ADD UNIQUE KEY `uq_master_barang_tahun_kategori_nama` (`tahun`, `kategori_id`, `nama_barang`);
