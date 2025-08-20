/*
 Navicat Premium Data Transfer

 Source Server         : lokalan
 Source Server Type    : MySQL
 Source Server Version : 100432 (10.4.32-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : rkap

 Target Server Type    : MySQL
 Target Server Version : 100432 (10.4.32-MariaDB)
 File Encoding         : 65001

 Date: 17/08/2025 22:13:02
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for biaya_amdk
-- ----------------------------
DROP TABLE IF EXISTS `biaya_amdk`;
CREATE TABLE `biaya_amdk`  (
  `id_biaya_amdk` int NOT NULL AUTO_INCREMENT,
  `tahun_rkap` int NOT NULL,
  `tipe_biaya` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_biaya` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `rincian_biaya` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `keterangan` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jumlah` bigint NOT NULL,
  `bagian_upk` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL DEFAULT 1,
  `status_update` int NOT NULL DEFAULT 1,
  `tgl_upload` timestamp NOT NULL DEFAULT current_timestamp,
  `tgl_update` datetime NOT NULL,
  PRIMARY KEY (`id_biaya_amdk`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 49 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of biaya_amdk
-- ----------------------------
INSERT INTO `biaya_amdk` VALUES (1, 2025, 'Biaya Pegawai', 'Biaya Gaji', 'Manager', '2.500.000 x 12', 30000000, 'amdk', 1, 1, '2025-08-17 20:23:42', '2025-08-17 20:55:29');
INSERT INTO `biaya_amdk` VALUES (2, 2025, 'Biaya Pegawai', 'Biaya Gaji', 'Pegawai Tetap', '5 x 2.500.000 x 12', 0, 'amdk', 1, 1, '2025-08-17 20:25:50', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (3, 2025, 'Biaya Pegawai', 'Biaya Gaji', 'Pegawai Kontrak', '7 x 1.235.000 x 12', 0, 'amdk', 1, 1, '2025-08-17 20:26:43', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (4, 2025, 'Biaya Pegawai', 'Biaya Gaji', 'Pegawai Borongan', '10 x 1.000.000 x 12', 0, 'amdk', 1, 1, '2025-08-17 20:27:15', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (5, 2025, 'Biaya Pegawai', 'Iuran BPJS', 'Total 12 pegawai', '12 x 2500000', 0, 'amdk', 1, 1, '2025-08-17 20:29:02', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (6, 2025, 'Biaya Pegawai', 'Biaya Lembur', '', '', 0, 'amdk', 1, 1, '2025-08-17 21:05:43', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (7, 2025, 'Biaya Pegawai', 'Insentif/Tunjangan', 'THR', 'Total Gaji Pegawai x 2', 0, 'amdk', 1, 1, '2025-08-17 21:06:15', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (8, 2025, 'Biaya Pegawai', 'Insentif/Tunjangan', 'Pendidikan', 'Total Gaji Pegawai x 1', 0, 'amdk', 1, 1, '2025-08-17 21:06:23', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (9, 2025, 'Biaya Pegawai', 'Insentif/Tunjangan', 'Bingkisan Lebaran', '12 x 5 x 15000', 0, 'amdk', 1, 1, '2025-08-17 21:06:24', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (10, 2025, 'Biaya Pegawai', 'Pembinaan Pegawai', 'Pakaian Dinas', '13 x 400000', 0, 'amdk', 1, 1, '2025-08-17 21:06:25', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (11, 2025, 'Biaya Pegawai', 'Pembinaan Pegawai', 'Pakaian Olahraga', '13 x 400000', 0, 'amdk', 1, 1, '2025-08-17 21:10:34', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (12, 2025, 'Biaya Pegawai', 'Pembinaan Pegawai', 'Seragam Produksi', '10 x 100000', 0, 'amdk', 1, 1, '2025-08-17 21:10:56', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (13, 2025, 'Biaya Pegawai', 'Bantuan/Sumbangan', '', '', 0, 'amdk', 1, 1, '2025-08-17 21:12:39', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (14, 2025, 'Biaya Pegawai', 'Pendidikan & Pelatihan', '', '', 0, 'amdk', 1, 1, '2025-08-17 21:12:40', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (15, 2025, 'Biaya Pegawai', 'Rupa-rupa Biaya Pegawai', '', '', 0, 'amdk', 1, 1, '2025-08-17 21:12:41', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (16, 2025, 'Biaya Operasional', 'BBM', 'Roda 2', '', 0, 'amdk', 1, 1, '2025-08-17 21:14:13', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (17, 2025, 'Biaya Operasional', 'BBM', 'Roda 4', '', 0, 'amdk', 1, 1, '2025-08-17 21:14:16', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (18, 2025, 'Biaya Operasional', 'BBM', 'Roda 6', '', 0, 'amdk', 1, 1, '2025-08-17 21:14:17', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (19, 2025, 'Biaya Operasional', 'Biaya ATK & Fotokkopi', '', '', 2500000, 'amdk', 1, 1, '2025-08-17 21:14:18', '2025-08-17 22:05:41');
INSERT INTO `biaya_amdk` VALUES (20, 2025, 'Biaya Operasional', 'Perlengkapan Komputer', '', '', 0, 'amdk', 1, 1, '2025-08-17 21:14:21', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (21, 2025, 'Biaya Operasional', 'Biaya Rapat & Tamu', '', '', 0, 'amdk', 1, 1, '2025-08-17 21:16:56', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (22, 2025, 'Biaya Operasional', 'Biaya Listrik', '', '', 0, 'amdk', 1, 1, '2025-08-17 21:17:06', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (23, 2025, 'Biaya Operasional', 'Biaya Pemakaian Air', '', '', 0, 'amdk', 1, 1, '2025-08-17 21:17:22', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (24, 2025, 'Biaya Operasional', 'Biaya Promosi', '', '', 0, 'amdk', 1, 1, '2025-08-17 21:17:38', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (25, 2025, 'Biaya Operasional', 'Biaya Pemeliharaan', 'Pemeliharaan Kendaraan Dinas', '', 0, 'amdk', 1, 1, '2025-08-17 21:18:42', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (26, 2025, 'Biaya Operasional', 'Biaya Pemeliharaan', 'Pajak kendaraan dinas', '', 0, 'amdk', 1, 1, '2025-08-17 21:19:28', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (27, 2025, 'Biaya Operasional', 'Biaya Pemeliharaan', 'Gedung', '', 0, 'amdk', 1, 1, '2025-08-17 21:19:29', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (28, 2025, 'Biaya Operasional', 'Biaya Pemeliharaan', 'Pemeliharaan Mesin Produksi', 'Galon', 0, 'amdk', 1, 1, '2025-08-17 21:19:30', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (29, 2025, 'Biaya Operasional', 'Biaya Pemeliharaan', 'Pemeliharaan Mesin Produksi', 'Pemeliharaan kompresor', 0, 'amdk', 1, 1, '2025-08-17 21:19:31', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (30, 2025, 'Biaya Operasional', 'Biaya Pemeliharaan', 'Pemeliharaan Mesin Produksi', 'Pemeliharaan Lab', 0, 'amdk', 1, 1, '2025-08-17 21:23:09', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (31, 2025, 'Biaya Operasional', 'Biaya Pemeliharaan', 'Pemeliharaan Ruang Produksi', 'Galon', 0, 'amdk', 1, 1, '2025-08-17 21:23:31', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (32, 2025, 'Biaya Operasional', 'Biaya Pemeliharaan', 'Pemeliharaan Ruang Produksi', 'Gelas 220 ml', 0, 'amdk', 1, 1, '2025-08-17 21:23:36', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (33, 2025, 'Biaya Operasional', 'Biaya Pemeliharaan', 'Pemeliharaan Ruang Produksi', 'Ruang WT ( Water Treatment )', 0, 'amdk', 1, 1, '2025-08-17 21:23:37', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (34, 2025, 'Biaya Operasional', 'Biaya Pemeliharaan', 'Pemeliharaan Ruang Produksi', 'Botol', 0, 'amdk', 1, 1, '2025-08-17 21:23:39', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (35, 2025, 'Biaya Operasional', 'Pemakaian Bahan Baku', 'Bahan Baku Galon', '', 0, 'amdk', 1, 1, '2025-08-17 21:25:32', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (36, 2025, 'Biaya Operasional', 'Pemakaian Bahan Baku', 'Bahan Baku Gelas 220 ml', '', 0, 'amdk', 1, 1, '2025-08-17 21:25:33', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (37, 2025, 'Biaya Operasional', 'Pemakaian Bahan Baku', 'Bahan Baku Botol 330 ml', '', 0, 'amdk', 1, 1, '2025-08-17 21:25:34', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (38, 2025, 'Biaya Operasional', 'Pemakaian Bahan Baku', 'Bahan Baku Botol 500 ml', '', 0, 'amdk', 1, 1, '2025-08-17 21:25:35', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (39, 2025, 'Biaya Operasional', 'Pemakaian Bahan Baku', 'Bahan Baku Botol 1500 ml', '', 0, 'amdk', 1, 1, '2025-08-17 21:25:36', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (40, 2025, 'Biaya Operasional', 'Pemakaian Bahan Baku', 'Perlengkapan Lab', '', 0, 'amdk', 1, 1, '2025-08-17 21:25:37', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (41, 2025, 'Biaya Operasional', 'Pemakaian Bahan Baku', 'Perlengkapan Lainnya', '', 0, 'amdk', 1, 1, '2025-08-17 21:28:22', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (42, 2025, 'Biaya Operasional', 'Biaya Rupa-rupa', 'Bantuan Produk Ijen Water', 'Galon', 0, 'amdk', 1, 1, '2025-08-17 21:28:56', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (43, 2025, 'Biaya Operasional', 'Biaya Rupa-rupa', 'Bantuan Produk Ijen Water', 'Gelas 220 ml', 0, 'amdk', 1, 1, '2025-08-17 21:28:57', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (44, 2025, 'Biaya Operasional', 'Biaya Rupa-rupa', 'Bantuan Produk Ijen Water', 'Botol 500 ml', 0, 'amdk', 1, 1, '2025-08-17 21:30:03', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (45, 2025, 'Biaya Operasional', 'Biaya Rupa-rupa', 'Biaya Pemeriksaan SNI', '', 0, 'amdk', 1, 1, '2025-08-17 21:30:39', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (46, 2025, 'Biaya Operasional', 'Biaya Rupa-rupa', 'Uji Kualitas Air (Biaya Lab)', '', 0, 'amdk', 1, 1, '2025-08-17 21:30:50', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (47, 2025, 'Biaya Operasional', 'Biaya Rupa-rupa', 'Rupa - rupa Biaya Lainnya', '', 0, 'amdk', 1, 1, '2025-08-17 21:31:00', '0000-00-00 00:00:00');
INSERT INTO `biaya_amdk` VALUES (48, 2025, 'Biaya Operasional', 'Biaya Penyusutan Umum', '', '', 0, 'amdk', 1, 1, '2025-08-17 21:31:29', '0000-00-00 00:00:00');

SET FOREIGN_KEY_CHECKS = 1;
