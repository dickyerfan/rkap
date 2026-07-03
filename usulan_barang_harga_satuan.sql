ALTER TABLE `usulan_barang`
    ADD COLUMN `harga_satuan` BIGINT NOT NULL DEFAULT 0 AFTER `satuan`;

UPDATE `usulan_barang`
SET `harga_satuan` = `biaya`,
    `biaya` = `biaya` * CAST(`volume` AS UNSIGNED);
