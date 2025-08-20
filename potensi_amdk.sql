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

 Date: 15/08/2025 16:57:49
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for potensi_amdk
-- ----------------------------
DROP TABLE IF EXISTS `potensi_amdk`;
CREATE TABLE `potensi_amdk`  (
  `id_potensi_amdk` int NOT NULL AUTO_INCREMENT,
  `tahun_rkap` int NOT NULL,
  `uraian` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `harga` int NOT NULL,
  `jumlah` int NOT NULL,
  `bagian_upk` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL DEFAULT 1,
  `status_update` int NOT NULL DEFAULT 1,
  `tgl_upload` timestamp NOT NULL DEFAULT current_timestamp,
  `tgl_update` datetime NOT NULL,
  PRIMARY KEY (`id_potensi_amdk`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

SET FOREIGN_KEY_CHECKS = 1;
