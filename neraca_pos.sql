-- Master Akun Neraca (menu: Master Akun pada halaman Laporan/Komparasi/Neraca Lajur/
-- Input Neraca Awal/Input Jurnal). Semua akun posisi neraca kini dibaca dari tabel ini
-- oleh Model_posisi_keuangan::getPosList(); bila tabel kosong, model tetap memakai
-- daftar bawaan di kode sehingga laporan tidak pernah kosong.
--
-- Kolom:
--   kode        : kode pos (PK) - TIDAK BISA diubah lewat menu (identitas akun).
--   uraian      : nama akun yang tampil di laporan/lajur/jurnal.
--   grup        : aktiva_lancar | aktiva_pajak | aktiva_tetap | aktiva_lain |
--                 liabilitas_pendek | liabilitas_panjang | ekuitas
--   sign        : 1 = debit, -1 = pembalik (mis. penyisihan/akumulasi).
--   parent_kode : diisi bila akun ini adalah ANAK dari akun lain, maka nilai akun
--                 induk = jumlah anak (read-only di Input Neraca Awal).
--   urutan      : urutan baris (1..60 = urutan bawaan lama).
--   tampil      : 1 = tampil di Laporan/Komparasi/Neraca Lajur, 0 = disembunyikan.
--   aktif       : 0 = dinonaktifkan (hilang dari semua halaman, data lama tetap ada).
--   sumber      : 'sistem' = bawaan, 'tambahan' = ditambahkan lewat menu.
--
-- Catatan:
--   - 42.01/42.02/42.04/42.05/42.06 punya tampil = 0 karena nilainya sudah DILIPAT
--     ke 42.03 (Aktiva Tetap Tak Berwujud); bila ikut ditampil total aset jadi dobel.
--   - Akun 14/61/62 adalah akun TURUNAN (hasil jumlah anak) sehingga tidak ada di
--     tabel ini; anak-anaknya (14.09/14.10, 61.01-61.03, 62.01-62.05) punya parent_kode.
-- Jalankan sekali: mysql -u root rkap < neraca_pos.sql
-- ---------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `neraca_pos` (
  `kode` VARCHAR(20) NOT NULL,
  `uraian` VARCHAR(120) NOT NULL DEFAULT '',
  `grup` VARCHAR(30) NOT NULL DEFAULT 'aktiva_lancar',
  `sign` TINYINT NOT NULL DEFAULT 1,
  `parent_kode` VARCHAR(20) NULL DEFAULT NULL,
  `urutan` INT NOT NULL DEFAULT 0,
  `tampil` TINYINT(1) NOT NULL DEFAULT 1,
  `aktif` TINYINT(1) NOT NULL DEFAULT 1,
  `sumber` VARCHAR(10) NOT NULL DEFAULT 'tambahan',
  `updated_by` VARCHAR(50) NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`kode`),
  KEY `idx_neraca_pos_grup` (`grup`),
  KEY `idx_neraca_pos_parent` (`parent_kode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Isi awal: 60 akun bawaan (identik dengan daftar hardcoded lama, urutan & agregasi sama).
INSERT INTO neraca_pos (kode, uraian, grup, sign, parent_kode, urutan, tampil, aktif, sumber, updated_by) VALUES
('11','Kas dan Bank','aktiva_lancar',1,NULL,1,1,1,'sistem','seed'),
('11.01','Uang Tunai / Dana','aktiva_lancar',1,'11',2,1,1,'sistem','seed'),
('11.01.01','Uang Tunai','aktiva_lancar',1,'11.01',3,1,1,'sistem','seed'),
('11.01.02','Dana Kerja','aktiva_lancar',1,'11.01',4,1,1,'sistem','seed'),
('11.01.03','Dana Pemeliharan','aktiva_lancar',1,'11.01',5,1,1,'sistem','seed'),
('11.01.04','Dana Penagihan','aktiva_lancar',1,'11.01',6,1,1,'sistem','seed'),
('11.01.05','Dana Operasional AMDK','aktiva_lancar',1,'11.01',7,1,1,'sistem','seed'),
('11.02','Rekening Giro','aktiva_lancar',1,'11',8,1,1,'sistem','seed'),
('11.03','Rekening Tabungan','aktiva_lancar',1,'11',9,1,1,'sistem','seed'),
('11.04','Kas Kecil','aktiva_lancar',1,'11',10,1,1,'sistem','seed'),
('12','Deposito','aktiva_lancar',1,NULL,11,1,1,'sistem','seed'),
('12.01','Deposito Rupiah','aktiva_lancar',1,'12',12,1,1,'sistem','seed'),
('13','Piutang Usaha','aktiva_lancar',1,NULL,13,1,1,'sistem','seed'),
('13.06','Penyisihan Piutang Usaha','aktiva_lancar',-1,NULL,14,1,1,'sistem','seed'),
('14.09','Piutang Lain-lain','aktiva_lancar',1,NULL,15,1,1,'sistem','seed'),
('14.10','Penyisihan Piutang Lain-lain','aktiva_lancar',-1,NULL,16,1,1,'sistem','seed'),
('15','Persediaan','aktiva_lancar',1,NULL,17,1,1,'sistem','seed'),
('16','Pembayaran Dimuka','aktiva_lancar',1,NULL,18,1,1,'sistem','seed'),
('25.01.01','Aktiva Pajak Tangguhan','aktiva_pajak',1,NULL,19,1,1,'sistem','seed'),
('31','Nilai Perolehan Aktiva Tetap','aktiva_tetap',1,NULL,20,1,1,'sistem','seed'),
('31.1','Akumulasi Penyusutan Aktiva Tetap','aktiva_tetap',-1,NULL,21,1,1,'sistem','seed'),
('41.01','Aktiva Dalam Penyelesaian','aktiva_lain',1,NULL,22,1,1,'sistem','seed'),
('41.08','Aset DPLK - DAPENMA PAMSI','aktiva_lain',1,NULL,23,1,1,'sistem','seed'),
('42.01','Beban Ditangguhkan','aktiva_lain',1,NULL,24,0,1,'sistem','seed'),
('42.02','Akumulasi Amortisasi Beban Ditangguhkan','aktiva_lain',-1,NULL,25,0,1,'sistem','seed'),
('42.03','Trade Mark','aktiva_lain',1,NULL,26,1,1,'sistem','seed'),
('42.04','Akumulasi Amortisasi Trade Mark','aktiva_lain',-1,NULL,27,0,1,'sistem','seed'),
('42.05','Goodwill','aktiva_lain',1,NULL,28,0,1,'sistem','seed'),
('42.06','Akumulasi Amortisasi Goodwill','aktiva_lain',-1,NULL,29,0,1,'sistem','seed'),
('50.01','Utang Usaha','liabilitas_pendek',1,NULL,30,1,1,'sistem','seed'),
('50.02','Utang Non Usaha','liabilitas_pendek',1,NULL,31,1,1,'sistem','seed'),
('50.03','Biaya Yang Masih Harus Dibayar','liabilitas_pendek',1,NULL,32,1,1,'sistem','seed'),
('50.04','Pendapatan Diterima Dimuka','liabilitas_pendek',1,NULL,33,1,1,'sistem','seed'),
('50.05','Utang Pajak','liabilitas_pendek',1,NULL,34,1,1,'sistem','seed'),
('50.06','Utang Jangka Panjang Jatuh Tempo','liabilitas_pendek',1,NULL,35,1,1,'sistem','seed'),
('50.07','Utang Bunga','liabilitas_pendek',1,NULL,36,1,1,'sistem','seed'),
('50.08','Utang Iuran Pensiun','liabilitas_pendek',1,NULL,37,1,1,'sistem','seed'),
('50.09','Jaminan Masa Pemeliharaan','liabilitas_pendek',1,NULL,38,1,1,'sistem','seed'),
('50.1','Pinjaman Jangka Pendek','liabilitas_pendek',1,'50.90',39,1,1,'sistem','seed'),
('50.9','Kewajiban Jangka Pendek Lainnya','liabilitas_pendek',1,'50.90',40,1,1,'sistem','seed'),
('50.80','Utang Imbalan Jasa Kerja','liabilitas_pendek',1,NULL,41,1,1,'sistem','seed'),
('50.90','Utang Jangka Pendek Lainnya','liabilitas_pendek',1,NULL,42,1,1,'sistem','seed'),
('61.01','Kewajiban Jangka Panjang','liabilitas_panjang',1,NULL,43,1,1,'sistem','seed'),
('61.02','Bunga Masa Tenggang','liabilitas_panjang',1,NULL,44,1,1,'sistem','seed'),
('61.03','Utang Leasing','liabilitas_panjang',1,NULL,45,1,1,'sistem','seed'),
('62.01','Pendapatan Yang Ditangguhkan','liabilitas_panjang',1,NULL,46,1,1,'sistem','seed'),
('62.02','Dana Meter','liabilitas_panjang',1,NULL,47,1,1,'sistem','seed'),
('62.03','Cadangan Dana','liabilitas_panjang',1,NULL,48,1,1,'sistem','seed'),
('62.04','Uang Jaminan','liabilitas_panjang',1,NULL,49,1,1,'sistem','seed'),
('62.05','Rupa Kewajiban Lainnya','liabilitas_panjang',1,NULL,50,1,1,'sistem','seed'),
('70.01','Kekayaan Pemda Yang Dipisahkan','ekuitas',1,NULL,51,1,1,'sistem','seed'),
('70.02','Penyertaan Pemerintah Pusat Belum Ditetapkan Statusnya','ekuitas',1,NULL,52,1,1,'sistem','seed'),
('70.03','Penyertaan Pemerintah Pusat','ekuitas',1,NULL,53,1,1,'sistem','seed'),
('70.04','Modal Hibah','ekuitas',1,NULL,54,1,1,'sistem','seed'),
('70.05','Selisih Penilaian Kembali Iuran Pasca Kerja','ekuitas',1,NULL,55,1,1,'sistem','seed'),
('70.06','Cadangan Umum','ekuitas',1,NULL,56,1,1,'sistem','seed'),
('70.07','Akumulasi Kerugian Tahun Lalu','ekuitas',-1,NULL,57,1,1,'sistem','seed'),
('70.08','Pengukuran Kembali Imbalan Pasca Kerja','ekuitas',1,NULL,58,1,1,'sistem','seed'),
('70.09','Laba/(Rugi) Tahun Berjalan','ekuitas',1,NULL,59,1,1,'sistem','seed')
;
