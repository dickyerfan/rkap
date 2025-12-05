/*
 Navicat Premium Data Transfer

 Source Server         : DIE ArtS
 Source Server Type    : MySQL
 Source Server Version : 100418 (10.4.18-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : rkap

 Target Server Type    : MySQL
 Target Server Version : 100418 (10.4.18-MariaDB)
 File Encoding         : 65001

 Date: 07/08/2025 07:53:02
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for arsip
-- ----------------------------
DROP TABLE IF EXISTS `arsip`;
CREATE TABLE `arsip`  (
  `id_arsip` int NOT NULL AUTO_INCREMENT,
  `jenis` enum('Surat Keputusan','Peraturan','Berkas Kerja','dokumen') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tahun` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_dokumen` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tentang` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_dokumen` date NOT NULL,
  `tgl_upload` date NOT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_arsip`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of arsip
-- ----------------------------
INSERT INTO `arsip` VALUES (2, 'Surat Keputusan', '1999', 'Kepmendagri_47_th_99.pdf', 'Kepmendagri no 47 Tahun 1999', 'Pedoman Penilaian Kinerja Perusahaan Daerah Air Minum', '2023-05-11', '2023-05-11', '-');
INSERT INTO `arsip` VALUES (4, 'Peraturan', '1993', 'Perda_No_2_Tahun_93_tentang_Pendirian_Pdam.pdf', 'Perda No 2 Tahun 1993', 'Pendirian Perusahaan  Daerah Air Minum Kabupaten Bondowoso Tingkat II Bondowoso', '1993-04-21', '2023-05-15', '');
INSERT INTO `arsip` VALUES (5, 'Surat Keputusan', '1996', 'SK_Direktur_NO_22_2_Tahun_96_Tentang_Struktur.pdf', 'SK Direktur No 22.2 Tahun 1996 ', 'Struktur  Organisasi, Uraian Tugas  dan Tata Kerja Perusahaan Daerah Air Minum Kabupaten Daerah Tingkat II Bondowoso', '1996-04-01', '2023-05-15', '-');
INSERT INTO `arsip` VALUES (6, 'Surat Keputusan', '2017', 'SK_Bupati_No_188_45_Tahun_2017_Tentang_Tarif_Air.pdf', 'SK Bupati No 188.45/830/430.4.2/2017', 'Tarif Air Minum Pada Perusahaan Daerah Air Minum Kabupaten Bondowoso Tahun 2017', '2017-11-29', '2023-05-15', '-');
INSERT INTO `arsip` VALUES (7, 'Surat Keputusan', '2022', 'SK_Bupati_No_188_45_Tahun_2022_Tentang_Tarif_Air.pdf', 'SK Bupati No 188.45/262/430.4.2/2022', 'Tarif Air Minum Pada Perusahaan Daerah Air Minum Kabupaten Bondowoso Tahun 2022', '2022-02-24', '2023-05-15', '-');
INSERT INTO `arsip` VALUES (8, 'Surat Keputusan', '2021', 'SK_Direktur_No_188_tahun_2021_tentang_Hak_Minim.pdf', 'SK Direktur No 188/33.3/430.12/2021 ', 'Perubahan Penetapan Pemberlakuan Hak Minim (10)M3', '2021-11-01', '2023-05-15', '-');
INSERT INTO `arsip` VALUES (9, 'Peraturan', '2015', 'Perda_no_3_tahun_2015_ttg_Penyertaan_Modal.pdf', 'Perda No 3 Tahun 2015', 'Penyertaan Modal Pemerintah Daerah Kepada Perusahaan Daerah Air Minum Kabupaten Bondowoso', '2015-11-30', '2023-05-15', '-');
INSERT INTO `arsip` VALUES (10, 'Surat Keputusan', '2021', 'SK_Direktur_No_188_Tahun_2021_Tentang_Pedoman_Pengadaan_barang_jasa.pdf', 'SK Direktur No 188/01.4.2/430.12/2021 ', 'Pedoman Pelaksanaan Pengadaan Barang/Jasa  pada Perusahaan Daerah Air Minum Kabupaten Bondowoso', '2021-01-11', '2023-05-15', '-');
INSERT INTO `arsip` VALUES (11, 'Peraturan', '2019', 'PERBUP_Perubahan_kedua_atas_Peraturan_Bupati_No_57_TAHUN_2013.pdf', 'PerBup No 8 Tahun 2019', 'Perubahan Kedua atas Peraturan Bupati Bondowoso No 57 tahun Tahun 2013 Tentang Petunjuk Pelaksanaan Peraturan Daerah Kabupaten Daerah Tingkat II Bondowoso No 2 Tahun 1993 Tentang Pendirian Perusahaan Daerah Air Minum Kabupaten Daerah Tingkat II Bondowoso', '2019-01-18', '2023-05-15', '-');
INSERT INTO `arsip` VALUES (12, 'Peraturan', '2011', 'Perda_No_6_Tahun_2011_ttg_perubahan_pendirian_pdam.pdf', 'Perda No 6 Tahun 2011', 'Perubahan Atas  Peraturan Daerah Kabupaten Daerah Tingkat II Bondowoso No 2  Tahun 1993  Tentang Pendirian Perusahaan Daerah Air Minum  Kabupaten  Daerah Tingkat II Bondowoso', '2011-08-01', '2023-05-15', '-');
INSERT INTO `arsip` VALUES (17, 'Peraturan', '2018', 'Permendagri_Nomor_37_Tahun_2018.pdf', 'Permendagri No 37 Tahun 2018', 'Pengangkatan dan Pemberhentian Anggota Dewan Pengawas atau  Anggota Komisaris dan Anggota Direksi Badan Usaha Milik Daerah', '2018-05-07', '2023-05-16', '');
INSERT INTO `arsip` VALUES (20, 'Peraturan', '2017', 'PERMENDAGRI_Nomor_11_Tahun_2017.pdf', 'Permendagri No 11 Tahun 2017', 'Pedoman Evaluasi Rancangan Peraturan Daerah Tentang\r\nPertanggungjawaban Pelaksanaan Anggaran Pendapatan Dan\r\nBelanja Daerah Dan Rancangan Peraturan Kepala Daerah\r\nTentang Penjabaran Pertanggungjawaban Pelaksanaan\r\nAnggaran Pendapatan Dan Belanja Daerah', '2017-02-22', '2023-05-16', '');
INSERT INTO `arsip` VALUES (21, 'dokumen', '2015', 'SAK_ETAP_CONTENTS.pdf', 'Pedoman SAK ETAP', 'Pedoman Standar Akuntansi Keuangan Untuk Entitas Tanpa Akuntabilitas Publik', '2015-01-01', '2023-06-21', '');
INSERT INTO `arsip` VALUES (22, 'Peraturan', '2006', 'permendagri_23_2006.pdf', 'Permendagri no 23 tahun 2006', 'Pedoman Teknis Dan Tata Cara Pengaturan Tarif Air Minum Pada Perusahaan Daerah Air Minum', '2006-07-03', '2023-06-23', '');

-- ----------------------------
-- Table structure for bagian
-- ----------------------------
DROP TABLE IF EXISTS `bagian`;
CREATE TABLE `bagian`  (
  `id_bagian` int NOT NULL AUTO_INCREMENT,
  `nama_bagian` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_bagian`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bagian
-- ----------------------------
INSERT INTO `bagian` VALUES (1, 'Langganan');
INSERT INTO `bagian` VALUES (2, 'Umum');
INSERT INTO `bagian` VALUES (3, 'Keuangan');
INSERT INTO `bagian` VALUES (4, 'Pemeliharaan');
INSERT INTO `bagian` VALUES (5, 'Perencanaan');
INSERT INTO `bagian` VALUES (6, 'S P I');
INSERT INTO `bagian` VALUES (7, 'U P K');
INSERT INTO `bagian` VALUES (8, 'A M D K');

-- ----------------------------
-- Table structure for data_rekening
-- ----------------------------
DROP TABLE IF EXISTS `data_rekening`;
CREATE TABLE `data_rekening`  (
  `id_rek` int NOT NULL AUTO_INCREMENT,
  `id_upk` int NOT NULL,
  `bln` int NOT NULL,
  `thn` int NOT NULL,
  `jml_rek` int NOT NULL,
  `air_pakai` int NOT NULL,
  `rupiah` int NOT NULL,
  PRIMARY KEY (`id_rek`) USING BTREE,
  INDEX `id_upk`(`id_upk` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 271 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of data_rekening
-- ----------------------------
INSERT INTO `data_rekening` VALUES (1, 1, 1, 2022, 5491, 84451, 466540360);
INSERT INTO `data_rekening` VALUES (2, 2, 1, 2022, 1296, 15230, 82427940);
INSERT INTO `data_rekening` VALUES (3, 3, 1, 2022, 1234, 16279, 88463300);
INSERT INTO `data_rekening` VALUES (4, 4, 1, 2022, 1628, 23955, 124977360);
INSERT INTO `data_rekening` VALUES (5, 5, 1, 2022, 1105, 14225, 73840120);
INSERT INTO `data_rekening` VALUES (6, 6, 1, 2022, 1010, 12597, 70095960);
INSERT INTO `data_rekening` VALUES (7, 7, 1, 2022, 1152, 10152, 58948970);
INSERT INTO `data_rekening` VALUES (8, 8, 1, 2022, 1151, 15040, 79050900);
INSERT INTO `data_rekening` VALUES (9, 9, 1, 2022, 1232, 18085, 96791420);
INSERT INTO `data_rekening` VALUES (10, 10, 1, 2022, 302, 4401, 23222790);
INSERT INTO `data_rekening` VALUES (11, 11, 1, 2022, 583, 8595, 50900760);
INSERT INTO `data_rekening` VALUES (12, 12, 1, 2022, 605, 6548, 29677410);
INSERT INTO `data_rekening` VALUES (13, 13, 1, 2022, 1100, 10540, 57268660);
INSERT INTO `data_rekening` VALUES (14, 14, 1, 2022, 92, 1032, 5795020);
INSERT INTO `data_rekening` VALUES (15, 15, 1, 2022, 1524, 17736, 89010110);
INSERT INTO `data_rekening` VALUES (16, 1, 2, 2022, 5469, 82562, 458690100);
INSERT INTO `data_rekening` VALUES (17, 2, 2, 2022, 1285, 14615, 82701060);
INSERT INTO `data_rekening` VALUES (18, 3, 2, 2022, 1238, 16640, 90520420);
INSERT INTO `data_rekening` VALUES (19, 4, 2, 2022, 1626, 22725, 119646610);
INSERT INTO `data_rekening` VALUES (20, 5, 2, 2022, 1104, 14002, 73518540);
INSERT INTO `data_rekening` VALUES (21, 6, 2, 2022, 1004, 12621, 69904080);
INSERT INTO `data_rekening` VALUES (22, 7, 2, 2022, 1129, 11389, 64952780);
INSERT INTO `data_rekening` VALUES (23, 8, 2, 2022, 1141, 14601, 73802970);
INSERT INTO `data_rekening` VALUES (24, 9, 2, 2022, 1232, 17462, 93123990);
INSERT INTO `data_rekening` VALUES (25, 10, 2, 2022, 305, 4436, 23605620);
INSERT INTO `data_rekening` VALUES (26, 11, 2, 2022, 582, 8827, 51300450);
INSERT INTO `data_rekening` VALUES (27, 12, 2, 2022, 603, 6309, 28839120);
INSERT INTO `data_rekening` VALUES (28, 13, 2, 2022, 1101, 9984, 55465820);
INSERT INTO `data_rekening` VALUES (29, 14, 2, 2022, 92, 1039, 20623770);
INSERT INTO `data_rekening` VALUES (30, 15, 2, 2022, 1517, 16775, 84721300);
INSERT INTO `data_rekening` VALUES (31, 1, 3, 2022, 5484, 75811, 430323160);
INSERT INTO `data_rekening` VALUES (32, 2, 3, 2022, 1279, 14057, 80307670);
INSERT INTO `data_rekening` VALUES (33, 3, 3, 2022, 1240, 14872, 82724850);
INSERT INTO `data_rekening` VALUES (34, 4, 3, 2022, 1612, 20379, 110442900);
INSERT INTO `data_rekening` VALUES (35, 5, 3, 2022, 1101, 12103, 66872480);
INSERT INTO `data_rekening` VALUES (36, 6, 3, 2022, 1001, 10198, 60479780);
INSERT INTO `data_rekening` VALUES (37, 7, 3, 2022, 1125, 9612, 57991600);
INSERT INTO `data_rekening` VALUES (38, 8, 3, 2022, 1130, 13355, 68082740);
INSERT INTO `data_rekening` VALUES (39, 9, 3, 2022, 1225, 14998, 82810010);
INSERT INTO `data_rekening` VALUES (40, 10, 3, 2022, 303, 3917, 21678360);
INSERT INTO `data_rekening` VALUES (41, 11, 3, 2022, 578, 8443, 50466920);
INSERT INTO `data_rekening` VALUES (42, 12, 3, 2022, 593, 5461, 26539040);
INSERT INTO `data_rekening` VALUES (43, 13, 3, 2022, 1098, 8635, 51839100);
INSERT INTO `data_rekening` VALUES (44, 14, 3, 2022, 91, 820, 8146270);
INSERT INTO `data_rekening` VALUES (45, 15, 3, 2022, 1517, 14752, 77918770);
INSERT INTO `data_rekening` VALUES (46, 1, 4, 2022, 5474, 80578, 447638020);
INSERT INTO `data_rekening` VALUES (47, 2, 4, 2022, 1265, 14645, 80351260);
INSERT INTO `data_rekening` VALUES (48, 3, 4, 2022, 1241, 15831, 88015940);
INSERT INTO `data_rekening` VALUES (49, 4, 4, 2022, 1605, 22479, 118600780);
INSERT INTO `data_rekening` VALUES (50, 5, 4, 2022, 1099, 14494, 74441320);
INSERT INTO `data_rekening` VALUES (51, 6, 4, 2022, 999, 12155, 66892690);
INSERT INTO `data_rekening` VALUES (52, 7, 4, 2022, 1121, 10304, 60699280);
INSERT INTO `data_rekening` VALUES (53, 8, 4, 2022, 1130, 13950, 70260960);
INSERT INTO `data_rekening` VALUES (54, 9, 4, 2022, 1222, 17370, 91990100);
INSERT INTO `data_rekening` VALUES (55, 10, 4, 2022, 301, 4321, 23123560);
INSERT INTO `data_rekening` VALUES (56, 11, 4, 2022, 577, 8709, 51166680);
INSERT INTO `data_rekening` VALUES (57, 12, 4, 2022, 586, 6592, 29505790);
INSERT INTO `data_rekening` VALUES (58, 13, 4, 2022, 1099, 10478, 56598930);
INSERT INTO `data_rekening` VALUES (59, 14, 4, 2022, 91, 993, 8595310);
INSERT INTO `data_rekening` VALUES (60, 15, 4, 2022, 1517, 15955, 81762170);
INSERT INTO `data_rekening` VALUES (61, 1, 5, 2022, 5501, 83700, 460970270);
INSERT INTO `data_rekening` VALUES (62, 2, 5, 2022, 1256, 16465, 87408160);
INSERT INTO `data_rekening` VALUES (63, 3, 5, 2022, 1234, 18219, 96638990);
INSERT INTO `data_rekening` VALUES (64, 4, 5, 2022, 1616, 24349, 126505150);
INSERT INTO `data_rekening` VALUES (65, 5, 5, 2022, 1104, 15696, 79116240);
INSERT INTO `data_rekening` VALUES (66, 6, 5, 2022, 1004, 12800, 69673160);
INSERT INTO `data_rekening` VALUES (67, 7, 5, 2022, 1117, 9690, 57605340);
INSERT INTO `data_rekening` VALUES (68, 8, 5, 2022, 1126, 16182, 79137640);
INSERT INTO `data_rekening` VALUES (69, 9, 5, 2022, 1227, 17566, 93280260);
INSERT INTO `data_rekening` VALUES (70, 10, 5, 2022, 302, 4550, 24365450);
INSERT INTO `data_rekening` VALUES (71, 11, 5, 2022, 574, 8867, 51374490);
INSERT INTO `data_rekening` VALUES (72, 12, 5, 2022, 588, 6645, 29620510);
INSERT INTO `data_rekening` VALUES (73, 13, 5, 2022, 1090, 11479, 59338100);
INSERT INTO `data_rekening` VALUES (74, 14, 5, 2022, 91, 1149, 9289450);
INSERT INTO `data_rekening` VALUES (75, 15, 5, 2022, 1509, 18803, 91749130);
INSERT INTO `data_rekening` VALUES (76, 1, 6, 2022, 5518, 78832, 441045730);
INSERT INTO `data_rekening` VALUES (77, 2, 6, 2022, 1250, 13216, 75633290);
INSERT INTO `data_rekening` VALUES (78, 3, 6, 2022, 1238, 14978, 83191330);
INSERT INTO `data_rekening` VALUES (79, 4, 6, 2022, 1611, 20418, 110196700);
INSERT INTO `data_rekening` VALUES (80, 5, 6, 2022, 1104, 12525, 67475200);
INSERT INTO `data_rekening` VALUES (81, 6, 6, 2022, 1004, 11173, 63754160);
INSERT INTO `data_rekening` VALUES (82, 7, 6, 2022, 1111, 9937, 58960230);
INSERT INTO `data_rekening` VALUES (83, 8, 6, 2022, 1118, 14259, 71224650);
INSERT INTO `data_rekening` VALUES (84, 9, 6, 2022, 1227, 17952, 94646920);
INSERT INTO `data_rekening` VALUES (85, 10, 6, 2022, 301, 4258, 23422100);
INSERT INTO `data_rekening` VALUES (86, 11, 6, 2022, 571, 8634, 49907350);
INSERT INTO `data_rekening` VALUES (87, 12, 6, 2022, 588, 6311, 28725690);
INSERT INTO `data_rekening` VALUES (88, 13, 6, 2022, 1089, 10461, 56566070);
INSERT INTO `data_rekening` VALUES (89, 14, 6, 2022, 91, 1059, 8882090);
INSERT INTO `data_rekening` VALUES (90, 15, 6, 2022, 1506, 14621, 77882430);
INSERT INTO `data_rekening` VALUES (91, 1, 7, 2022, 5497, 76080, 428469390);
INSERT INTO `data_rekening` VALUES (92, 2, 7, 2022, 1252, 13862, 78129880);
INSERT INTO `data_rekening` VALUES (93, 3, 7, 2022, 1244, 17428, 91685570);
INSERT INTO `data_rekening` VALUES (94, 4, 7, 2022, 1619, 22589, 120348470);
INSERT INTO `data_rekening` VALUES (95, 5, 7, 2022, 1101, 13477, 71171680);
INSERT INTO `data_rekening` VALUES (96, 6, 7, 2022, 1005, 11753, 66708910);
INSERT INTO `data_rekening` VALUES (97, 7, 7, 2022, 1090, 8413, 52125140);
INSERT INTO `data_rekening` VALUES (98, 8, 7, 2022, 1109, 13388, 67200810);
INSERT INTO `data_rekening` VALUES (99, 9, 7, 2022, 1229, 17570, 93275520);
INSERT INTO `data_rekening` VALUES (100, 10, 7, 2022, 300, 3573, 19951470);
INSERT INTO `data_rekening` VALUES (101, 11, 7, 2022, 572, 8855, 52097180);
INSERT INTO `data_rekening` VALUES (102, 12, 7, 2022, 584, 6108, 28527060);
INSERT INTO `data_rekening` VALUES (103, 13, 7, 2022, 1088, 9737, 54567070);
INSERT INTO `data_rekening` VALUES (104, 14, 7, 2022, 89, 1081, 8853350);
INSERT INTO `data_rekening` VALUES (105, 15, 7, 2022, 1492, 16018, 81885140);
INSERT INTO `data_rekening` VALUES (106, 1, 8, 2022, 5474, 80239, 456149450);
INSERT INTO `data_rekening` VALUES (107, 2, 8, 2022, 1254, 15994, 85563190);
INSERT INTO `data_rekening` VALUES (108, 3, 8, 2022, 1244, 18525, 95050630);
INSERT INTO `data_rekening` VALUES (109, 4, 8, 2022, 1605, 23274, 121012190);
INSERT INTO `data_rekening` VALUES (110, 5, 8, 2022, 1099, 13985, 72946420);
INSERT INTO `data_rekening` VALUES (111, 6, 8, 2022, 1006, 12447, 68168370);
INSERT INTO `data_rekening` VALUES (112, 7, 8, 2022, 1051, 8315, 51540230);
INSERT INTO `data_rekening` VALUES (113, 8, 8, 2022, 1101, 15012, 73485530);
INSERT INTO `data_rekening` VALUES (114, 9, 8, 2022, 1229, 17599, 92313260);
INSERT INTO `data_rekening` VALUES (115, 10, 8, 2022, 300, 4224, 22464620);
INSERT INTO `data_rekening` VALUES (116, 11, 8, 2022, 570, 8674, 51218010);
INSERT INTO `data_rekening` VALUES (117, 12, 8, 2022, 585, 6222, 28518390);
INSERT INTO `data_rekening` VALUES (118, 13, 8, 2022, 1089, 11401, 61051960);
INSERT INTO `data_rekening` VALUES (119, 14, 8, 2022, 91, 1220, 9495350);
INSERT INTO `data_rekening` VALUES (120, 15, 8, 2022, 1495, 16845, 84349480);
INSERT INTO `data_rekening` VALUES (121, 1, 9, 2022, 5535, 80329, 456528660);
INSERT INTO `data_rekening` VALUES (122, 2, 9, 2022, 1277, 15312, 85329560);
INSERT INTO `data_rekening` VALUES (123, 3, 9, 2022, 1268, 19235, 103011940);
INSERT INTO `data_rekening` VALUES (124, 4, 9, 2022, 1620, 23889, 126606810);
INSERT INTO `data_rekening` VALUES (125, 5, 9, 2022, 1119, 14442, 75828590);
INSERT INTO `data_rekening` VALUES (126, 6, 9, 2022, 1028, 13515, 73372990);
INSERT INTO `data_rekening` VALUES (127, 7, 9, 2022, 1054, 8642, 56941190);
INSERT INTO `data_rekening` VALUES (128, 8, 9, 2022, 1127, 14492, 72567170);
INSERT INTO `data_rekening` VALUES (129, 9, 9, 2022, 1273, 19139, 100730270);
INSERT INTO `data_rekening` VALUES (130, 10, 9, 2022, 303, 4577, 26274550);
INSERT INTO `data_rekening` VALUES (131, 11, 9, 2022, 577, 9118, 54111560);
INSERT INTO `data_rekening` VALUES (132, 12, 9, 2022, 583, 6911, 31497080);
INSERT INTO `data_rekening` VALUES (133, 13, 9, 2022, 1158, 11894, 64982810);
INSERT INTO `data_rekening` VALUES (134, 14, 9, 2022, 101, 1496, 10948320);
INSERT INTO `data_rekening` VALUES (135, 15, 9, 2022, 1527, 17761, 87702480);
INSERT INTO `data_rekening` VALUES (136, 1, 10, 2022, 5551, 78612, 449664840);
INSERT INTO `data_rekening` VALUES (137, 2, 10, 2022, 1275, 15296, 83707500);
INSERT INTO `data_rekening` VALUES (138, 3, 10, 2022, 1262, 18155, 97295380);
INSERT INTO `data_rekening` VALUES (139, 4, 10, 2022, 1642, 23794, 127015780);
INSERT INTO `data_rekening` VALUES (140, 5, 10, 2022, 1115, 13246, 70889370);
INSERT INTO `data_rekening` VALUES (141, 6, 10, 2022, 1029, 12252, 68259360);
INSERT INTO `data_rekening` VALUES (142, 7, 10, 2022, 1033, 8662, 56277000);
INSERT INTO `data_rekening` VALUES (143, 8, 10, 2022, 1122, 14429, 71989930);
INSERT INTO `data_rekening` VALUES (144, 9, 10, 2022, 1272, 18945, 100084210);
INSERT INTO `data_rekening` VALUES (145, 10, 10, 2022, 301, 4221, 23826730);
INSERT INTO `data_rekening` VALUES (146, 11, 10, 2022, 579, 9295, 55577030);
INSERT INTO `data_rekening` VALUES (147, 12, 10, 2022, 581, 6601, 30641290);
INSERT INTO `data_rekening` VALUES (148, 13, 10, 2022, 1152, 11428, 61446050);
INSERT INTO `data_rekening` VALUES (149, 14, 10, 2022, 101, 1453, 21368500);
INSERT INTO `data_rekening` VALUES (150, 15, 10, 2022, 1521, 16782, 83774170);
INSERT INTO `data_rekening` VALUES (151, 1, 11, 2022, 5552, 77283, 528176330);
INSERT INTO `data_rekening` VALUES (152, 2, 11, 2022, 1272, 15932, 104149260);
INSERT INTO `data_rekening` VALUES (153, 3, 11, 2022, 1259, 17706, 113960400);
INSERT INTO `data_rekening` VALUES (154, 4, 11, 2022, 1644, 23197, 148029220);
INSERT INTO `data_rekening` VALUES (155, 5, 11, 2022, 1113, 13886, 87880390);
INSERT INTO `data_rekening` VALUES (156, 6, 11, 2022, 1032, 12539, 83124260);
INSERT INTO `data_rekening` VALUES (157, 7, 11, 2022, 1000, 9548, 71513930);
INSERT INTO `data_rekening` VALUES (158, 8, 11, 2022, 1113, 13782, 84156750);
INSERT INTO `data_rekening` VALUES (159, 9, 11, 2022, 1269, 20338, 127335250);
INSERT INTO `data_rekening` VALUES (160, 10, 11, 2022, 301, 4181, 28052060);
INSERT INTO `data_rekening` VALUES (161, 11, 11, 2022, 576, 8925, 61962890);
INSERT INTO `data_rekening` VALUES (162, 12, 11, 2022, 575, 6789, 35921140);
INSERT INTO `data_rekening` VALUES (163, 13, 11, 2022, 1151, 11590, 74876180);
INSERT INTO `data_rekening` VALUES (164, 14, 11, 2022, 99, 3108, 22258870);
INSERT INTO `data_rekening` VALUES (165, 15, 11, 2022, 1522, 17718, 109972300);
INSERT INTO `data_rekening` VALUES (166, 1, 12, 2022, 5552, 74958, 516976140);
INSERT INTO `data_rekening` VALUES (167, 2, 12, 2022, 1263, 14469, 95560620);
INSERT INTO `data_rekening` VALUES (168, 3, 12, 2022, 1263, 16709, 109330880);
INSERT INTO `data_rekening` VALUES (169, 4, 12, 2022, 1646, 22737, 146012200);
INSERT INTO `data_rekening` VALUES (170, 5, 12, 2022, 1114, 12591, 82132490);
INSERT INTO `data_rekening` VALUES (171, 6, 12, 2022, 1027, 12158, 81132260);
INSERT INTO `data_rekening` VALUES (172, 7, 12, 2022, 988, 8916, 66540750);
INSERT INTO `data_rekening` VALUES (173, 8, 12, 2022, 1113, 12973, 80102960);
INSERT INTO `data_rekening` VALUES (174, 9, 12, 2022, 1270, 19404, 122210570);
INSERT INTO `data_rekening` VALUES (175, 10, 12, 2022, 299, 3850, 26624060);
INSERT INTO `data_rekening` VALUES (176, 11, 12, 2022, 574, 9617, 66355520);
INSERT INTO `data_rekening` VALUES (177, 12, 12, 2022, 570, 5793, 32984490);
INSERT INTO `data_rekening` VALUES (178, 13, 12, 2022, 1151, 11445, 74774130);
INSERT INTO `data_rekening` VALUES (179, 14, 12, 2022, 100, 3410, 23502000);
INSERT INTO `data_rekening` VALUES (180, 15, 12, 2022, 1533, 16724, 106137170);
INSERT INTO `data_rekening` VALUES (181, 1, 1, 2023, 5540, 79627, 540642080);
INSERT INTO `data_rekening` VALUES (182, 2, 1, 2023, 1260, 14503, 95326850);
INSERT INTO `data_rekening` VALUES (183, 3, 1, 2023, 1263, 17131, 111692990);
INSERT INTO `data_rekening` VALUES (184, 4, 1, 2023, 1629, 22543, 144356750);
INSERT INTO `data_rekening` VALUES (185, 5, 1, 2023, 1105, 13513, 85713870);
INSERT INTO `data_rekening` VALUES (186, 6, 1, 2023, 1030, 13139, 86391140);
INSERT INTO `data_rekening` VALUES (187, 7, 1, 2023, 979, 10621, 79091070);
INSERT INTO `data_rekening` VALUES (188, 8, 1, 2023, 1104, 13330, 81647000);
INSERT INTO `data_rekening` VALUES (189, 9, 1, 2023, 1267, 19692, 122989180);
INSERT INTO `data_rekening` VALUES (190, 10, 1, 2023, 300, 4109, 27756090);
INSERT INTO `data_rekening` VALUES (191, 11, 1, 2023, 572, 9412, 64486470);
INSERT INTO `data_rekening` VALUES (192, 12, 1, 2023, 569, 5920, 32590530);
INSERT INTO `data_rekening` VALUES (193, 13, 1, 2023, 1154, 12166, 77414600);
INSERT INTO `data_rekening` VALUES (194, 14, 1, 2023, 100, 3124, 22188860);
INSERT INTO `data_rekening` VALUES (195, 15, 1, 2023, 1534, 18142, 111922950);
INSERT INTO `data_rekening` VALUES (196, 1, 2, 2023, 5569, 77679, 532248940);
INSERT INTO `data_rekening` VALUES (197, 2, 2, 2023, 1259, 13868, 93090760);
INSERT INTO `data_rekening` VALUES (198, 3, 2, 2023, 1277, 16464, 110384210);
INSERT INTO `data_rekening` VALUES (199, 4, 2, 2023, 1646, 23519, 150871520);
INSERT INTO `data_rekening` VALUES (200, 5, 2, 2023, 1123, 13375, 86566750);
INSERT INTO `data_rekening` VALUES (201, 6, 2, 2023, 1033, 12674, 85027380);
INSERT INTO `data_rekening` VALUES (202, 7, 2, 2023, 1005, 10411, 76403080);
INSERT INTO `data_rekening` VALUES (203, 8, 2, 2023, 1106, 13356, 83245430);
INSERT INTO `data_rekening` VALUES (204, 9, 2, 2023, 1293, 18446, 118392400);
INSERT INTO `data_rekening` VALUES (205, 10, 2, 2023, 300, 3863, 27091900);
INSERT INTO `data_rekening` VALUES (206, 11, 2, 2023, 581, 9145, 63666120);
INSERT INTO `data_rekening` VALUES (207, 12, 2, 2023, 562, 5804, 31843340);
INSERT INTO `data_rekening` VALUES (208, 13, 2, 2023, 1168, 11638, 75492070);
INSERT INTO `data_rekening` VALUES (209, 14, 2, 2023, 103, 3773, 26022740);
INSERT INTO `data_rekening` VALUES (210, 15, 2, 2023, 1536, 16360, 105054850);
INSERT INTO `data_rekening` VALUES (211, 1, 3, 2023, 5566, 70663, 495889520);
INSERT INTO `data_rekening` VALUES (212, 2, 3, 2023, 1253, 14230, 94664820);
INSERT INTO `data_rekening` VALUES (213, 3, 3, 2023, 1271, 14110, 99452460);
INSERT INTO `data_rekening` VALUES (214, 4, 3, 2023, 1641, 19731, 131438370);
INSERT INTO `data_rekening` VALUES (215, 5, 3, 2023, 1122, 11834, 80060450);
INSERT INTO `data_rekening` VALUES (216, 6, 3, 2023, 1024, 10780, 75623510);
INSERT INTO `data_rekening` VALUES (217, 7, 3, 2023, 983, 6792, 56371020);
INSERT INTO `data_rekening` VALUES (218, 8, 3, 2023, 1093, 11392, 74484330);
INSERT INTO `data_rekening` VALUES (219, 9, 3, 2023, 1280, 16309, 107932890);
INSERT INTO `data_rekening` VALUES (220, 10, 3, 2023, 299, 3432, 24539470);
INSERT INTO `data_rekening` VALUES (221, 11, 3, 2023, 583, 7994, 58279310);
INSERT INTO `data_rekening` VALUES (222, 12, 3, 2023, 557, 4977, 29991250);
INSERT INTO `data_rekening` VALUES (223, 13, 3, 2023, 1145, 9957, 68411610);
INSERT INTO `data_rekening` VALUES (224, 14, 3, 2023, 99, 2974, 21415930);
INSERT INTO `data_rekening` VALUES (225, 15, 3, 2023, 1513, 13961, 95637560);
INSERT INTO `data_rekening` VALUES (226, 1, 4, 2023, 5568, 79244, 537227140);
INSERT INTO `data_rekening` VALUES (227, 2, 4, 2023, 1248, 12281, 86106170);
INSERT INTO `data_rekening` VALUES (228, 3, 4, 2023, 1257, 15646, 105241590);
INSERT INTO `data_rekening` VALUES (229, 4, 4, 2023, 1624, 21967, 142076890);
INSERT INTO `data_rekening` VALUES (230, 5, 4, 2023, 1121, 14110, 89281160);
INSERT INTO `data_rekening` VALUES (231, 6, 4, 2023, 1029, 11917, 80578530);
INSERT INTO `data_rekening` VALUES (232, 7, 4, 2023, 930, 7742, 58893580);
INSERT INTO `data_rekening` VALUES (233, 8, 4, 2023, 1080, 13418, 82643070);
INSERT INTO `data_rekening` VALUES (234, 9, 4, 2023, 1278, 18488, 117107860);
INSERT INTO `data_rekening` VALUES (235, 10, 4, 2023, 298, 4148, 27941470);
INSERT INTO `data_rekening` VALUES (236, 11, 4, 2023, 581, 8305, 59153730);
INSERT INTO `data_rekening` VALUES (237, 12, 4, 2023, 549, 6320, 34538570);
INSERT INTO `data_rekening` VALUES (238, 13, 4, 2023, 1127, 10735, 70521630);
INSERT INTO `data_rekening` VALUES (239, 14, 4, 2023, 102, 3236, 22945470);
INSERT INTO `data_rekening` VALUES (240, 15, 4, 2023, 1512, 15582, 100975450);
INSERT INTO `data_rekening` VALUES (241, 1, 5, 2023, 5563, 77761, 530137740);
INSERT INTO `data_rekening` VALUES (242, 2, 5, 2023, 1242, 14034, 92291850);
INSERT INTO `data_rekening` VALUES (243, 3, 5, 2023, 1253, 15743, 104226200);
INSERT INTO `data_rekening` VALUES (244, 4, 5, 2023, 1616, 22415, 142439860);
INSERT INTO `data_rekening` VALUES (245, 5, 5, 2023, 1126, 14547, 90937100);
INSERT INTO `data_rekening` VALUES (246, 6, 5, 2023, 1027, 12166, 80704310);
INSERT INTO `data_rekening` VALUES (247, 7, 5, 2023, 934, 8016, 59581110);
INSERT INTO `data_rekening` VALUES (248, 8, 5, 2023, 1061, 12847, 78887540);
INSERT INTO `data_rekening` VALUES (249, 9, 5, 2023, 1274, 18320, 116359450);
INSERT INTO `data_rekening` VALUES (250, 10, 5, 2023, 297, 4174, 28216430);
INSERT INTO `data_rekening` VALUES (251, 11, 5, 2023, 577, 7927, 56923590);
INSERT INTO `data_rekening` VALUES (252, 12, 5, 2023, 544, 6233, 33853050);
INSERT INTO `data_rekening` VALUES (253, 13, 5, 2023, 1126, 10629, 70520960);
INSERT INTO `data_rekening` VALUES (254, 14, 5, 2023, 102, 3187, 22360000);
INSERT INTO `data_rekening` VALUES (255, 15, 5, 2023, 1507, 17518, 108306090);
INSERT INTO `data_rekening` VALUES (256, 1, 6, 2023, 5559, 79578, 539020420);
INSERT INTO `data_rekening` VALUES (257, 2, 6, 2023, 1251, 14005, 93690700);
INSERT INTO `data_rekening` VALUES (258, 3, 6, 2023, 1249, 16496, 109024560);
INSERT INTO `data_rekening` VALUES (259, 4, 6, 2023, 1605, 23300, 146016810);
INSERT INTO `data_rekening` VALUES (260, 5, 6, 2023, 1120, 13591, 87757420);
INSERT INTO `data_rekening` VALUES (261, 6, 6, 2023, 1025, 11982, 79894320);
INSERT INTO `data_rekening` VALUES (262, 7, 6, 2023, 918, 7409, 56339520);
INSERT INTO `data_rekening` VALUES (263, 8, 6, 2023, 1049, 12483, 77357810);
INSERT INTO `data_rekening` VALUES (264, 9, 6, 2023, 1283, 19220, 120089310);
INSERT INTO `data_rekening` VALUES (265, 10, 6, 2023, 295, 4244, 27960130);
INSERT INTO `data_rekening` VALUES (266, 11, 6, 2023, 580, 8233, 58923360);
INSERT INTO `data_rekening` VALUES (267, 12, 6, 2023, 542, 5886, 32834950);
INSERT INTO `data_rekening` VALUES (268, 13, 6, 2023, 1125, 11887, 75585640);
INSERT INTO `data_rekening` VALUES (269, 14, 6, 2023, 103, 3372, 23131550);
INSERT INTO `data_rekening` VALUES (270, 15, 6, 2023, 1507, 17055, 106503570);

-- ----------------------------
-- Table structure for evaluasi_amdk
-- ----------------------------
DROP TABLE IF EXISTS `evaluasi_amdk`;
CREATE TABLE `evaluasi_amdk`  (
  `id_evaluasi_amdk` int NOT NULL AUTO_INCREMENT,
  `tahun_rkap` int NOT NULL,
  `jenis_uraian` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `uraian_evaluasi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `satuan` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `rkap` int NOT NULL,
  `realisasi` int NOT NULL,
  `bagian_upk` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL DEFAULT 1,
  `status_update` int NOT NULL DEFAULT 1,
  `tgl_upload` timestamp NOT NULL DEFAULT current_timestamp,
  `tgl_update` datetime NOT NULL,
  PRIMARY KEY (`id_evaluasi_amdk`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of evaluasi_amdk
-- ----------------------------
INSERT INTO `evaluasi_amdk` VALUES (1, 2023, 'Tenaga Kerja', 'Manajer', 'Orang', 1, 1, 'amdk', 1, 1, '2023-08-24 12:06:08', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_amdk` VALUES (2, 2023, 'Tenaga Kerja', 'Bagian Produksi', 'Orang', 2, 2, 'amdk', 1, 1, '2023-08-24 12:06:24', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_amdk` VALUES (3, 2023, 'Tenaga Kerja', 'Bagian Quality Kontrol', 'Orang', 2, 1, 'amdk', 1, 1, '2023-08-24 12:06:38', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_amdk` VALUES (4, 2023, 'Tenaga Kerja', 'Bagian Pemasaran', 'Orang', 3, 3, 'amdk', 1, 1, '2023-08-24 12:06:50', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_amdk` VALUES (5, 2023, 'Tenaga Kerja', 'Bagian Administrasi & Keuangan', 'Orang', 3, 3, 'amdk', 1, 1, '2023-08-24 12:07:04', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_amdk` VALUES (6, 2023, 'Piutang Usaha', 'Galon', 'Rp', 0, 0, 'amdk', 1, 1, '2023-08-24 12:07:35', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_amdk` VALUES (7, 2023, 'Piutang Usaha', 'Air Gelas 220 ml', 'Rp', 0, 0, 'amdk', 1, 1, '2023-08-24 12:07:50', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_amdk` VALUES (8, 2023, 'Piutang Usaha', 'Air Botol 330 ml', 'Rp', 0, 0, 'amdk', 1, 1, '2023-08-24 12:08:02', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_amdk` VALUES (9, 2023, 'Piutang Usaha', 'Air Botol 500 ml', 'Rp', 0, 0, 'amdk', 1, 1, '2023-08-24 12:08:14', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_amdk` VALUES (10, 2023, 'Piutang Usaha', 'Air Botol 600 ml', 'Rp', 0, 0, 'amdk', 1, 1, '2023-08-24 12:08:24', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_amdk` VALUES (11, 2023, 'Pendapatan Usaha', 'Galon', 'Rp', 181155000, 105357500, 'amdk', 1, 1, '2023-08-24 12:09:00', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_amdk` VALUES (12, 2023, 'Pendapatan Usaha', 'Air Gelas 220 ml', 'Rp', 415184000, 590433900, 'amdk', 1, 1, '2023-08-24 12:09:29', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_amdk` VALUES (13, 2023, 'Pendapatan Usaha', 'Air Botol 330 ml', 'Rp', 34006000, 49498000, 'amdk', 1, 1, '2023-08-24 12:09:49', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_amdk` VALUES (14, 2023, 'Pendapatan Usaha', 'Air Botol 500 ml', 'Rp', 116515000, 80820000, 'amdk', 1, 1, '2023-08-24 12:10:47', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_amdk` VALUES (15, 2023, 'Piutang Usaha', 'Air Botol 1500 ml', 'Rp', 0, 0, 'amdk', 1, 1, '2023-08-24 12:11:19', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_amdk` VALUES (16, 2023, 'Pendapatan Usaha', 'Air Botol 600 ml', 'Rp', 0, 0, 'amdk', 1, 1, '2023-08-24 12:11:39', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_amdk` VALUES (17, 2023, 'Pendapatan Usaha', 'Air Botol 1500 ml', 'Rp', 48342000, 4499500, 'amdk', 1, 1, '2023-08-24 12:13:19', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for evaluasi_program
-- ----------------------------
DROP TABLE IF EXISTS `evaluasi_program`;
CREATE TABLE `evaluasi_program`  (
  `id_evaluasi_program` int NOT NULL AUTO_INCREMENT,
  `tahun_rkap` int NOT NULL,
  `evaluasi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `program` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `bagian_upk` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL DEFAULT 1,
  `status_update` int NOT NULL DEFAULT 1,
  `tgl_upload` timestamp NOT NULL DEFAULT current_timestamp,
  `tgl_update` datetime NOT NULL,
  PRIMARY KEY (`id_evaluasi_program`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of evaluasi_program
-- ----------------------------
INSERT INTO `evaluasi_program` VALUES (1, 2025, 'Peningkatan jumlah SR Baru', 'Promosi SR baru ke upk2', 'percobaan edit dari admin lagi', 'langganan', 1, 1, '2025-08-06 13:54:02', '2025-08-06 14:42:38');

-- ----------------------------
-- Table structure for evaluasi_upk
-- ----------------------------
DROP TABLE IF EXISTS `evaluasi_upk`;
CREATE TABLE `evaluasi_upk`  (
  `id_evaluasi_upk` int NOT NULL AUTO_INCREMENT,
  `tahun_rkap` int NOT NULL,
  `uraian_evaluasi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `satuan` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `rkap` int NOT NULL,
  `realisasi` int NOT NULL,
  `bagian_upk` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL DEFAULT 1,
  `status_update` int NOT NULL DEFAULT 1,
  `tgl_upload` timestamp NOT NULL DEFAULT current_timestamp,
  `tgl_update` datetime NOT NULL,
  PRIMARY KEY (`id_evaluasi_upk`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 37 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of evaluasi_upk
-- ----------------------------
INSERT INTO `evaluasi_upk` VALUES (1, 2023, 'Penambahan Pelanggan Baru', 'SR', 140, 124, 'bondowoso', 1, 1, '2023-08-25 09:51:48', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_upk` VALUES (2, 2023, 'Jumlah pelanggan aktif', 'SR', 5736, 5662, 'bondowoso', 1, 1, '2023-08-28 07:39:24', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_upk` VALUES (3, 2023, 'Jumlah Lbr Yg Direkeningkan', 'Lbr', 39942, 38917, 'bondowoso', 1, 1, '2023-08-28 07:45:20', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_upk` VALUES (4, 2023, 'Air terjual', 'M3', 578697, 541102, 'bondowoso', 1, 1, '2023-08-28 07:45:36', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_upk` VALUES (5, 2023, 'Pendapatan air', 'Rp', 2147483647, 2147483647, 'bondowoso', 1, 1, '2023-08-28 07:46:07', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_upk` VALUES (6, 2023, 'Penambahan Pelanggan Baru', 'SR', 72, 38, 'sukosari1', 1, 1, '2023-08-29 09:54:29', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_upk` VALUES (7, 2023, 'Jumlah pelanggan aktif', 'SR', 1346, 1271, 'sukosari1', 1, 1, '2023-08-29 09:54:43', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_upk` VALUES (8, 2023, 'Jumlah Lbr Yg Direkeningkan', 'Lbr', 1316, 1256, 'sukosari1', 1, 1, '2023-08-29 09:55:09', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_upk` VALUES (9, 2023, 'Air terjual', 'M3', 106059, 96768, 'sukosari1', 1, 1, '2023-08-29 09:55:24', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_upk` VALUES (10, 2023, 'Pendapatan air', 'Rp', 648350322, 648945870, 'sukosari1', 1, 1, '2023-08-29 09:55:41', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_upk` VALUES (11, 2023, 'Penambahan Pelanggan Baru', 'SR', 22, 18, 'maesan', 1, 1, '2023-08-29 10:14:29', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_upk` VALUES (13, 2023, 'Jumlah pelanggan aktif', 'SR', 1275, 1271, 'maesan', 1, 1, '2023-08-29 10:14:58', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_upk` VALUES (14, 2023, 'Jumlah Lbr Yg Direkeningkan', 'Lbr', 1276, 1251, 'maesan', 1, 1, '2023-08-29 10:15:23', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_upk` VALUES (15, 2023, 'Air terjual', 'M3', 118365, 112349, 'maesan', 1, 1, '2023-08-29 10:15:52', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_upk` VALUES (16, 2023, 'Pendapatan air', 'Rp', 719578403, 749340610, 'maesan', 1, 1, '2023-08-29 10:16:05', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_upk` VALUES (17, 2023, 'Penambahan Pelanggan Baru', 'SR', 72, 36, 'tegalampel', 1, 1, '2023-08-29 10:39:04', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_upk` VALUES (18, 2023, 'Jumlah pelanggan aktif', 'SR', 1791, 1762, 'tegalampel', 1, 1, '2023-08-29 10:40:12', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_upk` VALUES (19, 2023, 'Jumlah Lbr Yg Direkeningkan', 'Lbr', 1784, 1607, 'tegalampel', 1, 1, '2023-08-29 10:40:19', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_upk` VALUES (20, 2023, 'Air terjual', 'M3', 172697, 156404, 'tegalampel', 1, 1, '2023-08-29 10:40:34', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_upk` VALUES (21, 2023, 'Pendapatan air', 'Rp', 1025786146, 1002830470, 'tegalampel', 1, 1, '2023-08-29 10:40:53', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_upk` VALUES (22, 2023, 'Penambahan Pelanggan Baru', 'SR', 14, 26, 'tapen', 1, 1, '2023-08-29 11:02:52', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_upk` VALUES (23, 2023, 'Jumlah pelanggan aktif', 'SR', 1125, 1138, 'tapen', 1, 1, '2023-08-29 11:03:03', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_upk` VALUES (24, 2023, 'Jumlah Lbr Yg Direkeningkan', 'Lbr', 7851, 7828, 'tapen', 1, 1, '2023-08-29 11:03:11', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_upk` VALUES (25, 2023, 'Air terjual', 'M3', 95889, 94293, 'tapen', 1, 1, '2023-08-29 11:03:23', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_upk` VALUES (26, 2023, 'Pendapatan air', 'Rp', 559681791, 606305180, 'tapen', 1, 1, '2023-08-29 11:03:36', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_upk` VALUES (27, 2023, 'Penambahan Pelanggan Baru', 'SR', 22, 14, 'prajekan', 1, 1, '2023-08-31 12:39:12', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_upk` VALUES (28, 2023, 'Jumlah pelanggan aktif', 'SR', 1046, 1059, 'prajekan', 1, 1, '2023-08-31 12:39:19', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_upk` VALUES (29, 2023, 'Jumlah Lbr Yg Direkeningkan', 'Lbr', 1047, 1023, 'prajekan', 1, 1, '2023-08-31 12:39:26', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_upk` VALUES (30, 2023, 'Air terjual', 'M3', 82582, 84509, 'prajekan', 1, 1, '2023-08-31 12:39:38', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_upk` VALUES (31, 2023, 'Pendapatan air', 'Rp', 537987052, 567694330, 'prajekan', 1, 1, '2023-08-31 12:40:10', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_upk` VALUES (32, 2023, 'Penambahan Pelanggan Baru', 'SR', 117, 38, 'tlogosari', 1, 1, '2023-09-04 10:21:48', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_upk` VALUES (33, 2023, 'Jumlah pelanggan aktif', 'SR', 1220, 896, 'tlogosari', 1, 1, '2023-09-04 10:22:00', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_upk` VALUES (34, 2023, 'Jumlah Lbr Yg Direkeningkan', 'Lbr', 1232, 896, 'tlogosari', 1, 1, '2023-09-04 10:22:07', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_upk` VALUES (35, 2023, 'Air terjual', 'M3', 12432, 6598, 'tlogosari', 1, 1, '2023-09-04 10:22:24', '0000-00-00 00:00:00');
INSERT INTO `evaluasi_upk` VALUES (36, 2023, 'Pendapatan air', 'Rp', 76148194, 52564080, 'tlogosari', 1, 1, '2023-09-04 10:22:37', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for jabatan
-- ----------------------------
DROP TABLE IF EXISTS `jabatan`;
CREATE TABLE `jabatan`  (
  `id_jabatan` int NOT NULL AUTO_INCREMENT,
  `nama_jabatan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_jabatan`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of jabatan
-- ----------------------------
INSERT INTO `jabatan` VALUES (1, 'Kabag');
INSERT INTO `jabatan` VALUES (2, 'Ketua ');
INSERT INTO `jabatan` VALUES (3, 'Ka UPK');
INSERT INTO `jabatan` VALUES (4, 'Manager');
INSERT INTO `jabatan` VALUES (5, 'Kasubag');
INSERT INTO `jabatan` VALUES (6, 'Pelaksana Administrasi');
INSERT INTO `jabatan` VALUES (7, 'Pelaksana Teknik');
INSERT INTO `jabatan` VALUES (8, 'Pelaksana Pelayanan Pelanggan');
INSERT INTO `jabatan` VALUES (9, 'Anggota');
INSERT INTO `jabatan` VALUES (10, 'Staf Administrasi');
INSERT INTO `jabatan` VALUES (11, 'Staf Teknik');
INSERT INTO `jabatan` VALUES (13, 'Staf Pelayanan Pelanggan');
INSERT INTO `jabatan` VALUES (15, 'Direktur');
INSERT INTO `jabatan` VALUES (18, 'Staf Administrasi(Pembaca Meter)');
INSERT INTO `jabatan` VALUES (19, 'Staf Administrasi(Security)');

-- ----------------------------
-- Table structure for karyawan
-- ----------------------------
DROP TABLE IF EXISTS `karyawan`;
CREATE TABLE `karyawan`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_bagian` int NOT NULL,
  `id_subag` int NOT NULL,
  `id_jabatan` int NOT NULL,
  `nama` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `agama` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status_pegawai` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nik` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `no_hp` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jenkel` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tmp_lahir` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_lahir` date NOT NULL,
  `tgl_masuk` date NOT NULL,
  `aktif` int NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_bagian`(`id_bagian` ASC) USING BTREE,
  INDEX `id_subag`(`id_subag` ASC) USING BTREE,
  INDEX `id_jabatan`(`id_jabatan` ASC) USING BTREE,
  CONSTRAINT `karyawan_ibfk_1` FOREIGN KEY (`id_subag`) REFERENCES `subag` (`id_subag`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `karyawan_ibfk_2` FOREIGN KEY (`id_bagian`) REFERENCES `bagian` (`id_bagian`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `karyawan_ibfk_3` FOREIGN KEY (`id_jabatan`) REFERENCES `jabatan` (`id_jabatan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 217 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of karyawan
-- ----------------------------
INSERT INTO `karyawan` VALUES (1, 3, 6, 1, 'Rosida', 'Sukowiryo, Bondowoso', 'Islam', 'Karyawan Tetap', '12190030', '082302209147', 'Perempuan', 'Bondowoso', '1968-07-28', '1991-01-02', 0);
INSERT INTO `karyawan` VALUES (2, 2, 3, 15, 'April Ariestha Bhirawa', 'Perum Tamansari Indah Bondowoso', 'Islam', 'Karyawan Tetap', '', '085236165969', 'Laki-laki', 'Bondowoso', '1970-04-21', '1992-12-01', 1);
INSERT INTO `karyawan` VALUES (4, 6, 14, 2, 'Supriyadi', 'Klabang Bondowoso', 'Islam', 'Karyawan Tetap', '01592049', '085311048058', 'Laki-laki', 'Bondowoso', '1968-05-02', '1992-05-01', 0);
INSERT INTO `karyawan` VALUES (5, 1, 1, 1, 'Cipto Kusuma', 'Nangkaan Bondowoso', 'Islam', 'Karyawan Tetap', '05589009', '085203365470', 'Laki-laki', 'Banyuwangi', '1967-08-11', '1989-05-05', 0);
INSERT INTO `karyawan` VALUES (6, 2, 3, 1, 'Siti Nuraini', 'Sukowiryo Bondowoso', 'Islam', 'Karyawan Tetap', '01592045', '081336463122', 'Perempuan', 'Bojonegoro', '1968-04-23', '1992-05-01', 0);
INSERT INTO `karyawan` VALUES (9, 6, 14, 2, 'I Made Suarjaya', 'Jln. A. Yani Bondowoso', 'Hindu', 'Karyawan Tetap', '11292083', '08123456789', 'Laki-laki', 'Pujungan', '1972-06-20', '1992-06-20', 1);
INSERT INTO `karyawan` VALUES (10, 5, 12, 1, 'Mohammad Yunus Anis', 'Sukowiryo Bondowoso', 'Islam', 'Karyawan Tetap', '01995599', '08233510842', 'Laki-laki', 'Lumajang', '1972-01-25', '1995-05-19', 1);
INSERT INTO `karyawan` VALUES (13, 7, 22, 3, 'Sirajuddin', 'Prajekan', 'Islam', 'Karyawan Tetap', '31190018', '082331851007', 'Laki-laki', 'Bondowoso', '1968-11-10', '1990-02-02', 0);
INSERT INTO `karyawan` VALUES (14, 7, 31, 3, 'Sudarso', 'Sukowiryo Bondowoso', 'Islam', 'Karyawan Tetap', '05589007', '081336413514', 'Laki-laki', 'Situbondo', '1968-08-28', '1989-05-23', 0);
INSERT INTO `karyawan` VALUES (15, 7, 17, 3, 'Sucipno', 'Tegalampel', 'Islam', 'Karyawan Tetap', '31190022', '085234951008', 'Laki-laki', 'Bondowoso', '1968-07-13', '1990-01-02', 0);
INSERT INTO `karyawan` VALUES (16, 7, 18, 3, 'Juhaeni', 'Maesan', 'Islam', 'Karyawan Tetap', '11292069', '085236343743', 'Laki-laki', 'Bondowoso', '1968-05-25', '1992-12-01', 0);
INSERT INTO `karyawan` VALUES (17, 2, 4, 5, 'Suhendra Paratu', 'Petung Bondowoso', 'Islam', 'Karyawan Tetap', '01592047', '081217071969', 'Laki-laki', 'Tana Toraja', '1969-03-17', '1992-05-01', 0);
INSERT INTO `karyawan` VALUES (18, 7, 21, 3, 'Achmad Roedy Witarsa', 'Hos. Cokroaminoto', 'Islam', 'Karyawan Tetap', '04489005', '081336628789', 'Laki-laki', 'Bondowoso', '1969-03-29', '1989-04-08', 0);
INSERT INTO `karyawan` VALUES (19, 6, 14, 9, 'Teguh Imam Santuso', 'Tenggarang Bondowoso', 'Islam', 'Karyawan Tetap', '01101105', '082335555997', 'Laki-laki', 'Bondowoso', '1968-07-04', '2001-01-01', 0);
INSERT INTO `karyawan` VALUES (20, 7, 21, 3, 'Indrayati', 'Situbondo', 'Islam', 'Karyawan Tetap', '02191031', '085257799751', 'Perempuan', 'Manado', '1967-09-09', '1991-01-02', 0);
INSERT INTO `karyawan` VALUES (21, 2, 3, 19, 'Sundari', 'Nangkaan Bondowoso', 'Islam', 'Karyawan Tetap', '11012119', '085236139585', 'Laki-laki', 'Bondowoso', '1975-04-15', '2012-10-01', 1);
INSERT INTO `karyawan` VALUES (22, 7, 19, 3, 'Rudi Hasyim', 'Badean Bondowoso', 'Islam', 'Karyawan Tetap', '01403108', '085334597710', 'Laki-laki', 'Bondowoso', '1974-11-28', '2003-04-01', 1);
INSERT INTO `karyawan` VALUES (23, 2, 3, 1, 'Suwarna', 'Nangkaan Bondowoso', 'Islam', 'Karyawan Tetap', '01592055', '085338519245', 'Perempuan', 'Bondowoso', '1971-04-16', '1992-05-01', 1);
INSERT INTO `karyawan` VALUES (24, 1, 1, 1, 'Adityas Arief Witjaksono', 'Sekarputih Bondowoso', 'Islam', 'Karyawan Tetap', '01393089', '085257780909', 'Laki-laki', 'Pamekasan', '1971-12-23', '1993-03-01', 1);
INSERT INTO `karyawan` VALUES (25, 7, 30, 3, 'Sanur', 'Sukosari Bondowoso', 'Islam', 'Karyawan Tetap', '01993092', '085258547502', 'Laki-laki', 'Sumenep', '1972-04-21', '1993-09-01', 1);
INSERT INTO `karyawan` VALUES (26, 7, 20, 3, 'Siti Rosida', 'Prajekan Bondowoso', 'Islam', 'Karyawan Tetap', '02191033', '083854071977', 'Laki-laki', 'Prajekan', '1970-01-01', '1991-01-02', 1);
INSERT INTO `karyawan` VALUES (27, 3, 8, 5, 'Lilik Yuli Andayani', 'Sukowiryo Bondowoso', 'Islam', 'Karyawan Tetap', '02191032', '085235425022', 'Perempuan', 'Bondowoso', '1970-07-16', '1991-01-02', 1);
INSERT INTO `karyawan` VALUES (28, 3, 7, 5, 'Yulia', 'Dabasah Bondowoso', 'Islam', 'Karyawan Tetap', '02191035', '085236558772', 'Perempuan', 'Bondowoso', '1970-07-04', '1991-01-02', 1);
INSERT INTO `karyawan` VALUES (29, 2, 3, 5, 'Misiati', 'Sukowiryo Bondowoso', 'Islam', 'Karyawan Tetap', '11292078', '081233719959', 'Perempuan', 'Bondowoso', '1972-06-29', '1992-12-01', 1);
INSERT INTO `karyawan` VALUES (30, 2, 5, 5, 'Linda Anggraita', 'Maesan Bondowoso', 'Islam', 'Karyawan Tetap', '20117147', '085230685485', 'Perempuan', 'Bondowoso', '1992-07-04', '2017-01-02', 1);
INSERT INTO `karyawan` VALUES (31, 3, 6, 1, 'Dicky Erfan Septiono', 'Badean Bondowoso', 'Islam', 'Karyawan Tetap', '01410112', '0816591527', 'Laki-laki', 'Bondowoso', '1978-09-20', '2010-04-01', 1);
INSERT INTO `karyawan` VALUES (32, 4, 11, 5, 'Suwantono', 'Sukowiryo Bondowoso', 'Islam', 'Karyawan Tetap', '01592053', '085258176532', 'Laki-laki', 'Bondowoso', '1971-03-06', '1992-05-01', 1);
INSERT INTO `karyawan` VALUES (33, 7, 19, 6, 'Nuning Handayani', 'Bataan Bondowoso', 'Islam', 'Karyawan Tetap', '01592046', '081317174139', 'Laki-laki', 'Bondowoso', '1972-05-25', '1992-05-01', 1);
INSERT INTO `karyawan` VALUES (34, 7, 31, 6, 'Andrayani', 'Nangkaan Bondowoso', 'Islam', 'Karyawan Tetap', '01592044', '085258038337', 'Perempuan', 'Bondowoso', '1971-04-20', '1992-05-01', 1);
INSERT INTO `karyawan` VALUES (35, 7, 31, 3, 'Rudy Himawan', 'Curahdami Bondowoso', 'Islam', 'Karyawan Tetap', '11292068', '081249804300', 'Laki-laki', 'Kediri', '1971-04-20', '1992-12-01', 1);
INSERT INTO `karyawan` VALUES (36, 7, 22, 7, 'Fitriadi Suryono', 'Sukowiryo Bondowoso', 'Islam', 'Karyawan Tetap', '01592060', '085230266428', 'Laki-laki', 'Jember', '1971-11-21', '1992-05-01', 0);
INSERT INTO `karyawan` VALUES (37, 3, 9, 5, 'Yuliatin Jumariyah', 'Garahan Jember', 'Islam', 'Karyawan Tetap', '28895102', '085233763257', 'Perempuan', 'Jember', '1975-07-31', '1995-08-28', 1);
INSERT INTO `karyawan` VALUES (38, 4, 10, 1, 'Mohammad Rois', 'Curahdami Bondowoso', 'Islam', 'Karyawan Tetap', '11012118', '082330104146', 'Laki-laki', 'Bondowoso', '1978-04-18', '2012-10-01', 1);
INSERT INTO `karyawan` VALUES (39, 7, 18, 3, 'Rahmat Febri Eko Tanyono', 'Jember', 'Islam', 'Karyawan Tetap', '01403046', '085101229001', 'Laki-laki', 'Bojonegoro', '1979-02-17', '2003-04-01', 1);
INSERT INTO `karyawan` VALUES (40, 7, 23, 11, 'Saeful Anshori', 'Kademangan', 'Islam', 'Karyawan Tetap', '10414131', '082330340415', 'Laki-laki', 'Bondowoso', '1982-03-28', '2014-04-01', 1);
INSERT INTO `karyawan` VALUES (41, 7, 26, 3, 'Supangkat Harianto', 'Tegalampel', 'Islam', 'Karyawan Tetap', '20117144', '085330849697', 'Laki-laki', 'Malang', '1984-05-11', '2017-01-02', 1);
INSERT INTO `karyawan` VALUES (42, 7, 25, 3, 'Achmad Novi Patria Budiman', 'Tamansari Bondowoso', 'Islam', 'Karyawan Tetap', '10414125', '082316384438', 'Laki-laki', 'Bondowoso', '1975-11-12', '2014-04-01', 1);
INSERT INTO `karyawan` VALUES (43, 7, 24, 7, 'Rudi Heriyanto', 'Nangkaan Bondowoso', 'Islam', 'Karyawan Tetap', '01592058', '081217894120', 'Laki-laki', 'Bondowoso', '1970-05-24', '1992-05-01', 1);
INSERT INTO `karyawan` VALUES (44, 7, 26, 10, 'Titin Sri Murtinah', 'Koncer Bondowoso', 'Islam', 'Karyawan Tetap', '01493086', '085236039200', 'Perempuan', 'Malang', '1971-07-20', '1993-04-01', 1);
INSERT INTO `karyawan` VALUES (45, 7, 31, 8, 'Sulistyowati', 'Grujugan Bondowoso', 'Islam', 'Karyawan Tetap', '11012121', '085258559926', 'Perempuan', 'Bondowoso', '1981-11-21', '2012-10-01', 1);
INSERT INTO `karyawan` VALUES (46, 7, 18, 6, 'Sohibul Fadillah', 'Maesan Bondowoso', 'Islam', 'Karyawan Tetap', '20117146', '082233598935', 'Perempuan', 'Bondowoso', '1995-06-17', '2017-01-02', 1);
INSERT INTO `karyawan` VALUES (47, 7, 18, 6, 'Santuso', 'Sukowiryo Bondowoso', 'Islam', 'Karyawan Tetap', '11292080', '081336197752', 'Laki-laki', 'Bondowoso', '1967-08-26', '1992-12-01', 0);
INSERT INTO `karyawan` VALUES (48, 7, 17, 3, 'Fathorrasi', 'Badean Bondowoso', 'Islam', 'Karyawan Tetap', '10414134', '085259621069', 'Laki-laki', 'Bondowoso', '1973-01-24', '2014-04-01', 0);
INSERT INTO `karyawan` VALUES (49, 7, 27, 3, 'Sugijono', 'Maesan Bondowoso', 'Islam', 'Karyawan Tetap', '31190016', '085310333737', 'Laki-laki', 'Jember', '1968-02-23', '1990-01-31', 0);
INSERT INTO `karyawan` VALUES (50, 7, 31, 13, 'Erfan', 'Kotakulon Bondowoso', 'Islam', 'Karyawan Tetap', '01592062', '085258191743', 'Laki-laki', 'Bondowoso', '1968-08-14', '1992-05-01', 0);
INSERT INTO `karyawan` VALUES (51, 7, 31, 18, 'Fahmi Tri Andika', 'Kotakulon Bondowoso', 'Islam', 'Karyawan Tetap', '', '085259001165', 'Laki-laki', 'Bondowoso', '1990-09-25', '2024-11-01', 1);
INSERT INTO `karyawan` VALUES (52, 7, 18, 11, 'Rendra Septian', 'Nangkaan Bondowoso', 'Islam', 'Karyawan Kontrak', '', '081382933339', 'Laki-laki', 'Bondowoso', '1994-09-04', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (53, 7, 22, 11, 'Ridwan Nurus Zuhur', 'Gebang Bondowoso', 'Islam', 'Karyawan Tetap', '28423169', '082237746469', 'Laki-laki', 'Bondowoso', '1995-09-13', '2023-04-28', 1);
INSERT INTO `karyawan` VALUES (54, 7, 31, 18, 'Dion  Dwi Sapta R', 'Kembang Bondowoso', 'Islam', 'Karyawan Kontrak', '', '081249805006', 'Laki-laki', 'Sidoarjo', '1995-02-27', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (55, 7, 31, 11, 'Ilyas', 'Bondowoso', 'Islam', 'Karyawan Tetap', '11012114', '082336157245', 'Laki-laki', 'Bondowoso', '1976-09-21', '2012-10-01', 1);
INSERT INTO `karyawan` VALUES (56, 7, 19, 11, 'Mahmudi', 'Bondowoso', 'Islam', 'Karyawan Tetap', '11012115', '085257169200', 'Laki-laki', 'Bondowoso', '1969-07-05', '2012-10-01', 1);
INSERT INTO `karyawan` VALUES (57, 7, 31, 11, 'Audri Dwi Putra Nurilahi', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '089619600254', 'Laki-laki', 'Bondowoso', '2000-01-01', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (58, 7, 31, 11, 'Wijaya Kusuma', 'Bondowoso', 'Islam', 'Karyawan Tetap', '', '085236005991', 'Laki-laki', 'Bondowoso', '1990-01-01', '2023-04-28', 1);
INSERT INTO `karyawan` VALUES (59, 7, 31, 13, 'Ilham Kamil Adi Iskandar', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '082228111207', 'Laki-laki', 'Bondowoso', '1985-10-18', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (60, 7, 31, 11, 'Anton Sujarwo', 'Bondowoso', 'Islam', 'Karyawan Tetap', '', '085259061773', 'Laki-laki', 'Bondowoso', '1990-01-01', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (61, 7, 31, 11, 'Moh Hadi Sutrisno', 'Curahdami Bondowoso', 'Islam', 'Karyawan Tetap', '', '085232903540', 'Laki-laki', 'Bondowoso', '1990-01-01', '2022-05-02', 1);
INSERT INTO `karyawan` VALUES (62, 3, 8, 10, 'Muhammad Deni Saputro', 'Grujugan Bondowoso', 'Islam', 'Karyawan Tetap', '11124190', '083117513423', 'Laki-laki', 'Bondowoso', '1999-11-18', '2024-11-01', 1);
INSERT INTO `karyawan` VALUES (63, 3, 8, 10, 'Somaya Dewantari', 'Dabasah Bondowoso', 'Islam', 'Karyawan Tetap', '02524188', '085232330042', 'Perempuan', 'Bondowoso', '1999-01-31', '2024-05-02', 1);
INSERT INTO `karyawan` VALUES (64, 3, 9, 10, 'Achmad Wahyu Dian P', 'Kademangan Bondowoso', 'Islam', 'Karyawan Tetap', '', '085230993424', 'Laki-laki', 'Bondowoso', '1994-07-14', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (65, 7, 27, 11, 'Bachtiar Cahya Nuangga', 'Sukosari Bondowoso', 'Islam', 'Karyawan Tetap', '', '085228134138', 'Laki-laki', 'Bondowoso', '1988-07-12', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (66, 1, 1, 10, 'Faradiela Sakti Ananda', 'Bondowoso', 'Islam', 'Karyawan Tetap', '', '085258999009', 'Laki-laki', 'Bondowoso', '1991-10-01', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (67, 6, 14, 9, 'Inaka Patria Farino', 'Dabasah Bondowoso', 'Islam', 'Karyawan Tetap', '', '083847782219', 'Laki-laki', 'Bondowoso', '1994-04-25', '2024-11-01', 1);
INSERT INTO `karyawan` VALUES (68, 6, 14, 9, 'Bagas Ridha Tria S', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '082141601557', 'Laki-laki', 'Bondowoso', '1996-04-28', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (69, 5, 13, 5, 'Agus Ridwan Firdaus', 'Jember', 'Islam', 'Karyawan Tetap', '31119154', '085336516320', 'Laki-laki', 'Bondowoso', '1988-08-20', '2019-01-31', 1);
INSERT INTO `karyawan` VALUES (70, 5, 12, 5, 'Resty Ageng Permatasari', 'Bondowoso', 'Islam', 'Karyawan Tetap', '20117149', '082228101715', 'Perempuan', 'Jember', '1984-09-06', '2017-01-02', 1);
INSERT INTO `karyawan` VALUES (71, 5, 12, 10, 'Sonya Desiana Mangiri', 'Koncer Bondowoso', 'Islam', 'Karyawan Tetap', '', '082141841544', 'Perempuan', 'Bondowoso', '2000-01-01', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (72, 5, 13, 10, 'Ainun Febriana', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '082228830285', 'Perempuan', 'Bondowoso', '2000-01-01', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (73, 7, 23, 3, 'Didik Ahmad Rafidi', 'Bondowoso', 'Islam', 'Karyawan Tetap', '10414129', '085234951484', 'Laki-laki', 'Bondowoso', '1981-09-08', '2014-04-01', 1);
INSERT INTO `karyawan` VALUES (74, 4, 10, 5, 'Taufiqurrahman', 'Klabang Bondowoso', 'Islam', 'Karyawan Tetap', '31119158', '082335338758', 'Laki-laki', 'Bondowoso', '1996-01-23', '2019-01-31', 1);
INSERT INTO `karyawan` VALUES (75, 7, 24, 11, 'Muhammad Hafi Anshori', 'Tamansari Bondowoso', 'Islam', 'Karyawan Tetap', '31119159', '082338733342', 'Laki-laki', 'Jember', '1990-09-11', '2019-03-11', 1);
INSERT INTO `karyawan` VALUES (76, 7, 21, 11, 'Rizal Akbar Rusmana', 'Tegalampel Bondowoso', 'Islam', 'Karyawan Tetap', '', '082231275038', 'Laki-laki', 'Bondowoso', '2000-01-01', '2022-05-02', 1);
INSERT INTO `karyawan` VALUES (77, 4, 10, 11, 'Haryo Ari Wibowo', 'Tamanan Bondowoso', 'Islam', 'Karyawan Kontrak', '', '085291714958', 'Laki-laki', 'Jember', '1989-05-11', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (78, 2, 5, 10, 'Annur Darmawan', 'Bataan Bondowoso', 'Islam', 'Karyawan Tetap', '11124195', '081230695407', 'Laki-laki', 'Situbondo', '1996-01-18', '2024-11-01', 1);
INSERT INTO `karyawan` VALUES (79, 2, 4, 10, 'Vika Ardian Farikasari', 'Tegalampel Bondowoso', 'Islam', 'Karyawan Tetap', '11124196', '083847168808', 'Perempuan', 'Bondowoso', '2001-06-11', '2024-11-01', 1);
INSERT INTO `karyawan` VALUES (80, 7, 31, 11, 'Muhammad Budi Hartono', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '082142113872', 'Laki-laki', 'Bondowoso', '1997-10-01', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (81, 2, 3, 19, 'Septa Ragiel P', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '085961563373', 'Laki-laki', 'Bondowoso', '2000-01-01', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (82, 7, 27, 11, 'Adi Fitri Fauzi', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '087760295756', 'Laki-laki', 'Bondowoso', '1997-02-27', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (83, 7, 28, 18, 'M Nasir', 'Tlogosari Bondowoso', 'Islam', 'Karyawan Kontrak', '', '082301708091', 'Laki-laki', 'Bondowoso', '1990-01-01', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (84, 2, 3, 10, 'Mohammad Handoko', 'Nangkaan Bondowoso', 'Islam', 'Karyawan Tetap', '01410111', '089685617475', 'Laki-laki', 'Bondowoso', '1969-04-06', '2010-04-01', 0);
INSERT INTO `karyawan` VALUES (85, 2, 3, 10, 'Fathor Rozyi', 'Bondowoso', 'Islam', 'Karyawan Tetap', '21823177', '085714928475', 'Laki-laki', 'Bondowoso', '1989-09-05', '2023-08-21', 1);
INSERT INTO `karyawan` VALUES (86, 7, 22, 11, 'Mohammad Sugeng Prayogo', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '081259943704', 'Laki-laki', 'Bondowoso', '2002-08-10', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (87, 2, 3, 10, 'Hendi Hendra Laksya Utama', 'Kembang Bondowoso', 'Islam', 'Karyawan Tetap', '10414139', '085231315707', 'Laki-laki', 'Bondowoso', '1978-12-12', '2014-04-01', 1);
INSERT INTO `karyawan` VALUES (88, 2, 3, 10, 'Bayu Nur Sito Utomo', 'Kembang Bondowoso', 'Islam', 'Karyawan Tetap', '', '082332070150', 'Laki-laki', 'Bondowoso', '1991-01-01', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (89, 2, 3, 10, 'Dian Irfan Hanugerah', 'Kembang Bondowoso', 'Islam', 'Karyawan Kontrak', '', '081916059888', 'Laki-laki', 'Bondowoso', '1995-07-26', '0000-00-00', 0);
INSERT INTO `karyawan` VALUES (90, 2, 3, 10, 'Mohamad Fajar Kurniawan', 'Jember', 'Islam', 'Karyawan Tetap', '02524184', '08818457609', 'Laki-laki', 'Jember', '1991-04-29', '2024-05-02', 1);
INSERT INTO `karyawan` VALUES (91, 8, 34, 10, 'Moh Iqbal Septiadi', 'Bondowoso', 'Islam', 'Karyawan Tetap', '21823173', '085157236199', 'Laki-laki', 'Madiun', '1987-09-22', '2023-08-21', 1);
INSERT INTO `karyawan` VALUES (92, 2, 3, 10, 'M. Boby Kurniawan', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '085850617726', 'Laki-laki', 'Bondowoso', '1993-11-09', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (93, 7, 24, 11, 'Angger Wilujeng', 'Nangkaan Bondowoso', 'Islam', 'Karyawan Tetap', '', '087888022255', 'Laki-laki', 'Bondowoso', '1997-12-22', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (94, 2, 3, 10, 'Daniel Wima Pratama', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '085234760170', 'Laki-laki', 'Kediri', '1998-05-07', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (95, 7, 28, 3, 'Arsono Agus Prayudi', 'Bondowoso', 'Islam', 'Karyawan Tetap', '01493085', '082230903020', 'Laki-laki', 'Bondowoso', '1978-02-13', '1993-04-01', 1);
INSERT INTO `karyawan` VALUES (96, 7, 22, 10, 'Tri Puji Rahayu Ningsih', 'Bondowoso', 'Islam', 'Karyawan Tetap', '01403107', '085843071984', 'Perempuan', 'Jember', '1975-11-19', '2003-04-01', 0);
INSERT INTO `karyawan` VALUES (97, 7, 30, 6, 'Anita Kusumayani', 'Bondowoso', 'Islam', 'Karyawan Tetap', '11012120', '082230899665', 'Perempuan', 'Situbondo', '1976-12-08', '2012-01-10', 1);
INSERT INTO `karyawan` VALUES (98, 7, 23, 11, 'Jumanto', 'Wringin', 'Islam', 'Karyawan Tetap', '10414122', '', 'Laki-laki', 'Bondowoso', '1972-02-17', '2014-04-01', 1);
INSERT INTO `karyawan` VALUES (99, 7, 23, 11, 'Ajir', 'Wringin', 'Islam', 'Karyawan Tetap', '10414123', '085334589781', 'Laki-laki', 'Bondowoso', '1972-07-28', '2014-04-01', 1);
INSERT INTO `karyawan` VALUES (100, 7, 21, 3, 'Wiwik', 'Tapen Bondowoso', 'Islam', 'Karyawan Tetap', '10414124', '085257999823', 'Laki-laki', 'Bondowoso', '1975-07-18', '2014-04-01', 1);
INSERT INTO `karyawan` VALUES (101, 7, 30, 11, 'Sudarmo', 'Nangkaan Bondowoso', 'Islam', 'Karyawan Tetap', '10414128', '085236266632', 'Laki-laki', 'Bondowoso', '1975-01-26', '2014-04-01', 1);
INSERT INTO `karyawan` VALUES (102, 7, 22, 11, 'Rafi I', 'Tlogosari Bondowoso', 'Islam', 'Karyawan Tetap', '10414132', '085230210417', 'Laki-laki', 'Bondowoso', '1968-05-19', '2014-04-01', 0);
INSERT INTO `karyawan` VALUES (103, 7, 17, 11, 'Bahrul Ulum', 'Curahdami Bondowoso', 'Islam', 'Karyawan Tetap', '10414137', '085234017564', 'Laki-laki', 'Bondowoso', '1983-07-10', '2014-04-01', 1);
INSERT INTO `karyawan` VALUES (104, 7, 23, 11, 'Sulasis', 'Wringin', 'Islam', 'Karyawan Tetap', '10414141', '085259073073', 'Laki-laki', 'Bondowoso', '1973-11-15', '2014-04-01', 1);
INSERT INTO `karyawan` VALUES (105, 7, 30, 11, 'Lutfi Alfan Rahmatullah', 'Bondowoso', 'Islam', 'Karyawan Tetap', '20117142', '081336336445', 'Laki-laki', 'Bondowoso', '1984-01-21', '2017-01-02', 1);
INSERT INTO `karyawan` VALUES (106, 7, 31, 11, 'Sugiono', 'Nangkaan Bondowoso', 'Islam', 'Karyawan Tetap', '20117143', '085259221782', 'Laki-laki', 'Bondowoso', '1981-07-08', '2017-01-02', 1);
INSERT INTO `karyawan` VALUES (107, 7, 27, 3, 'Sayudi Pranayuda', 'Nangkaan Bondowoso', 'Islam', 'Karyawan Tetap', '20117145', '082323808536', 'Laki-laki', 'Bondowoso', '1984-07-31', '2017-01-02', 1);
INSERT INTO `karyawan` VALUES (108, 7, 22, 11, 'Abdul Jamil', 'Bondowoso', 'Islam', 'Karyawan Tetap', '20117148', '085231344616', 'Laki-laki', 'Bondowoso', '1987-12-26', '2017-01-02', 1);
INSERT INTO `karyawan` VALUES (109, 7, 31, 13, 'Devita Oktaviani', 'Locare Bondowoso', 'Islam', 'Karyawan Tetap', '20117150', '083840388438', 'Perempuan', 'Bondowoso', '1994-10-06', '2017-01-02', 1);
INSERT INTO `karyawan` VALUES (110, 7, 17, 11, 'Beni Puji Raharjo', 'Nangkaan Bondowoso', 'Islam', 'Karyawan Tetap', '31119151', '081947615037', 'Laki-laki', 'Bondowoso', '1991-06-26', '2019-01-31', 1);
INSERT INTO `karyawan` VALUES (111, 7, 22, 3, 'M Arief Teguh Andiyanto', 'Bondowoso', 'Islam', 'Karyawan Tetap', '31119152', '082141492394', 'Laki-laki', 'Bondowoso', '1976-06-28', '2019-01-31', 1);
INSERT INTO `karyawan` VALUES (112, 7, 17, 3, 'Saiful Bari', 'Badean Bondowoso', 'Islam', 'Karyawan Tetap', '311 19 1', '085335111027', 'Laki-laki', 'Situbondo', '1987-03-06', '2019-03-11', 1);
INSERT INTO `karyawan` VALUES (113, 8, 35, 10, 'Muh Abd Cholil', 'Bondowoso', 'Islam', 'Karyawan Tetap', '31119155', '082324897200', 'Laki-laki', 'Bondowoso', '1983-04-01', '2019-01-31', 1);
INSERT INTO `karyawan` VALUES (114, 7, 24, 3, 'Hidayatullah Firdaus', 'Bondowoso', 'Islam', 'Karyawan Tetap', '31119156', '082233120549', 'Laki-laki', 'Bondowoso', '1976-11-06', '2019-01-31', 1);
INSERT INTO `karyawan` VALUES (115, 7, 20, 11, 'Sutikno', 'Gebang Bondowoso', 'Islam', 'Karyawan Tetap', '31119157', '082331354069', 'Laki-laki', 'Bondowoso', '1986-03-08', '2019-01-31', 1);
INSERT INTO `karyawan` VALUES (116, 7, 17, 11, 'Andre Rico Aliffiansyah', 'Prajekan Bondowoso', 'Islam', 'Karyawan Tetap', '31119160', '082244976515', 'Laki-laki', 'Treanggalek', '1995-05-02', '2019-03-11', 1);
INSERT INTO `karyawan` VALUES (117, 7, 23, 10, 'Ratih Nur Azizatuz Zuhro', 'Pakem Bondowoso', 'Islam', 'Karyawan Tetap', '31119161', '085236537052', 'Perempuan', 'Bondowoso', '1993-01-30', '2019-01-31', 1);
INSERT INTO `karyawan` VALUES (118, 7, 17, 10, 'Wawan Budianto', 'Sukosari Bondowoso', 'Islam', 'Karyawan Tetap', '31119162', '082139022511', 'Laki-laki', 'Bondowoso', '1993-02-15', '2019-01-31', 1);
INSERT INTO `karyawan` VALUES (119, 1, 1, 10, 'Andriya Ikfa Nurul Ms', 'Bataan Bondowoso', 'Islam', 'Karyawan Tetap', '31119164', '082283884577', 'Laki-laki', 'Malang', '1994-08-01', '2019-03-11', 1);
INSERT INTO `karyawan` VALUES (120, 7, 25, 18, 'Ananta Prayogi', 'Kotakulon Bondowoso', 'Islam', 'Karyawan Tetap', '28423167', '082245520624', 'Laki-laki', 'Bondowoso', '1993-03-27', '2023-04-28', 1);
INSERT INTO `karyawan` VALUES (121, 7, 26, 11, 'Moh Iqbal Bachtiar', 'Bondowoso', 'Islam', 'Karyawan Tetap', '28423168', '082233831357', 'Laki-laki', 'Sumenep', '1994-03-19', '2023-04-28', 1);
INSERT INTO `karyawan` VALUES (122, 7, 30, 10, 'Mohlasi', 'Tegalampel Bondowoso', 'Islam', 'Karyawan Tetap', '', '089682212739', 'Laki-laki', 'Bondowoso', '1989-09-05', '2023-04-28', 1);
INSERT INTO `karyawan` VALUES (123, 7, 25, 10, 'Novi Sundari Subaidah', 'Maesan Bondowoso', 'Islam', 'Karyawan Kontrak', '', '082330926669', 'Perempuan', 'Jember', '1991-11-05', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (124, 7, 23, 11, 'Moh Sofyan Hadi', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '085234452462', 'Laki-laki', 'Bondowoso', '1980-07-11', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (125, 7, 23, 11, 'Andika Eka Prayudi', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '085232472763', 'Laki-laki', 'Bondowoso', '2000-01-01', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (126, 7, 17, 11, 'Syaifullah', 'Sukosari Bondowoso', 'Islam', 'Karyawan Kontrak', '', '081252190579', 'Laki-laki', 'Bondowoso', '2000-01-01', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (127, 7, 17, 18, 'Tegar Ubaidhir Rahman', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '081259495726', 'Laki-laki', 'Bondowoso', '2003-05-02', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (128, 7, 18, 11, 'Hendrik Efendi', 'Maesan Bondowoso', 'Islam', 'Karyawan Kontrak', '', '081335464652', 'Laki-laki', 'Bondowoso', '1992-10-07', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (129, 7, 17, 10, 'Mustika Aditya Pratiwi', 'Sukowiryo Bondowoso', 'Islam', 'Karyawan Kontrak', '', '085732571483', 'Perempuan', 'Bondowoso', '2000-01-01', '0000-00-00', 0);
INSERT INTO `karyawan` VALUES (130, 7, 19, 11, 'Abdul Wahid', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '082335552926', 'Laki-laki', 'Bondowoso', '1988-03-03', '0000-00-00', 0);
INSERT INTO `karyawan` VALUES (131, 7, 19, 11, 'Alfian Maulana Rosyidi', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '081332323828', 'Laki-laki', 'Bondowoso', '1992-09-24', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (132, 7, 19, 18, 'Andi Siswanto', 'Bondowoso', 'Islam', 'Karyawan Tetap', '', '083115872049', 'Laki-laki', 'Bondowoso', '1996-08-19', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (133, 4, 10, 11, 'Imam Kusairi', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '082330109338', 'Laki-laki', 'Bondowoso', '1996-05-19', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (134, 7, 20, 10, 'Ardiansyah Wahyu R H', 'Tapen Bondowoso', 'Islam', 'Karyawan Kontrak', '', '081336603300', 'Laki-laki', 'Bondowoso', '1996-09-08', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (135, 7, 20, 11, 'Doddy Arifaldi Yuniargo', 'Prajekan Bondowoso', 'Islam', 'Karyawan Kontrak', '', '081231904530', 'Laki-laki', 'Bondowoso', '2000-01-16', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (136, 7, 20, 18, 'Fahrozi Dwi Julianto', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '082245284740', 'Laki-laki', 'Bondowoso', '1992-07-25', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (137, 7, 20, 11, 'Hafidzul Ahkam', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '081232608664', 'Laki-laki', 'Bondowoso', '1991-07-21', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (138, 7, 19, 11, 'Dharma Marisca', 'Bondowoso', 'Islam', 'Karyawan Tetap', '04923180', '089656525722', 'Laki-laki', 'Surabaya', '1996-05-07', '2023-09-04', 1);
INSERT INTO `karyawan` VALUES (139, 7, 28, 11, 'Nasrullah', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '085231140559', 'Laki-laki', 'Bondowoso', '1999-07-07', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (140, 7, 21, 11, 'Rohmat Maulana', 'Prajekan Bondowoso', 'Islam', 'Karyawan Kontrak', '', '081252722169', 'Laki-laki', 'Bondowoso', '2000-01-01', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (141, 7, 31, 18, 'Muhammad Akbar Maulana', 'Nangkaan Bondowoso', 'Islam', 'Karyawan Kontrak', '', '088237670090', 'Laki-laki', 'Bondowoso', '2002-12-22', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (142, 7, 22, 18, 'Muhammad Imam Badri', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '082264218348', 'Laki-laki', 'Bondowoso', '1990-01-01', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (143, 4, 10, 11, 'Lutfi Arip', 'Bondowoso', 'Islam', 'Karyawan Tetap', '', '081133318314', 'Laki-laki', 'Bondowoso', '1997-09-09', '2023-04-28', 1);
INSERT INTO `karyawan` VALUES (144, 7, 22, 11, 'Jasit', 'Tlogosari Bondowoso', 'Islam', 'Karyawan Honorer', '', '082112200645', 'Laki-laki', 'Bondowoso', '1990-01-01', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (145, 7, 23, 11, 'Adi Suharsono', 'Wringin Bondowoso', 'Islam', 'Karyawan Kontrak', '', '081133318312', 'Laki-laki', 'Bondowoso', '1991-07-06', '0000-00-00', 0);
INSERT INTO `karyawan` VALUES (146, 7, 23, 11, 'Firman Hidayah', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '082233010077', 'Laki-laki', 'Bondowoso', '1990-02-10', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (147, 7, 23, 18, 'Junaedi', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '081230656346', 'Laki-laki', 'Bondowoso', '2000-01-01', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (148, 7, 24, 18, 'Guntur Hermawan', 'Gebang Bondowoso', 'Islam', 'Karyawan Tetap', '', '085331301116', 'Laki-laki', 'Bondowoso', '1994-11-23', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (149, 7, 31, 10, 'Renaldi Ramadan', 'Bondowoso', 'Islam', 'Karyawan Tetap', '', '085336300788', 'Laki-laki', 'Bondowoso', '2000-01-01', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (150, 7, 24, 11, 'Ahmad Fatoni', 'Bondowoso', 'Islam', 'Karyawan Tetap', '', '085334529202', 'Laki-laki', 'Bondowoso', '1998-05-15', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (151, 7, 24, 11, 'Muhammad Awat Heryanto', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '081216416136', 'Laki-laki', 'Bondowoso', '1990-01-01', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (152, 7, 26, 11, 'Bayu Candra Wicaksono', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '082334070443', 'Laki-laki', 'Bondowoso', '1985-04-26', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (153, 7, 31, 11, 'Thesar Wahyu Ardiansyah', 'Nangkaan Bondowoso', 'Islam', 'Karyawan Tetap', '', '082141451739', 'Laki-laki', 'Bondowoso', '2001-05-19', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (154, 7, 17, 11, 'Anugerah Riski Fardana', 'Koncer Bondowoso', 'Islam', 'Karyawan Kontrak', '', '085210675373', 'Laki-laki', 'Bondowoso', '1990-01-01', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (155, 7, 27, 18, 'Abdul Basit Junaidi', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '082237334786', 'Laki-laki', 'Bondowoso', '1986-06-06', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (156, 2, 3, 19, 'Andi Rahmat Hakim', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '081946132195', 'Laki-laki', 'Bondowoso', '1998-10-12', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (157, 7, 28, 10, 'Ahmad Muzammil', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '085234621803', 'Laki-laki', 'Bondowoso', '2000-01-01', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (158, 7, 28, 11, 'Teguh Umar F', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '085230689119', 'Laki-laki', 'Bondowoso', '1999-02-19', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (159, 7, 28, 10, 'Reza Satria Airlangga', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '085607963612', 'Laki-laki', 'Bondowoso', '2000-01-01', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (160, 7, 28, 11, 'Prasetyo Dwi Risqianto', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '085745789015', 'Laki-laki', 'Bondowoso', '2001-05-26', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (161, 7, 30, 11, 'Sintoso', 'Prajekan Bondowoso', 'Islam', 'Karyawan Tetap', '01410109', '', 'Laki-laki', 'Bondowoso', '1972-09-06', '2010-04-01', 1);
INSERT INTO `karyawan` VALUES (162, 7, 17, 11, 'Bayu Prianto', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '082230160046', 'Laki-laki', 'Bondowoso', '1996-04-04', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (163, 7, 30, 11, 'Andika Juni Suharyanto', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '082143165806', 'Laki-laki', 'Bondowoso', '2000-01-01', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (164, 7, 30, 10, 'Dika Pratama', 'Tenggarang Bondowoso', 'Islam', 'Karyawan Kontrak', '', '082339143730', 'Laki-laki', 'Bondowoso', '1998-11-04', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (165, 7, 30, 18, 'Firman Damansyah', 'Pujer Bondowoso', 'Islam', 'Karyawan Kontrak', '', '081330811600', 'Laki-laki', 'Bondowoso', '1995-10-06', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (166, 7, 27, 11, 'Putra Raga Adityamala', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '083874580762', 'Laki-laki', 'Bondowoso', '1990-01-01', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (167, 8, 4, 10, 'Reza Yudianto', 'Petung Bondowoso', 'Islam', 'Karyawan Tetap', '21823175', '082330433653', 'Laki-laki', 'Surabaya', '1986-04-06', '2023-08-21', 1);
INSERT INTO `karyawan` VALUES (168, 2, 4, 10, 'Yosef Nasoka', 'Petung Bondowoso', 'Islam', 'Karyawan Tetap', '', '085204937722', 'Laki-laki', 'Bondowoso', '1996-09-21', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (169, 2, 3, 10, 'Ardiylla Rosza', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '083198579633', 'Perempuan', 'Bondowoso', '2000-01-01', '0000-00-00', 0);
INSERT INTO `karyawan` VALUES (170, 8, 35, 10, 'Dwi Bekti Hariyanto', 'Pancoran Bondowoso', 'Islam', 'Karyawan Kontrak', '', '083872907252', 'Laki-laki', 'Bondowoso', '1996-04-14', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (171, 7, 30, 11, 'Muhammad Zainul Hasan', 'Bondowoso', 'Islam', 'Karyawan Tetap', '', '082335519390', 'Laki-laki', 'Bondowoso', '1994-12-29', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (172, 2, 3, 10, 'Zainul Hasan', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '085233355118', 'Laki-laki', 'Bondowoso', '1988-12-18', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (173, 8, 34, 10, 'Ali Shadikin', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '082142101456', 'Laki-laki', 'Bondowoso', '1992-11-25', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (174, 3, 7, 10, 'Chinta Adelita Diva', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '081249800779', 'Perempuan', 'Bondowoso', '2000-01-01', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (175, 7, 18, 11, 'Muchamad Aidil Akbar', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '082336993553', 'Laki-laki', 'Bondowoso', '1997-04-24', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (176, 7, 18, 11, 'Ade Prayoga', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '085880954831', 'Laki-laki', 'Bondowoso', '2000-01-01', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (177, 7, 22, 10, 'Mohammad Andika', 'Tlogosari Bondowoso', 'Islam', 'Karyawan Kontrak', '', '085232723699', 'Laki-laki', 'Bondowoso', '1998-09-20', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (178, 7, 28, 10, 'Aisyah Evita Dewi', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '083847437787', 'Perempuan', 'Bondowoso', '1998-01-01', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (179, 4, 11, 10, 'Nurul Qomariyah', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '088803718524', 'Perempuan', 'Bondowoso', '2023-09-18', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (180, 7, 19, 10, 'Denny Setiady Prabowo', 'Jl. S.Parman Perum Badean Estate Bondowoso', 'Islam', 'Karyawan Kontrak', '', '083147860320', 'Laki-laki', 'Bondowoso', '2023-09-18', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (181, 7, 18, 18, 'Moch Yahya Ikbar', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '089683017714', 'Laki-laki', 'Bondowoso', '2023-09-18', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (182, 7, 21, 10, 'Emelia Rafilah Aisya', 'Blimbing Bondowoso', 'Islam', 'Karyawan Kontrak', '', '081231947779', 'Perempuan', 'Bondowoso', '2023-09-18', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (183, 7, 18, 10, 'Alyfiyyah Jamil', 'Maesan Bondowoso', 'Islam', 'Karyawan Kontrak', '11124191', '', 'Perempuan', 'Bondowoso', '1998-04-14', '2024-11-01', 1);
INSERT INTO `karyawan` VALUES (184, 7, 20, 11, 'Anugerah Putra Suwantono', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '', 'Laki-laki', 'Bondowoso', '2023-09-18', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (185, 7, 19, 10, 'Anisah Firdaus', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '085781701599', 'Perempuan', 'Bondowoso', '2000-01-01', '2024-05-28', 1);
INSERT INTO `karyawan` VALUES (186, 7, 19, 11, 'Temmy Rizky Prihandana', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '', 'Laki-laki', 'Bondowoso', '2023-09-18', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (187, 7, 26, 18, 'Imam Arifin', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '0895383501136', 'Laki-laki', 'Bondowoso', '2023-09-18', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (188, 7, 17, 11, 'Novi Hidayah', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '', 'Laki-laki', 'Bondowoso', '2023-09-18', '0000-00-00', 1);
INSERT INTO `karyawan` VALUES (189, 7, 31, 18, 'Arief Chandra Hermawan', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '085204860465', 'Laki-laki', 'Bondowoso', '2000-01-01', '2024-05-27', 1);
INSERT INTO `karyawan` VALUES (190, 8, 34, 10, 'Tony Adam Iskandar', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '082289747555', 'Laki-laki', 'Bondowoso', '2000-01-01', '2024-05-27', 1);
INSERT INTO `karyawan` VALUES (191, 7, 20, 10, 'Radhika Vavirya Sunardi', 'Bondowoso', 'Islam', 'Karyawan Honorer', '', '082139533450', 'Laki-laki', 'Bondowoso', '2000-01-01', '2024-05-27', 1);
INSERT INTO `karyawan` VALUES (192, 7, 28, 11, 'Dede Ahmad Satrio', 'Bondowoso', 'Islam', 'Karyawan Honorer', '', '083867817451', 'Laki-laki', 'Bondowoso', '2000-01-01', '2024-05-27', 1);
INSERT INTO `karyawan` VALUES (193, 7, 21, 11, 'Ravimalik Fathon M', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '081332996673', 'Laki-laki', 'Bondowoso', '2000-01-01', '2024-05-27', 1);
INSERT INTO `karyawan` VALUES (194, 8, 34, 10, 'Rizaldy Yudha Arry P', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '081330462714', 'Laki-laki', 'Bondowoso', '2000-01-01', '2024-05-27', 1);
INSERT INTO `karyawan` VALUES (195, 8, 34, 10, 'Alex Agus Setiawan', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '085645705926', 'Laki-laki', 'Bondowoso', '2000-01-01', '2024-05-27', 1);
INSERT INTO `karyawan` VALUES (196, 7, 21, 18, 'Febri Ananda Maunah D', 'Prajekan', 'Islam', 'Karyawan Honorer', '', '085337035197', 'Laki-laki', 'Bondowoso', '2000-01-01', '2024-05-27', 1);
INSERT INTO `karyawan` VALUES (197, 7, 22, 10, 'Anggi Agus F', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '081331652586', 'Laki-laki', 'Bondowoso', '2000-01-01', '2024-05-27', 1);
INSERT INTO `karyawan` VALUES (198, 7, 24, 11, 'Andrean Priyanto S', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '085707950286', 'Laki-laki', 'Bondowoso', '2000-01-01', '2024-05-27', 1);
INSERT INTO `karyawan` VALUES (199, 8, 15, 4, 'Rudy Harnalis', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '08122333960', 'Laki-laki', 'Bondowoso', '1970-01-01', '2024-05-01', 0);
INSERT INTO `karyawan` VALUES (200, 8, 15, 4, 'Edi Suhartono', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '082141412986', 'Laki-laki', 'Bondowoso', '2000-01-01', '2024-05-27', 1);
INSERT INTO `karyawan` VALUES (201, 7, 19, 18, 'Ricky Nugroho', 'Bondowoso', 'Islam', 'Karyawan Honorer', '', '', 'Laki-laki', 'Bondowoso', '2000-01-01', '2024-06-01', 1);
INSERT INTO `karyawan` VALUES (202, 4, 10, 11, 'Abean Azriel Widyo S', 'Bondowoso', 'Islam', 'Karyawan Honorer', '', '081235139683', 'Laki-laki', 'Bondowoso', '2000-01-01', '2024-06-01', 1);
INSERT INTO `karyawan` VALUES (203, 6, 14, 9, 'Aminah Oktarina Libra A', 'Bondowoso', 'Islam', 'Karyawan Honorer', '', '', 'Perempuan', 'Bondowoso', '2000-01-01', '2024-06-01', 1);
INSERT INTO `karyawan` VALUES (204, 2, 3, 19, 'Muhammad Rizal Qhadafi', 'Bondowoso', 'Islam', 'Karyawan Honorer', '', '085730634070', 'Laki-laki', 'Bondowoso', '2000-01-01', '2024-06-01', 1);
INSERT INTO `karyawan` VALUES (205, 7, 31, 11, 'Muhammad Armand Reza M', 'Bondowoso', 'Islam', 'Karyawan Honorer', '', '083877005717', 'Laki-laki', 'Bondowoso', '2000-01-01', '2024-08-01', 1);
INSERT INTO `karyawan` VALUES (206, 7, 31, 11, 'Moh Syahrial Putra P', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '', 'Laki-laki', 'Bondowoso', '2000-01-01', '2024-08-01', 1);
INSERT INTO `karyawan` VALUES (207, 7, 19, 11, 'Muhammad Ariel Maulana', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '', 'Laki-laki', 'Bondowoso', '2000-01-01', '2024-01-01', 1);
INSERT INTO `karyawan` VALUES (208, 7, 22, 11, 'Riko Aditya N', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '082229148459', 'Laki-laki', 'Bondowoso', '2000-01-01', '2024-01-01', 0);
INSERT INTO `karyawan` VALUES (209, 8, 34, 10, 'Alvianda Rizkiyadi R', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '085257307218', 'Laki-laki', 'Bondowoso', '2000-01-01', '2024-01-01', 1);
INSERT INTO `karyawan` VALUES (210, 8, 4, 10, 'Decky Rizaldy E D', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '082233933496', 'Laki-laki', 'Bondowoso', '2000-01-01', '2024-01-01', 1);
INSERT INTO `karyawan` VALUES (211, 7, 21, 11, 'Dian Siregar', 'Bondowoso', 'Islam', 'Karyawan Honorer', '', '083867879745', 'Laki-laki', 'Bondowoso', '2000-01-01', '2025-01-01', 1);
INSERT INTO `karyawan` VALUES (212, 7, 24, 10, 'Mita Yoandra', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '085931156709', 'Perempuan', 'Bondowoso', '2000-01-01', '2025-01-01', 1);
INSERT INTO `karyawan` VALUES (213, 1, 1, 10, 'Aqsa Fahmiranda Darmawan Lubis', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '082140356939', 'Laki-laki', 'Bondowoso', '2000-01-01', '2025-01-01', 1);
INSERT INTO `karyawan` VALUES (215, 2, 3, 10, 'Giant Paul Ivan', 'Bondowoso', 'Islam', 'Karyawan Honorer', '', '', 'Laki-laki', 'Bondowoso', '2000-01-01', '2025-01-01', 1);
INSERT INTO `karyawan` VALUES (216, 2, 5, 10, 'Siti Syafira Densiana T', 'Bondowoso', 'Islam', 'Karyawan Kontrak', '', '085232438208', 'Perempuan', 'Bondowoso', '2000-01-01', '0000-00-00', 1);

-- ----------------------------
-- Table structure for kendaraan
-- ----------------------------
DROP TABLE IF EXISTS `kendaraan`;
CREATE TABLE `kendaraan`  (
  `id_kendaraan` int NOT NULL AUTO_INCREMENT,
  `id_karyawan` int NOT NULL,
  `id_merk` int NOT NULL,
  `id_type` int NOT NULL,
  `no_plat` varchar(9) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `no_rangka` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `no_mesin` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jumlah_roda` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tahun` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `warna` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `bahan_bakar` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `berlaku_sampai` date NOT NULL,
  PRIMARY KEY (`id_kendaraan`) USING BTREE,
  INDEX `id_merk`(`id_merk` ASC) USING BTREE,
  INDEX `id_type`(`id_type` ASC) USING BTREE,
  INDEX `id_karyawan`(`id_karyawan` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kendaraan
-- ----------------------------
INSERT INTO `kendaraan` VALUES (1, 2, 5, 4, 'P5582AB', '123456789654', 'pl12659877aert', '4', '2012', 'silver', 'Solar', '2022-06-30');
INSERT INTO `kendaraan` VALUES (4, 4, 1, 2, 'P3396AB', '1234567988', 'ply12365841tre', '2', '1997', 'Hitam', 'Bensin', '2022-06-25');
INSERT INTO `kendaraan` VALUES (6, 6, 1, 5, 'P6953AB', '1234567988', 'ply123658412tre', '2', '2011', 'Hitam', 'Bensin', '2022-06-30');
INSERT INTO `kendaraan` VALUES (7, 5, 1, 3, 'P3385AB', '1234567988', 'ply12365841tre', '2', '2018', 'Hitam', 'Bensin', '2022-06-30');

-- ----------------------------
-- Table structure for ket_potensi_sr
-- ----------------------------
DROP TABLE IF EXISTS `ket_potensi_sr`;
CREATE TABLE `ket_potensi_sr`  (
  `id_ket_potensi` int NOT NULL AUTO_INCREMENT,
  `tahun_rkap` int NOT NULL,
  `nama_wil` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jumlah_sr` int NOT NULL,
  `status` int NOT NULL DEFAULT 1,
  `status_update` int NOT NULL DEFAULT 1,
  `bagian_upk` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_upload` timestamp NOT NULL DEFAULT current_timestamp,
  `tgl_update` datetime NOT NULL,
  PRIMARY KEY (`id_ket_potensi`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 32 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ket_potensi_sr
-- ----------------------------
INSERT INTO `ket_potensi_sr` VALUES (1, 2023, 'Perum Wijaya Kusuma', 50, 1, 1, 'bondowoso', '2023-08-25 07:49:11', '0000-00-00 00:00:00');
INSERT INTO `ket_potensi_sr` VALUES (2, 2023, 'Perum Vandoland', 20, 1, 1, 'bondowoso', '2023-08-25 07:49:40', '0000-00-00 00:00:00');
INSERT INTO `ket_potensi_sr` VALUES (3, 2023, 'Perum Tata Residence', 10, 1, 1, 'bondowoso', '2023-08-25 07:50:28', '0000-00-00 00:00:00');
INSERT INTO `ket_potensi_sr` VALUES (4, 2023, 'Perum Graha Pelita', 50, 1, 1, 'bondowoso', '2023-08-25 07:50:43', '0000-00-00 00:00:00');
INSERT INTO `ket_potensi_sr` VALUES (5, 2023, 'Perum Villa Kembang Asri', 20, 1, 1, 'bondowoso', '2023-08-25 07:51:02', '0000-00-00 00:00:00');
INSERT INTO `ket_potensi_sr` VALUES (6, 2023, 'Perum City Gate A.Yani', 10, 1, 1, 'bondowoso', '2023-08-25 07:51:49', '0000-00-00 00:00:00');
INSERT INTO `ket_potensi_sr` VALUES (7, 2023, 'Perum A. Yani Regency', 5, 1, 1, 'bondowoso', '2023-08-25 07:52:03', '0000-00-00 00:00:00');
INSERT INTO `ket_potensi_sr` VALUES (8, 2023, 'existing', 35, 1, 1, 'bondowoso', '2023-08-25 07:52:12', '0000-00-00 00:00:00');
INSERT INTO `ket_potensi_sr` VALUES (9, 2023, 'Tanah wulan', 8, 1, 1, 'maesan', '2023-08-29 10:12:42', '0000-00-00 00:00:00');
INSERT INTO `ket_potensi_sr` VALUES (10, 2023, 'Sumber Sari Selatan', 4, 1, 1, 'maesan', '2023-08-29 10:13:02', '0000-00-00 00:00:00');
INSERT INTO `ket_potensi_sr` VALUES (11, 2023, 'Sumber Sari Utara', 6, 1, 1, 'maesan', '2023-08-29 10:13:14', '0000-00-00 00:00:00');
INSERT INTO `ket_potensi_sr` VALUES (12, 2023, 'Maesan', 5, 1, 1, 'maesan', '2023-08-29 10:13:23', '0000-00-00 00:00:00');
INSERT INTO `ket_potensi_sr` VALUES (13, 2023, 'Gambangan', 3, 1, 1, 'maesan', '2023-08-29 10:13:31', '0000-00-00 00:00:00');
INSERT INTO `ket_potensi_sr` VALUES (14, 2023, 'Penanggungan', 2, 1, 1, 'maesan', '2023-08-29 10:13:52', '0000-00-00 00:00:00');
INSERT INTO `ket_potensi_sr` VALUES (15, 2023, 'Tegalampel', 5, 1, 1, 'tegalampel', '2023-08-29 10:37:52', '0000-00-00 00:00:00');
INSERT INTO `ket_potensi_sr` VALUES (16, 2023, 'Pejaten', 10, 1, 1, 'tegalampel', '2023-08-29 10:38:00', '0000-00-00 00:00:00');
INSERT INTO `ket_potensi_sr` VALUES (17, 2023, 'Sekarputih', 5, 1, 1, 'tegalampel', '2023-08-29 10:38:09', '0000-00-00 00:00:00');
INSERT INTO `ket_potensi_sr` VALUES (18, 2023, 'Karanganyar', 27, 1, 1, 'tegalampel', '2023-08-29 10:38:19', '0000-00-00 00:00:00');
INSERT INTO `ket_potensi_sr` VALUES (19, 2023, 'Locare', 3, 1, 1, 'tegalampel', '2023-08-29 10:38:26', '0000-00-00 00:00:00');
INSERT INTO `ket_potensi_sr` VALUES (20, 2023, 'Karangsengon', 3, 1, 1, 'tapen', '2023-08-29 11:01:36', '0000-00-00 00:00:00');
INSERT INTO `ket_potensi_sr` VALUES (21, 2023, 'Donosuko', 3, 1, 1, 'tapen', '2023-08-29 11:01:46', '0000-00-00 00:00:00');
INSERT INTO `ket_potensi_sr` VALUES (22, 2023, 'Blimbing', 2, 1, 1, 'tapen', '2023-08-29 11:01:57', '0000-00-00 00:00:00');
INSERT INTO `ket_potensi_sr` VALUES (23, 2023, 'Tapen', 8, 1, 1, 'tapen', '2023-08-29 11:02:04', '0000-00-00 00:00:00');
INSERT INTO `ket_potensi_sr` VALUES (24, 2023, 'Posong', 9, 1, 1, 'tapen', '2023-08-29 11:02:15', '0000-00-00 00:00:00');
INSERT INTO `ket_potensi_sr` VALUES (25, 2023, 'Prajekan lor', 10, 1, 1, 'prajekan', '2023-08-31 12:38:37', '0000-00-00 00:00:00');
INSERT INTO `ket_potensi_sr` VALUES (26, 2023, 'Prajekan Kidul', 10, 1, 1, 'prajekan', '2023-08-31 12:38:44', '0000-00-00 00:00:00');
INSERT INTO `ket_potensi_sr` VALUES (27, 2023, 'Patemon', 5, 1, 1, 'tlogosari', '2023-09-04 10:20:00', '0000-00-00 00:00:00');
INSERT INTO `ket_potensi_sr` VALUES (28, 2023, 'Maskuning', 10, 1, 1, 'tlogosari', '2023-09-04 10:20:15', '0000-00-00 00:00:00');
INSERT INTO `ket_potensi_sr` VALUES (29, 2023, 'Kejayan', 5, 1, 1, 'tlogosari', '2023-09-04 10:20:24', '0000-00-00 00:00:00');
INSERT INTO `ket_potensi_sr` VALUES (30, 2023, 'Lombok', 10, 1, 1, 'tlogosari', '2023-09-04 10:20:34', '0000-00-00 00:00:00');
INSERT INTO `ket_potensi_sr` VALUES (31, 2023, 'Jebung', 5, 1, 1, 'tlogosari', '2023-09-04 10:20:44', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for merk
-- ----------------------------
DROP TABLE IF EXISTS `merk`;
CREATE TABLE `merk`  (
  `id_merk` int NOT NULL AUTO_INCREMENT,
  `nama_merk` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_merk`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of merk
-- ----------------------------
INSERT INTO `merk` VALUES (1, 'Honda');
INSERT INTO `merk` VALUES (2, 'Yamaha');
INSERT INTO `merk` VALUES (3, 'Suzuki');
INSERT INTO `merk` VALUES (4, 'Kawazaki');
INSERT INTO `merk` VALUES (5, 'Toyota');
INSERT INTO `merk` VALUES (7, 'Daihatsu');

-- ----------------------------
-- Table structure for nama_upk
-- ----------------------------
DROP TABLE IF EXISTS `nama_upk`;
CREATE TABLE `nama_upk`  (
  `id_upk` int NOT NULL AUTO_INCREMENT,
  `nama_upk` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_upk`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of nama_upk
-- ----------------------------
INSERT INTO `nama_upk` VALUES (1, 'Bondowoso');
INSERT INTO `nama_upk` VALUES (2, 'Sukosari 1');
INSERT INTO `nama_upk` VALUES (3, 'Maesan');
INSERT INTO `nama_upk` VALUES (4, 'Tegalampel');
INSERT INTO `nama_upk` VALUES (5, 'Tapen');
INSERT INTO `nama_upk` VALUES (6, 'Prajekan');
INSERT INTO `nama_upk` VALUES (7, 'Tlogosari');
INSERT INTO `nama_upk` VALUES (8, 'Wringin');
INSERT INTO `nama_upk` VALUES (9, 'Curahdami');
INSERT INTO `nama_upk` VALUES (10, 'Tamanan');
INSERT INTO `nama_upk` VALUES (11, 'Tenggarang');
INSERT INTO `nama_upk` VALUES (12, 'Tamankrocok');
INSERT INTO `nama_upk` VALUES (13, 'Wonosari');
INSERT INTO `nama_upk` VALUES (14, 'Klabang');
INSERT INTO `nama_upk` VALUES (15, 'Sukosari 2');

-- ----------------------------
-- Table structure for permasalahan
-- ----------------------------
DROP TABLE IF EXISTS `permasalahan`;
CREATE TABLE `permasalahan`  (
  `id_permasalahan` int NOT NULL AUTO_INCREMENT,
  `tahun_rkap` int NOT NULL,
  `sub_bagian` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `permasalahan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `penyebab` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tindak_lanjut` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL DEFAULT 1,
  `status_update` int NOT NULL DEFAULT 1,
  `bagian_upk` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_upload` timestamp NOT NULL DEFAULT current_timestamp,
  `tgl_update` datetime NOT NULL,
  PRIMARY KEY (`id_permasalahan`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permasalahan
-- ----------------------------
INSERT INTO `permasalahan` VALUES (1, 2023, 'Rekening', 'Untuk proses pembuatan rekening masih menggunakan program aplikasi lama', 'Belum terealisasinya program baru', 'Penyesuaian program baru', 1, 1, 'keuangan', '2023-08-31 14:29:53', '2023-08-31 15:18:32');
INSERT INTO `permasalahan` VALUES (2, 2023, 'Kas', 'Untuk loket BPD pencatatan penerimaan pelanggan diBPD sering tidak lolos/ada selisih', 'Pembayaran lewat ATM atau m-banking sering terjadi gagal bayar', 'Perlu duduk Bersama antara IT PDAM dengan IT BPD untuk mendapat solusi terbaik', 1, 1, 'keuangan', '2023-08-31 14:32:18', '0000-00-00 00:00:00');
INSERT INTO `permasalahan` VALUES (3, 2023, 'Pembukuan', 'Ketidak seimbangan pencatatan persediaan dengan data bagian IT', 'Belum terealisasinya program baru', 'Penyesuaian program baru', 1, 1, 'keuangan', '2023-08-31 14:34:02', '0000-00-00 00:00:00');
INSERT INTO `permasalahan` VALUES (4, 2023, 'Pembukuan', 'Belum ada buku pembantu akuntansi', 'Belum terealisasinya program baru', 'Penyesuaian program baru', 1, 1, 'keuangan', '2023-08-31 14:35:22', '0000-00-00 00:00:00');
INSERT INTO `permasalahan` VALUES (5, 2023, 'Pembukuan', 'Pekerjaan Aset, penyusutan dan RKAP masih dikerjakan secara manual.', 'Belum ada aplikasi untuk menghitung aset, penyusutan dan RKAP', 'Dibuatkan aplikasi untuk Aset, penyusutan dan RKAP', 1, 1, 'keuangan', '2023-08-31 14:37:02', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for potensi_sr
-- ----------------------------
DROP TABLE IF EXISTS `potensi_sr`;
CREATE TABLE `potensi_sr`  (
  `id_potensi_sr` int NOT NULL AUTO_INCREMENT,
  `tahun_rkap` int NOT NULL,
  `kap_pro` decimal(10, 2) NOT NULL,
  `kap_manf` decimal(10, 2) NOT NULL,
  `jam_op` decimal(10, 2) NOT NULL,
  `tk_bocor` decimal(10, 2) NOT NULL,
  `plg_aktif` int NOT NULL,
  `tambah_sr` int NOT NULL,
  `pola_kon` decimal(10, 2) NOT NULL,
  `status` int NOT NULL DEFAULT 1,
  `status_update` int NOT NULL DEFAULT 1,
  `bagian_upk` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_upload` timestamp NOT NULL DEFAULT current_timestamp,
  `tgl_update` datetime NOT NULL,
  PRIMARY KEY (`id_potensi_sr`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of potensi_sr
-- ----------------------------
INSERT INTO `potensi_sr` VALUES (1, 2023, 83.31, 83.31, 22.00, 35.00, 5662, 120, 14.00, 1, 1, 'bondowoso', '2023-08-25 07:37:36', '2023-08-28 10:34:32');
INSERT INTO `potensi_sr` VALUES (2, 2023, 12.00, 12.00, 23.00, 35.00, 1271, 15, 11.01, 1, 1, 'sukosari1', '2023-08-29 09:52:47', '0000-00-00 00:00:00');
INSERT INTO `potensi_sr` VALUES (3, 2023, 16.00, 14.40, 24.00, 35.00, 1271, 12, 12.73, 1, 1, 'maesan', '2023-08-29 10:12:14', '0000-00-00 00:00:00');
INSERT INTO `potensi_sr` VALUES (4, 2023, 15.70, 15.70, 24.00, 35.00, 1762, 15, 13.75, 1, 1, 'tegalampel', '2023-08-29 10:34:26', '2023-08-29 10:37:07');
INSERT INTO `potensi_sr` VALUES (5, 2023, 13.80, 12.42, 24.00, 35.00, 1138, 10, 12.05, 1, 1, 'tapen', '2023-08-29 11:01:11', '0000-00-00 00:00:00');
INSERT INTO `potensi_sr` VALUES (6, 2023, 12.80, 12.80, 24.00, 35.00, 1059, 10, 12.02, 1, 1, 'prajekan', '2023-08-31 12:38:20', '0000-00-00 00:00:00');
INSERT INTO `potensi_sr` VALUES (7, 2023, 15.50, 15.30, 20.00, 18.00, 896, 38, 7.36, 1, 1, 'tlogosari', '2023-09-04 10:19:07', '0000-00-00 00:00:00');
INSERT INTO `potensi_sr` VALUES (8, 2025, 13.00, 12.79, 24.00, 35.00, 1318, 40, 13.60, 1, 1, 'curahdami', '2025-08-06 09:07:19', '2025-08-06 15:21:47');

-- ----------------------------
-- Table structure for subag
-- ----------------------------
DROP TABLE IF EXISTS `subag`;
CREATE TABLE `subag`  (
  `id_subag` int NOT NULL AUTO_INCREMENT,
  `nama_subag` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_subag`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 38 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of subag
-- ----------------------------
INSERT INTO `subag` VALUES (1, 'Langganan');
INSERT INTO `subag` VALUES (2, 'Penagihan');
INSERT INTO `subag` VALUES (3, 'Umum');
INSERT INTO `subag` VALUES (4, 'Administrasi');
INSERT INTO `subag` VALUES (5, 'Personalia');
INSERT INTO `subag` VALUES (6, 'Keuangan');
INSERT INTO `subag` VALUES (7, 'Kas');
INSERT INTO `subag` VALUES (8, 'Pembukuan');
INSERT INTO `subag` VALUES (9, 'Rekening');
INSERT INTO `subag` VALUES (10, 'Pemeliharaan');
INSERT INTO `subag` VALUES (11, 'Peralatan');
INSERT INTO `subag` VALUES (12, 'Perencanaan');
INSERT INTO `subag` VALUES (13, 'Pengawasan');
INSERT INTO `subag` VALUES (14, 'S P I');
INSERT INTO `subag` VALUES (15, 'A M D K');
INSERT INTO `subag` VALUES (16, 'I T');
INSERT INTO `subag` VALUES (17, 'Sukosari 1');
INSERT INTO `subag` VALUES (18, 'Maesan');
INSERT INTO `subag` VALUES (19, 'Tegalampel');
INSERT INTO `subag` VALUES (20, 'Tapen');
INSERT INTO `subag` VALUES (21, 'Prajekan');
INSERT INTO `subag` VALUES (22, 'Tlogosari');
INSERT INTO `subag` VALUES (23, 'Wringin');
INSERT INTO `subag` VALUES (24, 'Curahdami');
INSERT INTO `subag` VALUES (25, 'Tamanan');
INSERT INTO `subag` VALUES (26, 'Tenggarang');
INSERT INTO `subag` VALUES (27, 'Tamankrocok');
INSERT INTO `subag` VALUES (28, 'Wonosari');
INSERT INTO `subag` VALUES (29, 'Klabang');
INSERT INTO `subag` VALUES (30, 'Sukosari 2');
INSERT INTO `subag` VALUES (31, 'Bondowoso');
INSERT INTO `subag` VALUES (32, 'Quality Control');
INSERT INTO `subag` VALUES (34, 'Pemasaran');
INSERT INTO `subag` VALUES (35, 'Produksi');

-- ----------------------------
-- Table structure for tambah_air_baku
-- ----------------------------
DROP TABLE IF EXISTS `tambah_air_baku`;
CREATE TABLE `tambah_air_baku`  (
  `id_tambah_air_baku` int NOT NULL AUTO_INCREMENT,
  `tahun_rkap` int NOT NULL,
  `uraian` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL DEFAULT 1,
  `status_update` int NOT NULL DEFAULT 1,
  `bagian_upk` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_upload` timestamp NOT NULL DEFAULT current_timestamp,
  `tgl_update` datetime NOT NULL,
  PRIMARY KEY (`id_tambah_air_baku`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tambah_air_baku
-- ----------------------------
INSERT INTO `tambah_air_baku` VALUES (1, 2023, '-', 1, 1, 'bondowoso', '2023-08-25 09:49:15', '0000-00-00 00:00:00');
INSERT INTO `tambah_air_baku` VALUES (2, 2023, '-', 1, 1, 'maesan', '2023-08-29 10:14:02', '0000-00-00 00:00:00');
INSERT INTO `tambah_air_baku` VALUES (3, 2023, 'Perlu di daerah atas  (locare)', 1, 1, 'tegalampel', '2023-08-29 10:38:40', '0000-00-00 00:00:00');
INSERT INTO `tambah_air_baku` VALUES (4, 2023, '-', 1, 1, 'tapen', '2023-08-29 11:02:24', '0000-00-00 00:00:00');
INSERT INTO `tambah_air_baku` VALUES (5, 2023, '-', 1, 1, 'prajekan', '2023-08-31 12:38:53', '0000-00-00 00:00:00');
INSERT INTO `tambah_air_baku` VALUES (6, 2023, '-', 1, 1, 'tlogosari', '2023-09-04 10:21:19', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for target_pencapaian
-- ----------------------------
DROP TABLE IF EXISTS `target_pencapaian`;
CREATE TABLE `target_pencapaian`  (
  `id_target` int NOT NULL AUTO_INCREMENT,
  `tahun_rkap` int NOT NULL,
  `uraian_target` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL DEFAULT 1,
  `status_update` int NOT NULL DEFAULT 1,
  `bagian_upk` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_upload` timestamp NOT NULL DEFAULT current_timestamp,
  `tgl_update` datetime NOT NULL,
  PRIMARY KEY (`id_target`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 36 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of target_pencapaian
-- ----------------------------
INSERT INTO `target_pencapaian` VALUES (1, 2023, 'Pendapatan tercapai dengan selisih over target Rp. 37.366.900', 1, 1, 'amdk', '2023-08-24 12:13:40', '0000-00-00 00:00:00');
INSERT INTO `target_pencapaian` VALUES (2, 2023, 'Ada pendapatan yg tidak sesuai target seperti penjualan Galon, Botol 500ml dan Botol 1500ml', 1, 1, 'amdk', '2023-08-24 12:14:01', '0000-00-00 00:00:00');
INSERT INTO `target_pencapaian` VALUES (3, 2023, 'Pendapatan tercapai karena RKAP tahun 2022 mengacu kepada kondisi Pandemi', 1, 1, 'amdk', '2023-08-24 12:14:21', '0000-00-00 00:00:00');
INSERT INTO `target_pencapaian` VALUES (4, 2023, 'Target pencapaian 2022 mempertimbangkan pajak yg harus di bayar sehingga realistis dan rasional', 1, 1, 'amdk', '2023-08-24 12:15:49', '0000-00-00 00:00:00');
INSERT INTO `target_pencapaian` VALUES (5, 2023, 'Seringnya pemadaman PLN secara tiba 2 sehingga mengakibatkan aliran air ke pelanggan terganggu', 1, 1, 'bondowoso', '2023-08-28 07:54:01', '2023-08-28 08:08:08');
INSERT INTO `target_pencapaian` VALUES (6, 2023, 'masih banyak pemakaian nol yang secara bertahap kami lakukan Penggantian', 1, 1, 'bondowoso', '2023-08-28 07:54:42', '0000-00-00 00:00:00');
INSERT INTO `target_pencapaian` VALUES (7, 2023, 'Masih adanya WM pelanggan yang  nilai ekonomisnya diatas 5 th', 1, 1, 'bondowoso', '2023-08-28 07:55:12', '0000-00-00 00:00:00');
INSERT INTO `target_pencapaian` VALUES (8, 2023, 'Menurunnya Debit SB pancoran yang sangat drastis sehingga pelayanan diwilayah tersebut tidak optimal', 1, 1, 'bondowoso', '2023-08-28 07:55:34', '0000-00-00 00:00:00');
INSERT INTO `target_pencapaian` VALUES (9, 2023, 'Minimnya minat masyarakat terhadap PDAM karena dianggap biaya pasang baru dan Tarif PDAM terlalu mahal', 1, 1, 'bondowoso', '2023-08-28 07:55:50', '0000-00-00 00:00:00');
INSERT INTO `target_pencapaian` VALUES (10, 2023, 'Beberapa perumahan yang sudah MOU dengan PDAM tidak semua terpasang', 1, 1, 'bondowoso', '2023-08-28 07:56:05', '0000-00-00 00:00:00');
INSERT INTO `target_pencapaian` VALUES (11, 2023, 'Banyaknya permintaan pelanggan aktif minta dicabut karena alasan tidak dipakai / menggunakan DAP / BOR', 1, 1, 'bondowoso', '2023-08-28 07:56:34', '0000-00-00 00:00:00');
INSERT INTO `target_pencapaian` VALUES (12, 2023, 'Pendapatan tercapai', 1, 1, 'sukosari1', '2023-08-29 09:56:10', '0000-00-00 00:00:00');
INSERT INTO `target_pencapaian` VALUES (13, 2023, 'Adanya penyediaan air pedesaan di luar PDAM.', 1, 1, 'maesan', '2023-08-29 10:16:57', '0000-00-00 00:00:00');
INSERT INTO `target_pencapaian` VALUES (14, 2023, 'Mudah mendapatkan alternatif air lain.', 1, 1, 'maesan', '2023-08-29 10:17:06', '0000-00-00 00:00:00');
INSERT INTO `target_pencapaian` VALUES (15, 2023, 'Banyak penduduk menggunakan sumur dangkal, maupun sumur berpompa.', 1, 1, 'maesan', '2023-08-29 10:17:16', '0000-00-00 00:00:00');
INSERT INTO `target_pencapaian` VALUES (16, 2023, 'Tersedianya sungai - sungai kecil untuk kebutuhan mencuci dan mandi.', 1, 1, 'maesan', '2023-08-29 10:17:27', '2023-08-29 10:19:20');
INSERT INTO `target_pencapaian` VALUES (17, 2023, 'Pdam jadi Alternatif ke 2 dikarenakan sebagian penduduk juga memiliki air pedesaan,sumur bor maupun sumur dangkal.', 1, 1, 'maesan', '2023-08-29 10:18:09', '0000-00-00 00:00:00');
INSERT INTO `target_pencapaian` VALUES (18, 2023, 'Lokasi calon pelanggan yang tidak memiliki akses jalur untuk dimasuki pipa PDAM karena melewati lahan orang lain.', 1, 1, 'maesan', '2023-08-29 10:18:32', '0000-00-00 00:00:00');
INSERT INTO `target_pencapaian` VALUES (19, 2023, 'Banyaknya pemakaian di bawah 10 m3', 1, 1, 'tegalampel', '2023-08-29 10:41:19', '0000-00-00 00:00:00');
INSERT INTO `target_pencapaian` VALUES (20, 2023, 'Pemadaman dari PLN tanpa pemberitahuan', 1, 1, 'tegalampel', '2023-08-29 10:41:29', '0000-00-00 00:00:00');
INSERT INTO `target_pencapaian` VALUES (21, 2023, 'Penurunan debit pompa karang anyar akibat longsor', 1, 1, 'tegalampel', '2023-08-29 10:41:45', '0000-00-00 00:00:00');
INSERT INTO `target_pencapaian` VALUES (22, 2023, 'Kualitas air kurang bagus di SB locare', 1, 1, 'tegalampel', '2023-08-29 10:41:54', '0000-00-00 00:00:00');
INSERT INTO `target_pencapaian` VALUES (23, 2023, 'Telatnya pembangunan di perumahan yang ada MOU dengan PDAM', 1, 1, 'tegalampel', '2023-08-29 10:42:08', '0000-00-00 00:00:00');
INSERT INTO `target_pencapaian` VALUES (24, 2023, 'Adanya pelanggan air bersih di luar PDAM', 1, 1, 'tapen', '2023-08-29 11:04:27', '0000-00-00 00:00:00');
INSERT INTO `target_pencapaian` VALUES (25, 2023, 'Pola konsumsi masyarakat rendah', 1, 1, 'tapen', '2023-08-29 11:04:35', '0000-00-00 00:00:00');
INSERT INTO `target_pencapaian` VALUES (26, 2023, 'Pelanggan Mempunyai alternatif lain (air pedesaan,sungai,mck)', 1, 1, 'tapen', '2023-08-29 11:04:43', '0000-00-00 00:00:00');
INSERT INTO `target_pencapaian` VALUES (27, 2023, 'Masyarakat mengerti yang di terapkan tarif dari PDAM,pelanggan dalan penggunaan air lebih hati hati', 1, 1, 'tapen', '2023-08-29 11:04:55', '0000-00-00 00:00:00');
INSERT INTO `target_pencapaian` VALUES (28, 2023, 'Pola konsumsi pelanggan rendah', 1, 1, 'prajekan', '2023-08-31 12:41:06', '0000-00-00 00:00:00');
INSERT INTO `target_pencapaian` VALUES (29, 2023, 'Banyak pelanggan yang mengebor perorangan', 1, 1, 'prajekan', '2023-08-31 12:41:21', '0000-00-00 00:00:00');
INSERT INTO `target_pencapaian` VALUES (30, 2023, 'Pelanggan mengerti harga tarif PDAM dan berhati-hati dalam penggunaan airnya', 1, 1, 'prajekan', '2023-08-31 12:41:31', '0000-00-00 00:00:00');
INSERT INTO `target_pencapaian` VALUES (31, 2023, 'Pelanggan banyak yang di tutup', 1, 1, 'prajekan', '2023-08-31 12:41:39', '0000-00-00 00:00:00');
INSERT INTO `target_pencapaian` VALUES (32, 2023, 'Adanya kebocoran', 1, 1, 'prajekan', '2023-08-31 12:41:50', '0000-00-00 00:00:00');
INSERT INTO `target_pencapaian` VALUES (33, 2023, 'Banyaknya sumur bor desa', 1, 1, 'tlogosari', '2023-09-04 10:23:32', '0000-00-00 00:00:00');
INSERT INTO `target_pencapaian` VALUES (34, 2023, 'Banyaknya permintaan SR di tutup', 1, 1, 'tlogosari', '2023-09-04 10:23:46', '0000-00-00 00:00:00');
INSERT INTO `target_pencapaian` VALUES (35, 2023, 'Banyaknya permintaan SR di cabut', 1, 1, 'tlogosari', '2023-09-04 10:23:56', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for type
-- ----------------------------
DROP TABLE IF EXISTS `type`;
CREATE TABLE `type`  (
  `id_type` int NOT NULL AUTO_INCREMENT,
  `nama_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_type`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of type
-- ----------------------------
INSERT INTO `type` VALUES (1, 'Revo X');
INSERT INTO `type` VALUES (2, 'Revo Fit');
INSERT INTO `type` VALUES (3, 'Win 100');
INSERT INTO `type` VALUES (4, ' Innova');
INSERT INTO `type` VALUES (5, 'Supra X');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_pengguna` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_lengkap` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `upk_bagian` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `level` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Pengguna',
  `tipe` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 50 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (2, 'administrator', 'Dicky Erfan Septiono', 'dicky', '$2y$10$MFzEk5qSvSQo1l8Ip4Psaelp4bi20s9Fwus8n3I0J5tien9xdao8G', 'Admin', 'admin', 1);
INSERT INTO `user` VALUES (18, 'admin', 'Muhammad Deni Saputro', 'admin', '$2y$10$rlcKUpdaS8gX9cYZO1OwveUlifZyAB8V3qStlq16chvl85RjqYOOm', 'Admin', 'admin', 1);
INSERT INTO `user` VALUES (23, 'Bondowoso', 'Rudy Himawan', 'bondowoso', '$2y$10$XQwrFff4P2w669f7nCyjMu/zNcWPPJlgE2XD6.ozSNR0eP/TWotxy', 'Pengguna', 'upk', 1);
INSERT INTO `user` VALUES (24, 'Sukosari 1', 'Saiful Bari', 'sukosari1', '$2y$10$UqUAYZrS24FLdhO3GFjo4u6AzISV2/4qaoHnSRxMWBupQt4xcpL4a', 'Pengguna', 'upk', 1);
INSERT INTO `user` VALUES (25, 'Maesan', 'Rahmat Febri Eko Tanyono', 'maesan', '$2y$10$jesmqR6FpWFGSaGATj8/K.F4wCNvhUpPZ10vWVFcmvKqJ4i5O3Eea', 'Pengguna', 'upk', 1);
INSERT INTO `user` VALUES (26, 'Tegalampel', 'Rudi Hasyim', 'tegalampel', '$2y$10$8dDL7TN0FeT5F0nFUPnQleXaQZIkYWmj82hYSr7oSoUAiw6JYD29O', 'Pengguna', 'upk', 1);
INSERT INTO `user` VALUES (27, 'Tapen', 'Siti Rosida', 'tapen', '$2y$10$pgc41ORODnDKCQk.ser0/uQZKvO6jqpyikxrDFEaxcKgBsn2BR0RW', 'Pengguna', 'upk', 1);
INSERT INTO `user` VALUES (28, 'Prajekan', 'Wiwik', 'prajekan', '$2y$10$ueiSaPLIUgq3UcxiEyCcTeeXDiBV/GOLRXOsktSPuqWSqzWmwxbaW', 'Pengguna', 'upk', 1);
INSERT INTO `user` VALUES (29, 'Tlogosari', 'M Arief Teguh Andiyanto', 'tlogosari', '$2y$10$PhDX9i8aU9HCeH8TuncHBudjG4yul3ctHrSuSEoCTV6Na9D7gEOAC', 'Pengguna', 'upk', 1);
INSERT INTO `user` VALUES (30, 'Wringin', 'Didik Ahmad Rafidi', 'wringin', '$2y$10$SHFo5nN.EHesAXTzRaCZkOgv3NU2Qjct/OVAT/V7HFBeRvDizW5.K', 'Pengguna', 'upk', 1);
INSERT INTO `user` VALUES (31, 'Curahdami', 'Hidayatullah Firdaus', 'curahdami', '$2y$10$RsDxvq/Wqq68B2PBNxuO3eGaSsY3qkq6pBFmYYic5Q0KbDEMuofW2', 'Pengguna', 'upk', 1);
INSERT INTO `user` VALUES (32, 'Tamanan', 'Achmad Novi Patria Budiman', 'tamanan', '$2y$10$pOmUNj2J2GEk0.8npQmAn.LIcpTurhvzI8m7JF6sZK3Gll5.ZqT4S', 'Pengguna', 'upk', 1);
INSERT INTO `user` VALUES (33, 'Tenggarang', 'Supangkat Harianto', 'tenggarang', '$2y$10$KjTDzTDOaAGsFc55RMR.O.7Eub3YXurpvne7YJq2EnOcs3eG2IPxS', 'Pengguna', 'upk', 1);
INSERT INTO `user` VALUES (34, 'Tamankrocok', 'Sayudi Pranayuda', 'tamankrocok', '$2y$10$V33ks.QwR/z9fuNg3h/UU.yuOZFaP7uyTEAws71MNfsZrV1qLyh4i', 'Pengguna', 'upk', 1);
INSERT INTO `user` VALUES (35, 'Wonosari', 'Arsono Agus Prayudi', 'wonosari', '$2y$10$SICEtYV6NglGO7jISt5MZOca.8QK98e33DbmVtkAtjLLU5My4kqLa', 'Pengguna', 'upk', 1);
INSERT INTO `user` VALUES (36, 'Klabang', 'Siti Rosida', 'klabang', '$2y$10$DOKORMnUPfEuSNZ/E/EVreFy1ykcO.fyBIAv7oH.GqowR3TJ5obTO', 'Pengguna', 'upk', 1);
INSERT INTO `user` VALUES (37, 'Sukosari 2', 'Sanur', 'sukosari2', '$2y$10$FVDBwkH4zWlzS.8InGBw6.Yww5YBxN7vUKsmeUlE/wVMeYZ5mjXti', 'Pengguna', 'upk', 1);
INSERT INTO `user` VALUES (39, 'Keuangan', 'Dicky Erfan Septiono', 'keuangan', '$2y$10$rHSYjOji53377qpHipJlle5DuLjDGtLoCAfmGNnlONy5rCHKGGUpW', 'Pengguna', 'bagian', 1);
INSERT INTO `user` VALUES (40, 'Langganan', 'Adityas Arief Witjaksono', 'langganan', '$2y$10$CEn97kpa8rvcSsEs.q4v5..NJtnf4i6IB1aPZQMTuM9.mE6nrHgQK', 'Pengguna', 'bagian', 1);
INSERT INTO `user` VALUES (41, 'Perencanaan', 'Mohammad Yunus Anis', 'perencanaan', '$2y$10$hEaaEEv2VO3KcHQSFfYrTe7FVEt6PT3.BNErVP44ccdSDe59lZ1hS', 'Pengguna', 'bagian', 1);
INSERT INTO `user` VALUES (42, 'Pemeliharaan', 'Mohammad Rois', 'pemeliharaan', '$2y$10$49eYYpFCXBJ9t3tImvWSaedyRq.qDDf1xbrDJIgo3AiKOQUTTXt5O', 'Pengguna', 'bagian', 1);
INSERT INTO `user` VALUES (43, 'A M D K', 'Edi Suhartono', 'amdk', '$2y$10$tJfzk8mZkOUXK4djNMngEO/SisAgXY8wIHiKfoWftbHublfO56zMi', 'Pengguna', 'upk', 1);
INSERT INTO `user` VALUES (45, 'Umum & Administrasi', 'Suwarna', 'umum', '$2y$10$9/dv6C68molDgSDeLcRxt.d7DyhC4dL7rz/A2Hlx1gHj27URRW8K2', 'Pengguna', 'bagian', 1);
INSERT INTO `user` VALUES (46, 'Satuan Pengawas Intern', 'I Made Suarjaya', 'spi', '$2y$10$IZeYvltl7zYljAtmAsKgtexmh9A2DKQ0ORwN0BRJIY4E8ZtD//TYC', 'Pengguna', 'bagian', 1);
INSERT INTO `user` VALUES (47, 'barang', 'Yuliatin Jumariyah', 'barang', '$2y$10$iQP/g0Q2HFzRdu.bXo1wtOxtG9bC/xsQWPYbHakiBK/ujgIovh48S', 'Pengguna', 'korektor', 1);
INSERT INTO `user` VALUES (48, 'rencana', 'Mohammad Yunus Anis', 'rencana', '$2y$10$c5DyDRPOszREtfBzxm0AbeTp/F5yN4O2ePDNbmUZDEK2KN/fb1Lli', 'Pengguna', 'korektor', 1);
INSERT INTO `user` VALUES (49, 'pelihara', 'Mohammad Rois', 'pelihara', '$2y$10$YoEXtxc5SudkwFbpqyuvJ.UD3d45yF9okaF2ZI.DhAt/q9HfBKGHy', 'Pengguna', 'korektor', 1);

-- ----------------------------
-- Table structure for usulan_admin
-- ----------------------------
DROP TABLE IF EXISTS `usulan_admin`;
CREATE TABLE `usulan_admin`  (
  `id_usulanAdmin` int NOT NULL AUTO_INCREMENT,
  `tahun_rkap` int NOT NULL,
  `usulan_admin` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL DEFAULT 1,
  `status_update` int NOT NULL DEFAULT 1,
  `bagian_upk` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_upload` timestamp NOT NULL DEFAULT current_timestamp,
  `tgl_update` datetime NOT NULL,
  PRIMARY KEY (`id_usulanAdmin`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of usulan_admin
-- ----------------------------
INSERT INTO `usulan_admin` VALUES (1, 2023, 'Merealisasikan team sales dan marketing sesuai usulan dari Pak Rudi Harnalis ( sesuai surat usulan yg sudah disetujui oleh manajemen bulan maret 2022', 1, 1, 'amdk', '2023-08-24 12:16:52', '0000-00-00 00:00:00');
INSERT INTO `usulan_admin` VALUES (2, 2023, 'Memperluas jaringan pemasaran dengan memaksimalkan SE Bupati untuk di sosialisasikan ke sekolah', 1, 1, 'amdk', '2023-08-24 12:17:16', '0000-00-00 00:00:00');
INSERT INTO `usulan_admin` VALUES (3, 2023, 'Merealisasikan MOU dengan pihak Nurul Jadid dengan pertimbangan aspek bisnis sehingga win-win solusi', 1, 1, 'amdk', '2023-08-24 12:17:36', '0000-00-00 00:00:00');
INSERT INTO `usulan_admin` VALUES (4, 2023, 'Menindak lanjuti penagihan piutang CV Diel, CV Cemara perkasa ( An Nujum ) Mitra Makmur', 1, 1, 'amdk', '2023-08-24 12:17:56', '0000-00-00 00:00:00');
INSERT INTO `usulan_admin` VALUES (5, 2023, 'Memisahkan piutang dari tahun 2015 sampai dengan awal  2019 sehingga mempermudah mendata piutang lancar', 1, 1, 'amdk', '2023-08-24 12:18:31', '0000-00-00 00:00:00');
INSERT INTO `usulan_admin` VALUES (6, 2023, 'Segera bisa men-tryal aplikasi untuk Unit AMDK dalam rangka keamanan dan tertib administrasi', 1, 1, 'amdk', '2023-08-24 12:18:50', '0000-00-00 00:00:00');
INSERT INTO `usulan_admin` VALUES (7, 2023, 'Berharap IT bisa memfasilitasi data piutang sesuai dengan variannya sebagai data laporan bulanan dan  data penagihan termasuk pembuatan data RKAP', 1, 1, 'amdk', '2023-08-24 12:19:28', '0000-00-00 00:00:00');
INSERT INTO `usulan_admin` VALUES (8, 2023, 'Sosialisasi pemasangan SR baru di perumahan2', 1, 1, 'bondowoso', '2023-08-28 08:02:31', '0000-00-00 00:00:00');
INSERT INTO `usulan_admin` VALUES (9, 2023, 'Melakukan penagihan dari rumah ke rumah sampai target penagihan tercapai', 1, 1, 'bondowoso', '2023-08-28 08:02:53', '0000-00-00 00:00:00');
INSERT INTO `usulan_admin` VALUES (10, 2023, 'Melakukan discount pemasangan SR Baru', 1, 1, 'bondowoso', '2023-08-28 08:03:15', '0000-00-00 00:00:00');
INSERT INTO `usulan_admin` VALUES (11, 2023, 'Penggantian Jenis Pelanggan', 1, 1, 'sukosari1', '2023-08-29 09:57:30', '0000-00-00 00:00:00');
INSERT INTO `usulan_admin` VALUES (12, 2023, '-', 1, 1, 'maesan', '2023-08-29 10:19:06', '0000-00-00 00:00:00');
INSERT INTO `usulan_admin` VALUES (13, 2023, 'Lebih inten melakukan promosi pemasangan SR Baru', 1, 1, 'tegalampel', '2023-08-29 10:43:09', '0000-00-00 00:00:00');
INSERT INTO `usulan_admin` VALUES (14, 2023, 'lebih Intens melakukan penagihan dari rumah ke rumah', 1, 1, 'tegalampel', '2023-08-29 10:43:21', '0000-00-00 00:00:00');
INSERT INTO `usulan_admin` VALUES (15, 2023, 'Melakukan penertiban sr(menutup dan mencabut) tunggakan rekening', 1, 1, 'tegalampel', '2023-08-29 10:43:29', '0000-00-00 00:00:00');
INSERT INTO `usulan_admin` VALUES (16, 2023, 'Meningkatkan Efisiensi Penagihan', 1, 1, 'tapen', '2023-08-29 11:05:44', '0000-00-00 00:00:00');
INSERT INTO `usulan_admin` VALUES (17, 2023, 'Meningkatkan efesiensi penagihan', 1, 1, 'prajekan', '2023-08-31 12:42:36', '0000-00-00 00:00:00');
INSERT INTO `usulan_admin` VALUES (18, 2023, 'Pelatihan peningkatan SDM', 1, 1, 'prajekan', '2023-08-31 12:42:43', '0000-00-00 00:00:00');
INSERT INTO `usulan_admin` VALUES (19, 2023, 'Pemutakhiran data jenis pelanggan', 1, 1, 'tlogosari', '2023-09-04 10:24:37', '0000-00-00 00:00:00');
INSERT INTO `usulan_admin` VALUES (20, 2023, 'Pelatihan peningkatan SDM', 1, 1, 'tlogosari', '2023-09-04 10:24:49', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for usulan_barang
-- ----------------------------
DROP TABLE IF EXISTS `usulan_barang`;
CREATE TABLE `usulan_barang`  (
  `id_usulanBarang` int NOT NULL AUTO_INCREMENT,
  `tahun_rkap` int NOT NULL,
  `no_perkiraan` int NOT NULL,
  `nama_perkiraan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `latar_belakang` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `solusi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `volume` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `satuan` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `biaya` int NOT NULL,
  `ket` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL DEFAULT 1,
  `status_update` int NOT NULL DEFAULT 1,
  `bagian_upk` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `foto_ket` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_upload` timestamp NOT NULL DEFAULT current_timestamp,
  `tgl_update` datetime NOT NULL,
  PRIMARY KEY (`id_usulanBarang`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 94 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of usulan_barang
-- ----------------------------
INSERT INTO `usulan_barang` VALUES (1, 2023, 0, 'Aquades', 'Dalam rangka memenuhi kebutuhan akurasi hasil lab dan menjaga standar kualitas produk', 'Pengadaan / pembelian dari kebutuhan tsb', '1', 'Buah', 150000, 'Perlengkapan Lab', 1, 1, 'amdk', 'Alfian.pdf', '2023-08-24 13:39:44', '2023-09-01 10:07:15');
INSERT INTO `usulan_barang` VALUES (2, 2023, 0, 'Mq Meter', 'Dalam rangka memenuhi kebutuhan akurasi hasil lab dan menjaga standar kualitas produk', 'Pengadaan / pembelian dari kebutuhan tsb', '1', 'Buah', 0, 'Perlengkapan Lab', 1, 1, 'amdk', '', '2023-08-28 13:08:50', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (3, 2023, 0, 'Petri Film', 'Dalam rangka memenuhi kebutuhan akurasi hasil lab dan menjaga standar kualitas produk', 'Pengadaan / pembelian dari kebutuhan tsb', '1', 'Buah', 0, 'Perlengkapan Lab', 1, 1, 'amdk', '', '2023-08-28 13:14:55', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (4, 2023, 0, 'Ozon Reagen', 'Dalam rangka memenuhi kebutuhan akurasi hasil lab dan menjaga standar kualitas produk', 'Pengadaan / pembelian dari kebutuhan tsb', '1', 'buah', 0, 'Perlengkapan Lab', 1, 1, 'amdk', '', '2023-08-28 13:21:27', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (5, 2023, 0, 'Tissue Lab', 'Dalam rangka memenuhi kebutuhan akurasi hasil lab dan menjaga standar kualitas produk', 'Pengadaan / pembelian dari kebutuhan tsb', '1', 'buah', 0, 'Perlengkapan Lab', 1, 1, 'amdk', '', '2023-08-28 13:21:27', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (6, 2023, 0, 'Alkohol 90% ', 'Dalam rangka memenuhi kebutuhan akurasi hasil lab dan menjaga standar kualitas produk', 'Pengadaan / pembelian dari kebutuhan tsb', '2', 'botol', 0, 'Perlengkapan Lab', 1, 1, 'amdk', '', '2023-08-28 13:21:27', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (7, 2023, 0, 'Pipet plastik', 'Dalam rangka memenuhi kebutuhan akurasi hasil lab dan menjaga standar kualitas produk', 'Pengadaan / pembelian dari kebutuhan tsb', '1', 'Buah', 0, 'Perlengkapan Lab', 1, 1, 'amdk', '', '2023-08-28 13:25:04', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (8, 2023, 0, 'Spirtus', 'Dalam rangka memenuhi kebutuhan akurasi hasil lab dan menjaga standar kualitas produk', 'Pengadaan / pembelian dari kebutuhan tsb', '2', 'Botol', 0, 'Perlengkapan Lab', 1, 1, 'amdk', '', '2023-08-28 13:25:55', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (9, 2023, 0, 'Baju Kerja', 'Kebutuhan rutin dari proses produki baik produksi galon maupun gelas 220ml', 'Pengadaan / pembelian dari kebutuhan tsb', '6', 'Buah', 0, 'Perlengkapan Lain2', 1, 1, 'amdk', '', '2023-08-28 13:27:29', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (10, 2023, 0, 'Kanibo', 'Kebutuhan rutin dari proses produki baik produksi galon maupun gelas 220ml', 'Pengadaan / pembelian dari kebutuhan tsb', '6', 'Buah', 0, 'Perlengkapan Lain2', 1, 1, 'amdk', '', '2023-08-28 13:28:25', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (11, 2023, 0, 'sandal Slop', 'Kebutuhan rutin dari proses produki baik produksi galon maupun gelas 220ml', 'Pengadaan / pembelian dari kebutuhan tsb', '6', 'Pasan', 0, 'Perlengkapan Lain2', 1, 1, 'amdk', '', '2023-08-28 13:29:01', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (12, 2023, 0, 'Sepatu Boot', 'Kebutuhan rutin dari proses produki baik produksi galon maupun gelas 220ml', 'Pengadaan / pembelian dari kebutuhan tsb', '4', 'Pasan', 0, 'Perlengkapan Lain2', 1, 1, 'amdk', '', '2023-08-28 13:29:47', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (13, 2023, 0, 'Tisu', 'Kebutuhan rutin dari proses produki baik produksi galon maupun gelas 220ml', 'Pengadaan / pembelian dari kebutuhan tsb', '12', 'Box', 0, 'Perlengkapan Lain2', 1, 1, 'amdk', '', '2023-08-28 13:30:30', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (14, 2023, 0, 'Sabun Cair', 'Kebutuhan rutin dari proses produki baik produksi galon maupun gelas 220ml', 'Pengadaan / pembelian dari kebutuhan tsb', '6', 'Box', 0, 'Perlengkapan Lain2', 1, 1, 'amdk', '', '2023-08-28 13:31:23', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (15, 2023, 0, 'Masker', 'Kebutuhan rutin dari proses produki baik produksi galon maupun gelas 220ml', 'Pengadaan / pembelian dari kebutuhan tsb', '2', 'Lusin', 0, 'Perlengkapan Lain2', 1, 1, 'amdk', '', '2023-08-28 13:32:02', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (16, 2023, 0, 'Tutup Kepala', 'Kebutuhan rutin dari proses produki baik produksi galon maupun gelas 220ml', 'Pengadaan / pembelian dari kebutuhan tsb', '2', 'Box', 0, 'Perlengkapan Lain2', 1, 1, 'amdk', '', '2023-08-28 13:32:38', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (17, 2023, 0, 'Sarung tangan', 'Kebutuhan rutin dari proses produki baik produksi galon maupun gelas 220ml', 'Pengadaan / pembelian dari kebutuhan tsb', '2', 'Box', 0, 'Perlengkapan Lain2', 1, 1, 'amdk', '', '2023-08-28 13:33:27', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (18, 2023, 0, 'Alkohol 90%', 'Kebutuhan rutin dari proses produki baik produksi galon maupun gelas 220ml', 'Pengadaan / pembelian dari kebutuhan tsb', '2', 'Botol', 0, 'Perlengkapan Lain2', 1, 1, 'amdk', '', '2023-08-28 13:34:14', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (19, 2023, 0, 'Slang bening mesin 8 line', 'Kebutuhan rutin dari proses produki baik produksi galon maupun gelas 220ml', 'Pengadaan / pembelian dari kebutuhan tsb', '4', 'Meter', 0, 'Perlengkapan Lain2', 1, 1, 'amdk', '', '2023-08-28 13:34:53', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (20, 2023, 0, 'AC Ruang Administrasi', 'Dengan ruangan yg sempit,juga banyak barang elektronik, dan full kaca membuat suhu ruangan sangat panas', 'Pengadaan / pembelian dari kebutuhan tsb', '1', 'Unit', 0, '', 1, 1, 'amdk', '', '2023-08-28 13:35:59', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (21, 2023, 0, 'Lampu UV 10 W', 'Kebutuhan rutin dari proses produki baik produksi galon maupun gelas 220ml', 'Pengadaan / pembelian dari kebutuhan tsb', '1', 'Unit', 0, 'Ruang Galon', 1, 1, 'amdk', '', '2023-08-28 13:37:29', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (22, 2023, 0, 'Lampu led 10 W', 'Kebutuhan rutin dari proses produki baik produksi galon maupun gelas 220ml', 'Pengadaan / pembelian dari kebutuhan tsb', '2', 'Buah', 0, 'Ruang Galon', 1, 1, 'amdk', '', '2023-08-28 13:38:21', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (23, 2023, 0, 'Container besar', 'Kebutuhan rutin dari proses produki baik produksi galon maupun gelas 220ml', 'Pengadaan / pembelian dari kebutuhan tsb', '1', 'Buah', 0, 'Ruang Galon', 1, 1, 'amdk', '', '2023-08-28 13:38:53', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (24, 2023, 0, 'Lampu UV 10W', 'Kebutuhan rutin dari proses produki baik produksi galon maupun gelas 220ml', 'Pengadaan / pembelian dari kebutuhan tsb', '1', 'Unit', 0, 'Ruang Gelas', 1, 1, 'amdk', '', '2023-08-28 13:39:53', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (25, 2023, 0, 'Heater / Pemanas', 'Kebutuhan rutin dari proses produki baik produksi galon maupun gelas 220ml', 'Pengadaan / pembelian dari kebutuhan tsb', '10', 'Buah', 0, 'Ruang Gelas', 1, 1, 'amdk', '', '2023-08-28 13:40:57', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (26, 2023, 0, 'Selenoid/ Limit swit', 'Kebutuhan rutin dari proses produki baik produksi galon maupun gelas 220ml', 'Pengadaan / pembelian dari kebutuhan tsb', '1', 'Unit', 0, 'Ruang Gelas', 1, 1, 'amdk', '', '2023-08-28 13:41:52', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (27, 2023, 0, 'Oli Power', 'Kebutuhan rutin dari proses produki baik produksi galon maupun gelas 220ml', 'Pengadaan / pembelian dari kebutuhan tsb', '4', 'Botol', 0, 'Ruang Gelas', 1, 1, 'amdk', '', '2023-08-28 13:42:35', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (28, 2023, 0, 'Oli Gear', 'Kebutuhan rutin dari proses produki baik produksi galon maupun gelas 220ml', 'Pengadaan / pembelian dari kebutuhan tsb', '3', 'Botol', 0, 'Ruang Gelas', 1, 1, 'amdk', '', '2023-08-28 13:43:24', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (29, 2023, 0, 'Minyak Rem', 'Kebutuhan rutin dari proses produki baik produksi galon maupun gelas 220ml', 'Pengadaan / pembelian dari kebutuhan tsb', '3', 'Botol', 0, 'Ruang Gelas', 1, 1, 'amdk', '', '2023-08-28 13:44:10', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (30, 2023, 0, 'Stemplet', 'Kebutuhan rutin dari proses produki baik produksi galon maupun gelas 220ml', 'Pengadaan / pembelian dari kebutuhan tsb', '2', 'Box', 0, 'Ruang Gelas', 1, 1, 'amdk', '', '2023-08-28 13:44:59', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (31, 2023, 0, 'Pnuomatik', 'Kebutuhan rutin dari proses produki baik produksi galon maupun gelas 220ml', 'Pengadaan / pembelian dari kebutuhan tsb', '1', 'Unit', 0, 'Ruang Gelas', 1, 1, 'amdk', '', '2023-08-28 13:45:34', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (32, 2023, 0, 'Karbon filter', 'Untuk menjaga kualitas produk yang di hasilkan dan kebutuhan rutin dari proses pengolahan air baku', 'Pengadaan / pembelian dari kebutuhan tsb', '200', 'Kg', 0, 'Ruang WT ( Water Treatment )', 1, 1, 'amdk', '', '2023-08-28 13:46:56', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (33, 2023, 0, 'Catrige filter  0,1', 'Untuk menjaga kualitas produk yang di hasilkan dan kebutuhan rutin dari proses pengolahan air baku', 'Pengadaan / pembelian dari kebutuhan tsb', '10', 'Buah', 0, 'Ruang WT ( Water Treatment )', 1, 1, 'amdk', '', '2023-08-28 13:47:52', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (34, 2023, 0, 'Catrige filter  0,3', 'Untuk menjaga kualitas produk yang di hasilkan dan kebutuhan rutin dari proses pengolahan air baku', 'Pengadaan / pembelian dari kebutuhan tsb', '10', 'Buah', 0, 'Ruang WT ( Water Treatment )', 1, 1, 'amdk', '', '2023-08-28 13:48:27', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (35, 2023, 0, 'Catrige filter  0,5', 'Untuk menjaga kualitas produk yang di hasilkan dan kebutuhan rutin dari proses pengolahan air baku', 'Pengadaan / pembelian dari kebutuhan tsb', '10', 'Buah', 0, 'Ruang WT ( Water Treatment )', 1, 1, 'amdk', '', '2023-08-28 13:48:59', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (36, 2023, 0, 'Kertas HVS', 'Operasional', 'Pengadaan', '15', 'Rim', 48000, 'ATK', 1, 1, 'bondowoso', '', '2023-08-28 14:23:57', '2023-09-05 08:16:39');
INSERT INTO `usulan_barang` VALUES (37, 2023, 0, 'Kertas Rekening Air', 'Operasional', 'Pengadaan', '7', 'Box', 0, 'ATK', 1, 1, 'bondowoso', '', '2023-08-28 14:25:07', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (38, 2023, 0, 'Kertas penagihan', 'Operasional', 'Pengadaan', '7', 'Box', 0, 'ATK', 1, 1, 'bondowoso', '', '2023-08-28 14:25:35', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (39, 2023, 0, 'Buku Folio', 'Operasional', 'Pengadaan', '5', 'Buah', 0, 'ATK', 1, 1, 'bondowoso', '', '2023-08-28 14:26:01', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (40, 2023, 0, 'Buku Quarto', 'Operasional', 'Pengadaan', '2', 'Buah', 0, 'ATK', 1, 1, 'bondowoso', '', '2023-08-28 14:26:45', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (41, 2023, 0, 'Buku Ekspedisi', 'Operasional', 'Pengadaan', '1', 'Buah', 0, 'ATK', 1, 1, 'bondowoso', '', '2023-08-28 14:27:12', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (42, 2023, 0, 'Pita + cartridge', 'Operasional', 'Pengadaan', '9', 'Buah', 0, 'ATK', 1, 1, 'bondowoso', '', '2023-08-28 14:27:47', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (43, 2023, 0, 'Thermal printer', 'Operasional', 'Pengadaan', '1', 'Buah', 0, 'ATK', 1, 1, 'bondowoso', '', '2023-08-28 14:28:22', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (44, 2023, 0, 'Thermal printer', 'Operasional', 'Pengadaan', '1', 'Buah', 0, 'ATK', 1, 1, 'bondowoso', '', '2023-08-28 14:28:22', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (45, 2023, 0, 'Jam Dinding', 'Yang Lama Rusak', 'Pengadaan', '1', 'Unit', 0, 'Inventaris', 1, 1, 'bondowoso', '', '2023-08-28 14:29:15', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (46, 2023, 0, 'Sepeda Motor', 'Operasional', 'Pengadaan', '2', 'Unit', 0, 'Inventaris', 1, 1, 'bondowoso', '', '2023-08-28 14:29:44', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (47, 2023, 0, 'AC 0,5 PK', 'Operasional', 'Pengadaan', '1', 'Unit', 0, 'Inventaris', 1, 1, 'bondowoso', '', '2023-08-28 14:30:21', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (48, 2023, 0, 'Petekol', 'Yang lama aus', 'Pengadaan', '2', 'Buah', 0, 'Peralatan Teknik', 1, 1, 'bondowoso', '', '2023-08-28 14:31:38', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (49, 2023, 0, 'Kunci Inggris', 'Yang lama aus', 'Pengadaan', '2', 'Buah', 0, 'Peralatan Teknik', 1, 1, 'bondowoso', '', '2023-08-28 14:32:18', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (50, 2023, 0, 'Cangkul', 'Yang lama aus', 'Pengadaan', '2', 'Meter', 0, 'Peralatan Teknik', 1, 1, 'bondowoso', '', '2023-08-28 14:32:45', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (51, 2023, 0, 'Gancu', 'Yang lama aus', 'Pengadaan', '2', 'Buah', 0, 'Peralatan Teknik', 1, 1, 'bondowoso', '', '2023-08-28 14:33:20', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (52, 2023, 0, 'Gergaji Besi', 'Yang lama aus', 'Pengadaan', '2', 'Buah', 0, 'Peralatan Teknik', 1, 1, 'bondowoso', '', '2023-08-28 14:33:53', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (53, 2023, 0, 'Gergaji Kayu', 'Yang lama aus', 'Pengadaan', '1', 'Buah', 0, 'Peralatan Teknik', 1, 1, 'bondowoso', '', '2023-08-28 14:34:23', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (54, 2023, 0, 'Mesin sedot Dia. 3 inch', 'Yang lama aus', 'Pengadaan', '1', 'Buah', 0, 'Peralatan Teknik', 1, 1, 'bondowoso', '', '2023-08-28 14:35:16', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (55, 2023, 0, 'Sepatu Booth', 'Yang lama rusak', 'Pengadaan', '5', 'Pasang', 0, 'Peralatan Teknik', 1, 1, 'bondowoso', '', '2023-08-28 14:35:57', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (56, 2023, 0, 'Meteran Rol', 'Belum Punya', 'Pengadaan', '1', 'Buah', 0, 'Peralatan Teknik', 1, 1, 'bondowoso', '', '2023-08-28 14:36:49', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (57, 2023, 0, 'Meja Kursi Tamu', 'Kurang nyaman melayani tamu atau pelanggan', 'Pengadaan meja kursi tamu', '1', 'Set', 0, '', 1, 1, 'sukosari1', '', '2023-08-29 10:02:31', '2023-08-29 10:05:46');
INSERT INTO `usulan_barang` VALUES (58, 2023, 0, 'Mesin Sedot Air', 'Saat perbaikan banyak material berupa pasir dan kerikil serta air yang keruh masuk kedalam pipa sehingga menyebabkan pipa tersumbat yang pelanggan aliran air terganggu dan pendapatan menurun', 'Pengadaan mesin sedot air diameter 40 mm', '1', 'Buah', 0, '', 1, 1, 'sukosari1', '', '2023-08-29 10:06:48', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (59, 2023, 0, 'Logam Detector', 'Banyak valve di UPK Sukosari hilang sehingga menyebabkan aliran tidak bisa diatur secara optimal', 'Pengadaan Logam Detector', '1', 'Buah', 0, '', 1, 1, 'sukosari1', '', '2023-08-29 10:07:55', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (60, 2023, 0, 'Kertas HVS', 'Operasional', 'Pengadaan', '24', 'Buah', 0, 'Administrasi', 1, 1, 'tegalampel', '', '2023-08-29 10:53:16', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (61, 2023, 0, 'Kertas Rekening Air', 'Operasional', 'Pengadaan', '6', 'Box', 0, 'Administrasi', 1, 1, 'tegalampel', '', '2023-08-29 10:53:56', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (62, 2023, 0, 'Buku Folio', 'Operasional', 'Pengadaan', '8', 'Buah', 0, 'Administrasi', 1, 1, 'tegalampel', '', '2023-08-29 10:54:34', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (63, 2023, 0, 'Pita Cartridge', 'Operasional', 'Pengadaan', '2', 'Buah', 0, 'Administrasi', 1, 1, 'tegalampel', '', '2023-08-29 10:55:14', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (64, 2023, 0, 'Buku Kwarto', 'Operasional', 'Pengadaan', '2', 'Buah', 0, 'Administrasi', 1, 1, 'tegalampel', '', '2023-08-29 10:55:43', '2023-08-29 10:55:49');
INSERT INTO `usulan_barang` VALUES (65, 2023, 0, 'Kerta Termal Printer', 'Operasional', 'Pengadaan', '2', 'Box', 0, 'Administrasi', 1, 1, 'tegalampel', '', '2023-08-29 10:56:13', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (66, 2023, 0, 'Laptop Ka UPK', 'Operasional', 'Pengadaan', '1', 'Unit', 0, 'Administrasi', 1, 1, 'tegalampel', '', '2023-08-29 10:56:43', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (67, 2023, 0, 'Tas Teknik', 'Operasional', 'Pengadaan', '1', 'Buah', 0, 'Teknik', 1, 1, 'tegalampel', '', '2023-08-29 10:57:23', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (68, 2023, 0, 'Kunci Inggris', 'Operasional', 'Pengadaan', '1', 'Buah', 0, 'Teknik', 1, 1, 'tegalampel', '', '2023-08-29 10:57:43', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (69, 2023, 0, 'Petekol', 'Operasional', 'Pengadaan', '1', 'Buah', 0, 'Teknik', 1, 1, 'tegalampel', '', '2023-08-29 10:58:06', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (70, 2023, 0, 'Tang Segel', 'Operasional', 'Pengadaan', '1', 'Buah', 0, 'Teknik', 1, 1, 'tegalampel', '', '2023-08-29 10:58:30', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (71, 2023, 0, 'Gergaji Besi', 'Operasional', 'Pengadaan', '1', 'Buah', 0, 'Teknik', 1, 1, 'tegalampel', '', '2023-08-29 10:58:54', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (72, 2023, 0, 'Kapak/parang', 'Operasional', 'Pengadaan', '1', 'Buah', 0, 'Teknik', 1, 1, 'tegalampel', '', '2023-08-29 10:59:16', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (73, 2023, 0, 'Kunci Inggris', 'Operasional', 'Pengadaan', '1', 'Buah', 0, 'Peralatan Kerja Teknik', 1, 1, 'tapen', '', '2023-08-29 11:09:10', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (74, 2023, 0, 'Petekol', 'Operasional', 'Pengadaan', '1', 'Buah', 0, 'Peralatan Kerja Teknik', 1, 1, 'tapen', '', '2023-08-29 11:09:27', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (75, 2023, 0, 'Cangkul', 'Operasional', 'Pengadaan', '1', 'Buah', 0, 'Peralatan Kerja Teknik', 1, 1, 'tapen', '', '2023-08-29 11:09:47', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (76, 2023, 0, 'Gancu', 'Operasional', 'Pengadaan', '1', 'Buah', 0, 'Peralatan Kerja Teknik', 1, 1, 'tapen', '', '2023-08-29 11:10:10', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (77, 2023, 0, 'Sepatu Boot', 'Operasional', 'Pengadaan', '1', 'Buah', 0, 'Peralatan Kerja Teknik', 1, 1, 'tapen', '', '2023-08-29 11:10:31', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (78, 2023, 0, 'Stang Gergaji', 'Operasional', 'Pengadaan', '1', 'Buah', 0, 'Peralatan Kerja Teknik', 1, 1, 'tapen', '', '2023-08-29 11:10:59', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (79, 2023, 0, 'Betel', 'Operasional', 'Pengadaan', '1', 'Buah', 0, 'Peralatan Kerja Teknik', 1, 1, 'tapen', '', '2023-08-29 11:11:33', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (80, 2023, 0, 'Kapak', 'Operasional', 'Pengadaan', '1', 'Buah', 0, 'Peralatan Kerja Teknik', 1, 1, 'tapen', '', '2023-08-29 11:11:54', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (81, 2023, 0, 'Cetok', 'Operasional', 'Pengadaan', '1', 'Buah', 0, 'Peralatan Kerja Teknik', 1, 1, 'tapen', '', '2023-08-29 11:12:15', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (82, 2023, 0, 'Tang Segel', 'Operasional', 'Pengadaan', '1', 'Buah', 0, 'Peralatan Kerja Teknik', 1, 1, 'tapen', '', '2023-08-29 11:12:50', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (83, 2023, 0, 'Gigi Snei', 'Operasional', 'Pengadaan', '1', 'Buah', 0, 'Peralatan Kerja Teknik', 1, 1, 'tapen', '', '2023-08-29 11:13:14', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (84, 2023, 0, 'Tas Teknik', 'Operasional', 'Pengadaan', '1', 'Buah', 0, 'Peralatan Kerja Teknik', 1, 1, 'tapen', '', '2023-08-29 11:13:35', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (85, 2023, 0, 'Cutter PE', 'Operasional', 'Pengadaan', '1', 'Buah', 0, 'Peralatan Kerja Teknik', 1, 1, 'tapen', '', '2023-08-29 11:13:56', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (86, 2023, 0, 'Pita & Catridge', 'Operasional', 'Pengadaan', '4', 'Buah', 0, 'ATK', 1, 1, 'prajekan', '', '2023-08-31 13:57:22', '2023-08-31 13:58:30');
INSERT INTO `usulan_barang` VALUES (90, 2025, 0, 'Printer Epson L230', 'Printer yang lama sudah rusak', 'Pengadaan Printer Baru', '1', 'Unit', 1350000, '', 1, 1, 'amdk', 'WhatsApp_Image_2025-06-26_at_14_18_31.jpeg', '2025-08-06 12:41:59', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (91, 2025, 0, 'Sepeda Motor', 'bagian pemasaran yang membutuhkan kendaraan untuk promosi dll', 'Pengadaan Barang baru', '1', 'Unit', 22000000, 'untuk mencari pelanggan baru', 1, 1, 'amdk', '6604820.jpg', '2025-08-06 12:51:57', '2025-08-06 12:58:06');
INSERT INTO `usulan_barang` VALUES (92, 2025, 0, 'Printer Epson L3210', 'padatnya kebutuhan untuk melakukan cetak dokumen', 'Pengadaan Printer baru', '1', 'Unit', 2500000, 'sebagai backup untuk printer di bagian keuangan', 1, 1, 'keuangan', '06000709_2302.jpg', '2025-08-06 13:00:43', '0000-00-00 00:00:00');
INSERT INTO `usulan_barang` VALUES (93, 2025, 0, 'Petekol', 'bertambahnya tenaga teknik', 'pengadaan Barang baru', '2', 'Buah', 50000, 'untuk digunakan oleh tenaga teknik ', 1, 1, 'curahdami', 'Conte_2201.jpg', '2025-08-06 15:25:12', '2025-08-06 15:34:46');

-- ----------------------------
-- Table structure for usulan_investasi
-- ----------------------------
DROP TABLE IF EXISTS `usulan_investasi`;
CREATE TABLE `usulan_investasi`  (
  `id_usulanInvestasi` int NOT NULL AUTO_INCREMENT,
  `tahun_rkap` int NOT NULL,
  `no_perkiraan` int NOT NULL,
  `nama_perkiraan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `latar_belakang` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `solusi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `volume` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `satuan` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `biaya` int NOT NULL,
  `ket` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL DEFAULT 1,
  `status_update` int NOT NULL DEFAULT 1,
  `bagian_upk` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `foto_ket` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_upload` timestamp NOT NULL DEFAULT current_timestamp,
  `tgl_update` datetime NOT NULL,
  PRIMARY KEY (`id_usulanInvestasi`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 25 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of usulan_investasi
-- ----------------------------
INSERT INTO `usulan_investasi` VALUES (1, 2023, 0, 'Conveor ruang Galon', 'Dalam efesiensi biaya dan waktu untuk helper memindahkan barang', 'Pembelian Conveor', '1', 'Unit', 1500000, '', 1, 1, 'amdk', '', '2023-08-24 12:34:23', '0000-00-00 00:00:00');
INSERT INTO `usulan_investasi` VALUES (2, 2023, 0, 'Mesin Galon dan Botol otomatic', 'Saat ini produksi masih manual sehingga ongkos produksi botol mahal ( 3.500/karton ) berdampak pada HPP yg tidak kompetitif', 'Pembelian Mesin Galon dan Botol otomatic', '1', 'Unit', 0, '', 1, 1, 'amdk', '04000324.jpeg', '2023-08-24 12:39:18', '2023-08-24 13:17:53');
INSERT INTO `usulan_investasi` VALUES (3, 2023, 0, 'Gudang barang jadi', 'Saat ini Unit AMDK tidak memiliki Gudang barang jadi', 'Pembuatan gudang barang jadi', '1', 'Ruangan', 0, '', 1, 1, 'amdk', '04000446.jpeg', '2023-08-24 12:41:13', '2023-08-24 13:17:22');
INSERT INTO `usulan_investasi` VALUES (4, 2023, 0, 'Perpompaan', 'Seringnya PLN Padam secara tiba2 SB Penambangan', 'Pengadaan Genset + Alternator 160 KVA lengkap dengan ATS', '1', 'Unit', 0, '', 1, 1, 'bondowoso', '', '2023-08-28 14:04:58', '0000-00-00 00:00:00');
INSERT INTO `usulan_investasi` VALUES (5, 2023, 0, 'Perpipaan', 'Optimalisasi Debit SB Wijaya Kusuma', 'Pengadaan & Pemasangan pipa Transmisi Dia 100mm', '200', 'Meter', 47500, '', 1, 1, 'bondowoso', '', '2023-08-28 14:05:47', '2023-09-05 08:36:33');
INSERT INTO `usulan_investasi` VALUES (6, 2023, 0, 'Perpompaan', 'Menurunnya sumber SB Pancoran', 'Pembuatan sumur bor wilayah selatan', '1', 'Unit', 0, '', 1, 1, 'bondowoso', '', '2023-08-28 14:06:31', '0000-00-00 00:00:00');
INSERT INTO `usulan_investasi` VALUES (7, 2023, 0, 'Perpompaan', 'Menjaga keamanan Instalasi Pompa', 'Pembuatan pagar sumur bor Kotakulon', '165', 'Meter', 0, '11 x 15 m2', 1, 1, 'bondowoso', '', '2023-08-28 14:10:59', '2023-08-28 14:12:56');
INSERT INTO `usulan_investasi` VALUES (8, 2023, 0, 'Perpompaan', 'Menjaga keamanan Instalasi Pompa', 'Pembuatan pagar sumur bor poncogati', '120', 'Meter', 0, '8 x 15 m2', 1, 1, 'bondowoso', '', '2023-08-28 14:11:48', '2023-08-28 14:13:07');
INSERT INTO `usulan_investasi` VALUES (9, 2023, 0, 'Perpompaan', 'Menjaga keamanan Instalasi Pompa', 'Pembuatan pagar sumur bor Nangkaan', '150', 'Meter', 0, '15 x 10 m2', 1, 1, 'bondowoso', '', '2023-08-28 14:12:36', '2023-08-28 14:13:28');
INSERT INTO `usulan_investasi` VALUES (10, 2023, 0, 'Perpipaan', 'Pipa Transmisi terputus akibat pelebaran  jembatan jalan propinsi', 'Penambahan jembatan pipa Dia.100mm', '12', 'Meter', 0, '', 1, 1, 'bondowoso', '', '2023-08-28 14:14:27', '0000-00-00 00:00:00');
INSERT INTO `usulan_investasi` VALUES (11, 2023, 0, 'Perpipaan', 'Pengembangan perumahan Perum vandoland', 'Pengadaan & Pemasangan jaringan perpipaan dia. 50mm', '1', 'Meter', 0, '', 1, 1, 'bondowoso', '', '2023-08-28 14:15:16', '0000-00-00 00:00:00');
INSERT INTO `usulan_investasi` VALUES (12, 2023, 0, 'Perpipaan', 'Pengembangan perumahan Graha pelita', 'Pengadaan dan pemasangan jaringan perpipaan', '1', 'Meter', 0, '', 1, 1, 'bondowoso', '', '2023-08-28 14:16:00', '0000-00-00 00:00:00');
INSERT INTO `usulan_investasi` VALUES (13, 2023, 0, 'Jaringan Pipa Dia. 40 mm', 'Masyarakat sangat kesulitan air', 'Penambahan Jaringan pipa diameter 1,5\" / 40 mm', '200', 'Meter', 0, 'Ada Calon pelanggan yang siap menjadi pelanggan sebanyak', 1, 1, 'sukosari1', '', '2023-08-29 10:00:21', '0000-00-00 00:00:00');
INSERT INTO `usulan_investasi` VALUES (14, 2023, 0, 'NRW non fisik', 'Banyak Water Meter pelanggan yang macet', 'Penggantian WM Macet', '150', 'Buah', 0, '', 1, 1, 'sukosari1', '', '2023-08-29 10:01:12', '0000-00-00 00:00:00');
INSERT INTO `usulan_investasi` VALUES (16, 2023, 0, 'Perpompaan', 'Pemadaman PLN tanpa pemberitahuan', 'Pengadaan GENSET di SB tegal ampel 2', '1', 'Unit', 0, '', 1, 1, 'tegalampel', '', '2023-08-29 10:44:44', '0000-00-00 00:00:00');
INSERT INTO `usulan_investasi` VALUES (17, 2023, 0, 'Perpompaan', 'Menurunnya debit pompa karang anyar dan Tingginya unsur FE di SB locare', 'Pengeboran di daerah locare atas', '1', 'Unit', 0, '', 1, 1, 'tegalampel', '', '2023-08-29 10:45:39', '0000-00-00 00:00:00');
INSERT INTO `usulan_investasi` VALUES (18, 2023, 0, 'Perpipaan', 'Sebagian wilayah Perum MUTIARA belum ada pipa distribusi', 'Pengadaan dan pemasangan pipa Distribusi \r\n Dia. 50mm', '100', 'Meter', 0, '', 1, 1, 'tegalampel', '', '2023-08-29 10:46:23', '0000-00-00 00:00:00');
INSERT INTO `usulan_investasi` VALUES (19, 2023, 0, 'Kusen Kantor', 'Faktor usia pada kayu yang saat ini lapuk dan kropos', 'Perlunya penggantian atau renovasi kusen ruang kasir dan kusen ruang tamu', '5', 'Meter', 0, '1,1 x 2 m\r\n1 x 2,45 m', 1, 1, 'tapen', '', '2023-08-29 11:07:16', '0000-00-00 00:00:00');
INSERT INTO `usulan_investasi` VALUES (20, 2023, 0, 'Kanopi', 'Tidak ada lahan parkir sepeda', 'adanya penambahan kanopi', '32', 'Meter', 0, '5 X 6,30 m', 1, 1, 'tapen', '', '2023-08-29 11:08:08', '0000-00-00 00:00:00');
INSERT INTO `usulan_investasi` VALUES (21, 2023, 0, 'Perpipaan', 'Pelayanan daerah widuri lokasi barat jalan dan timur jalan alirannya kurang', 'Normalisasi pipa jaringan induk Dia. 75 mm', '600', 'Meter', 0, '', 1, 1, 'prajekan', '', '2023-08-31 12:43:46', '0000-00-00 00:00:00');
INSERT INTO `usulan_investasi` VALUES (22, 2023, 0, 'Perpipaan', 'Aliran Gambangan dari jaringan Ø50 sampai SD Gambangan Sekolahan kecil.Karena jaringan Ø½ melayani 11 Pelanggan', 'Normalisasi jaringan dari Ø½ ke Ø40.', '100', 'Meter', 0, 'Ø40mm X 100 m', 1, 1, 'maesan', '', '2023-09-04 09:11:02', '0000-00-00 00:00:00');
INSERT INTO `usulan_investasi` VALUES (24, 2025, 0, 'Jaringan pipa Transmisi dia. 75', 'adanya minat sekitar 20 orang untuk pasang sr baru', 'Pengadaan jaringan pipa baru', '75', 'Meter', 0, 'untuk memenuhi kebutuhan di perum curahdami resident', 1, 1, 'curahdami', '', '2025-08-06 15:45:12', '2025-08-06 15:46:08');

-- ----------------------------
-- Table structure for usulan_pemeliharaan
-- ----------------------------
DROP TABLE IF EXISTS `usulan_pemeliharaan`;
CREATE TABLE `usulan_pemeliharaan`  (
  `id_usulanPemeliharaan` int NOT NULL AUTO_INCREMENT,
  `tahun_rkap` int NOT NULL,
  `no_perkiraan` int NOT NULL,
  `nama_perkiraan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `latar_belakang` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `solusi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `volume` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `satuan` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `biaya` int NOT NULL,
  `ket` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL DEFAULT 1,
  `status_update` int NOT NULL DEFAULT 1,
  `bagian_upk` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `foto_ket` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_upload` timestamp NOT NULL DEFAULT current_timestamp,
  `tgl_update` datetime NOT NULL,
  PRIMARY KEY (`id_usulanPemeliharaan`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 46 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of usulan_pemeliharaan
-- ----------------------------
INSERT INTO `usulan_pemeliharaan` VALUES (1, 2023, 0, 'Lampu led 25 W', 'Kebutuhan reguler maintenance mesin atau untuk produksi galon', 'Pengadaan / pembelian dari kebutuhan tsb', '2', 'Buah', 35500, 'Pemeliharaan Mesin Galon dan Botol', 1, 1, 'amdk', '16000117.jpeg', '2023-08-24 13:48:25', '2023-09-05 08:48:18');
INSERT INTO `usulan_pemeliharaan` VALUES (2, 2023, 0, 'Lampu UV 10W', 'Kebutuhan reguler maintenance mesin atau untuk produksi galon', 'Pengadaan / pembelian dari kebutuhan tsb', '1', 'Unit', 75000, 'Pemeliharaan Mesin Galon dan Botol', 1, 1, 'amdk', '', '2023-08-28 13:52:25', '0000-00-00 00:00:00');
INSERT INTO `usulan_pemeliharaan` VALUES (3, 2023, 0, 'Bak Kontainer besar', 'Kebutuhan reguler maintenance mesin atau untuk produksi galon', 'Pengadaan / pembelian dari kebutuhan tsb', '1', 'Buah', 0, 'Pemeliharaan Mesin Galon dan Botol', 1, 1, 'amdk', '', '2023-08-28 13:53:57', '0000-00-00 00:00:00');
INSERT INTO `usulan_pemeliharaan` VALUES (4, 2023, 0, 'Hot Gun', 'Kebutuhan reguler maintenance mesin atau untuk produksi galon', 'Pengadaan / pembelian dari kebutuhan tsb', '1', 'Buah', 0, 'Pemeliharaan Mesin Galon dan Botol', 1, 1, 'amdk', '', '2023-08-28 13:54:37', '0000-00-00 00:00:00');
INSERT INTO `usulan_pemeliharaan` VALUES (5, 2023, 0, 'Termometer Ruangan', 'Kebutuhan reguler maintenance mesin atau untuk produksi galon', 'Pengadaan / pembelian dari kebutuhan tsb', '1', 'Unit', 0, 'Pemeliharaan Mesin Galon dan Botol', 1, 1, 'amdk', '', '2023-08-28 13:55:09', '0000-00-00 00:00:00');
INSERT INTO `usulan_pemeliharaan` VALUES (6, 2023, 0, 'Termometer Ruangan', 'Kebutuhan reguler maintenance mesin atau atau untuk produksi gelas 220ml', 'Pengadaan / pembelian dari kebutuhan tsb', '1', 'Unit', 0, 'Pemeliharaan Ruang Produksi Gelas 220ml', 1, 1, 'amdk', '', '2023-08-28 13:56:39', '0000-00-00 00:00:00');
INSERT INTO `usulan_pemeliharaan` VALUES (7, 2023, 0, 'Lampu UV 10W', 'Kebutuhan reguler maintenance mesin atau atau untuk produksi gelas 220ml', 'Pengadaan / pembelian dari kebutuhan tsb', '1', 'Unit', 0, 'Pemeliharaan Ruang Produksi Gelas 220ml', 1, 1, 'amdk', '', '2023-08-28 13:57:19', '0000-00-00 00:00:00');
INSERT INTO `usulan_pemeliharaan` VALUES (8, 2023, 0, 'Bak Kontainer', 'Kebutuhan reguler maintenance mesin atau atau untuk produksi gelas 220ml', 'Pengadaan / pembelian dari kebutuhan tsb', '1', 'Buah', 0, 'Pemeliharaan Ruang Produksi Gelas 220ml', 1, 1, 'amdk', '', '2023-08-28 13:58:07', '0000-00-00 00:00:00');
INSERT INTO `usulan_pemeliharaan` VALUES (9, 2023, 0, 'Mesin Package', 'Kebutuhan reguler maintenance mesin atau atau untuk produksi gelas 220ml', 'Pengadaan / pembelian dari kebutuhan tsb', '1', 'Unit', 0, 'Pemeliharaan Ruang Produksi Gelas 220ml', 1, 1, 'amdk', '', '2023-08-28 13:58:37', '0000-00-00 00:00:00');
INSERT INTO `usulan_pemeliharaan` VALUES (10, 2023, 0, 'Kursi pendek pastik', 'Kebutuhan reguler maintenance mesin atau atau untuk produksi gelas 220ml', 'Pengadaan / pembelian dari kebutuhan tsb', '6', 'Buah', 0, 'Pemeliharaan Ruang Produksi Gelas 220ml', 1, 1, 'amdk', '', '2023-08-28 13:59:07', '0000-00-00 00:00:00');
INSERT INTO `usulan_pemeliharaan` VALUES (11, 2023, 0, 'Van belt', 'Perawatan rutin kompresor', 'Pengadaan / pembelian dari kebutuhan tsb', '6', 'Buah', 0, 'Pemeliharaan kompresor', 1, 1, 'amdk', '', '2023-08-28 14:00:02', '0000-00-00 00:00:00');
INSERT INTO `usulan_pemeliharaan` VALUES (12, 2023, 0, 'Oli Mesin', 'Perawatan rutin kompresor', 'Pengadaan / pembelian dari kebutuhan tsb', '3', 'Botol', 0, 'Pemeliharaan kompresor', 1, 1, 'amdk', '', '2023-08-28 14:00:32', '0000-00-00 00:00:00');
INSERT INTO `usulan_pemeliharaan` VALUES (13, 2023, 0, 'Termometer Ruangan', 'Kebutuhan Reguler Lab', 'Pengadaan / pembelian dari kebutuhan tsb', '1', 'Unit', 0, 'Pemeliharaan Lab', 1, 1, 'amdk', '', '2023-08-28 14:01:28', '0000-00-00 00:00:00');
INSERT INTO `usulan_pemeliharaan` VALUES (14, 2023, 0, 'Instalasi Perpompaan', 'Untuk menjaga kebersihan Sumur Bor', 'Kebersihan sumur bor & reservoar 11 unit', '330', 'Meter', 5000, '3 kali setahun', 1, 1, 'bondowoso', '', '2023-08-28 14:19:18', '2023-09-05 08:51:11');
INSERT INTO `usulan_pemeliharaan` VALUES (15, 2023, 0, 'Instalasi perpompaan', 'Kusen & Pintu panel SB 4 Nangkaan rusak', 'Perbaikan Kusen & rumah pintu panel', '1', 'Unit', 5000000, '', 1, 1, 'bondowoso', '', '2023-08-28 14:20:32', '0000-00-00 00:00:00');
INSERT INTO `usulan_pemeliharaan` VALUES (16, 2023, 0, 'Instalasi perpipaan', 'Pemeliharaan Venomatic', 'Pemeliharaan Rutin', '2', 'Unit', 5000000, '1x setahun', 1, 1, 'bondowoso', '', '2023-08-28 14:21:41', '0000-00-00 00:00:00');
INSERT INTO `usulan_pemeliharaan` VALUES (17, 2023, 0, 'Normalisasi WM Pelanggan', 'Water meter pelanggan ada didalam rumah sehingga kesulitan dalam pembacaan meter dan penutupan sementara juga dimungkinkan pelanggan menyambung illegal', 'Pemindahan WM pelanggan ke luar rumah', '20', 'Buah', 0, '', 1, 1, 'sukosari1', '', '2023-08-29 10:09:48', '0000-00-00 00:00:00');
INSERT INTO `usulan_pemeliharaan` VALUES (18, 2023, 0, 'Penngecatan Kantor', 'Cat sudah kusam dan banyak mengelupas', 'Pengecatan Ulang', '1', 'M2', 0, '', 1, 1, 'sukosari1', '', '2023-08-29 10:10:33', '0000-00-00 00:00:00');
INSERT INTO `usulan_pemeliharaan` VALUES (19, 2023, 0, 'BPT', 'BPT 01 - Tanah wulan podasi dan pagar Rusak', 'Perbaikan Pondasi dan dinding kawat pembatas BPT 01 Tanah Wulan.', '1', 'Meter', 0, '', 1, 1, 'maesan', '', '2023-08-29 10:22:34', '0000-00-00 00:00:00');
INSERT INTO `usulan_pemeliharaan` VALUES (20, 2023, 0, 'Perpipaan', 'Sulit mematikan air saat perbaikan pipa induk Ø100 di wilayah Tanah wulan Sampai dengan Gambangan', 'Pemasangan Gate Valve Ø 100, di daerah BPT 01 Tanah Wulan', '1', 'Unit', 0, '', 1, 1, 'maesan', '', '2023-08-29 10:23:40', '0000-00-00 00:00:00');
INSERT INTO `usulan_pemeliharaan` VALUES (21, 2023, 0, 'Perpipaan', 'Pipa Jp Ø150 Gi dan jaringanØ 150, disungai Serean ,masih dalam kondisi darurat melewati tanah kebun milik warga yang sementara memakai pipa Ø100.', 'Perbaikan Jp Ø150 dan pemindahan jaringan Ø 150 yang menuju ke Jp Ø 150. di Sungai Serean.', '80', 'Meter', 0, '', 1, 1, 'maesan', '', '2023-08-29 10:24:21', '0000-00-00 00:00:00');
INSERT INTO `usulan_pemeliharaan` VALUES (22, 2023, 0, 'Gate Valve', 'Gate Valve Ø 100 Tanah wulan Mudah Jatuh / Menutup. Dikarenakan aus dan usia.', 'Penggantian Gate Valve Ø100 di Tanah wulan.', '1', 'Unit', 0, '', 1, 1, 'maesan', '', '2023-08-29 10:25:04', '0000-00-00 00:00:00');
INSERT INTO `usulan_pemeliharaan` VALUES (23, 2023, 0, 'Perpipaan', 'Jp Ø100 Tanah wulan mulai usang. Dikhawatirkan karat dan korosi.', 'Pengecatan Jp Ø100 Tanah Wulan', '6', 'Meter', 0, '', 1, 1, 'maesan', '', '2023-08-29 10:26:02', '0000-00-00 00:00:00');
INSERT INTO `usulan_pemeliharaan` VALUES (24, 2023, 0, 'Perpipaan', 'kurangnya tekanan di wilayah Tanah wulan atas. Saat jam puncak yang melayani 213 sr sampai pujer baru.', 'pemisahan jaringan Ø50 Pujer baru dan tanah wulan untuk dikonek crosing ke pipa induk Ø100', '4', 'Meter', 0, '', 1, 1, 'maesan', '', '2023-08-29 10:27:01', '0000-00-00 00:00:00');
INSERT INTO `usulan_pemeliharaan` VALUES (25, 2023, 0, 'Perpipaan', 'Jp Ø100 Gambangan mulai usang di khawatirkan korosi.', 'Pengecatan Jp Ø100 Gambangan.', '3', 'Meter', 0, '', 1, 1, 'maesan', '', '2023-08-29 10:27:38', '0000-00-00 00:00:00');
INSERT INTO `usulan_pemeliharaan` VALUES (26, 2023, 0, 'Gate Valve', 'Gate Valve Ø100 Gambangan. Sudah Aus Sulit menutup Full', 'Penggantian Gate Valve Ø100 Gambangan.', '1', 'Unit', 0, '', 1, 1, 'maesan', '', '2023-08-29 10:28:52', '0000-00-00 00:00:00');
INSERT INTO `usulan_pemeliharaan` VALUES (27, 2023, 0, 'Perpipaan', 'Pipa Crosing Ø50 dipertigaan Pasar Maesan mulai keropos dan bocor rembes.', 'Perbaikan Crosing pipa Ø100.di pertigaan Pasar Maesan . Jl Jember - Bondowoso.', '6', 'Meter', 0, '', 1, 1, 'maesan', '', '2023-08-29 10:29:30', '0000-00-00 00:00:00');
INSERT INTO `usulan_pemeliharaan` VALUES (28, 2023, 0, 'Perpipaan', 'Perbaikan Crosing pipa GI Gorong- gorong Ø 50 lintang Jl Raya Jember - Bondowoso yang mu;ai keropos serta lokasi perbaikan sulit dan sempit.', 'Pemindahan konek pipa dari timur Jalan Raya Ke pipa Ø100 di barat jalan.', '12', 'Meter', 0, '', 1, 1, 'maesan', '', '2023-08-29 10:30:01', '0000-00-00 00:00:00');
INSERT INTO `usulan_pemeliharaan` VALUES (29, 2023, 0, 'Perpipaan', 'Kurang tekanan saat jam puncak diwilayah PTP. Jaringan Ø25 206m. konek jaringan Ø50. dikarenakan melayani 223 Sr untuk saat ini.', 'Pemisahan Jaringan Ø50 Utara Jembatan. Untuk dikonek ke pipa Ø100 ( Crosing ) secara tersendiri.', '12', 'Meter', 0, '', 1, 1, 'maesan', '', '2023-08-29 10:30:34', '0000-00-00 00:00:00');
INSERT INTO `usulan_pemeliharaan` VALUES (30, 2023, 0, 'Gate Valve', 'Saat ada perbaikan di area Jp Ø100. Jl Jember-Bondowoso ke utara. Mematikan Valve Ø Gambangan. Sehingga 5 Rayon mengalami pemadaman.', 'Menambahkan valve Ø 100 sebelum Jp Ø100. Sehingga saat perbaikan di Jembatan ke utara . Yang padam hanya 2 Rayon.', '1', 'Unit', 0, '', 1, 1, 'maesan', '', '2023-08-29 10:31:31', '0000-00-00 00:00:00');
INSERT INTO `usulan_pemeliharaan` VALUES (31, 2023, 0, 'Perpipaan', 'Pipa Ø50 berada di selokan. Tanah Wulan Utara. Adanya penggeseran proyek selokan.', 'Pemindahan Jaringan Ø 50mm. Ke Pinggir Jalan.', '22', 'Meter', 0, '', 1, 1, 'maesan', '', '2023-08-29 10:31:58', '0000-00-00 00:00:00');
INSERT INTO `usulan_pemeliharaan` VALUES (32, 2023, 0, 'Perpompaan', 'Rimbunnya Rumput dan ilalang diarea rumah pompa', 'Pembersihan 4 area rumah pompa', '1', 'M2', 0, '', 1, 1, 'tegalampel', '', '2023-08-29 10:47:55', '0000-00-00 00:00:00');
INSERT INTO `usulan_pemeliharaan` VALUES (33, 2023, 0, 'Pengecatan', 'Kusamnya Cat di kantor UPK', 'Pengecatan Ulang Kantor', '1', 'Meter', 0, '', 1, 1, 'tegalampel', '', '2023-08-29 10:48:44', '0000-00-00 00:00:00');
INSERT INTO `usulan_pemeliharaan` VALUES (34, 2023, 0, 'MAG Mangli', 'Tergerusnya tanah penompang pipa karena banjir mengakibatkan pipa 150 menggantung di sungai sepanjang  1 km.', 'Melakukan pemasangan penompang pipa Ø 150 yang menggantung sebanyak 80 buah', '80', 'Buah', 0, '', 1, 1, 'tapen', '', '2023-08-29 11:15:09', '0000-00-00 00:00:00');
INSERT INTO `usulan_pemeliharaan` VALUES (35, 2023, 0, 'MAG Mangli', 'Terperangkapnya angin pada pipa.', 'penambahan Air valve Ø 1/2 di JP satu MAG Mangli pada pipa Ø 150 dan penambahan Air valve Ø 1/2  di JP Dekat masjid Taal pada pipa Ø 75', '2', 'Buah', 0, '', 1, 1, 'tapen', '', '2023-08-29 11:16:01', '0000-00-00 00:00:00');
INSERT INTO `usulan_pemeliharaan` VALUES (36, 2023, 0, 'Pengecatan', 'Kondisi cat JP sudah memudar', 'Pengecatan JP gang batas Prakid - Pralor Ø 40', '1', 'Meter', 0, '', 1, 1, 'prajekan', '', '2023-08-31 12:44:56', '0000-00-00 00:00:00');
INSERT INTO `usulan_pemeliharaan` VALUES (37, 2023, 0, 'Pengecatan JP', 'Kondisi cat JP sudah memudar', 'Pengecatan JP Pengairan Ø 100', '1', 'Meter', 0, '', 1, 1, 'prajekan', '', '2023-08-31 12:45:39', '0000-00-00 00:00:00');
INSERT INTO `usulan_pemeliharaan` VALUES (38, 2023, 0, 'Pengecatan JP', 'Kondisi cat JP sudah memudar', 'Pengecatan JP Sumardi Ø 100', '1', 'Meter', 0, '', 1, 1, 'prajekan', '', '2023-08-31 12:47:00', '0000-00-00 00:00:00');
INSERT INTO `usulan_pemeliharaan` VALUES (39, 2023, 0, 'Pengecatan JP', 'Kondisi cat JP sudah memudar', 'Pengecatan JP Masjid Al Arif Ø 100', '1', 'Meter', 0, '', 1, 1, 'prajekan', '', '2023-08-31 12:47:27', '0000-00-00 00:00:00');
INSERT INTO `usulan_pemeliharaan` VALUES (40, 2023, 0, 'Renovasi Bangunan', 'Kondisi rusak lisplangnya rapuh kalau hujan bocor', 'Perbaikan kayu, asbes dan lisplang', '1', 'M2', 0, '', 1, 1, 'prajekan', '', '2023-08-31 12:49:22', '0000-00-00 00:00:00');
INSERT INTO `usulan_pemeliharaan` VALUES (41, 2023, 0, 'Renovasi Bangunan', 'Talang bocor', 'Perbaikan kayu dan talang', '1', 'M2', 0, '', 1, 1, 'prajekan', '', '2023-08-31 12:49:45', '0000-00-00 00:00:00');
INSERT INTO `usulan_pemeliharaan` VALUES (42, 2023, 0, 'Pengecatan Kantor', 'Kondisi warna cat tembok perlu perawatan', 'Pengecatan ulang', '1', 'M2', 0, '', 1, 1, 'prajekan', '', '2023-08-31 12:50:12', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for usulan_teknik
-- ----------------------------
DROP TABLE IF EXISTS `usulan_teknik`;
CREATE TABLE `usulan_teknik`  (
  `id_usulanTeknik` int NOT NULL AUTO_INCREMENT,
  `tahun_rkap` int NOT NULL,
  `usulan_teknik` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL DEFAULT 1,
  `status_update` int NOT NULL DEFAULT 1,
  `bagian_upk` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_upload` timestamp NOT NULL DEFAULT current_timestamp,
  `tgl_update` datetime NOT NULL,
  PRIMARY KEY (`id_usulanTeknik`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 24 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of usulan_teknik
-- ----------------------------
INSERT INTO `usulan_teknik` VALUES (1, 2023, 'Adanya  tenaga tehnisi maintenance mesin yg expert ( dengan pelaksanaan maintenance 2 kali dalam setahun)', 1, 1, 'amdk', '2023-08-24 12:19:59', '0000-00-00 00:00:00');
INSERT INTO `usulan_teknik` VALUES (2, 2023, 'Maintenance mesin 4 line yg saat ini blm bisa operasional karena ada part yg perlu di ganti dan di perbaiki', 1, 1, 'amdk', '2023-08-24 12:20:25', '0000-00-00 00:00:00');
INSERT INTO `usulan_teknik` VALUES (3, 2023, 'Apabila memungkinkan investasi mesin galon dan botol otomatic ( saat ini manual ) untuk efesiensi ongkos produksi', 1, 1, 'amdk', '2023-08-24 12:20:58', '0000-00-00 00:00:00');
INSERT INTO `usulan_teknik` VALUES (4, 2023, 'Pengadaan & Pemasangan genset 160KVA di SB penambangan ,sebagai antisipasi pada saat PLN Padam', 1, 1, 'bondowoso', '2023-08-28 07:59:48', '0000-00-00 00:00:00');
INSERT INTO `usulan_teknik` VALUES (5, 2023, 'Melakukan pencarian kebocoran dimalam hari secara efektif dan berkesinambungan untuk mengetahui adanya kebocoran pipa yang yang sulit dideteksi karena tidak tampak dipermukaan', 1, 1, 'bondowoso', '2023-08-28 08:00:30', '0000-00-00 00:00:00');
INSERT INTO `usulan_teknik` VALUES (6, 2023, 'Penambahan jaringan diluar Existing', 1, 1, 'bondowoso', '2023-08-28 08:00:50', '0000-00-00 00:00:00');
INSERT INTO `usulan_teknik` VALUES (7, 2023, 'Penggantian Water Meter Macet sebanyak 250 buah', 1, 1, 'sukosari1', '2023-08-29 09:56:45', '0000-00-00 00:00:00');
INSERT INTO `usulan_teknik` VALUES (8, 2023, 'Normalisasi jaringan di Sumber gading', 1, 1, 'sukosari1', '2023-08-29 09:57:15', '0000-00-00 00:00:00');
INSERT INTO `usulan_teknik` VALUES (9, 2023, 'Peremajaan dan perbaikan jaringan - jaringan keropos.', 1, 1, 'maesan', '2023-08-29 10:18:44', '0000-00-00 00:00:00');
INSERT INTO `usulan_teknik` VALUES (10, 2023, 'Normalisasi Jaringan.', 1, 1, 'maesan', '2023-08-29 10:18:53', '0000-00-00 00:00:00');
INSERT INTO `usulan_teknik` VALUES (11, 2023, 'Pengangkatan Pompa secara periodik di sb locare', 1, 1, 'tegalampel', '2023-08-29 10:42:24', '0000-00-00 00:00:00');
INSERT INTO `usulan_teknik` VALUES (12, 2023, 'Pengaktifan genset di Sb tegal ampel 2', 1, 1, 'tegalampel', '2023-08-29 10:42:33', '0000-00-00 00:00:00');
INSERT INTO `usulan_teknik` VALUES (13, 2023, 'Mencari kebocoran secara berkesinambungan di malam hari', 1, 1, 'tegalampel', '2023-08-29 10:42:44', '0000-00-00 00:00:00');
INSERT INTO `usulan_teknik` VALUES (14, 2023, 'Penambahan jaringan baru', 1, 1, 'tegalampel', '2023-08-29 10:42:53', '0000-00-00 00:00:00');
INSERT INTO `usulan_teknik` VALUES (15, 2023, 'Penggantian WM macet', 1, 1, 'tegalampel', '2023-08-29 10:43:00', '0000-00-00 00:00:00');
INSERT INTO `usulan_teknik` VALUES (16, 2023, 'Penggantian WM Macet yang efektif', 1, 1, 'tapen', '2023-08-29 11:05:05', '0000-00-00 00:00:00');
INSERT INTO `usulan_teknik` VALUES (17, 2023, 'Melaksanakan tera meter', 1, 1, 'tapen', '2023-08-29 11:05:22', '0000-00-00 00:00:00');
INSERT INTO `usulan_teknik` VALUES (18, 2023, 'Mencari kebocoran', 1, 1, 'tapen', '2023-08-29 11:05:30', '0000-00-00 00:00:00');
INSERT INTO `usulan_teknik` VALUES (19, 2023, 'Mencari kebocoran dan buntu', 1, 1, 'prajekan', '2023-08-31 12:42:02', '0000-00-00 00:00:00');
INSERT INTO `usulan_teknik` VALUES (20, 2023, 'Penggantian water meter macet yang potensi pemakaiannya', 1, 1, 'prajekan', '2023-08-31 12:42:11', '0000-00-00 00:00:00');
INSERT INTO `usulan_teknik` VALUES (21, 2023, 'Melaksanakan tera meter', 1, 1, 'prajekan', '2023-08-31 12:42:25', '0000-00-00 00:00:00');
INSERT INTO `usulan_teknik` VALUES (22, 2023, 'Penambahan SR Baru', 1, 1, 'tlogosari', '2023-09-04 10:24:07', '0000-00-00 00:00:00');
INSERT INTO `usulan_teknik` VALUES (23, 2023, 'Mencari kebocoran', 1, 1, 'tlogosari', '2023-09-04 10:24:24', '0000-00-00 00:00:00');

SET FOREIGN_KEY_CHECKS = 1;
